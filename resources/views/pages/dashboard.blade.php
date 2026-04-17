<div class="page active space-y-6 animate-fade-in-up" id="page-dashboard">

  <!-- Stats Row -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    <!-- Stat Card 1: Pendapatan Hari Ini -->
    <div class="bg-gradient-to-br from-brand-purple to-brand-purple-dark rounded-2xl p-6 text-white shadow-lg shadow-brand-purple/20 relative overflow-hidden group">
      <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
      <div class="text-white/80 text-xs font-semibold uppercase tracking-wider mb-2">Pendapatan Hari Ini</div>
      <div class="text-3xl font-bold mb-1 tracking-tight" id="d-rev">Rp 0</div>
      <div class="text-white/70 text-sm flex items-center gap-1.5 mt-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
        <span id="d-rev-info">Dari 0 transaksi</span>
      </div>
    </div>

    <!-- Stat Card 2: Pelanggan Hari Ini -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden">
      <div class="absolute right-0 top-0 w-2 h-full bg-blue-500"></div>
      <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">Pelanggan Hari Ini</div>
      <div class="text-3xl font-bold text-gray-800 mb-1" id="d-cust">0</div>
      <div class="text-gray-400 text-sm mt-2" id="d-cust-info">Belum ada pelanggan</div>
    </div>

    <!-- Stat Card 3: Anggota Aktif -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden">
      <div class="absolute right-0 top-0 w-2 h-full bg-emerald-500"></div>
      <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">Anggota Aktif</div>
      <div class="text-3xl font-bold text-gray-800 mb-1" id="d-members">0</div>
      <div class="text-gray-400 text-sm mt-2">Total member</div>
    </div>

    <!-- Stat Card 4: Poin Diberikan -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden">
      <div class="absolute right-0 top-0 w-2 h-full bg-brand-gold"></div>
      <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">Poin Diberikan</div>
      <div class="text-3xl font-bold text-gray-800 mb-1" id="d-points">0</div>
      <div class="text-gray-400 text-sm mt-2">Hari ini</div>
    </div>

  </div>

  <!-- Main Content Row -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Antrian Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col h-full">
      <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">Antrian Hari Ini</h3>
        <span class="bg-brand-purple-light text-brand-purple-dark text-xs font-bold px-3 py-1 rounded-full">Live</span>
      </div>

      <div class="flex-1" id="queue-list">
        <div class="flex flex-col items-center justify-center py-12 text-center text-gray-400">
          <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          </div>
          <p class="text-sm font-medium text-gray-500">Belum ada antrian hari ini.</p>
          <p class="text-xs mt-1">Tambahkan transaksi baru untuk memulai antrian.</p>
        </div>
      </div>
    </div>

    <!-- Chart & Top Services -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col h-full">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">Performa</h3>
        <button class="text-sm text-brand-purple hover:underline font-medium" onclick="SalonApp.goPage('report', document.querySelectorAll('.ni')[4])">Lihat Laporan</button>
      </div>

      <div class="mb-8">
        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-3">Layanan Terpopuler</h4>
        <div id="popular-services">
          <div class="text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">
            <p class="text-sm text-gray-500 font-medium">Belum ada data layanan.</p>
          </div>
        </div>
      </div>

      <div class="mt-auto">
        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-3">Pendapatan 7 Hari Terakhir</h4>
        <div class="h-28 bg-gray-50 rounded-xl border border-gray-100 flex items-end p-3 gap-1.5" id="rev-chart">
          <div class="flex-1 h-full flex items-center justify-center text-xs text-gray-400">Memuat data...</div>
        </div>
      </div>
    </div>

  </div>

  <!-- Birthday Banner -->
  <div class="bg-gradient-to-r from-brand-gold-light via-white to-white rounded-2xl p-6 shadow-sm border border-brand-gold/20 flex flex-col sm:flex-row items-center gap-4">
    <div class="w-12 h-12 bg-brand-gold/10 rounded-full flex items-center justify-center text-2xl flex-shrink-0 relative">
      🎂
      <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
    </div>
    <div class="flex-1 text-center sm:text-left">
      <h3 class="text-lg font-bold text-gray-800">Member Ulang Tahun Bulan Ini</h3>
      <div class="birthday-row mt-2 flex flex-wrap gap-2" id="birthday-list">
        <p class="text-sm text-gray-600 font-medium">Memuat data...</p>
      </div>
    </div>
  </div>

</div>