<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function checkout(Product $product)
    {
        if ($product->status !== 'approved' || $product->stock <= 0) {
            return redirect()->route('home')->with('error', 'Produk tidak tersedia.');
        }

        return view('orders.checkout', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'buyer_name' => 'required|max:255',
            'buyer_address' => 'required',
            'buyer_phone' => 'required|max:20',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $totalAmount = $product->price * $request->quantity;

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'buyer_id' => auth()->id(),
            'seller_id' => $product->user_id,
            'buyer_name' => $request->buyer_name,
            'buyer_address' => $request->buyer_address,
            'buyer_phone' => $request->buyer_phone,
            'total_amount' => $totalAmount,
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        // Update product stock
        $product->decrement('stock', $request->quantity);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat silahkan pantau status pemesanan secara berkala.');
    }

    public function index()
    {
        $orders = auth()->user()->buyerOrders()->with(['orderItems.product', 'seller'])->latest()->get();
        return view('orders.index', compact('orders'));
    }
}