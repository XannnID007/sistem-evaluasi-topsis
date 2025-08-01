<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\PeriodeEvaluasi;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Filter berdasarkan tahun
        $query = $user->evaluasi()->with('periode');

        if ($request->filled('tahun')) {
            $query->whereHas('periode', function ($q) use ($request) {
                $q->where('tahun', $request->tahun);
            });
        }

        $historyList = $query->orderBy('created_at', 'desc')->paginate(12);

        // Daftar tahun yang tersedia
        $tahunList = $user->evaluasi()
            ->join('periode_evaluasi', 'evaluasi.periode_id', '=', 'periode_evaluasi.id')
            ->distinct()
            ->orderBy('periode_evaluasi.tahun', 'desc')
            ->pluck('periode_evaluasi.tahun');

        // Statistik history
        $totalHistory = $user->evaluasi()->count();
        $trendSkor = $this->calculateTrend($user);
        $konsistensiRanking = $this->calculateConsistency($user);

        return view('pegawai.history.index', compact(
            'historyList',
            'tahunList',
            'totalHistory',
            'trendSkor',
            'konsistensiRanking'
        ));
    }

    private function calculateTrend($user)
    {
        $evaluasiTerakhir = $user->evaluasi()
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        if ($evaluasiTerakhir->count() < 2) {
            return 'stable'; // tidak ada perbandingan
        }

        $skorSekarang = $evaluasiTerakhir->first()->total_skor;
        $skorSebelum = $evaluasiTerakhir->last()->total_skor;

        $selisih = $skorSekarang - $skorSebelum;

        if ($selisih > 5) return 'naik';
        if ($selisih < -5) return 'turun';
        return 'stabil';
    }

    private function calculateConsistency($user)
    {
        $rankings = $user->evaluasi()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('ranking')
            ->toArray();

        if (count($rankings) < 3) {
            return 'insufficient_data';
        }

        // Hitung standar deviasi ranking
        $mean = array_sum($rankings) / count($rankings);
        $variance = array_sum(array_map(function ($x) use ($mean) {
            return pow($x - $mean, 2);
        }, $rankings)) / count($rankings);
        $stdDev = sqrt($variance);

        if ($stdDev <= 2) return 'sangat_konsisten';
        if ($stdDev <= 4) return 'konsisten';
        if ($stdDev <= 6) return 'cukup_konsisten';
        return 'tidak_konsisten';
    }

    public function compareWithPeers(Request $request)
    {
        $user = auth()->user();
        $periodeId = $request->periode_id;

        if (!$periodeId) {
            return redirect()->route('pegawai.history.index')
                ->with('error', 'Silakan pilih periode untuk perbandingan.');
        }

        $userEvaluasi = $user->evaluasi()->where('periode_id', $periodeId)->first();

        if (!$userEvaluasi) {
            return redirect()->route('pegawai.history.index')
                ->with('error', 'Anda belum memiliki evaluasi pada periode tersebut.');
        }

        // Ambil evaluasi pegawai dengan kelas jabatan yang sama
        $peerEvaluations = Evaluasi::with('user')
            ->where('periode_id', $periodeId)
            ->whereHas('user', function ($q) use ($user) {
                $q->where('kelas_jabatan', $user->kelas_jabatan)
                    ->where('id', '!=', $user->id);
            })
            ->orderBy('ranking')
            ->get();

        // Statistik perbandingan
        $avgPeerScore = $peerEvaluations->avg('total_skor');
        $myPosition = $peerEvaluations->where('total_skor', '>', $userEvaluasi->total_skor)->count() + 1;
        $totalPeers = $peerEvaluations->count() + 1; // +1 untuk user sendiri

        $periode = PeriodeEvaluasi::find($periodeId);
        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        return view('pegawai.history.comparison', compact(
            'userEvaluasi',
            'peerEvaluations',
            'avgPeerScore',
            'myPosition',
            'totalPeers',
            'periode',
            'periodeList'
        ));
    }
}
