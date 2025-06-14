@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header">
            <h4><i class="fas fa-list"></i> Pesanan Saya</h4>
        </div>
        <div class="card-body">
            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6>{{ $order->order_number }}</h6>
                                    <p class="text-muted mb-1">
                                        <i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y, H:i') }}
                                    </p>
                                    <p class="text-muted mb-1">
                                        <i class="fas fa-store"></i> {{ $order->seller->umkmProfile->store_name ?? $order->seller->name }}
                                    </p>
                                    
                                    <!-- Order Items -->
                                    @foreach($order->orderItems as $item)
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/50x50' }}" 
                                                 class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                            <div>
                                                <strong>{{ $item->product->name }}</strong><br>
                                                <small class="text-muted">{{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4 text-end">
                                    @php
                                        $statusClass = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger'
                                        ][$order->status] ?? 'secondary';
                                        
                                        $statusText = [
                                            'pending' => 'Menunggu Konfirmasi',
                                            'confirmed' => 'Dikonfirmasi',
                                            'delivered' => 'Dikirim',
                                            'cancelled' => 'Dibatalkan'
                                        ][$order->status] ?? 'Unknown';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }} mb-2">{{ $statusText }}</span>
                                    <h5 class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h5>
                                    <small class="text-muted">COD</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5>Belum ada pesanan</h5>
                    <p class="text-muted">Mulai berbelanja produk UMKM lokal</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection