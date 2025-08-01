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

        // Langkah 2: Hitung CPI untuk setiap evaluasi menggunakan formula Excel yang BENAR
        foreach ($evaluasiList as $evaluasi) {
            $totalSkor = 0;

            // KRITERIA POSITIF (C1, C2, C3)
            // Formula yang BENAR berdasarkan reverse engineering Excel:

            // C1 - Produktivitas Kerja (Tren Positif)
            // Formula Excel: nilai * (40/3) = nilai * 13.33333
            if ($kriteria->has('C1')) {
                $c1_contribution = $evaluasi->c1_produktivitas * (40 / 3);
                $totalSkor += $c1_contribution;
            }

            // C2 - Tanggung Jawab (Tren Positif) 
            // Formula Excel: nilai * 10
            if ($kriteria->has('C2')) {
                $c2_contribution = $evaluasi->c2_tanggung_jawab * 10;
                $totalSkor += $c2_contribution;
            }

            // C3 - Kehadiran (Tren Positif)
            // Formula Excel: nilai * (20/3) = nilai * 6.66667
            if ($kriteria->has('C3')) {
                $c3_contribution = $evaluasi->c3_kehadiran * (20 / 3);
                $totalSkor += $c3_contribution;
            }

            // KRITERIA NEGATIF (C4, C5)
            // Formula yang BENAR berdasarkan reverse engineering Excel dengan batasan maksimum:

            // C4 - Pelanggaran Disiplin (Tren Negatif)
            // Formula Excel: min(20 / nilai_asli, 10)
            if ($kriteria->has('C4') && $evaluasi->c4_pelanggaran > 0) {
                $c4_contribution = min(20 / $evaluasi->c4_pelanggaran, 10);
                $totalSkor += $c4_contribution;
            }

            // C5 - Terlambat (Tren Negatif)  
            // Formula Excel: min(10 / nilai_asli, 10)
            if ($kriteria->has('C5') && $evaluasi->c5_terlambat > 0) {
                $c5_contribution = min(10 / $evaluasi->c5_terlambat, 10);
                $totalSkor += $c5_contribution;
            }

            // Update total skor
            $evaluasi->update(['total_skor' => round($totalSkor, 5)]);
        }

        // Langkah 3: Hitung ranking berdasarkan total skor (dari tertinggi ke terendah)
        $evaluasiSorted = Evaluasi::where('periode_id', $periodeId)
            ->orderBy('total_skor', 'desc')
            ->get();

        foreach ($evaluasiSorted as $index => $evaluasi) {
            $evaluasi->update(['ranking' => $index + 1]);
        }
    }
}
