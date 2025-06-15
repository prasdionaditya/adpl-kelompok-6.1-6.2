@extends('layouts.app')

@section('title', 'Produk Kategori ' . $category->name)

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Produk dalam Kategori: {{ $category->name }}</h2>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada produk dalam kategori ini.</p>
        @endforelse
    </div>
</div>
@endsection
