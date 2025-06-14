<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        if ($product->status !== 'approved') {
            abort(404);
        }

        $product->load(['user.umkmProfile']);
        
        return view('products.show', compact('product'));
    }

    public function index()
    {
        $products = auth()->user()->products()->latest()->get();
        return view('umkm.products.index', compact('products'));
    }

    public function create()
    {
        return view('umkm.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('umkm.products.index')->with('success', 'Produk berhasil ditambahkan dan menunggu persetujuan admin.');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('umkm.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Reset status to pending if product was approved and is being edited
        if ($product->status === 'approved') {
            $data['status'] = 'pending';
        }

        $product->update($data);

        return redirect()->route('umkm.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('umkm.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}