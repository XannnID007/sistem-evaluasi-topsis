@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Pegawai</h2>
                <p class="text-gray-600 mt-1">Informasi lengkap pegawai: {{ $pegawai->nama }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-warning-600 hover:bg-warning-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.pegawai.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <!-- Avatar -->
                        <div class="mx-auto h-24 w-24 bg-primary-500 rounded-full flex items-center justify-center mb-4">
                            <span class="text-white text-2xl font-bold">
                                {{ strtoupper(substr($pegawai->nama, 0, 2)) }}
                            </span>
                        </div>

                        <!-- User Info -->
                        <h3 class="text-xl font-semibold text-gray-900">{{ $pegawai->nama }}</h3>
                        <p class="text-gray-600">{{ $pegawai->jabatan }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $pegawai->kelas_jabatan }}</p>

                        <!-- Status Badge -->
                        <div class="mt-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $pegawai->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($pegawai->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Statistik Evaluasi</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Evaluasi</span>
                            <span class="font-semibold">{{ $totalEvaluasi }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Rata-rata Skor</span>
                            <span class="font-semibold">{{ number_format($rataRataSkor, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ranking Terbaik</span>
                            <span class="font-semibold">#{{ $rankingTerbaik ?: '-' }}</span>
                        </div>
                        @if ($evaluasiTerbaru && $evaluasiTerbaru->count() > 0)
                            <div class="pt-4 border-t">
                                <p class="text-sm text-gray-600 mb-2">Evaluasi Terbaru</p>
                                @foreach ($evaluasiTerbaru as $eval)
                                    <div class="mb-2">
                                        <p class="font-semibold">{{ $eval->periode->nama }}</p>
                                        <p class="text-sm text-gray-500">Ranking #{{ $eval->ranking }} - Skor:
                                            {{ number_format($eval->total_skor, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6">Informasi Personal</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <p class="text-gray-900">{{ $pegawai->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <p class="text-gray-900">{{ $pegawai->username }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-gray-900">{{ $pegawai->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <p class="text-gray-900">{{ $pegawai->telepon ?: '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <p class="text-gray-900">{{ $pegawai->alamat ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Job Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6">Informasi Jabatan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                            <p class="text-gray-900">{{ $pegawai->jabatan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Jabatan</label>
                            <p class="text-gray-900">{{ $pegawai->kelas_jabatan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <p class="text-gray-900 capitalize">{{ $pegawai->role }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $pegawai->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($pegawai->status) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bergabung</label>
                            <p class="text-gray-900">{{ $pegawai->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                            <p class="text-gray-900">{{ $pegawai->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Evaluations -->
                @if ($evaluasiTerbaru && $evaluasiTerbaru->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-semibold text-gray-900">Evaluasi Terbaru</h4>
                            <a href="{{ route('admin.hasil.index', ['pegawai_id' => $pegawai->id]) }}"
                                class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="space-y-4">
                            @foreach ($evaluasiTerbaru as $eval)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h5 class="font-medium text-gray-900">{{ $eval->periode->nama }}</h5>
                                        <p class="text-sm text-gray-600">{{ $eval->periode->getFormattedTanggal() }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Dievaluasi pada {{ $eval->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center space-x-3">
                                            @php
                                                $rankingColor = match (true) {
                                                    $eval->ranking <= 3 => 'bg-yellow-100 text-yellow-800',
                                                    $eval->ranking <= 10 => 'bg-blue-100 text-blue-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-bold {{ $rankingColor }}">
                                                #{{ $eval->ranking }}
                                            </span>
                                            <div>
                                                <p class="text-lg font-bold text-gray-900">
                                                    {{ number_format($eval->total_skor, 2) }}</p>
                                                <p class="text-xs text-gray-500">Total Skor</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6">Aksi</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.evaluasi.create', ['user_id' => $pegawai->id]) }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Buat Evaluasi
                        </a>

                        <a href="{{ route('admin.hasil.index', ['pegawai_id' => $pegawai->id]) }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Lihat Hasil
                        </a>

                        <button onclick="resetPassword('{{ $pegawai->id }}', '{{ $pegawai->nama }}')"
                            class="inline-flex items-center justify-center px-4 py-2 bg-warning-600 hover:bg-warning-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                </path>
                            </svg>
                            Reset Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div id="resetPasswordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Reset Password</h3>
                    <button onclick="closeResetPasswordModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin mereset password untuk <span id="resetPasswordName"
                            class="font-medium text-gray-900"></span>?
                        Password akan direset ke default: <code class="bg-gray-100 px-2 py-1 rounded">password123</code>
                    </p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button onclick="closeResetPasswordModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg transition-colors">
                        Batal
                    </button>
                    <form id="resetPasswordForm" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="px-4 py-2 bg-warning-600 hover:bg-warning-700 text-white rounded-lg transition-colors">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function resetPassword(id, nama) {
                document.getElementById('resetPasswordName').textContent = nama;
                document.getElementById('resetPasswordForm').action = `/admin/pegawai/${id}/reset-password`;
                document.getElementById('resetPasswordModal').classList.remove('hidden');
                document.getElementById('resetPasswordModal').classList.add('flex');
            }

            function closeResetPasswordModal() {
                document.getElementById('resetPasswordModal').classList.add('hidden');
                document.getElementById('resetPasswordModal').classList.remove('flex');
            }

            // Close modal when clicking outside
            document.getElementById('resetPasswordModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeResetPasswordModal();
                }
            });
        </script>
    @endpush
@endsection
