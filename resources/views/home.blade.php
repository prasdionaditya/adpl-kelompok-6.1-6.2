@extends('layouts.app')

@section('title', 'Beranda - Platform UMKM Lokal')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Platform UMKM Lokal Terpercaya</h1>
        <p class="lead mb-4">Temukan produk berkualitas dari UMKM lokal di sekitar Anda</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">
                <i class="fas fa-rocket"></i> Mulai Jualan Sekarang
            </a>
        @else
            @if(Auth::user()->isBuyer())
                <form action="{{ route('become.umkm') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-rocket"></i> Mulai Jualan Sekarang
                    </button>
                </form>
            @endif
        @endguest
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Produk Terbaru dari UMKM Lokal</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('home') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>

        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card product-card h-100">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200' }}" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted small">
                                    <i class="fas fa-store"></i> {{ $product->user->umkmProfile->store_name ?? $product->user->name }}
                                </p>
                                <p class="card-text flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="h5 text-primary mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <small class="text-muted">Stok: {{ $product->stock }}</small>
                                    </div>
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-primary w-100">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h4>Belum ada produk tersedia</h4>
                <p class="text-muted">Produk dari UMKM akan muncul di sini setelah disetujui admin.</p>
            </div>
        @endif
    </div>
</section>
@endsection
