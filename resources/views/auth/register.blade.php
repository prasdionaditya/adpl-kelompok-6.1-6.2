@extends('layouts.app')

@section('title', 'Daftar - UMKM Marketplace')

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
                                <h4 class="mb-4">{{ __('Join Us!') }}</h4>
                                <p class="mb-4">{{ __('Register now and start selling your UMKM products on a trusted marketplace') }}</p>
                                <!-- Avatar Icon -->
                                <div class="mb-4">
                                    <div style="width: 120px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 15px; margin: 0 auto; position: relative;">
                                        <div style="width: 30px; height: 30px; background: white; border-radius: 50%; position: absolute; top: 15px; left: 25px;"></div>
                                        <div style="width: 30px; height: 30px; background: white; border-radius: 50%; position: absolute; top: 15px; right: 25px;"></div>
                                        <div style="width: 60px; height: 25px; background: white; border-radius: 12px; position: absolute; bottom: 15px; left: 30px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side - Register Form -->
                        <div class="col-md-6 bg-white">
                            <div class="p-5">
                                <h3 class="fw-bold mb-4" style="color: #333;">{{ __('Register') }}</h3>
                                
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    
                                    <!-- Full Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label text-muted">{{ __('Name') }}</label>
                                        <input id="name" 
                                               type="text" 
                                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               placeholder="{{ __('Your full name') }}"
                                               style="border-radius: 12px; border: 2px solid #e9ecef;"
                                               required 
                                               autocomplete="name" 
                                               autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label text-muted">{{ __('Email Address') }}</label>
                                        <input id="email" 
                                               type="email" 
                                               class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               placeholder="{{ __('example@email.com') }}"
                                               style="border-radius: 12px; border: 2px solid #e9ecef;"
                                               required 
                                               autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label text-muted">{{ __('Password') }}</label>
                                        <input id="password" 
                                               type="password" 
                                               class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                               name="password" 
                                               placeholder="{{ __('minimum 8 characters') }}"
                                               style="border-radius: 12px; border: 2px solid #e9ecef;"
                                               required 
                                               autocomplete="new-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <!-- Confirm Password -->
                                    <div class="mb-4">
                                        <label for="password-confirm" class="form-label text-muted">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" 
                                               type="password" 
                                               class="form-control form-control-lg" 
                                               name="password_confirmation" 
                                               placeholder="{{ __('repeat password') }}"
                                               style="border-radius: 12px; border: 2px solid #e9ecef;"
                                               required 
                                               autocomplete="new-password">
                                    </div>
                                    
                                    <!-- Register Button -->
                                    <button type="submit" 
                                            class="btn btn-lg w-100 text-white fw-bold mb-4"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; border: none;">
                                        {{ __('Register') }}
                                    </button>
                                    
                                    <!-- Login Link -->
                                    <div class="text-center">
                                        <span class="text-muted">{{ __('Already have an account?') }} </span>
                                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #667eea;">
                                            {{ __('Login here') }}
                                        </a>
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

@push('styles')
<style>
    .form-control:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
    }
    
    @media (max-width: 768px) {
        .col-md-6:first-child {
            display: none;
        }
        
        .card {
            margin: 20px;
        }
        
        .p-5 {
            padding: 2rem !important;
        }
    }
</style>
@endpush
@endsection