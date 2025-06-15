@extends('layouts.app')

@section('title', 'Moderasi Produk - Admin')

@section('content')
<div class="container py-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Moderasi Produk UMKM</h2>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow border text-sm">
            <thead class="bg-gray-100 border-b text-gray-700">
                <tr>
                    <th class="py-3 px-4 text-left">Foto</th>
                    <th class="py-3 px-4 text-left">Nama Produk</th>
                    <th class="py-3 px-4 text-left">Toko</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-left">Harga</th>
                    <th class="py-3 px-4 text-left">Stok</th>
                    <th class="py-3 px-4 text-left">Deskripsi</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Foto" class="w-20 h-20 object-cover rounded">
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 font-semibold">{{ $product->name }}</td>
                    <td class="py-3 px-4">
                        <div class="font-medium">
                            {{ $product->user->umkmProfile->store_name ?? $product->user->name }}
                        </div>
                        <a href="{{ route('umkm.profile.show', $product->user->id) }}"
                           class="text-blue-500 hover:underline text-xs">Lihat Detail Toko</a>
                    </td>
                    <td class="py-3 px-4">{{ $product->category->name ?? '-' }}</td>
                    <td class="py-3 px-4">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="py-3 px-4">{{ $product->stock }}</td>
                    <td class="py-3 px-4">{{ Str::limit($product->description, 60) }}</td>
                    <td class="py-3 px-4 text-center space-y-2">
                        <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="admin_notes" value="Disetujui oleh admin.">
                            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded w-full text-sm">
                                ✅ Setujui
                            </button>
                        </form>

                        <form action="{{ route('admin.products.reject', $product) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="admin_notes" placeholder="Alasan tolak"
                                   class="w-full border px-2 py-1 text-xs rounded mb-1" required>
                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded w-full text-sm">
                                ❌ Tolak
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-5 text-center text-gray-500">Tidak ada produk yang menunggu persetujuan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $products->links() }}
    </div>
</div>
@endsection
