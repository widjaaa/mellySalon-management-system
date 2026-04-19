<!-- ===== MODAL LAYANAN ===== -->
<div class="modal-bg hidden" id="svc-modal">
  <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-[200] p-4" onclick="if(event.target===this)SalonApp.closeServiceModal()">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl animate-modal-in">
      <div class="flex items-center justify-between mb-5">
        <h3 class="text-lg font-bold text-gray-800" id="svc-modal-title">Tambah Layanan Baru</h3>
        <button onclick="SalonApp.closeServiceModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>

      <div class="space-y-4">
        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Layanan *</label>
          <input type="text" id="f-name" placeholder="cth: Creambath, Smoothing..." class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all placeholder:text-gray-400">
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kategori *</label>
          <select id="f-cat" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all">
            <option value="">-- Pilih Kategori --</option>
            <option value="Rambut">Rambut</option>
            <option value="Wajah">Wajah</option>
            <option value="Kuku">Kuku</option>
            <option value="Tubuh">Tubuh</option>
            <option value="Paket">Paket</option>
            <option value="Lainnya">Lainnya</option>
          </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Harga (Rp) *</label>
            <input type="number" id="f-price" placeholder="0" min="0" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all placeholder:text-gray-400">
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Durasi (menit)</label>
            <input type="number" id="f-dur" placeholder="60" min="5" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all placeholder:text-gray-400">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
          <textarea id="f-desc" placeholder="Deskripsi singkat layanan..." rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all placeholder:text-gray-400 resize-none"></textarea>
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-6">
        <button class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors" onclick="SalonApp.closeServiceModal()">Batal</button>
        <button class="px-5 py-2.5 text-sm font-bold text-white bg-brand-purple hover:bg-brand-purple-dark rounded-xl transition-colors shadow-md shadow-brand-purple/20" onclick="SalonApp.saveService()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL HAPUS LAYANAN -->
<div class="modal-bg hidden" id="del-modal">
  <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-[200] p-4" onclick="if(event.target===this)SalonApp.closeDeleteModal()">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl animate-modal-in">
      <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
      </div>
      <h3 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Layanan?</h3>
      <p class="text-sm text-gray-500 text-center mb-6">Layanan <strong id="del-name" class="text-gray-800"></strong> akan dihapus permanen. Lanjutkan?</p>
      <div class="flex gap-3">
        <button class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors" onclick="SalonApp.closeDeleteModal()">Batal</button>
        <button class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-md" onclick="SalonApp.confirmDeleteService()">Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL MEMBER -->
<div class="modal-bg hidden" id="mem-modal">
  <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-[200] p-4" onclick="if(event.target===this)SalonApp.closeMemberModal()">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl animate-modal-in">
      <div class="flex items-center justify-between mb-5">
        <h3 class="text-lg font-bold text-gray-800" id="mem-modal-title">Tambah Member Baru</h3>
        <button onclick="SalonApp.closeMemberModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>

      <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
            <input type="text" id="m-name" placeholder="Nama member..." class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all placeholder:text-gray-400">
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">No. HP</label>
            <input type="text" id="m-phone" placeholder="08xx..." class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all placeholder:text-gray-400">
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tier</label>
            <select id="m-tier" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all">
              <option value="Bronze">Bronze</option>
              <option value="Silver">Silver</option>
              <option value="Gold">Gold</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal Lahir</label>
            <input type="date" id="m-bday" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all placeholder:text-gray-400">
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-6">
        <button class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors" onclick="SalonApp.closeMemberModal()">Batal</button>
        <button class="px-5 py-2.5 text-sm font-bold text-white bg-brand-purple hover:bg-brand-purple-dark rounded-xl transition-colors shadow-md shadow-brand-purple/20" onclick="SalonApp.saveMember()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DELETE MEMBER -->
<div class="modal-bg hidden" id="del-mem-modal">
  <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-[200] p-4" onclick="if(event.target===this)SalonApp.closeDeleteMemberModal()">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl animate-modal-in">
      <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
      </div>
      <h3 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Member?</h3>
      <p class="text-sm text-gray-500 text-center mb-6">Member <strong id="del-mem-name" class="text-gray-800"></strong> akan dihapus permanen. Lanjutkan?</p>
      <div class="flex gap-3">
        <button class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors" onclick="SalonApp.closeDeleteMemberModal()">Batal</button>
        <button class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-md" onclick="SalonApp.confirmDeleteMember()">Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL VOID TRANSAKSI -->
<div class="modal-bg hidden" id="void-trx-modal">
  <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-[200] p-4" onclick="if(event.target===this)SalonApp.closeVoidModal()">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl animate-modal-in">
      <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
      </div>
      <h3 class="text-lg font-bold text-gray-800 text-center mb-2">Batalkan Transaksi?</h3>
      <p class="text-sm text-gray-500 text-center mb-2">Transaksi <strong id="void-trx-invoice" class="text-gray-800"></strong> akan dibatalkan.</p>
      <p class="text-xs text-amber-600 text-center mb-6 bg-amber-50 rounded-lg p-2">⚠️ Poin dan data member yang terkait akan dikembalikan.</p>
      <div class="flex gap-3">
        <button class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors" onclick="SalonApp.closeVoidModal()">Batal</button>
        <button class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-colors shadow-md" onclick="SalonApp.confirmVoidTransaction()">Ya, Batalkan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL INVENTARIS (STOK) -->
<div class="modal-bg hidden" id="inv-modal">
  <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-[200] p-4" onclick="if(event.target===this)SalonApp.closeInventoryModal()">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl animate-modal-in">
      <div class="flex items-center justify-between mb-5">
        <h3 class="text-lg font-bold text-gray-800" id="inv-modal-title">Tambah Barang Inventaris</h3>
        <button onclick="SalonApp.closeInventoryModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>

      <div class="space-y-4">
        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Barang *</label>
          <input type="text" id="i-name" placeholder="cth: Shampo Pantene..." class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder:text-gray-400">
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Stok Awal Fisik *</label>
            <input type="number" id="i-stock" placeholder="0" min="0" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder:text-gray-400">
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Satuan *</label>
            <select id="i-unit" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all">
              <option value="Botol">Botol</option>
              <option value="Tube">Tube</option>
              <option value="Pcs">Pcs</option>
              <option value="Sachet">Sachet</option>
              <option value="Pax">Pax</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-6">
        <button class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors" onclick="SalonApp.closeInventoryModal()">Batal</button>
        <button class="px-5 py-2.5 text-sm font-bold text-white bg-emerald-500 hover:bg-emerald-600 rounded-xl transition-colors shadow-md shadow-emerald-500/20" onclick="SalonApp.saveInventory()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL HAPUS INVENTARIS -->
<div class="modal-bg hidden" id="del-inv-modal">
  <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-[200] p-4" onclick="if(event.target===this)SalonApp.closeDeleteInventoryModal()">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl animate-modal-in">
      <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
      </div>
      <h3 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Barang?</h3>
      <p class="text-sm text-gray-500 text-center mb-6">Barang <strong id="del-inv-name" class="text-gray-800"></strong> akan dihapus permanen. Lanjutkan?</p>
      <div class="flex gap-3">
        <button class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors" onclick="SalonApp.closeDeleteInventoryModal()">Batal</button>
        <button class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors shadow-md" onclick="SalonApp.confirmDeleteInventory()">Hapus</button>
      </div>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast" class="fixed bottom-5 right-5 bg-gray-800 text-white px-5 py-3 rounded-xl text-sm font-medium shadow-xl opacity-0 translate-y-2 transition-all duration-300 pointer-events-none z-[999]"></div>
