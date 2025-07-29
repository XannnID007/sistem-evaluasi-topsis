@extends('layouts.app')

@section('title', 'Hasil & Ranking')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Hasil Evaluasi & Ranking</h2>
                <p class="text-gray-600 mt-1">
                    Lihat hasil evaluasi dan ranking kinerja pegawai
                    @if ($selectedPeriode)
                        - {{ $selectedPeriode->nama }}
                    @endif
                </p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('admin.hasil.comparison') }}"
                    class="inline-flex items-center px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    Perbandingan Periode
                </a>
                <a href="{{ route('admin.laporan.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Buat Laporan
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
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Evaluasi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalEvaluasi }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($rataRataSkor, 2) }}</p>
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
                        <p class="text-sm font-medium text-gray-600">Skor Tertinggi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($skorTertinggi, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-danger-100">
                        <svg class="h-6 w-6 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Skor Terendah</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($skorTerendah, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="GET" action="{{ route('admin.hasil.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Periode -->
                <div>
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-2">Periode Evaluasi</label>
                    <select id="periode_id" name="periode_id"
                        class="block w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Periode</option>
                        @foreach ($periodeList as $periode)
                            <option value="{{ $periode->id }}"
                                {{ request('periode_id') == $periode->id || (!request('periode_id') && $selectedPeriode && $selectedPeriode->id == $periode->id) ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kelas Jabatan -->
                <div>
                    <label for="kelas_jabatan" class="block text-sm font-medium text-gray-700 mb-2">Kelas Jabatan</label>
                    <select id="kelas_jabatan" name="kelas_jabatan"
                        class="block w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Kelas</option>
                        @for ($i = 17; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('kelas_jabatan') == $i ? 'selected' : '' }}>
                                Kelas {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Ranking Filter -->
                <div>
                    <label for="ranking_filter" class="block text-sm font-medium text-gray-700 mb-2">Filter Ranking</label>
                    <select id="ranking_filter" name="ranking_filter"
                        class="block w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Ranking</option>
                        <option value="top_5" {{ request('ranking_filter') == 'top_5' ? 'selected' : '' }}>Top 5</option>
                        <option value="top_10" {{ request('ranking_filter') == 'top_10' ? 'selected' : '' }}>Top 10
                        </option>
                        <option value="bottom_5" {{ request('ranking_filter') == 'bottom_5' ? 'selected' : '' }}>Bottom 5
                        </option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                        Filter Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Distribution Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Kinerja</h3>
                </div>
                <div class="h-64">
                    <canvas id="distributionChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Criteria Average Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Rata-rata Per Kriteria</h3>
                </div>
                <div class="h-64">
                    <canvas id="criteriaChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Ranking Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Ranking Kinerja Pegawai</h3>
                    <span class="text-sm text-gray-500">
                        Menampilkan {{ $evaluasiList->firstItem() ?? 0 }} - {{ $evaluasiList->lastItem() ?? 0 }}
                        dari {{ $evaluasiList->total() }} evaluasi
                    </span>
                </div>
            </div>

            @if ($evaluasiList->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ranking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pegawai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Skor</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    C1</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    C2</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    C3</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    C4</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    C5</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($evaluasiList as $evaluasi)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $rankingColor = match (true) {
                                                $evaluasi->ranking <= 3 => 'gold',
                                                $evaluasi->ranking <= 10 => 'silver',
                                                default => 'bronze',
                                            };
                                            $bgColor = match ($rankingColor) {
                                                'gold' => 'bg-yellow-100 text-yellow-800',
                                                'silver' => 'bg-gray-100 text-gray-800',
                                                'bronze' => 'bg-orange-100 text-orange-800',
                                            };
                                        @endphp
                                        <div class="flex items-center">
                                            @if ($evaluasi->ranking <= 3)
                                                <svg class="h-6 w-6 text-yellow-500 mr-2" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endif
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $bgColor }}">
                                                #{{ $evaluasi->ranking }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center">
                                                    <span class="text-white font-medium text-sm">
                                                        {{ strtoupper(substr($evaluasi->user->nama, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $evaluasi->user->nama }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $evaluasi->user->jabatan }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-gray-900">
                                            {{ number_format($evaluasi->total_skor, 2) }}</div>
                                        @php
                                            $scoreCategory = match (true) {
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
                                        <div class="text-xs {{ $scoreCategory['color'] }} font-medium">
                                            {{ $scoreCategory['text'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        {{ number_format($evaluasi->c1_produktivitas, 1) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        {{ number_format($evaluasi->c2_tanggung_jawab, 1) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        {{ number_format($evaluasi->c3_kehadiran, 1) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        {{ $evaluasi->c4_pelanggaran }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                        {{ $evaluasi->c5_terlambat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.hasil.show', $evaluasi->id) }}"
                                                class="text-primary-600 hover:text-primary-900 p-1 rounded hover:bg-primary-50"
                                                title="Detail">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.evaluasi.edit', $evaluasi->id) }}"
                                                class="text-yellow-600 hover:text-yellow-900 p-1 rounded hover:bg-yellow-50"
                                                title="Edit">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Data Evaluasi</h3>
                    <p class="mt-2 text-gray-500">Belum ada evaluasi untuk periode atau filter yang dipilih.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.evaluasi.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Input Evaluasi Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Distribution Chart
                const distributionCtx = document.getElementById('distributionChart').getContext('2d');
                const distributionData = @json(array_values($chartData['distribution'] ?? []));
                const distributionLabels = @json(array_keys($chartData['distribution'] ?? []));

                new Chart(distributionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: distributionLabels,
                        datasets: [{
                            data: distributionData,
                            backgroundColor: [
                                '#22c55e', // success-500
                                '#3b82f6', // primary-500
                                '#f59e0b', // warning-500
                                '#ef4444' // danger-500
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
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
                                        return `Rata-rata: ${context.parsed.y.toFixed(2)}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                max: 100,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
