<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteriaList = Kriteria::orderBy('kode')->get();

        // Hitung total bobot
        $totalBobot = Kriteria::where('status', 'aktif')->sum('bobot');
        $bobotValid = abs($totalBobot - 1.0) < 0.001; // Allow small floating point differences

        return view('admin.kriteria.index', compact('kriteriaList', 'totalBobot', 'bobotValid'));
    }

    public function create()
    {
        // Hitung total bobot yang sudah ada
        $totalBobotAda = Kriteria::where('status', 'aktif')->sum('bobot');
        $sisaBobot = 1.0 - $totalBobotAda;

        return view('admin.kriteria.create', compact('sisaBobot'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:kriteria,kode',
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1',
            'tren' => 'required|in:positif,negatif',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Validasi total bobot jika status aktif
        if ($validated['status'] === 'aktif') {
            $totalBobotSetelah = Kriteria::where('status', 'aktif')->sum('bobot') + $validated['bobot'];

            if ($totalBobotSetelah > 1.001) { // Allow small tolerance
                return back()->withErrors(['bobot' => 'Total bobot kriteria aktif tidak boleh lebih dari 100%.'])
                    ->withInput();
            }
        }

        Kriteria::create($validated);

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function show(Kriteria $kriteria)
    {
        return view('admin.kriteria.show', compact('kriteria'));
    }

    public function edit(Kriteria $kriteria)
    {
        // Hitung sisa bobot (exclude kriteria yang sedang diedit)
        $totalBobotLain = Kriteria::where('status', 'aktif')
            ->where('id', '!=', $kriteria->id)
            ->sum('bobot');
        $sisaBobot = 1.0 - $totalBobotLain;

        return view('admin.kriteria.edit', compact('kriteria', 'sisaBobot'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', Rule::unique('kriteria')->ignore($kriteria->id)],
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:1',
            'tren' => 'required|in:positif,negatif',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Validasi total bobot jika status aktif
        if ($validated['status'] === 'aktif') {
            $totalBobotLain = Kriteria::where('status', 'aktif')
                ->where('id', '!=', $kriteria->id)
                ->sum('bobot');
            $totalBobotSetelah = $totalBobotLain + $validated['bobot'];

            if ($totalBobotSetelah > 1.001) { // Allow small tolerance
                return back()->withErrors(['bobot' => 'Total bobot kriteria aktif tidak boleh lebih dari 100%.'])
                    ->withInput();
            }
        }

        $kriteria->update($validated);

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriteria)
    {
        // Cek apakah kriteria digunakan di evaluasi
        $digunakan = DB::table('evaluasi')
            ->where(function ($query) use ($kriteria) {
                // Check if this criteria is used in any evaluations
                switch ($kriteria->kode) {
                    case 'C1':
                        $query->whereNotNull('c1_produktivitas');
                        break;
                    case 'C2':
                        $query->whereNotNull('c2_tanggung_jawab');
                        break;
                    case 'C3':
                        $query->whereNotNull('c3_kehadiran');
                        break;
                    case 'C4':
                        $query->whereNotNull('c4_pelanggaran');
                        break;
                    case 'C5':
                        $query->whereNotNull('c5_terlambat');
                        break;
                }
            })
            ->exists();

        if ($digunakan) {
            return back()->with('error', 'Kriteria tidak dapat dihapus karena sudah digunakan dalam evaluasi.');
        }

        $kriteria->delete();

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }

    public function toggleStatus(Kriteria $kriteria)
    {
        $newStatus = $kriteria->status === 'aktif' ? 'nonaktif' : 'aktif';

        // Jika akan diaktifkan, validasi total bobot
        if ($newStatus === 'aktif') {
            $totalBobotLain = Kriteria::where('status', 'aktif')
                ->where('id', '!=', $kriteria->id)
                ->sum('bobot');
            $totalBobotSetelah = $totalBobotLain + $kriteria->bobot;

            if ($totalBobotSetelah > 1.001) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat mengaktifkan kriteria karena total bobot akan melebihi 100%.'
                ]);
            }
        }

        $kriteria->update(['status' => $newStatus]);

        $message = $newStatus === 'aktif' ? 'Kriteria berhasil diaktifkan.' : 'Kriteria berhasil dinonaktifkan.';

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function resetToDefault()
    {
        try {
            DB::beginTransaction();

            // Reset ke kriteria default (C1-C5) sesuai seeder
            Kriteria::truncate();

            $defaultKriteria = [
                [
                    'kode' => 'C1',
                    'nama' => 'Produktivitas Kerja',
                    'bobot' => 0.40,
                    'tren' => 'positif',
                    'status' => 'aktif',
                ],
                [
                    'kode' => 'C2',
                    'nama' => 'Tanggung Jawab',
                    'bobot' => 0.20,
                    'tren' => 'positif',
                    'status' => 'aktif',
                ],
                [
                    'kode' => 'C3',
                    'nama' => 'Kehadiran',
                    'bobot' => 0.20,
                    'tren' => 'positif',
                    'status' => 'aktif',
                ],
                [
                    'kode' => 'C4',
                    'nama' => 'Pelanggaran Disiplin',
                    'bobot' => 0.10,
                    'tren' => 'negatif',
                    'status' => 'aktif',
                ],
                [
                    'kode' => 'C5',
                    'nama' => 'Terlambat',
                    'bobot' => 0.10,
                    'tren' => 'negatif',
                    'status' => 'aktif',
                ],
            ];

            foreach ($defaultKriteria as $kriteria) {
                Kriteria::create($kriteria);
            }

            DB::commit();

            return redirect()->route('admin.kriteria.index')
                ->with('success', 'Kriteria berhasil direset ke pengaturan default.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.kriteria.index')
                ->with('error', 'Terjadi kesalahan saat mereset kriteria.');
        }
    }
}
