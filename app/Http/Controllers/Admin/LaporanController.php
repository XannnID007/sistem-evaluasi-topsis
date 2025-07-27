<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\PeriodeEvaluasi;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        // Laporan yang sudah pernah di-generate bisa disimpan di database
        // Untuk sekarang kita generate on-demand

        return view('admin.laporan.index', compact('periodeList'));
    }

    public function generate(Request $request)
    {
        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        return view('admin.laporan.generate', compact('periodeList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_evaluasi,id',
            'jenis_laporan' => 'required|in:ranking,statistik,lengkap',
            'format' => 'required|in:pdf,excel',
            'include_chart' => 'boolean',
        ]);

        $periode = PeriodeEvaluasi::find($validated['periode_id']);
        $jenisLaporan = $validated['jenis_laporan'];
        $format = $validated['format'];

        // Generate laporan berdasarkan jenis
        switch ($jenisLaporan) {
            case 'ranking':
                return $this->generateRankingReport($periode, $format, $request->boolean('include_chart'));
            case 'statistik':
                return $this->generateStatistikReport($periode, $format, $request->boolean('include_chart'));
            case 'lengkap':
                return $this->generateLengkapReport($periode, $format, $request->boolean('include_chart'));
            default:
                return back()->with('error', 'Jenis laporan tidak valid.');
        }
    }

    private function generateRankingReport($periode, $format, $includeChart = false)
    {
        $evaluasiList = Evaluasi::with('user')
            ->where('periode_id', $periode->id)
            ->orderBy('ranking')
            ->get();

        $data = [
            'periode' => $periode,
            'evaluasi_list' => $evaluasiList,
            'include_chart' => $includeChart,
            'generated_at' => now(),
            'generated_by' => auth()->user()->nama
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.templates.ranking-pdf', $data);
            return $pdf->download("Laporan_Ranking_{$periode->nama}.pdf");
        } else {
            // Excel export implementation
            return $this->exportToExcel($data, 'ranking');
        }
    }

    private function generateStatistikReport($periode, $format, $includeChart = false)
    {
        $evaluasiList = Evaluasi::where('periode_id', $periode->id)->get();

        $statistik = [
            'total_pegawai' => $evaluasiList->count(),
            'rata_skor' => $evaluasiList->avg('total_skor'),
            'skor_tertinggi' => $evaluasiList->max('total_skor'),
            'skor_terendah' => $evaluasiList->min('total_skor'),
            'distribusi' => [
                'sangat_baik' => $evaluasiList->where('total_skor', '>', 150)->count(),
                'baik' => $evaluasiList->whereBetween('total_skor', [130, 150])->count(),
                'cukup' => $evaluasiList->whereBetween('total_skor', [110, 130])->count(),
                'kurang' => $evaluasiList->where('total_skor', '<', 110)->count(),
            ],
            'rata_kriteria' => [
                'c1' => $evaluasiList->avg('c1_produktivitas'),
                'c2' => $evaluasiList->avg('c2_tanggung_jawab'),
                'c3' => $evaluasiList->avg('c3_kehadiran'),
                'c4' => $evaluasiList->avg('c4_pelanggaran'),
                'c5' => $evaluasiList->avg('c5_terlambat'),
            ]
        ];

        $data = [
            'periode' => $periode,
            'statistik' => $statistik,
            'include_chart' => $includeChart,
            'generated_at' => now(),
            'generated_by' => auth()->user()->nama
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.templates.statistik-pdf', $data);
            return $pdf->download("Laporan_Statistik_{$periode->nama}.pdf");
        } else {
            return $this->exportToExcel($data, 'statistik');
        }
    }

    private function generateLengkapReport($periode, $format, $includeChart = false)
    {
        $evaluasiList = Evaluasi::with('user')
            ->where('periode_id', $periode->id)
            ->orderBy('ranking')
            ->get();

        // Kombinasi ranking + statistik
        $statistik = [
            'total_pegawai' => $evaluasiList->count(),
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

        $data = [
            'periode' => $periode,
            'evaluasi_list' => $evaluasiList,
            'statistik' => $statistik,
            'include_chart' => $includeChart,
            'generated_at' => now(),
            'generated_by' => auth()->user()->nama
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.templates.lengkap-pdf', $data);
            return $pdf->download("Laporan_Lengkap_{$periode->nama}.pdf");
        } else {
            return $this->exportToExcel($data, 'lengkap');
        }
    }

    private function exportToExcel($data, $type)
    {
        // Implementation for Excel export
        // Using Laravel Excel package
        return response()->json([
            'message' => 'Excel export will be implemented with Laravel Excel package',
            'type' => $type,
            'data_count' => count($data)
        ]);
    }

    public function show($id)
    {
        // Show generated report (if storing reports in database)
        return view('admin.laporan.show');
    }

    public function download($id)
    {
        // Download previously generated report
        return response()->json(['message' => 'Download previous report functionality']);
    }
}
