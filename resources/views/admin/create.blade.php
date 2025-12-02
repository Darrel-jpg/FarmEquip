@extends('layouts.app-admin')

@section('title', $tool['nama_alat'] ?? 'Create Tool')

@section('content')
<div class="bg-white rounded-2xl shadow-md w-full py-8 px-10 mx-auto max-w-2xl">
    <h1 class="text-2xl font-bold mb-5 text-green-600">
        {{ isset($tool) ? 'Edit Tool' : 'Create Tools' }}
    </h1>

    <form action="{{ isset($tool) ? route('admin.tools.update', $tool['id']) : route('admin.tools.create') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @if(isset($tool))
        @method('PUT')
        @endif

        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <!-- NAMA ALAT -->
            <div class="sm:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-900">Nama Alat</label>
                <input type="text" name="nama_alat"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-800 focus:border-green-800 block w-full p-3"
                    placeholder="Type tool name"
                    value="{{ old('nama_alat', $tool['nama_alat'] ?? '') }}" required>
            </div>

            <!-- KATEGORI -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-900">Kategori</label>
                <select id="category-select" name="kategori_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-800 focus:border-green-800 block w-full p-3" required>
                    <option value="" disabled selected>Select a category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}"
                        {{ old('kategori_id', $tool['kategori_id'] ?? '') == $category['id'] ? 'selected' : '' }}>
                        {{ $category['nama_kategori'] }}
                    </option>
                    @endforeach
                    <option value="other">+ Create new category</option>
                </select>

                <!-- Input kategori baru -->
                <div id="new-category-wrapper" class="hidden mt-3">
                    <label class="block mb-2 text-sm font-semibold text-gray-900">Nama Kategori Baru</label>
                    <input type="text" name="new_category"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-800 focus:border-green-800 block w-full p-3"
                        placeholder="Enter new category name">
                </div>
            </div>

            <!-- STATUS -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-900">Status</label>
                <select name="status"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-800 focus:border-green-800 block w-full p-3"
                    required>
                    <option value="available" {{ old('status', $tool['status'] ?? '') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="rented" {{ old('status', $tool['status'] ?? '') == 'rented' ? 'selected' : '' }}>Rented</option>
                    <option value="broken" {{ old('status', $tool['status'] ?? '') == 'broken' ? 'selected' : '' }}>Broken</option>
                </select>
            </div>

            <!-- DESKRIPSI -->
            <div class="sm:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-900">Deskripsi</label>
                <div class="bg-gray-50 w-full border border-gray-300 rounded-lg">
                    <textarea name="deskripsi" rows="6"
                        class="block bg-gray-50 w-full px-0 text-sm text-heading border-0 focus:ring-0 placeholder:text-body p-3 rounded-lg"
                        placeholder="Write tool description..." required>{{ old('deskripsi', $tool['deskripsi'] ?? '') }}</textarea>
                </div>
            </div>

            <!-- HARGA -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-900">Harga Per Hari</label>
                <input type="number" name="harga_per_hari"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-800 focus:border-green-800 block w-full p-3"
                    placeholder="Daily price"
                    value="{{ old('harga_per_hari', $tool['harga_per_hari'] ?? '') }}" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-900">Harga Per Minggu</label>
                <input type="number" name="harga_per_minggu"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-800 focus:border-green-800 block w-full p-3"
                    placeholder="Weekly price"
                    value="{{ old('harga_per_minggu', $tool['harga_per_minggu'] ?? '') }}" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-900">Harga Per Bulan</label>
                <input type="number" name="harga_per_bulan"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-800 focus:border-green-800 block w-full p-3"
                    placeholder="Monthly price"
                    value="{{ old('harga_per_bulan', $tool['harga_per_bulan'] ?? '') }}" required>
            </div>

            <!-- GAMBAR UPLOAD -->
            <div class="sm:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-900">Gambar</label>
                <input type="file" name="gambar"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-800 focus:border-green-800 block w-full p-3">
            </div>

            <!-- BUTTON -->
            <div class="flex items-center gap-3 sm:col-span-2">
                <button type="submit"
                    class="px-5 py-3 text-sm font-medium text-white bg-green-800 rounded-lg hover:bg-green-700 transition">
                    {{ isset($tool) ? 'Update Tool' : 'Save Tool' }}
                </button>

                <a href="{{ route('admin.dashboard') }}"
                    class="px-5 py-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('category-select').addEventListener('change', function() {
        const wrapper = document.getElementById('new-category-wrapper');

        if (this.value === 'other') {
            wrapper.classList.remove('hidden');
            wrapper.querySelector('input').required = true;
        } else {
            wrapper.classList.add('hidden');
            wrapper.querySelector('input').required = false;
        }
    });
</script>
@endsection