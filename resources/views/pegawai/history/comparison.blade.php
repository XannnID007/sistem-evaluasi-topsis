@extends('layouts.app')

@section('title', 'Perbandingan dengan Rekan')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Perbandingan dengan Rekan Sekerja</h2>
                <p class="text-gray-600 mt-1">Bandingkan kinerja Anda dengan rekan sekerja yang memiliki kelas jabatan sama
                </p>
            </div>
            <a href="{{ route('pegawai.history.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke History
            </a>
        </div>

        <!-- Period Selection -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Pilih Periode untuk Perbandingan</h3>
            <form method="GET" action="{{ route('pegawai.history.comparison') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-64">
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-2">Periode Evaluasi</label>
                    <select id="periode_id" name="periode_id" required
                        class="block w-full py-2 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Pilih Periode</option>
                        @foreach ($periodeList as $periode)
                            <option value="{{ $periode->id }}"
                                {{ request('periode_id') == $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit"
                        class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                        Bandingkan
                    </button>
                </div>
            </form>
        </div>

        @if (isset($userEvaluasi) && isset($peerEvaluations))
            <!-- Comparison Results -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- My Performance -->
                <div class="bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 rounded-xl p-6">
                    <div class="text-center">
                        <div class="mx-auto h-16 w-16 bg-primary-500 rounded-full flex items-center justify-center mb-4">
                            <span
                                class="text-white text-xl font-bold">{{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Kinerja Saya</h3>
                        <p class="text-sm text-gray-600 mb-4">{{ $periode->nama }}</p>

                        <!-- My Stats -->
                        <div class="space-y-3">
                            <div class="bg-white bg-opacity-60 rounded-lg p-3">
                                <p class="text-sm text-gray-600">Total Skor</p>
                                <p class="text-2xl font-bold text-primary-700">
                                    {{ number_format($userEvaluasi->total_skor, 2) }}</p>
                            </div>
                            <div class="bg-white bg-opacity-60 rounded-lg p-3">
                                <p class="text-sm text-gray-600">Ranking</p>
                                <p class="text-xl font-bold text-primary-700">#{{ $userEvaluasi->ranking }}</p>
                            </div>
                            <div class="bg-white bg-opacity-60 rounded-lg p-3">
                                <p class="text-sm text-gray-600">Posisi dari {{ $totalPeers }} pegawai</p>
                                <p class="text-lg font-bold text-primary-700">#{{ $myPosition }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Statistik Perbandingan</h3>

                    <div class="space-y-4">
                        <!-- My Score vs Average -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Skor Saya</p>
                                <p class="text-xs text-gray-600">vs Rata-rata Rekan</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-primary-600">
                                    {{ number_format($userEvaluasi->total_skor, 2) }}</p>
                                <p class="text-sm text-gray-600">vs {{ number_format($avgPeerScore, 2) }}</p>
                                @php $scoreDiff = $userEvaluasi->total_skor - $avgPeerScore; @endphp
                                <p class="text-xs {{ $scoreDiff >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                    {{ $scoreDiff >= 0 ? '+' : '' }}{{ number_format($scoreDiff, 2) }}
                                </p>
                            </div>
                        </div>

                        <!-- Position among peers -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Posisi di Kelas Jabatan</p>
                                <p class="text-xs text-gray-600">{{ auth()->user()->getKelasJabatanText() }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">#{{ $myPosition }}</p>
                                <p class="text-sm text-gray-600">dari {{ $totalPeers }} pegawai</p>
                                @php $percentile = (($totalPeers - $myPosition + 1) / $totalPeers) * 100; @endphp
                                <p class="text-xs text-gray-600">Persentil: {{ number_format($percentile, 0) }}%</p>
                            </div>
                        </div>

                        <!-- Performance Category -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            @php
                                $performanceLevel = match (true) {
                                    $myPosition <= ceil($totalPeers * 0.1) => [
                                        'text' => 'Top Performer',
                                        'color' => 'text-green-600',
                                        'bg' => 'bg-green-100',
                                    ],
                                    $myPosition <= ceil($totalPeers * 0.25) => [
                                        'text' => 'High Performer',
                                        'color' => 'text-blue-600',
                                        'bg' => 'bg-blue-100',
                                    ],
                                    $myPosition <= ceil($totalPeers * 0.75) => [
                                        'text' => 'Average Performer',
                                        'color' => 'text-yellow-600',
                                        'bg' => 'bg-yellow-100',
                                    ],
                                    default => [
                                        'text' => 'Needs Improvement',
                                        'color' => 'text-red-600',
                                        'bg' => 'bg-red-100',
                                    ],
                                };
                            @endphp
                            <div class="text-center">
                                <div
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $performanceLevel['bg'] }} {{ $performanceLevel['color'] }}">
                                    {{ $performanceLevel['text'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Criteria Comparison -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Perbandingan Per Kriteria</h3>

                    @php
                        $avgPeerData = [
                            'c1' => $peerEvaluations->avg('c1_produktivitas'),
                            'c2' => $peerEvaluations->avg('c2_tanggung_jawab'),
                            'c3' => $peerEvaluations->avg('c3_kehadiran'),
                            'c4' => $peerEvaluations->avg('c4_pelanggaran'),
                            'c5' => $peerEvaluations->avg('c5_terlambat'),
                        ];
                    @endphp

                    <div class="space-y-4">
                        <!-- C1 - Produktivitas -->
                        <div class="p-3 bg-primary-50 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-900">Produktivitas</p>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-primary-600">
                                        {{ number_format($userEvaluasi->c1_produktivitas, 1) }}</p>
                                    <p class="text-xs text-gray-600">avg: {{ number_format($avgPeerData['c1'], 1) }}</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary-500 h-2 rounded-full"
                                        style="width: {{ min(100, $userEvaluasi->c1_produktivitas) }}%"></div>
                                </div>
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-gray-400 h-2 rounded-full"
                                        style="width: {{ min(100, $avgPeerData['c1']) }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- C2 - Tanggung Jawab -->
                        <div class="p-3 bg-success-50 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-900">Tanggung Jawab</p>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-success-600">
                                        {{ number_format($userEvaluasi->c2_tanggung_jawab, 1) }}</p>
                                    <p class="text-xs text-gray-600">avg: {{ number_format($avgPeerData['c2'], 1) }}</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-success-500 h-2 rounded-full"
                                        style="width: {{ min(100, $userEvaluasi->c2_tanggung_jawab) }}%"></div>
                                </div>
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-gray-400 h-2 rounded-full"
                                        style="width: {{ min(100, $avgPeerData['c2']) }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- C3 - Kehadiran -->
                        <div class="p-3 bg-secondary-50 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-900">Kehadiran</p>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-secondary-600">
                                        {{ number_format($userEvaluasi->c3_kehadiran, 1) }}</p>
                                    <p class="text-xs text-gray-600">avg: {{ number_format($avgPeerData['c3'], 1) }}</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-secondary-500 h-2 rounded-full"
                                        style="width: {{ min(100, $userEvaluasi->c3_kehadiran) }}%"></div>
                                </div>
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-gray-400 h-2 rounded-full"
                                        style="width: {{ min(100, $avgPeerData['c3']) }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- C4 & C5 - Negative Criteria -->
                        <div class="grid grid-cols-2 gap-2">
                            <div class="p-3 bg-warning-50 rounded-lg text-center">
                                <p class="text-xs text-gray-600 mb-1">Pelanggaran</p>
                                <p class="text-lg font-bold text-warning-600">{{ $userEvaluasi->c4_pelanggaran }}</p>
                                <p class="text-xs text-gray-600">avg: {{ number_format($avgPeerData['c4'], 1) }}</p>
                            </div>
                            <div class="p-3 bg-danger-50 rounded-lg text-center">
                                <p class="text-xs text-gray-600 mb-1">Terlambat</p>
                                <p class="text-lg font-bold text-danger-600">{{ $userEvaluasi->c5_terlambat }}</p>
                                <p class="text-xs text-gray-600">avg: {{ number_format($avgPeerData['c5'], 1) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peer Rankings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Ranking Rekan Sekerja
                            ({{ auth()->user()->getKelasJabatanText() }})</h3>
                        <span class="text-sm text-gray-500">{{ $peerEvaluations->count() + 1 }} pegawai total</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ranking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Skor</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Selisih dengan Saya</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                // Combine user and peer data for sorting
                                $allEvaluations = collect([$userEvaluasi])
                                    ->concat($peerEvaluations)
                                    ->sortByDesc('total_skor')
                                    ->values();
                            @endphp

                            @foreach ($allEvaluations as $index => $evaluation)
                                @php $isCurrentUser = $evaluation->user_id === auth()->id(); @endphp
                                <tr class="{{ $isCurrentUser ? 'bg-primary-50' : 'hover:bg-gray-50' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $position = $index + 1;
                                            $rankingColor = match (true) {
                                                $position <= 3 => 'bg-yellow-100 text-yellow-800',
                                                $position <= 5 => 'bg-blue-100 text-blue-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-bold {{ $rankingColor }}">
                                            #{{ $position }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 flex-shrink-0">
                                                <div
                                                    class="h-8 w-8 rounded-full {{ $isCurrentUser ? 'bg-primary-500' : 'bg-gray-500' }} flex items-center justify-center">
                                                    <span class="text-white font-medium text-xs">
                                                        {{ strtoupper(substr($evaluation->user->nama, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $isCurrentUser ? 'Saya (' . $evaluation->user->nama . ')' : $evaluation->user->nama }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $evaluation->user->jabatan }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div
                                            class="text-lg font-bold {{ $isCurrentUser ? 'text-primary-600' : 'text-gray-900' }}">
                                            {{ number_format($evaluation->total_skor, 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if (!$isCurrentUser)
                                            @php $diff = $evaluation->total_skor - $userEvaluasi->total_skor; @endphp
                                            <span
                                                class="text-sm {{ $diff > 0 ? 'text-red-600' : 'text-green-600' }} font-medium">
                                                {{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 2) }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-500">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Insights and Recommendations -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Insights & Rekomendasi</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Strengths -->
                    <div>
                        <h4 class="text-md font-medium text-green-700 mb-3">Kekuatan Anda</h4>
                        <div class="space-y-2">
                            @if ($userEvaluasi->c1_produktivitas > $avgPeerData['c1'])
                                <div class="flex items-center p-2 bg-green-50 rounded">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-green-700">Produktivitas di atas rata-rata rekan</span>
                                </div>
                            @endif
                            @if ($userEvaluasi->c2_tanggung_jawab > $avgPeerData['c2'])
                                <div class="flex items-center p-2 bg-green-50 rounded">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-green-700">Tanggung jawab lebih baik dari rekan</span>
                                </div>
                            @endif
                            @if ($userEvaluasi->c3_kehadiran > $avgPeerData['c3'])
                                <div class="flex items-center p-2 bg-green-50 rounded">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-green-700">Kehadiran konsisten dan baik</span>
                                </div>
                            @endif
                            @if ($userEvaluasi->c4_pelanggaran < $avgPeerData['c4'])
                                <div class="flex items-center p-2 bg-green-50 rounded">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-green-700">Disiplin lebih baik dari rata-rata</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Areas for Improvement -->
                    <div>
                        <h4 class="text-md font-medium text-red-700 mb-3">Area Perbaikan</h4>
                        <div class="space-y-2">
                            @if ($userEvaluasi->c1_produktivitas < $avgPeerData['c1'])
                                <div class="flex items-center p-2 bg-red-50 rounded">
                                    <svg class="h-4 w-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-red-700">Tingkatkan produktivitas kerja</span>
                                </div>
                            @endif
                            @if ($userEvaluasi->c2_tanggung_jawab < $avgPeerData['c2'])
                                <div class="flex items-center p-2 bg-red-50 rounded">
                                    <svg class="h-4 w-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-red-700">Perkuat sense of responsibility</span>
                                </div>
                            @endif
                            @if ($userEvaluasi->c3_kehadiran < $avgPeerData['c3'])
                                <div class="flex items-center p-2 bg-red-50 rounded">
                                    <svg class="h-4 w-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-red-700">Tingkatkan konsistensi kehadiran</span>
                                </div>
                            @endif
                            @if ($userEvaluasi->c4_pelanggaran > $avgPeerData['c4'])
                                <div class="flex items-center p-2 bg-red-50 rounded">
                                    <svg class="h-4 w-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-red-700">Kurangi pelanggaran disiplin</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Overall Recommendation -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800">Rekomendasi Umum</h4>
                            <p class="text-sm text-blue-700 mt-1">
                                @if ($myPosition <= ceil($totalPeers * 0.25))
                                    Pertahankan kinerja yang sudah baik dan jadilah mentor bagi rekan-rekan yang membutuhkan
                                    bantuan. Fokus pada konsistensi dan inovasi dalam pekerjaan.
                                @elseif ($myPosition <= ceil($totalPeers * 0.75))
                                    Anda berada di posisi yang cukup baik. Identifikasi area yang masih bisa ditingkatkan
                                    dan pelajari dari rekan-rekan yang memiliki performa lebih tinggi.
                                @else
                                    Fokus pada perbaikan di area-area yang masih kurang. Jangan ragu untuk meminta bantuan
                                    atau mentoring dari rekan-rekan yang memiliki performa lebih baik.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            // Auto submit form when period is selected
            document.getElementById('periode_id').addEventListener('change', function() {
                if (this.value) {
                    this.form.submit();
                }
            });
        </script>
    @endpush
@endsection
