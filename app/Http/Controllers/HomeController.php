<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['user.umkmProfile'])
            ->approved()
            ->latest()
            ->paginate(12);

        return view('home', compact('products'));
    }

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

    public function becomeUmkm(Request $request)
    {
    $user = auth()->user();

    if ($user->role !== 'buyer') {
        return back()->with('error', 'Anda sudah memiliki role lain.');
    }

    // Redirect ke form pengisian data toko, jangan ubah role dulu
    return redirect()->route('umkm.registerForm');
    }
    // Tampilkan form isi profil toko UMKM
public function showUmkmRegistrationForm()
{
    return view('umkm.register'); // buat nanti view ini
}

// Simpan data profil toko dan ubah role
public function storeUmkmRegistration(Request $request)
{
    $user = auth()->user();

    // Validasi
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

    // Ubah role menjadi umkm setelah simpan profil
    $user->update(['role' => 'umkm']);

    return redirect()->route('umkm.dashboard')->with('success', 'Profil toko berhasil disimpan. Anda sekarang terdaftar sebagai UMKM.');
}


}