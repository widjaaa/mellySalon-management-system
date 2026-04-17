<div class="bg-white/80 backdrop-blur-xl border-b border-gray-200 px-8 py-4 flex items-center justify-between sticky top-0 z-30 w-full">
    <div class="flex items-center gap-3">
        <button class="w-8 h-8 bg-brand-purple rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-purple/30 md:hidden" onclick="SalonApp.toggleSidebar()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <div class="text-2xl font-serif font-bold text-gray-800 tracking-tight" id="pg-title">Dashboard</div>
    </div>

    <div class="flex items-center gap-5">
        <span class="hidden md:flex items-center px-4 py-1.5 bg-brand-purple-light text-brand-purple-dark text-xs font-bold rounded-full shadow-inner gap-2" id="date-chip">
            <svg class="w-4 h-4 text-brand-purple" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            Hari Ini
        </span>

        <div class="h-8 w-px bg-gray-200 hidden md:block"></div>

        <button class="relative p-2 text-gray-400 hover:text-brand-purple transition-colors rounded-full hover:bg-gray-50 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
        </button>

        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-purple to-brand-purple-dark text-white flex items-center justify-center text-sm font-bold shadow-md relative group cursor-pointer border-2 border-white ring-2 ring-gray-100 hover:ring-brand-purple/50 transition-all">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=9736c4&color=fff" class="w-full h-full rounded-full object-cover" alt="Admin" />

            <div class="hidden group-hover:block absolute right-0 top-12 w-56 bg-white border border-gray-100 shadow-2xl rounded-2xl p-2 z-50 transform origin-top-right transition-all">
                <div class="px-4 py-3 bg-gray-50 rounded-xl mb-1">
                    <div class="text-sm font-bold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="text-xs text-gray-500 mt-0.5">{{ Auth::user()->email ?? '' }}</div>
                </div>
                <div class="px-2 py-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>