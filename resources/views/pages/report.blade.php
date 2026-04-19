<div class="page" id="page-report">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div class="flex flex-wrap gap-2">
      <button class="report-tab active px-4 py-2 text-xs font-bold rounded-full border transition-all cursor-pointer" onclick="SalonApp.setReportPeriod('harian',this)">Harian</button>
      <button class="report-tab px-4 py-2 text-xs font-bold rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-all cursor-pointer" onclick="SalonApp.setReportPeriod('mingguan',this)">Mingguan</button>
      <button class="report-tab px-4 py-2 text-xs font-bold rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-all cursor-pointer" onclick="SalonApp.setReportPeriod('bulanan',this)">Bulanan</button>
    </div>
    <div class="flex gap-2">
      <button class="px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold hover:bg-emerald-100 transition-colors flex items-center gap-1.5" onclick="SalonApp.exportExcel()">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Ekspor Excel
      </button>
      <button class="px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-bold hover:bg-blue-100 transition-colors flex items-center gap-1.5" onclick="SalonApp.printReport()">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Cetak
      </button>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6" id="rep-summary">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
      <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Total Transaksi</div>
      <div class="text-2xl font-bold text-gray-800" id="rep-total-trx">0x</div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
      <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Total Pendapatan</div>
      <div class="text-2xl font-bold text-brand-purple" id="rep-total-rev">Rp 0</div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
      <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Rata-rata Transaksi</div>
      <div class="text-2xl font-bold text-gray-800" id="rep-avg">Rp 0</div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
      <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Transaksi Member</div>
      <div class="text-2xl font-bold text-emerald-600" id="rep-member-trx">0x</div>
    </div>
  </div>

  <!-- Payment Method Breakdown -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6" id="payment-breakdown">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center gap-4">
      <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-2xl">💵</div>
      <div>
        <div class="text-xs text-gray-500 font-semibold">Tunai</div>
        <div class="text-lg font-bold text-gray-800" id="pm-cash">Rp 0</div>
        <div class="text-xs text-gray-400" id="pm-cash-count">0 transaksi</div>
      </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center gap-4">
      <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-2xl">📱</div>
      <div>
        <div class="text-xs text-gray-500 font-semibold">QRIS</div>
        <div class="text-lg font-bold text-gray-800" id="pm-qris">Rp 0</div>
        <div class="text-xs text-gray-400" id="pm-qris-count">0 transaksi</div>
      </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center gap-4">
      <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-2xl">🏦</div>
      <div>
        <div class="text-xs text-gray-500 font-semibold">Transfer</div>
        <div class="text-lg font-bold text-gray-800" id="pm-transfer">Rp 0</div>
        <div class="text-xs text-gray-400" id="pm-transfer-count">0 transaksi</div>
      </div>
    </div>
  </div>

  <!-- Transaction Table -->
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
      <h3 class="font-bold text-gray-800" id="rep-title">Laporan Harian</h3>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="bg-gray-50">
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan</th>
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Layanan</th>
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Metode</th>
            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Member</th>
            <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
          </tr>
        </thead>
        <tbody id="rep-body" class="divide-y divide-gray-100">
          <tr>
            <td colspan="6" class="text-center py-12 text-gray-400 text-sm">Belum ada data transaksi.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
