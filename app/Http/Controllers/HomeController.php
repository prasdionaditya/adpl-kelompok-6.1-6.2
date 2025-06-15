<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    // Halaman beranda + fitur pencarian
    public function index(Request $request)
    {
        $query = Product::with(['user.umkmProfile'])->approved()->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return view('home', compact('products'));
    }

    // Redirect dashboard sesuai role
    public function dashboard()
    {
        $user = auth()->user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'umkm':
                return redirect()->route('umkm.dashboard');
            default:
                return view('dashboard.buyer', compact('user'));
        }
    }

    // Aksi tombol "Mulai Jualan Sekarang"
    public function becomeUmkm(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'buyer') {
            return back()->with('error', 'Anda sudah memiliki role lain.');
        }

        // Redirect ke form profil toko (tidak langsung ubah role)
        return redirect()->route('umkm.registerForm');
    }

    // Tampilkan form registrasi UMKM
    public function showUmkmRegistrationForm()
    {
        return view('umkm.register'); // Buat view ini: resources/views/umkm/register.blade.php
    }

    // Simpan data toko dan ubah role
    public function storeUmkmRegistration(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Simpan profil toko
        $user->umkmProfile()->create([
            'store_name' => $request->store_name,
            'store_address' => $request->store_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Ubah role menjadi UMKM
        $user->update(['role' => 'umkm']);

        return redirect()->route('umkm.dashboard')->with('success', 'Profil toko berhasil disimpan. Anda sekarang terdaftar sebagai UMKM.');
    }
}
