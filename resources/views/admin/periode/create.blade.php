@extends('layouts.app')

@section('title', 'Tambah Periode Evaluasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Tambah Periode Evaluasi</h2>
                <p class="text-gray-600 mt-1">Buat periode evaluasi baru untuk penilaian kinerja pegawai</p>
            </div>
            <a href="{{ route('admin.periode.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('admin.periode.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Basic Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Informasi Periode
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Periode -->
                        <div class="md:col-span-2">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Periode <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama') border-red-500 @enderror"
                                placeholder="Contoh: Evaluasi Kinerja Januari 2025">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <select id="tahun" name="tahun" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tahun') border-red-500 @enderror"
                                onchange="updateNama()">
                                <option value="">Pilih Tahun</option>
                                @for ($year = 2020; $year <= 2030; $year++)
                                    <option value="{{ $year }}"
                                        {{ old('tahun', date('Y')) == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahun')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bulan -->
                        <div>
                            <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">
                                Bulan <span class="text-red-500">*</span>
                            </label>
                            <select id="bulan" name="bulan" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('bulan') border-red-500 @enderror"
                                onchange="updateNama(); updateTanggal()">
                                <option value="">Pilih Bulan</option>
                                @php
                                    $bulanList = [
                                        1 => 'Januari',
                                        2 => 'Februari',
                                        3 => 'Maret',
                                        4 => 'April',
                                        5 => 'Mei',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'Agustus',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Desember',
                                    ];
                                @endphp
                                @foreach ($bulanList as $num => $nama)
                                    <option value="{{ $num }}"
                                        {{ old('bulan', date('n')) == $num ? 'selected' : '' }}>
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bulan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Date Range Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Rentang Tanggal
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal Mulai -->
                        <div>
                            <label for="tgl_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tgl_mulai') border-red-500 @enderror"
                                onchange="validateDateRange()">
                            @error('tgl_mulai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Selesai -->
                        <div>
                            <label for="tgl_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="tgl_selesai" name="tgl_selesai" value="{{ old('tgl_selesai') }}"
                                required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('tgl_selesai') border-red-500 @enderror"
                                onchange="validateDateRange()">
                            @error('tgl_selesai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Durasi -->
                        <div class="md:col-span-2">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Durasi periode:</strong> <span id="durasi">-</span> hari
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Status Periode
                    </h3>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('status') border-red-500 @enderror">
                            <option value="">Pilih Status</option>
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="mt-2 text-xs text-gray-500">
                            <p><strong>Draft:</strong> Periode belum aktif, dapat diedit</p>
                            <p><strong>Aktif:</strong> Periode sedang berjalan, dapat digunakan untuk evaluasi</p>
                            <p><strong>Selesai:</strong> Periode telah selesai, tidak dapat diubah</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.periode.index') }}"
                        class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                        Simpan Periode
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const bulanNama = {
                1: 'Januari',
                2: 'Februari',
                3: 'Maret',
                4: 'April',
                5: 'Mei',
                6: 'Juni',
                7: 'Juli',
                8: 'Agustus',
                9: 'September',
                10: 'Oktober',
                11: 'November',
                12: 'Desember'
            };

            function updateNama() {
                const tahun = document.getElementById('tahun').value;
                const bulan = document.getElementById('bulan').value;
                const namaInput = document.getElementById('nama');

                if (tahun && bulan && bulanNama[bulan]) {
                    namaInput.value = `Evaluasi Kinerja ${bulanNama[bulan]} ${tahun}`;
                }
            }

            function updateTanggal() {
                const tahun = document.getElementById('tahun').value;
                const bulan = document.getElementById('bulan').value;

                if (tahun && bulan) {
                    // Set tanggal mulai ke tanggal 1 bulan tersebut
                    const tglMulai = `${tahun}-${bulan.toString().padStart(2, '0')}-01`;
                    document.getElementById('tgl_mulai').value = tglMulai;

                    // Set tanggal selesai ke tanggal terakhir bulan tersebut
                    const lastDay = new Date(tahun, bulan, 0).getDate();
                    const tglSelesai = `${tahun}-${bulan.toString().padStart(2, '0')}-${lastDay}`;
                    document.getElementById('tgl_selesai').value = tglSelesai;

                    validateDateRange();
                }
            }

            function validateDateRange() {
                const tglMulai = document.getElementById('tgl_mulai').value;
                const tglSelesai = document.getElementById('tgl_selesai').value;
                const durasiElement = document.getElementById('durasi');

                if (tglMulai && tglSelesai) {
                    const mulai = new Date(tglMulai);
                    const selesai = new Date(tglSelesai);

                    if (selesai >= mulai) {
                        const diffTime = selesai - mulai;
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                        durasiElement.textContent = diffDays;
                        durasiElement.classList.remove('text-red-600');
                        durasiElement.classList.add('text-blue-700');
                    } else {
                        durasiElement.textContent = 'Invalid';
                        durasiElement.classList.remove('text-blue-700');
                        durasiElement.classList.add('text-red-600');
                    }
                } else {
                    durasiElement.textContent = '-';
                }
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                updateNama();
                updateTanggal();
                validateDateRange();
            });
        </script>
    @endpush
@endsection
