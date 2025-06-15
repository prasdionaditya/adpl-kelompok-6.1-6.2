@extends('layouts.app')

@section('title', 'Dashboard UMKM')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard UMKM</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Grid Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card Template -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700">Total Produk</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $totalProducts }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700">Produk Disetujui</h2>
            <p class="text-3xl font-bold text-green-600">{{ $approvedProducts }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700">Produk Pending</h2>
            <p class="text-3xl font-bold text-yellow-500">{{ $pendingProducts }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700">Total Pesanan</h2>
            <p class="text-3xl font-bold text-purple-600">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700">Pesanan Pending</h2>
            <p class="text-3xl font-bold text-red-500">{{ $pendingOrders }}</p>
        </div>

        <!-- Aksi Cepat -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-700">Aksi Cepat</h2>
            <ul class="mt-3 space-y-2 text-blue-600 list-disc list-inside">
                <li><a href="{{ route('umkm.profile') }}" class="hover:underline">Edit Profil Toko</a></li>
                <li><a href="{{ route('umkm.products.index') }}" class="hover:underline">Kelola Produk</a></li>
                <li><a href="{{ route('umkm.orders') }}" class="hover:underline">Lihat Pesanan</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
