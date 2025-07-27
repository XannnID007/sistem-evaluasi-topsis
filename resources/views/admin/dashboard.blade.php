@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">Selamat datang, {{ auth()->user()->nama }}!</h2>
                    <p class="text-primary-100 mt-2">Kelola evaluasi kinerja pegawai Kecamatan Cangkuang</p>
                </div>
                <div class="hidden md:block">
                    <svg class="h-16 w-16 text-primary-200" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Pegawai -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-primary-100">
                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pegawai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalPegawai ?? 21 }}</p>
                    </div>
                </div>
            </div>

            <!-- Evaluasi Selesai -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-success-100">
                        <svg class="h-6 w-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Evaluasi Selesai</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $evaluasiSelesai ?? 18 }}</p>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Skor -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-secondary-100">
                        <svg class="h-6 w-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Rata-rata Skor</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($rataSkor ?? 142.5, 1) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Ranking Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Top 5 Pegawai Terbaik</h3>
                    <button class="text-primary-600 hover:text-primary-700 text-sm font-medium">Lihat Semua</button>
                </div>
                <div class="space-y-4">
                    <div
                        class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200">
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 bg-yellow-500 text-white rounded-full text-sm font-bold">1</span>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Hari Sumarhadi, S.A.P.</p>
                                <p class="text-sm text-gray-600">Staff Administrasi</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-yellow-700">156.0</span>
                    </div>

                    <div
                        class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200">
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 bg-gray-400 text-white rounded-full text-sm font-bold">2</span>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Agus Mulya, S.PT., MM</p>
                                <p class="text-sm text-gray-600">Kepala Seksi</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-gray-700">150.3</span>
                    </div>

                    <div
                        class="flex items-center justify-between p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg border border-orange-200">
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 bg-orange-500 text-white rounded-full text-sm font-bold">3</span>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Andri Yudha Prawira, S.I.P., M.SI.</p>
                                <p class="text-sm text-gray-600">Staff Pelayanan</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-orange-700">149.3</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-700 rounded-full text-sm font-bold">4</span>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Siti Noviyanti S.Sos, M.K.P</p>
                                <p class="text-sm text-gray-600">Staff Administrasi</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-gray-600">136.0</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-700 rounded-full text-sm font-bold">5</span>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Rahmat Hidayat, SH</p>
                                <p class="text-sm text-gray-600">Staff Pelayanan</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-gray-600">136.5</span>
                    </div>
                </div>
            </div>

            <!-- Performance Distribution Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Kinerja</h3>
                </div>
                <div class="space-y-6">
                    <!-- Chart Placeholder -->
                    <div
                        class="h-48 bg-gradient-to-br from-primary-50 to-secondary-50 rounded-lg flex items-center justify-center">
                        <canvas id="performanceChart" class="w-full h-full"></canvas>
                    </div>

                    <!-- Legend -->
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-success-500 rounded-full mr-2"></div>
                            <span class="text-gray-700">Sangat Baik (>150)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-primary-500 rounded-full mr-2"></div>
                            <span class="text-gray-700">Baik (130-150)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-warning-500 rounded-full mr-2"></div>
                            <span class="text-gray-700">Cukup (110-130)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-danger-500 rounded-full mr-2"></div>
                            <span class="text-gray-700">Kurang (<110)< /span>
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
                // Performance Distribution Chart
                const ctx = document.getElementById('performanceChart').getContext('2d');

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'],
                        datasets: [{
                            data: [3, 12, 5, 1], // Sample data
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
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} pegawai (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '60%',
                        elements: {
                            arc: {
                                borderRadius: 8
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
