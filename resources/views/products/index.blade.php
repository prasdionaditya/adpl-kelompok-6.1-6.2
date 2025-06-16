@extends('layouts.app')

@section('title', 'Produk Saya - Dashboard Penjual')

@section('content')
<!-- Header -->
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem 0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Dashboard Penjual</h4>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('seller.products.index') }}" class="text-white text-decoration-none">Produk Saya</a>
                <a href="{{ route('seller.orders.index') }}" class="text-white text-decoration-none">Pesanan</a>
                <a href="{{ route('seller.profile') }}" class="text-white text-decoration-none">Profil Toko</a>
                <a href="{{ route('logout') }}" class="text-white text-decoration-none"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #333;">Produk Saya</h2>
        <a href="{{ route('seller.products.create') }}" 
           class="btn btn-success btn-lg fw-bold px-4"
           style="border-radius: 12px;">
            <i class="fas fa-plus me-2"></i>TAMBAH PRODUK BARU
        </a>
    </div>
    
    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-body p-4">
            <h5 class="mb-4">Daftar Produk</h5>
            
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>NAMA PRODUK</th>
                                <th>HARGA</th>
                                <th>STOK</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td class="fw-medium">{{ $product->name }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if($product->status === 'approved')
                                            <span class="badge bg-success badge-status">DISETUJUI</span>
                                        @elseif($product->status === 'pending')
                                            <span class="badge bg-warning badge-status">MENUNGGU PERSETUJUAN</span>
                                        @else
                                            <span class="badge bg-danger badge-status">DITOLAK</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('seller.products.edit', $product) }}" 
                                               class="btn btn-warning btn-sm">Edit</a>
                                            <form method="POST" action="{{ route('seller.products.destroy', $product) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{ $products->links() }}
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5>Belum ada produk</h5>
                    <p class="text-muted">Mulai tambahkan produk pertama Anda!</p>
                </div>
            @endif
        </div>
    </div>
    
    <div class="text-center mt-4">
        <small class="text-muted">© 2025 UMKM Lokal Marketplace. All rights reserved.</small>
    </div>
</div>
@endsection

{{-- resources/views/seller/products/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<!-- Header -->
<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem 0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">DASHBOARD PENJUAL</h4>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('seller.products.index') }}" class="text-white text-decoration-none">PRODUK SAYA</a>
                <a href="{{ route('seller.orders.index') }}" class="text-white text-decoration-none">PESANAN</a>
                <a href="{{ route('seller.profile') }}" class="text-white text-decoration-none">PROFIL TOKO</a>
                <a href="{{ route('logout') }}" class="text-white text-decoration-none">KELUAR</a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="text-center fw-bold mb-5" style="color: #333;">Tambah Produk Baru</h2>
            
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Product Name -->
                        <div class="mb-4">
                            <label class="form-label text-muted fw-medium">NAMA PRODUK</label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama produk"
                                   style="border-radius: 12px; border: 2px solid #e9ecef;"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Product Description -->
                        <div class="mb-4">
                            <label class="form-label text-muted fw-medium">DESKRIPSI PRODUK</label>
                            <textarea class="form-control form-control-lg @error('description') is-invalid @enderror" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Jelaskan detail produk Anda..."
                                      style="border-radius: 12px; border: 2px solid #e9ecef;"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <!-- Price -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted fw-medium">HARGA (RP)</label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('price') is-invalid @enderror" 
                                       name="price" 
                                       value="{{ old('price') }}" 
                                       placeholder="Contoh: 50000"
                                       style="border-radius: 12px; border: 2px solid #e9ecef;"
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Stock -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted fw-medium">STOK</label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('stock') is-invalid @enderror" 
                                       name="stock" 
                                       value="{{ old('stock') }}" 
                                       placeholder="Contoh: 10"
                                       style="border-radius: 12px; border: 2px solid #e9ecef;"
                                       required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Product Image -->
                        <div class="mb-4">
                            <label class="form-label text-muted fw-medium">GAMBAR PRODUK</label>
                            <input type="file" 
                                   class="form-control form-control-lg @error('image') is-invalid @enderror" 
                                   name="image" 
                                   accept="image/*"
                                   style="border-radius: 12px; border: 2px solid #e9ecef;">
                            <small class="text-muted">Maksimal ukuran file: 2MB. Format: JPG, PNG</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" 
                                    class="btn btn-lg text-white fw-bold"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; border: none;">
                                AJUKAN PRODUK
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">Produk Anda akan "menunggu persetujuan admin" sebelum tampil di marketplace.</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
