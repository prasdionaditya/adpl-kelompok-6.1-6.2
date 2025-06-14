@extends('layouts.app')

@section('title', 'Login - UMKM Marketplace')

@section('content')
<div class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <div class="row g-0">
                        <!-- Left Side - Branding -->
                        <div class="col-md-6 d-flex align-items-center justify-content-center" 
                             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <div class="text-center p-5">
                                <h2 class="fw-bold mb-3">UMKM</h2>
                                <p class="mb-4">Marketplace</p>
                                <h4 class="mb-4">Selamat Datang Kembali!</h4>
                                <p class="mb-4">Masuk ke akun Anda untuk mengakses fitur-fitur terbaik marketplace UMKM</p>
                                <!-- Avatar Icon -->
                                <div class="mb-4">
                                    <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto; position: relative;">
                                        <div style="width: 60px; height: 25px; background: white; border-radius: 12px; position: absolute; bottom: 15px; left: 10px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side - Login Form -->
                        <div class="col-md-6 bg-white">
                            <div class="p-5">
                                <h3 class="fw-bold mb-4" style="color: #333;">LOGIN</h3>
                                
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Email</label>
                                        <input type="email" 
                                               class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               placeholder="nama@gmail.com"
                                               style="border-radius: 12px; border: 2px solid #e9ecef;"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Kata Sandi</label>
                                        <input type="password" 
                                               class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                               name="password" 
                                               placeholder="masukan password"
                                               style="border-radius: 12px; border: 2px solid #e9ecef;"
                                               required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <!-- Remember Me & Forgot Password -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label text-muted" for="remember">
                                                Ingat Saya
                                            </label>
                                        </div>
                                        <a href="#" class="text-decoration-none" style="color: #667eea;">Lupa Kata Sandi?</a>
                                    </div>
                                    
                                    <!-- Login Button -->
                                    <button type="submit" 
                                            class="btn btn-lg w-100 text-white fw-bold mb-4"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; border: none;">
                                        Masuk
                                    </button>
                                    
                                    <!-- Register Link -->
                                    <div class="text-center">
                                        <span class="text-muted">Belum punya akun? </span>
                                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #667eea;">Daftar Sekarang</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
