@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Pesanan #{{ $order->order_number }}</h4>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><strong>Informasi Pesanan</strong></h6>
                            <p><strong>No. Pesanan:</strong> {{ $order->order_number }}</p>
                            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge badge-{{ 
                                    $order->status == 'pending' ? 'warning' : 
                                    ($order->status == 'completed' ? 'success' : 
                                    ($order->status == 'cancelled' ? 'danger' : 'info')) 
                                }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Informasi Pembeli</strong></h6>
                            <p><strong>Nama:</strong> {{ $order->buyer_name }}</p>
                            <p><strong>Alamat:</strong> {{ $order->buyer_address }}</p>
                            <p><strong>Telepon:</strong> {{ $order->buyer_phone }}</p>
                        </div>
                    </div>

                    <h6><strong>Detail Produk</strong></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                            Kembali ke Daftar Pesanan
                        </a>
                        
                        @if(in_array($order->status, ['pending', 'confirmed']))
                        <form method="POST" 
                              action="{{ route('orders.cancel', $order->id) }}" 
                              style="display: inline;"
                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Batalkan Pesanan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection