@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Produk Saya</h2>

    <a href="{{ route('umkm.products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($products->isEmpty())
        <p>Tidak ada produk.</p>
    @else
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p>Status: <strong>{{ ucfirst($product->status) }}</strong></p>
                            <a href="{{ route('umkm.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('umkm.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
