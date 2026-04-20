@php
    $lowStockItems = \App\Models\Inventory::where('stock', '<=', 5)->get();
    $birthdayMembers = \App\Models\Member::whereMonth('bday', date('m'))->whereDay('bday', date('d'))->get();
    
    $notifications = [];
    
    foreach($lowStockItems as $item) {
        $notifications[] = [
            'title' => 'Stok Menipis',
            'message' => "Stok {$item->name} sisa {$item->stock} {$item->unit}.",
            'time' => 'Inventory',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>',
            'color' => 'amber'
        ];
    }
    
    foreach($birthdayMembers as $member) {
        $notifications[] = [
            'title' => 'Ulang Tahun Member',
            'message' => "Hari ini ({$member->bday->format('d M')}) adalah ulang tahun {$member->name}!",
            'time' => 'Member',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path>',
            'color' => 'blue'
        ];
    }
    
    $hasUnread = count($notifications) > 0;
@endphp

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

        <!-- Notifications -->
        <div class="relative flex items-center">
            <button onclick="document.getElementById('notif-dropdown').classList.toggle('hidden'); document.getElementById('admin-dropdown').classList.add('hidden');" class="relative p-2 text-gray-400 hover:text-brand-purple transition-colors rounded-full hover:bg-gray-50 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                @if($hasUnread)
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                @endif
            </button>

            <!-- Notification Dropdown -->
            <div id="notif-dropdown" class="hidden absolute right-0 top-12 w-80 bg-white border border-gray-200 shadow-xl rounded-xl z-50 overflow-hidden">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-700">Notifikasi</span>
                    @if($hasUnread)
                        <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded">{{ count($notifications) }}</span>
                    @endif
                </div>
                
                <div class="max-h-[300px] overflow-y-auto">
                    @forelse($notifications as $notif)
                    <div class="block px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer">
                        <div class="text-xs font-bold text-gray-800 mb-0.5">{{ $notif['title'] }}</div>
                        <div class="text-xs text-gray-600">{{ $notif['message'] }}</div>
                    </div>
                    @empty
                    <div class="px-4 py-6 text-center text-sm text-gray-500">
                        Tidak ada notifikasi baru.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="relative">
            <div onclick="document.getElementById('admin-dropdown').classList.toggle('hidden'); document.getElementById('notif-dropdown').classList.add('hidden');" class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-purple to-brand-purple-dark text-white flex items-center justify-center text-sm font-bold shadow-md cursor-pointer border-2 border-white ring-2 ring-gray-100 hover:ring-brand-purple/50 transition-all">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=9736c4&color=fff" class="w-full h-full rounded-full object-cover" alt="Admin" />
            </div>

            <div id="admin-dropdown" class="hidden absolute right-0 top-12 w-56 bg-white border border-gray-100 shadow-2xl rounded-2xl p-2 z-50 transform origin-top-right transition-all">
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