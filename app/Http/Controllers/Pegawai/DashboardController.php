<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\PeriodeEvaluasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil evaluasi terbaru
        $evaluasiTerbaru = $user->evaluasi()
            ->with('periode')
            ->latest()
            ->first();

        // Statistik pegawai
        $skorTerbaru = $evaluasiTerbaru->total_skor ?? 0;
        $rankingTerbaru = $evaluasiTerbaru->ranking ?? null;
        $rataSkor = $user->evaluasi()->avg('total_skor') ?? 0;
        $totalEvaluasi = $user->evaluasi()->count();

        // History evaluasi (5 terakhir)
        $historyEvaluasi = $user->evaluasi()
            ->with('periode')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Data untuk trend chart (6 bulan terakhir)
        $trendData = $user->evaluasi()
            ->with('periode')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->reverse()
            ->map(function ($evaluasi) {
                return [
                    'period' => $evaluasi->periode->nama,
                    'score' => $evaluasi->total_skor
                ];
            })
            ->values();

        // Periode aktif
        $periodeAktif = PeriodeEvaluasi::where('status', 'aktif')->first();

        return view('pegawai.dashboard', compact(
            'skorTerbaru',
            'rankingTerbaru',
            'rataSkor',
            'totalEvaluasi',
            'evaluasiTerbaru',
            'historyEvaluasi',
            'trendData',
            'periodeAktif'
        ));
    }
}
