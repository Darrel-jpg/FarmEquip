<nav class="bg-[#73AF6F] fixed w-full z-50 top-0 start-0 border-b border-default">
  <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <span class="self-center text-xl text-heading font-bold whitespace-nowrap">FarmEquip</span>
    </a>
    <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-[#89C484] hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary" aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-[#6AA867] md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-[#73AF6F]">
        <li>
            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
        </li>
        <li>
            <x-nav-link href="/tools" :active="request()->is('tools')">Farm Tools</x-nav-link>
        </li>
      </ul>
    </div>
  </div>
</nav>
