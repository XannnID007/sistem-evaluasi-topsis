@extends('layouts.app')

@section('title', 'Tambah Kriteria')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Tambah Kriteria Baru</h2>
                <p class="text-gray-600 mt-1">Buat kriteria evaluasi baru untuk penilaian kinerja pegawai</p>
            </div>
            <a href="{{ route('admin.kriteria.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Sisa Bobot Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Sisa bobot yang tersedia:</strong> {{ number_format($sisaBobot * 100, 1) }}%
                        @if ($sisaBobot <= 0)
                            <span class="text-red-600">(Sudah mencapai 100%)</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('admin.kriteria.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Informasi Kriteria
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kode -->
                        <div>
                            <label for="kode" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Kriteria <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="kode" name="kode" value="{{ old('kode') }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kode') border-red-500 @enderror"
                                placeholder="Contoh: C1, C2, dst">
                            @error('kode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: C + angka (contoh: C1, C2)</p>
                        </div>

                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kriteria <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama') border-red-500 @enderror"
                                placeholder="Contoh: Produktivitas Kerja">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuration -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Konfigurasi Kriteria
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Bobot -->
                        <div>
                            <label for="bobot" class="block text-sm font-medium text-gray-700 mb-2">
                                Bobot (0.0 - 1.0) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="bobot" name="bobot" value="{{ old('bobot') }}" required
                                    min="0" max="{{ $sisaBobot }}" step="0.001"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('bobot') border-red-500 @enderror"
                                    placeholder="0.1" oninput="updateBobotPercentage()">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm" id="bobotPercentage">0%</span>
                                </div>
                            </div>
                            @error('bobot')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Maksimal: {{ number_format($sisaBobot, 3) }}
                                ({{ number_format($sisaBobot * 100, 1) }}%)</p>
                        </div>

                        <!-- Tren -->
                        <div>
                            <label for="tren" class="block text-sm font-medium text-gray-700 mb-2">
                                Tren Kriteria <span class="text-red-500">*</span>
                            </label>
                            <select id="tren" name="tren" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tren') border-red-500 @enderror">
                                <option value="">Pilih Tren</option>
                                <option value="positif" {{ old('tren') == 'positif' ? 'selected' : '' }}>Positif</option>
                                <option value="negatif" {{ old('tren') == 'negatif' ? 'selected' : '' }}>Negatif</option>
                            </select>
                            @error('tren')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('status') border-red-500 @enderror">
                                <option value="">Pilih Status</option>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Penjelasan Tren Kriteria:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <p class="font-medium text-green-700">Tren Positif:</p>
                            <p>Semakin tinggi nilai semakin baik</p>
                            <p class="text-xs italic">Contoh: Produktivitas, Kehadiran, Kualitas Kerja</p>
                        </div>
                        <div>
                            <p class="font-medium text-red-700">Tren Negatif:</p>
                            <p>Semakin rendah nilai semakin baik</p>
                            <p class="text-xs italic">Contoh: Pelanggaran, Keterlambatan, Error</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.kriteria.index') }}"
                        class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                        Simpan Kriteria
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateBobotPercentage() {
                const bobotInput = document.getElementById('bobot');
                const percentageSpan = document.getElementById('bobotPercentage');

                const bobot = parseFloat(bobotInput.value) || 0;
                const percentage = (bobot * 100).toFixed(1);

                percentageSpan.textContent = percentage + '%';
            }

            // Initialize percentage display
            document.addEventListener('DOMContentLoaded', function() {
                updateBobotPercentage();
            });
        </script>
    @endpush
@endsection
