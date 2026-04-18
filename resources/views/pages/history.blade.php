<div class="page" id="page-history">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
      <h2 class="text-lg font-bold text-gray-800">Riwayat Transaksi</h2>
      <p class="text-sm text-gray-500 mt-0.5" id="hist-count">Memuat data...</p>
    </div>
  </div>

  <!-- Search & Filter Bar -->
  <div class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="relative flex-1">
      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
      </div>
      <input type="text" id="hist-search" placeholder="Cari nama pelanggan atau no. invoice..."
        class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all placeholder:text-gray-400"
        oninput="SalonApp.searchTransactionHistory()">
    </div>
    <div class="flex gap-2">
      <button class="hist-status-btn active px-4 py-2 text-xs font-bold rounded-full border transition-all cursor-pointer" onclick="SalonApp.filterTransactionStatus('all',this)">Semua</button>
      <button class="hist-status-btn px-4 py-2 text-xs font-bold rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-all cursor-pointer" onclick="SalonApp.filterTransactionStatus('completed',this)">
        <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 mr-1"></span>Selesai
      </button>
      <button class="hist-status-btn px-4 py-2 text-xs font-bold rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-all cursor-pointer" onclick="SalonApp.filterTransactionStatus('voided',this)">
        <span class="inline-block w-2 h-2 rounded-full bg-red-400 mr-1"></span>Dibatalkan
      </button>
    </div>
  </div>

  <!-- Transaction History Table -->
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="bg-gray-50">
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice</th>
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan</th>
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Layanan</th>
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Metode</th>
            <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
            <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
            <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody id="hist-list" class="divide-y divide-gray-100">
          <tr>
            <td colspan="8" class="text-center py-12 text-gray-400 text-sm">Memuat riwayat transaksi...</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="hidden px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/50" id="hist-pagination">
      <div class="text-xs text-gray-500 font-medium" id="hist-page-info">Menampilkan 0 dari 0 transaksi</div>
      <div class="flex items-center gap-2">
        <button class="px-3 py-1.5 text-xs font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors" id="hist-prev" onclick="SalonApp.histPrevPage()" disabled>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <span class="text-xs font-bold text-gray-700 min-w-[60px] text-center" id="hist-page-num">1 / 1</span>
        <button class="px-3 py-1.5 text-xs font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors" id="hist-next" onclick="SalonApp.histNextPage()" disabled>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
      </div>
    </div>
  </div>
</div>
