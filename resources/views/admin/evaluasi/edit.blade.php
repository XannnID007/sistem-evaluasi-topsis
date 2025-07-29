@extends('layouts.app')

@section('title', 'Edit Evaluasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Evaluasi Kinerja</h2>
                <p class="text-gray-600 mt-1">Edit evaluasi kinerja untuk {{ $evaluasi->user->nama }}</p>
            </div>
            <a href="{{ route('admin.evaluasi.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('admin.evaluasi.update', $evaluasi->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Informasi Evaluasi -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Evaluasi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pegawai</label>
                            <div class="flex items-center p-3 bg-white border border-gray-300 rounded-lg">
                                <div class="h-10 w-10 bg-primary-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-medium text-sm">
                                        {{ strtoupper(substr($evaluasi->user->nama, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $evaluasi->user->nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $evaluasi->user->jabatan }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                            <div class="p-3 bg-white border border-gray-300 rounded-lg">
                                <p class="font-medium text-gray-900">{{ $evaluasi->periode->nama }}</p>
                                <p class="text-sm text-gray-500">{{ $evaluasi->periode->getFormattedTanggal() }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Skor Saat Ini</label>
                            <div class="p-3 bg-white border border-gray-300 rounded-lg">
                                <p class="text-2xl font-bold text-primary-600">{{ number_format($evaluasi->total_skor, 2) }}
                                </p>
                                <p class="text-sm text-gray-500">Ranking #{{ $evaluasi->ranking }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kriteria Evaluasi -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Penilaian Kriteria</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        <!-- C1 - Produktivitas Kerja -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-blue-500">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-blue-900">C1 - Produktivitas Kerja</h4>
                                    <p class="text-sm text-blue-700">Bobot: 40% (Tren Positif)</p>
                                </div>
                            </div>
                            <div>
                                <label for="c1_produktivitas" class="block text-sm font-medium text-blue-800 mb-2">
                                    Nilai (0-100) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="c1_produktivitas" name="c1_produktivitas"
                                    value="{{ old('c1_produktivitas', $evaluasi->c1_produktivitas) }}" min="0"
                                    max="100" step="0.01" required
                                    class="block w-full px-3 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('c1_produktivitas') border-red-500 @enderror">
                                @error('c1_produktivitas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-blue-600">
                                    Semakin tinggi nilai semakin baik
                                </p>
                            </div>
                        </div>

                        <!-- C2 - Tanggung Jawab -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-green-500">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-green-900">C2 - Tanggung Jawab</h4>
                                    <p class="text-sm text-green-700">Bobot: 20% (Tren Positif)</p>
                                </div>
                            </div>
                            <div>
                                <label for="c2_tanggung_jawab" class="block text-sm font-medium text-green-800 mb-2">
                                    Nilai (0-100) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="c2_tanggung_jawab" name="c2_tanggung_jawab"
                                    value="{{ old('c2_tanggung_jawab', $evaluasi->c2_tanggung_jawab) }}" min="0"
                                    max="100" step="0.01" required
                                    class="block w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('c2_tanggung_jawab') border-red-500 @enderror">
                                @error('c2_tanggung_jawab')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-green-600">
                                    Semakin tinggi nilai semakin baik
                                </p>
                            </div>
                        </div>

                        <!-- C3 - Kehadiran -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-purple-500">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-purple-900">C3 - Kehadiran</h4>
                                    <p class="text-sm text-purple-700">Bobot: 20% (Tren Positif)</p>
                                </div>
                            </div>
                            <div>
                                <label for="c3_kehadiran" class="block text-sm font-medium text-purple-800 mb-2">
                                    Nilai (0-100) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="c3_kehadiran" name="c3_kehadiran"
                                    value="{{ old('c3_kehadiran', $evaluasi->c3_kehadiran) }}" min="0"
                                    max="100" step="0.01" required
                                    class="block w-full px-3 py-2 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('c3_kehadiran') border-red-500 @enderror">
                                @error('c3_kehadiran')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-purple-600">
                                    Semakin tinggi nilai semakin baik
                                </p>
                            </div>
                        </div>

                        <!-- C4 - Pelanggaran Disiplin -->
                        <div
                            class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-orange-500">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-orange-900">C4 - Pelanggaran Disiplin</h4>
                                    <p class="text-sm text-orange-700">Bobot: 10% (Tren Negatif)</p>
                                </div>
                            </div>
                            <div>
                                <label for="c4_pelanggaran" class="block text-sm font-medium text-orange-800 mb-2">
                                    Jumlah Pelanggaran <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="c4_pelanggaran" name="c4_pelanggaran"
                                    value="{{ old('c4_pelanggaran', $evaluasi->c4_pelanggaran) }}" min="0"
                                    step="1" required
                                    class="block w-full px-3 py-2 border border-orange-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('c4_pelanggaran') border-red-500 @enderror">
                                @error('c4_pelanggaran')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-orange-600">
                                    Semakin rendah nilai semakin baik
                                </p>
                            </div>
                        </div>

                        <!-- C5 - Terlambat -->
                        <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-red-500">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-red-900">C5 - Terlambat</h4>
                                    <p class="text-sm text-red-700">Bobot: 10% (Tren Negatif)</p>
                                </div>
                            </div>
                            <div>
                                <label for="c5_terlambat" class="block text-sm font-medium text-red-800 mb-2">
                                    Jumlah Keterlambatan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="c5_terlambat" name="c5_terlambat"
                                    value="{{ old('c5_terlambat', $evaluasi->c5_terlambat) }}" min="0"
                                    step="1" required
                                    class="block w-full px-3 py-2 border border-red-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('c5_terlambat') border-red-500 @enderror">
                                @error('c5_terlambat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-red-600">
                                    Semakin rendah nilai semakin baik
                                </p>
                            </div>
                        </div>

                        <!-- Preview Skor (akan dihitung real-time) -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-gray-500">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-gray-900">Preview Skor CPI</h4>
                                    <p class="text-sm text-gray-700">Skor akan dihitung otomatis</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-gray-900" id="previewScore">-</p>
                                <p class="text-sm text-gray-500" id="previewCategory">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informasi Penilaian</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li><strong>Kriteria Positif (C1, C2, C3):</strong> Semakin tinggi nilai semakin baik
                                    </li>
                                    <li><strong>Kriteria Negatif (C4, C5):</strong> Semakin rendah nilai semakin baik</li>
                                    <li>Setelah update, ranking akan dihitung ulang secara otomatis untuk semua pegawai</li>
                                    <li>Perubahan ini akan mempengaruhi posisi ranking pegawai lainnya</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        <p>Evaluasi terakhir diperbarui: {{ $evaluasi->updated_at->format('d M Y H:i') }}</p>
                        <p>Dibuat oleh: {{ $evaluasi->creator->nama }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.evaluasi.index') }}"
                            class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Update Evaluasi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Real-time CPI calculation preview
            function calculatePreviewScore() {
                const c1 = parseFloat(document.getElementById('c1_produktivitas').value) || 0;
                const c2 = parseFloat(document.getElementById('c2_tanggung_jawab').value) || 0;
                const c3 = parseFloat(document.getElementById('c3_kehadiran').value) || 0;
                const c4 = parseFloat(document.getElementById('c4_pelanggaran').value) || 0;
                const c5 = parseFloat(document.getElementById('c5_terlambat').value) || 0;

                let totalScore = 0;

                // C1 - Produktivitas (40/3)
                totalScore += c1 * (40 / 3);

                // C2 - Tanggung Jawab (10)
                totalScore += c2 * 10;

                // C3 - Kehadiran (20/3)
                totalScore += c3 * (20 / 3);

                // C4 - Pelanggaran (negatif)
                if (c4 > 0) {
                    totalScore += Math.min(20 / c4, 10);
                }

                // C5 - Terlambat (negatif)
                if (c5 > 0) {
                    totalScore += Math.min(10 / c5, 10);
                }

                // Update preview
                document.getElementById('previewScore').textContent = totalScore.toFixed(2);

                // Update category
                let category = '';
                if (totalScore > 150) {
                    category = 'Sangat Baik';
                } else if (totalScore >= 130) {
                    category = 'Baik';
                } else if (totalScore >= 110) {
                    category = 'Cukup';
                } else {
                    category = 'Kurang';
                }
                document.getElementById('previewCategory').textContent = category;
            }

            // Add event listeners to all input fields
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = ['c1_produktivitas', 'c2_tanggung_jawab', 'c3_kehadiran', 'c4_pelanggaran',
                    'c5_terlambat'
                ];

                inputs.forEach(function(inputId) {
                    const input = document.getElementById(inputId);
                    if (input) {
                        input.addEventListener('input', calculatePreviewScore);
                        input.addEventListener('change', calculatePreviewScore);
                    }
                });

                // Calculate initial preview
                calculatePreviewScore();
            });

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const inputs = ['c1_produktivitas', 'c2_tanggung_jawab', 'c3_kehadiran', 'c4_pelanggaran',
                    'c5_terlambat'
                ];
                let isValid = true;

                inputs.forEach(function(inputId) {
                    const input = document.getElementById(inputId);
                    const value = parseFloat(input.value);

                    if (inputId.includes('c1_') || inputId.includes('c2_') || inputId.includes('c3_')) {
                        // Positive criteria: 0-100
                        if (value < 0 || value > 100) {
                            alert(`Nilai ${inputId.replace('_', ' ')} harus antara 0-100`);
                            isValid = false;
                            input.focus();
                            return false;
                        }
                    } else {
                        // Negative criteria: >= 0
                        if (value < 0) {
                            alert(`Nilai ${inputId.replace('_', ' ')} tidak boleh negatif`);
                            isValid = false;
                            input.focus();
                            return false;
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });
        </script>
    @endpush
@endsection
