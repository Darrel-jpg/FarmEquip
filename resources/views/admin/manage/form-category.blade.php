@extends('layouts.app-admin')
@section('title', $mode == 'create' ? 'Create Category' : 'Edit Category')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md w-full py-8 px-10 mx-auto max-w-2xl">

        <h2 class="block mb-4 text-lg font-semibold text-gray-900">
            {{ $header ?? ($mode=='create' ? 'Tambah Kategori' : 'Edit Kategori') }}
        </h2>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg mb-4">{{ session('error') }}</div>
        @endif

        <form id="kategoriForm">
            @csrf

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nama Kategori</label>
                    <input type="text" name="nama_kategori" required autocomplete="off"
                        value="{{ old('nama_kategori', $category['nama_kategori'] ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] block w-full p-2.5"
                        placeholder="Masukkan nama kategori">
                </div>

                <div class="sm:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" required
                        class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-[#73AF6F] focus:border-[#73AF6F]"
                        placeholder="Masukkan deskripsi kategori">{{ old('deskripsi', $category['deskripsi'] ?? '') }}</textarea>
                </div>

                <div class="sm:col-span-2">
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
    document.getElementById('kategoriForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const data = new FormData(this);
        const payload = Object.fromEntries(data.entries());
        const id = "{{ $category['id'] ?? '' }}";
        const url = id ? `https://farmequip.up.railway.app/kategori/${id}` : `https://farmequip.up.railway.app/kategori`;
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

            location.href = "{{ route('admin.tools.create') }}";
        } catch {
            alert("Gagal submit kategori ke API!");
        }
    });
</script>
@endsection