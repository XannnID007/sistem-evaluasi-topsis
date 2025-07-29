@extends('layouts.app')

@section('title', 'Laporan Evaluasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Laporan Evaluasi Kinerja</h2>
                <p class="text-gray-600 mt-1">Generate dan kelola laporan evaluasi kinerja pegawai</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.laporan.generate') }}"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Generate Laporan Baru
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Laporan Ranking -->
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-primary-500">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-primary-900">Laporan Ranking</h3>
                        <p class="text-sm text-primary-700">Ranking kinerja pegawai berdasarkan periode</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button onclick="generateQuickReport('ranking')"
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Generate Sekarang
                    </button>
                </div>
            </div>

            <!-- Laporan Statistik -->
            <div class="bg-gradient-to-br from-success-50 to-success-100 border border-success-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-success-500">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-success-900">Laporan Statistik</h3>
                        <p class="text-sm text-success-700">Analisis statistik dan distribusi kinerja</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button onclick="generateQuickReport('statistik')"
                        class="w-full bg-success-600 hover:bg-success-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Generate Sekarang
                    </button>
                </div>
            </div>

            <!-- Laporan Lengkap -->
            <div class="bg-gradient-to-br from-secondary-50 to-secondary-100 border border-secondary-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-secondary-500">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-secondary-900">Laporan Lengkap</h3>
                        <p class="text-sm text-secondary-700">Laporan komprehensif dengan semua detail</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button onclick="generateQuickReport('lengkap')"
                        class="w-full bg-secondary-600 hover:bg-secondary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        Generate Sekarang
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Laporan Terbaru</h3>
                    <div class="flex items-center space-x-3">
                        <select id="filterPeriode" onchange="filterReports()"
                            class="px-3 py-1 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Semua Periode</option>
                            @foreach ($periodeList as $periode)
                                <option value="{{ $periode->id }}">{{ $periode->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Sample Recent Reports (Karena belum ada data real) -->
            <div class="divide-y divide-gray-200">
                @php
                    $sampleReports = [
                        [
                            'id' => 1,
                            'nama' => 'Laporan Ranking April 2025',
                            'jenis' => 'ranking',
                            'periode' => 'April 2025',
                            'format' => 'PDF',
                            'ukuran' => '1.2 MB',
                            'tanggal' => '2025-05-01 10:30:00',
                            'status' => 'completed',
                        ],
                        [
                            'id' => 2,
                            'nama' => 'Laporan Statistik April 2025',
                            'jenis' => 'statistik',
                            'periode' => 'April 2025',
                            'format' => 'Excel',
                            'ukuran' => '850 KB',
                            'tanggal' => '2025-05-01 09:15:00',
                            'status' => 'completed',
                        ],
                        [
                            'id' => 3,
                            'nama' => 'Laporan Lengkap Maret 2025',
                            'jenis' => 'lengkap',
                            'periode' => 'Maret 2025',
                            'format' => 'PDF',
                            'ukuran' => '2.8 MB',
                            'tanggal' => '2025-04-01 14:20:00',
                            'status' => 'completed',
                        ],
                    ];
                @endphp

                @forelse($sampleReports as $index => $report)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Report Icon -->
                                @php
                                    $iconColors = [
                                        'ranking' => 'bg-primary-100 text-primary-600',
                                        'statistik' => 'bg-success-100 text-success-600',
                                        'lengkap' => 'bg-secondary-100 text-secondary-600',
                                    ];
                                @endphp
                                <div class="p-3 rounded-lg {{ $iconColors[$report['jenis']] }}">
                                    @if ($report['jenis'] == 'ranking')
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                    @elseif($report['jenis'] == 'statistik')
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Report Info -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $report['nama'] }}</h4>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span class="text-sm text-gray-600">{{ $report['periode'] }}</span>
                                        <span class="text-sm text-gray-400">•</span>
                                        <span class="text-sm text-gray-600">{{ $report['format'] }}</span>
                                        <span class="text-sm text-gray-400">•</span>
                                        <span class="text-sm text-gray-600">{{ $report['ukuran'] }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Dibuat {{ \Carbon\Carbon::parse($report['tanggal'])->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <!-- Status Badge -->
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Selesai
                                </span>

                                <!-- Action Buttons -->
                                <div class="flex space-x-1">
                                    <button onclick="previewReport({{ $report['id'] }})"
                                        class="p-2 text-primary-600 hover:text-primary-900 hover:bg-primary-50 rounded-lg transition-colors"
                                        title="Preview">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button onclick="downloadReport({{ $report['id'] }})"
                                        class="p-2 text-success-600 hover:text-success-900 hover:bg-success-50 rounded-lg transition-colors"
                                        title="Download">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button onclick="shareReport({{ $report['id'] }})"
                                        class="p-2 text-secondary-600 hover:text-secondary-900 hover:bg-secondary-50 rounded-lg transition-colors"
                                        title="Share">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button onclick="deleteReport({{ $report['id'] }}, '{{ $report['nama'] }}')"
                                        class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Laporan</h3>
                        <p class="mt-2 text-gray-500">Mulai dengan generate laporan evaluasi kinerja pertama Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.laporan.generate') }}"
                                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Generate Laporan Pertama
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-primary-100">
                        <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600">Total Laporan</p>
                        <p class="text-lg font-bold text-gray-900">3</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-success-100">
                        <svg class="h-5 w-5 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600">Total Download</p>
                        <p class="text-lg font-bold text-gray-900">12</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-warning-100">
                        <svg class="h-5 w-5 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m-7 9a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600">Bulan Ini</p>
                        <p class="text-lg font-bold text-gray-900">2</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-secondary-100">
                        <svg class="h-5 w-5 text-secondary-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs font-medium text-gray-600">Ukuran Total</p>
                        <p class="text-lg font-bold text-gray-900">4.8 MB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Generate Modal -->
    <div id="quickGenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Generate Laporan Cepat</h3>
                    <button onclick="closeQuickGenerateModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="quickGenerateForm">
                    <div class="space-y-4">
                        <div>
                            <label for="quick_periode" class="block text-sm font-medium text-gray-700 mb-2">
                                Periode Evaluasi <span class="text-red-500">*</span>
                            </label>
                            <select id="quick_periode" name="periode_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Pilih Periode</option>
                                @foreach ($periodeList as $periode)
                                    <option value="{{ $periode->id }}">{{ $periode->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="quick_format" class="block text-sm font-medium text-gray-700 mb-2">
                                Format <span class="text-red-500">*</span>
                            </label>
                            <select id="quick_format" name="format" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="quick_include_chart" name="include_chart"
                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="quick_include_chart" class="ml-2 block text-sm text-gray-900">
                                Sertakan grafik dan chart
                            </label>
                        </div>

                        <input type="hidden" id="quick_jenis_laporan" name="jenis_laporan">
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeQuickGenerateModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                            Generate Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function generateQuickReport(jenis) {
                document.getElementById('quick_jenis_laporan').value = jenis;
                document.getElementById('quickGenerateModal').classList.remove('hidden');
                document.getElementById('quickGenerateModal').classList.add('flex');
            }

            function closeQuickGenerateModal() {
                document.getElementById('quickGenerateModal').classList.add('hidden');
                document.getElementById('quickGenerateModal').classList.remove('flex');
            }

            function previewReport(id) {
                // Implement preview functionality
                alert(`Preview laporan ID: ${id}`);
            }

            function downloadReport(id) {
                // Implement download functionality
                window.location.href = `/admin/laporan/${id}/download`;
            }

            function shareReport(id) {
                // Implement share functionality
                if (navigator.share) {
                    navigator.share({
                        title: 'Laporan Evaluasi Kinerja',
                        text: 'Bagikan laporan evaluasi kinerja',
                        url: window.location.origin + `/admin/laporan/${id}/download`
                    });
                } else {
                    // Fallback - copy to clipboard
                    const url = window.location.origin + `/admin/laporan/${id}/download`;
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link laporan berhasil disalin ke clipboard!');
                    });
                }
            }

            function deleteReport(id, nama) {
                if (confirm(`Apakah Anda yakin ingin menghapus laporan "${nama}"?`)) {
                    // Implement delete functionality
                    alert(`Hapus laporan ID: ${id}`);
                }
            }

            function filterReports() {
                const periodeId = document.getElementById('filterPeriode').value;
                // Implement filter functionality
                console.log('Filter by periode:', periodeId);
            }

            // Quick Generate Form Submit
            document.getElementById('quickGenerateForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const data = Object.fromEntries(formData.entries());

                // Validate required fields
                if (!data.periode_id) {
                    alert('Silakan pilih periode evaluasi!');
                    return;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Generating...';
                submitBtn.disabled = true;

                // Simulate API call
                setTimeout(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    closeQuickGenerateModal();

                    // Show success message
                    alert(`Laporan ${data.jenis_laporan} berhasil di-generate!`);

                    // Redirect to generate page with parameters
                    const params = new URLSearchParams(data);
                    window.location.href = `{{ route('admin.laporan.generate') }}?${params.toString()}`;
                }, 2000);
            });

            // Close modal when clicking outside
            document.getElementById('quickGenerateModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeQuickGenerateModal();
                }
            });
        </script>
    @endpush
@endsection
