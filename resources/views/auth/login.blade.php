<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Melly Salon Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-100">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-pink-100 mb-4">
                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.071 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4">
                    </path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Melly Salon</h1>
            <p class="text-sm text-gray-500 mt-1">Silakan masuk ke akun Anda</p>
        </div>

        <form action="/login" method="POST">
            @csrf <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none transition-all"
                    placeholder="admin@mellysalon.com" required autofocus>
            </div>

            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 outline-none transition-all"
                    placeholder="••••••••" required>
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">Ingat saya</label>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-pink-600 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-pink-700 focus:ring-4 focus:ring-pink-200 transition duration-200 shadow-sm">
                Masuk
            </button>
        </form>

    </div>
</body>

</html>