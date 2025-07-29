<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Evaluasi Kinerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        
        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .info-item {
            text-align: center;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .info-item .value {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .info-item .label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 10px;
        }
        
        td {
            font-size: 9px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .ranking {
            font-weight: bold;
            font-size: 12px;
        }
        
        .ranking-1 { color: #ffd700; }
        .ranking-2 { color: #c0c0c0; }
        .ranking-3 { color: #cd7f32; }
        
        .kategori {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .kategori-sangat-baik { background-color: #dcfce7; color: #166534; }
        .kategori-baik { background-color: #dbeafe; color: #1e40af; }
        .kategori-cukup { background-color: #fef3c7; color: #92400e; }
        .kategori-kurang { background-color: #fee2e2; color: #991b1b; }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>KECAMATAN CANGKUANG</h1>
        <h2>KABUPATEN BANDUNG</h2>
        <p>Jl. Raya Cangkuang No. 123, Cangkuang, Bandung</p>
        <h2 style="margin-top: 20px;">HASIL EVALUASI KINERJA PEGAWAI</h2>
        @if($periode)
            <p><strong>Periode: {{ $periode->nama }}</strong></p>
        @else
            <p><strong>Semua Periode</strong></p>
        @endif
    </div>

    <!-- Summary Statistics -->
    <div class="info-box">
        <h3 style="margin-top: 0;">Ringkasan Statistik</h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="value">{{ $evaluasiList->count() }}</div>
                <div class="label">Total Pegawai</div>
            </div>
            <div class="info-item">
                <div class="value">{{ number_format($evaluasiList->avg('total_skor'), 2) }}</div>
                <div class="label">Rata-rata Skor</div>
            </div>
            <div class="info-item">
                <div class="value">{{ number_format($evaluasiList->max('total_skor'), 2) }}</div>
                <div class="label">Skor Tertinggi</div>
            </div>
            <div class="info-item">
                <div class="value">{{ number_format($evaluasiList->min('total_skor'), 2) }}</div>
                <div class="label">Skor Terendah</div>
            </div>
        </div>
    </div>

    <!-- Ranking Table -->
    <h3>Daftar Ranking Kinerja Pegawai</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">Rank</th>
                <th width="25%">Nama Pegawai</th>
                <th width="20%">Jabatan</th>
                <th width="8%">Kelas</th>
                <th width="6%">C1</th>
                <th width="6%">C2</th>
                <th width="6%">C3</th>
                <th width="6%">C4</th>
                <th width="6%">C5</th>
                <th width="8%">Total Skor</th>
                <th width="10%">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluasiList as $evaluasi)
            <tr>
                <td class="text-center">
                    <span class="ranking ranking-{{ min($evaluasi->ranking, 3) }}">
                        #{{ $evaluasi->ranking }}
                    </span>
                </td>
                <td>{{ $evaluasi->user->nama }}</td>
                <td>{{ $evaluasi->user->jabatan }}</td>
                <td class="text-center">{{ $evaluasi->user->getKelasJabatanShort() }}</td>
                <td class="text-center">{{ number_format($evaluasi->c1_produktivitas, 1) }}</td>
                <td class="text-center">{{ number_format($evaluasi->c2_tanggung_jawab, 1) }}</td>
                <td class="text-center">{{ number_format($evaluasi->c3_kehadiran, 1) }}</td>
                <td class="text-center">{{ $evaluasi->c4_pelanggaran }}</td>
                <td class="text-center">{{ $evaluasi->c5_terlambat }}</td>
                <td class="text-center"><strong>{{ number_format($evaluasi->total_skor, 2) }}</strong></td>
                <td class="text-center">
                    @php
                        $kategori = '';
                        $class = '';
                        if ($evaluasi->total_skor > 150) {
                            $kategori = 'Sangat Baik';
                            $class = 'kategori-sangat-baik';
                        } elseif ($evaluasi->total_skor >= 130) {
                            $kategori = 'Baik';
                            $class = 'kategori-baik';
                        } elseif ($evaluasi->total_skor >= 110) {
                            $kategori = 'Cukup';
                            $class = 'kategori-cukup';
                        } else {
                            $kategori = 'Kurang';
                            $class = 'kategori-kurang';
                        }
                    @endphp
                    <span class="kategori {{ $class }}">{{ $kategori }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Distribution Analysis -->
    <div class="page-break"></div>
    
    <h3>Analisis Distribusi Kinerja</h3>
    <div class="info-box">
        @php
            $sangat_baik = $evaluasiList->where('total_skor', '>', 150)->count();
            $baik = $evaluasiList->whereBetween('total_skor', [130, 150])->count();
            $cukup = $evaluasiList->whereBetween('total_skor', [110, 130])->count();
            $kurang = $evaluasiList->where('total_skor', '<', 110)->count();
            $total = $evaluasiList->count();
        @endphp
        
        <div class="info-grid">
            <div class="info-item">
                <div class="value" style="color: #16a34a;">{{ $sangat_baik }}</div>
                <div class="label">Sangat Baik ({{ $total > 0 ? round(($sangat_baik/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="info-item">
                <div class="value" style="color: #2563eb;">{{ $baik }}</div>
                <div class="label">Baik ({{ $total > 0 ? round(($baik/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="info-item">
                <div class="value" style="color: #d97706;">{{ $cukup }}</div>
                <div class="label">Cukup ({{ $total > 0 ? round(($cukup/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="info-item">
                <div class="value" style="color: #dc2626;">{{ $kurang }}</div>
                <div class="label">Kurang ({{ $total > 0 ? round(($kurang/$total)*100, 1) : 0 }}%)</div>
            </div>
        </div>
    </div>

    <!-- Criteria Analysis -->
    <h3>Analisis Per Kriteria</h3>
    <table>
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Bobot</th>
                <th>Rata-rata</th>
                <th>Tertinggi</th>
                <th>Terendah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>C1 - Produktivitas Kerja</td>
                <td class="text-center">40%</td>
                <td class="text-center">{{ number_format($evaluasiList->avg('c1_produktivitas'), 2) }}</td>
                <td class="text-center">{{ number_format($evaluasiList->max('c1_produktivitas'), 2) }}</td>
                <td class="text-center">{{ number_format($evaluasiList->min('c1_produktivitas'), 2) }}</td>
                <td>Tren Positif</td>
            </tr>
            <tr>
                <td>C2 - Tanggung Jawab</td>
                <td class="text-center">20%</td>
                <td class="text-center">{{ number_format($evaluasiList->avg('c2_tanggung_jawab'), 2) }}</td>
                <td class="text-center">{{ number_format($evaluasiList->max('c2_tanggung_jawab'), 2) }}</td>
                <td class="text-center">{{ number_format($evaluasiList->min('c2_tanggung_jawab'), 2) }}</td>
                <td>Tren Positif</td>
            </tr>
            <tr>
                <td>C3 - Kehadiran</td>
                <td class="text-center">20%</td>
                <td class="text-center">{{ number_format($evaluasiList->avg('c3_kehadiran'), 2) }}</td>
                <td class="text-center">{{ number_format($evaluasiList->max('c3_kehadiran'), 2) }}</td>
                <td class="text-center">{{ number_format($evaluasiList->min('c3_kehadiran'), 2) }}</td>
                <td>Tren Positif</td>
            </tr>
            <tr>
                <td>C4 - Pelanggaran Disiplin</td>
                <td class="text-center">10%</td>
                <td class="text-center">{{ number_format($evaluasiList->avg('c4_pelanggaran'), 2) }}</td>
                <td class="text-center">{{ $evaluasiList->max('c4_pelanggaran') }}</td>
                <td class="text-center">{{ $evaluasiList->min('c4_pelanggaran') }}</td>
                <td>Tren Negatif</td>
            </tr>
            <tr>
                <td>C5 - Keterlambatan</td>
                <td class="text-center">10%</td>
                <td class="text-center">{{ number_format($evaluasiList->avg('c5_terlambat'), 2) }}</td>
                <td class="text-center">{{ $evaluasiList->max('c5_terlambat') }}</td>
                <td class="text-center">{{ $evaluasiList->min('c5_terlambat') }}</td>
                <td>Tren Negatif</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Laporan ini dibuat secara otomatis oleh Sistem Evaluasi Kinerja Kecamatan Cangkuang</strong></p>
        <p>Digenerate pada: {{ $generated_at->format('d F Y, H:i:s') }} WIB oleh {{ $generated_by }}</p>
        <p>Halaman ini berisi {{ $evaluasiList->count() }} data evaluasi kinerja pegawai</p>
    </div>
</body>
</html>