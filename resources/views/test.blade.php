@extends('layouts.app')

@section('title', 'Farm Tools')

@section('content')
    <section class="py-8 antialiased md:py-12">
        <div class="mx-auto max-w-7xl px-4 2xl:px-0">
            <div class="mb-4 items-center justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                <!-- Search Section -->
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
                        <input type="search" id="search"
                            class="block w-full p-3 ps-9 bg-white border border-gray-300 text-gray-900 text-sm rounded focus:ring-[#73AF6F] focus:border-[#73AF6F] shadow-sm placeholder:text-gray-500"
                            placeholder="Search" autocomplete="off" required />
                        <button type="button" onclick="handleSearch()"
                            class="absolute end-1.5 bottom-1.5 text-white bg-[#73AF6F] hover:bg-[#6AA867] border border-transparent focus:ring-4 focus:ring-green-200 shadow-sm font-medium leading-5 rounded text-xs px-3 py-1.5 focus:outline-none">
                            Search
                        </button>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Sort Button -->
                    <div class="relative">
                        <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1" type="button"
                            class="flex w-full items-center justify-center rounded-lg border border-[#73AF6F] bg-[#73AF6F] px-3 py-2 text-sm font-medium text-white hover:bg-[#6AA867] hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-[#6AA867] sm:w-auto">
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
                            class="z-50 hidden w-40 divide-y divide-[#6AA867] rounded-lg bg-[#73AF6F] shadow"
                            data-popper-placement="bottom">
                            <ul class="py-2 text-left text-sm font-medium text-white dark:text-gray-400"
                                aria-labelledby="sortDropdownButton">
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        The most popular </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        Newest </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        Increasing price </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        Decreasing price </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="group inline-flex w-full items-center px-3 py-2 text-sm text-white hover:bg-gray-100 hover:text-gray-900">
                                        No. reviews </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tool-list" class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($tools as $index => $tool)
                    <div
                        class="tool-card flex flex-col rounded-lg border border-gray-200 bg-white p-6 shadow-sm h-full {{ $index > 7 ? 'hidden' : '' }}">
                        <div class="h-56 w-full">
                            <a href="{{ route('product', $tool['id']) }}">
                                <img class="mx-auto h-full block"
                                    src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg"
                                    alt="" />
                            </a>
                        </div>
                        <div class="pt-6 flex flex-col grow">
                            <a href="{{ route('product', $tool['id']) }}"
                                class="text-lg font-semibold leading-tight text-gray-900 hover:underline">{{ $tool['nama_alat'] }}</a>
                            <ul class="mt-2 flex items-center gap-4">
                                <li class="flex items-center gap-2">
                                    <svg class="h-4 w-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                    </svg>
                                    <p class="text-sm font-medium text-gray-500">{{ $tool['nama_kategori'] }}</p>
                                </li>
                            </ul>
                            <div class="mt-auto pt-4 flex items-center justify-between gap-4">
                                <p class="text-lg font-extrabold leading-tight text-gray-900">
                                    Rp. {{ number_format($tool['harga_per_hari'], 0, ',', '.') }}/hari
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-full text-center">
                <button type="button" id="showMoreBtn"
                    class="rounded-lg border border-gray-200 bg-[#73AF6F] px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-[#6AA867] hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-[#6AA867]">Show
                    more</button>
            </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.tool-card');
            const btn = document.getElementById('showMoreBtn');
            let visible = 8;

            btn.addEventListener('click', function() {
                for (let i = visible; i < visible + 8; i++) {
                    if (cards[i]) {
                        cards[i].style.display = 'block';
                    }
                }
                visible += 8;
                if (visible >= cards.length) {
                    btn.style.display = 'none';
                }
            });
        });
    </script>
@endsection
