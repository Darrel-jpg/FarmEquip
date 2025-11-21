<!DOCTYPE html>
<html lang="en" class="font-sans h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Sans:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title')</title>
</head>

<body class="flex flex-col min-h-screen">
    <x-navbar></x-navbar>

    {{-- <x-header>@yield('header')</x-header> --}}

    <!-- Konten Utama -->
    <main class="grow px-4 py-6 pt-20 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>

</html>