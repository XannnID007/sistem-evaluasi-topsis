@extends('layouts.app')

@section('title', 'Laporan Evaluasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Export Laporan Evaluasi Kinerja</h2>
                <p class="text-gray-600 mt-1">Generate dan download laporan evaluasi kinerja pegawai</p>
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
                    <p class="text-sm text-purple-700">Export laporan langsung dengan periode aktif</p>
                </div>
            </div>

            <form id="quickExportForm" class="grid grid-cols-1 md:grid-cols-4 gap-4" method="POST"
                action="{{ route('admin.laporan.export') }}">
                @csrf
                <div>
                    <label for="quick_periode" class="block text-sm font-medium text-purple-800 mb-2">Periode</label>
                    <select id="quick_periode" name="periode_id" required
                        class="block w-full px-3 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Pilih Periode</option>
                        @foreach ($periodeList as $periode)
                            <option value="{{ $periode->id }}" {{ $periode->status === 'aktif' ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
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
            function generateQuickReport(jenis, format) {
                // Get active period or prompt user to select
                const aktivePeriode = @json($periodeList->where('status', 'aktif')->first());

                if (aktivePeriode) {
                    showLoading();

                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.laporan.export') }}';

                    // Add CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    // Add form data
                    const inputs = {
                        periode_id: aktivePeriode.id,
                        jenis_laporan: jenis,
                        format: format,
                        include_chart: 1
                    };

                    Object.keys(inputs).forEach(key => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = inputs[key];
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);

                    // Add to history
                    addToHistory({
                        filename: `Laporan_${jenis}_${aktivePeriode.nama}_${new Date().toISOString().slice(0, 10)}.${format}`,
                        type: jenis,
                        format: format,
                        timestamp: new Date().toLocaleString('id-ID')
                    });

                    setTimeout(() => {
                        hideLoading();
                    }, 2000);
                } else {
                    showPeriodSelection(jenis, format);
                }
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

                showLoading();

                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.laporan.export') }}';

                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                // Add form data
                const inputs = {
                    periode_id: periodeId,
                    jenis_laporan: jenis,
                    format: format,
                    include_chart: 1
                };

                Object.keys(inputs).forEach(key => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = inputs[key];
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);

                setTimeout(() => {
                    hideLoading();
                }, 2000);
            }

            function showLoading() {
                document.getElementById('loadingModal').classList.remove('hidden');
                document.getElementById('loadingModal').classList.add('flex');
            }

            function hideLoading() {
                document.getElementById('loadingModal').classList.add('hidden');
                document.getElementById('loadingModal').classList.remove('flex');
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
                    default:
                        return 'bg-gray-500';
                }
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

            function showToast(message, type = 'success') {
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

                // Handle form submissions with loading
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        const formData = new FormData(this);

                        // Check required fields
                        if (!formData.get('periode_id') || !formData.get('jenis_laporan') || !formData
                            .get('format')) {
                            e.preventDefault();
                            showToast('Mohon lengkapi semua field yang diperlukan!', 'error');
                            return;
                        }

                        showLoading();

                        // Add to history
                        const periode = this.querySelector('[name="periode_id"] option:checked')
                            ?.textContent || 'Unknown';
                        const jenis = formData.get('jenis_laporan');
                        const format = formData.get('format');

                        addToHistory({
                            filename: `Laporan_${jenis}_${periode}_${new Date().toISOString().slice(0, 10)}.${format}`,
                            type: jenis,
                            format: format,
                            timestamp: new Date().toLocaleString('id-ID')
                        });

                        // Hide loading after delay (form will submit)
                        setTimeout(() => {
                            hideLoading();
                        }, 2000);
                    });
                });

                // Validate forms in real time
                const requiredSelects = document.querySelectorAll('select[required]');
                requiredSelects.forEach(select => {
                    select.addEventListener('change', function() {
                        const form = this.closest('form');
                        const submitBtns = form.querySelectorAll('button[type="submit"]');

                        const periode = form.querySelector('[name="periode_id"]').value;
                        const jenis = form.querySelector('[name="jenis_laporan"]').value;
                        const format = form.querySelector('[name="format"]')?.value;

                        const isValid = periode && jenis && (format || form.id === 'customExportForm');

                        submitBtns.forEach(btn => {
                            if (isValid) {
                                btn.disabled = false;
                                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                            } else {
                                btn.disabled = true;
                                btn.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                        });
                    });
                });

                // Initial validation
                requiredSelects.forEach(select => {
                    select.dispatchEvent(new Event('change'));
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.key) {
                        case 'e':
                            e.preventDefault();
                            document.getElementById('quick_periode').focus();
                            break;
                    }
                }
            });
        </script>
    @endpush
@endsection
