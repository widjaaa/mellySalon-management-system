<div class="page" id="page-payment">
  <div id="pay-success" class="alert-success">Pembayaran berhasil! Poin telah ditambahkan ke akun member.</div>
  <div class="g2">
    <div class="card">
      <div class="ct">Detail Transaksi</div>
      <div class="form-row">
        <div class="fl">Nama Pelanggan</div>
        <input type="text" id="cust-name" list="members-list" placeholder="Ketik nama atau cari member..."
          oninput="SalonApp.searchMember()">
        <datalist id="members-list"></datalist>
        <div class="hint-member" id="member-hint"></div>
      </div>
      <div class="form-row">
        <div class="fl">Pilih Layanan</div>
        <select id="svc-sel">
          <option value="">-- Pilih Layanan --</option>
        </select>
      </div>
      <button class="btn-out full" style="margin-bottom:10px" onclick="SalonApp.addService()">+ Tambah Layanan</button>
      <div id="order-list"></div>
      <div class="order-total hidden" id="order-subtotal"><span>Subtotal</span><span id="sub-val">Rp 0</span></div>
      <div class="disc-row" id="disc-row"><span>Diskon Member</span><span id="disc-val"></span></div>
      <div class="grand-row" id="grand-row"><span>Total Bayar</span><span id="grand-val" style="color:var(--purple)">Rp
          0</span></div>
    </div>
    <div class="card">
      <div class="ct">Metode Pembayaran</div>
      <div class="pay-methods">
        <div class="pm sel" onclick="SalonApp.selectPaymentMethod(this,'Tunai')">
          <div class="pm-icon">💵</div>Tunai
        </div>
        <div class="pm" onclick="SalonApp.selectPaymentMethod(this,'QRIS')">
          <div class="pm-icon">📱</div>QRIS
        </div>
        <div class="pm" onclick="SalonApp.selectPaymentMethod(this,'Transfer')">
          <div class="pm-icon">🏦</div>Transfer
        </div>
      </div>
      <!-- TUNAI SECTION -->
      <div id="cash-section">
        <div class="form-row">
          <div class="fl">Uang Diterima</div>
          <input type="number" id="cash-in" placeholder="0" oninput="SalonApp.calculateChange()">
          <div class="quick-cash-row">
            <button class="btn-quick-cash" onclick="SalonApp.setCashAmount('pas')">Uang Pas</button>
            <button class="btn-quick-cash" onclick="SalonApp.setCashAmount(50000)">50.000</button>
            <button class="btn-quick-cash" onclick="SalonApp.setCashAmount(100000)">100.000</button>
          </div>
        </div>
        <div class="change-row" id="change-row">
          <div style="display:flex;justify-content:space-between;font-size:12px">
            <span style="color:var(--text2)">Kembalian</span>
            <span id="change-v" style="color:var(--green);font-weight:500">Rp 0</span>
          </div>
        </div>
      </div>

      <!-- QRIS SECTION -->
      <div id="qris-section" style="display:none;text-align:center;padding:1rem 0">
        <div style="font-weight:600;color:var(--purple);font-size:16px;margin-bottom:8px">QRIS Sanggar Melly</div>
        <div style="background:var(--surface);border:1px solid var(--border);padding:10px;display:inline-block;border-radius:var(--radius-lg);margin-bottom:10px;width:100%;max-width:220px;">
          <img src="{{ asset('images/qris.jpeg') }}" alt="QRIS" style="width:100%;height:auto;display:block;border-radius:6px;object-fit:contain;">
        </div>
        <div style="font-size:10.5px;color:var(--text2)">Minta pelanggan scan kode ini dengan aplikasi e-Wallet / M-Banking.</div>
      </div>

      <!-- TRANSFER SECTION -->
      <div id="transfer-section" style="display:none;padding:5px 0 10px">
        <div class="bank-card">
          <div style="font-size:10.5px;color:var(--text3);margin-bottom:2px">BCA - Sanggar Melly Salon</div>
          <div style="display:flex;justify-content:space-between;align-items:center">
            <div style="font-size:16px;font-weight:600;letter-spacing:1px">0123456789</div>
            <button class="btn-copy" onclick="SalonApp.copyAccountNumber('0123456789')">Salin</button>
          </div>
        </div>
        <div class="bank-card">
          <div style="font-size:10.5px;color:var(--text3);margin-bottom:2px">Mandiri - Siti Aminah</div>
          <div style="display:flex;justify-content:space-between;align-items:center">
            <div style="font-size:16px;font-weight:600;letter-spacing:1px">1330001122334</div>
            <button class="btn-copy" onclick="SalonApp.copyAccountNumber('1330001122334')">Salin</button>
          </div>
        </div>
        <div
          style="font-size:10.5px;color:var(--text3);margin-top:10px;background:var(--purple-light);padding:8px;border-radius:var(--radius);color:var(--purple-dark)">
          ℹ Pastikan pembayaran telah masuk sebelum klik proses.</div>
      </div>
      <div class="poin-preview" id="poin-preview"></div>
      <button class="btn-pri full" onclick="SalonApp.processPayment()">Proses Pembayaran</button>
    </div>
  </div>
</div>