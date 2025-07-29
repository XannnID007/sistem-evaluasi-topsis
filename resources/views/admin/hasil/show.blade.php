@extends('layouts.app')

@section('title', 'Detail Hasil Evaluasi')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Hasil Evaluasi</h2>
                <p class="text-gray-600 mt-1">{{ $evaluasi->user->nama }} - {{ $evaluasi->periode->nama }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.hasil.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Main Info Card -->
        <div class="bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 rounded-xl p-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-20 w-20 bg-primary-500 rounded-full flex items-center justify-center mr-6">
                        <span class="text-white font-bold text-2xl">
                            {{ strtoupper(substr($evaluasi->user->nama, 0, 2)) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-primary-900">{{ $evaluasi->user->nama }}</h3>
                        <p class="text-primary-700 text-lg">{{ $evaluasi->user->jabatan }}</p>
                        <p class="text-primary-600 text-sm">{{ $evaluasi->user->getKelasJabatanText() }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold text-primary-600">{{ number_format($evaluasi->total_skor, 2) }}</div>
                    <div class="text-primary-700 font-medium">Total Skor CPI</div>
                    <div class="mt-2">
                        @php
                            $rankingColor = match (true) {
                                $evaluasi->ranking <= 3 => 'bg-yellow-500 text-white',
                                $evaluasi->ranking <= 10 => 'bg-blue-500 text-white',
                                default => 'bg-gray-500 text-white',
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $rankingColor }}">
                            Ranking #{{ $evaluasi->ranking }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $kategori = match (true) {
                    $evaluasi->total_skor > 150 => ['text' => 'Sangat Baik', 'color' => 'success', 'icon' => 'star'],
                    $evaluasi->total_skor >= 130 => ['text' => 'Baik', 'color' => 'primary', 'icon' => 'check'],
                    $evaluasi->total_skor >= 110 => ['text' => 'Cukup', 'color' => 'warning', 'icon' => 'minus'],
                    default => ['text' => 'Kurang', 'color' => 'danger', 'icon' => 'x'],
                };
            @endphp

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-{{ $kategori['color'] }}-100">
                        @if ($kategori['icon'] === 'star')
                            <svg class="h-6 w-6 text-{{ $kategori['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        @elseif($kategori['icon'] === 'check')
                            <svg class="h-6 w-6 text-{{ $kategori['color'] }}-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        @elseif($kategori['icon'] === 'minus')
                            <svg class="h-6 w-6 text-{{ $kategori['color'] }}-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        @else
                            <svg class="h-6 w-6 text-{{ $kategori['color'] }}-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Kategori Kinerja</p>
                        <p class="text-lg font-bold text-{{ $kategori['color'] }}-600">{{ $kategori['text'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-secondary-100">
                        <svg class="h-6 w-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m-7 9a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Periode</p>
                        <p class="text-lg font-bold text-gray-900">{{ $evaluasi->periode->nama }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-purple-100">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Evaluator</p>
                        <p class="text-lg font-bold text-gray-900">{{ $evaluasi->creator->nama }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tanggal Evaluasi</p>
                        <p class="text-lg font-bold text-gray-900">{{ $evaluasi->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Criteria Analysis -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Analisis Detail per Kriteria</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- C1 - Produktivitas -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-blue-500">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-blue-900">C1 - Produktivitas</h4>
                                <p class="text-xs text-blue-700">Bobot: 40%</p>
                            </div>
                        </div>
                        <span
                            class="text-2xl font-bold text-blue-600">{{ number_format($evaluasi->c1_produktivitas, 1) }}</span>
                    </div>

                    <div class="mb-3">
                        <div class="flex justify-between text-sm text-blue-700 mb-1">
                            <span>Nilai vs Rata-rata</span>
                            <span>{{ number_format($avgPeriode->avg_c1 ?? 0, 1) }}</span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full"
                                style="width: {{ ($evaluasi->c1_produktivitas / 100) * 100 }}%"></div>
                        </div>
                    </div>

                    @php $c1_diff = $evaluasi->c1_produktivitas - ($avgPeriode->avg_c1 ?? 0); @endphp
                    <div class="text-center">
                        @if ($c1_diff > 0)
                            <span class="inline-flex items-center text-xs font-medium text-blue-800">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                {{ number_format($c1_diff, 1) }} di atas rata-rata
                            </span>
                        @elseif($c1_diff < 0)
                            <span class="inline-flex items-center text-xs font-medium text-blue-600">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                                {{ number_format(abs($c1_diff), 1) }} di bawah rata-rata
                            </span>
                        @else
                            <span class="text-xs font-medium text-blue-600">Sama dengan rata-rata</span>
                        @endif
                    </div>
                </div>

                <!-- C2 - Tanggung Jawab -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-green-500">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-green-900">C2 - Tanggung Jawab</h4>
                                <p class="text-xs text-green-700">Bobot: 20%</p>
                            </div>
                        </div>
                        <span
                            class="text-2xl font-bold text-green-600">{{ number_format($evaluasi->c2_tanggung_jawab, 1) }}</span>
                    </div>

                    <div class="mb-3">
                        <div class="flex justify-between text-sm text-green-700 mb-1">
                            <span>Nilai vs Rata-rata</span>
                            <span>{{ number_format($avgPeriode->avg_c2 ?? 0, 1) }}</span>
                        </div>
                        <div class="w-full bg-green-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full"
                                style="width: {{ ($evaluasi->c2_tanggung_jawab / 100) * 100 }}%"></div>
                        </div>
                    </div>

                    @php $c2_diff = $evaluasi->c2_tanggung_jawab - ($avgPeriode->avg_c2 ?? 0); @endphp
                    <div class="text-center">
                        @if ($c2_diff > 0)
                            <span class="inline-flex items-center text-xs font-medium text-green-800">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                {{ number_format($c2_diff, 1) }} di atas rata-rata
                            </span>
                        @elseif($c2_diff < 0)
                            <span class="inline-flex items-center text-xs font-medium text-green-600">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                                {{ number_format(abs($c2_diff), 1) }} di bawah rata-rata
                            </span>
                        @else
                            <span class="text-xs font-medium text-green-600">Sama dengan rata-rata</span>
                        @endif
                    </div>
                </div>

                <!-- C3 - Kehadiran -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-purple-500">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-purple-900">C3 - Kehadiran</h4>
                                <p class="text-xs text-purple-700">Bobot: 20%</p>
                            </div>
                        </div>
                        <span
                            class="text-2xl font-bold text-purple-600">{{ number_format($evaluasi->c3_kehadiran, 1) }}</span>
                    </div>

                    <div class="mb-3">
                        <div class="flex justify-between text-sm text-purple-700 mb-1">
                            <span>Nilai vs Rata-rata</span>
                            <span>{{ number_format($avgPeriode->avg_c3 ?? 0, 1) }}</span>
                        </div>
                        <div class="w-full bg-purple-200 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full"
                                style="width: {{ ($evaluasi->c3_kehadiran / 100) * 100 }}%"></div>
                        </div>
                    </div>

                    @php $c3_diff = $evaluasi->c3_kehadiran - ($avgPeriode->avg_c3 ?? 0); @endphp
                    <div class="text-center">
                        @if ($c3_diff > 0)
                            <span class="inline-flex items-center text-xs font-medium text-purple-800">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                {{ number_format($c3_diff, 1) }} di atas rata-rata
                            </span>
                        @elseif($c3_diff < 0)
                            <span class="inline-flex items-center text-xs font-medium text-purple-600">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                                {{ number_format(abs($c3_diff), 1) }} di bawah rata-rata
                            </span>
                        @else
                            <span class="text-xs font-medium text-purple-600">Sama dengan rata-rata</span>
                        @endif
                    </div>
                </div>

                <!-- C4 - Pelanggaran -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-orange-500">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-orange-900">C4 - Pelanggaran</h4>
                                <p class="text-xs text-orange-700">Bobot: 10% (Negatif)</p>
                            </div>
                        </div>
                        <span class="text-2xl font-bold text-orange-600">{{ $evaluasi->c4_pelanggaran }}</span>
                    </div>

                    <div class="mb-3">
                        <div class="flex justify-between text-sm text-orange-700 mb-1">
                            <span>Jumlah vs Rata-rata</span>
                            <span>{{ number_format($avgPeriode->avg_c4 ?? 0, 1) }}</span>
                        </div>
                        @php $maxPelanggaran = 10; @endphp
                        <div class="w-full bg-orange-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full"
                                style="width: {{ min(($evaluasi->c4_pelanggaran / $maxPelanggaran) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    @php $c4_diff = $evaluasi->c4_pelanggaran - ($avgPeriode->avg_c4 ?? 0); @endphp
                    <div class="text-center">
                        @if ($c4_diff < 0)
                            <span class="inline-flex items-center text-xs font-medium text-orange-800">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                {{ number_format(abs($c4_diff), 1) }} lebih baik
                            </span>
                        @elseif($c4_diff > 0)
                            <span class="inline-flex items-center text-xs font-medium text-orange-600">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                                {{ number_format($c4_diff, 1) }} lebih tinggi
                            </span>
                        @else
                            <span class="text-xs font-medium text-orange-600">Sama dengan rata-rata</span>
                        @endif
                    </div>
                </div>

                <!-- C5 - Terlambat -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-red-500">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-red-900">C5 - Terlambat</h4>
                                <p class="text-xs text-red-700">Bobot: 10% (Negatif)</p>
                            </div>
                        </div>
                        <span class="text-2xl font-bold text-red-600">{{ $evaluasi->c5_terlambat }}</span>
                    </div>

                    <div class="mb-3">
                        <div class="flex justify-between text-sm text-red-700 mb-1">
                            <span>Jumlah vs Rata-rata</span>
                            <span>{{ number_format($avgPeriode->avg_c5 ?? 0, 1) }}</span>
                        </div>
                        @php $maxTerlambat = 10; @endphp
                        <div class="w-full bg-red-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full"
                                style="width: {{ min(($evaluasi->c5_terlambat / $maxTerlambat) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    @php $c5_diff = $evaluasi->c5_terlambat - ($avgPeriode->avg_c5 ?? 0); @endphp
                    <div class="text-center">
                        @if ($c5_diff < 0)
                            <span class="inline-flex items-center text-xs font-medium text-red-800">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                {{ number_format(abs($c5_diff), 1) }} lebih baik
                            </span>
                        @elseif($c5_diff > 0)
                            <span class="inline-flex items-center text-xs font-medium text-red-600">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                                {{ number_format($c5_diff, 1) }} lebih tinggi
                            </span>
                        @else
                            <span class="text-xs font-medium text-red-600">Sama dengan rata-rata</span>
                        @endif
                    </div>
                </div>

                <!-- Position Analysis -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-gray-500">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-gray-900">Posisi Relatif</h4>
                                <p class="text-xs text-gray-700">Dalam periode ini</p>
                            </div>
                        </div>
                        <span
                            class="text-2xl font-bold text-gray-600">{{ round((($totalPegawai - $evaluasi->ranking + 1) / $totalPegawai) * 100) }}%</span>
                    </div>

                    <div class="mb-3">
                        <div class="flex justify-between text-sm text-gray-700 mb-1">
                            <span>Persentil</span>
                            <span>{{ $totalPegawai ?? 0 }} total pegawai</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-500 h-2 rounded-full"
                                style="width: {{ (($totalPegawai - $evaluasi->ranking + 1) / max($totalPegawai, 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <span class="text-xs font-medium text-gray-600">
                            Lebih baik dari {{ $totalPegawai - $evaluasi->ranking }} pegawai lainnya
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historical Performance -->
        @if ($historyRanking && $historyRanking->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Riwayat Kinerja</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Periode</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Total Skor</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Ranking</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Kategori</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">Trend</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($historyRanking as $index => $history)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $history->periode->nama }}</div>
                                        <div class="text-sm text-gray-500">{{ $history->periode->getFormattedTanggal() }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="text-sm font-bold text-gray-900">{{ number_format($history->total_skor, 2) }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            #{{ $history->ranking }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $historyKategori = match (true) {
                                                $history->total_skor > 150 => [
                                                    'text' => 'Sangat Baik',
                                                    'color' => 'success',
                                                ],
                                                $history->total_skor >= 130 => ['text' => 'Baik', 'color' => 'primary'],
                                                $history->total_skor >= 110 => [
                                                    'text' => 'Cukup',
                                                    'color' => 'warning',
                                                ],
                                                default => ['text' => 'Kurang', 'color' => 'danger'],
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $historyKategori['color'] }}-100 text-{{ $historyKategori['color'] }}-800">
                                            {{ $historyKategori['text'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($index < $historyRanking->count() - 1)
                                            @php
                                                $nextHistory = $historyRanking[$index + 1];
                                                $scoreDiff = $history->total_skor - $nextHistory->total_skor;
                                                $rankDiff = $nextHistory->ranking - $history->ranking;
                                            @endphp

                                            @if ($scoreDiff > 0)
                                                <span class="inline-flex items-center text-success-600">
                                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                    </svg>
                                                    <span class="text-xs font-medium">Naik</span>
                                                </span>
                                            @elseif($scoreDiff < 0)
                                                <span class="inline-flex items-center text-danger-600">
                                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                                    </svg>
                                                    <span class="text-xs font-medium">Turun</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center text-gray-500">
                                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                    <span class="text-xs font-medium">Stabil</span>
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Performance Analysis & Recommendations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Strengths & Areas for Improvement -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Analisis Kekuatan & Area Pengembangan</h3>

                @php
                    $criteriaScores = [
                        [
                            'name' => 'Produktivitas Kerja',
                            'score' => $evaluasi->c1_produktivitas,
                            'avg' => $avgPeriode->avg_c1 ?? 0,
                            'type' => 'positive',
                        ],
                        [
                            'name' => 'Tanggung Jawab',
                            'score' => $evaluasi->c2_tanggung_jawab,
                            'avg' => $avgPeriode->avg_c2 ?? 0,
                            'type' => 'positive',
                        ],
                        [
                            'name' => 'Kehadiran',
                            'score' => $evaluasi->c3_kehadiran,
                            'avg' => $avgPeriode->avg_c3 ?? 0,
                            'type' => 'positive',
                        ],
                        [
                            'name' => 'Pelanggaran Disiplin',
                            'score' => $evaluasi->c4_pelanggaran,
                            'avg' => $avgPeriode->avg_c4 ?? 0,
                            'type' => 'negative',
                        ],
                        [
                            'name' => 'Keterlambatan',
                            'score' => $evaluasi->c5_terlambat,
                            'avg' => $avgPeriode->avg_c5 ?? 0,
                            'type' => 'negative',
                        ],
                    ];

                    $strengths = [];
                    $improvements = [];

                    foreach ($criteriaScores as $criteria) {
                        if ($criteria['type'] === 'positive') {
                            if ($criteria['score'] > $criteria['avg']) {
                                $strengths[] = $criteria;
                            } elseif ($criteria['score'] < $criteria['avg']) {
                                $improvements[] = $criteria;
                            }
                        } else {
                            if ($criteria['score'] < $criteria['avg']) {
                                $strengths[] = $criteria;
                            } elseif ($criteria['score'] > $criteria['avg']) {
                                $improvements[] = $criteria;
                            }
                        }
                    }
                @endphp

                <!-- Strengths -->
                <div class="mb-6">
                    <h4 class="font-semibold text-success-900 mb-3 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-success-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Kekuatan
                    </h4>
                    @if (count($strengths) > 0)
                        <div class="space-y-2">
                            @foreach ($strengths as $strength)
                                <div class="flex items-center justify-between p-3 bg-success-50 rounded-lg">
                                    <span class="text-sm font-medium text-success-900">{{ $strength['name'] }}</span>
                                    <div class="text-right">
                                        <span
                                            class="text-sm font-bold text-success-600">{{ number_format($strength['score'], 1) }}</span>
                                        <span class="text-xs text-success-500 ml-1">(avg:
                                            {{ number_format($strength['avg'], 1) }})</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">Semua kriteria dalam rentang rata-rata periode.</p>
                    @endif
                </div>

                <!-- Areas for Improvement -->
                <div>
                    <h4 class="font-semibold text-warning-900 mb-3 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-warning-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Area Pengembangan
                    </h4>
                    @if (count($improvements) > 0)
                        <div class="space-y-2">
                            @foreach ($improvements as $improvement)
                                <div class="flex items-center justify-between p-3 bg-warning-50 rounded-lg">
                                    <span class="text-sm font-medium text-warning-900">{{ $improvement['name'] }}</span>
                                    <div class="text-right">
                                        <span
                                            class="text-sm font-bold text-warning-600">{{ number_format($improvement['score'], 1) }}</span>
                                        <span class="text-xs text-warning-500 ml-1">(avg:
                                            {{ number_format($improvement['avg'], 1) }})</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">Tidak ada area yang memerlukan peningkatan khusus.</p>
                    @endif
                </div>
            </div>

            <!-- Recommendations -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-6">Rekomendasi Tindak Lanjut</h3>

                <div class="space-y-4">
                    @if ($evaluasi->total_skor > 150)
                        <!-- Sangat Baik -->
                        <div class="flex items-start">
                            <div class="p-2 rounded-lg bg-success-500 mr-3">
                                <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-success-900">Pertahankan Prestasi Tinggi</h4>
                                <p class="text-sm text-success-700 mt-1">
                                    Kinerja Anda sangat baik. Pertahankan konsistensi dan jadilah mentor bagi rekan kerja
                                    lainnya.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="p-2 rounded-lg bg-blue-500 mr-3">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-900">Pengembangan Karir</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    Pertimbangkan untuk mengikuti program pengembangan kepemimpinan atau pelatihan lanjutan.
                                </p>
                            </div>
                        </div>
                    @elseif($evaluasi->total_skor >= 130)
                        <!-- Baik -->
                        <div class="flex items-start">
                            <div class="p-2 rounded-lg bg-primary-500 mr-3">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-primary-900">Kinerja yang Baik</h4>
                                <p class="text-sm text-primary-700 mt-1">
                                    Kinerja Anda sudah baik. Fokus pada peningkatan beberapa area untuk mencapai level
                                    sangat baik.
                                </p>
                            </div>
                        </div>

                        @if (count($improvements) > 0)
                            <div class="flex items-start">
                                <div class="p-2 rounded-lg bg-warning-500 mr-3">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-warning-900">Area Fokus</h4>
                                    <p class="text-sm text-warning-700 mt-1">
                                        Tingkatkan: {{ collect($improvements)->pluck('name')->join(', ') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @elseif($evaluasi->total_skor >= 110)
                        <!-- Cukup -->
                        <div class="flex items-start">
                            <div class="p-2 rounded-lg bg-warning-500 mr-3">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-warning-900">Perlu Peningkatan</h4>
                                <p class="text-sm text-warning-700 mt-1">
                                    Kinerja dalam kategori cukup. Diperlukan usaha lebih untuk mencapai target yang
                                    diharapkan.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="p-2 rounded-lg bg-blue-500 mr-3">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-900">Program Pengembangan</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    Direkomendasikan mengikuti pelatihan keterampilan dan program mentoring.
                                </p>
                            </div>
                        </div>
                    @else
                        <!-- Kurang -->
                        <div class="flex items-start">
                            <div class="p-2 rounded-lg bg-danger-500 mr-3">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-danger-900">Perlu Perhatian Khusus</h4>
                                <p class="text-sm text-danger-700 mt-1">
                                    Kinerja perlu ditingkatkan secara signifikan. Diperlukan bimbingan dan pengawasan
                                    intensif.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="p-2 rounded-lg bg-purple-500 mr-3">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-purple-900">Rencana Perbaikan</h4>
                                <p class="text-sm text-purple-700 mt-1">
                                    Susun rencana perbaikan kinerja dengan timeline yang jelas dan monitoring berkala.
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- General Recommendations -->
                    <div class="border-t border-blue-200 pt-4">
                        <h4 class="font-semibold text-blue-900 mb-2">Saran Umum:</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Lakukan evaluasi diri secara berkala</li>
                            <li>• Komunikasikan kendala dengan atasan</li>
                            <li>• Manfaatkan program pengembangan yang tersedia</li>
                            <li>• Jaga konsistensi dalam bekerja</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div class="text-sm text-gray-500">
                <p>Evaluasi dibuat: {{ $evaluasi->created_at->format('d M Y H:i') }}</p>
                <p>Terakhir diperbarui: {{ $evaluasi->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function printDetail() {
                window.print();
            }

            function exportIndividual(evaluasiId) {
                const format = prompt('Pilih format export:\n1. PDF\n2. Excel\n\nKetik "pdf" atau "excel":', 'pdf');

                if (format === 'pdf' || format === 'excel') {
                    window.location.href = `/admin/hasil/${evaluasiId}/export?format=${format}`;
                }
            }

            // Print styles
            document.addEventListener('DOMContentLoaded', function() {
                const style = document.createElement('style');
                style.textContent = `
                    @media print {
                        body * {
                            visibility: hidden;
                        }
                        
                        .print-content, .print-content * {
                            visibility: visible;
                        }
                        
                        .print-content {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 100%;
                        }
                        
                        button, .no-print {
                            display: none !important;
                        }
                        
                        .bg-gradient-to-br {
                            background: #f8fafc !important;
                        }
                        
                        .shadow-sm, .shadow-xl {
                            box-shadow: none !important;
                        }
                    }
                `;
                document.head.appendChild(style);

                // Add print-content class to main content
                document.querySelector('main').classList.add('print-content');
            });
        </script>
    @endpush
@endsection
