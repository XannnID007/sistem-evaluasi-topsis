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

        <!-- Quick Export Section -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-lg bg-purple-500">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-purple-900">Export Cepat</h3>
                    <p class="text-sm text-purple-700">Export laporan langsung tanpa kustomisasi</p>
                </div>
            </div>

            <form id="quickExportForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="quick_periode" class="block text-sm font-medium text-purple-800 mb-2">Periode</label>
                    <select id="quick_periode" name="periode_id" required
                        class="block w-full px-3 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Pilih Periode</option>
                        @foreach ($periodeList as $periode)
                            <option value="{{ $periode->id }}">{{ $periode->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quick_jenis" class="block text-sm font-medium text-purple-800 mb-2">Jenis Laporan</label>
                    <select id="quick_jenis" name="jenis_laporan" required
                        class="block w-full px-3 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Pilih Jenis</option>
                        <option value="ranking">Laporan Ranking</option>
                        <option value="statistik">Laporan Statistik</option>
                        <option value="lengkap">Laporan Lengkap</option>
                    </select>
                </div>

                <div>
                    <label for="quick_format" class="block text-sm font-medium text-purple-800 mb-2">Format</label>
                    <select id="quick_format" name="format" required
                        class="block w-full px-3 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Pilih Format</option>
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="h-4 w-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3"></path>
                        </svg>
                        Export Sekarang
                    </button>
                </div>
            </form>
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
                <div class="mt-4 flex space-x-2">
                    <button onclick="generateQuickReport('ranking', 'pdf')"
                        class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-3 rounded-lg transition-colors text-sm">
                        PDF
                    </button>
                    <button onclick="generateQuickReport('ranking', 'excel')"
                        class="flex-1 bg-success-600 hover:bg-success-700 text-white font-medium py-2 px-3 rounded-lg transition-colors text-sm">
                        Excel
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
                <div class="mt-4 flex space-x-2">
                    <button onclick="generateQuickReport('statistik', 'pdf')"
                        class="flex-1 bg-success-600 hover:bg-success-700 text-white font-medium py-2 px-3 rounded-lg transition-colors text-sm">
                        PDF
                    </button>
                    <button onclick="generateQuickReport('statistik', 'excel')"
                        class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-3 rounded-lg transition-colors text-sm">
                        Excel
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
                <div class="mt-4 flex space-x-2">
                    <button onclick="generateQuickReport('lengkap', 'pdf')"
                        class="flex-1 bg-secondary-600 hover:bg-secondary-700 text-white font-medium py-2 px-3 rounded-lg transition-colors text-sm">
                        PDF
                    </button>
                    <button onclick="generateQuickReport('lengkap', 'excel')"
                        class="flex-1 bg-warning-600 hover:bg-warning-700 text-white font-medium py-2 px-3 rounded-lg transition-colors text-sm">
                        Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Advanced Export Options -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Export dengan Kustomisasi</h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Batch Export by Period -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-2 rounded-lg bg-blue-100">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m-7 9a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="ml-3 font-semibold text-gray-900">Export Berdasarkan Periode</h4>
                    </div>

                    <form id="batchExportForm">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Periode
                                    (Multiple)</label>
                                <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-3">
                                    @foreach ($periodeList as $periode)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="batch_periode[]" value="{{ $periode->id }}"
                                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">{{ $periode->nama }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                                    <select name="batch_jenis" required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                        <option value="ranking">Ranking</option>
                                        <option value="statistik">Statistik</option>
                                        <option value="lengkap">Lengkap</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                                    <select name="batch_format" required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                        <option value="pdf">PDF</option>
                                        <option value="excel">Excel</option>
                                        <option value="zip">ZIP (Gabungan)</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                Export Batch
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Custom Export Settings -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-2 rounded-lg bg-green-100">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h4 class="ml-3 font-semibold text-gray-900">Export Custom</h4>
                    </div>

                    <form id="customExportForm">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                                <select name="custom_periode" required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <option value="">Pilih Periode</option>
                                    @foreach ($periodeList as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kelas Jabatan</label>
                                <select name="custom_kelas"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <option value="">Semua Kelas</option>
                                    @for ($i = 17; $i >= 1; $i--)
                                        <option value="{{ $i }}">Kelas {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Range Ranking</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" name="custom_rank_start" placeholder="Dari" min="1"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <input type="number" name="custom_rank_end" placeholder="Sampai" min="1"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Konten Tambahan</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="custom_options[]" value="charts"
                                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Sertakan Grafik & Chart</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="custom_options[]" value="summary"
                                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Ringkasan Eksekutif</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="custom_options[]" value="recommendations"
                                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Rekomendasi</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="custom_options[]" value="detailed_analysis"
                                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Analisis Detail per Kriteria</span>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <button type="button" onclick="customExport('pdf')"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                                    Export PDF
                                </button>
                                <button type="button" onclick="customExport('excel')"
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                    Export Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Export History -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Export</h3>
                <button onclick="clearHistory()" class="text-sm text-gray-500 hover:text-red-600 transition-colors">
                    Bersihkan Riwayat
                </button>
            </div>

            <div id="exportHistory" class="space-y-3">
                <!-- History akan diisi oleh JavaScript -->
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <p class="mt-2">Belum ada riwayat export</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full mx-4">
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600 mx-auto"></div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Generating Laporan...</h3>
                <p class="mt-2 text-sm text-gray-500">Mohon tunggu, sedang memproses laporan Anda.</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Quick Export Form Handler
            document.getElementById('quickExportForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const data = Object.fromEntries(formData.entries());

                if (!data.periode_id || !data.jenis_laporan || !data.format) {
                    alert('Semua field harus diisi!');
                    return;
                }

                showLoading();
                exportReport(data);
            });

            // Batch Export Form Handler
            document.getElementById('batchExportForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const periods = formData.getAll('batch_periode[]');

                if (periods.length === 0) {
                    alert('Pilih minimal satu periode!');
                    return;
                }

                const data = {
                    type: 'batch',
                    periods: periods,
                    jenis_laporan: formData.get('batch_jenis'),
                    format: formData.get('batch_format')
                };

                showLoading();
                exportReport(data);
            });

            function generateQuickReport(jenis, format) {
                // Get active period or prompt user to select
                const aktivePeriode = @json($periodeList->where('status', 'aktif')->first());

                if (aktivePeriode) {
                    const data = {
                        periode_id: aktivePeriode.id,
                        jenis_laporan: jenis,
                        format: format,
                        include_chart: true
                    };

                    showLoading();
                    exportReport(data);
                } else {
                    // Show period selection modal
                    showPeriodSelection(jenis, format);
                }
            }

            function customExport(format) {
                const form = document.getElementById('customExportForm');
                const formData = new FormData(form);

                if (!formData.get('custom_periode')) {
                    alert('Periode harus dipilih!');
                    return;
                }

                const data = {
                    type: 'custom',
                    periode_id: formData.get('custom_periode'),
                    kelas_jabatan: formData.get('custom_kelas'),
                    rank_start: formData.get('custom_rank_start'),
                    rank_end: formData.get('custom_rank_end'),
                    options: formData.getAll('custom_options[]'),
                    format: format,
                    jenis_laporan: 'lengkap' // Default untuk custom export
                };

                showLoading();
                exportReport(data);
            }

            function exportReport(data) {
                // Simulate API call
                fetch('{{ route('admin.laporan.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.blob();
                        }
                        throw new Error('Export failed');
                    })
                    .then(blob => {
                        // Create download link
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;

                        // Generate filename
                        const timestamp = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
                        const filename = `Laporan_${data.jenis_laporan || 'Custom'}_${timestamp}.${data.format}`;
                        a.download = filename;

                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);

                        // Add to history
                        addToHistory({
                            filename: filename,
                            type: data.jenis_laporan || 'Custom',
                            format: data.format,
                            timestamp: new Date().toLocaleString('id-ID')
                        });

                        hideLoading();
                        showSuccessMessage('Laporan berhasil di-export!');
                    })
                    .catch(error => {
                        hideLoading();
                        showErrorMessage('Gagal export laporan: ' + error.message);
                    });
            }

            function showPeriodSelection(jenis, format) {
                const periodeList = @json($periodeList);

                const options = periodeList.map(periode =>
                    `<option value="${periode.id}">${periode.nama}</option>`
                ).join('');

                const selectHtml = `
                    <select id="periodSelect" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Pilih Periode</option>
                        ${options}
                    </select>
                `;

                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pilih Periode</h3>
                        ${selectHtml}
                        <div class="flex justify-end space-x-3 mt-6">
                            <button onclick="this.closest('.fixed').remove()" 
                                class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition-colors">
                                Batal
                            </button>
                            <button onclick="confirmPeriodSelection('${jenis}', '${format}')" 
                                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                Export
                            </button>
                        </div>
                    </div>
                `;

                document.body.appendChild(modal);
            }

            function confirmPeriodSelection(jenis, format) {
                const periodeId = document.getElementById('periodSelect').value;

                if (!periodeId) {
                    alert('Silakan pilih periode!');
                    return;
                }

                document.querySelector('.fixed').remove();

                const data = {
                    periode_id: periodeId,
                    jenis_laporan: jenis,
                    format: format,
                    include_chart: true
                };

                showLoading();
                exportReport(data);
            }

            function addToHistory(item) {
                let history = JSON.parse(localStorage.getItem('exportHistory') || '[]');
                history.unshift(item);

                // Keep only last 10 items
                if (history.length > 10) {
                    history = history.slice(0, 10);
                }

                localStorage.setItem('exportHistory', JSON.stringify(history));
                updateHistoryDisplay();
            }

            function updateHistoryDisplay() {
                const history = JSON.parse(localStorage.getItem('exportHistory') || '[]');
                const container = document.getElementById('exportHistory');

                if (history.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="mt-2">Belum ada riwayat export</p>
                        </div>
                    `;
                    return;
                }

                container.innerHTML = history.map(item => `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg ${getFormatColor(item.format)}">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">${item.filename}</p>
                                <p class="text-xs text-gray-500">${item.type} • ${item.format.toUpperCase()} • ${item.timestamp}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="redownload('${item.filename}')" 
                                class="text-primary-600 hover:text-primary-900 p-1 rounded hover:bg-primary-50" title="Download Ulang">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </button>
                            <button onclick="removeFromHistory('${item.filename}')" 
                                class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" title="Hapus">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `).join('');
            }

            function getFormatColor(format) {
                switch (format.toLowerCase()) {
                    case 'pdf':
                        return 'bg-red-500';
                    case 'excel':
                        return 'bg-green-500';
                    case 'zip':
                        return 'bg-purple-500';
                    default:
                        return 'bg-gray-500';
                }
            }

            function redownload(filename) {
                // In real implementation, this would fetch the file from server
                showInfoMessage('Fitur download ulang akan segera tersedia');
            }

            function removeFromHistory(filename) {
                let history = JSON.parse(localStorage.getItem('exportHistory') || '[]');
                history = history.filter(item => item.filename !== filename);
                localStorage.setItem('exportHistory', JSON.stringify(history));
                updateHistoryDisplay();
            }

            function clearHistory() {
                if (confirm('Apakah Anda yakin ingin menghapus semua riwayat export?')) {
                    localStorage.removeItem('exportHistory');
                    updateHistoryDisplay();
                }
            }

            function showSuccessMessage(message) {
                showToast(message, 'success');
            }

            function showErrorMessage(message) {
                showToast(message, 'error');
            }

            function showInfoMessage(message) {
                showToast(message, 'info');
            }

            function showToast(message, type) {
                const colors = {
                    success: 'bg-green-500',
                    error: 'bg-red-500',
                    info: 'bg-blue-500'
                };

                const toast = document.createElement('div');
                toast.className =
                    `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 translate-x-full`;
                toast.textContent = message;

                document.body.appendChild(toast);

                // Animate in
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);

                // Animate out and remove
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 3000);
            }

            // Initialize
            document.addEventListener('DOMContentLoaded', function() {
                updateHistoryDisplay();

                // Auto-submit quick export when all fields are filled
                const quickForm = document.getElementById('quickExportForm');
                const quickInputs = quickForm.querySelectorAll('select');

                quickInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        const formData = new FormData(quickForm);
                        const data = Object.fromEntries(formData.entries());

                        if (data.periode_id && data.jenis_laporan && data.format) {
                            // Auto-submit after short delay
                            setTimeout(() => {
                                if (quickForm.checkValidity()) {
                                    quickForm.dispatchEvent(new Event('submit'));
                                }
                            }, 500);
                        }
                    });
                });

                // Validate batch export periods
                const batchForm = document.getElementById('batchExportForm');
                const batchCheckboxes = batchForm.querySelectorAll('input[type="checkbox"]');

                batchCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const checked = batchForm.querySelectorAll('input[type="checkbox"]:checked');
                        const submitBtn = batchForm.querySelector('button[type="submit"]');

                        if (checked.length === 0) {
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        } else {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    });
                });

                // Validate custom export
                const customForm = document.getElementById('customExportForm');
                const customPeriode = customForm.querySelector('select[name="custom_periode"]');
                const customButtons = customForm.querySelectorAll('button[type="button"]');

                customPeriode.addEventListener('change', function() {
                    const isValid = this.value !== '';

                    customButtons.forEach(btn => {
                        if (isValid) {
                            btn.disabled = false;
                            btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        } else {
                            btn.disabled = true;
                            btn.classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    });
                });

                // Initialize button states
                customButtons.forEach(btn => {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                });

                batchForm.querySelector('button[type="submit"]').disabled = true;
                batchForm.querySelector('button[type="submit"]').classList.add('opacity-50', 'cursor-not-allowed');
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.key) {
                        case 'e':
                            e.preventDefault();
                            document.getElementById('quick_periode').focus();
                            break;
                        case 'g':
                            e.preventDefault();
                            window.location.href = '{{ route('admin.laporan.generate') }}';
                            break;
                    }
                }
            });
        </script>
    @endpush
@endsection
