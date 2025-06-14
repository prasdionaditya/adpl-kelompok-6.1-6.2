@extends('layouts.app')

@section('title', 'Dashboard UMKM')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard UMKM</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Produk -->
        <div class="bg-white rounded shadow p-5">
            <h2 class="text-lg font-semibold text-gray-700">Total Produk</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $totalProducts }}</p>
        </div>

        <!-- Produk Disetujui -->
        <div class="bg-white rounded shadow p-5">
            <h2 class="text-lg font-semibold text-gray-700">Produk Disetujui</h2>
            <p class="text-3xl font-bold text-green-600">{{ $approvedProducts }}</p>
        </div>

        <!-- Produk Menunggu -->
        <div class="bg-white rounded shadow p-5">
            <h2 class="text-lg font-semibold text-gray-700">Produk Pending</h2>
            <p class="text-3xl font-bold text-yellow-500">{{ $pendingProducts }}</p>
        </div>

        <!-- Total Pesanan -->
        <div class="bg-white rounded shadow p-5">
            <h2 class="text-lg font-semibold text-gray-700">Total Pesanan</h2>
            <p class="text-3xl font-bold text-purple-600">{{ $totalOrders }}</p>
        </div>

        <!-- Pesanan Menunggu -->
        <div class="bg-white rounded shadow p-5">
            <h2 class="text-lg font-semibold text-gray-700">Pesanan Pending</h2>
            <p class="text-3xl font-bold text-red-500">{{ $pendingOrders }}</p>
        </div>

        <!-- Aksi -->
        <div class="bg-white rounded shadow p-5">
            <h2 class="text-lg font-semibold text-gray-700">Aksi Cepat</h2>
            <ul class="list-disc ml-5 mt-2 text-blue-600">
                <li><a href="{{ route('umkm.profile') }}" class="hover:underline">Edit Profil Toko</a></li>
                <li><a href="{{ route('umkm.products.index') }}" class="hover:underline">Kelola Produk</a></li>
                <li><a href="{{ route('umkm.orders') }}" class="hover:underline">Lihat Pesanan</a></li>
            </ul>
        </div>
        <div class="card bg-primary text-white mb-3">
                                <div class="card-body">
                                    <h5><i class="fas fa-shopping-cart"></i> Pesanan Saya</h5>
                                    <p>Lihat riwayat pembelian</p>
                                    <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm">Lihat Pesanan</a>
                                </div>
                            </div>
                        </div>
    </div>
</div>
@endsection
