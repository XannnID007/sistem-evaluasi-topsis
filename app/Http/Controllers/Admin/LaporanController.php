<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\PeriodeEvaluasi;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $periodeList = PeriodeEvaluasi::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

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
        ]);

        try {
            $periode = PeriodeEvaluasi::findOrFail($validated['periode_id']);
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
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate laporan: ' . $e->getMessage());
        }
    }

    private function generateRankingReport($periode, $format, $includeChart = false)
    {
        $evaluasiList = Evaluasi::with('user')
            ->where('periode_id', $periode->id)
            ->orderBy('ranking')
            ->get();

        if ($evaluasiList->isEmpty()) {
            return back()->with('error', 'Tidak ada data evaluasi untuk periode ini.');
        }

        $data = [
            'periode' => $periode,
            'evaluasi_list' => $evaluasiList,
            'include_chart' => $includeChart,
            'generated_at' => now(),
            'generated_by' => auth()->user()->nama,
            'jenis_laporan' => 'Ranking'
        ];

        $filename = "Laporan_Ranking_{$periode->nama}_" . date('Y-m-d');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.templates.ranking-pdf', $data);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download($filename . '.pdf');
        } else {
            return Excel::download(new LaporanRankingExport($data), $filename . '.xlsx');
        }
    }

    private function generateStatistikReport($periode, $format, $includeChart = false)
    {
        $evaluasiList = Evaluasi::where('periode_id', $periode->id)->get();

        if ($evaluasiList->isEmpty()) {
            return back()->with('error', 'Tidak ada data evaluasi untuk periode ini.');
        }

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
            'generated_by' => auth()->user()->nama,
            'jenis_laporan' => 'Statistik'
        ];

        $filename = "Laporan_Statistik_{$periode->nama}_" . date('Y-m-d');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.templates.statistik-pdf', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->download($filename . '.pdf');
        } else {
            return Excel::download(new LaporanStatistikExport($data), $filename . '.xlsx');
        }
    }

    private function generateLengkapReport($periode, $format, $includeChart = false)
    {
        $evaluasiList = Evaluasi::with('user')
            ->where('periode_id', $periode->id)
            ->orderBy('ranking')
            ->get();

        if ($evaluasiList->isEmpty()) {
            return back()->with('error', 'Tidak ada data evaluasi untuk periode ini.');
        }

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
            'evaluasi_list' => $evaluasiList,
            'statistik' => $statistik,
            'include_chart' => $includeChart,
            'generated_at' => now(),
            'generated_by' => auth()->user()->nama,
            'jenis_laporan' => 'Lengkap'
        ];

        $filename = "Laporan_Lengkap_{$periode->nama}_" . date('Y-m-d');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.templates.lengkap-pdf', $data);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download($filename . '.pdf');
        } else {
            return Excel::download(new LaporanLengkapExport($data), $filename . '.xlsx');
        }
    }

    public function show($id)
    {
        // Show generated report (placeholder)
        return view('admin.laporan.show');
    }

    public function download($id)
    {
        // Download previously generated report (placeholder)
        return response()->json(['message' => 'Download previous report functionality']);
    }
}

// Export Classes untuk Excel

class LaporanRankingExport implements
    \Maatwebsite\Excel\Concerns\FromCollection,
    \Maatwebsite\Excel\Concerns\WithHeadings,
    \Maatwebsite\Excel\Concerns\WithStyles,
    \Maatwebsite\Excel\Concerns\ShouldAutoSize,
    \Maatwebsite\Excel\Concerns\WithTitle
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data['evaluasi_list']->map(function ($evaluasi, $index) {
            return [
                'No' => $index + 1,
                'Ranking' => $evaluasi->ranking,
                'Nama Pegawai' => $evaluasi->user->nama,
                'Jabatan' => $evaluasi->user->jabatan,
                'Kelas Jabatan' => $evaluasi->user->getKelasJabatanShort(),
                'Total Skor CPI' => number_format($evaluasi->total_skor, 5),
                'Kategori' => $this->getKategori($evaluasi->total_skor),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Ranking',
            'Nama Pegawai',
            'Jabatan',
            'Kelas Jabatan',
            'Total Skor CPI',
            'Kategori'
        ];
    }

    public function title(): string
    {
        return 'Ranking ' . $this->data['periode']->nama;
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    private function getKategori($skor)
    {
        if ($skor > 150) return 'Sangat Baik';
        if ($skor >= 130) return 'Baik';
        if ($skor >= 110) return 'Cukup';
        return 'Kurang';
    }
}

class LaporanStatistikExport implements
    \Maatwebsite\Excel\Concerns\FromArray,
    \Maatwebsite\Excel\Concerns\WithStyles,
    \Maatwebsite\Excel\Concerns\ShouldAutoSize,
    \Maatwebsite\Excel\Concerns\WithTitle
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $statistik = $this->data['statistik'];

        return [
            ['LAPORAN STATISTIK EVALUASI KINERJA'],
            ['Periode: ' . $this->data['periode']->nama],
            [''],
            ['RINGKASAN STATISTIK'],
            ['Total Pegawai', $statistik['total_pegawai']],
            ['Rata-rata Skor', number_format($statistik['rata_skor'], 2)],
            ['Skor Tertinggi', number_format($statistik['skor_tertinggi'], 2)],
            ['Skor Terendah', number_format($statistik['skor_terendah'], 2)],
            [''],
            ['DISTRIBUSI KINERJA'],
            ['Sangat Baik (>150)', $statistik['distribusi']['sangat_baik']],
            ['Baik (130-150)', $statistik['distribusi']['baik']],
            ['Cukup (110-130)', $statistik['distribusi']['cukup']],
            ['Kurang (<110)', $statistik['distribusi']['kurang']],
            [''],
            ['RATA-RATA PER KRITERIA'],
            ['C1 - Produktivitas', number_format($statistik['rata_kriteria']['c1'], 2)],
            ['C2 - Tanggung Jawab', number_format($statistik['rata_kriteria']['c2'], 2)],
            ['C3 - Kehadiran', number_format($statistik['rata_kriteria']['c3'], 2)],
            ['C4 - Pelanggaran', number_format($statistik['rata_kriteria']['c4'], 2)],
            ['C5 - Terlambat', number_format($statistik['rata_kriteria']['c5'], 2)],
        ];
    }

    public function title(): string
    {
        return 'Statistik ' . $this->data['periode']->nama;
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            4 => ['font' => ['bold' => true, 'size' => 12]],
            10 => ['font' => ['bold' => true, 'size' => 12]],
            16 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

class LaporanLengkapExport implements \Maatwebsite\Excel\Concerns\WithMultipleSheets
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new LaporanRankingExport($this->data),
            new LaporanStatistikExport($this->data),
        ];
    }
}
