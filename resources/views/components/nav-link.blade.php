@props(['active' => false])

<a {{ $attributes }}
    class="{{ $active ? 'md:text-gray-800 bg-gray-800 md:bg-transparent' : 'hover:bg-gray-700 md:hover:bg-transparent md:hover:text-gray-800  hover:text-white border-gray-700' }} block py-2 px-3 text-white rounded-sm md:p-0"
    aria-current="{{ $active ? 'page' : false }}">{{ $slot }}</a>