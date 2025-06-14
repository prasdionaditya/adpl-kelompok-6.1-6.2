@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Detail Pesanan</h2>

    <a href="{{ route('umkm.orders') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar Pesanan</a>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Informasi Pembeli</h5>
            <p><strong>Nama:</strong> {{ $order->buyer_name }}</p>
            <p><strong>No HP:</strong> {{ $order->buyer_phone }}</p>
            <p><strong>Alamat:</strong> {{ $order->buyer_address }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Detail Produk</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <strong>Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Status Pesanan</h5>
            <p>Status saat ini: <strong>{{ ucfirst($order->status) }}</strong></p>
        </div>
    </div>
</div>
@endsection
