<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800">
                Travel Booking
            </h1>

            <p class="text-gray-500 mt-2">
                Admin Login
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}">

            @csrf

            <div class="mb-5">
                <label class="block mb-2 font-medium">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
                    required
                    autofocus
                >

                @error('email')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-6">

                <label class="block mb-2 font-medium">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
                    required
                >

                @error('password')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror

            </div>

            <button
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition">

                Login

            </button>

        </form>

    </div>

</div>

</body>
</html>
