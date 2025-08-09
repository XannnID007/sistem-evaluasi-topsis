<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\PeriodeEvaluasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluasiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Filter berdasarkan periode
        $query = $user->evaluasi()->with('periode');

        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        }

        $evaluasiList = $query->orderBy('created_at', 'desc')->paginate(10);
        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        // Statistik personal
        $totalEvaluasi = $user->evaluasi()->count();
        $rataSkor = $user->evaluasi()->avg('total_skor') ?? 0;
        $rankingTerbaik = $user->evaluasi()->min('ranking') ?? 0;
        $skorTertinggi = $user->evaluasi()->max('total_skor') ?? 0;

        return view('pegawai.evaluasi.index', compact(
            'evaluasiList',
            'periodeList',
            'totalEvaluasi',
            'rataSkor',
            'rankingTerbaik',
            'skorTertinggi'
        ));
    }

    public function show(Evaluasi $evaluasi)
    {
        // Pastikan pegawai hanya bisa melihat evaluasinya sendiri
        if ($evaluasi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke evaluasi ini.');
        }

        $evaluasi->load(['periode', 'creator']);

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

        // Posisi dalam periode
        $totalPegawai = Evaluasi::where('periode_id', $evaluasi->periode_id)->count();
        $pegawaiBawah = Evaluasi::where('periode_id', $evaluasi->periode_id)
            ->where('total_skor', '<', $evaluasi->total_skor)
            ->count();
        $persentil = $totalPegawai > 0 ? round(($pegawaiBawah / $totalPegawai) * 100) : 0;

        return view('pegawai.evaluasi.show', compact(
            'evaluasi',
            'avgPeriode',
            'totalPegawai',
            'persentil'
        ));
    }

    public function download(Evaluasi $evaluasi)
    {
        // Pastikan pegawai hanya bisa download evaluasinya sendiri
        if ($evaluasi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke evaluasi ini.');
        }

        $evaluasi->load(['periode', 'creator']);

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

        // Posisi dalam periode
        $totalPegawai = Evaluasi::where('periode_id', $evaluasi->periode_id)->count();
        $pegawaiBawah = Evaluasi::where('periode_id', $evaluasi->periode_id)
            ->where('total_skor', '<', $evaluasi->total_skor)
            ->count();
        $persentil = $totalPegawai > 0 ? round(($pegawaiBawah / $totalPegawai) * 100) : 0;

        // History evaluasi (5 terakhir untuk tren)
        $historyEvaluasi = auth()->user()->evaluasi()
            ->with('periode')
            ->where('id', '!=', $evaluasi->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Kategori kinerja
        $kategori = match (true) {
            $evaluasi->total_skor > 150 => 'Sangat Baik',
            $evaluasi->total_skor >= 130 => 'Baik',
            $evaluasi->total_skor >= 110 => 'Cukup',
            default => 'Kurang',
        };

        $data = [
            'evaluasi' => $evaluasi,
            'avgPeriode' => $avgPeriode,
            'totalPegawai' => $totalPegawai,
            'persentil' => $persentil,
            'historyEvaluasi' => $historyEvaluasi,
            'kategori' => $kategori,
            'generated_at' => now(),
        ];

        $filename = "Evaluasi_Kinerja_{$evaluasi->user->nama}_{$evaluasi->periode->nama}_" . date('Y-m-d');

        try {
            $pdf = Pdf::loadView('pegawai.evaluasi.pdf', $data);
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

            return $pdf->download($filename . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunduh PDF: ' . $e->getMessage());
        }
    }
}
