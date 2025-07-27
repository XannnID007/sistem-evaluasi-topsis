<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Statistik untuk pegawai
        if ($user->isPegawai()) {
            $totalEvaluasi = $user->evaluasi()->count();
            $rataSkor = $user->evaluasi()->avg('total_skor') ?? 0;
            $rankingTerbaik = $user->evaluasi()->min('ranking') ?? 0;
            $evaluasiTerbaru = $user->evaluasi()->with('periode')->latest()->first();

            return view('profile.index', compact(
                'user',
                'totalEvaluasi',
                'rataSkor',
                'rankingTerbaik',
                'evaluasiTerbaru'
            ));
        }

        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Jika mengubah password, validasi password lama
        if (!empty($validated['password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak benar.']);
            }
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        unset($validated['current_password']);

        $user->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Profile berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak benar.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diubah.');
    }
}
