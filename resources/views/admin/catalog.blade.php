@extends('layouts.app-admin')

@section('title', 'Farm Tools')

@section('content')
<section class="py-8 antialiased md:py-12">
    <div class="mx-auto max-w-7xl px-4 2xl:px-0">

        <!-- FORM FILTER -->
        <form method="GET" action="{{ route('catalog') }}" id="filterForm">
            <div class="mb-4 items-center justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">

                <!-- Search Section (Kiri) -->
                <div class="flex-1 max-w-md">
                    <label for="search" class="block mb-2.5 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search"
                            id="search"
                            name="search"
                            value="{{ $filters['search'] ?? '' }}"
                            class="block w-full p-3 ps-9 bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-[#73AF6F] focus:border-[#73AF6F] shadow-sm placeholder:text-gray-500"
                            placeholder="Search"
                            autocomplete="off" />
                        <button type="submit"
                            class="absolute end-1.5 bottom-1.5 text-white bg-[#73AF6F] hover:bg-[#6AA867] border border-transparent focus:ring-4 focus:ring-green-200 shadow-sm font-medium leading-5 rounded text-xs px-3 py-1.5 focus:outline-none">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Filter & Sort Section (Kanan) -->
                <div class="flex items-center space-x-4">
                    <!-- Sort Button -->
                    <div class="relative">
                        <button id="sortDropdownButton1"
                            type="button"
                            onclick="toggleSortDropdown()"
                            class="flex w-full items-center justify-center rounded-lg border border-[#73AF6F] bg-[#73AF6F] px-3 py-2 text-sm font-medium text-white hover:bg-[#6AA867] focus:z-10 focus:outline-none focus:ring-4 focus:ring-[#6AA867] sm:w-auto">
                            <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4" />
                            </svg>
                            Sort
                            <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 9-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="dropdownSort1"
                            class="hidden absolute right-0 mt-2 z-50 w-48 divide-y divide-[#6AA867] rounded-lg bg-[#73AF6F] shadow-lg">
                            <ul class="py-2 text-left text-sm font-medium text-white">
                                <li>
                                    <button type="button" onclick="selectSort('')"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        Default
                                    </button>
                                </li>
                                <li>
                                    <button type="button" onclick="selectSort('popular')"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        The most popular
                                    </button>
                                </li>
                                <li>
                                    <button type="button" onclick="selectSort('newest')"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        Newest
                                    </button>
                                </li>
                                <li>
                                    <button type="button" onclick="selectSort('price_low')"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        Increasing price
                                    </button>
                                </li>
                                <li>
                                    <button type="button" onclick="selectSort('price_high')"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        Decreasing price
                                    </button>
                                </li>
                                <li>
                                    <button type="button" onclick="selectSort('reviews')"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        No. reviews
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden Sort Input -->
            <input type="hidden" name="sort" id="sortInput" value="{{ $filters['sort'] ?? '' }}">
        </form>

        <!-- Active Filters Display -->
        @if(count(array_filter($filters ?? [])) > 0)
        <div class="mb-6 flex flex-wrap gap-2">
            @if(!empty($filters['search']))
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#73AF6F] text-white text-sm rounded-full">
                Search: {{ $filters['search'] }}
                <a href="{{ route('catalog', array_filter(array_merge($filters, ['search' => null]))) }}" class="hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </span>
            @endif

            @if(!empty($filters['category']))
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#73AF6F] text-white text-sm rounded-full">
                Category: {{ ucfirst(str_replace('-', ' ', $filters['category'])) }}
                <a href="{{ route('catalog', array_filter(array_merge($filters, ['category' => null]))) }}" class="hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </span>
            @endif

            @if(!empty($filters['status']))
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#73AF6F] text-white text-sm rounded-full">
                Status: {{ ucfirst($filters['status']) }}
                <a href="{{ route('catalog', array_filter(array_merge($filters, ['status' => null]))) }}" class="hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </span>
            @endif
        </div>
        @endif

        <!-- PRODUCTS GRID -->
        <div id="tool-list" class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($tools as $index => $tool)
            <div class="tool-card flex flex-col rounded-lg border border-gray-200 bg-white p-6 shadow-sm h-full {{ $index > 7 ? 'hidden' : '' }}">
                <div class="h-56 w-full">
                    <a href="{{ route('product', $tool['id']) }}">
                        <img class="mx-auto h-full block"
                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg"
                            alt="{{ $tool['nama_alat'] }}" />
                    </a>
                </div>
                <div class="pt-6 flex flex-col grow">
                    <a href="{{ route('product', $tool['id']) }}"
                        class="text-lg font-semibold leading-tight text-gray-900 hover:underline">
                        {{ $tool['nama_alat'] }}
                    </a>
                    <ul class="mt-2 flex items-center gap-4">
                        <li class="flex items-center gap-2">
                            <p class="bg-lime-100 text-rose-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded">{{ $tool['nama_kategori'] }}</p>
                        </li>
                    </ul>
                    <div class="mt-auto pt-4 flex items-center justify-between gap-4">
                        <p class="text-lg font-extrabold leading-tight text-gray-900">
                            Rp. {{ number_format($tool['harga_per_hari'], 0, ',', '.') }}/hari
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No tools found</h3>
                <p class="text-gray-500">Try adjusting your filters or search terms</p>
            </div>
            @endforelse
        </div>

        <!-- Show More Button -->
        @if(count($tools) > 8)
        <div class="w-full text-center">
            <button type="button" id="showMoreBtn"
                class="rounded-lg border border-gray-200 bg-[#73AF6F] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#6AA867] focus:z-10 focus:outline-none focus:ring-4 focus:ring-[#6AA867]">
                Show more
            </button>
        </div>
        @endif
    </div>
</section>

<script>
    // Toggle Sort Dropdown
    function toggleSortDropdown() {
        document.getElementById('dropdownSort1').classList.toggle('hidden');
    }

    // Select Sort Option
    function selectSort(value) {
        document.getElementById('sortInput').value = value;
        document.getElementById('filterForm').submit();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdownSort1');
        const button = document.getElementById('sortDropdownButton1');

        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Show More Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.tool-card');
        const btn = document.getElementById('showMoreBtn');

        if (btn) {
            let visible = 8;

            btn.addEventListener('click', function() {
                for (let i = visible; i < visible + 8; i++) {
                    if (cards[i]) {
                        cards[i].classList.remove('hidden');
                    }
                }
                visible += 8;
                if (visible >= cards.length) {
                    btn.style.display = 'none';
                }
            });
        }
    });
</script>
@endsection