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

        <!-- FORM langsung submit ke API Go -->
        <form id="toolForm">

            @csrf

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nama Alat</label>
                    <input type="text" name="nama_alat" required autocomplete="off"
                        value="{{ old('nama_alat', $tool['nama_alat'] ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                        placeholder="Masukkan nama alat">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                    <select name="nama_kategori"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5">
                        <option value="" disabled {{ $mode=='create' ? 'selected' : '' }}>Select a category</option>
                        @foreach ($categories as $cat)
                        <option value="{{ $cat['nama_kategori'] }}"
                            {{ old('nama_kategori', $tool['nama_kategori'] ?? '') == $cat['nama_kategori'] ? 'selected' : '' }}>
                            {{ $cat['nama_kategori'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                    <textarea name="deskripsi" rows="5" required
                        class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-[#FFAB2F] focus:border-[#FFAB2F]"
                        placeholder="Masukkan deskripsi alat">{{ old('deskripsi', $tool['deskripsi'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Harga Harian</label>
                    <input type="number" name="harga_per_hari" required
                        value="{{ old('harga_per_hari', $tool['harga_per_hari'] ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                        placeholder="0">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Harga Mingguan</label>
                    <input type="number" name="harga_per_minggu" required
                        value="{{ old('harga_per_minggu', $tool['harga_per_minggu'] ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                        placeholder="0">
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Harga Bulanan</label>
                    <input type="number" name="harga_per_bulan" required
                        value="{{ old('harga_per_bulan', $tool['harga_per_bulan'] ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] block w-full p-2.5"
                        placeholder="0">
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Gambar (Base64)</label>
                    <textarea name="gambar" rows="3"
                        class="block w-full p-2.5 text-xs text-gray-900 bg-gray-50 rounded-lg border border-gray-300 font-mono focus:ring-[#FFAB2F] focus:border-[#FFAB2F]"
                        placeholder="Paste base64 gambar di sini">{{ old('gambar', $tool['gambar'] ?? '') }}</textarea>
                </div>

                <div class="flex items-center gap-3 sm:col-span-2">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-[#FFAB2F] rounded-lg hover:bg-[#FF9D0A] transition">
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
    document.getElementById('toolForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const payload = Object.fromEntries(formData.entries());

        const id = "{{ $tool['id'] ?? '' }}";
        const url = id ?
            `https://farmequip.up.railway.app/alat/${id}` :
            `https://farmequip.up.railway.app/alat`;

        const method = id ? "PUT" : "POST";

        try {
            const res = await fetch(url, {
                method,
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(payload)
            });

            if (!res.ok) throw new Error("Request failed");

            location.href = "{{ route('admin.tools') }}";
        } catch (err) {
            alert("Gagal submit ke API Go!");
        }
    });
</script>
@endsection