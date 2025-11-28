<nav class="bg-[#73AF6F] fixed w-full z-20 top-0 start-0 border-b border-default">
    <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-xl text-heading font-bold whitespace-nowrap">FarmEquip</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-[#73AF6F]">
                <li>
                    <x-nav-link href="/admin/dashboard" :active="request()->is('admin/dashboard')">Home</x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{ route('admin.tools') }}" :active="request()->is('admin/tools')">
                        Farm Tools
                    </x-nav-link>
                </li>
                <!-- Dropdown menu -->
                <li>
                    <button id="dropdownNvbarButton" data-dropdown-toggle="dropdownNavbar"
                        class="flex items-center justify-between w-full py-2 px-3 rounded font-semibold md:w-auto hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:p-0 
        {{ Request::is('tools*') ? 'text-heading' : 'text-white md:hover:text-heading' }} ">
                        Management
                        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 9-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="dropdownNavbar"
                        class="z-10 hidden w-44 my-4 list-none divide-y rounded-lg shadow-sm bg-[#73AF6F] divide-[#73AF6F]">
                        <ul class="py-2 text-sm text-white font-medium" aria-labelledby="dropdownNvbarButton">
                            <li>
                                <a href="{{ route('admin.tools.create') }}"
                                    class="inline-flex items-center w-full p-2 hover:bg-[#73AF6F]">
                                    Create Tools
                                </a>
                            </li>
                            <li>
                                <!-- Karena edit butuh {id}, ini biasanya halaman list tools -->
                                <a href="{{ route('admin.tools') }}"
                                    class="inline-flex items-center w-full p-2 hover:bg-[#73AF6F]">
                                    Manage Tools
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <x-nav-link href="{{ route('admin.logout') }}">
                        Logout
                    </x-nav-link>
                </li>
                {{-- <li>
          <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">About</a>
        </li> --}}
            </ul>
        </div>
    </div>
</nav>