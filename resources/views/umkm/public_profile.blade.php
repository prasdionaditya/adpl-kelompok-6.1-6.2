@extends('layouts.app')

@section('title', $profile->store_name . ' - Profil UMKM')

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-body">

            {{-- Gambar Toko --}}
            @if($profile->store_image)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $profile->store_image) }}"
                         alt="Gambar Toko {{ $profile->store_name }}"
                         class="img-fluid rounded shadow"
                         style="max-height: 250px;">
                </div>
            @endif

            <h2 class="mb-3">{{ $profile->store_name }}</h2>
            <p><strong>Alamat:</strong> {{ $profile->store_address }}</p>
            <p><strong>Deskripsi:</strong> {{ $profile->store_description ?? '-' }}</p>

            @if($profile->latitude && $profile->longitude)
                <h5 class="mt-4">Lokasi di Peta</h5>
                <div id="map" style="height: 300px;"></div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($profile->latitude && $profile->longitude)
<script>
    function initMap() {
        const lat = {{ $profile->latitude }};
        const lng = {{ $profile->longitude }};
        
        const mapDiv = document.getElementById('map');
        mapDiv.innerHTML = `
            <iframe 
                width="100%" 
                height="300" 
                frameborder="0" 
                scrolling="no" 
                src="https://www.openstreetmap.org/export/embed.html?bbox=${lng-0.01},${lat-0.01},${lng+0.01},${lat+0.01}&layer=mapnik&marker=${lat},${lng}">
            </iframe>
        `;
    }

    document.addEventListener('DOMContentLoaded', initMap);
</script>
@endif
@endsection
