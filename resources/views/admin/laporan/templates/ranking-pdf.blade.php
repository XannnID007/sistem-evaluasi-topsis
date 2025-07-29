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

    <!-- Ranking Table -->
    <h3>Daftar Ranking Kinerja Pegawai</h3>
    <table>
        <thead>
            <tr>
                <th width="8%">Ranking</th>
                <th width="25%">Nama Pegawai</th>
                <th width="22%">Jabatan</th>
                <th width="8%">Kelas</th>
                <th width="6%">C1</th>
                <th width="6%">C2</th>
                <th width="6%">C3</th>
                <th width="5%">C4</th>
                <th width="5%">C5</th>
                <th width="9%">Total Skor</th>
                <th width="10%">Kategori</th>
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