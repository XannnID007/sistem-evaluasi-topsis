<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Evaluasi;
use App\Models\PeriodeEvaluasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalPegawai = User::where('role', 'pegawai')->where('status', 'aktif')->count();

        // Periode aktif
        $periodeAktif = PeriodeEvaluasi::where('status', 'aktif')->first();

        // Evaluasi pada periode aktif
        $evaluasiSelesai = $periodeAktif ?
            Evaluasi::where('periode_id', $periodeAktif->id)->count() : 0;

        $rataSkor = $periodeAktif ?
            Evaluasi::where('periode_id', $periodeAktif->id)->avg('total_skor') : 0;

        // Top 5 pegawai terbaik (periode aktif)
        $topPegawai = $periodeAktif ?
            Evaluasi::with('user')
            ->where('periode_id', $periodeAktif->id)
            ->orderBy('ranking')
            ->limit(5)
            ->get() : collect();

        // Data untuk chart distribusi kinerja
        $distributionData = $this->getPerformanceDistribution($periodeAktif);

        // Aktivitas terbaru
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact(
            'totalPegawai',
            'evaluasiSelesai',
            'rataSkor',
            'periodeAktif',
            'topPegawai',
            'distributionData',
            'recentActivities'
        ));
    }

    private function getPerformanceDistribution($periode)
    {
        if (!$periode) {
            return [
                'sangat_baik' => 0,
                'baik' => 0,
                'cukup' => 0,
                'kurang' => 0
            ];
        }

        $evaluasi = Evaluasi::where('periode_id', $periode->id)->get();

        return [
            'sangat_baik' => $evaluasi->where('total_skor', '>', 150)->count(),
            'baik' => $evaluasi->whereBetween('total_skor', [130, 150])->count(),
            'cukup' => $evaluasi->whereBetween('total_skor', [110, 130])->count(),
            'kurang' => $evaluasi->where('total_skor', '<', 110)->count(),
        ];
    }

    private function getRecentActivities()
    {
        // Gabungkan berbagai aktivitas terbaru
        $activities = collect();

        // Evaluasi terbaru
        $recentEvaluations = Evaluasi::with(['user', 'periode', 'creator'])
            ->latest()
            ->take(3)
            ->get();

        foreach ($recentEvaluations as $eval) {
            $activities->push([
                'type' => 'evaluasi_created',
                'message' => "Evaluasi kinerja untuk {$eval->user->nama} pada {$eval->periode->nama} telah dibuat",
                'time' => $eval->created_at,
                'icon' => 'success'
            ]);
        }

        // Pegawai baru
        $newEmployees = User::where('role', 'pegawai')
            ->latest()
            ->take(2)
            ->get();

        foreach ($newEmployees as $emp) {
            $activities->push([
                'type' => 'pegawai_created',
                'message' => "Pegawai baru {$emp->nama} berhasil ditambahkan",
                'time' => $emp->created_at,
                'icon' => 'primary'
            ]);
        }

        // Periode evaluasi baru
        $newPeriods = PeriodeEvaluasi::latest()->take(2)->get();

        foreach ($newPeriods as $period) {
            $activities->push([
                'type' => 'periode_created',
                'message' => "Periode evaluasi {$period->nama} telah dibuat",
                'time' => $period->created_at,
                'icon' => 'warning'
            ]);
        }

        return $activities->sortByDesc('time')->take(6)->values();
    }
}
