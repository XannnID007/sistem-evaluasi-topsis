@extends('layouts.app')

@section('title', 'Generate Laporan')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Generate Laporan Evaluasi</h2>
                <p class="text-gray-600 mt-1">Buat laporan evaluasi kinerja pegawai dengan berbagai format dan jenis</p>
            </div>
            <a href="{{ route('admin.laporan.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('admin.laporan.store') }}" method="POST" class="p-6 space-y-6" id="generateForm">
                @csrf

                <!-- Jenis Laporan Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Pilih Jenis Laporan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Laporan Ranking -->
                        <div class="relative">
                            <input type="radio" id="ranking" name="jenis_laporan" value="ranking" class="sr-only peer"
                                {{ old('jenis_laporan', request('jenis_laporan')) == 'ranking' ? 'checked' : '' }}>
                            <label for="ranking"
                                class="flex flex-col items-center justify-center p-6 bg-white border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-primary-50 hover:border-primary-300 peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:text-primary-600 transition-all">
                                <div class="p-3 rounded-lg bg-primary-100 peer-checked:bg-primary-200 mb-4">
                                    <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 peer-checked:text-primary-600">Laporan
                                    Ranking</h4>
                                <p class="text-sm text-gray-600 text-center mt-2">
                                    Daftar ranking kinerja pegawai berdasarkan total skor CPI
                                </p>
                                <ul class="text-xs text-gray-500 mt-3 space-y-1">
                                    <li>• Ranking berdasarkan skor</li>
                                    <li>• Detail per pegawai</li>
                                    <li>• Informasi periode</li>
                                </ul>
                            </label>
                        </div>

                        <!-- Laporan Statistik -->
                        <div class="relative">
                            <input type="radio" id="statistik" name="jenis_laporan" value="statistik" class="sr-only peer"
                                {{ old('jenis_laporan', request('jenis_laporan')) == 'statistik' ? 'checked' : '' }}>
                            <label for="statistik"
                                class="flex flex-col items-center justify-center p-6 bg-white border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-success-50 hover:border-success-300 peer-checked:border-success-500 peer-checked:bg-success-50 peer-checked:text-success-600 transition-all">
                                <div class="p-3 rounded-lg bg-success-100 peer-checked:bg-success-200 mb-4">
                                    <svg class="h-8 w-8 text-success-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 peer-checked:text-success-600">Laporan
                                    Statistik</h4>
                                <p class="text-sm text-gray-600 text-center mt-2">
                                    Analisis statistik dan distribusi kinerja pegawai
                                </p>
                                <ul class="text-xs text-gray-500 mt-3 space-y-1">
                                    <li>• Rata-rata skor</li>
                                    <li>• Distribusi kinerja</li>
                                    <li>• Grafik dan chart</li>
                                </ul>
                            </label>
                        </div>

                        <!-- Laporan Lengkap -->
                        <div class="relative">
                            <input type="radio" id="lengkap" name="jenis_laporan" value="lengkap" class="sr-only peer"
                                {{ old('jenis_laporan', request('jenis_laporan')) == 'lengkap' ? 'checked' : '' }}>
                            <label for="lengkap"
                                class="flex flex-col items-center justify-center p-6 bg-white border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-secondary-50 hover:border-secondary-300 peer-checked:border-secondary-500 peer-checked:bg-secondary-50 peer-checked:text-secondary-600 transition-all">
                                <div class="p-3 rounded-lg bg-secondary-100 peer-checked:bg-secondary-200 mb-4">
                                    <svg class="h-8 w-8 text-secondary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 peer-checked:text-secondary-600">Laporan
                                    Lengkap</h4>
                                <p class="text-sm text-gray-600 text-center mt-2">
                                    Laporan komprehensif dengan semua detail evaluasi
                                </p>
                                <ul class="text-xs text-gray-500 mt-3 space-y-1">
                                    <li>• Ranking + Statistik</li>
                                    <li>• Detail per kriteria</li>
                                    <li>• Analisis mendalam</li>
                                </ul>
                            </label>
                        </div>
                    </div>
                    @error('jenis_laporan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Periode & Format Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Pengaturan Laporan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Periode -->
                        <div>
                            <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Periode Evaluasi <span class="text-red-500">*</span>
                            </label>
                            <select id="periode_id" name="periode_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('periode_id') border-red-500 @enderror">
                                <option value="">Pilih Periode Evaluasi</option>
                                @foreach ($periodeList as $periode)
                                    <option value="{{ $periode->id }}"
                                        {{ old('periode_id', request('periode_id')) == $periode->id ? 'selected' : '' }}>
                                        {{ $periode->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('periode_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Format -->
                        <div>
                            <label for="format" class="block text-sm font-medium text-gray-700 mb-2">
                                Format Output <span class="text-red-500">*</span>
                            </label>
                            <select id="format" name="format" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('format') border-red-500 @enderror">
                                <option value="">Pilih Format</option>
                                <option value="pdf"
                                    {{ old('format', request('format', 'pdf')) == 'pdf' ? 'selected' : '' }}>
                                    PDF - Portable Document Format
                                </option>
                                <option value="excel" {{ old('format', request('format')) == 'excel' ? 'selected' : '' }}>
                                    Excel - Microsoft Excel Spreadsheet
                                </option>
                            </select>
                            @error('format')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Opsi Tambahan -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Opsi Tambahan
                    </h3>
                    <div class="space-y-4">
                        <!-- Include Chart -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="include_chart" name="include_chart" type="checkbox" value="1"
                                    {{ old('include_chart', request('include_chart')) ? 'checked' : '' }}
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="include_chart" class="font-medium text-gray-700">Sertakan Grafik dan
                                    Chart</label>
                                <p class="text-gray-500">Menambahkan visualisasi data dalam bentuk grafik dan chart untuk
                                    analisis yang lebih mudah dipahami</p>
                            </div>
                        </div>

                        <!-- Include Summary -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="include_summary" name="include_summary" type="checkbox" value="1"
                                    checked
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="include_summary" class="font-medium text-gray-700">Sertakan Ringkasan
                                    Eksekutif</label>
                                <p class="text-gray-500">Menambahkan halaman ringkasan dengan poin-poin penting dari hasil
                                    evaluasi</p>
                            </div>
                        </div>

                        <!-- Include Recommendations -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="include_recommendations" name="include_recommendations" type="checkbox"
                                    value="1"
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="include_recommendations" class="font-medium text-gray-700">Sertakan
                                    Rekomendasi</label>
                                <p class="text-gray-500">Menambahkan saran dan rekomendasi untuk peningkatan kinerja
                                    berdasarkan hasil evaluasi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview Section -->
                <div id="previewSection" class="bg-gray-50 rounded-lg p-6" style="display: none;">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Preview Laporan</h4>
                    <div id="previewContent" class="text-sm text-gray-600">
                        <!-- Dynamic preview content will be loaded here -->
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <button type="button" onclick="showPreview()" id="previewBtn"
                        class="px-6 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                        Preview Laporan
                    </button>

                    <div class="flex space-x-3">
                        <a href="{{ route('admin.laporan.index') }}"
                            class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit" id="generateBtn"
                            class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Generate Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-blue-500">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-semibold text-blue-900">Format PDF</h4>
                        <p class="text-xs text-blue-700">Cocok untuk presentasi dan arsip dokumen resmi</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-green-500">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-semibold text-green-900">Format Excel</h4>
                        <p class="text-xs text-green-700">Ideal untuk analisis data dan perhitungan lebih lanjut</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-purple-500">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-semibold text-purple-900">Proses Cepat</h4>
                        <p class="text-xs text-purple-700">Generate laporan dalam hitungan detik</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showPreview() {
                const formData = new FormData(document.getElementById('generateForm'));
                const data = Object.fromEntries(formData.entries());

                // Validate required fields
                if (!data.jenis_laporan) {
                    alert('Silakan pilih jenis laporan terlebih dahulu!');
                    return;
                }

                if (!data.periode_id) {
                    alert('Silakan pilih periode evaluasi terlebih dahulu!');
                    return;
                }

                if (!data.format) {
                    alert('Silakan pilih format output terlebih dahulu!');
                    return;
                }

                // Show preview section
                const previewSection = document.getElementById('previewSection');
                const previewContent = document.getElementById('previewContent');

                previewSection.style.display = 'block';
                previewContent.innerHTML = generatePreviewContent(data);

                // Scroll to preview
                previewSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            function generatePreviewContent(data) {
                const periodeText = document.querySelector(`#periode_id option[value="${data.periode_id}"]`)?.textContent ||
                    'Periode tidak dipilih';
                const jenisText = data.jenis_laporan.charAt(0).toUpperCase() + data.jenis_laporan.slice(1);
                const formatText = data.format.toUpperCase();

                let previewHtml = `
                    <div class="bg-white rounded-lg border p-4 mb-4">
                        <h5 class="font-semibold text-gray-900 mb-2">Informasi Laporan</h5>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Jenis:</span>
                                <span class="text-gray-900">Laporan ${jenisText}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Periode:</span>
                                <span class="text-gray-900">${periodeText}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Format:</span>
                                <span class="text-gray-900">${formatText}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg border p-4 mb-4">
                        <h5 class="font-semibold text-gray-900 mb-2">Konten yang Akan Disertakan</h5>
                        <ul class="text-sm space-y-1">
                `;

                // Add content based on report type
                if (data.jenis_laporan === 'ranking') {
                    previewHtml += `
                        <li class="flex items-center"><svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Rata-rata skor dan distribusi kinerja</li>
                        <li class="flex items-center"><svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Analisis per kriteria evaluasi</li>
                        <li class="flex items-center"><svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Tren dan perbandingan data</li>
                    `;
                } else if (data.jenis_laporan === 'lengkap') {
                    previewHtml += `
                        <li class="flex items-center"><svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Gabungan laporan ranking dan statistik</li>
                        <li class="flex items-center"><svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Detail lengkap setiap pegawai</li>
                        <li class="flex items-center"><svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Analisis mendalam dan insight</li>
                    `;
                }

                // Add optional content
                if (data.include_chart) {
                    previewHtml +=
                        `<li class="flex items-center"><svg class="h-4 w-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Grafik dan chart visualisasi data</li>`;
                }

                if (data.include_summary) {
                    previewHtml +=
                        `<li class="flex items-center"><svg class="h-4 w-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Ringkasan eksekutif</li>`;
                }

                if (data.include_recommendations) {
                    previewHtml +=
                        `<li class="flex items-center"><svg class="h-4 w-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Rekomendasi peningkatan kinerja</li>`;
                }

                previewHtml += `
                        </ul>
                    </div>
                    
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Catatan:</strong> Preview ini hanya menampilkan struktur laporan. 
                                    Data aktual akan dimuat saat laporan di-generate.
                                </p>
                            </div>
                        </div>
                    </div>
                `;

                return previewHtml;
            }

            // Form submission with loading state
            document.getElementById('generateForm').addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('generateBtn');
                const originalText = submitBtn.innerHTML;

                // Show loading state
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Generating...
                `;
                submitBtn.disabled = true;

                // Note: The actual form will be submitted normally
                // This is just for UI feedback
            });

            // Auto-select options from URL parameters
            document.addEventListener('DOMContentLoaded', function() {
                const urlParams = new URLSearchParams(window.location.search);

                // Auto-check include_chart if specified
                if (urlParams.get('include_chart')) {
                    document.getElementById('include_chart').checked = true;
                }

                // Auto-fill form if coming from quick generate
                if (urlParams.get('jenis_laporan')) {
                    const jenisRadio = document.getElementById(urlParams.get('jenis_laporan'));
                    if (jenisRadio) {
                        jenisRadio.checked = true;
                    }
                }
            });

            // Real-time form validation
            function validateForm() {
                const jenis = document.querySelector('input[name="jenis_laporan"]:checked');
                const periode = document.getElementById('periode_id').value;
                const format = document.getElementById('format').value;

                const generateBtn = document.getElementById('generateBtn');
                const previewBtn = document.getElementById('previewBtn');

                const isValid = jenis && periode && format;

                generateBtn.disabled = !isValid;
                previewBtn.disabled = !isValid;

                if (!isValid) {
                    generateBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    previewBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    generateBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    previewBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // Add event listeners for real-time validation
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('generateForm');
                const inputs = form.querySelectorAll('input[type="radio"], select');

                inputs.forEach(input => {
                    input.addEventListener('change', validateForm);
                });

                // Initial validation
                validateForm();
            });
        </script>
    @endpush
@endsection
