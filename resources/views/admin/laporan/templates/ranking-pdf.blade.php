<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Ranking Evaluasi Kinerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 15px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 3px 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .header p {
            margin: 3px 0;
            font-size: 10px;
        }
        
        .summary {
            background-color: #f8f9fa;
            padding: 12px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            text-align: center;
        }
        
        .summary-item {
            padding: 8px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        
        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .summary-label {
            font-size: 9px;
            color: #666;
            margin-top: 3px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 9px;
            text-align: center;
        }
        
        td {
            font-size: 9px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .ranking {
            font-weight: bold;
            font-size: 11px;
        }
        
        .medal {
            color: #ffd700;
        }
        
        .kategori {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            color: white;
        }
        
        .kategori-sangat-baik { background-color: #16a34a; }
        .kategori-baik { background-color: #2563eb; }
        .kategori-cukup { background-color: #d97706; }
        .kategori-kurang { background-color: #dc2626; }
        
        .distribution {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        .dist-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        
        .dist-item {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            color: white;
        }
        
        .dist-sangat-baik { background-color: #16a34a; }
        .dist-baik { background-color: #2563eb; }
        .dist-cukup { background-color: #d97706; }
        .dist-kurang { background-color: #dc2626; }
        
        .footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 9px;
            color: #666;
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
        <h2 style="margin-top: 15px;">LAPORAN RANKING EVALUASI KINERJA PEGAWAI</h2>
        <p><strong>Periode: {{ $periode->nama }}</strong></p>
    </div>

    <!-- Summary -->
    <div class="summary">
        <h3 style="margin-top: 0; margin-bottom: 10px;">Ringkasan Eksekutif</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">{{ $evaluasi_list->count() }}</div>
                <div class="summary-label">Total Pegawai</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($evaluasi_list->avg('total_skor'), 1) }}</div>
                <div class="summary-label">Rata-rata Skor</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($evaluasi_list->max('total_skor'), 1) }}</div>
                <div class="summary-label">Skor Tertinggi</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($evaluasi_list->min('total_skor'), 1) }}</div>
                <div class="summary-label">Skor Terendah</div>
            </div>
        </div>
    </div>

    <!-- Ranking Table -->
    <h3>Daftar Ranking Kinerja Pegawai</h3>
    <table>
        <thead>
            <tr>
                <th width="8%">Ranking</th>
                <th width="28%">Nama Pegawai</th>
                <th width="25%">Jabatan</th>
                <th width="10%">Kelas</th>
                <th width="12%">Total Skor</th>
                <th width="17%">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluasi_list as $evaluasi)
            <tr>
                <td class="text-center">
                    <span class="ranking {{ $evaluasi->ranking <= 3 ? 'medal' : '' }}">
                        @if($evaluasi->ranking <= 3)★@endif #{{ $evaluasi->ranking }}
                    </span>
                </td>
                <td>{{ $evaluasi->user->nama }}</td>
                <td>{{ $evaluasi->user->jabatan }}</td>
                <td class="text-center">{{ $evaluasi->user->getKelasJabatanShort() }}</td>
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
    <div class="distribution">
        <h3 style="margin-top: 0;">Distribusi Kinerja</h3>
        @php
            $sangat_baik = $evaluasi_list->where('total_skor', '>', 150)->count();
            $baik = $evaluasi_list->whereBetween('total_skor', [130, 150])->count();
            $cukup = $evaluasi_list->whereBetween('total_skor', [110, 130])->count();
            $kurang = $evaluasi_list->where('total_skor', '<', 110)->count();
            $total = $evaluasi_list->count();
        @endphp
        
        <div class="dist-grid">
            <div class="dist-item dist-sangat-baik">
                <div style="font-size: 14px; font-weight: bold;">{{ $sangat_baik }}</div>
                <div style="font-size: 9px;">Sangat Baik</div>
                <div style="font-size: 8px;">({{ $total > 0 ? round(($sangat_baik/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="dist-item dist-baik">
                <div style="font-size: 14px; font-weight: bold;">{{ $baik }}</div>
                <div style="font-size: 9px;">Baik</div>
                <div style="font-size: 8px;">({{ $total > 0 ? round(($baik/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="dist-item dist-cukup">
                <div style="font-size: 14px; font-weight: bold;">{{ $cukup }}</div>
                <div style="font-size: 9px;">Cukup</div>
                <div style="font-size: 8px;">({{ $total > 0 ? round(($cukup/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="dist-item dist-kurang">
                <div style="font-size: 14px; font-weight: bold;">{{ $kurang }}</div>
                <div style="font-size: 9px;">Kurang</div>
                <div style="font-size: 8px;">({{ $total > 0 ? round(($kurang/$total)*100, 1) : 0 }}%)</div>
            </div>
        </div>
    </div>

    <!-- Top 5 Performers -->
    <div style="margin-top: 20px;">
        <h3>Top 5 Pegawai Terbaik</h3>
        <table>
            <thead>
                <tr>
                    <th width="10%">Rank</th>
                    <th width="35%">Nama</th>
                    <th width="30%">Jabatan</th>
                    <th width="15%">Skor</th>
                    <th width="10%">Gap</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evaluasi_list->take(5) as $index => $evaluasi)
                <tr>
                    <td class="text-center">
                        <span class="ranking medal">★ #{{ $evaluasi->ranking }}</span>
                    </td>
                    <td>{{ $evaluasi->user->nama }}</td>
                    <td>{{ $evaluasi->user->jabatan }}</td>
                    <td class="text-center"><strong>{{ number_format($evaluasi->total_skor, 2) }}</strong></td>
                    <td class="text-center">
                        @if($index > 0)
                            {{ number_format($evaluasi_list->first()->total_skor - $evaluasi->total_skor, 2) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Laporan Ranking Evaluasi Kinerja - {{ $jenis_laporan }}</strong></p>
        <p>Digenerate pada: {{ $generated_at->format('d F Y, H:i:s') }} WIB oleh {{ $generated_by }}</p>
        <p>Total {{ $evaluasi_list->count() }} pegawai telah dievaluasi pada periode {{ $periode->nama }}</p>
        <p style="margin-top: 10px; font-style: italic;">
            Sistem Evaluasi Kinerja Pegawai - Kecamatan Cangkuang, Kabupaten Bandung
        </p>
    </div>
</body>
</html>