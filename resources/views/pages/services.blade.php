<div class="page" id="page-services">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
      <h2 class="text-lg font-bold text-gray-800">Kelola Layanan</h2>
      <p class="text-sm text-gray-500 mt-0.5" id="svc-sub">Memuat data...</p>
    </div>
    <button class="bg-gradient-to-r from-brand-purple to-brand-purple-dark text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-brand-purple/20 hover:shadow-lg hover:shadow-brand-purple/30 transform hover:-translate-y-0.5 transition-all text-sm flex items-center gap-2" onclick="SalonApp.openServiceModal()">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
      Tambah Layanan
    </button>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
      <div class="text-2xl font-bold text-gray-800" id="ss-total">0</div>
      <div class="text-xs text-gray-500 font-medium mt-1">Total Layanan</div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
      <div class="text-2xl font-bold text-gray-800" id="ss-cat">0</div>
      <div class="text-xs text-gray-500 font-medium mt-1">Kategori</div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
      <div class="text-2xl font-bold text-brand-purple" id="ss-low">—</div>
      <div class="text-xs text-gray-500 font-medium mt-1">Harga Terendah</div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
      <div class="text-2xl font-bold text-brand-purple" id="ss-high">—</div>
      <div class="text-xs text-gray-500 font-medium mt-1">Harga Tertinggi</div>
    </div>
  </div>

  <!-- Category Filter Tabs -->
  <div class="flex flex-wrap gap-2 mb-6" id="svc-tabs"></div>

  <!-- Services Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="svc-grid"></div>
</div>
