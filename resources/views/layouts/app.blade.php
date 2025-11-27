<!DOCTYPE html>
<html lang="en" class="font-sans h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Sans:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title')</title>
</head>

<body class="flex flex-col min-h-screen">
    <x-navbar></x-navbar>
    <main class="grow pt-10 px-4 py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>

</html>