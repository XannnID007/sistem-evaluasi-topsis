<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Evaluasi Kinerja - {{ $evaluasi->user->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 15px;
            color: #333;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
        }
        
        .header h2 {
            margin: 3px 0;
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .header p {
            margin: 3px 0;
            font-size: 10px;
            color: #666;
        }
        
        .employee-info {
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .employee-info h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #1e40af;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }
        
        .info-label {
            font-weight: bold;
            color: #475569;
        }
        
        .info-value {
            color: #1e293b;
        }
        
        .score-summary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .score-main {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .score-label {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 10px;
        }
        
        .score-category {
            display: inline-block;
            padding: 5px 15px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
        }
        
        .ranking-box {
            background-color: #fbbf24;
            color: white;
            display: inline-block;
            padding: 10px 15px;
            border-radius: 50px;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .criteria-section {
            margin-bottom: 20px;
        }
        
        .criteria-section h3 {
            font-size: 14px;
            color: #1e40af;
            margin-bottom: 15px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
        }
        
        .criteria-item {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
        }
        
        .criteria-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .criteria-name {
            font-weight: bold;
            color: #1e293b;
        }
        
        .criteria-score {
            font-size: 18px;
            font-weight: bold;
        }
        
        .criteria-positive { color: #059669; }
        .criteria-negative { color: #dc2626; }
        
        .criteria-details {
            font-size: 10px;
            color: #6b7280;
            margin-top: 3px;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 5px;
        }
        
        .progress-fill {
            height: 100%;
            transition: width 0.3s ease;
        }
        
        .progress-positive { background-color: #10b981; }
        .progress-negative { background-color: #ef4444; }
        
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .comparison-table th,
        .comparison-table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: center;
        }
        
        .comparison-table th {
            background-color: #f3f4f6;
            font-weight: bold;
            font-size: 10px;
        }
        
        .comparison-table td {
            font-size: 10px;
        }
        
        .trend-section {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .trend-section h4 {
            margin: 0 0 10px 0;
            color: #92400e;
            font-size: 13px;
        }
        
        .recommendations {
            background-color: #ecfdf5;
            border: 1px solid #10b981;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .recommendations h4 {
            margin: 0 0 10px 0;
            color: #065f46;
            font-size: 13px;
        }
        
        .recommendations ul {
            margin: 0;
            padding-left: 15px;
        }
        
        .recommendations li {
            margin-bottom: 5px;
            font-size: 10px;
            color: #064e3b;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }
        
        .positive-trend {
            color: #059669;
            font-weight: bold;
        }
        
        .negative-trend {
            color: #dc2626;
            font-weight: bold;
        }
        
        .stable-trend {
            color: #6b7280;
            font-weight: bold;
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
        <h2 style="margin-top: 15px;">LAPORAN EVALUASI KINERJA PEGAWAI</h2>
    </div>

    <!-- Employee Information -->
    <div class="employee-info">
        <h3>Informasi Pegawai</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama:</span>
                <span class="info-value">{{ $evaluasi->user->nama }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jabatan:</span>
                <span class="info-value">{{ $evaluasi->user->jabatan }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Kelas Jabatan:</span>
                <span class="info-value">{{ $evaluasi->user->getKelasJabatanText() }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Periode:</span>
                <span class="info-value">{{ $evaluasi->periode->nama }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Evaluasi:</span>
                <span class="info-value">{{ $evaluasi->created_at->format('d F Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Evaluator:</span>
                <span class="info-value">{{ $evaluasi->creator->nama }}</span>
            </div>
        </div>
    </div>

    <!-- Score Summary -->
    <div class="score-summary">
        <div class="score-main">{{ number_format($evaluasi->total_skor, 2) }}</div>
        <div class="score-label">Total Skor CPI (Composite Performance Index)</div>
        <div class="score-category">{{ $kategori }}</div>
        <div class="ranking-box">Peringkat #{{ $evaluasi->ranking }} dari {{ $totalPegawai }} pegawai</div>
        @if($persentil)
            <div style="margin-top: 8px; font-size: 11px; opacity: 0.9;">
                Anda berada di persentil ke-{{ $persentil }}
            </div>
        @endif
    </div>

    <!-- Criteria Breakdown -->
    <div class="criteria-section">
        <h3>Penilaian Per Kriteria</h3>

        <!-- C1 - Produktivitas -->
        <div class="criteria-item">
            <div class="criteria-header">
                <div>
                    <div class="criteria-name">C1 - Produktivitas Kerja</div>
                    <div class="criteria-details">Bobot: 40% | Tren: Positif</div>
                </div>
                <div class="criteria-score criteria-positive">{{ number_format($evaluasi->c1_produktivitas, 1) }}</div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill progress-positive" style="width: {{ min(100, $evaluasi->c1_produktivitas) }}%"></div>
            </div>
            @if($avgPeriode)
                <div class="criteria-details" style="margin-top: 5px;">
                    Rata-rata periode: {{ number_format($avgPeriode->avg_c1, 1) }}
                    @php $diff = $evaluasi->c1_produktivitas - $avgPeriode->avg_c1; @endphp
                    ({{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }})
                </div>
            @endif
        </div>

        <!-- C2 - Tanggung Jawab -->
        <div class="criteria-item">
            <div class="criteria-header">
                <div>
                    <div class="criteria-name">C2 - Tanggung Jawab</div>
                    <div class="criteria-details">Bobot: 20% | Tren: Positif</div>
                </div>
                <div class="criteria-score criteria-positive">{{ number_format($evaluasi->c2_tanggung_jawab, 1) }}</div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill progress-positive" style="width: {{ min(100, $evaluasi->c2_tanggung_jawab) }}%"></div>
            </div>
            @if($avgPeriode)
                <div class="criteria-details" style="margin-top: 5px;">
                    Rata-rata periode: {{ number_format($avgPeriode->avg_c2, 1) }}
                    @php $diff = $evaluasi->c2_tanggung_jawab - $avgPeriode->avg_c2; @endphp
                    ({{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }})
                </div>
            @endif
        </div>

        <!-- C3 - Kehadiran -->
        <div class="criteria-item">
            <div class="criteria-header">
                <div>
                    <div class="criteria-name">C3 - Kehadiran</div>
                    <div class="criteria-details">Bobot: 20% | Tren: Positif</div>
                </div>
                <div class="criteria-score criteria-positive">{{ number_format($evaluasi->c3_kehadiran, 1) }}</div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill progress-positive" style="width: {{ min(100, $evaluasi->c3_kehadiran) }}%"></div>
            </div>
            @if($avgPeriode)
                <div class="criteria-details" style="margin-top: 5px;">
                    Rata-rata periode: {{ number_format($avgPeriode->avg_c3, 1) }}
                    @php $diff = $evaluasi->c3_kehadiran - $avgPeriode->avg_c3; @endphp
                    ({{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }})
                </div>
            @endif
        </div>

        <!-- C4 - Pelanggaran -->
        <div class="criteria-item">
            <div class="criteria-header">
                <div>
                    <div class="criteria-name">C4 - Pelanggaran Disiplin</div>
                    <div class="criteria-details">Bobot: 10% | Tren: Negatif (semakin sedikit semakin baik)</div>
                </div>
                <div class="criteria-score criteria-negative">{{ $evaluasi->c4_pelanggaran }} kali</div>
            </div>
            @if($avgPeriode)
                <div class="criteria-details" style="margin-top: 5px;">
                    Rata-rata periode: {{ number_format($avgPeriode->avg_c4, 1) }} kali
                </div>
            @endif
        </div>

        <!-- C5 - Keterlambatan -->
        <div class="criteria-item">
            <div class="criteria-header">
                <div>
                    <div class="criteria-name">C5 - Keterlambatan</div>
                    <div class="criteria-details">Bobot: 10% | Tren: Negatif (semakin sedikit semakin baik)</div>
                </div>
                <div class="criteria-score criteria-negative">{{ $evaluasi->c5_terlambat }} kali</div>
            </div>
            @if($avgPeriode)
                <div class="criteria-details" style="margin-top: 5px;">
                    Rata-rata periode: {{ number_format($avgPeriode->avg_c5, 1) }} kali
                </div>
            @endif
        </div>
    </div>

    <!-- Performance Comparison -->
    @if($avgPeriode)
        <div class="criteria-section">
            <h3>Perbandingan dengan Rata-rata Periode</h3>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th>Skor Anda</th>
                        <th>Rata-rata Periode</th>
                        <th>Selisih</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>C1 - Produktivitas</td>
                        <td>{{ number_format($evaluasi->c1_produktivitas, 1) }}</td>
                        <td>{{ number_format($avgPeriode->avg_c1, 1) }}</td>
                        <td>{{ number_format($evaluasi->c1_produktivitas - $avgPeriode->avg_c1, 1) }}</td>
                        <td class="{{ $evaluasi->c1_produktivitas >= $avgPeriode->avg_c1 ? 'positive-trend' : 'negative-trend' }}">
                            {{ $evaluasi->c1_produktivitas >= $avgPeriode->avg_c1 ? 'Di Atas Rata-rata' : 'Di Bawah Rata-rata' }}
                        </td>
                    </tr>
                    <tr>
                        <td>C2 - Tanggung Jawab</td>
                        <td>{{ number_format($evaluasi->c2_tanggung_jawab, 1) }}</td>
                        <td>{{ number_format($avgPeriode->avg_c2, 1) }}</td>
                        <td>{{ number_format($evaluasi->c2_tanggung_jawab - $avgPeriode->avg_c2, 1) }}</td>
                        <td class="{{ $evaluasi->c2_tanggung_jawab >= $avgPeriode->avg_c2 ? 'positive-trend' : 'negative-trend' }}">
                            {{ $evaluasi->c2_tanggung_jawab >= $avgPeriode->avg_c2 ? 'Di Atas Rata-rata' : 'Di Bawah Rata-rata' }}
                        </td>
                    </tr>
                    <tr>
                        <td>C3 - Kehadiran</td>
                        <td>{{ number_format($evaluasi->c3_kehadiran, 1) }}</td>
                        <td>{{ number_format($avgPeriode->avg_c3, 1) }}</td>
                        <td>{{ number_format($evaluasi->c3_kehadiran - $avgPeriode->avg_c3, 1) }}</td>
                        <td class="{{ $evaluasi->c3_kehadiran >= $avgPeriode->avg_c3 ? 'positive-trend' : 'negative-trend' }}">
                            {{ $evaluasi->c3_kehadiran >= $avgPeriode->avg_c3 ? 'Di Atas Rata-rata' : 'Di Bawah Rata-rata' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Total Skor CPI</td>
                        <td>{{ number_format($evaluasi->total_skor, 2) }}</td>
                        <td>{{ number_format($avgPeriode->avg_total, 2) }}</td>
                        <td>{{ number_format($evaluasi->total_skor - $avgPeriode->avg_total, 2) }}</td>
                        <td class="{{ $evaluasi->total_skor >= $avgPeriode->avg_total ? 'positive-trend' : 'negative-trend' }}">
                            {{ $evaluasi->total_skor >= $avgPeriode->avg_total ? 'Di Atas Rata-rata' : 'Di Bawah Rata-rata' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    <!-- Trend History -->
    @if($historyEvaluasi->count() > 0)
        <div class="trend-section">
            <h4>Tren Kinerja Historis (5 Periode Terakhir)</h4>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Total Skor</th>
                        <th>Ranking</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historyEvaluasi as $history)
                        <tr>
                            <td>{{ $history->periode->nama }}</td>
                            <td>{{ number_format($history->total_skor, 2) }}</td>
                            <td>#{{ $history->ranking }}</td>
                            <td>
                                @php
                                    $historyCat = match (true) {
                                        $history->total_skor > 150 => 'Sangat Baik',
                                        $history->total_skor >= 130 => 'Baik',
                                        $history->total_skor >= 110 => 'Cukup',
                                        default => 'Kurang',
                                    };
                                @endphp
                                {{ $historyCat }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Recommendations -->
    <div class="recommendations">
        <h4>Rekomendasi Pengembangan</h4>
        <ul>
            @if($evaluasi->ranking <= 5)
                <li><strong>Pertahankan Prestasi:</strong> Anda berada dalam 5 besar. Terus tingkatkan konsistensi dan jadilah mentor bagi rekan kerja.</li>
            @elseif($evaluasi->ranking <= 10)
                <li><strong>Tingkatkan Performa:</strong> Anda sudah di jalur yang baik. Fokus pada area dengan skor terendah untuk naik ke ranking teratas.</li>
            @else
                <li><strong>Perbaikan Diperlukan:</strong> Fokus pada peningkatan kinerja di semua aspek, terutama yang skornya di bawah rata-rata.</li>
            @endif

            @if($evaluasi->c1_produktivitas < 70)
                <li><strong>Produktivitas:</strong> Tingkatkan efisiensi kerja dan kualitas output. Gunakan metode manajemen waktu yang lebih baik.</li>
            @endif

            @if($evaluasi->c2_tanggung_jawab < 70)
                <li><strong>Tanggung Jawab:</strong> Perkuat komitmen terhadap tugas dan tingkatkan akuntabilitas dalam pekerjaan.</li>
            @endif

            @if($evaluasi->c3_kehadiran < 80)
                <li><strong>Kehadiran:</strong> Perbaiki konsistensi kehadiran dan ketepatan waktu masuk kantor.</li>
            @endif

            @if($evaluasi->c4_pelanggaran > 0)
                <li><strong>Disiplin:</strong> Patuhi semua peraturan dan tata tertib yang berlaku untuk menghindari pelanggaran.</li>
            @endif

            @if($evaluasi->c5_terlambat > 2)
                <li><strong>Ketepatan Waktu:</strong> Tingkatkan manajemen waktu untuk mengurangi keterlambatan.</li>
            @endif

            <li><strong>Pengembangan Diri:</strong> Ikuti pelatihan dan workshop yang relevan dengan bidang kerja untuk meningkatkan kompetensi.</li>
            
            @if($evaluasi->total_skor >= $avgPeriode->avg_total ?? 0)
                <li><strong>Kontribusi Positif:</strong> Anda sudah memberikan kontribusi di atas rata-rata. Pertimbangkan untuk mengambil tanggung jawab lebih besar.</li>
            @endif
            
            <li><strong>Komunikasi:</strong> Tingkatkan komunikasi dengan atasan dan rekan kerja untuk koordinasi yang lebih baik.</li>
        </ul>
    </div>

    <!-- Performance Insights -->
    <div class="criteria-section">
        <h3>Analisis Kinerja</h3>
        
        <div style="background-color: #f1f5f9; padding: 12px; border-radius: 6px; margin-bottom: 10px;">
            <strong>Kekuatan Utama:</strong>
            @php
                $strengths = [];
                if ($evaluasi->c1_produktivitas >= 80) $strengths[] = 'Produktivitas Tinggi';
                if ($evaluasi->c2_tanggung_jawab >= 80) $strengths[] = 'Tanggung Jawab Tinggi';
                if ($evaluasi->c3_kehadiran >= 90) $strengths[] = 'Kehadiran Konsisten';
                if ($evaluasi->c4_pelanggaran == 0) $strengths[] = 'Disiplin Baik';
                if ($evaluasi->c5_terlambat <= 1) $strengths[] = 'Ketepatan Waktu';
                
                if (empty($strengths)) {
                    $strengths[] = 'Potensi untuk Berkembang';
                }
            @endphp
            {{ implode(', ', $strengths) }}
        </div>

        <div style="background-color: #fef2f2; padding: 12px; border-radius: 6px; margin-bottom: 10px;">
            <strong>Area yang Perlu Diperbaiki:</strong>
            @php
                $improvements = [];
                if ($evaluasi->c1_produktivitas < 70) $improvements[] = 'Produktivitas';
                if ($evaluasi->c2_tanggung_jawab < 70) $improvements[] = 'Tanggung Jawab';
                if ($evaluasi->c3_kehadiran < 80) $improvements[] = 'Kehadiran';
                if ($evaluasi->c4_pelanggaran > 0) $improvements[] = 'Kedisiplinan';
                if ($evaluasi->c5_terlambat > 2) $improvements[] = 'Ketepatan Waktu';
                
                if (empty($improvements)) {
                    $improvements[] = 'Pertahankan Kinerja Saat Ini';
                }
            @endphp
            {{ implode(', ', $improvements) }}
        </div>

        <div style="background-color: #ecfdf5; padding: 12px; border-radius: 6px;">
            <strong>Target Periode Berikutnya:</strong>
            @if($evaluasi->total_skor < 110)
                Mencapai kategori "Cukup" dengan target skor minimal 110
            @elseif($evaluasi->total_skor < 130)
                Mencapai kategori "Baik" dengan target skor minimal 130
            @elseif($evaluasi->total_skor < 150)
                Mencapai kategori "Sangat Baik" dengan target skor minimal 150
            @else
                Mempertahankan kategori "Sangat Baik" dan meningkatkan ranking
            @endif
        </div>
    </div>

    <!-- Metodologi Penilaian -->
    <div class="criteria-section">
        <h3>Metodologi Penilaian CPI (Composite Performance Index)</h3>
        
        <div style="font-size: 10px; line-height: 1.4;">
            <p><strong>Sistem Penilaian:</strong> Evaluasi menggunakan metode Composite Performance Index (CPI) yang menggabungkan 5 kriteria utama dengan pembobotan yang berbeda.</p>
            
            <div style="margin: 10px 0;">
                <strong>Bobot Kriteria:</strong>
                <ul style="margin: 5px 0; padding-left: 15px;">
                    <li>C1 - Produktivitas Kerja: 40% (Kriteria Utama)</li>
                    <li>C2 - Tanggung Jawab: 20%</li>
                    <li>C3 - Kehadiran: 20%</li>
                    <li>C4 - Pelanggaran Disiplin: 10%</li>
                    <li>C5 - Keterlambatan: 10%</li>
                </ul>
            </div>
            
            <div style="margin: 10px 0;">
                <strong>Kategori Kinerja:</strong>
                <ul style="margin: 5px 0; padding-left: 15px;">
                    <li><span style="color: #059669; font-weight: bold;">Sangat Baik:</span> Skor > 150</li>
                    <li><span style="color: #2563eb; font-weight: bold;">Baik:</span> Skor 130-150</li>
                    <li><span style="color: #d97706; font-weight: bold;">Cukup:</span> Skor 110-130</li>
                    <li><span style="color: #dc2626; font-weight: bold;">Kurang:</span> Skor < 110</li>
                </ul>
            </div>

            <p><strong>Catatan:</strong> Ranking dihitung berdasarkan total skor CPI dari seluruh pegawai pada periode yang sama. Semakin tinggi skor, semakin baik ranking yang diperoleh.</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Laporan Evaluasi Kinerja Pegawai</strong></p>
        <p>Digenerate pada: {{ $generated_at->format('d F Y, H:i:s') }} WIB</p>
        <p>Sistem Evaluasi Kinerja Pegawai - Kecamatan Cangkuang, Kabupaten Bandung</p>
        <br>
        <p style="font-size: 8px; color: #9ca3af;">
            Dokumen ini bersifat rahasia dan hanya untuk keperluan evaluasi kinerja internal.<br>
            Dilarang menyebarluaskan tanpa izin dari pihak yang berwenang.
        </p>
    </div>
</body>
</html>