@extends('layouts.app')

@section('title', 'Detail Evaluasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Evaluasi Kinerja</h2>
                <p class="text-gray-600 mt-1">{{ $evaluasi->periode->nama }}</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="downloadEvaluasi()"
                    class="inline-flex items-center px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Download PDF
                </button>
                <a href="{{ route('pegawai.evaluasi.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <!-- Ranking Badge -->
                        @php
                            $rankingColor = match (true) {
                                $evaluasi->ranking <= 3 => 'from-yellow-400 to-yellow-600',
                                $evaluasi->ranking <= 10 => 'from-blue-400 to-blue-600',
                                default => 'from-gray-400 to-gray-600',
                            };
                        @endphp
                        <div
                            class="mx-auto h-20 w-20 bg-gradient-to-br {{ $rankingColor }} rounded-full flex items-center justify-center mb-4">
                            <span class="text-white text-2xl font-bold">#{{ $evaluasi->ranking }}</span>
                        </div>

                        <!-- Score -->
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($evaluasi->total_skor, 2) }}</h3>
                        <p class="text-gray-600">Total Skor CPI</p>

                        <!-- Category -->
                        @php
                            $kategori = match (true) {
                                $evaluasi->total_skor > 150 => ['text' => 'Sangat Baik', 'color' => 'text-green-600'],
                                $evaluasi->total_skor >= 130 => ['text' => 'Baik', 'color' => 'text-blue-600'],
                                $evaluasi->total_skor >= 110 => ['text' => 'Cukup', 'color' => 'text-yellow-600'],
                                default => ['text' => 'Kurang', 'color' => 'text-red-600'],
                            };
                        @endphp
                        <p class="text-lg {{ $kategori['color'] }} font-semibold mt-2">{{ $kategori['text'] }}</p>
                    </div>

                    <!-- Period Info -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Periode</span>
                                <span class="font-medium">{{ $evaluasi->periode->nama }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal</span>
                                <span class="font-medium">{{ $evaluasi->periode->getFormattedTanggal() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dievaluasi</span>
                                <span class="font-medium">{{ $evaluasi->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Posisi dari</span>
                                <span class="font-medium">{{ $totalPegawai }} pegawai</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Persentil</span>
                                <span class="font-medium">{{ $persentil }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Perbandingan dengan Rata-rata</h4>
                    <div class="space-y-3">
                        @if ($avgPeriode)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Skor Saya</span>
                                <span
                                    class="font-bold text-primary-600">{{ number_format($evaluasi->total_skor, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Rata-rata Periode</span>
                                <span class="font-bold text-gray-600">{{ number_format($avgPeriode->avg_total, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t">
                                <span class="text-gray-600">Selisih</span>
                                @php $selisih = $evaluasi->total_skor - $avgPeriode->avg_total; @endphp
                                <span class="font-bold {{ $selisih >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $selisih >= 0 ? '+' : '' }}{{ number_format($selisih, 2) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Kriteria Breakdown -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6">Penilaian Per Kriteria</h4>
                    <div class="space-y-6">

                        <!-- C1 - Produktivitas Kerja -->
                        <div class="bg-primary-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-primary-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C1
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900">Produktivitas Kerja</h5>
                                        <p class="text-xs text-gray-600">Bobot: 40% (Tren Positif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-primary-600">
                                        {{ number_format($evaluasi->c1_produktivitas, 1) }}</p>
                                    @if ($avgPeriode)
                                        <p class="text-xs text-gray-600">Avg: {{ number_format($avgPeriode->avg_c1, 1) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full"
                                    style="width: {{ min(100, $evaluasi->c1_produktivitas) }}%"></div>
                            </div>
                        </div>

                        <!-- C2 - Tanggung Jawab -->
                        <div class="bg-success-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-success-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C2
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900">Tanggung Jawab</h5>
                                        <p class="text-xs text-gray-600">Bobot: 20% (Tren Positif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-success-600">
                                        {{ number_format($evaluasi->c2_tanggung_jawab, 1) }}</p>
                                    @if ($avgPeriode)
                                        <p class="text-xs text-gray-600">Avg: {{ number_format($avgPeriode->avg_c2, 1) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-success-500 h-2 rounded-full"
                                    style="width: {{ min(100, $evaluasi->c2_tanggung_jawab) }}%"></div>
                            </div>
                        </div>

                        <!-- C3 - Kehadiran -->
                        <div class="bg-secondary-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-secondary-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C3
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900">Kehadiran</h5>
                                        <p class="text-xs text-gray-600">Bobot: 20% (Tren Positif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-secondary-600">
                                        {{ number_format($evaluasi->c3_kehadiran, 1) }}</p>
                                    @if ($avgPeriode)
                                        <p class="text-xs text-gray-600">Avg: {{ number_format($avgPeriode->avg_c3, 1) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-secondary-500 h-2 rounded-full"
                                    style="width: {{ min(100, $evaluasi->c3_kehadiran) }}%"></div>
                            </div>
                        </div>

                        <!-- C4 - Pelanggaran Disiplin -->
                        <div class="bg-warning-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-warning-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C4
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900">Pelanggaran Disiplin</h5>
                                        <p class="text-xs text-gray-600">Bobot: 10% (Tren Negatif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-warning-600">{{ $evaluasi->c4_pelanggaran }}</p>
                                    <p class="text-xs text-gray-600">kali</p>
                                    @if ($avgPeriode)
                                        <p class="text-xs text-gray-600">Avg: {{ number_format($avgPeriode->avg_c4, 1) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs text-gray-600">Semakin sedikit semakin baik</p>
                        </div>

                        <!-- C5 - Keterlambatan -->
                        <div class="bg-danger-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-danger-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C5
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900">Keterlambatan</h5>
                                        <p class="text-xs text-gray-600">Bobot: 10% (Tren Negatif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-danger-600">{{ $evaluasi->c5_terlambat }}</p>
                                    <p class="text-xs text-gray-600">kali</p>
                                    @if ($avgPeriode)
                                        <p class="text-xs text-gray-600">Avg: {{ number_format($avgPeriode->avg_c5, 1) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs text-gray-600">Semakin sedikit semakin baik</p>
                        </div>
                    </div>
                </div>

                <!-- Radar Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6">Profil Kinerja</h4>
                    <div class="h-64">
                        <canvas id="radarChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Information & Tips -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi & Saran Perbaikan</h4>
                    <div class="space-y-4">
                        @if ($evaluasi->ranking <= 5)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">
                                            <strong>Selamat!</strong> Anda berada di peringkat {{ $evaluasi->ranking }}
                                            dengan kinerja yang sangat baik.
                                            Pertahankan konsistensi dan terus tingkatkan kualitas kerja Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($evaluasi->ranking <= 10)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            Kinerja Anda berada di peringkat {{ $evaluasi->ranking }} yang termasuk dalam
                                            kategori baik.
                                            Fokus pada peningkatan di area dengan nilai terendah untuk naik ke peringkat
                                            yang lebih tinggi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Ada ruang untuk perbaikan dalam kinerja Anda. Fokus pada konsistensi kehadiran,
                                            peningkatan produktivitas, dan mengurangi pelanggaran disiplin untuk hasil yang
                                            lebih baik.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Specific recommendations based on scores -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            @if ($evaluasi->c1_produktivitas < 70)
                                <div class="bg-gray-50 p-3 rounded">
                                    <h6 class="font-medium text-gray-900">Produktivitas Kerja</h6>
                                    <p class="text-gray-600">Tingkatkan efisiensi dan kualitas output pekerjaan</p>
                                </div>
                            @endif

                            @if ($evaluasi->c2_tanggung_jawab < 70)
                                <div class="bg-gray-50 p-3 rounded">
                                    <h6 class="font-medium text-gray-900">Tanggung Jawab</h6>
                                    <p class="text-gray-600">Perkuat komitmen dan akuntabilitas dalam tugas</p>
                                </div>
                            @endif

                            @if ($evaluasi->c3_kehadiran < 80)
                                <div class="bg-gray-50 p-3 rounded">
                                    <h6 class="font-medium text-gray-900">Kehadiran</h6>
                                    <p class="text-gray-600">Tingkatkan konsistensi kehadiran dan ketepatan waktu</p>
                                </div>
                            @endif

                            @if ($evaluasi->c4_pelanggaran > 0)
                                <div class="bg-gray-50 p-3 rounded">
                                    <h6 class="font-medium text-gray-900">Disiplin</h6>
                                    <p class="text-gray-600">Patuhi aturan dan regulasi yang berlaku</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Radar Chart
                const radarCtx = document.getElementById('radarChart').getContext('2d');

                const evaluasiData = {
                    produktivitas: {{ $evaluasi->c1_produktivitas }},
                    tanggungJawab: {{ $evaluasi->c2_tanggung_jawab }},
                    kehadiran: {{ $evaluasi->c3_kehadiran }},
                    disiplin: {{ 100 - $evaluasi->c4_pelanggaran * 10 }}, // Convert to positive scale
                    ketepatan: {{ 100 - $evaluasi->c5_terlambat * 10 }} // Convert to positive scale
                };

                @if ($avgPeriode)
                    const avgData = {
                        produktivitas: {{ $avgPeriode->avg_c1 }},
                        tanggungJawab: {{ $avgPeriode->avg_c2 }},
                        kehadiran: {{ $avgPeriode->avg_c3 }},
                        disiplin: {{ 100 - $avgPeriode->avg_c4 * 10 }},
                        ketepatan: {{ 100 - $avgPeriode->avg_c5 * 10 }}
                    };
                @endif

                new Chart(radarCtx, {
                    type: 'radar',
                    data: {
                        labels: ['Produktivitas', 'Tanggung Jawab', 'Kehadiran', 'Disiplin', 'Ketepatan'],
                        datasets: [{
                                label: 'Skor Anda',
                                data: Object.values(evaluasiData),
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 2,
                                pointBackgroundColor: '#3b82f6',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 5
                            }
                            @if ($avgPeriode)
                                , {
                                    label: 'Rata-rata Periode',
                                    data: Object.values(avgData),
                                    borderColor: '#6b7280',
                                    backgroundColor: 'rgba(107, 114, 128, 0.1)',
                                    borderWidth: 2,
                                    borderDash: [5, 5],
                                    pointBackgroundColor: '#6b7280',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4
                                }
                            @endif
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            r: {
                                beginAtZero: true,
                                max: 100,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                pointLabels: {
                                    font: {
                                        size: 12
                                    }
                                },
                                ticks: {
                                    stepSize: 20,
                                    font: {
                                        size: 10
                                    }
                                }
                            }
                        }
                    }
                });
            });

            function downloadEvaluasi() {
                window.location.href = '{{ route('pegawai.evaluasi.download', $evaluasi->id) }}';
            }
        </script>
    @endpush
@endsection
