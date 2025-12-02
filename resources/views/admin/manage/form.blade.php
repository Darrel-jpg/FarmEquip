@extends('layouts.app-admin')

@section('title', $mode == 'create' ? 'Create Tool' : 'Edit Tool')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md w-full py-8 px-10 mx-auto max-w-2xl">

        <h2 class="block mb-4 text-lg font-semibold text-gray-900">
            {{ $header ?? ($mode=='create' ? 'Tambah Alat' : 'Edit Data Alat') }}
        </h2>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg mb-4">{{ session('error') }}</div>
        @endif

        <form id="toolForm" action="{{ route('admin.tools.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nama Alat</label>
                    <input type="text" name="nama_alat" required autocomplete="off"
                        value="{{ old('nama_alat', $tool['nama_alat'] ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5"
                        placeholder="Masukkan nama alat">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                    <select id="kategoriSelect" name="kategori_id" required
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5">

                        <option value="" disabled {{ !$tool ? 'selected' : '' }}>Select a category</option>

                        @foreach ($categories as $cat)
                        <option value="{{ $cat['id'] }}"
                            {{ old('kategori_id', $tool['kategori_id'] ?? '') == $cat['id'] ? 'selected' : '' }}>
                            {{ $cat['nama_kategori'] }}
                        </option>
                        @endforeach

                        <option value="__add">➕ Tambah Kategori</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                    <textarea name="deskripsi" rows="5" required
                        class="block w-full p-2.5 text-sm bg-gray-50 rounded-lg border focus:ring-[#73AF6F] focus:border-[#73AF6F]"
                        placeholder="Masukkan deskripsi alat">{{ old('deskripsi', $tool['deskripsi'] ?? '') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Spesifikasi</label>
                    <textarea name="spesifikasi" rows="3" required
                        class="block w-full p-2.5 text-sm bg-gray-50 rounded-lg border focus:ring-[#73AF6F] focus:border-[#73AF6F]"
                        placeholder="Masukkan spesifikasi alat">{{ old('spesifikasi', $tool['spesifikasi'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Harga per Hari</label>
                    <input type="number" name="harga_per_hari" required
                        value="{{ old('harga_per_hari', $tool['harga_per_hari'] ?? '') }}"
                        class="bg-gray-50 border text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5"
                        placeholder="0">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Harga per Minggu</label>
                    <input type="number" name="harga_per_minggu" required
                        value="{{ old('harga_per_minggu', $tool['harga_per_minggu'] ?? '') }}"
                        class="bg-gray-50 border text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5"
                        placeholder="0">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Harga per Bulan</label>
                    <input type="number" name="harga_per_bulan" required
                        value="{{ old('harga_per_bulan', $tool['harga_per_bulan'] ?? '') }}"
                        class="bg-gray-50 border text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5"
                        placeholder="0">
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Gambar</label>
                    <input type="file" id="gambarUpload" name="gambar" accept="image/png, image/jpeg"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5">
                    <p class="mt-1 text-xs text-gray-500">Format wajib: PNG / JPG</p>
                </div>

                <div class="flex items-center gap-3 sm:col-span-2">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-[#73AF6F] rounded-lg hover:bg-[#5E9E5A] transition">
                        {{ $mode=='edit' ? 'Update' : 'Create' }}
                    </button>

                    <a href="{{ route('admin.tools') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-800 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('toolForm');

        form.addEventListener('submit', function(e) {
        });

    });
</script>
@endsection