@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 px-4">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800">Dashboard Admin</h2>
        <a href="{{ route('admin.products') }}" 
           class="bg-gradient-to-r from-blue-500 to-purple-600 text-white hover:from-blue-600 hover:to-purple-700 font-semibold py-2 px-5 rounded-lg shadow transition duration-300 ease-in-out">
            Moderasi Produk
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card -->
        <div class="bg-white p-6 shadow-md rounded-lg border-t-4 border-blue-500 hover:shadow-xl transition">
            <div class="text-gray-500">Total User</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</div>
        </div>

        <div class="bg-white p-6 shadow-md rounded-lg border-t-4 border-green-500 hover:shadow-xl transition">
            <div class="text-gray-500">Total UMKM</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalUmkm }}</div>
        </div>

        <div class="bg-white p-6 shadow-md rounded-lg border-t-4 border-yellow-500 hover:shadow-xl transition">
            <div class="text-gray-500">Total Pembeli</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalBuyers }}</div>
        </div>

        <div class="bg-white p-6 shadow-md rounded-lg border-t-4 border-indigo-500 hover:shadow-xl transition">
            <div class="text-gray-500">Total Produk</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</div>
        </div>

        <div class="bg-white p-6 shadow-md rounded-lg border-t-4 border-red-500 hover:shadow-xl transition">
            <div class="text-gray-500">Produk Menunggu</div>
            <div class="text-2xl font-bold text-gray-800">{{ $pendingProducts }}</div>
        </div>

        <div class="bg-white p-6 shadow-md rounded-lg border-t-4 border-green-600 hover:shadow-xl transition">
            <div class="text-gray-500">Produk Disetujui</div>
            <div class="text-2xl font-bold text-gray-800">{{ $approvedProducts }}</div>
        </div>

        <div class="bg-white p-6 shadow-md rounded-lg border-t-4 border-purple-500 sm:col-span-2 hover:shadow-xl transition">
            <div class="text-gray-500">Total Pesanan</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</div>
        </div>
    </div>
</div>
@endsection
