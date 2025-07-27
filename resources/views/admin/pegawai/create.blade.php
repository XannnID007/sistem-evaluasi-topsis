@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Tambah Pegawai Baru</h2>
                <p class="text-gray-600 mt-1">Tambahkan data pegawai baru ke sistem</p>
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
            <form action="{{ route('admin.pegawai.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

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
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nama') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                                placeholder="nama@kecamatancangkuang.go.id">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('username') border-red-500 @enderror"
                                placeholder="username">
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div>
                            <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('telepon') border-red-500 @enderror"
                                placeholder="081234567890">
                            @error('telepon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat
                            </label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('alamat') border-red-500 @enderror"
                                placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jabatan -->
                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Jabatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('jabatan') border-red-500 @enderror"
                                placeholder="Contoh: Staff Administrasi">
                            @error('jabatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelas Jabatan -->
                        <div>
                            <label for="kelas_jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelas Jabatan <span class="text-red-500">*</span>
                            </label>
                            <select id="kelas_jabatan" name="kelas_jabatan" required
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('kelas_jabatan') border-red-500 @enderror">
                                <option value="">Pilih Kelas Jabatan</option>
                                <option value="17" {{ old('kelas_jabatan') == '17' ? 'selected' : '' }}>Kelas 17
                                    (Eselon I)</option>
                                <option value="16" {{ old('kelas_jabatan') == '16' ? 'selected' : '' }}>Kelas 16
                                    (Eselon II.a)</option>
                                <option value="15" {{ old('kelas_jabatan') == '15' ? 'selected' : '' }}>Kelas 15
                                    (Eselon II.b)</option>
                                <option value="14" {{ old('kelas_jabatan') == '14' ? 'selected' : '' }}>Kelas 14
                                    (Eselon III.a)</option>
                                <option value="13" {{ old('kelas_jabatan') == '13' ? 'selected' : '' }}>Kelas 13
                                    (Eselon III.b)</option>
                                <option value="12" {{ old('kelas_jabatan') == '12' ? 'selected' : '' }}>Kelas 12
                                    (Eselon IV.a/Camat)</option>
                                <option value="11" {{ old('kelas_jabatan') == '11' ? 'selected' : '' }}>Kelas 11
                                    (Eselon IV.b/Sekretaris)</option>
                                <option value="10" {{ old('kelas_jabatan') == '10' ? 'selected' : '' }}>Kelas 10
                                    (Fungsional Ahli Utama)</option>
                                <option value="9" {{ old('kelas_jabatan') == '9' ? 'selected' : '' }}>Kelas 9
                                    (Fungsional Ahli Madya/Kasi)</option>
                                <option value="8" {{ old('kelas_jabatan') == '8' ? 'selected' : '' }}>Kelas 8
                                    (Fungsional Ahli Muda)</option>
                                <option value="7" {{ old('kelas_jabatan') == '7' ? 'selected' : '' }}>Kelas 7
                                    (Fungsional Ahli Pertama)</option>
                                <option value="6" {{ old('kelas_jabatan') == '6' ? 'selected' : '' }}>Kelas 6
                                    (Fungsional Terampil Penyelia)</option>
                                <option value="5" {{ old('kelas_jabatan') == '5' ? 'selected' : '' }}>Kelas 5
                                    (Fungsional Terampil Mahir)</option>
                                <option value="4" {{ old('kelas_jabatan') == '4' ? 'selected' : '' }}>Kelas 4
                                    (Fungsional Terampil Terampil)</option>
                                <option value="3" {{ old('kelas_jabatan') == '3' ? 'selected' : '' }}>Kelas 3
                                    (Fungsional Terampil Pemula)</option>
                                <option value="2" {{ old('kelas_jabatan') == '2' ? 'selected' : '' }}>Kelas 2
                                    (Pelaksana Lanjutan)</option>
                                <option value="1" {{ old('kelas_jabatan') == '1' ? 'selected' : '' }}>Kelas 1
                                    (Pelaksana Pemula)</option>
                            </select>
                            @error('kelas_jabatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Sesuai dengan kelas jabatan PNS berdasarkan PP No. 11
                                Tahun 2017</p>
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

                <!-- Account Information Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                        Informasi Akun
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror"
                                    placeholder="Minimal 6 karakter">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" onclick="togglePassword('password')"
                                        class="text-gray-400 hover:text-gray-600">
                                        <svg id="password-eye-open" class="h-5 w-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg id="password-eye-closed" class="h-5 w-5 hidden" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="Ulangi password">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button type="button" onclick="togglePassword('password_confirmation')"
                                        class="text-gray-400 hover:text-gray-600">
                                        <svg id="password_confirmation-eye-open" class="h-5 w-5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg id="password_confirmation-eye-closed" class="h-5 w-5 hidden" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
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
                        Simpan Pegawai
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword(fieldId) {
                const passwordInput = document.getElementById(fieldId);
                const eyeOpen = document.getElementById(fieldId + '-eye-open');
                const eyeClosed = document.getElementById(fieldId + '-eye-closed');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            }

            // Auto-generate username from nama
            document.getElementById('nama').addEventListener('input', function() {
                const nama = this.value.toLowerCase()
                    .replace(/[^a-z\s]/g, '') // Remove non-alphabetic characters except spaces
                    .trim()
                    .split(' ')
                    .slice(0, 2) // Take first 2 words
                    .join('.');

                if (nama && !document.getElementById('username').value) {
                    document.getElementById('username').value = nama;
                }
            });

            // Auto-generate email from username
            document.getElementById('username').addEventListener('input', function() {
                const username = this.value.toLowerCase().replace(/[^a-z.]/g, '');

                if (username && !document.getElementById('email').value) {
                    document.getElementById('email').value = username + '@kecamatancangkuang.go.id';
                }
            });

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;

                if (password !== passwordConfirmation) {
                    e.preventDefault();
                    alert('Password dan konfirmasi password tidak cocok!');
                    document.getElementById('password_confirmation').focus();
                    return false;
                }

                if (password.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter!');
                    document.getElementById('password').focus();
                    return false;
                }
            });
        </script>
    @endpush
@endsection
