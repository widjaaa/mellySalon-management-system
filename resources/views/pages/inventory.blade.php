<div class="page" id="page-inventory">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
      <h2 class="text-lg font-bold text-gray-800">Sistem Inventaris Stok</h2>
      <p class="text-sm text-gray-500 mt-0.5">Pantau ketersediaan barang konsumsi salon Anda</p>
    </div>
    <button class="px-5 py-2.5 text-sm font-bold text-white bg-emerald-500 hover:bg-emerald-600 rounded-xl transition-colors shadow-md shadow-emerald-500/20 flex items-center gap-2" onclick="SalonApp.openInventoryModal()">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
      Tambah Barang
    </button>
  </div>

  <div id="inv-low-alert" class="hidden mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-4">
    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
    </div>
    <div>
      <h4 class="text-sm font-bold text-red-800">Peringatan Stok Menipis!</h4>
      <p class="text-xs text-red-600 mt-1">Beberapa barang hampir atau sudah habis. Segera lakukan pemesanan ulang untuk:</p>
      <ul id="inv-low-list" class="mt-2 text-xs text-red-700 font-semibold list-disc pl-5">
        <!-- Low stock list rendered here -->
      </ul>
    </div>
  </div>

  <!-- Search & Filter -->
  <div class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="relative flex-1">
      <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
      </div>
      <input type="text" id="inv-search" placeholder="Cari nama barang..."
        class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder:text-gray-400"
        oninput="SalonApp.searchInventory()">
    </div>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="bg-gray-50 border-b border-gray-100">
            <th class="text-left px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nama Barang</th>
            <th class="text-center px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Satuan</th>
            <th class="text-center px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Sisa Stok</th>
            <th class="text-center px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider w-40">Penyesuaian Cepat</th>
            <th class="text-right px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody id="inv-list" class="divide-y divide-gray-100">
          <tr>
            <td colspan="5" class="text-center py-12 text-gray-400 text-sm">Memuat data stok...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
