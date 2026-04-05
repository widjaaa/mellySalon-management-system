<!-- ===== MODAL LAYANAN ===== -->
<div class="modal-bg hidden" id="svc-modal">
  <div class="modal">
    <div class="modal-title" id="svc-modal-title">Tambah Layanan Baru</div>
    <div class="form-row"><div class="fl">Nama Layanan *</div><input type="text" id="f-name" placeholder="cth: Creambath, Smoothing..."></div>
    <div class="form-row"><div class="fl">Kategori *</div>
      <select id="f-cat">
        <option value="">-- Pilih Kategori --</option>
        <option value="Rambut">Rambut</option>
        <option value="Wajah">Wajah</option>
        <option value="Kuku">Kuku</option>
        <option value="Tubuh">Tubuh</option>
        <option value="Paket">Paket</option>
        <option value="Lainnya">Lainnya</option>
      </select>
    </div>
    <div class="g2">
      <div class="form-row"><div class="fl">Harga (Rp) *</div><input type="number" id="f-price" placeholder="0" min="0"></div>
      <div class="form-row"><div class="fl">Durasi (menit)</div><input type="number" id="f-dur" placeholder="60" min="5"></div>
    </div>
    <div class="form-row"><div class="fl">Deskripsi</div><textarea id="f-desc" placeholder="Deskripsi singkat layanan..."></textarea></div>
    <div class="modal-actions">
      <button class="btn-out" onclick="closeSvcModal()">Batal</button>
      <button class="btn-pri" onclick="saveSvc()">Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL HAPUS LAYANAN -->
<div class="modal-bg hidden" id="del-modal">
  <div class="modal" style="width:320px">
    <div class="modal-title">Hapus Layanan?</div>
    <div style="font-size:12.5px;color:var(--text2);margin-bottom:1rem">Layanan <strong id="del-name"></strong> akan dihapus. Lanjutkan?</div>
    <div class="modal-actions">
      <button class="btn-out" onclick="closeDelModal()">Batal</button>
      <button class="btn-del-sm" style="padding:8px 14px" onclick="confirmDel()">Hapus</button>
    </div>
  </div>
</div>

<!-- MODAL MEMBER -->
<div class="modal-bg hidden" id="mem-modal">
  <div class="modal">
    <div class="modal-title" id="mem-modal-title">Tambah Member Baru</div>
    <div class="g2">
      <div class="form-row"><div class="fl">Nama Lengkap *</div><input type="text" id="m-name" placeholder="Nama member..."></div>
      <div class="form-row"><div class="fl">No. HP</div><input type="text" id="m-phone" placeholder="08xx..."></div>
    </div>
    <div class="g2">
      <div class="form-row"><div class="fl">Tier</div>
        <select id="m-tier">
          <option value="Bronze">Bronze</option>
          <option value="Silver">Silver</option>
          <option value="Gold">Gold</option>
        </select>
      </div>
      <div class="form-row"><div class="fl">Tanggal Lahir</div><input type="text" id="m-bday" placeholder="cth: 12 Mar"></div>
    </div>
    <div class="modal-actions">
      <button class="btn-out" onclick="closeMemModal()">Batal</button>
      <button class="btn-pri" onclick="saveMember()">Simpan</button>
    </div>
  </div>
</div>
<div id="toast"></div>
