@extends('layouts.app')

@section('title', 'Produk Kategori ' . $category->name)

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Produk dalam Kategori: <strong>{{ $category->name }}</strong></h2>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x250?text=No+Image" class="card-img-top" alt="No Image">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-muted mb-1">Stok: {{ $product->stock }}</p>
                        
                        @if($product->user && $product->user->umkmProfile)
                            <p class="text-muted small mb-2">
                                <i class="fas fa-store"></i> {{ $product->user->umkmProfile->store_name }}
                            </p>
                        @endif

                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary mt-auto">
                            <i class="fas fa-eye"></i> Lihat Produk
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">Belum ada produk dalam kategori ini.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
