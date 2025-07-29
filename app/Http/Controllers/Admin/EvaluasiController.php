<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Evaluasi;
use App\Models\PeriodeEvaluasi;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Evaluasi::with(['user', 'periode', 'creator']);

        // Filter berdasarkan periode
        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        } else {
            // Default ke periode aktif
            $periodeAktif = PeriodeEvaluasi::where('status', 'aktif')->first();
            if ($periodeAktif) {
                $query->where('periode_id', $periodeAktif->id);
            }
        }

        // Filter berdasarkan pegawai
        if ($request->filled('pegawai_id')) {
            $query->where('user_id', $request->pegawai_id);
        }

        $evaluasi = $query->orderBy('created_at', 'desc')->paginate(15);
        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $pegawaiList = User::where('role', 'pegawai')->where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.evaluasi.index', compact('evaluasi', 'periodeList', 'pegawaiList'));
    }

    public function create()
    {
        $pegawaiList = User::where('role', 'pegawai')->where('status', 'aktif')->orderBy('nama')->get();
        $periodeList = PeriodeEvaluasi::where('status', 'aktif')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $kriteria = Kriteria::where('status', 'aktif')->orderBy('kode')->get();

        return view('admin.evaluasi.create', compact('pegawaiList', 'periodeList', 'kriteria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode_id' => 'required|exists:periode_evaluasi,id',
            'c1_produktivitas' => 'required|numeric|min:0|max:100',
            'c2_tanggung_jawab' => 'required|numeric|min:0|max:100',
            'c3_kehadiran' => 'required|numeric|min:0|max:100',
            'c4_pelanggaran' => 'required|numeric|min:0',
            'c5_terlambat' => 'required|numeric|min:0',
        ]);

        // Cek apakah evaluasi untuk pegawai dan periode ini sudah ada
        $existingEvaluasi = Evaluasi::where('user_id', $validated['user_id'])
            ->where('periode_id', $validated['periode_id'])
            ->first();

        if ($existingEvaluasi) {
            return back()->withErrors(['user_id' => 'Evaluasi untuk pegawai ini pada periode tersebut sudah ada.'])
                ->withInput();
        }

        $validated['created_by'] = auth()->id();

        // Buat evaluasi baru
        $evaluasi = Evaluasi::create($validated);

        // Hitung CPI dan ranking
        $this->calculateCPIAndRanking($evaluasi->periode_id);

        return redirect()->route('admin.evaluasi.index')
            ->with('success', 'Evaluasi berhasil ditambahkan dan skor CPI telah dihitung.');
    }

    public function edit(Evaluasi $evaluasi)
    {
        $pegawaiList = User::where('role', 'pegawai')->where('status', 'aktif')->orderBy('nama')->get();
        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $kriteria = Kriteria::where('status', 'aktif')->orderBy('kode')->get();

        return view('admin.evaluasi.edit', compact('evaluasi', 'pegawaiList', 'periodeList', 'kriteria'));
    }

    public function update(Request $request, Evaluasi $evaluasi)
    {
        $validated = $request->validate([
            'c1_produktivitas' => 'required|numeric|min:0|max:100',
            'c2_tanggung_jawab' => 'required|numeric|min:0|max:100',
            'c3_kehadiran' => 'required|numeric|min:0|max:100',
            'c4_pelanggaran' => 'required|numeric|min:0',
            'c5_terlambat' => 'required|numeric|min:0',
        ]);

        // Update evaluasi
        $evaluasi->update($validated);

        // Hitung ulang CPI dan ranking untuk periode ini
        $this->calculateCPIAndRanking($evaluasi->periode_id);

        return redirect()->route('admin.evaluasi.index')
            ->with('success', 'Evaluasi berhasil diperbarui dan skor CPI telah dihitung ulang.');
    }

    public function destroy(Evaluasi $evaluasi)
    {
        $periodeId = $evaluasi->periode_id;
        $evaluasi->delete();

        // Hitung ulang ranking setelah penghapusan
        $this->calculateCPIAndRanking($periodeId);

        return redirect()->route('admin.evaluasi.index')
            ->with('success', 'Evaluasi berhasil dihapus dan ranking telah diperbarui.');
    }

    public function bulkCreate()
    {
        $periodeAktif = PeriodeEvaluasi::where('status', 'aktif')->first();

        if (!$periodeAktif) {
            return redirect()->route('admin.evaluasi.index')
                ->with('error', 'Tidak ada periode evaluasi yang aktif.');
        }

        // Ambil pegawai yang belum dievaluasi pada periode aktif
        $pegawaiTersedia = User::where('role', 'pegawai')
            ->where('status', 'aktif')
            ->whereNotIn('id', function ($query) use ($periodeAktif) {
                $query->select('user_id')
                    ->from('evaluasi')
                    ->where('periode_id', $periodeAktif->id);
            })
            ->orderBy('nama')
            ->get();

        $kriteria = Kriteria::where('status', 'aktif')->orderBy('kode')->get();

        return view('admin.evaluasi.bulk-create', compact('pegawaiTersedia', 'periodeAktif', 'kriteria'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_evaluasi,id',
            'evaluasi' => 'required|array|min:1',
            'evaluasi.*.user_id' => 'required|exists:users,id',
            'evaluasi.*.c1_produktivitas' => 'required|numeric|min:0|max:100',
            'evaluasi.*.c2_tanggung_jawab' => 'required|numeric|min:0|max:100',
            'evaluasi.*.c3_kehadiran' => 'required|numeric|min:0|max:100',
            'evaluasi.*.c4_pelanggaran' => 'required|numeric|min:0',
            'evaluasi.*.c5_terlambat' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['evaluasi'] as $data) {
                // Cek duplikasi
                $exists = Evaluasi::where('user_id', $data['user_id'])
                    ->where('periode_id', $validated['periode_id'])
                    ->exists();

                if (!$exists) {
                    Evaluasi::create([
                        'user_id' => $data['user_id'],
                        'periode_id' => $validated['periode_id'],
                        'c1_produktivitas' => $data['c1_produktivitas'],
                        'c2_tanggung_jawab' => $data['c2_tanggung_jawab'],
                        'c3_kehadiran' => $data['c3_kehadiran'],
                        'c4_pelanggaran' => $data['c4_pelanggaran'],
                        'c5_terlambat' => $data['c5_terlambat'],
                        'created_by' => auth()->id(),
                    ]);
                }
            }

            // Hitung CPI dan ranking setelah semua data tersimpan
            $this->calculateCPIAndRanking($validated['periode_id']);
        });

        return redirect()->route('admin.evaluasi.index')
            ->with('success', 'Evaluasi batch berhasil disimpan dan skor CPI telah dihitung.');
    }

    private function calculateCPIAndRanking($periodeId)
    {
        // Ambil semua evaluasi pada periode tersebut
        $evaluasiList = Evaluasi::where('periode_id', $periodeId)->get();

        if ($evaluasiList->isEmpty()) {
            return;
        }

        // Ambil kriteria dan bobot
        $kriteria = Kriteria::where('status', 'aktif')->get()->keyBy('kode');

        // Langkah 1: Konversi nilai text ke numerik berdasarkan mapping Excel
        $nilaiMapping = [
            // C1 - Produktivitas Kerja
            'Sangat produktivitas, selalu melebihi target' => 5,
            'Produktif, sering memenuhi target kerja' => 4,
            'Cukup Produktif, kadang memenuhi target' => 3,
            'Kurang Produktif, sering tidak memenuhi target' => 2,
            'Tidak Produktif, hampir selalu tidak memenuhi target' => 1,

            // C2 - Tanggung Jawab
            'Sangat bertanggung jawab, tidak pernah lalai' => 5,
            'Bertanggung jawab, sangat jarang lalai' => 4,
            'Cukup bertanggung jawab, kadang lalai' => 3,
            'Kurang bertanggung jawab, sering lalai' => 2,
            'Tidak bertanggung jawab, selalu lalai' => 1,

            // C3 - Kehadiran
            'Hadir 100% (tidak pernah absen)' => 5,
            'Absen 1-2 kali' => 4,
            'Absen 3-4 kali' => 3,
            'Absen 5-6 kali' => 2,
            'Absen lebih dari 6 kali' => 1,

            // C4 - Pelanggaran Disiplin (nilai negatif)
            'Tidak pernah melanggar' => 5, // Semakin tinggi nilai semakin baik
            '1 kali pelanggaran ringan' => 4,
            '2-3 kali pelanggaran ringan' => 3,
            '1 kali pelanggaran sedang' => 2,
            'Lebih dari 1 kali pelanggaran berat' => 1,

            // C5 - Terlambat (nilai negatif)
            'Tidak pernah terlambat' => 5, // Semakin tinggi nilai semakin baik
            '1-2 kali terlambat' => 4,
            '3-4 kali terlambat' => 3,
            '5-6 kali terlambat' => 2,
            'Lebih dari 6 kali terlambat' => 1
        ];

        // Konversi data evaluasi ke nilai numerik
        foreach ($evaluasiList as $evaluasi) {
            // Untuk sistem yang menggunakan nilai numerik langsung, tidak perlu konversi
            // Namun nilai harus dalam skala 1-5 untuk konsistensi dengan Excel

            // Pastikan nilai dalam range yang benar
            $evaluasi->c1_produktivitas = max(1, min(5, $evaluasi->c1_produktivitas));
            $evaluasi->c2_tanggung_jawab = max(1, min(5, $evaluasi->c2_tanggung_jawab));
            $evaluasi->c3_kehadiran = max(1, min(5, $evaluasi->c3_kehadiran));
            $evaluasi->c4_pelanggaran = max(1, min(5, $evaluasi->c4_pelanggaran));
            $evaluasi->c5_terlambat = max(1, min(5, $evaluasi->c5_terlambat));
        }

        // Langkah 2: Hitung nilai minimum untuk transformasi (sesuai metode Excel)
        $minValues = [
            'c1' => $evaluasiList->min('c1_produktivitas'), // Untuk tren positif: gunakan min
            'c2' => $evaluasiList->min('c2_tanggung_jawab'), // Untuk tren positif: gunakan min
            'c3' => $evaluasiList->min('c3_kehadiran'),     // Untuk tren positif: gunakan min
            'c4' => $evaluasiList->min('c4_pelanggaran'),   // Untuk tren negatif: gunakan min dari nilai yang sudah dinormalisasi
            'c5' => $evaluasiList->min('c5_terlambat'),     // Untuk tren negatif: gunakan min dari nilai yang sudah dinormalisasi
        ];

        // Langkah 3: Hitung CPI untuk setiap evaluasi (sesuai formula Excel)
        foreach ($evaluasiList as $evaluasi) {
            $totalSkor = 0;

            // C1 - Produktivitas Kerja (Tren Positif)
            if ($kriteria->has('C1') && $minValues['c1'] > 0) {
                // Formula Excel: (Nilai Alternatif / Nilai Min) * 100
                $normalized_c1 = ($evaluasi->c1_produktivitas / $minValues['c1']) * 100;
                // Kalikan dengan bobot kriteria
                $totalSkor += $normalized_c1 * $kriteria['C1']->bobot;
            }

            // C2 - Tanggung Jawab (Tren Positif)
            if ($kriteria->has('C2') && $minValues['c2'] > 0) {
                $normalized_c2 = ($evaluasi->c2_tanggung_jawab / $minValues['c2']) * 100;
                $totalSkor += $normalized_c2 * $kriteria['C2']->bobot;
            }

            // C3 - Kehadiran (Tren Positif)
            if ($kriteria->has('C3') && $minValues['c3'] > 0) {
                $normalized_c3 = ($evaluasi->c3_kehadiran / $minValues['c3']) * 100;
                $totalSkor += $normalized_c3 * $kriteria['C3']->bobot;
            }

            // C4 - Pelanggaran Disiplin (Tren Negatif)
            if ($kriteria->has('C4') && $minValues['c4'] > 0) {
                // Untuk tren negatif: (Nilai Min / Nilai Alternatif) * 100
                $normalized_c4 = ($minValues['c4'] / $evaluasi->c4_pelanggaran) * 100;
                $totalSkor += $normalized_c4 * $kriteria['C4']->bobot;
            }

            // C5 - Terlambat (Tren Negatif)
            if ($kriteria->has('C5') && $minValues['c5'] > 0) {
                $normalized_c5 = ($minValues['c5'] / $evaluasi->c5_terlambat) * 100;
                $totalSkor += $normalized_c5 * $kriteria['C5']->bobot;
            }

            // Update total skor
            $evaluasi->update(['total_skor' => round($totalSkor, 5)]);
        }

        // Langkah 4: Hitung ranking berdasarkan total skor (dari tertinggi ke terendah)
        $evaluasiSorted = Evaluasi::where('periode_id', $periodeId)
            ->orderBy('total_skor', 'desc')
            ->get();

        foreach ($evaluasiSorted as $index => $evaluasi) {
            $evaluasi->update(['ranking' => $index + 1]);
        }
    }
}
