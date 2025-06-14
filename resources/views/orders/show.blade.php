@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Pesanan</h2>

    <div class="card mb-4">
        <div class="card-header">Informasi Pembeli</div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $order->buyer_name }}</p>
            <p><strong>No. HP:</strong> {{ $order->buyer_phone }}</p>
            <p><strong>Alamat:</strong> {{ $order->buyer_address }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Detail Produk</div>
        <div class="card-body">
            <ul>
                @foreach($order->orderItems as $item)
                    <li>
                        <strong>{{ $item->product->name }}</strong> - 
                        Jumlah: {{ $item->quantity }} - 
                        Harga: Rp {{ number_format($item->price, 0, ',', '.') }}
                    </li>
                @endforeach
            </ul>
            <p class="mt-3"><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
        </div>
    </div>

    <a href="{{ route('umkm.orders') }}" class="btn btn-secondary mt-4">← Kembali ke Daftar Pesanan</a>
</div>
@endsection
