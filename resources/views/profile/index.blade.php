@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Profile Saya</h2>
                <p class="text-gray-600 mt-1">Kelola informasi personal dan akun Anda</p>
            </div>
            <a href="{{ route('profile.edit') }}"
                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Edit Profile
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <!-- Avatar -->
                        <div class="mx-auto h-24 w-24 bg-primary-500 rounded-full flex items-center justify-center mb-4">
                            <span class="text-white text-2xl font-bold">
                                {{ strtoupper(substr($user->nama, 0, 2)) }}
                            </span>
                        </div>

                        <!-- User Info -->
                        <h3 class="text-xl font-semibold text-gray-900">{{ $user->nama }}</h3>
                        <p class="text-gray-600">{{ $user->jabatan }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ ucfirst($user->role) }}</p>

                        <!-- Status Badge -->
                        <div class="mt-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $user->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                @if ($user->isPegawai() && isset($evaluasiTerbaru))
                    <!-- Quick Stats for Pegawai -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Statistik Kinerja</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Evaluasi</span>
                                <span class="font-semibold">{{ $totalEvaluasi }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Rata-rata Skor</span>
                                <span class="font-semibold">{{ number_format($rataSkor, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ranking Terbaik</span>
                                <span class="font-semibold">#{{ $rankingTerbaik ?: '-' }}</span>
                            </div>
                            @if ($evaluasiTerbaru)
                                <div class="pt-4 border-t">
                                    <p class="text-sm text-gray-600 mb-2">Evaluasi Terbaru</p>
                                    <p class="font-semibold">{{ $evaluasiTerbaru->periode->nama }}</p>
                                    <p class="text-sm text-gray-500">Ranking #{{ $evaluasiTerbaru->ranking }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6">Informasi Personal</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <p class="text-gray-900">{{ $user->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <p class="text-gray-900">{{ $user->username }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <p class="text-gray-900">{{ $user->telepon ?: '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <p class="text-gray-900">{{ $user->alamat ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Job Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6">Informasi Jabatan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                            <p class="text-gray-900">{{ $user->jabatan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Jabatan</label>
                            <p class="text-gray-900">{{ $user->kelas_jabatan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <p class="text-gray-900 capitalize">{{ $user->role }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $user->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Account Security -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6">Keamanan Akun</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h5 class="font-medium text-gray-900">Password</h5>
                                <p class="text-sm text-gray-600">Terakhir diubah pada
                                    {{ $user->updated_at->format('d M Y') }}</p>
                            </div>
                            <button onclick="showChangePasswordModal()"
                                class="px-4 py-2 bg-warning-600 hover:bg-warning-700 text-white text-sm font-medium rounded-lg transition-colors">
                                Ubah Password
                            </button>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h5 class="font-medium text-gray-900">Akun dibuat</h5>
                                <p class="text-sm text-gray-600">{{ $user->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Ubah Password</h3>
                    <button onclick="closeChangePasswordModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('profile.change-password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat
                            Ini</label>
                        <input type="password" id="current_password" name="current_password" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input type="password" id="password" name="password" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi
                            Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeChangePasswordModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showChangePasswordModal() {
                document.getElementById('changePasswordModal').classList.remove('hidden');
                document.getElementById('changePasswordModal').classList.add('flex');
            }

            function closeChangePasswordModal() {
                document.getElementById('changePasswordModal').classList.add('hidden');
                document.getElementById('changePasswordModal').classList.remove('flex');
            }

            // Close modal when clicking outside
            document.getElementById('changePasswordModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeChangePasswordModal();
                }
            });
        </script>
    @endpush
@endsection
