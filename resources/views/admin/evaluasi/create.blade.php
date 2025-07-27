@extends('layouts.app')

@section('title', 'Input Evaluasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Input Evaluasi Kinerja</h2>
                <p class="text-gray-600 mt-1">Input penilaian kinerja pegawai berdasarkan kriteria yang telah ditetapkan</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.evaluasi.bulk-create') }}"
                    class="inline-flex items-center px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Input Batch
                </a>
                <a href="{{ route('admin.evaluasi.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('admin.evaluasi.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Basic Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Informasi Dasar
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pegawai -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Pegawai <span class="text-red-500">*</span>
                            </label>
                            <select id="user_id" name="user_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('user_id') border-red-500 @enderror">
                                <option value="">Pilih Pegawai</option>
                                @foreach ($pegawaiList as $pegawai)
                                    <option value="{{ $pegawai->id }}"
                                        {{ old('user_id') == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->nama }} - {{ $pegawai->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Periode -->
                        <div>
                            <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Periode Evaluasi <span class="text-red-500">*</span>
                            </label>
                            <select id="periode_id" name="periode_id" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('periode_id') border-red-500 @enderror">
                                <option value="">Pilih Periode</option>
                                @foreach ($periodeList as $periode)
                                    <option value="{{ $periode->id }}"
                                        {{ old('periode_id') == $periode->id ? 'selected' : '' }}>
                                        {{ $periode->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('periode_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Kriteria Evaluasi Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Penilaian Kriteria
                    </h3>
                    <div class="space-y-6">

                        <!-- C1 - Produktivitas Kerja -->
                        <div class="bg-primary-50 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-primary-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C1
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">Produktivitas Kerja</h4>
                                        <p class="text-sm text-gray-600">Bobot: 40% (Tren Positif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-primary-600" id="c1_display">0</span>
                                    <p class="text-sm text-gray-600">dari 100</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label for="c1_produktivitas" class="block text-sm font-medium text-gray-700">
                                    Nilai Produktivitas Kerja <span class="text-red-500">*</span>
                                </label>
                                <input type="range" id="c1_produktivitas" name="c1_produktivitas" min="0"
                                    max="100" step="0.1" value="{{ old('c1_produktivitas', 0) }}"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider-primary"
                                    oninput="updateDisplay('c1', this.value)">
                                <input type="number" id="c1_input" min="0" max="100" step="0.1"
                                    value="{{ old('c1_produktivitas', 0) }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('c1_produktivitas') border-red-500 @enderror"
                                    placeholder="0-100" oninput="updateSlider('c1', this.value)">
                                @error('c1_produktivitas')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500">
                                    Penilaian tingkat produktivitas dalam menyelesaikan tugas dan tanggung jawab
                                </p>
                            </div>
                        </div>

                        <!-- C2 - Tanggung Jawab -->
                        <div class="bg-success-50 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-success-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C2
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">Tanggung Jawab</h4>
                                        <p class="text-sm text-gray-600">Bobot: 20% (Tren Positif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-success-600" id="c2_display">0</span>
                                    <p class="text-sm text-gray-600">dari 100</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label for="c2_tanggung_jawab" class="block text-sm font-medium text-gray-700">
                                    Nilai Tanggung Jawab <span class="text-red-500">*</span>
                                </label>
                                <input type="range" id="c2_tanggung_jawab" name="c2_tanggung_jawab" min="0"
                                    max="100" step="0.1" value="{{ old('c2_tanggung_jawab', 0) }}"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider-success"
                                    oninput="updateDisplay('c2', this.value)">
                                <input type="number" id="c2_input" min="0" max="100" step="0.1"
                                    value="{{ old('c2_tanggung_jawab', 0) }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-success-500 focus:border-success-500 @error('c2_tanggung_jawab') border-red-500 @enderror"
                                    placeholder="0-100" oninput="updateSlider('c2', this.value)">
                                @error('c2_tanggung_jawab')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500">
                                    Penilaian tingkat tanggung jawab dalam melaksanakan tugas dan kewajiban
                                </p>
                            </div>
                        </div>

                        <!-- C3 - Kehadiran -->
                        <div class="bg-secondary-50 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-secondary-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C3
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">Kehadiran</h4>
                                        <p class="text-sm text-gray-600">Bobot: 20% (Tren Positif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-secondary-600" id="c3_display">0</span>
                                    <p class="text-sm text-gray-600">dari 100</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label for="c3_kehadiran" class="block text-sm font-medium text-gray-700">
                                    Nilai Kehadiran <span class="text-red-500">*</span>
                                </label>
                                <input type="range" id="c3_kehadiran" name="c3_kehadiran" min="0"
                                    max="100" step="0.1" value="{{ old('c3_kehadiran', 0) }}"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider-secondary"
                                    oninput="updateDisplay('c3', this.value)">
                                <input type="number" id="c3_input" min="0" max="100" step="0.1"
                                    value="{{ old('c3_kehadiran', 0) }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:border-secondary-500 @error('c3_kehadiran') border-red-500 @enderror"
                                    placeholder="0-100" oninput="updateSlider('c3', this.value)">
                                @error('c3_kehadiran')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500">
                                    Penilaian tingkat kehadiran dan kedisiplinan waktu
                                </p>
                            </div>
                        </div>

                        <!-- C4 - Pelanggaran Disiplin -->
                        <div class="bg-warning-50 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-warning-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C4
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">Pelanggaran Disiplin</h4>
                                        <p class="text-sm text-gray-600">Bobot: 10% (Tren Negatif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-warning-600" id="c4_display">0</span>
                                    <p class="text-sm text-gray-600">kali</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label for="c4_pelanggaran" class="block text-sm font-medium text-gray-700">
                                    Jumlah Pelanggaran Disiplin <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="c4_pelanggaran" name="c4_pelanggaran" min="0"
                                    step="1" value="{{ old('c4_pelanggaran', 0) }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-warning-500 focus:border-warning-500 @error('c4_pelanggaran') border-red-500 @enderror"
                                    placeholder="0" oninput="updateDisplay('c4', this.value)">
                                @error('c4_pelanggaran')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500">
                                    Jumlah pelanggaran disiplin yang dilakukan dalam periode evaluasi (semakin sedikit
                                    semakin baik)
                                </p>
                            </div>
                        </div>

                        <!-- C5 - Terlambat -->
                        <div class="bg-danger-50 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-danger-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                                        C5
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">Keterlambatan</h4>
                                        <p class="text-sm text-gray-600">Bobot: 10% (Tren Negatif)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-bold text-danger-600" id="c5_display">0</span>
                                    <p class="text-sm text-gray-600">kali</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label for="c5_terlambat" class="block text-sm font-medium text-gray-700">
                                    Jumlah Keterlambatan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="c5_terlambat" name="c5_terlambat" min="0"
                                    step="1" value="{{ old('c5_terlambat', 0) }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-danger-500 focus:border-danger-500 @error('c5_terlambat') border-red-500 @enderror"
                                    placeholder="0" oninput="updateDisplay('c5', this.value)">
                                @error('c5_terlambat')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500">
                                    Jumlah keterlambatan dalam periode evaluasi (semakin sedikit semakin baik)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Penilaian</h3>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Produktivitas</p>
                            <p class="text-lg font-bold text-primary-600" id="summary_c1">0</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Tanggung Jawab</p>
                            <p class="text-lg font-bold text-success-600" id="summary_c2">0</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Kehadiran</p>
                            <p class="text-lg font-bold text-secondary-600" id="summary_c3">0</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Pelanggaran</p>
                            <p class="text-lg font-bold text-warning-600" id="summary_c4">0</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Terlambat</p>
                            <p class="text-lg font-bold text-danger-600" id="summary_c5">0</p>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-white rounded-lg border-2 border-primary-200">
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-2">Estimasi Skor CPI akan dihitung setelah data disimpan</p>
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="h-5 w-5 text-primary-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-xs text-gray-500">Skor CPI dihitung berdasarkan normalisasi nilai dan bobot
                                    kriteria</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.evaluasi.index') }}"
                        class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                        Simpan Evaluasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            /* Custom slider styles */
            .slider-primary::-webkit-slider-thumb {
                appearance: none;
                height: 20px;
                width: 20px;
                border-radius: 50%;
                background: #3b82f6;
                cursor: pointer;
                border: 2px solid #ffffff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .slider-success::-webkit-slider-thumb {
                appearance: none;
                height: 20px;
                width: 20px;
                border-radius: 50%;
                background: #22c55e;
                cursor: pointer;
                border: 2px solid #ffffff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .slider-secondary::-webkit-slider-thumb {
                appearance: none;
                height: 20px;
                width: 20px;
                border-radius: 50%;
                background: #0ea5e9;
                cursor: pointer;
                border: 2px solid #ffffff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .slider-primary::-webkit-slider-track {
                height: 8px;
                border-radius: 4px;
                background: linear-gradient(to right, #dbeafe 0%, #3b82f6 100%);
            }

            .slider-success::-webkit-slider-track {
                height: 8px;
                border-radius: 4px;
                background: linear-gradient(to right, #dcfce7 0%, #22c55e 100%);
            }

            .slider-secondary::-webkit-slider-track {
                height: 8px;
                border-radius: 4px;
                background: linear-gradient(to right, #e0f2fe 0%, #0ea5e9 100%);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Update display functions
            function updateDisplay(criteria, value) {
                const displayElement = document.getElementById(criteria + '_display');
                const summaryElement = document.getElementById('summary_' + criteria);
                const inputElement = document.getElementById(criteria + '_input') || document.getElementById(criteria + '_' +
                    getCriteriaName(criteria));

                // Update display value
                if (displayElement) {
                    displayElement.textContent = parseFloat(value).toFixed(1);
                }

                // Update summary
                if (summaryElement) {
                    summaryElement.textContent = parseFloat(value).toFixed(1);
                }

                // Sync input field
                if (inputElement && inputElement !== document.activeElement) {
                    inputElement.value = value;
                }

                // Update slider if this came from input
                const sliderElement = document.getElementById(criteria + '_' + getCriteriaName(criteria));
                if (sliderElement && sliderElement !== document.activeElement) {
                    sliderElement.value = value;
                }
            }

            function updateSlider(criteria, value) {
                const sliderElement = document.getElementById(criteria + '_' + getCriteriaName(criteria));
                if (sliderElement) {
                    sliderElement.value = value;
                }
                updateDisplay(criteria, value);
            }

            function getCriteriaName(criteria) {
                const names = {
                    'c1': 'produktivitas',
                    'c2': 'tanggung_jawab',
                    'c3': 'kehadiran',
                    'c4': 'pelanggaran',
                    'c5': 'terlambat'
                };
                return names[criteria];
            }

            // Initialize displays on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize all displays with current values
                ['c1', 'c2', 'c3', 'c4', 'c5'].forEach(criteria => {
                    const inputElement = document.getElementById(criteria + '_' + getCriteriaName(criteria));
                    if (inputElement) {
                        updateDisplay(criteria, inputElement.value);
                    }
                });

                // Add event listeners for input fields
                document.getElementById('c1_input').addEventListener('input', function() {
                    updateSlider('c1', this.value);
                });

                document.getElementById('c2_input').addEventListener('input', function() {
                    updateSlider('c2', this.value);
                });

                document.getElementById('c3_input').addEventListener('input', function() {
                    updateSlider('c3', this.value);
                });

                document.getElementById('c4_pelanggaran').addEventListener('input', function() {
                    updateDisplay('c4', this.value);
                });

                document.getElementById('c5_terlambat').addEventListener('input', function() {
                    updateDisplay('c5', this.value);
                });
            });

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const userId = document.getElementById('user_id').value;
                const periodeId = document.getElementById('periode_id').value;

                if (!userId) {
                    e.preventDefault();
                    alert('Silakan pilih pegawai yang akan dievaluasi!');
                    document.getElementById('user_id').focus();
                    return false;
                }

                if (!periodeId) {
                    e.preventDefault();
                    alert('Silakan pilih periode evaluasi!');
                    document.getElementById('periode_id').focus();
                    return false;
                }

                // Validate all criteria values
                const criteria = ['c1_produktivitas', 'c2_tanggung_jawab', 'c3_kehadiran', 'c4_pelanggaran',
                    'c5_terlambat'
                ];
                for (let criteriaName of criteria) {
                    const element = document.getElementById(criteriaName);
                    if (element && (element.value === '' || element.value < 0)) {
                        e.preventDefault();
                        alert('Silakan isi semua nilai kriteria dengan benar!');
                        element.focus();
                        return false;
                    }
                }
            });

            // Auto-save draft functionality (optional)
            function saveDraft() {
                const formData = new FormData(document.querySelector('form'));
                const data = Object.fromEntries(formData.entries());
                localStorage.setItem('evaluasi_draft', JSON.stringify(data));

                // Show saved indicator
                const saveIndicator = document.createElement('div');
                saveIndicator.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                saveIndicator.textContent = 'Draft tersimpan';
                document.body.appendChild(saveIndicator);

                setTimeout(() => {
                    saveIndicator.remove();
                }, 2000);
            }

            // Load draft on page load
            document.addEventListener('DOMContentLoaded', function() {
                const draft = localStorage.getItem('evaluasi_draft');
                if (draft && confirm('Ditemukan draft evaluasi tersimpan. Muat draft?')) {
                    const data = JSON.parse(draft);
                    Object.keys(data).forEach(key => {
                        const element = document.getElementById(key);
                        if (element) {
                            element.value = data[key];
                            if (key.startsWith('c')) {
                                const criteria = key.split('_')[0];
                                updateDisplay(criteria, data[key]);
                            }
                        }
                    });
                }
            });

            // Clear draft after successful submission
            window.addEventListener('beforeunload', function() {
                if (document.querySelector('form').checkValidity()) {
                    localStorage.removeItem('evaluasi_draft');
                }
            });
        </script>
    @endpush
@endsection
