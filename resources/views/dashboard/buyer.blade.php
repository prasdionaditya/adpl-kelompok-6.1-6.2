@extends('layouts.app')

@section('title', 'Dashboard Pembeli - Platform UMKM Lokal')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Menu Pembeli</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-chart-bar"></i> Dashboard
                    </a>
                    <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-bag"></i> Pesanan Saya
                    </a>
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-store"></i> Jelajahi Produk
                    </a>
                </div>
            </div>

            <!-- Upgrade to UMKM Card -->
            <div class="card mt-3">
                <div class="card-body text-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                    <i class="fas fa-rocket fa-2x mb-2"></i>
                    <h6>Punya Usaha?</h6>
                    <p class="small mb-3">Mulai jual produk Anda di platform kami!</p>
                    <form action="{{ route('become.umkm') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-up"></i> Jadi UMKM
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Welcome Card -->
            <div class="card mb-4" style="background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%); color: white;">
                <div class="card-body">
                    <h3><i class="fas fa-user-circle"></i> Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="mb-0">Nikmati pengalaman berbelanja produk UMKM lokal terbaik.</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-center border-primary">
                        <div class="card-body">
                            <i class="fas fa-shopping-bag fa-2x text-primary mb-2"></i>
                            <h4 class="text-primary">{{ $totalOrders }}</h4>
                            <p class="text-muted mb-0">Total Pesanan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-success">
                        <div class="card-body">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <h4 class="text-success">{{ $completedOrders }}</h4>
                            <p class="text-muted mb-0">Pesanan Selesai</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-info">
                        <div class="card-body">
                            <i class="fas fa-money-bill-wave fa-2x text-info mb-2"></i>
                            <h4 class="text-info">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Total Belanja</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> Pesanan Terbaru</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        @foreach($recentOrders as $order)
                            <div class="card mb-3 border-start border-4 border-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'primary') }}">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <img src="{{ $order->product->image ? asset('storage/' . $order->product->image) : 'https://via.placeholder.com/80x80' }}" 
                                                 class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-1">{{ $order->product->name }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-store"></i> {{ $order->product->user->umkmProfile->store_name ?? $order->product->user->name }}
                                            </small>
                                            <div class="mt-1">
                                                <small class="text-muted">{{ $order->quantity }} x Rp {{ number_format($order->product->price, 0, ',', '.') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <div class="fw-bold text-primary mb-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                            @if($order->status == 'pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($order->status == 'confirmed')
                                                <span class="badge bg-primary">Dikonfirmasi</span>
                                            @elseif($order->status == 'delivered')
                                                <span class="badge bg-info">Dikirim</span>
                                            @elseif($order->status == 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                            <div class="mt-1">
                                                <small class="text-muted">{{ $order->created_at->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h5>Belum ada pesanan</h5>
                            <p class="text-muted">
                                <a href="{{ route('home') }}" class="btn btn-primary">
                                    <i class="fas fa-store"></i> Mulai Berbelanja
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recommended Products -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-thumbs-up"></i> Produk Rekomendasi</h5>
                </div>
                <div class="card-body">
                    @if($recommendedProducts->count() > 0)
                        <div class="row">
                            @foreach($recommendedProducts as $product)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/60x60' }}" 
                                                     class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                                    <small class="text-muted">{{ $product->user->umkmProfile->store_name ?? $product->user->name }}</small>
                                                    <div class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                                </div>
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Rekomendasi produk akan muncul berdasarkan riwayat belanja Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection