@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Data Pegawai</h2>
                <p class="text-gray-600 mt-1">Perbarui informasi pegawai: {{ $pegawai->nama }}</p>
            </div>
            <a href="{{ route('admin.pegawai.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Personal Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Informasi Personal
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $pegawai->nama) }}"
                                required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama') border-red-500 @enderror">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $pegawai->email) }}"
                                required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="username" name="username"
                                value="{{ old('username', $pegawai->username) }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('username') border-red-500 @enderror">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div>
                            <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" id="telepon" name="telepon"
                                value="{{ old('telepon', $pegawai->telepon) }}"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('telepon') border-red-500 @enderror">
                            @error('telepon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $pegawai->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Job Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Informasi Jabatan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Jabatan -->
                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Jabatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="jabatan" name="jabatan"
                                value="{{ old('jabatan', $pegawai->jabatan) }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('jabatan') border-red-500 @enderror">
                            @error('jabatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelas Jabatan - DIPERBAIKI -->
                        <div>
                            <label for="kelas_jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelas Jabatan <span class="text-red-500">*</span>
                            </label>
                            <select id="kelas_jabatan" name="kelas_jabatan" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kelas_jabatan') border-red-500 @enderror">
                                <option value="">Pilih Kelas Jabatan</option>
                                <option value="17"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 17 ? 'selected' : '' }}>Kelas 17
                                    (Eselon I)</option>
                                <option value="16"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 16 ? 'selected' : '' }}>Kelas 16
                                    (Eselon II.a)</option>
                                <option value="15"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 15 ? 'selected' : '' }}>Kelas 15
                                    (Eselon II.b)</option>
                                <option value="14"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 14 ? 'selected' : '' }}>Kelas 14
                                    (Eselon III.a)</option>
                                <option value="13"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 13 ? 'selected' : '' }}>Kelas 13
                                    (Eselon III.b)</option>
                                <option value="12"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 12 ? 'selected' : '' }}>Kelas 12
                                    (Eselon IV.a/Camat)</option>
                                <option value="11"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 11 ? 'selected' : '' }}>Kelas 11
                                    (Eselon IV.b/Sekretaris)</option>
                                <option value="10"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 10 ? 'selected' : '' }}>Kelas 10
                                    (Fungsional Ahli Utama)</option>
                                <option value="9"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 9 ? 'selected' : '' }}>Kelas 9
                                    (Fungsional Ahli Madya)</option>
                                <option value="8"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 8 ? 'selected' : '' }}>Kelas 8
                                    (Fungsional Ahli Muda)</option>
                                <option value="7"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 7 ? 'selected' : '' }}>Kelas 7
                                    (Fungsional Ahli Pertama)</option>
                                <option value="6"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 6 ? 'selected' : '' }}>Kelas 6
                                    (Fungsional Terampil Penyelia)</option>
                                <option value="5"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 5 ? 'selected' : '' }}>Kelas 5
                                    (Fungsional Terampil Mahir)</option>
                                <option value="4"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 4 ? 'selected' : '' }}>Kelas 4
                                    (Fungsional Terampil)</option>
                                <option value="3"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 3 ? 'selected' : '' }}>Kelas 3
                                    (Fungsional Terampil Pemula)</option>
                                <option value="2"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 2 ? 'selected' : '' }}>Kelas 2
                                    (Pelaksana Lanjutan)</option>
                                <option value="1"
                                    {{ old('kelas_jabatan', $pegawai->kelas_jabatan) == 1 ? 'selected' : '' }}>Kelas 1
                                    (Pelaksana Pemula)</option>
                            </select>
                            @error('kelas_jabatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">
                                Saat ini: Kelas {{ $pegawai->kelas_jabatan ?? 'Tidak ada' }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('status') border-red-500 @enderror">
                                <option value="">Pilih Status</option>
                                <option value="aktif" {{ old('status', $pegawai->status) == 'aktif' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="nonaktif"
                                    {{ old('status', $pegawai->status) == 'nonaktif' ? 'selected' : '' }}>Non-aktif
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Ubah Password (Opsional)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password
                                Baru</label>
                            <input type="password" id="password" name="password"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.pegawai.index') }}"
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
            // Debug untuk melihat nilai kelas jabatan
            document.addEventListener('DOMContentLoaded', function() {
                const kelasJabatan = document.getElementById('kelas_jabatan');
                console.log('Kelas Jabatan Value:', kelasJabatan.value);
                console.log('Pegawai Kelas Jabatan:', {{ $pegawai->kelas_jabatan ?? 'null' }});
            });
        </script>
    @endpush
@endsection
