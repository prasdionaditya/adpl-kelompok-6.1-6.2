@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold">Dashboard Admin</h2>
        <a href="{{ route('admin.products') }}" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded">
            Moderasi Produk
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 shadow rounded border-l-4 border-blue-500">
            <div class="text-gray-600">Total User</div>
            <div class="text-xl font-bold">{{ $totalUsers }}</div>
        </div>
        <div class="bg-white p-4 shadow rounded border-l-4 border-green-500">
            <div class="text-gray-600">Total UMKM</div>
            <div class="text-xl font-bold">{{ $totalUmkm }}</div>
        </div>
        <div class="bg-white p-4 shadow rounded border-l-4 border-yellow-500">
            <div class="text-gray-600">Total Pembeli</div>
            <div class="text-xl font-bold">{{ $totalBuyers }}</div>
        </div>
        <div class="bg-white p-4 shadow rounded border-l-4 border-indigo-500">
            <div class="text-gray-600">Total Produk</div>
            <div class="text-xl font-bold">{{ $totalProducts }}</div>
        </div>
        <div class="bg-white p-4 shadow rounded border-l-4 border-red-500">
            <div class="text-gray-600">Produk Menunggu</div>
            <div class="text-xl font-bold">{{ $pendingProducts }}</div>
        </div>
        <div class="bg-white p-4 shadow rounded border-l-4 border-green-600">
            <div class="text-gray-600">Produk Disetujui</div>
            <div class="text-xl font-bold">{{ $approvedProducts }}</div>
        </div>
        <div class="bg-white p-4 shadow rounded border-l-4 border-purple-500 sm:col-span-2">
            <div class="text-gray-600">Total Pesanan</div>
            <div class="text-xl font-bold">{{ $totalOrders }}</div>
        </div>
    </div>
</div>
@endsection
