<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalUmkm = User::where('role', 'umkm')->count();
        $totalBuyers = User::where('role', 'buyer')->count();
        $totalProducts = Product::count();
        $pendingProducts = Product::pending()->count();
        $approvedProducts = Product::approved()->count();
        $totalOrders = Order::count();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalUmkm', 'totalBuyers', 'totalProducts', 
            'pendingProducts', 'approvedProducts', 'totalOrders'
        ));
    }

    public function products()
    {
        $products = Product::with(['user.umkmProfile'])
            ->pending()
            ->latest()
            ->paginate(10);

        return view('admin.products', compact('products'));
    }

    public function approveProduct(Request $request, Product $product)
    {
        $product->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes
        ]);

        return back()->with('success', 'Produk berhasil disetujui.');
    }

    public function rejectProduct(Request $request, Product $product)
    {
        $request->validate([
            'admin_notes' => 'required|max:1000'
        ]);

        $product->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes
        ]);

        return back()->with('success', 'Produk berhasil ditolak.');
    }
}