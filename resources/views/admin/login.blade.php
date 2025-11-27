<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#73AF6F] flex justify-center items-center h-screen">

    <div class="bg-white p-6 rounded-2xl shadow-xl w-80">
        <h2 class="text-xl font-bold mb-4 text-center">Admin Login</h2>

        @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-3 text-sm text-center">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-3">
            @csrf
            <input type="text" name="username" placeholder="Username"
                class="w-full border p-2 rounded-lg focus:outline-green-600">

            <input type="password" name="password" placeholder="Password"
                class="w-full border p-2 rounded-lg focus:outline-green-600">

            <button type="submit"
                class="w-full bg-[#73AF6F] text-white py-2 rounded-lg hover:brightness-110 cursor-pointer">
                Login
            </button>
        </form>
    </div>

</body>

</html>