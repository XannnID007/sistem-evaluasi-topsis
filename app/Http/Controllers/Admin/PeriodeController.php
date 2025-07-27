<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeEvaluasi;
use App\Models\Evaluasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->withCount('evaluasi')
            ->get();

        return view('admin.periode.index', compact('periodeList'));
    }

    public function create()
    {
        return view('admin.periode.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2020|max:2030',
            'bulan' => 'required|integer|min:1|max:12',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        // Validasi overlap tanggal
        $overlap = PeriodeEvaluasi::where(function ($query) use ($validated) {
            $query->whereBetween('tgl_mulai', [$validated['tgl_mulai'], $validated['tgl_selesai']])
                ->orWhereBetween('tgl_selesai', [$validated['tgl_mulai'], $validated['tgl_selesai']])
                ->orWhere(function ($q) use ($validated) {
                    $q->where('tgl_mulai', '<=', $validated['tgl_mulai'])
                        ->where('tgl_selesai', '>=', $validated['tgl_selesai']);
                });
        })->exists();

        if ($overlap) {
            return back()->withErrors(['tgl_mulai' => 'Periode ini bertabrakan dengan periode yang sudah ada.'])
                ->withInput();
        }

        // Jika status aktif, nonaktifkan periode aktif lainnya
        if ($validated['status'] === 'aktif') {
            PeriodeEvaluasi::where('status', 'aktif')->update(['status' => 'draft']);
        }

        PeriodeEvaluasi::create($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode evaluasi berhasil ditambahkan.');
    }

    public function show(PeriodeEvaluasi $periode)
    {
        $periode->loadCount('evaluasi');

        // Statistik periode
        $evaluasiList = $periode->evaluasi()->with('user')->get();

        $statistik = [
            'total_evaluasi' => $evaluasiList->count(),
            'rata_skor' => $evaluasiList->avg('total_skor'),
            'skor_tertinggi' => $evaluasiList->max('total_skor'),
            'skor_terendah' => $evaluasiList->min('total_skor'),
            'distribusi' => [
                'sangat_baik' => $evaluasiList->where('total_skor', '>', 150)->count(),
                'baik' => $evaluasiList->whereBetween('total_skor', [130, 150])->count(),
                'cukup' => $evaluasiList->whereBetween('total_skor', [110, 130])->count(),
                'kurang' => $evaluasiList->where('total_skor', '<', 110)->count(),
            ]
        ];

        $topPerformers = $evaluasiList->sortBy('ranking')->take(5);

        return view('admin.periode.show', compact('periode', 'statistik', 'topPerformers'));
    }

    public function edit(PeriodeEvaluasi $periode)
    {
        return view('admin.periode.edit', compact('periode'));
    }

    public function update(Request $request, PeriodeEvaluasi $periode)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2020|max:2030',
            'bulan' => 'required|integer|min:1|max:12',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        // Validasi overlap tanggal (exclude periode yang sedang diedit)
        $overlap = PeriodeEvaluasi::where('id', '!=', $periode->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('tgl_mulai', [$validated['tgl_mulai'], $validated['tgl_selesai']])
                    ->orWhereBetween('tgl_selesai', [$validated['tgl_mulai'], $validated['tgl_selesai']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('tgl_mulai', '<=', $validated['tgl_mulai'])
                            ->where('tgl_selesai', '>=', $validated['tgl_selesai']);
                    });
            })->exists();

        if ($overlap) {
            return back()->withErrors(['tgl_mulai' => 'Periode ini bertabrakan dengan periode yang sudah ada.'])
                ->withInput();
        }

        // Jika status diubah ke aktif, nonaktifkan periode aktif lainnya
        if ($validated['status'] === 'aktif' && $periode->status !== 'aktif') {
            PeriodeEvaluasi::where('status', 'aktif')
                ->where('id', '!=', $periode->id)
                ->update(['status' => 'draft']);
        }

        $periode->update($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode evaluasi berhasil diperbarui.');
    }

    public function destroy(PeriodeEvaluasi $periode)
    {
        // Cek apakah periode memiliki evaluasi
        if ($periode->evaluasi()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus periode yang sudah memiliki evaluasi.');
        }

        $periode->delete();

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode evaluasi berhasil dihapus.');
    }

    public function activate(PeriodeEvaluasi $periode)
    {
        // Nonaktifkan periode aktif lainnya
        PeriodeEvaluasi::where('status', 'aktif')->update(['status' => 'draft']);

        // Aktifkan periode ini
        $periode->update(['status' => 'aktif']);

        return back()->with('success', "Periode {$periode->nama} berhasil diaktifkan.");
    }

    public function deactivate(PeriodeEvaluasi $periode)
    {
        $periode->update(['status' => 'draft']);

        return back()->with('success', "Periode {$periode->nama} berhasil dinonaktifkan.");
    }

    public function finish(PeriodeEvaluasi $periode)
    {
        // Cek apakah ada evaluasi di periode ini
        if (!$periode->evaluasi()->exists()) {
            return back()->with('error', 'Tidak dapat menyelesaikan periode yang belum memiliki evaluasi.');
        }

        $periode->update(['status' => 'selesai']);

        return back()->with('success', "Periode {$periode->nama} berhasil diselesaikan.");
    }

    public function duplicate(PeriodeEvaluasi $periode)
    {
        // Buat periode baru berdasarkan periode yang ada
        $bulanBaru = $periode->bulan + 1;
        $tahunBaru = $periode->tahun;

        if ($bulanBaru > 12) {
            $bulanBaru = 1;
            $tahunBaru++;
        }

        $bulanNama = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $newPeriode = [
            'nama' => "Evaluasi Kinerja {$bulanNama[$bulanBaru]} {$tahunBaru}",
            'tahun' => $tahunBaru,
            'bulan' => $bulanBaru,
            'tgl_mulai' => date('Y-m-01', strtotime("{$tahunBaru}-{$bulanBaru}-01")),
            'tgl_selesai' => date('Y-m-t', strtotime("{$tahunBaru}-{$bulanBaru}-01")),
            'status' => 'draft',
        ];

        // Cek apakah periode sudah ada
        $exists = PeriodeEvaluasi::where('tahun', $tahunBaru)
            ->where('bulan', $bulanBaru)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Periode untuk bulan tersebut sudah ada.');
        }

        PeriodeEvaluasi::create($newPeriode);

        return redirect()->route('admin.periode.index')
            ->with('success', "Periode {$bulanNama[$bulanBaru]} {$tahunBaru} berhasil dibuat.");
    }
}
