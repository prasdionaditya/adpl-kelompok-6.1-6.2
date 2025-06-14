@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Pesanan Masuk</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <p>Belum ada pesanan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Pembeli</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $order->buyer->name }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>
                                <form action="{{ route('umkm.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select d-inline w-auto">
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Konfirmasi</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                    <button class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <a href="{{ route('umkm.orders.show', $order->id) }}" class="btn btn-sm btn-info mt-2">Lihat Detail</a>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
