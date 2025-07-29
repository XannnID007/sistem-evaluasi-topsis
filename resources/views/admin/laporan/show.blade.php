@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Laporan Evaluasi</h2>
                <p class="text-gray-600 mt-1">Laporan Ranking Evaluasi Kinerja April 2025</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="downloadReport()"
                    class="inline-flex items-center px-4 py-2 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Download
                </button>
                <button onclick="shareReport()"
                    class="inline-flex items-center px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                        </path>
                    </svg>
                    Share
                </button>
                <a href="{{ route('admin.laporan.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Report Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-primary-100">
                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Jenis Laporan</p>
                        <p class="text-lg font-bold text-gray-900">Ranking</p>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-success-100">
                        <svg class="h-6 w-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m-7 9a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Periode</p>
                        <p class="text-lg font-bold text-gray-900">April 2025</p>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-warning-100">
                        <svg class="h-6 w-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Format</p>
                        <p class="text-lg font-bold text-gray-900">PDF</p>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-secondary-100">
                        <svg class="h-6 w-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Dibuat</p>
                        <p class="text-lg font-bold text-gray-900">1 Mei 2025</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Preview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Preview Laporan</h3>
                    <div class="flex items-center space-x-2">
                        <button onclick="zoomOut()"
                            class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>
                        <span id="zoomLevel" class="text-sm text-gray-600">100%</span>
                        <button onclick="zoomIn()"
                            class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </button>
                        <button onclick="toggleFullscreen()"
                            class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Report Content Preview -->
            <div id="reportPreview" class="p-6" style="transform: scale(1); transform-origin: top left;">
                <!-- Report Header -->
                <div class="text-center mb-8 pb-6 border-b-2 border-gray-200">
                    <div class="flex items-center justify-center mb-4">
                        <img src="../images/logo.jpeg" alt="Logo Kecamatan" class="h-12 w-12 mr-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">KECAMATAN CANGKUANG</h1>
                            <p class="text-lg text-gray-600">KABUPATEN BANDUNG</p>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mt-4">LAPORAN RANKING EVALUASI KINERJA PEGAWAI</h2>
                    <p class="text-gray-600">Periode: April 2025</p>
                </div>

                <!-- Executive Summary -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Eksekutif</h3>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-primary-600">21</p>
                                <p class="text-sm text-gray-600">Total Pegawai</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-success-600">18</p>
                                <p class="text-sm text-gray-600">Evaluasi Selesai</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-warning-600">142.5</p>
                                <p class="text-sm text-gray-600">Rata-rata Skor</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-secondary-600">85.7%</p>
                                <p class="text-sm text-gray-600">Tingkat Partisipasi</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700">
                            Evaluasi kinerja periode April 2025 menunjukkan tingkat partisipasi yang tinggi dengan
                            rata-rata skor 142.5 dari skala CPI. Mayoritas pegawai menunjukkan kinerja yang baik
                            dengan distribusi skor yang merata across different performance levels.
                        </p>
                    </div>
                </div>

                <!-- Ranking Table -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Ranking Kinerja Pegawai</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase border-b border-gray-300">
                                        Ranking</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase border-b border-gray-300">
                                        Nama Pegawai</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase border-b border-gray-300">
                                        Jabatan</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase border-b border-gray-300">
                                        Total Skor</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase border-b border-gray-300">
                                        Kategori</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @php
                                    $sampleData = [
                                        [
                                            'ranking' => 1,
                                            'nama' => 'Hari Sumarhadi, S.A.P.',
                                            'jabatan' => 'Pengolah Data dan Informasi',
                                            'skor' => 156.0,
                                            'kategori' => 'Sangat Baik',
                                        ],
                                        [
                                            'ranking' => 2,
                                            'nama' => 'Agus Mulya, S.PT., MM',
                                            'jabatan' => 'Plt. Plt.(u) Camat',
                                            'skor' => 150.3,
                                            'kategori' => 'Sangat Baik',
                                        ],
                                        [
                                            'ranking' => 3,
                                            'nama' => 'Andri Yudha Prawira, S.I.P., M.SI.',
                                            'jabatan' => 'Sekretaris Kecamatan',
                                            'skor' => 149.3,
                                            'kategori' => 'Baik',
                                        ],
                                        [
                                            'ranking' => 4,
                                            'nama' => 'Siti Noviyanti S.Sos, M.K.P',
                                            'jabatan' => 'Kepala Seksi Pemerintahan',
                                            'skor' => 136.0,
                                            'kategori' => 'Baik',
                                        ],
                                        [
                                            'ranking' => 5,
                                            'nama' => 'Rahmat Hidayat, SH',
                                            'jabatan' => 'Kepala Sub Bagian Program dan Keuangan',
                                            'skor' => 136.5,
                                            'kategori' => 'Baik',
                                        ],
                                        [
                                            'ranking' => 6,
                                            'nama' => 'Ajo Suarjo, S.M.',
                                            'jabatan' => 'Penelaah Teknis Kebijakan',
                                            'skor' => 134.2,
                                            'kategori' => 'Baik',
                                        ],
                                        [
                                            'ranking' => 7,
                                            'nama' => 'Reny Yulia, SH, M.SI',
                                            'jabatan' => 'Kepala Seksi Pemberdayaan Masyarakat',
                                            'skor' => 132.8,
                                            'kategori' => 'Baik',
                                        ],
                                        [
                                            'ranking' => 8,
                                            'nama' => 'Fahmi Taufik Firdaus, A.Md.',
                                            'jabatan' => 'Arsiparis Terampil',
                                            'skor' => 130.5,
                                            'kategori' => 'Baik',
                                        ],
                                    ];
                                @endphp
                                @foreach ($sampleData as $index => $pegawai)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-4 py-3 border-b border-gray-200">
                                            <div class="flex items-center">
                                                @if ($pegawai['ranking'] <= 3)
                                                    @php
                                                        $medalColor = match ($pegawai['ranking']) {
                                                            1 => 'text-yellow-500',
                                                            2 => 'text-gray-400',
                                                            3 => 'text-orange-500',
                                                        };
                                                    @endphp
                                                    <svg class="h-5 w-5 {{ $medalColor }} mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                @endif
                                                <span class="font-bold text-lg">#{{ $pegawai['ranking'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border-b border-gray-200">
                                            <p class="font-medium text-gray-900">{{ $pegawai['nama'] }}</p>
                                        </td>
                                        <td class="px-4 py-3 border-b border-gray-200">
                                            <p class="text-sm text-gray-700">{{ $pegawai['jabatan'] }}</p>
                                        </td>
                                        <td class="px-4 py-3 border-b border-gray-200 text-center">
                                            <span
                                                class="font-bold text-lg text-gray-900">{{ number_format($pegawai['skor'], 2) }}</span>
                                        </td>
                                        <td class="px-4 py-3 border-b border-gray-200 text-center">
                                            @php
                                                $badgeColor = match ($pegawai['kategori']) {
                                                    'Sangat Baik' => 'bg-green-100 text-green-800',
                                                    'Baik' => 'bg-blue-100 text-blue-800',
                                                    'Cukup' => 'bg-yellow-100 text-yellow-800',
                                                    'Kurang' => 'bg-red-100 text-red-800',
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                                {{ $pegawai['kategori'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Performance Distribution Chart -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Distribusi Kinerja</h3>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="text-center p-4 bg-green-100 rounded-lg">
                                <p class="text-2xl font-bold text-green-600">3</p>
                                <p class="text-sm text-green-700">Sangat Baik</p>
                                <p class="text-xs text-gray-500">(>150)</p>
                            </div>
                            <div class="text-center p-4 bg-blue-100 rounded-lg">
                                <p class="text-2xl font-bold text-blue-600">12</p>
                                <p class="text-sm text-blue-700">Baik</p>
                                <p class="text-xs text-gray-500">(130-150)</p>
                            </div>
                            <div class="text-center p-4 bg-yellow-100 rounded-lg">
                                <p class="text-2xl font-bold text-yellow-600">5</p>
                                <p class="text-sm text-yellow-700">Cukup</p>
                                <p class="text-xs text-gray-500">(110-130)</p>
                            </div>
                            <div class="text-center p-4 bg-red-100 rounded-lg">
                                <p class="text-2xl font-bold text-red-600">1</p>
                                <p class="text-sm text-red-700">Kurang</p>
                                <p class="text-xs text-gray-500">(<110)< /p>
                            </div>
                        </div>

                        <!-- Simple Bar Chart Representation -->
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-20 text-sm text-gray-700">Sangat Baik</div>
                                <div class="flex-1 bg-gray-200 rounded-full h-4 ml-4">
                                    <div class="bg-green-500 h-4 rounded-full" style="width: 17%"></div>
                                </div>
                                <div class="w-10 text-sm text-gray-700 text-right ml-2">17%</div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-20 text-sm text-gray-700">Baik</div>
                                <div class="flex-1 bg-gray-200 rounded-full h-4 ml-4">
                                    <div class="bg-blue-500 h-4 rounded-full" style="width: 67%"></div>
                                </div>
                                <div class="w-10 text-sm text-gray-700 text-right ml-2">67%</div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-20 text-sm text-gray-700">Cukup</div>
                                <div class="flex-1 bg-gray-200 rounded-full h-4 ml-4">
                                    <div class="bg-yellow-500 h-4 rounded-full" style="width: 28%"></div>
                                </div>
                                <div class="w-10 text-sm text-gray-700 text-right ml-2">28%</div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-20 text-sm text-gray-700">Kurang</div>
                                <div class="flex-1 bg-gray-200 rounded-full h-4 ml-4">
                                    <div class="bg-red-500 h-4 rounded-full" style="width: 6%"></div>
                                </div>
                                <div class="w-10 text-sm text-gray-700 text-right ml-2">6%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Criteria Analysis -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Analisis Per Kriteria</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="bg-primary-50 p-4 rounded-lg text-center">
                            <h4 class="font-semibold text-primary-900">C1 - Produktivitas</h4>
                            <p class="text-2xl font-bold text-primary-600 mt-2">87.3</p>
                            <p class="text-sm text-primary-700">Rata-rata</p>
                            <div class="mt-2 text-xs text-primary-600">Bobot: 40%</div>
                        </div>
                        <div class="bg-success-50 p-4 rounded-lg text-center">
                            <h4 class="font-semibold text-success-900">C2 - Tanggung Jawab</h4>
                            <p class="text-2xl font-bold text-success-600 mt-2">89.1</p>
                            <p class="text-sm text-success-700">Rata-rata</p>
                            <div class="mt-2 text-xs text-success-600">Bobot: 20%</div>
                        </div>
                        <div class="bg-secondary-50 p-4 rounded-lg text-center">
                            <h4 class="font-semibold text-secondary-900">C3 - Kehadiran</h4>
                            <p class="text-2xl font-bold text-secondary-600 mt-2">92.8</p>
                            <p class="text-sm text-secondary-700">Rata-rata</p>
                            <div class="mt-2 text-xs text-secondary-600">Bobot: 20%</div>
                        </div>
                        <div class="bg-warning-50 p-4 rounded-lg text-center">
                            <h4 class="font-semibold text-warning-900">C4 - Pelanggaran</h4>
                            <p class="text-2xl font-bold text-warning-600 mt-2">0.8</p>
                            <p class="text-sm text-warning-700">Rata-rata</p>
                            <div class="mt-2 text-xs text-warning-600">Bobot: 10%</div>
                        </div>
                        <div class="bg-danger-50 p-4 rounded-lg text-center">
                            <h4 class="font-semibold text-danger-900">C5 - Terlambat</h4>
                            <p class="text-2xl font-bold text-danger-600 mt-2">1.2</p>
                            <p class="text-sm text-danger-700">Rata-rata</p>
                            <div class="mt-2 text-xs text-danger-600">Bobot: 10%</div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Rekomendasi</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <ul class="space-y-2 text-sm text-blue-900">
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Pertahankan kinerja pegawai dengan kategori "Sangat Baik" melalui program penghargaan dan
                                pengembangan karir.
                            </li>
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Berikan pelatihan tambahan untuk meningkatkan produktivitas kerja pegawai dengan skor di
                                bawah rata-rata.
                            </li>
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Implementasikan sistem monitoring kehadiran yang lebih ketat untuk mengurangi tingkat
                                keterlambatan.
                            </li>
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Selenggarakan program mentoring untuk pegawai dengan kinerja kurang optimal oleh pegawai
                                berprestasi.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Report Footer -->
                <div class="border-t-2 border-gray-200 pt-6 mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Laporan ini dibuat secara otomatis oleh Sistem Evaluasi Kinerja Kecamatan Cangkuang
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        Digenerate pada: {{ now()->format('d F Y, H:i:s') }} WIB
                    </p>
                </div>
            </div>
        </div>

        <!-- Report Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Laporan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="printReport()"
                    class="flex items-center justify-center px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Print Laporan
                </button>

                <button onclick="emailReport()"
                    class="flex items-center justify-center px-4 py-3 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    Kirim via Email
                </button>

                <button onclick="regenerateReport()"
                    class="flex items-center justify-center px-4 py-3 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Generate Ulang
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentZoom = 100;

            function downloadReport() {
                // Simulate download
                const link = document.createElement('a');
                link.href = '#'; // In real app, this would be the actual download URL
                link.download = 'Laporan_Ranking_April_2025.pdf';
                alert('Download laporan dimulai...');
            }

            function shareReport() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Laporan Ranking Evaluasi Kinerja April 2025',
                        text: 'Laporan ranking evaluasi kinerja pegawai Kecamatan Cangkuang',
                        url: window.location.href
                    });
                } else {
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('Link laporan berhasil disalin ke clipboard!');
                    });
                }
            }

            function zoomIn() {
                if (currentZoom < 150) {
                    currentZoom += 10;
                    updateZoom();
                }
            }

            function zoomOut() {
                if (currentZoom > 50) {
                    currentZoom -= 10;
                    updateZoom();
                }
            }

            function updateZoom() {
                const preview = document.getElementById('reportPreview');
                preview.style.transform = `scale(${currentZoom / 100})`;
                document.getElementById('zoomLevel').textContent = currentZoom + '%';
            }

            function toggleFullscreen() {
                const preview = document.getElementById('reportPreview');
                if (!document.fullscreenElement) {
                    preview.requestFullscreen().catch(err => {
                        console.log('Error attempting to enable fullscreen:', err);
                    });
                } else {
                    document.exitFullscreen();
                }
            }

            function printReport() {
                const printContent = document.getElementById('reportPreview').innerHTML;
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Laporan Ranking Evaluasi Kinerja</title>
                            <style>
                                body { font-family: Arial, sans-serif; margin: 20px; }
                                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                                th { background-color: #f2f2f2; }
                                .bg-gray-50 { background-color: #f9f9f9; }
                                .text-center { text-align: center; }
                                .font-bold { font-weight: bold; }
                                .text-lg { font-size: 1.125rem; }
                                .text-2xl { font-size: 1.5rem; }
                                .mb-4 { margin-bottom: 1rem; }
                                .mb-8 { margin-bottom: 2rem; }
                                .p-4 { padding: 1rem; }
                                .p-6 { padding: 1.5rem; }
                                .grid { display: grid; }
                                .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
                                .gap-4 { gap: 1rem; }
                                .rounded-lg { border-radius: 0.5rem; }
                                .border { border: 1px solid #e5e7eb; }
                                @media print {
                                    body { margin: 0; }
                                    .no-print { display: none; }
                                }
                            </style>
                        </head>
                        <body>
                            ${printContent}
                        </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.print();
            }

            function emailReport() {
                // Show email dialog
                const email = prompt('Masukkan alamat email tujuan:');
                if (email) {
                    alert(`Laporan akan dikirim ke: ${email}`);
                    // In real app, this would trigger an API call to send email
                }
            }

            function regenerateReport() {
                if (confirm('Apakah Anda yakin ingin generate ulang laporan ini dengan data terbaru?')) {
                    alert('Laporan sedang di-generate ulang...');
                    // In real app, this would redirect to generate page with same parameters
                    // window.location.href = '{{ route('admin.laporan.generate') }}?periode_id=1&jenis_laporan=ranking&format=pdf';
                }
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.key) {
                        case '=':
                        case '+':
                            e.preventDefault();
                            zoomIn();
                            break;
                        case '-':
                            e.preventDefault();
                            zoomOut();
                            break;
                        case 'p':
                            e.preventDefault();
                            printReport();
                            break;
                        case 'd':
                            e.preventDefault();
                            downloadReport();
                            break;
                    }
                }

                if (e.key === 'F11') {
                    e.preventDefault();
                    toggleFullscreen();
                }
            });
        </script>
    @endpush
@endsection
