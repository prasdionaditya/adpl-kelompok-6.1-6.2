@extends('layouts.app')

@section('title', 'Moderasi Produk - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Moderasi Produk UMKM</h2>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg text-sm">
            <thead>
                <tr class="bg-indigo-600 text-white text-xs uppercase tracking-wider">
                    <th class="px-4 py-3">Foto</th>
                    <th class="px-4 py-3">Nama Produk</th>
                    <th class="px-4 py-3">Toko</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded" alt="Foto">
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $product->name }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-700">
                                {{ $product->user->umkmProfile->store_name ?? $product->user->name }}
                            </div>
                            <a href="{{ route('umkm.profile.show', $product->user->id) }}" class="text-blue-500 hover:underline text-xs">
                                Lihat Detail Toko
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $product->stock }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ Str::limit($product->description, 60) }}</td>
                        <td class="px-4 py-3 text-center space-y-2">
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="admin_notes" value="Disetujui oleh admin.">
                                <button class="w-full bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded text-sm">
                                    ✅ Setujui
                                </button>
                            </form>

                            <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" name="admin_notes" placeholder="Alasan tolak"
                                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs mb-1 focus:outline-none focus:ring focus:border-blue-300"
                                    required>
                                <button class="w-full bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
                                    ❌ Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500">
                            Tidak ada produk yang menunggu persetujuan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

    <div class="text-center text-sm text-gray-500 mt-6">
    </div>
</div>
@endsection
