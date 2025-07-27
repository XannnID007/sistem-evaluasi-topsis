@extends('layouts.app')

@section('title', 'Edit Kriteria')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Kriteria</h2>
                <p class="text-gray-600 mt-1">Perbarui kriteria: {{ $kriteria->nama }}</p>
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
                        <br><small>Bobot saat ini: {{ $kriteria->getFormattedBobot() }}</small>
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('admin.kriteria.update', $kriteria->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

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
                            <input type="text" id="kode" name="kode" value="{{ old('kode', $kriteria->kode) }}"
                                required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kode') border-red-500 @enderror">
                            @error('kode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kriteria <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $kriteria->nama) }}"
                                required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama') border-red-500 @enderror">
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
                                <input type="number" id="bobot" name="bobot"
                                    value="{{ old('bobot', $kriteria->bobot) }}" required min="0"
                                    max="{{ $sisaBobot + $kriteria->bobot }}" step="0.001"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('bobot') border-red-500 @enderror"
                                    oninput="updateBobotPercentage()">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm"
                                        id="bobotPercentage">{{ $kriteria->getFormattedBobot() }}</span>
                                </div>
                            </div>
                            @error('bobot')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Maksimal:
                                {{ number_format($sisaBobot + $kriteria->bobot, 3) }}</p>
                        </div>

                        <!-- Tren -->
                        <div>
                            <label for="tren" class="block text-sm font-medium text-gray-700 mb-2">
                                Tren Kriteria <span class="text-red-500">*</span>
                            </label>
                            <select id="tren" name="tren" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tren') border-red-500 @enderror">
                                <option value="">Pilih Tren</option>
                                <option value="positif" {{ old('tren', $kriteria->tren) == 'positif' ? 'selected' : '' }}>
                                    Positif</option>
                                <option value="negatif" {{ old('tren', $kriteria->tren) == 'negatif' ? 'selected' : '' }}>
                                    Negatif</option>
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
                                <option value="aktif" {{ old('status', $kriteria->status) == 'aktif' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="nonaktif"
                                    {{ old('status', $kriteria->status) == 'nonaktif' ? 'selected' : '' }}>Non-aktif
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                        Simpan Perubahan
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
        </script>
    @endpush
@endsection
