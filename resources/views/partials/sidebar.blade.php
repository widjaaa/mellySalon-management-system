<!-- SIDEBAR -->
<div
  class="w-64 bg-white border-r border-gray-200 flex flex-col flex-shrink-0 relative h-full shadow-sm z-20 transition-all duration-300"
  id="sidebar">

  <!-- Logo -->
  <div
    class="p-6 border-b border-gray-100 flex flex-col items-center justify-center text-center py-8 bg-gradient-to-b from-white to-gray-50">
    <div
      class="w-24 h-24 rounded-2xl flex items-center justify-center mb-2 shadow-sm ring-4 ring-white overflow-hidden bg-white">
      <img src="{{ asset('images/logo_salon.png') }}" class="w-full h-full object-contain" alt="Melly Salon Logo">
    </div>
    <div class="font-serif font-bold text-gray-900 leading-tight text-lg">Melly Salon</div>
    <div class="text-[10px] text-gray-400 font-bold tracking-widest mt-1.5 uppercase">Management System</div>
  </div>

  <!-- Navigation -->
  <nav class="flex-1 py-6 px-4 space-y-1.5 overflow-y-auto">
    <div
      class="ni active w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-[13px] font-medium text-gray-500 cursor-pointer transition-all hover:bg-gray-50 hover:text-gray-900 [&.active]:bg-brand-purple [&.active]:text-white shadow-sm [&.active]:shadow-brand-purple/30 group"
      onclick="SalonApp.goPage('dashboard',this)">
      <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-purple group-[.active]:text-white transition-colors"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7" rx="1.5" />
        <rect x="14" y="3" width="7" height="7" rx="1.5" />
        <rect x="14" y="14" width="7" height="7" rx="1.5" />
        <rect x="3" y="14" width="7" height="7" rx="1.5" />
      </svg>
      Dashboard
    </div>

    <div
      class="ni w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-[13px] font-medium text-gray-500 cursor-pointer transition-all hover:bg-gray-50 hover:text-gray-900 [&.active]:bg-brand-purple [&.active]:text-white shadow-sm [&.active]:shadow-brand-purple/30 group"
      onclick="SalonApp.goPage('payment',this)">
      <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-purple group-[.active]:text-white transition-colors"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="1" y="4" width="22" height="16" rx="2" />
        <line x1="1" y1="10" x2="23" y2="10" />
      </svg>
      Pembayaran
    </div>

    <div
      class="ni w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-[13px] font-medium text-gray-500 cursor-pointer transition-all hover:bg-gray-50 hover:text-gray-900 [&.active]:bg-brand-purple [&.active]:text-white shadow-sm [&.active]:shadow-brand-purple/30 group"
      onclick="SalonApp.goPage('members',this)">
      <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-purple group-[.active]:text-white transition-colors"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
        <circle cx="9" cy="7" r="4" />
        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
      </svg>
      Data Member
    </div>

    <div
      class="ni w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-[13px] font-medium text-gray-500 cursor-pointer transition-all hover:bg-gray-50 hover:text-gray-900 [&.active]:bg-brand-purple [&.active]:text-white shadow-sm [&.active]:shadow-brand-purple/30 group"
      onclick="SalonApp.goPage('services',this)">
      <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-purple group-[.active]:text-white transition-colors"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
      </svg>
      Kelola Layanan
    </div>

    <div
      class="ni w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-[13px] font-medium text-gray-500 cursor-pointer transition-all hover:bg-gray-50 hover:text-gray-900 [&.active]:bg-emerald-500 [&.active]:text-white shadow-sm [&.active]:shadow-emerald-500/30 group"
      onclick="SalonApp.goPage('inventory',this)">
      <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-500 group-[.active]:text-white transition-colors"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path
          d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
        </path>
        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
        <line x1="12" y1="22.08" x2="12" y2="12"></line>
      </svg>
      Inventaris
    </div>

    <div
      class="ni w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-[13px] font-medium text-gray-500 cursor-pointer transition-all hover:bg-gray-50 hover:text-gray-900 [&.active]:bg-brand-purple [&.active]:text-white shadow-sm [&.active]:shadow-brand-purple/30 group"
      onclick="SalonApp.goPage('report',this)">
      <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-purple group-[.active]:text-white transition-colors"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="20" x2="18" y2="10" />
        <line x1="12" y1="20" x2="12" y2="4" />
        <line x1="6" y1="20" x2="6" y2="14" />
      </svg>
      Laporan
    </div>

    <div
      class="ni w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-[13px] font-medium text-gray-500 cursor-pointer transition-all hover:bg-gray-50 hover:text-gray-900 [&.active]:bg-brand-purple [&.active]:text-white shadow-sm [&.active]:shadow-brand-purple/30 group"
      onclick="SalonApp.goPage('history',this)">
      <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-purple group-[.active]:text-white transition-colors"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10" />
        <polyline points="12 6 12 12 16 14" />
      </svg>
      Riwayat
    </div>
  </nav>

  <!-- Sidebar Footer with Logout -->
  <div class="p-4 border-t border-gray-100 bg-gray-50 space-y-3">
    <div class="flex items-center gap-3 bg-white p-3 rounded-xl shadow-sm border border-gray-100">
      <div
        class="w-10 h-10 rounded-full bg-brand-gold-light text-brand-gold font-bold flex items-center justify-center text-sm ring-2 ring-white">
        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
      </div>
      <div class="flex-1 min-w-0">
        <div class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->name ?? 'Admin' }}</div>
        <div class="text-[10px] uppercase tracking-wider text-brand-purple font-semibold mt-0.5">Administrator</div>
      </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit"
        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors border border-red-100">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        Keluar
      </button>
    </form>
  </div>

</div>