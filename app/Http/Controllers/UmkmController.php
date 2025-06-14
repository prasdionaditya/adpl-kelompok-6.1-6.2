<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UmkmProfile;
use App\Models\Order;

class UmkmController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $totalProducts = $user->products()->count();
        $pendingProducts = $user->products()->pending()->count();
        $approvedProducts = $user->products()->approved()->count();
        $totalOrders = $user->sellerOrders()->count();
        $pendingOrders = $user->sellerOrders()->where('status', 'pending')->count();

        return view('umkm.dashboard', compact(
            'user', 'totalProducts', 'pendingProducts', 
            'approvedProducts', 'totalOrders', 'pendingOrders'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        $profile = $user->umkmProfile;

        return view('umkm.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'store_name' => 'required|max:255',
            'store_description' => 'nullable',
            'store_address' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'store_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = auth()->user();
        $data = $request->all();

        if ($request->hasFile('store_image')) {
            $data['store_image'] = $request->file('store_image')->store('stores', 'public');
        }

        $user->umkmProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return back()->with('success', 'Profil toko berhasil diperbarui.');
    }

    public function orders()
    {
        $orders = auth()->user()->sellerOrders()->with(['orderItems.product', 'buyer'])->latest()->get();
        return view('umkm.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,delivered,cancelled'
        ]);

        if ($order->seller_id !== auth()->id()) {
            abort(403);
        }

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function showOrder(Order $order)
    {
        if ($order->seller_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['buyer', 'orderItems.product']);

        return view('umkm.orders.show', compact('order'));
    }

    public function showStoreProfile(\App\Models\User $user)
{
    $profile = $user->umkmProfile;

    if (!$profile) {
        abort(404, 'Profil UMKM tidak ditemukan.');
    }

    return view('umkm.public_profile', compact('user', 'profile'));
}

}
