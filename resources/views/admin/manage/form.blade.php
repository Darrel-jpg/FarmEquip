@extends('layouts.app')

@section('title', $mode == 'create' ? 'Create Tool' : 'Edit Tool')

@section('content')
    <div class="bg-white rounded-lg shadow-md w-full mt-5 md:mt-10 md:mb-6 py-8 px-10 mx-auto max-w-2xl">
        <h2 class="block mb-4 text-lg font-semibold text-gray-900">
            {{ $header }}
        </h2>
        {{-- @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg mb-4">{{ session('error') }}</div>
        @endif --}}
        <form id="toolForm"
            action="{{ $mode == 'edit' ? route('admin.tools.update', $tool['id']) : route('admin.tools.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if ($mode == 'edit')
                @method('PUT')
            @endif
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tool Name</label>
                    <input type="text" name="nama_alat" required autocomplete="off"
                        value="{{ old('nama_alat', $tool['nama_alat'] ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5"
                        placeholder="Masukkan nama alat">
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                    <select id="category-select" name="category_id" required
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5">
                        <option value="" disabled {{ !old('category_id') && !isset($tool) ? 'selected' : '' }}>Select
                            a category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['id'] }}"
                                {{ old('category_id', $tool['kategori_id'] ?? '') == $cat['id'] ? 'selected' : '' }}>
                                {{ $cat['nama_kategori'] }}
                            </option>
                        @endforeach
                        <option value="other" {{ old('category_id') == 'other' ? 'selected' : '' }}>➕ New Category</option>
                    </select>

                    <div id="new-category-wrapper" class="{{ old('category_id') == 'other' ? '' : 'hidden' }} mt-3">
                        <label class="block mb-2 text-sm font-medium text-gray-900">New Category</label>
                        <input type="text" name="new_category" value="{{ old('new_category') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5"
                            autocomplete="off" placeholder="Masukkan nama kategori baru">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                    <textarea name="deskripsi" rows="5" required
                        class="block w-full p-2.5 text-sm bg-gray-50 rounded-lg border focus:ring-[#73AF6F] focus:border-[#73AF6F]"
                        placeholder="Masukkan deskripsi alat">{{ old('deskripsi', $tool['deskripsi'] ?? '') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Specification</label>
                    <textarea name="spesifikasi" rows="3" required
                        class="block w-full p-2.5 text-sm bg-gray-50 rounded-lg border focus:ring-[#73AF6F] focus:border-[#73AF6F]"
                        placeholder="Masukkan spesifikasi alat">{{ old('spesifikasi', $tool['spesifikasi'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Price per Day</label>
                    <input type="number" name="harga_per_hari" required
                        value="{{ old('harga_per_hari', $tool['harga_per_hari'] ?? '') }}"
                        class="bg-gray-50 border text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5"
                        placeholder="0" min="0">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Price per Week</label>
                    <input type="number" name="harga_per_minggu" required
                        value="{{ old('harga_per_minggu', $tool['harga_per_minggu'] ?? '') }}"
                        class="bg-gray-50 border text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5"
                        placeholder="0" min="0">
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Price per Month</label>
                    <input type="number" name="harga_per_bulan" required
                        value="{{ old('harga_per_bulan', $tool['harga_per_bulan'] ?? '') }}"
                        class="bg-gray-50 border text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-71 p-2.5"
                        placeholder="0" min="0">
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        Image {{ $mode == 'edit' ? '(Optional - leave empty to keep current image)' : '' }}
                    </label>
                    <input name="gambar" {{ $mode == 'create' ? 'required' : '' }}
                        class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full shadow-xs"
                        id="file_input" type="file" accept="image/jpeg,image/png,image/jpg">
                    <p class="mt-1 text-xs text-gray-500">JPG, PNG or JPEG</p>

                    @if ($mode == 'edit' && isset($tool['gambar']))
                        <div class="mt-3">
                            <p class="text-xs font-medium text-gray-700 mb-2">Current image:</p>
                            <img src="{{ $tool['gambar'] }}" alt="{{ $tool['nama_alat'] ?? 'Tool image' }}"
                                class="w-40 h-40 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-3 sm:col-span-2">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-[#73AF6F] cursor-pointer rounded-lg hover:bg-[#5E9E5A] transition">
                        {{ $mode == 'edit' ? 'Update' : 'Add' }}
                    </button>

                    <a href="{{ route('admin.tools') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-800 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('category-select').addEventListener('change', function() {
            const wrapper = document.getElementById('new-category-wrapper');
            const input = wrapper.querySelector('input');

            if (this.value === 'other') {
                wrapper.classList.remove('hidden');
                input.required = true;
            } else {
                wrapper.classList.add('hidden');
                input.required = false;
                input.value = ''; // Clear value when hidden
            }
        });

        // Trigger on page load if 'other' is selected (for old input)
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('category-select');
            if (select.value === 'other') {
                const wrapper = document.getElementById('new-category-wrapper');
                wrapper.classList.remove('hidden');
                wrapper.querySelector('input').required = true;
            }
        });
    </script>
@endsection
