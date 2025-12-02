@extends('layouts.app-admin')

@section('title', 'Manage Tools')
@section('header', 'Kelola Data Alat')

@section('content')
<div class="container mx-auto px-4 py-4">

    <!-- FILTER CARD -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <form method="GET" action="{{ route('admin.tools') }}" class="flex flex-wrap items-center gap-3">

            <!-- ✅ Search input -->
            <input type="text" id="searchInput" name="search" placeholder="Search nama alat..."
                value="{{ request('search') }}"
                class="flex-1 min-w-[200px] bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-[#73AF6F] focus:border-[#73AF6F] p-2.5"
                autocomplete="off">

            <!-- ✅ Filter kategori -->
            <div class="relative md:w-auto w-full">
                <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                    class="flex items-center justify-between w-full py-2 px-3 rounded font-semibold md:w-auto md:border-0 md:p-2.5 
        bg-[#73AF6F] text-white hover:bg-[#73AF6F] transition text-sm">
                    {{ request('category') ? ucfirst(request('category')) : 'All Categories' }}
                    <svg class="w-4 h-4 ms-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </button>

                <div id="filterDropdown"
                    class="z-10 hidden w-full md:w-44 my-2 list-none divide-y rounded-lg shadow-sm bg-[#73AF6F] divide-[#73AF6F]">
                    <ul class="py-2 text-sm text-white font-medium">
                        <li>
                            <a href="{{ route('admin.tools', ['search' => request('search'), 'category' => '']) }}"
                                class="inline-flex items-center w-full p-2 hover:bg-[#5e9c5a] transition">All</a>
                        </li>
                        @foreach($categories ?? [] as $cat)
                        <li>
                            <a href="{{ route('admin.tools', ['search' => request('search'), 'category' => strtolower($cat['nama_kategori'])]) }}"
                                class="inline-flex items-center w-full p-2 hover:bg-[#5e9c5a] transition">
                                {{ $cat['nama_kategori'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- ✅ Tombol Search menggantikan Add Tool -->
            <button type="submit"
                class="bg-[#73AF6F] hover:bg-[#5e9c5a] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2.5-5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
                </svg>
                Search
            </button>

        </form>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">

            <table class="w-full table-auto border border-gray-200">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                        <th class="px-6 py-3 text-left">Nama Alat</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Deskripsi</th>
                        <th class="px-6 py-3 text-right">Harga / Hari</th>
                        <th class="px-6 py-3 text-right">Harga / Minggu</th>
                        <th class="px-6 py-3 text-right">Harga / Bulan</th>
                        <th class="px-6 py-3 text-left">Spesifikasi</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody id="tableBody" class="divide-y divide-gray-200">
                    @forelse ($tools as $tool)
                    <tr class="hover:bg-gray-50"
                        data-name="{{ strtolower($tool['nama_alat']) }}"
                        data-category="{{ strtolower($tool['nama_kategori']) }}">

                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $tool['nama_alat'] }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $tool['nama_kategori'] }}
                        </td>

                        <td class="px-6 py-4 text-xs text-gray-500 max-w-[200px] truncate">
                            {{ $tool['deskripsi'] }}
                        </td>

                        <td class="px-6 py-4 text-sm text-right font-semibold">
                            Rp {{ number_format($tool['harga_per_hari'],0,',','.') }}
                        </td>

                        <td class="px-6 py-4 text-sm text-right font-semibold">
                            Rp {{ number_format($tool['harga_per_minggu'],0,',','.') }}
                        </td>

                        <td class="px-6 py-4 text-sm text-right font-semibold">
                            Rp {{ number_format($tool['harga_per_bulan'],0,',','.') }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700 max-w-[150px] truncate">
                            {{ $tool['spesifikasi'] }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-2">

                                <!-- ✅ Edit → langsung ke form otomatis terisi -->
                                <a href="{{ route('admin.tools.edit', $tool['id']) }}"
                                    class="text-amber-600 hover:text-amber-800" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828l-8.586 8.586H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <!-- ✅ Delete -->
                                <button type="button"
                                    class="text-red-600 hover:text-red-800 deleteBtn"
                                    data-id="{{ $tool['id'] }}"
                                    data-name="{{ $tool['nama_alat'] }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <!-- ✅ Lihat API (opsional) -->
                                <a href="{{ $api }}/{{ $tool['id'] }}" target="_blank" class="text-green-600 hover:text-green-800" title="Look at API">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>

                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-400 text-sm">
                            Tidak ada data dari API
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;

            if (!confirm(`Yakin ingin menghapus alat "${name}"?`)) return;

            fetch("{{ url('/admin/tools') }}/" + id, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                })
                .then(res => {
                    if(res.ok) {
                        alert("Berhasil dihapus!");
                        location.reload();
                    } else {
                        alert("Gagal menghapus! Status: " + res.status);
                    }

                })
                .catch(err => alert("Error: " + err));
        });
    });
</script>

@endsection