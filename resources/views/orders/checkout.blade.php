@extends('layouts.app')

@section('title', 'Checkout - ' . $product->name)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-shopping-cart"></i> Checkout - Pembayaran COD</h4>
                </div>
                <div class="card-body">
                    <!-- Product Info -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/200x150' }}" 
                                 class="img-fluid rounded" alt="{{ $product->name }}">
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $product->name }}</h5>
                            <p class="text-muted">
                                <i class="fas fa-store"></i> {{ $product->user->umkmProfile->store_name ?? $product->user->name }}
                            </p>
                            <p class="h5 text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p><strong>Stok tersedia:</strong> {{ $product->stock }}</p>
                        </div>
                    </div>

                    <!-- Order Form -->
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                   id="quantity" name="quantity" value="{{ old('quantity', 1) }}" 
                                   min="1" max="{{ $product->stock }}" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="buyer_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('buyer_name') is-invalid @enderror" 
                                   id="buyer_name" name="buyer_name" value="{{ old('buyer_name', Auth::user()->name) }}" required>
                            @error('buyer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="buyer_phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('buyer_phone') is-invalid @enderror" 
                                   id="buyer_phone" name="buyer_phone" value="{{ old('buyer_phone', Auth::user()->phone) }}" required>
                            @error('buyer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="buyer_address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('buyer_address') is-invalid @enderror" 
                                      id="buyer_address" name="buyer_address" rows="3" required>{{ old('buyer_address', Auth::user()->address) }}</textarea>
                            @error('buyer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6><i class="fas fa-money-bill-wave"></i> Metode Pembayaran</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="cod" checked disabled>
                                    <label class="form-check-label">
                                        <strong>COD (Cash on Delivery)</strong><br>
                                        <small class="text-muted">Pembayaran tunai saat barang diterima</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <span>Total Pembayaran:</span>
                                    <span id="total-amount" class="h5">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Pesan Sekarang (COD)
                            </button>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Produk
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('quantity').addEventListener('input', function() {
        const quantity = this.value;
        const price = {{ $product->price }};
        const total = quantity * price;
        document.getElementById('total-amount').textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
</script>
@endsection