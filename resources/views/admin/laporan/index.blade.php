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
    </div>

    <!-- Quick Generate Modal -->
    <div id="quickGenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Generate Laporan Cepat</h3>
                    <button onclick="closeQuickGenerateModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
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
