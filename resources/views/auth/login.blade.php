<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Melly Salon Management</title>
    <meta name="description" content="Sistem Manajemen Salon Kecantikan Melly Salon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-950 via-purple-900 to-purple-800 relative overflow-hidden">
    {{-- Decorative background elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-pink-500/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-purple/10 rounded-full blur-3xl"></div>
    </div>

    {{-- Login Card --}}
    <div class="relative z-10 w-full max-w-md mx-4">
        {{-- Glassmorphism card --}}
        <div class="bg-white/10 backdrop-blur-2xl border border-white/20 rounded-3xl shadow-2xl p-8 md:p-10">

            {{-- Logo & Branding --}}
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg border border-white/30">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" class="drop-shadow-lg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                </div>
                <h1 class="font-serif text-3xl font-bold text-white tracking-tight mb-1">Melly Salon</h1>
                <p class="text-purple-200 text-sm font-medium tracking-wider uppercase">Sistem Manajemen</p>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-400/30 rounded-xl p-4 mb-6 backdrop-blur-sm">
                    <div class="flex items-center gap-2 text-red-200 text-sm font-medium">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $errors->first('email') }}
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="bg-amber-500/20 border border-amber-400/30 rounded-xl p-4 mb-6 backdrop-blur-sm">
                    <div class="flex items-center gap-2 text-amber-200 text-sm font-medium">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="/login" class="space-y-5" id="login-form">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-purple-200 uppercase tracking-wider mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="admin@mellysalon.com"
                            required
                            autofocus
                            class="w-full bg-white/10 border border-white/20 text-white placeholder-purple-300/60 rounded-xl pl-12 pr-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-white/40 focus:border-white/40 transition-all backdrop-blur-sm"
                        >
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-purple-200 uppercase tracking-wider mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full bg-white/10 border border-white/20 text-white placeholder-purple-300/60 rounded-xl pl-12 pr-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-white/40 focus:border-white/40 transition-all backdrop-blur-sm"
                        >
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/30 bg-white/10 text-brand-purple focus:ring-white/30 focus:ring-offset-0">
                        <span class="text-sm text-purple-200 group-hover:text-white transition-colors">Ingat saya</span>
                    </label>
                </div>

                <button
                    type="submit"
                    id="login-btn"
                    class="w-full bg-white text-purple-900 font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white/50 text-sm tracking-wide uppercase"
                >
                    Masuk ke Dashboard
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-8 pt-6 border-t border-white/10 text-center">
                <p class="text-purple-300/60 text-xs">
                    &copy; {{ date('Y') }} Melly Salon Management System
                </p>
            </div>
        </div>
    </div>
</body>

</html>
