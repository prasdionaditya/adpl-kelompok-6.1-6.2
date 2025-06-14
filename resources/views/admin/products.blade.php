@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Produk Menunggu Persetujuan</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="py-2 px-4">Nama Produk</th>
                    <th class="py-2 px-4">Toko</th>
                    <th class="py-2 px-4">Harga</th>
                    <th class="py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $product->name }}</td>
                    <td class="py-2 px-4">{{ $product->user->umkmProfile->store_name ?? 'N/A' }}</td>
                    <td class="py-2 px-4">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 space-x-2">
                        <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="admin_notes" value="Disetujui oleh admin.">
                            <button class="bg-green-600 text-white px-3 py-1 rounded">Setujui</button>
                        </form>

                        <!-- Tombol tolak produk (pakai modal atau form langsung) -->
                        <form action="{{ route('admin.products.reject', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="text" name="admin_notes" placeholder="Alasan penolakan" class="border px-2 py-1 text-sm" required>
                            <button class="bg-red-600 text-white px-3 py-1 rounded mt-1">Tolak</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
