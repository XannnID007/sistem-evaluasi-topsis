@extends('layouts.app')

@section('title', 'Detail Periode Evaluasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Periode Evaluasi</h2>
                <p class="text-gray-600 mt-1">{{ $periode->nama }}</p>
            </div>
            <div class="flex space-x-3">
                @if ($periode->status !== 'selesai')
                    <a href="{{ route('admin.periode.edit', $periode->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-warning-600 hover:bg-warning-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit
                    </a>
                @endif

                <a href="{{ route('admin.periode.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Period Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <!-- Status Badge -->
                        @php $badge = $periode->getStatusBadge(); @endphp
                        <div
                            class="mx-auto h-20 w-20 rounded-full flex items-center justify-center mb-4 {{ str_replace('text-', 'bg-', $badge['class']) }}">
                            <span class="text-white text-2xl font-bold">
                                {{ strtoupper(substr($periode->nama, 0, 2)) }}
                            </span>
                        </div>

                        <!-- Period Name -->
                        <h3 class="text-xl font-semibold text-gray-900">{{ $periode->nama }}</h3>
                        <p class="text-gray-600">{{ $periode->getFormattedPeriode() }}</p>

                        <!-- Status -->
                        <div class="mt-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badge['class'] }}">
                                {{ $badge['text'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Period Details -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Mulai</span>
                                <span class="font-medium">{{ $periode->tgl_mulai->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Selesai</span>
                                <span class="font-medium">{{ $periode->tgl_selesai->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Durasi</span>
                                <span class="font-medium">{{ $periode->getDurasiHari() }} hari</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Progress</span>
                                <span class="font-medium">{{ $periode->getProgressPersentase() }}%</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full"
                                    style="width: {{ $periode->getProgressPersentase() }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h4>
                    <div class="space-y-3">
                        @if ($periode->status == 'draft')
                            <button onclick="activatePeriode({{ $periode->id }})"
                                class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                Aktifkan Periode
                            </button>
                        @elseif($periode->status == 'aktif')
                            <button onclick="finishPeriode({{ $periode->id }})"
                                class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Selesaikan Periode
                            </button>
                        @endif

                        <a href="{{ route('admin.evaluasi.index', ['periode_id' => $periode->id]) }}"
                            class="w-full flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Lihat Evaluasi
                        </a>

                        <button onclick="duplicatePeriode({{ $periode->id }})"
                            class="w-full flex items-center justify-center px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                            Duplikasi Periode
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics and Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-primary-100">
                                <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-gray-600">Total Evaluasi</p>
                                <p class="text-lg font-bold text-gray-900">{{ $statistik['total_evaluasi'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-success-100">
                                <svg class="h-5 w-5 text-success-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-gray-600">Rata-rata Skor</p>
                                <p class="text-lg font-bold text-gray-900">{{ number_format($statistik['rata_skor'], 2) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-warning-100">
                                <svg class="h-5 w-5 text-warning-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-gray-600">Skor Tertinggi</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ number_format($statistik['skor_tertinggi'], 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-danger-100">
                                <svg class="h-5 w-5 text-danger-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs font-medium text-gray-600">Skor Terendah</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ number_format($statistik['skor_terendah'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Distribution -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Kinerja</h4>

                    @if ($statistik['total_evaluasi'] > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <p class="text-2xl font-bold text-green-600">{{ $statistik['distribusi']['sangat_baik'] }}
                                </p>
                                <p class="text-sm text-green-700">Sangat Baik</p>
                                <p class="text-xs text-gray-500">(>150)</p>
                            </div>
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <p class="text-2xl font-bold text-blue-600">{{ $statistik['distribusi']['baik'] }}</p>
                                <p class="text-sm text-blue-700">Baik</p>
                                <p class="text-xs text-gray-500">(130-150)</p>
                            </div>
                            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                <p class="text-2xl font-bold text-yellow-600">{{ $statistik['distribusi']['cukup'] }}</p>
                                <p class="text-sm text-yellow-700">Cukup</p>
                                <p class="text-xs text-gray-500">(110-130)</p>
                            </div>
                            <div class="text-center p-4 bg-red-50 rounded-lg">
                                <p class="text-2xl font-bold text-red-600">{{ $statistik['distribusi']['kurang'] }}</p>
                                <p class="text-sm text-red-700">Kurang</p>
                                <p class="text-xs text-gray-500">(<110)< /p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada data evaluasi untuk periode ini</p>
                        </div>
                    @endif
                </div>

                <!-- Top Performers -->
                @if ($topPerformers->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">Top 5 Performers</h4>
                            <a href="{{ route('admin.hasil.index', ['periode_id' => $periode->id]) }}"
                                class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                Lihat Semua
                            </a>
                        </div>

                        <div class="space-y-3">
                            @foreach ($topPerformers as $index => $evaluasi)
                                <div
                                    class="flex items-center justify-between p-3 {{ $index < 3 ? 'bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200' : 'bg-gray-50' }} rounded-lg">
                                    <div class="flex items-center">
                                        @php
                                            $rankingColor = match ($evaluasi->ranking) {
                                                1 => 'bg-yellow-500',
                                                2 => 'bg-gray-400',
                                                3 => 'bg-orange-500',
                                                default => 'bg-gray-300',
                                            };
                                        @endphp
                                        <span
                                            class="flex items-center justify-center w-8 h-8 {{ $rankingColor }} text-white rounded-full text-sm font-bold mr-3">
                                            {{ $evaluasi->ranking }}
                                        </span>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $evaluasi->user->nama }}</p>
                                            <p class="text-sm text-gray-600">{{ $evaluasi->user->jabatan }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900">
                                            {{ number_format($evaluasi->total_skor, 2) }}</p>
                                        <p class="text-xs text-gray-500">Total Skor</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function activatePeriode(id) {
                if (confirm('Apakah Anda yakin ingin mengaktifkan periode ini? Periode aktif lainnya akan dinonaktifkan.')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/periode/${id}/activate`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                }
            }

            function finishPeriode(id) {
                if (confirm(
                        'Apakah Anda yakin ingin menyelesaikan periode ini? Status tidak dapat diubah setelah diselesaikan.')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/periode/${id}/finish`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                }
            }

            function duplicatePeriode(id) {
                if (confirm('Apakah Anda yakin ingin menduplikasi periode ini untuk bulan berikutnya?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/periode/${id}/duplicate`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>
    @endpush
@endsection
