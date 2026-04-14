<div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10 w-full shadow-sm backdrop-blur-md bg-white/90">
    <div class="text-xl font-serif font-bold text-gray-800 tracking-tight" id="pg-title">Dashboard</div>
    <div class="flex items-center gap-4">
        <span class="px-4 py-1.5 bg-brand-purple-light text-brand-purple-dark text-xs font-semibold rounded-full shadow-inner" id="date-chip"></span>
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-purple to-brand-purple-dark text-white flex items-center justify-center text-sm font-bold shadow-md relative group cursor-pointer border-2 border-white ring-2 ring-gray-100">
            A
            
            <!-- Perbaikan UI: Dropdown Profile + Logout Modal -->
            <div class="hidden group-hover:block absolute right-0 top-12 w-56 bg-white border border-gray-100 shadow-xl rounded-2xl p-2 z-50">
                <div class="px-4 py-3 border-b border-gray-50">
                    <div class="text-sm font-bold text-gray-800">Admin Melly Salon</div>
                    <div class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->email ?? 'admin@mellysalon.com' }}</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 rounded-xl transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
