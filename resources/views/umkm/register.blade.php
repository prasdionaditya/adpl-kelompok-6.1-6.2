@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold mb-4">Pendaftaran Toko UMKM</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('umkm.registerStore') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="store_name">
                Nama Toko
            </label>
            <input type="text" name="store_name" id="store_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ old('store_name') }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="store_description">
                Deskripsi Toko
            </label>
            <textarea name="store_description" id="store_description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">{{ old('store_description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="store_address">
                Alamat Toko
            </label>
            <input type="text" name="store_address" id="store_address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ old('store_address') }}" required>
        </div>

        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2" for="latitude">
                    Latitude (opsional)
                </label>
                <input type="text" name="latitude" id="latitude" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ old('latitude') }}">
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2" for="longitude">
                    Longitude (opsional)
                </label>
                <input type="text" name="longitude" id="longitude" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="{{ old('longitude') }}">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="store_image">
                Gambar Toko (opsional)
            </label>
            <input type="file" name="store_image" id="store_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:bg-gray-50 file:text-sm file:font-semibold file:text-gray-700">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Simpan Profil Toko
            </button>
        </div>
    </form>
</div>
@endsection
