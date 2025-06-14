@extends('layouts.app')

@section('title', $product->name . ' - Platform UMKM Lokal')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/500x400' }}" 
                 class="img-fluid rounded shadow" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <!-- Store Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-store text-primary"></i> 
                        <a href="{{ route('umkm.profile.show', $product->user->id) }}" class="text-decoration-none">
                            {{ $product->user->umkmProfile->store_name ?? $product->user->name }}
                        </a>
                     </h6>
                    @if($product->user->umkmProfile)
                        <p class="card-text small text-muted mb-2">
                            <i class="fas fa-map-marker-alt"></i> {{ $product->user->umkmProfile->store_address }}
                        </p>
                        @if($product->user->umkmProfile->latitude && $product->user->umkmProfile->longitude)
                            <div id="map" style="height: 200px; border-radius: 8px;" class="mb-2"></div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <span class="h3 text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="ms-3 text-muted">Stok: {{ $product->stock }}</span>
            </div>
            
            <div class="mb-4">
                <h5>Deskripsi Produk</h5>
                <p>{{ $product->description }}</p>
            </div>

            @auth
                @if($product->stock > 0)
                    <a href="{{ route('checkout', $product) }}" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-shopping-cart"></i> Beli Sekarang (COD)
                    </a>
                @else
                    <button class="btn btn-secondary btn-lg w-100" disabled>
                        <i class="fas fa-times"></i> Stok Habis
                    </button>
                @endif
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <a href="{{ route('login') }}">Login</a> untuk melakukan pembelian
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($product->user->umkmProfile && $product->user->umkmProfile->latitude && $product->user->umkmProfile->longitude)
<script>
    // Simple map with OpenStreetMap
    function initMap() {
        const lat = {{ $product->user->umkmProfile->latitude }};
        const lng = {{ $product->user->umkmProfile->longitude }};
        
        const mapDiv = document.getElementById('map');
        mapDiv.innerHTML = `
            <iframe 
                width="100%" 
                height="200" 
                frameborder="0" 
                scrolling="no" 
                marginheight="0" 
                marginwidth="0" 
                src="https://www.openstreetmap.org/export/embed.html?bbox=${lng-0.01},${lat-0.01},${lng+0.01},${lat+0.01}&layer=mapnik&marker=${lat},${lng}"
                style="border-radius: 8px;">
            </iframe>
        `;
    }
    
    document.addEventListener('DOMContentLoaded', initMap);
</script>
@endif
@endsection