@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">Selamat datang, {{ auth()->user()->nama }}!</h2>
                    <p class="text-primary-100 mt-2">{{ auth()->user()->jabatan }} - {{ auth()->user()->kelas_jabatan }}</p>
                    <p class="text-primary-200 text-sm mt-1">Lihat perkembangan kinerja Anda</p>
                </div>
                <div class="hidden md:block">
                    <div class="h-16 w-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold">{{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Evaluasi Terbaru -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-primary-100">
                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Skor Terbaru</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($skorTerbaru ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Ranking Terbaru -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-warning-100">
                        <svg class="h-6 w-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Ranking Terbaru</p>
                        <p class="text-2xl font-bold text-gray-900">#{{ $rankingTerbaru ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Skor -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-success-100">
                        <svg class="h-6 w-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Rata-rata Skor</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($rataSkor ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Evaluasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-secondary-100">
                        <svg class="h-6 w-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Evaluasi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalEvaluasi ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Performance Trend Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Tren Kinerja Saya</h3>
                    <div class="flex items-center space-x-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                            6 Bulan Terakhir
                        </span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="performanceTrendChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Kriteria Breakdown -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Evaluasi Per Kriteria</h3>
                    <span class="text-sm text-gray-500">Periode: {{ $periodeAktif ?? 'Juni 2025' }}</span>
                </div>

                @if ($evaluasiTerbaru)
                    <div class="space-y-4">
                        <!-- Produktivitas Kerja -->
                        <div class="flex items-center justify-between p-3 bg-primary-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-primary-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Produktivitas Kerja</p>
                                    <p class="text-xs text-gray-600">Bobot: 40%</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-primary-700">
                                    {{ number_format($evaluasiTerbaru->c1_produktivitas ?? 0, 1) }}</p>
                                <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-primary-500 h-1.5 rounded-full"
                                        style="width: {{ min(100, (($evaluasiTerbaru->c1_produktivitas ?? 0) / 100) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggung Jawab -->
                        <div class="flex items-center justify-between p-3 bg-success-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-success-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Tanggung Jawab</p>
                                    <p class="text-xs text-gray-600">Bobot: 20%</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-success-700">
                                    {{ number_format($evaluasiTerbaru->c2_tanggung_jawab ?? 0, 1) }}</p>
                                <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-success-500 h-1.5 rounded-full"
                                        style="width: {{ min(100, (($evaluasiTerbaru->c2_tanggung_jawab ?? 0) / 100) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kehadiran -->
                        <div class="flex items-center justify-between p-3 bg-secondary-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-secondary-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Kehadiran</p>
                                    <p class="text-xs text-gray-600">Bobot: 20%</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-secondary-700">
                                    {{ number_format($evaluasiTerbaru->c3_kehadiran ?? 0, 1) }}</p>
                                <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-secondary-500 h-1.5 rounded-full"
                                        style="width: {{ min(100, (($evaluasiTerbaru->c3_kehadiran ?? 0) / 100) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pelanggaran Disiplin -->
                        <div class="flex items-center justify-between p-3 bg-warning-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-warning-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Pelanggaran Disiplin</p>
                                    <p class="text-xs text-gray-600">Bobot: 10% (Negatif)</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-warning-700">
                                    {{ number_format($evaluasiTerbaru->c4_pelanggaran ?? 0, 0) }}</p>
                                <p class="text-xs text-gray-600">kali</p>
                            </div>
                        </div>

                        <!-- Keterlambatan -->
                        <div class="flex items-center justify-between p-3 bg-danger-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-danger-500 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Keterlambatan</p>
                                    <p class="text-xs text-gray-600">Bobot: 10% (Negatif)</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-danger-700">
                                    {{ number_format($evaluasiTerbaru->c5_terlambat ?? 0, 0) }}</p>
                                <p class="text-xs text-gray-600">kali</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Evaluasi</h3>
                        <p class="mt-2 text-gray-500">Evaluasi kinerja Anda belum tersedia untuk periode ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Activities and Quick Access -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- History Evaluasi -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">History Evaluasi Terbaru</h3>
                    <a href="{{ route('pegawai.history.index') }}"
                        class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                        Lihat Semua
                    </a>
                </div>

                @if ($historyEvaluasi && $historyEvaluasi->count() > 0)
                    <div class="space-y-4">
                        @foreach ($historyEvaluasi as $evaluasi)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @php
                                            $rankingColor = match (true) {
                                                $evaluasi->ranking <= 3 => 'success',
                                                $evaluasi->ranking <= 7 => 'warning',
                                                default => 'gray',
                                            };
                                        @endphp
                                        <div
                                            class="h-10 w-10 bg-{{ $rankingColor }}-100 rounded-full flex items-center justify-center">
                                            <span
                                                class="text-{{ $rankingColor }}-600 font-bold text-sm">#{{ $evaluasi->ranking }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $evaluasi->periode->nama }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($evaluasi->periode->tgl_mulai)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($evaluasi->periode->tgl_selesai)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-900">
                                        {{ number_format($evaluasi->total_skor, 2) }}</p>
                                    <p class="text-sm text-gray-500">Total Skor</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada History</h3>
                        <p class="mt-2 text-gray-500">History evaluasi Anda akan muncul di sini setelah ada evaluasi.</p>
                    </div>
                @endif
            </div>

            <!-- Quick Access -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Akses Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('pegawai.evaluasi.index') }}"
                        class="flex items-center p-3 text-left w-full bg-primary-50 hover:bg-primary-100 rounded-lg transition-colors group">
                        <div class="p-2 bg-primary-500 rounded-lg group-hover:bg-primary-600 transition-colors">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Hasil Evaluasi Saya</p>
                            <p class="text-xs text-gray-600">Lihat detail evaluasi terbaru</p>
                        </div>
                    </a>

                    <a href="{{ route('pegawai.history.index') }}"
                        class="flex items-center p-3 text-left w-full bg-secondary-50 hover:bg-secondary-100 rounded-lg transition-colors group">
                        <div class="p-2 bg-secondary-500 rounded-lg group-hover:bg-secondary-600 transition-colors">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">History Evaluasi</p>
                            <p class="text-xs text-gray-600">Lihat riwayat evaluasi lengkap</p>
                        </div>
                    </a>

                    <a href="{{ route('profile.index') }}"
                        class="flex items-center p-3 text-left w-full bg-success-50 hover:bg-success-100 rounded-lg transition-colors group">
                        <div class="p-2 bg-success-500 rounded-lg group-hover:bg-success-600 transition-colors">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Update Profile</p>
                            <p class="text-xs text-gray-600">Perbarui informasi pribadi</p>
                        </div>
                    </a>

                    @if ($evaluasiTerbaru)
                        <button onclick="downloadReport()"
                            class="flex items-center p-3 text-left w-full bg-warning-50 hover:bg-warning-100 rounded-lg transition-colors group">
                            <div class="p-2 bg-warning-500 rounded-lg group-hover:bg-warning-600 transition-colors">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Download Laporan</p>
                                <p class="text-xs text-gray-600">Export evaluasi ke PDF</p>
                            </div>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Performance Trend Chart
                const ctx = document.getElementById('performanceTrendChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: trendData.map(d => d.period),
                        datasets: [{
                            label: 'Skor Kinerja',
                            data: trendData.map(d => d.score),
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return `Skor: ${context.parsed.y.toFixed(2)}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            y: {
                                beginAtZero: false,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        elements: {
                            point: {
                                hoverBackgroundColor: '#1d4ed8'
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
