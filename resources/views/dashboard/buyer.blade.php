@extends('layouts.app')

@section('title', 'Dashboard Pembeli')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-3x text-primary mb-3"></i>
                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted">{{ ucfirst($user->role) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-tachometer-alt"></i> Dashboard Pembeli</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white mb-3">
                                <div class="card-body">
                                    <h5><i class="fas fa-shopping-cart"></i> Pesanan Saya</h5>
                                    <p>Lihat riwayat pembelian</p>
                                    <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm">Lihat Pesanan</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white mb-3">
                                <div class="card-body">
                                    <h5><i class="fas fa-rocket"></i> Mulai Jualan</h5>
                                    <p>Bergabung sebagai penjual UMKM</p>
                                    <form action="{{ route('become.umkm') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-light btn-sm">Mulai Jualan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection