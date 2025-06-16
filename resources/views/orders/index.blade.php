@extends('layouts.app')

@section('title', 'Pesanan Saya - Platform UMKM Lokal')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Menu Pembeli</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-bar"></i> Dashboard
                    </a>
                    <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-shopping-bag"></i> Pesanan Saya
                    </a>
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-store"></i> Jelajahi Produk
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-shopping-bag"></i> Riwayat Pesanan Saya</h4>
                    <div class="d-flex align-items-center">
                        <!-- Filter Status -->
                        <select class="form-select form-select-sm me-2" id="statusFilter" onchange="filterOrders()">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="confirmed">Dikonfirmasi</option>
                            <option value="processing">Diproses</option>
                            <option value="delivered">Dikirim</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                        <span class="badge bg-secondary" id="orderCount">{{ $orders->total() }} pesanan</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div id="ordersContainer">
                            @foreach($orders as $order)
                                <div class="order-item mb-4 p-3 border rounded" data-status="{{ $order->status }}">
                                    <div class="row">
                                        <div class="col-md-2">
                                            @if($order->orderItems->first() && $order->orderItems->first()->product && $order->orderItems->first()->product->image)
                                                <img src="{{ asset('storage/' . $order->orderItems->first()->product->image) }}" 
                                                     class="img-fluid rounded order-image" 
                                                     style="width: 100px; height: 100px; object-fit: cover;"
                                                     alt="{{ $order->orderItems->first()->product->name ?? 'Product Image' }}">
                                            @elseif($order->orderItems->first() && $order->orderItems->first()->product)
                                                <div class="placeholder-image d-flex align-items-center justify-content-center rounded" 
                                                     style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                </div>
                                            @else
                                                <div class="placeholder-image d-flex align-items-center justify-content-center rounded" 
                                                     style="width: 100px; height: 100px; background-color: #f8f9fa;">
                                                    <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-7">
                                            <h5 class="mb-2">
                                                @if($order->orderItems->count() > 1)
                                                    {{ $order->orderItems->first()->product->name ?? 'Produk Tidak Tersedia' }} 
                                                    <small class="text-muted">(+{{ $order->orderItems->count() - 1 }} produk lainnya)</small>
                                                @else
                                                    {{ $order->orderItems->first()->product->name ?? 'Produk Tidak Tersedia' }}
                                                @endif
                                            </h5>
                                            
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-store"></i> 
                                                @if($order->orderItems->first() && $order->orderItems->first()->product && $order->orderItems->first()->product->user)
                                                    {{ optional($order->orderItems->first()->product->user->umkmProfile)->store_name ?? $order->orderItems->first()->product->user->name ?? 'Toko Tidak Diketahui' }}
                                                @else
                                                    Toko Tidak Tersedia
                                                @endif
                                            </p>
                                            
                                            <p class="text-muted mb-2">
                                                <strong>No. Pesanan:</strong> {{ $order->order_number ?? '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                            </p>
                                            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <small class="text-muted">
                                                        <i class="fas fa-boxes"></i> 
                                                        Total Item: {{ $order->orderItems->sum('quantity') }}
                                                    </small>
                                                </div>
                                                <div class="col-sm-6">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y, H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <!-- Products List -->
                                            <div class="mt-2 p-2 bg-light rounded">
                                                <small class="text-muted">
                                                    <strong><i class="fas fa-list"></i> Produk:</strong><br>
                                                    @foreach($order->orderItems as $item)
                                                        • {{ $item->product->name ?? 'Produk Tidak Tersedia' }} 
                                                        ({{ $item->quantity }}x)
                                                        @if($item->product && $item->product->price)
                                                            - Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                        @endif
                                                        <br>
                                                    @endforeach
                                                </small>
                                            </div>

                                            <!-- Buyer/Delivery Info if available -->
                                            @if(isset($order->buyer_name) || isset($order->buyer_phone) || isset($order->buyer_address))
                                                <div class="mt-2 p-2 bg-info bg-opacity-10 rounded">
                                                    <small class="text-muted">
                                                        <strong><i class="fas fa-user"></i> Info Pengiriman:</strong><br>
                                                        @if($order->buyer_name)
                                                            {{ $order->buyer_name }}
                                                        @endif
                                                        @if($order->buyer_phone)
                                                            - <i class="fas fa-phone"></i> {{ $order->buyer_phone }}
                                                        @endif
                                                        <br>
                                                        @if($order->buyer_address)
                                                            <i class="fas fa-map-marker-alt"></i> {{ Str::limit($order->buyer_address, 50) }}
                                                        @endif
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <div class="h5 text-primary mb-2">
                                                Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}
                                            </div>
                                            
                                            <!-- Status Badge -->
                                            <div class="mb-3">
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning fs-6">
                                                            <i class="fas fa-clock"></i> Menunggu Konfirmasi
                                                        </span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="badge bg-primary fs-6">
                                                            <i class="fas fa-check"></i> Dikonfirmasi
                                                        </span>
                                                        @break
                                                    @case('processing')
                                                        <span class="badge bg-info fs-6">
                                                            <i class="fas fa-cog"></i> Diproses
                                                        </span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="badge bg-info fs-6">
                                                            <i class="fas fa-truck"></i> Sedang Dikirim
                                                        </span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge bg-success fs-6">
                                                            <i class="fas fa-check-circle"></i> Selesai
                                                        </span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger fs-6">
                                                            <i class="fas fa-times"></i> Dibatalkan
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary fs-6">
                                                            <i class="fas fa-question"></i> {{ ucfirst($order->status) }}
                                                        </span>
                                                @endswitch
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="d-grid gap-2">
                                                <!-- View Details Button (Always Available) -->
                                                <a href="{{ route('orders.show', $order->id) }}" 
                                                   class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>

                                                @if(in_array($order->status, ['pending', 'confirmed']))
                                                    <!-- Cancel Order Button -->
                                                    <form method="POST" 
                                                          action="{{ route('orders.cancel', $order->id) }}" 
                                                          style="display: inline;"
                                                          onsubmit="return cancelOrder(event)">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                            <i class="fas fa-times"></i> Batalkan
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($order->status == 'delivered')
                                                    <!-- Confirm Delivery Button -->
                                                    <button type="button" class="btn btn-success btn-sm" 
                                                            onclick="confirmDelivery({{ $order->id }})">
                                                        <i class="fas fa-check"></i> Konfirmasi Diterima
                                                    </button>
                                                @endif
                                                
                                                <!-- Contact Seller -->
                                                @if(in_array($order->status, ['confirmed', 'processing', 'delivered']) && $order->orderItems->first() && $order->orderItems->first()->product && $order->orderItems->first()->product->user)
                                                    @php
                                                        $whatsapp = optional($order->orderItems->first()->product->user->umkmProfile)->whatsapp;
                                                        $cleanWhatsapp = $whatsapp ? preg_replace('/[^0-9]/', '', $whatsapp) : null;
                                                        $orderNumber = $order->order_number ?? str_pad($order->id, 6, '0', STR_PAD_LEFT);
                                                    @endphp
                                                    @if($cleanWhatsapp)
                                                        <a href="https://wa.me/{{ $cleanWhatsapp }}?text=Halo, saya ingin bertanya tentang pesanan {{ $orderNumber }}" 
                                                           target="_blank" class="btn btn-outline-success btn-sm">
                                                            <i class="fab fa-whatsapp"></i> Hubungi Penjual
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Notes -->
                                    @if(isset($order->notes) && $order->notes)
                                        <div class="mt-3 p-2 bg-warning bg-opacity-10 rounded">
                                            <small class="text-muted">
                                                <strong><i class="fas fa-sticky-note"></i> Catatan:</strong> {{ $order->notes }}
                                            </small>
                                        </div>
                                    @endif

                                    <!-- Order Timeline (for completed orders) -->
                                    @if($order->status == 'completed' && $order->updated_at->diffInDays($order->created_at) > 0)
                                        <div class="mt-3 p-2 bg-success bg-opacity-10 rounded">
                                            <small class="text-muted">
                                                <strong><i class="fas fa-clock"></i> Waktu Penyelesaian:</strong> 
                                                {{ $order->updated_at->diffForHumans($order->created_at) }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
                            <h4>Belum Ada Pesanan</h4>
                            <p class="text-muted">Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-store"></i> Jelajahi Produk
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="d-none">
    <div class="d-flex flex-column align-items-center">
        <div class="spinner-border text-primary mb-2" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <small class="text-white">Memproses...</small>
    </div>
</div>

<!-- Hidden Form for Confirm Delivery -->
<form id="confirmDeliveryForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>
@endsection

@push('styles')
<style>
    .order-item {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6 !important;
        position: relative;
    }
    
    .order-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
        border-color: #007bff !important;
    }
    
    .order-image {
        border: 2px solid #dee2e6;
        transition: border-color 0.3s ease;
    }
    
    .order-item:hover .order-image {
        border-color: #007bff;
    }
    
    .placeholder-image {
        border: 2px dashed #dee2e6;
    }
    
    .badge {
        font-size: 0.75rem !important;
        padding: 0.5rem 0.75rem;
    }
    
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
    }
    
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .fade-out {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .fade-in {
        opacity: 1;
        transition: opacity 0.3s ease;
    }
    
    .list-group-item.active {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }
    
    .card-header.bg-info {
        background-color: #0dcaf0 !important;
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
        .order-item .col-md-2,
        .order-item .col-md-7,
        .order-item .col-md-3 {
            margin-bottom: 1rem;
        }
        
        .order-item .col-md-3 {
            text-align: center !important;
        }
        
        .order-item .row {
            margin: 0;
        }
    }
    
    /* Button styling improvements */
    .btn-outline-info:hover {
        color: #fff;
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }
    
    .btn-outline-success:hover {
        color: #fff;
        background-color: #198754;
        border-color: #198754;
    }
    
    .btn-outline-danger:hover {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>
@endpush

@push('scripts')
<script>
    // Filter orders by status
    function filterOrders() {
        const filter = document.getElementById('statusFilter').value;
        const orders = document.querySelectorAll('.order-item');
        let visibleCount = 0;
        
        orders.forEach(order => {
            const status = order.getAttribute('data-status');
            if (filter === '' || status === filter) {
                order.style.display = 'block';
                order.classList.add('fade-in');
                order.classList.remove('fade-out');
                visibleCount++;
            } else {
                order.classList.add('fade-out');
                order.classList.remove('fade-in');
                setTimeout(() => {
                    order.style.display = 'none';
                }, 300);
            }
        });
        
        // Update count
        document.getElementById('orderCount').textContent = visibleCount + ' pesanan';
    }
    
    // Show loading overlay
    function showLoading() {
        document.getElementById('loadingOverlay').classList.remove('d-none');
    }
    
    // Hide loading overlay
    function hideLoading() {
        document.getElementById('loadingOverlay').classList.add('d-none');
    }
    
    // Cancel order function
    function cancelOrder(event) {
        event.preventDefault();
        if (confirm('Yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.')) {
            showLoading();
            event.target.submit();
        }
        return false;
    }
    
    // Confirm delivery function
    function confirmDelivery(orderId) {
        if (confirm('Konfirmasi bahwa Anda telah menerima pesanan ini?')) {
            showLoading();
            const form = document.getElementById('confirmDeliveryForm');
            form.action = `/orders/${orderId}/confirm-delivery`;
            form.submit();
        }
    }
    
    // Document ready functions
    document.addEventListener('DOMContentLoaded', function() {
        // Handle form submissions with loading
        const forms = document.querySelectorAll('form:not(#confirmDeliveryForm)');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                showLoading();
            });
        });
        
        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.add('fade-out');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });
        
        // Initialize order count
        const totalOrders = document.querySelectorAll('.order-item').length;
        document.getElementById('orderCount').textContent = totalOrders + ' pesanan';
    });
    
    // Auto-refresh for pending orders (every 60 seconds)
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            const pendingOrders = document.querySelectorAll('[data-status="pending"], [data-status="confirmed"], [data-status="processing"]');
            if (pendingOrders.length > 0) {
                // Subtle refresh indicator
                const refreshIndicator = document.createElement('div');
                refreshIndicator.className = 'position-fixed top-0 end-0 m-3 alert alert-info py-1 px-2';
                refreshIndicator.innerHTML = '<small><i class="fas fa-sync-alt fa-spin"></i> Memperbarui...</small>';
                document.body.appendChild(refreshIndicator);
                
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        }
    }, 60000); // 60 seconds
    
    // Handle WhatsApp link clicks with analytics
    document.addEventListener('click', function(e) {
        const whatsappLink = e.target.closest('a[href*="wa.me"]');
        if (whatsappLink) {
            console.log('WhatsApp contact initiated for order');
            // Add analytics tracking here if needed
        }
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Press 'F' to focus on filter
        if (e.key === 'f' || e.key === 'F') {
            if (!e.target.matches('input, textarea, select')) {
                e.preventDefault();
                document.getElementById('statusFilter').focus();
            }
        }
        
        // Press 'Escape' to clear filter
        if (e.key === 'Escape') {
            document.getElementById('statusFilter').value = '';
            filterOrders();
        }
    });
</script>
@endpush