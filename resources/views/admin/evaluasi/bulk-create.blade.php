@extends('layouts.app')

@section('title', 'Input Evaluasi Batch')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Input Evaluasi Batch</h2>
                <p class="text-gray-600 mt-1">Input evaluasi untuk beberapa pegawai sekaligus pada periode yang sama</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.evaluasi.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Input Tunggal
                </a>
                <a href="{{ route('admin.evaluasi.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Info Periode -->
        @if ($periodeAktif)
            <div class="bg-gradient-to-r from-primary-50 to-primary-100 border border-primary-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-primary-500">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m-7 9a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-primary-900">{{ $periodeAktif->nama }}</h3>
                        <p class="text-primary-700">{{ $periodeAktif->getFormattedTanggal() }}</p>
                        <p class="text-sm text-primary-600 mt-1">
                            {{ $pegawaiTersedia->count() }} pegawai tersedia untuk evaluasi
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <div class="flex">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Peringatan!</strong> Tidak ada periode evaluasi yang aktif saat ini.
                            <a href="{{ route('admin.periode.index') }}" class="underline hover:text-yellow-800">Kelola
                                periode evaluasi</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if ($periodeAktif && $pegawaiTersedia->count() > 0)
            <!-- Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('admin.evaluasi.bulk-store') }}" method="POST" class="p-6 space-y-6" id="bulkForm">
                    @csrf
                    <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">

                    <!-- Criteria Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                            Kriteria Evaluasi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                            @foreach ($kriteria as $k)
                                <div class="text-center p-4 bg-gray-50 rounded-lg">
                                    <div class="text-lg font-bold text-primary-600">{{ $k->kode }}</div>
                                    <div class="text-sm font-medium text-gray-900 mt-1">{{ $k->nama }}</div>
                                    <div class="text-xs text-gray-600">{{ $k->getFormattedBobot() }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $k->tren == 'positif' ? 'Positif' : 'Negatif' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pegawai List -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Daftar Pegawai</h3>
                            <div class="flex space-x-2">
                                <button type="button" onclick="selectAll()"
                                    class="px-3 py-1 text-sm bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                    Pilih Semua
                                </button>
                                <button type="button" onclick="deselectAll()"
                                    class="px-3 py-1 text-sm bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                    Hapus Pilihan
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll()"
                                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pegawai</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            C1<br>Produktivitas</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            C2<br>Tanggung Jawab</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            C3<br>Kehadiran</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            C4<br>Pelanggaran</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            C5<br>Terlambat</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pegawaiTersedia as $index => $pegawai)
                                        <tr class="hover:bg-gray-50 pegawai-row" data-index="{{ $index }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="selected_pegawai[]"
                                                    value="{{ $pegawai->id }}"
                                                    class="pegawai-checkbox h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                                    onchange="togglePegawaiRow({{ $index }})">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <div
                                                            class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center">
                                                            <span class="text-white font-medium text-sm">
                                                                {{ strtoupper(substr($pegawai->nama, 0, 2)) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $pegawai->nama }}</div>
                                                        <div class="text-sm text-gray-500">{{ $pegawai->jabatan }}</div>
                                                        <div class="text-xs text-gray-400">
                                                            {{ $pegawai->getKelasJabatanShort() }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="number"
                                                    name="evaluasi[{{ $index }}][c1_produktivitas]" min="0"
                                                    max="100" step="0.1"
                                                    class="evaluasi-input w-20 px-2 py-1 text-center border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                    placeholder="0-100" disabled>
                                                <input type="hidden" name="evaluasi[{{ $index }}][user_id]"
                                                    value="{{ $pegawai->id }}">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="number"
                                                    name="evaluasi[{{ $index }}][c2_tanggung_jawab]"
                                                    min="0" max="100" step="0.1"
                                                    class="evaluasi-input w-20 px-2 py-1 text-center border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                    placeholder="0-100" disabled>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="number" name="evaluasi[{{ $index }}][c3_kehadiran]"
                                                    min="0" max="100" step="0.1"
                                                    class="evaluasi-input w-20 px-2 py-1 text-center border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                    placeholder="0-100" disabled>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="number"
                                                    name="evaluasi[{{ $index }}][c4_pelanggaran]" min="0"
                                                    step="1"
                                                    class="evaluasi-input w-20 px-2 py-1 text-center border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                    placeholder="0" disabled>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="number" name="evaluasi[{{ $index }}][c5_terlambat]"
                                                    min="0" step="1"
                                                    class="evaluasi-input w-20 px-2 py-1 text-center border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                    placeholder="0" disabled>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Quick Fill Section -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Isi Cepat (Opsional)</h4>
                        <p class="text-sm text-gray-600 mb-4">Isi nilai yang sama untuk semua pegawai yang dipilih, lalu
                            sesuaikan secara individual jika diperlukan</p>

                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">C1 - Produktivitas</label>
                                <input type="number" id="quick_c1" min="0" max="100" step="0.1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="0-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">C2 - Tanggung Jawab</label>
                                <input type="number" id="quick_c2" min="0" max="100" step="0.1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="0-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">C3 - Kehadiran</label>
                                <input type="number" id="quick_c3" min="0" max="100" step="0.1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="0-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">C4 - Pelanggaran</label>
                                <input type="number" id="quick_c4" min="0" step="1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">C5 - Terlambat</label>
                                <input type="number" id="quick_c5" min="0" step="1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="0">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="button" onclick="applyQuickFill()"
                                class="px-4 py-2 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                                Terapkan ke Pegawai Terpilih
                            </button>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="bg-primary-50 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-primary-900 mb-2">Ringkasan</h4>
                        <p class="text-primary-700">
                            <span id="selectedCount">0</span> pegawai dipilih untuk evaluasi.
                            Pastikan semua nilai sudah diisi dengan benar sebelum menyimpan.
                        </p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.evaluasi.index') }}"
                            class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit" id="submitBtn" disabled
                            class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                            Simpan Evaluasi Batch
                        </button>
                    </div>
                </form>
            </div>
        @elseif($periodeAktif && $pegawaiTersedia->count() == 0)
            <!-- No Available Employees -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                    </path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak Ada Pegawai Tersedia</h3>
                <p class="mt-2 text-gray-500">
                    Semua pegawai sudah dievaluasi pada periode {{ $periodeAktif->nama }} atau tidak ada pegawai aktif.
                </p>
                <div class="mt-6">
                    <a href="{{ route('admin.evaluasi.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                        Lihat Evaluasi yang Sudah Ada
                    </a>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            let selectedPegawai = new Set();

            function toggleSelectAll() {
                const selectAllCheckbox = document.getElementById('selectAllCheckbox');
                const pegawaiCheckboxes = document.querySelectorAll('.pegawai-checkbox');

                pegawaiCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                    const index = checkbox.closest('.pegawai-row').dataset.index;
                    togglePegawaiRow(index, checkbox.checked);
                });

                updateSelectedCount();
            }

            function selectAll() {
                document.getElementById('selectAllCheckbox').checked = true;
                toggleSelectAll();
            }

            function deselectAll() {
                document.getElementById('selectAllCheckbox').checked = false;
                toggleSelectAll();
            }

            function togglePegawaiRow(index, forceValue = null) {
                const row = document.querySelector(`[data-index="${index}"]`);
                const checkbox = row.querySelector('.pegawai-checkbox');
                const inputs = row.querySelectorAll('.evaluasi-input');

                const isChecked = forceValue !== null ? forceValue : checkbox.checked;

                if (isChecked) {
                    selectedPegawai.add(index);
                    row.classList.add('bg-primary-50', 'border-primary-200');
                    inputs.forEach(input => {
                        input.disabled = false;
                        input.required = true;
                    });
                } else {
                    selectedPegawai.delete(index);
                    row.classList.remove('bg-primary-50', 'border-primary-200');
                    inputs.forEach(input => {
                        input.disabled = true;
                        input.required = false;
                        input.value = '';
                    });
                }

                updateSelectedCount();
                updateSelectAllCheckbox();
            }

            function updateSelectAllCheckbox() {
                const selectAllCheckbox = document.getElementById('selectAllCheckbox');
                const pegawaiCheckboxes = document.querySelectorAll('.pegawai-checkbox');
                const checkedBoxes = document.querySelectorAll('.pegawai-checkbox:checked');

                if (checkedBoxes.length === 0) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = false;
                } else if (checkedBoxes.length === pegawaiCheckboxes.length) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.indeterminate = true;
                }
            }

            function updateSelectedCount() {
                const count = selectedPegawai.size;
                document.getElementById('selectedCount').textContent = count;

                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = count === 0;
            }

            function applyQuickFill() {
                const quickValues = {
                    c1_produktivitas: document.getElementById('quick_c1').value,
                    c2_tanggung_jawab: document.getElementById('quick_c2').value,
                    c3_kehadiran: document.getElementById('quick_c3').value,
                    c4_pelanggaran: document.getElementById('quick_c4').value,
                    c5_terlambat: document.getElementById('quick_c5').value
                };

                selectedPegawai.forEach(index => {
                    const row = document.querySelector(`[data-index="${index}"]`);
                    Object.keys(quickValues).forEach(criteria => {
                        if (quickValues[criteria] !== '') {
                            const input = row.querySelector(`input[name="evaluasi[${index}][${criteria}]"]`);
                            if (input) {
                                input.value = quickValues[criteria];
                            }
                        }
                    });
                });

                // Clear quick fill inputs
                Object.keys(quickValues).forEach((_, i) => {
                    document.getElementById(`quick_c${i + 1}`).value = '';
                });
            }

            // Form validation
            document.getElementById('bulkForm').addEventListener('submit', function(e) {
                if (selectedPegawai.size === 0) {
                    e.preventDefault();
                    alert('Silakan pilih minimal satu pegawai untuk dievaluasi!');
                    return false;
                }

                let isValid = true;
                let emptyFields = [];

                selectedPegawai.forEach(index => {
                    const row = document.querySelector(`[data-index="${index}"]`);
                    const pegawaiName = row.querySelector('.text-sm.font-medium').textContent;
                    const inputs = row.querySelectorAll('.evaluasi-input:not([disabled])');

                    inputs.forEach(input => {
                        if (!input.value || input.value < 0) {
                            isValid = false;
                            const criteria = input.name.match(/\[([^\]]+)\]/g)[1].replace(/[\[\]]/g,
                            '');
                            emptyFields.push(`${pegawaiName} - ${criteria}`);
                        }
                    });
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Masih ada field yang kosong atau tidak valid:\n' + emptyFields.slice(0, 5).join('\n') +
                        (emptyFields.length > 5 ? '\n... dan lainnya' : ''));
                    return false;
                }

                // Confirm before submit
                if (!confirm(`Apakah Anda yakin ingin menyimpan evaluasi untuk ${selectedPegawai.size} pegawai?`)) {
                    e.preventDefault();
                    return false;
                }
            });

            // Initialize
            document.addEventListener('DOMContentLoaded', function() {
                updateSelectedCount();
            });
        </script>
    @endpush
@endsection
