@extends('layouts.app-admin')

@section('title', 'Manage Tools')
@section('header', 'Kelola Data Alat')

@section('content')
<div class="container mx-auto px-4 py-4">
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <div class="flex flex-wrap items-center gap-3">
            <input type="text" id="searchInput" placeholder="Search nama alat..."
                class="flex-1 min-w-[200px] bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] p-2.5" autocomplete="off">
            <select id="filterCategory"
                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-[#FFAB2F] focus:border-[#FFAB2F] p-2.5">
                <option value="">All Categories</option>
                @foreach($categories ?? [] as $cat)
                <option value="{{ strtolower($cat['nama_kategori']) }}">{{ $cat['nama_kategori'] }}</option>
                @endforeach
                <option value="other">+ Create new category</option>
            </select>
            <a href="{{ route('admin.tools.create') }}"
                class="bg-[#FFAB2F] hover:bg-[#FF9D0A] text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Tool
            </a>
        </div>
    </div>

    <!-- Tools Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Author</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Create at</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="bg-white divide-y divide-gray-200">

                    @foreach($tools as $tool)
                    <tr class="hover:bg-gray-50" data-id="{{ $tool['id'] }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-amber-100 rounded-lg mr-3 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-[#FF9D0A]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($tool['nama_alat'] ?? '-', 50) }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($tool['deskripsi'] ?? '', 60) }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $tool['author'] ?? 'API GO' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-semibold rounded-lg bg-orange-100 text-rose-800">
                                {{ $tool['nama_kategori'] ?? '-' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $date = isset($tool['created_at']) ? \Carbon\Carbon::parse($tool['created_at']) : null;
                            @endphp
                            <div class="text-sm text-gray-900">{{ $date ? $date->format('d M Y') : '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $date ? $date->format('H:i') : '' }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">

                                <a href="{{ $api }}/{{ $tool['id'] }}" target="_blank"
                                    class="text-green-600 hover:text-green-800" title="Look at API">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>

                                <a href="{{ route('admin.tools.edit', $tool['id']) }}"
                                    class="text-amber-600 hover:text-amber-800" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <button type="button"
                                    class="text-red-600 hover:text-red-800 cursor-pointer deleteBtn"
                                    title="Delete"
                                    data-id="{{ $tool['id'] }}"
                                    data-name="{{ $tool['nama_alat'] }}"
                                    data-modal-target="deleteModal"
                                    data-modal-toggle="deleteModal">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                    @endforeach

                    @if(empty($tools))
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada data dari API</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>

        <!-- (opsional) Kamu boleh hapus pagination ini kalau API Go tidak return paginate -->
        {{-- <div class="px-6 py-4 border-t border-gray-200">{{ $tools->links() }}
    </div> --}}
</div>
</div>

<!-- Modal Delete -->
<div id="deleteModal" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-md w-full max-w-sm p-5">
        <h3 class="text-md font-semibold mb-3">Konfirmasi Hapus</h3>
        <p class="text-sm text-gray-600 mb-5" id="deleteText">Yakin ingin menghapus?</p>
        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeModal()"
                class="px-4 py-2 text-sm bg-gray-200 rounded-lg">Batal</button>
            <button type="button" id="confirmDeleteBtn"
                class="px-5 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
        </div>
    </div>
</div>

<script>
    let deleteID = null;

    // buka modal hapus
    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            deleteID = btn.dataset.id;
            document.getElementById('deleteText').textContent = `Yakin hapus alat "${btn.dataset.name}" ?`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        });
    });

    // confirm hapus ke API Go
    document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
        if (!deleteID) return;
        try {
            const res = await fetch(`{{ $api }}/${deleteID}`, {
                method: 'DELETE'
            });
            if (!res.ok) throw 1;
            window.location.reload();
        } catch {
            alert('Gagal hapus ke API Go!');
        }
    });

    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection