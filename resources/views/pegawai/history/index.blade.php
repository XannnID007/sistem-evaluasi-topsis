@extends('layouts.app')

@section('title', 'History Evaluasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">History Evaluasi Kinerja</h2>
                <p class="text-gray-600 mt-1">Lihat riwayat lengkap evaluasi kinerja Anda dari waktu ke waktu</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('pegawai.history.comparison') }}"
                    class="inline-flex items-center px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    Bandingkan dengan Rekan
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-primary-100">
                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total History</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalHistory }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-success-100">
                        @php
                            $trendIcon = match ($trendSkor) {
                                'naik' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
                                'turun' => 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6',
                                default => 'M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            };
                            $trendColor = match ($trendSkor) {
                                'naik' => 'success',
                                'turun' => 'danger',
                                default => 'secondary',
                            };
                        @endphp
                        <div class="p-3 rounded-lg bg-{{ $trendColor }}-100">
                            <svg class="h-6 w-6 text-{{ $trendColor }}-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $trendIcon }}"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tren Skor</p>
                        <p class="text-lg font-bold text-{{ $trendColor }}-600">
                            {{ ucfirst($trendSkor) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-warning-100">
                        <svg class="h-6 w-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Konsistensi Ranking</p>
                        @php
                            $konsistensiText = match ($konsistensiRanking) {
                                'sangat_konsisten' => 'Sangat Baik',
                                'konsisten' => 'Baik',
                                'cukup_konsisten' => 'Cukup',
                                'tidak_konsisten' => 'Perlu Perbaikan',
                                default => 'Tidak Cukup Data',
                            };
                        @endphp
                        <p class="text-sm font-bold text-gray-900">{{ $konsistensiText }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-secondary-100">
                        <svg class="h-6 w-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m-7 9a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Periode Tersedia</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $tahunList->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="GET" action="{{ route('pegawai.history.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-64">
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Filter Tahun</label>
                    <select id="tahun" name="tahun"
                        class="block w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- History Timeline -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Timeline Evaluasi</h3>
                    <span class="text-sm text-gray-500">
                        Menampilkan {{ $historyList->firstItem() ?? 0 }} - {{ $historyList->lastItem() ?? 0 }}
                        dari {{ $historyList->total() }} evaluasi
                    </span>
                </div>
            </div>

            @if ($historyList->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach ($historyList as $evaluasi)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start space-x-4">
                                <!-- Timeline indicator -->
                                <div class="flex-shrink-0 mt-1">
                                    @php
                                        $rankingColor = match (true) {
                                            $evaluasi->ranking <= 3 => 'bg-yellow-500',
                                            $evaluasi->ranking <= 10 => 'bg-blue-500',
                                            default => 'bg-gray-500',
                                        };
                                    @endphp
                                    <div class="w-3 h-3 {{ $rankingColor }} rounded-full"></div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $evaluasi->periode->nama }}
                                            </h4>
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ $evaluasi->periode->getFormattedTanggal() }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <!-- Ranking Badge -->
                                            @php
                                                $rankingBadgeColor = match (true) {
                                                    $evaluasi->ranking <= 3 => 'bg-yellow-100 text-yellow-800',
                                                    $evaluasi->ranking <= 10 => 'bg-blue-100 text-blue-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $rankingBadgeColor }}">
                                                Ranking #{{ $evaluasi->ranking }}
                                            </span>

                                            <!-- Total Score -->
                                            <div class="text-right">
                                                <p class="text-2xl font-bold text-gray-900">
                                                    {{ number_format($evaluasi->total_skor, 2) }}</p>
                                                @php
                                                    $kategori = match (true) {
                                                        $evaluasi->total_skor > 150 => [
                                                            'text' => 'Sangat Baik',
                                                            'color' => 'text-green-600',
                                                        ],
                                                        $evaluasi->total_skor >= 130 => [
                                                            'text' => 'Baik',
                                                            'color' => 'text-blue-600',
                                                        ],
                                                        $evaluasi->total_skor >= 110 => [
                                                            'text' => 'Cukup',
                                                            'color' => 'text-yellow-600',
                                                        ],
                                                        default => ['text' => 'Kurang', 'color' => 'text-red-600'],
                                                    };
                                                @endphp
                                                <p class="text-sm {{ $kategori['color'] }} font-medium">
                                                    {{ $kategori['text'] }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Criteria Breakdown -->
                                    <div class="mt-4 grid grid-cols-2 md:grid-cols-5 gap-4">
                                        <div class="text-center p-3 bg-primary-50 rounded-lg">
                                            <p class="text-xs text-gray-600 mb-1">Produktivitas</p>
                                            <p class="text-lg font-bold text-primary-600">
                                                {{ number_format($evaluasi->c1_produktivitas, 1) }}</p>
                                        </div>
                                        <div class="text-center p-3 bg-success-50 rounded-lg">
                                            <p class="text-xs text-gray-600 mb-1">Tanggung Jawab</p>
                                            <p class="text-lg font-bold text-success-600">
                                                {{ number_format($evaluasi->c2_tanggung_jawab, 1) }}</p>
                                        </div>
                                        <div class="text-center p-3 bg-secondary-50 rounded-lg">
                                            <p class="text-xs text-gray-600 mb-1">Kehadiran</p>
                                            <p class="text-lg font-bold text-secondary-600">
                                                {{ number_format($evaluasi->c3_kehadiran, 1) }}</p>
                                        </div>
                                        <div class="text-center p-3 bg-warning-50 rounded-lg">
                                            <p class="text-xs text-gray-600 mb-1">Pelanggaran</p>
                                            <p class="text-lg font-bold text-warning-600">{{ $evaluasi->c4_pelanggaran }}
                                            </p>
                                        </div>
                                        <div class="text-center p-3 bg-danger-50 rounded-lg">
                                            <p class="text-xs text-gray-600 mb-1">Terlambat</p>
                                            <p class="text-lg font-bold text-danger-600">{{ $evaluasi->c5_terlambat }}</p>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="mt-4 flex items-center justify-between">
                                        <p class="text-xs text-gray-500">
                                            Dievaluasi pada {{ $evaluasi->created_at->format('d M Y H:i') }}
                                        </p>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('pegawai.evaluasi.show', $evaluasi->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Detail
                                            </a>
                                            <button onclick="downloadEvaluasi({{ $evaluasi->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-secondary-600 hover:bg-secondary-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                PDF
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $historyList->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada History</h3>
                    <p class="mt-2 text-gray-500">
                        @if (request('tahun'))
                            Tidak ada evaluasi untuk tahun yang dipilih.
                        @else
                            Anda belum memiliki history evaluasi kinerja.
                        @endif
                    </p>
                    @if (request('tahun'))
                        <div class="mt-6">
                            <a href="{{ route('pegawai.history.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                                Lihat Semua History
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Performance Trend Chart -->
        @if ($historyList->count() > 1)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Grafik Tren Kinerja</h3>
                <div class="h-80">
                    <canvas id="performanceHistoryChart" class="w-full h-full"></canvas>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <script>
            @if ($historyList->count() > 1)
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('performanceHistoryChart').getContext('2d');

                    const historyData = @json(
                        $historyList->map(function ($eval) {
                                return [
                                    'period' => $eval->periode->nama,
                                    'score' => $eval->total_skor,
                                    'ranking' => $eval->ranking,
                                    'date' => $eval->created_at->format('M Y'),
                                ];
                            })->reverse()->values());

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: historyData.map(d => d.date),
                            datasets: [{
                                    label: 'Skor Kinerja',
                                    data: historyData.map(d => d.score),
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#3b82f6',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 6,
                                    pointHoverRadius: 8,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Ranking',
                                    data: historyData.map(d => d.ranking),
                                    borderColor: '#f59e0b',
                                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                    borderWidth: 2,
                                    fill: false,
                                    tension: 0.4,
                                    pointBackgroundColor: '#f59e0b',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 5,
                                    pointHoverRadius: 7,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    cornerRadius: 8,
                                    callbacks: {
                                        title: function(context) {
                                            const dataIndex = context[0].dataIndex;
                                            return historyData[dataIndex].period;
                                        },
                                        label: function(context) {
                                            if (context.dataset.label === 'Skor Kinerja') {
                                                return `Skor: ${context.parsed.y.toFixed(2)}`;
                                            } else {
                                                return `Ranking: #${context.parsed.y}`;
                                            }
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Periode'
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Skor Kinerja'
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)'
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Ranking'
                                    },
                                    reverse: true, // Lower ranking number is better
                                    grid: {
                                        drawOnChartArea: false,
                                    },
                                }
                            }
                        }
                    });
                });
            @endif

            function downloadEvaluasi(evaluasiId) {
                window.location.href = `/pegawai/evaluasi/${evaluasiId}/download`;
            }
        </script>
    @endpush
@endsection
