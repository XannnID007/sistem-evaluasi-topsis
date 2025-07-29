@extends('layouts.app')

@section('title', 'Hasil Evaluasi Saya')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Hasil Evaluasi Saya</h2>
                <p class="text-gray-600 mt-1">Lihat hasil evaluasi kinerja Anda dari berbagai periode</p>
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
                        <p class="text-sm font-medium text-gray-600">Total Evaluasi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalEvaluasi ?? 0 }}</p>
                    </div>
                </div>
            </div>

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
                        <p class="text-sm font-medium text-gray-600">Ranking Terbaik</p>
                        <p class="text-2xl font-bold text-gray-900">#{{ $rankingTerbaik ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-secondary-100">
                        <svg class="h-6 w-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Skor Tertinggi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($skorTertinggi ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="GET" action="{{ route('pegawai.evaluasi.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-64">
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-2">Filter Periode</label>
                    <select id="periode_id" name="periode_id"
                        class="block w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        onchange="this.form.submit()">
                        <option value="">Semua Periode</option>
                        @foreach ($periodeList as $periode)
                            <option value="{{ $periode->id }}"
                                {{ request('periode_id') == $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Evaluasi List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Riwayat Evaluasi</h3>
            </div>

            @if ($evaluasiList->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach ($evaluasiList as $evaluasi)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-4">
                                        <!-- Ranking Badge -->
                                        <div class="flex-shrink-0">
                                            @php
                                                $rankingColor = match (true) {
                                                    $evaluasi->ranking <= 3 => 'bg-yellow-100 text-yellow-800',
                                                    $evaluasi->ranking <= 10 => 'bg-blue-100 text-blue-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $rankingColor }}">
                                                Ranking #{{ $evaluasi->ranking }}
                                            </span>
                                        </div>

                                        <!-- Periode Info -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $evaluasi->periode->nama }}
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $evaluasi->periode->getFormattedTanggal() }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Dievaluasi pada {{ $evaluasi->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Score Breakdown -->
                                    <div class="mt-4 grid grid-cols-2 md:grid-cols-5 gap-4">
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Produktivitas</p>
                                            <p class="text-lg font-bold text-primary-600">
                                                {{ number_format($evaluasi->c1_produktivitas, 1) }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Tanggung Jawab</p>
                                            <p class="text-lg font-bold text-success-600">
                                                {{ number_format($evaluasi->c2_tanggung_jawab, 1) }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Kehadiran</p>
                                            <p class="text-lg font-bold text-secondary-600">
                                                {{ number_format($evaluasi->c3_kehadiran, 1) }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Pelanggaran</p>
                                            <p class="text-lg font-bold text-warning-600">{{ $evaluasi->c4_pelanggaran }}
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Terlambat</p>
                                            <p class="text-lg font-bold text-danger-600">{{ $evaluasi->c5_terlambat }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Score & Actions -->
                                <div class="flex-shrink-0 text-right ml-6">
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Total Skor</p>
                                        <p class="text-3xl font-bold text-gray-900">
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
                                        <p class="text-sm {{ $kategori['color'] }} font-medium">{{ $kategori['text'] }}
                                        </p>
                                    </div>

                                    <!-- Actions -->
                                    <div class="space-y-2">
                                        <a href="{{ route('pegawai.evaluasi.show', $evaluasi->id) }}"
                                            class="block w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg text-center transition-colors">
                                            Lihat Detail
                                        </a>
                                        <button onclick="downloadEvaluasi({{ $evaluasi->id }})"
                                            class="block w-full px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white text-sm font-medium rounded-lg text-center transition-colors">
                                            Download PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $evaluasiList->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Evaluasi</h3>
                    <p class="mt-2 text-gray-500">
                        @if (request('periode_id'))
                            Tidak ada evaluasi untuk periode yang dipilih.
                        @else
                            Anda belum memiliki evaluasi kinerja.
                        @endif
                    </p>
                    @if (request('periode_id'))
                        <div class="mt-6">
                            <a href="{{ route('pegawai.evaluasi.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                                Lihat Semua Evaluasi
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Performance Overview -->
        @if (isset($evaluasiList) && $evaluasiList->count() > 1)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Tren Kinerja Saya</h3>
                <div class="h-64">
                    <canvas id="performanceTrendChart" class="w-full h-full"></canvas>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (isset($evaluasiList) && $evaluasiList->count() > 1)
                    const ctx = document.getElementById('performanceTrendChart').getContext('2d');

                    // Prepare data safely
                    const trendData = [];
                    @foreach ($evaluasiList as $eval)
                        trendData.push({
                            period: "{{ $eval->periode->nama }}",
                            score: {{ $eval->total_skor ?? 0 }},
                            ranking: {{ $eval->ranking ?? 0 }}
                        });
                    @endforeach

                    // Sort by date (reverse to show chronological order)
                    trendData.reverse();

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
                                            const dataIndex = context.dataIndex;
                                            const score = context.parsed.y.toFixed(2);
                                            const ranking = trendData[dataIndex].ranking;
                                            return [`Skor: ${score}`, `Ranking: #${ranking}`];
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
                            }
                        }
                    });
                @endif
            });

            function downloadEvaluasi(evaluasiId) {
                // Show loading state
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML = 'Downloading...';
                button.disabled = true;

                // Simulate download
                setTimeout(() => {
                    // In real implementation, this would be:
                    // window.location.href = `/pegawai/evaluasi/${evaluasiId}/download`;

                    // For now, just show alert
                    alert('Fitur download PDF akan segera tersedia!');

                    // Reset button state
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 1000);
            }
        </script>
    @endpush
@endsection
