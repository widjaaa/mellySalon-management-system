<!-- SIDEBAR -->
<div class="sidebar">
  <div class="logo">
    <div class="logo-icon">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#9736c4ff" stroke-width="2">
        <path
          d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
      </svg>
    </div>
    <div class="logo-name">Sanggar Wedding Melly Salon</div>
    <div class="logo-sub">Management System</div>
  </div>
  <nav class="nav">
    <div class="ni active" onclick="SalonApp.goPage('dashboard',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7" />
        <rect x="14" y="3" width="7" height="7" />
        <rect x="14" y="14" width="7" height="7" />
        <rect x="3" y="14" width="7" height="7" />
      </svg>
      Dashboard
    </div>
    <div class="ni" onclick="SalonApp.goPage('payment',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="1" y="4" width="22" height="16" rx="2" />
        <line x1="1" y1="10" x2="23" y2="10" />
      </svg>
      Pembayaran
    </div>
    <div class="ni" onclick="SalonApp.goPage('members',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
        <circle cx="9" cy="7" r="4" />
        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
      </svg>
      Data Member
    </div>
    <div class="ni" onclick="SalonApp.goPage('services',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
      </svg>
      Kelola Layanan
    </div>
    <div class="ni" onclick="SalonApp.goPage('report',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="20" x2="18" y2="10" />
        <line x1="12" y1="20" x2="12" y2="4" />
        <line x1="6" y1="20" x2="6" y2="14" />
      </svg>
      Laporan
    </div>
    <div class="ni" onclick="SalonApp.goPage('history',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10" />
        <polyline points="12 6 12 12 16 14" />
      </svg>
      Riwayat
    </div>
  </nav>
  <div class="side-bot">
    <div class="av">SA</div>
    <div>
      <div style="font-size:11px;font-weight:500">Siti Aminah</div>
      <div style="font-size:10px;color:var(--text3)">Admin</div>
    </div>
  </div>
</div>