<div class="page animate-fade-in-up" id="page-payment">
  <div id="pay-success" class="hidden mb-6 bg-green-50 text-green-700 border border-green-200 p-4 rounded-xl shadow-sm items-center gap-3 font-medium">
    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    Pembayaran berhasil! Poin telah ditambahkan ke akun member.
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Left Column: Transaction Detail -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 h-fit">
      <div class="text-lg font-bold text-gray-800 mb-5 pb-3 border-b border-gray-50 tracking-tight">Detail Transaksi</div>

      <div class="mb-5">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Pelanggan</label>
        <input type="text" id="cust-name" list="members-list" placeholder="Ketik nama atau cari member..."
          class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all placeholder:text-gray-400"
          oninput="SalonApp.searchMember()">
        <datalist id="members-list"></datalist>
        <div class="text-xs font-semibold mt-2 text-brand-purple hidden" id="member-hint"></div>
      </div>

      <div class="mb-5">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Layanan</label>
        <select id="svc-sel" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all appearance-none cursor-pointer">
          <option value="">-- Pilih Layanan --</option>
        </select>
      </div>

      <button class="w-full border-2 border-dashed border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:border-brand-purple hover:text-brand-purple hover:bg-brand-purple-light transition-all mb-6 focus:outline-none text-sm group flex items-center justify-center gap-2" onclick="SalonApp.addService()">
        <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Layanan
      </button>

      <div id="order-list" class="space-y-2 mb-6"></div>

      <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 space-y-2">
        <div class="hidden justify-between items-center text-sm font-semibold text-gray-600" id="order-subtotal">
          <span>Subtotal</span><span id="sub-val">Rp 0</span>
        </div>
        <div class="hidden justify-between items-center text-sm font-bold text-gray-800 border-b border-gray-200 pb-2" id="disc-row">
          <span>Diskon Member</span><span id="disc-val" class="text-green-600"></span>
        </div>
        <div class="flex justify-between items-center" id="grand-row">
          <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Total Bayar</span>
          <span id="grand-val" class="text-2xl font-black text-brand-purple tracking-tight">Rp 0</span>
        </div>
      </div>
    </div>

    <!-- Right Column: Payment Method -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 h-fit">
      <div class="text-lg font-bold text-gray-800 mb-5 pb-3 border-b border-gray-50 tracking-tight">Metode Pembayaran</div>

      <div class="grid grid-cols-3 gap-3 mb-8">
        <div class="pm sel border border-brand-purple bg-brand-purple-light text-brand-purple-dark text-center py-4 rounded-xl cursor-pointer font-bold transition-all shadow-inner relative" onclick="SalonApp.selectPaymentMethod(this,'Tunai')">
          <div class="text-2xl mb-1 pb-1">💵</div>
          <div class="text-xs uppercase tracking-wider">Tunai</div>
        </div>
        <div class="pm border border-gray-200 bg-white text-gray-600 text-center py-4 rounded-xl cursor-pointer font-semibold hover:border-gray-300 hover:bg-gray-50 transition-all relative" onclick="SalonApp.selectPaymentMethod(this,'QRIS')">
          <div class="text-2xl mb-1 pb-1">📱</div>
          <div class="text-xs uppercase tracking-wider">QRIS</div>
        </div>
        <div class="pm border border-gray-200 bg-white text-gray-600 text-center py-4 rounded-xl cursor-pointer font-semibold hover:border-gray-300 hover:bg-gray-50 transition-all relative" onclick="SalonApp.selectPaymentMethod(this,'Transfer')">
          <div class="text-2xl mb-1 pb-1">🏦</div>
          <div class="text-xs uppercase tracking-wider">Transfer</div>
        </div>
      </div>

      <!-- TUNAI SECTION -->
      <div id="cash-section" class="mb-8">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Uang Diterima</label>
        <div class="relative mb-3">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <span class="text-gray-400 font-bold">Rp</span>
          </div>
          <input type="number" id="cash-in" placeholder="0" class="w-full bg-gray-50 border border-gray-200 text-gray-800 font-bold text-lg rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand-purple/50 focus:border-brand-purple transition-all" oninput="SalonApp.calculateChange()">
        </div>

        <div class="flex gap-2 mb-5">
          <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-3 rounded-lg text-xs transition-colors" onclick="SalonApp.setCashAmount('pas')">Uang Pas</button>
          <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-3 rounded-lg text-xs transition-colors" onclick="SalonApp.setCashAmount(50000)">50.000</button>
          <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-3 rounded-lg text-xs transition-colors" onclick="SalonApp.setCashAmount(100000)">100.000</button>
        </div>

        <div class="hidden bg-green-50 border border-green-100 rounded-xl p-4 justify-between items-center" id="change-row">
          <span class="text-xs font-bold text-green-700 uppercase tracking-wide">Kembalian</span>
          <span id="change-v" class="text-lg font-black text-green-600 tracking-tight">Rp 0</span>
        </div>
      </div>

      <!-- QRIS SECTION -->
      <div id="qris-section" class="hidden mb-8 text-center bg-gray-50 rounded-2xl p-6 border border-gray-100">
        <div class="font-bold text-brand-purple text-lg mb-4">QRIS Melly Salon</div>
        <div class="bg-white border-2 border-brand-purple-light p-3 inline-block rounded-2xl mb-4 shadow-sm">
          <img src="{{ asset('images/qris.jpeg') }}" class="w-48 h-auto block rounded-xl object-contain shadow-sm bg-white" alt="QRIS" onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'w-48 h-48 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-sm\'>QR Code</div>'">
        </div>
        <div class="text-xs font-medium text-gray-500 max-w-[200px] mx-auto leading-relaxed">Minta pelanggan scan kode ini dengan aplikasi e-Wallet atau M-Banking mereka.</div>
      </div>

      <!-- TRANSFER SECTION -->
      <div id="transfer-section" class="hidden mb-8 space-y-3">
        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex flex-col gap-1">
          <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">BCA — Melly Salon</div>
          <div class="flex justify-between items-center">
            <div class="font-mono text-lg font-bold tracking-widest text-gray-800">0123456789</div>
            <button class="text-xs font-bold bg-white border border-gray-200 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-50 hover:text-brand-purple hover:border-brand-purple transition-all shadow-sm" onclick="SalonApp.copyAccountNumber('0123456789')">Salin</button>
          </div>
        </div>

        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex flex-col gap-1">
          <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Mandiri — Siti Aminah</div>
          <div class="flex justify-between items-center">
            <div class="font-mono text-lg font-bold tracking-widest text-gray-800">1330001122334</div>
            <button class="text-xs font-bold bg-white border border-gray-200 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-50 hover:text-brand-purple hover:border-brand-purple transition-all shadow-sm" onclick="SalonApp.copyAccountNumber('1330001122334')">Salin</button>
          </div>
        </div>

        <div class="flex items-start gap-2 bg-brand-gold-light/50 border border-brand-gold/20 p-3 rounded-lg mt-4">
          <svg class="w-4 h-4 text-brand-gold flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          <span class="text-xs font-medium text-gray-700 leading-relaxed">Pastikan pembayaran telah masuk ke rekening sebelum klik tombol Proses Pembayaran.</span>
        </div>
      </div>

      <div class="text-xs font-medium text-brand-purple bg-brand-purple-light px-4 py-2 rounded-lg mb-6 hidden" id="poin-preview"></div>

      <button class="w-full bg-gradient-to-r from-brand-purple to-brand-purple-dark text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-brand-purple/30 hover:shadow-xl hover:shadow-brand-purple/40 transform hover:-translate-y-0.5 transition-all focus:outline-none flex justify-center items-center gap-2" onclick="SalonApp.processPayment()">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Proses Pembayaran
      </button>
    </div>
  </div>
</div>