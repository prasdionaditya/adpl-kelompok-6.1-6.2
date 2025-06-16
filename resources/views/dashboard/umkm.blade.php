@extends('layouts.app')

@section('title', 'Dashboard UMKM - Platform UMKM Lokal')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-tachometer-alt"></i> Menu UMKM</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-chart-bar"></i> Dashboard
                    </a>
                    <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-box"></i> Kelola Produk
                    </a>
                    <a href="{{ route('orders.umkm') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart"></i> Pesanan Masuk
                    </a>
                    <a href="{{ route('umkm.profile') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-store"></i> Profil Toko
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Welcome Card -->
            <div class="card mb-4" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                <div class="card-body">
                    <h3><i class="fas fa-store"></i> Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="mb-0">Kelola toko UMKM Anda dengan mudah melalui dashboard ini.</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center border-primary">
                        <div class="card-body">
                            <i class="fas fa-box fa-2x text-primary mb-2"></i>
                            <h4 class="text-primary">{{ $totalProducts }}</h4>
                            <p class="text-muted mb-4">Anda belum melakukan pemesanan apapun. Mulai jelajahi produk UMKM lokal terbaik!</p>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-store"></i> Jelajahi Produk
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function filterOrders() {
    const filter = document.getElementById('statusFilter').value;
    const orders = document.querySelectorAll('.order-item');
    
    orders.forEach(order => {
        const status = order.getAttribute('data-status');
        if (filter === '' || status === filter) {
            order.style.display = 'block';
        } else {
            order.style.display = 'none';
        }
    });
}
</script>
@endsectionmuted mb-0">Total Produk</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-success">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart fa-2x text-success mb-2"></i>
                            <h4 class="text-success">{{ $totalOrders }}</h4>
                            <p class="text-muted mb-0">Total Pesanan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-warning">
                        <div class="card-body">
                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                            <h4 class="text-warning">{{ $pendingOrders }}</h4>
                            <p class="text-muted mb-0">Perlu Diproses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center border-info">
                        <div class="card-body">
                            <i class="fas fa-money-bill-wave fa-2x text-info mb-2"></i>
                            <h4 class="text-info">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                            <p class="text-muted mb-0">Total Pendapatan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Pesanan Terbaru</h5>
                    <a href="{{ route('orders.umkm') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Pembeli</th>
                                        <th>Produk</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->id }}</strong></td>
                                            <td>{{ $order->buyer_name }}</td>
                                            <td>{{ $order->product->name }}</td>
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td>
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
                                            </td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5>Belum ada pesanan</h5>
                            <p class="text-muted">Pesanan dari pembeli akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Top Products -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-star"></i> Produk Terlaris</h5>
                </div>
                <div class="card-body">
                    @if($topProducts->count() > 0)
                        <div class="row">
                            @foreach($topProducts as $product)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/60x60' }}" 
                                                     class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                                    <small class="text-muted">{{ $product->orders_count }} pesanan</small>
                                                    <div class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <h5>Belum ada produk</h5>
                            <p class="text-muted">
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Produk Pertama
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection