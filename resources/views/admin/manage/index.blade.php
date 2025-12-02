@extends('layouts.app')

@section('title', 'Manage Tools')

@section('content')
    <div class="container mx-auto mt-8 px-10 py-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="shrink-0 bg-amber-100 rounded-lg p-3">
                        <svg class="w-8 h-8 text-[#FF9D0A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 2v8c0 1 .5 2 1.5 2h11c1 0 1.5-1 1.5-2V2M8 2v8M12 2v8M16 2v8M11 12v10M13 12v10" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Tools</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($tools) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 cursor-pointer hover:shadow-md transition"
                data-modal-target="categoriesModal" data-modal-toggle="categoriesModal">
                <div class="flex items-center">
                    <div class="shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Categories</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($categories) }}</p>
                        <p class="text-xs text-[#73AF6F] mt-1">Click to manage →</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="shrink-0 bg-purple-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Authors</p>
                        <p class="text-2xl font-bold text-gray-900">#</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTER CARD -->
        <div class="bg-white rounded-lg shadow-sm p-4 my-6">
            <form method="GET" action="{{ route('admin.tools') }}"
                class="flex flex-col md:flex-row items-center justify-between w-full gap-4">

                <!-- Search Bar - Left Side -->
                <div class="relative w-full md:w-96">
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="search" name="search" value="{{ request('search') }}"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-[#73AF6F] focus:border-[#73AF6F]"
                        placeholder="Search nama alat..." autocomplete="off" />

                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-[#73AF6F] hover:bg-[#5e9c5a] focus:ring-4 focus:outline-none focus:ring-[#5e9c5a] font-medium rounded-lg text-sm px-4 py-2">
                        Search
                    </button>
                </div>

                <!-- Filter & Add Button - Right Side -->
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <!-- Filter Dropdown -->
                    <div class="relative w-full md:w-auto">
                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" type="button"
                            class="flex items-center justify-between w-full py-2 px-3 rounded font-semibold md:w-44 md:border-0 md:p-2.5 bg-[#73AF6F] text-white hover:bg-[#5e9c5a] transition text-sm">
                            {{ request('category') ? ucfirst(request('category')) : 'All Categories' }}
                            <svg class="w-4 h-4 ms-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="filterDropdown"
                            class="z-10 hidden w-full md:w-44 my-2 list-none divide-y rounded-md shadow-sm bg-[#73AF6F] divide-[#73AF6F] absolute md:right-0">
                            <ul class="py-2 text-sm text-white font-medium">
                                <li>
                                    <a href="{{ route('admin.tools', ['search' => request('search'), 'category' => '']) }}"
                                        class="inline-flex items-center w-full p-2 hover:bg-[#5e9c5a] transition">All</a>
                                </li>
                                @foreach ($categories ?? [] as $cat)
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

                    <!-- Add New Post Button -->
                    <a href="{{ route('admin.tools.create') }}"
                        class="bg-[#73AF6F] hover:bg-[#5e9c5a] text-white px-4 py-2 rounded-md flex items-center gap-2 transition whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add new tool
                    </a>
                </div>
            </form>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-auto border border-gray-200">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <th class="px-6 py-3 text-left">Tool Name</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Description</th>
                            <th class="px-6 py-3 text-right">Price / Day</th>
                            <th class="px-6 py-3 text-right">Price / Week</th>
                            <th class="px-6 py-3 text-right">Price / Month</th>
                            <th class="px-6 py-3 text-left">Specification</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-gray-200">
                        @forelse ($tools as $tool)
                            <tr class="hover:bg-gray-50" data-name="{{ strtolower($tool['nama_alat']) }}"
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
                                    Rp. {{ number_format($tool['harga_per_hari'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-semibold">
                                    Rp. {{ number_format($tool['harga_per_minggu'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-semibold">
                                    Rp. {{ number_format($tool['harga_per_bulan'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-[150px] truncate">
                                    {{ $tool['spesifikasi'] }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('admin.tools.edit', $tool['id']) }}"
                                            class="text-amber-600 hover:text-amber-800" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828l-8.586 8.586H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button" class="text-red-600 hover:text-red-800 cursor-pointer deleteBtn"
                                            data-id="{{ $tool['id'] }}" data-name="{{ $tool['nama_alat'] }}"
                                            data-modal-target="deleteModal" data-modal-toggle="deleteModal">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        <a href="{{ route('product', $tool['id']) }}" target="_blank"
                                            class="text-green-600 hover:text-green-800" title="Look at FrontEnd">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
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

    <!-- Categories Management Modal -->
    <div id="categoriesModal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
        data-backdrop-classes="bg-gray-900 bg-opacity-80 fixed inset-0 z-40"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Manage Categories
                    </h3>
                    <button type="button" data-modal-toggle="categoriesModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Category Name</th>
                                    <th class="px-6 py-3">Slug</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $category['nama_kategori'] }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 font-mono text-xs">
                                            {{ $category['slug'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <button type="button"
                                                class="text-red-600 hover:text-red-800 cursor-pointer delete-category-btn"
                                                data-category-id="{{ $category['id'] }}"
                                                data-category-name="{{ $category['nama_kategori'] }}"
                                                data-modal-target="deleteModal" data-modal-toggle="deleteModal">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Modal -->
    <div id="deleteModal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
        data-backdrop-classes="bg-gray-900 bg-opacity-90 fixed inset-0 z-40"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative p-4 text-center bg-white rounded-lg shadow sm:p-5">
                <button type="button"
                    class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-toggle="deleteModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <svg class="text-gray-400 w-11 h-11 mb-3.5 mx-auto" fill="currentColor" viewbox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <p class="mb-4 text-gray-500">Are you sure you want to delete this post?</p>
                <p class="mb-4 text-sm text-gray-400">This action cannot be undone.</p>
                <form action="" method="POST" id="deletePostForm">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal" type="button"
                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-300 hover:text-gray-900 focus:z-10">
                            No, cancel
                        </button>
                        <button type="submit"
                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300">
                            Yes, I'm sure
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deletePostForm');
            const deleteMessage = deleteModal.querySelector('.mb-4.text-gray-500');
            const deleteWarning = deleteModal.querySelector('.mb-4.text-sm.text-gray-400');
            const categoriesModal = document.getElementById('categoriesModal');

            // Delete Post
            const deleteToolButtons = document.querySelectorAll('.deleteBtn');
            deleteToolButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const toolId = this.getAttribute('data-id');
                    const toolName = this.getAttribute('data-name');

                    deleteForm.action = `/admin/tools/${toolId}`;
                    deleteMessage.textContent = `Are you sure you want to delete "${toolName}"?`;
                    deleteWarning.textContent = 'This action cannot be undone.';
                });
            });

            // Delete Category
            const deleteCategoryButtons = document.querySelectorAll('.delete-category-btn');
            deleteCategoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-category-id');
                    const categoryName = this.getAttribute('data-category-name');
                    const categoryPosts = this.getAttribute('data-category-posts');

                    deleteForm.action = `/admin/categories/${categoryId}`;
                    deleteMessage.textContent =
                        `Are you sure you want to delete "${categoryName}" category?`;

                    if (categoryPosts > 0) {
                        deleteWarning.textContent =
                            `Warning: This category has ${categoryPosts} post(s). This action cannot be undone.`;
                    } else {
                        deleteWarning.textContent = 'This action cannot be undone.';
                    }

                    categoriesModal.classList.add('hidden');
                    categoriesModal.classList.remove('flex');
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('flex');
                });
            });

            const closeDeleteButtons = document.querySelectorAll('[data-modal-toggle="deleteModal"]');
            closeDeleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (deleteForm.action.includes('/admin/categories/')) {
                        deleteModal.classList.add('hidden');
                        deleteModal.classList.remove('flex');
                        categoriesModal.classList.remove('hidden');
                        categoriesModal.classList.add('flex');
                    }
                });
            });
        });
    </script>
@endsection
