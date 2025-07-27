<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\PeriodeEvaluasi;
use App\Models\User;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index(Request $request)
    {
        // Default ke periode aktif
        $periodeAktif = PeriodeEvaluasi::where('status', 'aktif')->first();
        $selectedPeriode = $request->filled('periode_id')
            ? PeriodeEvaluasi::find($request->periode_id)
            : $periodeAktif;

        $query = Evaluasi::with(['user', 'periode']);

        if ($selectedPeriode) {
            $query->where('periode_id', $selectedPeriode->id);
        }

        // Filter berdasarkan kelas jabatan
        if ($request->filled('kelas_jabatan')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('kelas_jabatan', $request->kelas_jabatan);
            });
        }

        // Filter berdasarkan ranking
        if ($request->filled('ranking_filter')) {
            switch ($request->ranking_filter) {
                case 'top_10':
                    $query->where('ranking', '<=', 10);
                    break;
                case 'top_5':
                    $query->where('ranking', '<=', 5);
                    break;
                case 'bottom_5':
                    $query->orderBy('ranking', 'desc')->limit(5);
                    break;
            }
        }

        $evaluasiList = $query->orderBy('ranking', 'asc')->paginate(15);

        // Statistik
        $totalEvaluasi = $selectedPeriode ?
            Evaluasi::where('periode_id', $selectedPeriode->id)->count() : 0;

        $rataRataSkor = $selectedPeriode ?
            Evaluasi::where('periode_id', $selectedPeriode->id)->avg('total_skor') : 0;

        $skorTertinggi = $selectedPeriode ?
            Evaluasi::where('periode_id', $selectedPeriode->id)->max('total_skor') : 0;

        $skorTerendah = $selectedPeriode ?
            Evaluasi::where('periode_id', $selectedPeriode->id)->min('total_skor') : 0;

        // Data untuk chart
        $chartData = $this->getChartData($selectedPeriode);

        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        return view('admin.hasil.index', compact(
            'evaluasiList',
            'selectedPeriode',
            'periodeList',
            'totalEvaluasi',
            'rataRataSkor',
            'skorTertinggi',
            'skorTerendah',
            'chartData'
        ));
    }

    public function show(Evaluasi $evaluasi)
    {
        $evaluasi->load(['user', 'periode', 'creator']);

        // Ambil ranking pegawai ini di periode lain
        $historyRanking = Evaluasi::where('user_id', $evaluasi->user_id)
            ->where('id', '!=', $evaluasi->id)
            ->with('periode')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Bandingkan dengan rata-rata periode
        $avgPeriode = Evaluasi::where('periode_id', $evaluasi->periode_id)
            ->selectRaw('
                                 AVG(c1_produktivitas) as avg_c1,
                                 AVG(c2_tanggung_jawab) as avg_c2,
                                 AVG(c3_kehadiran) as avg_c3,
                                 AVG(c4_pelanggaran) as avg_c4,
                                 AVG(c5_terlambat) as avg_c5,
                                 AVG(total_skor) as avg_total
                             ')
            ->first();

        return view('admin.hasil.show', compact('evaluasi', 'historyRanking', 'avgPeriode'));
    }

    public function export(Request $request)
    {
        $periodeId = $request->periode_id;
        $format = $request->format ?? 'excel'; // excel atau pdf

        $evaluasiList = Evaluasi::with(['user', 'periode'])
            ->when($periodeId, function ($query) use ($periodeId) {
                return $query->where('periode_id', $periodeId);
            })
            ->orderBy('ranking', 'asc')
            ->get();

        if ($format === 'pdf') {
            return $this->exportPDF($evaluasiList, $periodeId);
        } else {
            return $this->exportExcel($evaluasiList, $periodeId);
        }
    }

    public function comparison(Request $request)
    {
        $periode1Id = $request->periode1_id;
        $periode2Id = $request->periode2_id;

        if (!$periode1Id || !$periode2Id) {
            return redirect()->route('admin.hasil.index')
                ->with('error', 'Silakan pilih 2 periode untuk perbandingan.');
        }

        $periode1 = PeriodeEvaluasi::find($periode1Id);
        $periode2 = PeriodeEvaluasi::find($periode2Id);

        $evaluasi1 = Evaluasi::with('user')->where('periode_id', $periode1Id)->get()->keyBy('user_id');
        $evaluasi2 = Evaluasi::with('user')->where('periode_id', $periode2Id)->get()->keyBy('user_id');

        // Pegawai yang ada di kedua periode
        $commonPegawai = $evaluasi1->keys()->intersect($evaluasi2->keys());

        $comparisonData = [];
        foreach ($commonPegawai as $userId) {
            $eval1 = $evaluasi1[$userId];
            $eval2 = $evaluasi2[$userId];

            $comparisonData[] = [
                'user' => $eval1->user,
                'periode1' => $eval1,
                'periode2' => $eval2,
                'skor_diff' => $eval2->total_skor - $eval1->total_skor,
                'ranking_diff' => $eval1->ranking - $eval2->ranking, // Positif jika naik
            ];
        }

        // Sort by improvement
        usort($comparisonData, function ($a, $b) {
            return $b['skor_diff'] <=> $a['skor_diff'];
        });

        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        return view('admin.hasil.comparison', compact(
            'comparisonData',
            'periode1',
            'periode2',
            'periodeList'
        ));
    }

    private function getChartData($periode)
    {
        if (!$periode) {
            return [
                'distribution' => [],
                'criteria_avg' => []
            ];
        }

        $evaluasiList = Evaluasi::where('periode_id', $periode->id)->get();

        // Distribution data
        $distribution = [
            'Sangat Baik (>150)' => $evaluasiList->where('total_skor', '>', 150)->count(),
            'Baik (130-150)' => $evaluasiList->whereBetween('total_skor', [130, 150])->count(),
            'Cukup (110-130)' => $evaluasiList->whereBetween('total_skor', [110, 130])->count(),
            'Kurang (<110)' => $evaluasiList->where('total_skor', '<', 110)->count(),
        ];

        // Criteria averages
        $criteriaAvg = [
            'C1 - Produktivitas' => round($evaluasiList->avg('c1_produktivitas'), 2),
            'C2 - Tanggung Jawab' => round($evaluasiList->avg('c2_tanggung_jawab'), 2),
            'C3 - Kehadiran' => round($evaluasiList->avg('c3_kehadiran'), 2),
            'C4 - Pelanggaran' => round($evaluasiList->avg('c4_pelanggaran'), 2),
            'C5 - Terlambat' => round($evaluasiList->avg('c5_terlambat'), 2),
        ];

        return [
            'distribution' => $distribution,
            'criteria_avg' => $criteriaAvg
        ];
    }

    private function exportPDF($evaluasiList, $periodeId)
    {
        // Implementasi export PDF
        // Menggunakan library seperti DomPDF atau TCPDF
        return response()->json([
            'message' => 'PDF export will be implemented',
            'data_count' => $evaluasiList->count()
        ]);
    }

    private function exportExcel($evaluasiList, $periodeId)
    {
        // Implementasi export Excel
        // Menggunakan Laravel Excel package
        return response()->json([
            'message' => 'Excel export will be implemented',
            'data_count' => $evaluasiList->count()
        ]);
    }
}
