@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Produk Saya</h2>
<a href="{{ route('umkm.products.create') }}" class="btn-primary">+ TAMBAH PRODUK BARU</a>

<table>
    <thead>
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
            <td>{{ $product->name }}</td>
            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                <span class="status 
                    {{ $product->status == 'disetujui' ? 'approved' : 
                       ($product->status == 'menunggu persetujuan' ? 'pending' : 'rejected') }}">
                    {{ strtoupper($product->status) }}
                </span>
            </td>
            <td>
                <a href="{{ route('umkm.products.edit', $product) }}" class="btn-edit">Edit</a>
                <form action="{{ route('umkm.products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus produk?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #7c3aed; /* Warna ungu latar */
        margin: 0;
        padding: 0;
        color: #111827;
    }

    .container {
        max-width: 1100px;
        margin: 40px auto;
        background-color: #1f2937(0, 0, 0);
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 28px;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 25px;
    }

    .btn-primary {
        background-color: #10b981;
        color: white;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        text-decoration: none;
        margin-bottom: 20px;
        float: right;
    }

    .btn-primary:hover {
        background-color: #059669;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
    }

    thead {
        background-color: #d1d5db;
        font-weight: bold;
        font-size: 14px;
        color: #374151;
    }

    th, td {
        padding: 14px 18px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background-color: #f3f4f6;
    }

    /* Badge Status */
    .badge {
        display: inline-block;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 12px;
    }

    .approved {
        background-color: #d1fae5;
        color: #065f46;
    }

    .pending {
        background-color: #fef9c3;
        color: #92400e;
    }

    .rejected {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .btn-edit {
        background-color: #facc15;
        color: #1f2937;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        margin-right: 6px;
        cursor: pointer;
    }

    .btn-edit:hover {
        background-color: #eab308;
    }

    .btn-delete {
        background-color: #ef4444;
        color: white;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-delete:hover {
        background-color: #dc2626;
    }

    /* Footer */
    .footer {
        text-align: center;
        font-size: 12px;
        color: #f3f4f6;
        background-color: #000000;
        padding: 15px;
        margin-top: 40px;
    }
</style>
