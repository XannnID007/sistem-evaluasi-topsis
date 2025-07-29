@extends('layouts.app')

@section('title', 'Perbandingan Periode')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Perbandingan Hasil Evaluasi</h2>
                <p class="text-gray-600 mt-1">Bandingkan hasil evaluasi kinerja antar periode</p>
            </div>
            <a href="{{ route('admin.hasil.index') }}"
                class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Hasil
            </a>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="GET" action="{{ route('admin.hasil.comparison') }}"
                class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="periode1_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Periode Pertama <span class="text-red-500">*</span>
                    </label>
                    <select id="periode1_id" name="periode1_id" required
                        class="block w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Pilih Periode Pertama</option>
                        @foreach ($periodeList as $periode)
                            <option value="{{ $periode->id }}"
                                {{ request('periode1_id') == $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="periode2_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Periode Kedua <span class="text-red-500">*</span>
                    </label>
                    <select id="periode2_id" name="periode2_id" required
                        class="block w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Pilih Periode Kedua</option>
                        @foreach ($periodeList as $periode)
                            <option value="{{ $periode->id }}"
                                {{ request('periode2_id') == $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                        Bandingkan
                    </button>
                </div>
            </form>
        </div>

        @if (isset($comparisonData) && count($comparisonData) > 0)
            <!-- Comparison Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Periode 1 Info -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-500">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m-7 9a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-blue-900">{{ $periode1->nama }}</h3>
                            <p class="text-sm text-blue-700">{{ $periode1->getFormattedTanggal() }}</p>
                            <p class="text-xs text-blue-600 mt-1">{{ count($comparisonData) }} pegawai yang sama</p>
                        </div>
                    </div>
                </div>

                <!-- Periode 2 Info -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-500">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m-7 9a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-green-900">{{ $periode2->nama }}</h3>
                            <p class="text-sm text-green-700">{{ $periode2->getFormattedTanggal() }}</p>
                            <p class="text-xs text-green-600 mt-1">Perbandingan performa</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $improvedCount = collect($comparisonData)->where('skor_diff', '>', 0)->count();
                    $decreasedCount = collect($comparisonData)->where('skor_diff', '<', 0)->count();
                    $stableCount = collect($comparisonData)->where('skor_diff', '=', 0)->count();
                @endphp

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-success-100">
                            <svg class="h-6 w-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pegawai Meningkat</p>
                            <p class="text-2xl font-bold text-success-600">{{ $improvedCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-danger-100">
                            <svg class="h-6 w-6 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pegawai Menurun</p>
                            <p class="text-2xl font-bold text-danger-600">{{ $decreasedCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-secondary-100">
                            <svg class="h-6 w-6 text-secondary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pegawai Stabil</p>
                            <p class="text-2xl font-bold text-secondary-600">{{ $stableCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparison Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Perbandingan Detail per Pegawai</h3>
                        <div class="flex space-x-2">
                            <button onclick="exportComparison()"
                                class="inline-flex items-center px-3 py-1.5 bg-success-600 hover:bg-success-700 text-white text-sm rounded-lg transition-colors">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Export
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th rowspan="2"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                                    Pegawai
                                </th>
                                <th colspan="2"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                                    {{ $periode1->nama }}
                                </th>
                                <th colspan="2"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                                    {{ $periode2->nama }}
                                </th>
                                <th colspan="2"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Perubahan
                                </th>
                            </tr>
                            <tr>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Skor</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                                    Rank</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Skor</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                                    Rank</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Skor</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rank</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($comparisonData as $index => $data)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center">
                                                    <span class="text-white font-medium text-sm">
                                                        {{ strtoupper(substr($data['user']->nama, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $data['user']->nama }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $data['user']->jabatan }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Periode 1 -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="text-lg font-bold text-gray-900">{{ number_format($data['periode1']->total_skor, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center border-r border-gray-200">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                            #{{ $data['periode1']->ranking }}
                                        </span>
                                    </td>

                                    <!-- Periode 2 -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="text-lg font-bold text-gray-900">{{ number_format($data['periode2']->total_skor, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center border-r border-gray-200">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                            #{{ $data['periode2']->ranking }}
                                        </span>
                                    </td>

                                    <!-- Perubahan Skor -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($data['skor_diff'] > 0)
                                            <span class="inline-flex items-center text-success-600 font-bold">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                </svg>
                                                +{{ number_format($data['skor_diff'], 2) }}
                                            </span>
                                        @elseif($data['skor_diff'] < 0)
                                            <span class="inline-flex items-center text-danger-600 font-bold">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                                </svg>
                                                {{ number_format($data['skor_diff'], 2) }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 font-bold">0.00</span>
                                        @endif
                                    </td>

                                    <!-- Perubahan Ranking -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($data['ranking_diff'] > 0)
                                            <span class="inline-flex items-center text-success-600 font-bold">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                </svg>
                                                +{{ $data['ranking_diff'] }}
                                            </span>
                                        @elseif($data['ranking_diff'] < 0)
                                            <span class="inline-flex items-center text-danger-600 font-bold">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                                </svg>
                                                {{ $data['ranking_diff'] }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 font-bold">0</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Insights & Analysis -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 rounded-lg bg-purple-500">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-purple-900">Insight & Analisis</h3>
                        <p class="text-sm text-purple-700">Temuan dari perbandingan periode</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Top Improvers -->
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">🏆 Top 3 Pegawai Paling Meningkat</h4>
                        @php $topImprovers = collect($comparisonData)->sortByDesc('skor_diff')->take(3); @endphp
                        <div class="space-y-2">
                            @foreach ($topImprovers as $index => $data)
                                @if ($data['skor_diff'] > 0)
                                    <div class="flex items-center justify-between p-2 bg-success-50 rounded">
                                        <span class="text-sm font-medium text-gray-900">{{ $data['user']->nama }}</span>
                                        <span
                                            class="text-sm font-bold text-success-600">+{{ number_format($data['skor_diff'], 2) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Need Attention -->
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">⚠️ Pegawai yang Perlu Perhatian</h4>
                        @php $needAttention = collect($comparisonData)->sortBy('skor_diff')->take(3); @endphp
                        <div class="space-y-2">
                            @foreach ($needAttention as $index => $data)
                                @if ($data['skor_diff'] < 0)
                                    <div class="flex items-center justify-between p-2 bg-danger-50 rounded">
                                        <span class="text-sm font-medium text-gray-900">{{ $data['user']->nama }}</span>
                                        <span
                                            class="text-sm font-bold text-danger-600">{{ number_format($data['skor_diff'], 2) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="mt-6 p-4 bg-white rounded-lg">
                    <h4 class="font-semibold text-gray-900 mb-3">💡 Rekomendasi Tindak Lanjut</h4>
                    <ul class="space-y-2 text-sm text-gray-700">
                        @if ($improvedCount > $decreasedCount)
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-success-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <strong>Tren Positif:</strong> Lebih banyak pegawai yang mengalami peningkatan kinerja.
                                Pertahankan strategi pengembangan yang ada.
                            </li>
                        @endif

                        @if ($decreasedCount > 0)
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-warning-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Lakukan evaluasi mendalam terhadap {{ $decreasedCount }} pegawai yang mengalami penurunan
                                kinerja.
                            </li>
                        @endif

                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-primary-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Adakan program mentoring antara pegawai berprestasi dengan yang memerlukan peningkatan.
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Pilih Periode untuk Perbandingan</h3>
                <p class="mt-2 text-gray-500">Pilih dua periode yang berbeda untuk melihat perbandingan hasil evaluasi.</p>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function exportComparison() {
                const params = new URLSearchParams(window.location.search);
                params.set('export', 'true');
                window.location.href = `{{ route('admin.hasil.comparison') }}?${params.toString()}`;
            }

            // Auto-submit form when both periods are selected
            document.addEventListener('DOMContentLoaded', function() {
                const periode1 = document.getElementById('periode1_id');
                const periode2 = document.getElementById('periode2_id');

                function checkAutoSubmit() {
                    if (periode1.value && periode2.value && periode1.value !== periode2.value) {
                        // Auto submit after short delay
                        setTimeout(() => {
                            periode1.form.submit();
                        }, 500);
                    }
                }

                periode1.addEventListener('change', checkAutoSubmit);
                periode2.addEventListener('change', checkAutoSubmit);
            });

            // Prevent selecting same period
            document.getElementById('periode1_id').addEventListener('change', function() {
                const periode2Select = document.getElementById('periode2_id');
                const selectedValue = this.value;

                Array.from(periode2Select.options).forEach(option => {
                    if (option.value === selectedValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });

            document.getElementById('periode2_id').addEventListener('change', function() {
                const periode1Select = document.getElementById('periode1_id');
                const selectedValue = this.value;

                Array.from(periode1Select.options).forEach(option => {
                    if (option.value === selectedValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        </script>
    @endpush
@endsection
