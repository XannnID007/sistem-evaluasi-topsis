<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'pegawai');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kelas jabatan
        if ($request->filled('kelas_jabatan')) {
            $query->where('kelas_jabatan', $request->kelas_jabatan);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $pegawai = $query->orderBy('nama')->paginate(15);

        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'jabatan' => 'required|string|max:255',
            'kelas_jabatan' => 'required|in:Staff,Supervisor,Kepala Seksi,Camat',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'pegawai';

        User::create($validated);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function show(User $pegawai)
    {
        // Pastikan hanya pegawai yang bisa dilihat
        if ($pegawai->role !== 'pegawai') {
            abort(404);
        }

        // Ambil data evaluasi terbaru
        $evaluasiTerbaru = $pegawai->evaluasi()->with('periode')->latest()->take(5)->get();

        // Hitung statistik
        $totalEvaluasi = $pegawai->evaluasi()->count();
        $rataRataSkor = $pegawai->evaluasi()->avg('total_skor') ?? 0;
        $rankingTerbaik = $pegawai->evaluasi()->min('ranking') ?? 0;

        return view('admin.pegawai.show', compact(
            'pegawai',
            'evaluasiTerbaru',
            'totalEvaluasi',
            'rataRataSkor',
            'rankingTerbaik'
        ));
    }

    public function edit(User $pegawai)
    {
        // Pastikan hanya pegawai yang bisa diedit
        if ($pegawai->role !== 'pegawai') {
            abort(404);
        }

        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, User $pegawai)
    {
        // Pastikan hanya pegawai yang bisa diupdate
        if ($pegawai->role !== 'pegawai') {
            abort(404);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($pegawai->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($pegawai->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'jabatan' => 'required|string|max:255',
            'kelas_jabatan' => 'required|in:Staff,Supervisor,Kepala Seksi,Camat',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Jika password diisi, hash password baru
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pegawai->update($validated);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(User $pegawai)
    {
        // Pastikan hanya pegawai yang bisa dihapus
        if ($pegawai->role !== 'pegawai') {
            abort(404);
        }

        // Hapus semua evaluasi terkait
        $pegawai->evaluasi()->delete();

        // Hapus pegawai
        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $query = User::where('role', 'pegawai');

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas_jabatan')) {
            $query->where('kelas_jabatan', $request->kelas_jabatan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pegawai = $query->orderBy('nama')->get();

        // Export logic here (using Laravel Excel package)
        // For now, just return JSON
        return response()->json([
            'message' => 'Export functionality will be implemented',
            'count' => $pegawai->count()
        ]);
    }
}
