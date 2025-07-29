<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Statistik Evaluasi Kinerja</title>
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
        
        .summary-box {
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
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
        }
        
        td {
            font-size: 10px;
        }
        
        .text-center {
            text-align: center;
        }
        
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
        
        .criteria-table {
            margin-top: 20px;
        }
        
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
        <h2 style="margin-top: 15px;">LAPORAN STATISTIK EVALUASI KINERJA PEGAWAI</h2>
        <p><strong>Periode: {{ $periode->nama }}</strong></p>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-box">
        <h3 style="margin-top: 0; margin-bottom: 10px;">Ringkasan Statistik</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">{{ $statistik['total_pegawai'] }}</div>
                <div class="summary-label">Total Pegawai</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($statistik['rata_skor'], 1) }}</div>
                <div class="summary-label">Rata-rata Skor</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($statistik['skor_tertinggi'], 1) }}</div>
                <div class="summary-label">Skor Tertinggi</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($statistik['skor_terendah'], 1) }}</div>
                <div class="summary-label">Skor Terendah</div>
            </div>
        </div>
    </div>

    <!-- Distribution Analysis -->
    <div class="distribution">
        <h3 style="margin-top: 0;">Distribusi Kinerja</h3>
        @php
            $total = $statistik['total_pegawai'];
        @endphp
        
        <div class="dist-grid">
            <div class="dist-item dist-sangat-baik">
                <div style="font-size: 14px; font-weight: bold;">{{ $statistik['distribusi']['sangat_baik'] }}</div>
                <div style="font-size: 9px;">Sangat Baik</div>
                <div style="font-size: 8px;">({{ $total > 0 ? round(($statistik['distribusi']['sangat_baik']/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="dist-item dist-baik">
                <div style="font-size: 14px; font-weight: bold;">{{ $statistik['distribusi']['baik'] }}</div>
                <div style="font-size: 9px;">Baik</div>
                <div style="font-size: 8px;">({{ $total > 0 ? round(($statistik['distribusi']['baik']/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="dist-item dist-cukup">
                <div style="font-size: 14px; font-weight: bold;">{{ $statistik['distribusi']['cukup'] }}</div>
                <div style="font-size: 9px;">Cukup</div>
                <div style="font-size: 8px;">({{ $total > 0 ? round(($statistik['distribusi']['cukup']/$total)*100, 1) : 0 }}%)</div>
            </div>
            <div class="dist-item dist-kurang">
                <div style="font-size: 14px; font-weight: bold;">{{ $statistik['distribusi']['kurang'] }}</div>
                <div style="font-size: 9px;">Kurang</div>
                <div style="font-size: 8px;">({{ $total > 0 ? round(($statistik['distribusi']['kurang']/$total)*100, 1) : 0 }}%)</div>
            </div>
        </div>
    </div>

    <!-- Criteria Analysis -->
    <div class="criteria-table">
        <h3>Analisis Per Kriteria Evaluasi</h3>
        <table>
            <thead>
                <tr>
                    <th width="25%">Kriteria</th>
                    <th width="15%">Bobot</th>
                    <th width="15%">Rata-rata</th>
                    <th width="15%">Tertinggi</th>
                    <th width="15%">Terendah</th>
                    <th width="15%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>C1 - Produktivitas Kerja</td>
                    <td class="text-center">40%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c1'], 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->max('c1_produktivitas'), 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->min('c1_produktivitas'), 2) }}</td>
                    <td class="text-center">Tren Positif</td>
                </tr>
                <tr>
                    <td>C2 - Tanggung Jawab</td>
                    <td class="text-center">20%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c2'], 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->max('c2_tanggung_jawab'), 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->min('c2_tanggung_jawab'), 2) }}</td>
                    <td class="text-center">Tren Positif</td>
                </tr>
                <tr>
                    <td>C3 - Kehadiran</td>
                    <td class="text-center">20%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c3'], 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->max('c3_kehadiran'), 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->min('c3_kehadiran'), 2) }}</td>
                    <td class="text-center">Tren Positif</td>
                </tr>
                <tr>
                    <td>C4 - Pelanggaran Disiplin</td>
                    <td class="text-center">10%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c4'], 2) }}</td>
                    <td class="text-center">{{ $evaluasi_list->max('c4_pelanggaran') }}</td>
                    <td class="text-center">{{ $evaluasi_list->min('c4_pelanggaran') }}</td>
                    <td class="text-center">Tren Negatif</td>
                </tr>
                <tr>
                    <td>C5 - Keterlambatan</td>
                    <td class="text-center">10%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c5'], 2) }}</td>
                    <td class="text-center">{{ $evaluasi_list->max('c5_terlambat') }}</td>
                    <td class="text-center">{{ $evaluasi_list->min('c5_terlambat') }}</td>
                    <td class="text-center">Tren Negatif</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Top and Bottom Performers -->
    <div style="margin-top: 20px;">
        <h3>Top 5 Pegawai Terbaik</h3>
        <table>
            <thead>
                <tr>
                    <th width="10%">Rank</th>
                    <th width="35%">Nama</th>
                    <th width="30%">Jabatan</th>
                    <th width="15%">Skor</th>
                    <th width="10%">Kategori</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evaluasi_list->sortBy('ranking')->take(5) as $evaluasi)
                <tr>
                    <td class="text-center">
                        <span style="font-weight: bold; color: #ffd700;">#{{ $evaluasi->ranking }}</span>
                    </td>
                    <td>{{ $evaluasi->user->nama }}</td>
                    <td>{{ $evaluasi->user->jabatan }}</td>
                    <td class="text-center"><strong>{{ number_format($evaluasi->total_skor, 2) }}</strong></td>
                    <td class="text-center">
                        @php
                            $kategori = '';
                            if ($evaluasi->total_skor > 150) {
                                $kategori = 'Sangat Baik';
                            } elseif ($evaluasi->total_skor >= 130) {
                                $kategori = 'Baik';
                            } elseif ($evaluasi->total_skor >= 110) {
                                $kategori = 'Cukup';
                            } else {
                                $kategori = 'Kurang';
                            }
                        @endphp
                        {{ $kategori }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Laporan Statistik Evaluasi Kinerja - {{ $jenis_laporan }}</strong></p>
        <p>Digenerate pada: {{ $generated_at->format('d F Y, H:i:s') }} WIB oleh {{ $generated_by }}</p>
        <p>Total {{ $statistik['total_pegawai'] }} pegawai telah dievaluasi pada periode {{ $periode->nama }}</p>
        <p style="margin-top: 10px; font-style: italic;">
            Sistem Evaluasi Kinerja Pegawai - Kecamatan Cangkuang, Kabupaten Bandung
        </p>
    </div>
</body>
</html>