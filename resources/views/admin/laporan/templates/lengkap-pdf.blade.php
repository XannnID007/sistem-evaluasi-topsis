<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Lengkap Evaluasi Kinerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 10px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 2px 0;
            font-size: 12px;
            font-weight: bold;
        }
        
        .header p {
            margin: 2px 0;
            font-size: 9px;
        }
        
        .summary-box {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            border-radius: 3px;
        }
        
        .summary-stats {
            display: flex;
            justify-content: space-between;
            text-align: center;
            margin-top: 10px;
        }
        
        .summary-item {
            flex: 1;
            padding: 6px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 2px;
            margin: 0 2px;
        }
        
        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .summary-label {
            font-size: 8px;
            color: #666;
            margin-top: 2px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 8px;
            text-align: center;
        }
        
        td {
            font-size: 8px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .ranking {
            font-weight: bold;
            font-size: 9px;
        }
        
        .medal {
            color: #ffd700;
        }
        
        .kategori {
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            font-weight: bold;
            color: white;
        }
        
        .kategori-sangat-baik { background-color: #16a34a; }
        .kategori-baik { background-color: #2563eb; }
        .kategori-cukup { background-color: #d97706; }
        .kategori-kurang { background-color: #dc2626; }
        
        .distribution {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 3px;
        }
        
        .dist-grid {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
        }
        
        .dist-item {
            flex: 1;
            text-align: center;
            padding: 8px;
            border-radius: 3px;
            color: white;
            margin: 0 2px;
        }
        
        .dist-sangat-baik { background-color: #16a34a; }
        .dist-baik { background-color: #2563eb; }
        .dist-cukup { background-color: #d97706; }
        .dist-kurang { background-color: #dc2626; }
        
        .page-break {
            page-break-after: always;
        }
        
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
        
        .two-column {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        
        .column {
            flex: 1;
            background-color: white;
            border-radius: 5px;
            padding: 10px;
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
        <h2 style="margin-top: 10px;">LAPORAN LENGKAP EVALUASI KINERJA PEGAWAI</h2>
        <p><strong>Periode: {{ $periode->nama }}</strong></p>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-box">
        <h3 style="margin-top: 0; margin-bottom: 8px; font-size: 11px;">Ringkasan Statistik</h3>
        <div class="summary-stats">
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

    <!-- Ranking Table -->
    <h3 style="font-size: 11px;">Daftar Ranking Kinerja Pegawai</h3>
    <table>
        <thead>
            <tr>
                <th width="6%">Rank</th>
                <th width="20%">Nama Pegawai</th>
                <th width="18%">Jabatan</th>
                <th width="6%">Kelas</th>
                <th width="5%">C1</th>
                <th width="5%">C2</th>
                <th width="5%">C3</th>
                <th width="4%">C4</th>
                <th width="4%">C5</th>
                <th width="8%">Total Skor</th>
                <th width="9%">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluasi_list as $evaluasi)
            <tr>
                <td class="text-center">
                    <span class="ranking {{ $evaluasi->ranking <= 3 ? 'medal' : '' }}">
                        @if($evaluasi->ranking <= 3)★@endif {{ $evaluasi->ranking }}
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

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Distribution and Criteria Analysis -->
    <div class="two-column">
        <!-- Distribution Analysis -->
        <div class="column">
            <h3 style="margin-top: 0; font-size: 11px;">Distribusi Kinerja</h3>
            @php
                $total = $statistik['total_pegawai'];
            @endphp
            
            <div class="dist-grid">
                <div class="dist-item dist-sangat-baik">
                    <div style="font-size: 12px; font-weight: bold;">{{ $statistik['distribusi']['sangat_baik'] }}</div>
                    <div style="font-size: 8px;">Sangat Baik</div>
                    <div style="font-size: 7px;">({{ $total > 0 ? round(($statistik['distribusi']['sangat_baik']/$total)*100, 1) : 0 }}%)</div>
                </div>
                <div class="dist-item dist-baik">
                    <div style="font-size: 12px; font-weight: bold;">{{ $statistik['distribusi']['baik'] }}</div>
                    <div style="font-size: 8px;">Baik</div>
                    <div style="font-size: 7px;">({{ $total > 0 ? round(($statistik['distribusi']['baik']/$total)*100, 1) : 0 }}%)</div>
                </div>
                <div class="dist-item dist-cukup">
                    <div style="font-size: 12px; font-weight: bold;">{{ $statistik['distribusi']['cukup'] }}</div>
                    <div style="font-size: 8px;">Cukup</div>
                    <div style="font-size: 7px;">({{ $total > 0 ? round(($statistik['distribusi']['cukup']/$total)*100, 1) : 0 }}%)</div>
                </div>
                <div class="dist-item dist-kurang">
                    <div style="font-size: 12px; font-weight: bold;">{{ $statistik['distribusi']['kurang'] }}</div>
                    <div style="font-size: 8px;">Kurang</div>
                    <div style="font-size: 7px;">({{ $total > 0 ? round(($statistik['distribusi']['kurang']/$total)*100, 1) : 0 }}%)</div>
                </div>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="column">
            <h3 style="margin-top: 0; font-size: 11px;">Top 5 Performers</h3>
            @foreach($evaluasi_list->sortBy('ranking')->take(5) as $evaluasi)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 3px 0; border-bottom: 1px solid #eee;">
                    <div style="display: flex; align-items: center;">
                        <span style="background-color: {{ $evaluasi->ranking <= 3 ? '#ffd700' : '#ccc' }}; color: white; font-weight: bold; font-size: 8px; padding: 2px 4px; border-radius: 50%; margin-right: 5px; min-width: 20px; text-align: center;">
                            {{ $evaluasi->ranking }}
                        </span>
                        <div>
                            <div style="font-size: 8px; font-weight: bold;">{{ $evaluasi->user->nama }}</div>
                            <div style="font-size: 7px; color: #666;">{{ Str::limit($evaluasi->user->jabatan, 25) }}</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 9px; font-weight: bold;">{{ number_format($evaluasi->total_skor, 2) }}</div>
                        <div style="font-size: 7px; color: #666;">Skor</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Criteria Analysis -->
    <div style="margin-top: 15px;">
        <h3 style="font-size: 11px;">Analisis Per Kriteria Evaluasi</h3>
        <table>
            <thead>
                <tr>
                    <th width="25%">Kriteria</th>
                    <th width="12%">Bobot</th>
                    <th width="12%">Rata-rata</th>
                    <th width="12%">Tertinggi</th>
                    <th width="12%">Terendah</th>
                    <th width="15%">Std Deviasi</th>
                    <th width="12%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>C1 - Produktivitas Kerja</td>
                    <td class="text-center">40%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c1'], 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->max('c1_produktivitas'), 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->min('c1_produktivitas'), 2) }}</td>
                    <td class="text-center">{{ number_format(sqrt($evaluasi_list->map(fn($e) => pow($e->c1_produktivitas - $statistik['rata_kriteria']['c1'], 2))->sum() / $evaluasi_list->count()), 2) }}</td>
                    <td class="text-center">Tren Positif</td>
                </tr>
                <tr>
                    <td>C2 - Tanggung Jawab</td>
                    <td class="text-center">20%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c2'], 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->max('c2_tanggung_jawab'), 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->min('c2_tanggung_jawab'), 2) }}</td>
                    <td class="text-center">{{ number_format(sqrt($evaluasi_list->map(fn($e) => pow($e->c2_tanggung_jawab - $statistik['rata_kriteria']['c2'], 2))->sum() / $evaluasi_list->count()), 2) }}</td>
                    <td class="text-center">Tren Positif</td>
                </tr>
                <tr>
                    <td>C3 - Kehadiran</td>
                    <td class="text-center">20%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c3'], 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->max('c3_kehadiran'), 2) }}</td>
                    <td class="text-center">{{ number_format($evaluasi_list->min('c3_kehadiran'), 2) }}</td>
                    <td class="text-center">{{ number_format(sqrt($evaluasi_list->map(fn($e) => pow($e->c3_kehadiran - $statistik['rata_kriteria']['c3'], 2))->sum() / $evaluasi_list->count()), 2) }}</td>
                    <td class="text-center">Tren Positif</td>
                </tr>
                <tr>
                    <td>C4 - Pelanggaran Disiplin</td>
                    <td class="text-center">10%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c4'], 2) }}</td>
                    <td class="text-center">{{ $evaluasi_list->max('c4_pelanggaran') }}</td>
                    <td class="text-center">{{ $evaluasi_list->min('c4_pelanggaran') }}</td>
                    <td class="text-center">{{ number_format(sqrt($evaluasi_list->map(fn($e) => pow($e->c4_pelanggaran - $statistik['rata_kriteria']['c4'], 2))->sum() / $evaluasi_list->count()), 2) }}</td>
                    <td class="text-center">Tren Negatif</td>
                </tr>
                <tr>
                    <td>C5 - Keterlambatan</td>
                    <td class="text-center">10%</td>
                    <td class="text-center">{{ number_format($statistik['rata_kriteria']['c5'], 2) }}</td>
                    <td class="text-center">{{ $evaluasi_list->max('c5_terlambat') }}</td>
                    <td class="text-center">{{ $evaluasi_list->min('c5_terlambat') }}</td>
                    <td class="text-center">{{ number_format(sqrt($evaluasi_list->map(fn($e) => pow($e->c5_terlambat - $statistik['rata_kriteria']['c5'], 2))->sum() / $evaluasi_list->count()), 2) }}</td>
                    <td class="text-center">Tren Negatif</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Recommendations -->
    <div style="margin-top: 15px; padding: 10px; background-color: #f0f9ff; border-radius: 5px;">
        <h3 style="margin-top: 0; font-size: 11px; color: #1e40af;">Rekomendasi dan Tindak Lanjut</h3>
        
        @php
            $improvedCount = $evaluasi_list->where('total_skor', '>', $statistik['rata_skor'])->count();
            $needAttentionCount = $evaluasi_list->where('total_skor', '<', 110)->count();
        @endphp
        
        <ul style="margin: 5px 0; padding-left: 15px; font-size: 8px;">
            @if($improvedCount > ($statistik['total_pegawai'] / 2))
                <li style="margin-bottom: 3px;">
                    <strong>Tren Positif:</strong> {{ $improvedCount }} pegawai ({{ round(($improvedCount / $statistik['total_pegawai']) * 100, 1) }}%) berada di atas rata-rata. Pertahankan strategi pengembangan yang ada.
                </li>
            @endif
            
            @if($needAttentionCount > 0)
                <li style="margin-bottom: 3px;">
                    <strong>Perlu Perhatian:</strong> {{ $needAttentionCount }} pegawai memiliki skor di bawah 110 dan memerlukan program peningkatan kinerja khusus.
                </li>
            @endif
            
            <li style="margin-bottom: 3px;">
                <strong>Program Mentoring:</strong> Adakan program mentoring antara pegawai dengan skor tinggi dengan yang memerlukan peningkatan.
            </li>
            
            @if($statistik['rata_kriteria']['c3'] < 80)
                <li style="margin-bottom: 3px;">
                    <strong>Kehadiran:</strong> Rata-rata kehadiran masih perlu ditingkatkan. Implementasikan sistem monitoring kehadiran yang lebih ketat.
                </li>
            @endif
            
            @if($statistik['rata_kriteria']['c4'] > 1 || $statistik['rata_kriteria']['c5'] > 2)
                <li style="margin-bottom: 3px;">
                    <strong>Disiplin:</strong> Perlu penguatan aturan disiplin dan sanksi yang tegas untuk mengurangi pelanggaran dan keterlambatan.
                </li>
            @endif
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Laporan Lengkap Evaluasi Kinerja - {{ $jenis_laporan }}</strong></p>
        <p>Digenerate pada: {{ $generated_at->format('d F Y, H:i:s') }} WIB oleh {{ $generated_by }}</p>
        <p>Total {{ $statistik['total_pegawai'] }} pegawai telah dievaluasi pada periode {{ $periode->nama }}</p>
        <p style="margin-top: 8px; font-style: italic;">
            Sistem Evaluasi Kinerja Pegawai - Kecamatan Cangkuang, Kabupaten Bandung
        </p>
    </div>
</body>
</html>