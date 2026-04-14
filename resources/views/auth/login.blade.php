<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Melly Salon Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative min-h-screen flex items-center justify-center font-sans antialiased selection:bg-brand-gold selection:text-black">

    <!-- Aesthetic Background with Overlay -->
    <div class="fixed inset-0 z-[-1] bg-brand-purple-dark">
        <img src="{{ asset('images/login-bg.png') }}" alt="Background" class="w-full h-full object-cover opacity-60">
        <!-- Gradients to make it elegant and readable -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900/90 via-brand-purple-dark/80 to-black/90 backdrop-blur-sm"></div>
    </div>

    <!-- Login Container -->
    <div class="w-full max-w-md px-5 sm:px-0 relative z-10 w-full">
        
        <!-- Logo Area -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/5 backdrop-blur-xl shadow-2xl border border-white/20 mb-5 ring-4 ring-brand-purple-light/10">
                <span class="text-brand-gold-mid font-serif font-bold text-4xl">M</span>
            </div>
            <h1 class="text-3xl font-serif font-bold text-white tracking-wide">Melly Salon</h1>
            <p class="text-gray-300 text-sm mt-3 font-light tracking-wide uppercase">Sistem Manajemen Eksekutif</p>
        </div>

        <!-- Glassmorphism Card -->
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.4)] overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-gold via-brand-purple-mid to-brand-gold"></div>
            
            <div class="p-8 sm:p-10">
                
                <h2 class="text-xl font-medium text-white mb-8 text-center tracking-wider">
                    Silakan Masuk
                </h2>

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    @if ($errors->any())
                    <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-xl mb-6">
                        <p class="text-sm text-red-200 text-center font-medium">
                            {{ $errors->first() }}
                        </p>
                    </div>
                    @endif

                    <div>
                        <label for="email" class="block text-xs font-semibold tracking-widest uppercase text-gray-400 mb-2">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-500 group-focus-within:text-brand-gold-mid transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="w-full pl-11 pr-4 py-3.5 bg-black/20 border border-white/10 rounded-xl focus:bg-black/40 focus:border-brand-gold-mid focus:ring-1 focus:ring-brand-gold text-white placeholder-gray-500 outline-none transition-all font-medium"
                                placeholder="admin@example.com" required autofocus>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold tracking-widest uppercase text-gray-400 mb-2">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-500 group-focus-within:text-brand-gold-mid transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" 
                                class="w-full pl-11 pr-4 py-3.5 bg-black/20 border border-white/10 rounded-xl focus:bg-black/40 focus:border-brand-gold-mid focus:ring-1 focus:ring-brand-gold text-white placeholder-gray-500 outline-none transition-all font-medium"
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" 
                                class="h-4 w-4 bg-black/20 border-white/20 rounded focus:ring-brand-gold-mid text-brand-gold cursor-pointer checked:bg-brand-gold">
                            <label for="remember" class="ml-2 block text-sm text-gray-400 cursor-pointer hover:text-gray-200 transition-colors">Ingat sesi saya</label>
                        </div>
                        <a href="#" class="text-sm font-medium text-brand-gold-mid hover:text-white transition-colors">Lupa sandi?</a>
                    </div>

                    <button type="submit" 
                        class="w-full mt-4 bg-gradient-to-r from-brand-gold to-brand-gold-mid text-black font-bold py-4 px-4 rounded-xl shadow-[0_0_15px_rgba(250,199,117,0.4)] hover:shadow-[0_0_25px_rgba(250,199,117,0.6)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex justify-center items-center gap-2 group border border-brand-gold-light/50">
                        <span class="tracking-widest uppercase text-sm">Masuk Sistem</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                    
                </form>
            </div>
            
            <div class="bg-black/40 backdrop-blur-md border-t border-white/5 p-4 text-center">
                <p class="text-xs text-brand-purple-mid tracking-wide">Akses khusus staf internal Melly Salon.</p>
            </div>
        </div>

    </div>

</body>
</html>