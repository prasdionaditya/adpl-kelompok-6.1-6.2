@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pesanan Anda</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($orders->isEmpty())
        <p>Belum ada pesanan.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Penjual</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>
                            @foreach ($order->orderItems as $item)
                                {{ $item->product->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($order->orderItems as $item)
                                 {{ $item->product->name }}
                                 {{ $item->quantity }}
                            @endforeach
                        </td>
                        <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td>{{ $order->seller->name }}</td>
                        <td>{{ ucfirst($order->status ?? 'pending') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
