<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Salon Cantik — Sistem Manajemen</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --pink:#D4537E;--pink-light:#FBEAF0;--pink-mid:#F4C0D1;--pink-dark:#993556;
  --gold:#BA7517;--gold-light:#FAEEDA;--gold-mid:#FAC775;
  --green:#3B6D11;--green-light:#EAF3DE;--green-mid:#C0DD97;
  --blue:#185FA5;--blue-light:#E6F1FB;--blue-mid:#B5D4F4;
  --red:#A32D2D;--red-light:#FCEBEB;--red-mid:#F09595;
  --gray:#5F5E5A;--gray-light:#F1EFE8;--gray-mid:#D3D1C7;
  --coral:#993C1D;--coral-light:#FAECE7;--coral-mid:#F5C4B3;
  --bg:#F7F5F2;--surface:#FFFFFF;--border:#E8E4DF;--border-md:#D0CBC4;
  --text:#1A1917;--text2:#5F5E5A;--text3:#9A9690;
  --radius:10px;--radius-lg:14px;--radius-xl:18px;
  --shadow:0 1px 3px rgba(0,0,0,.07),0 4px 12px rgba(0,0,0,.04);
}
html,body{height:100%;font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);font-size:14px}

/* LAYOUT */
.app{display:flex;height:100vh;overflow:hidden}
.sidebar{width:220px;background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;flex-shrink:0}
.main{flex:1;display:flex;flex-direction:column;overflow:hidden}
.topbar{background:var(--surface);border-bottom:1px solid var(--border);padding:.85rem 1.4rem;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.content{flex:1;overflow-y:auto;padding:1.25rem 1.4rem}

/* SIDEBAR */
.logo{padding:1.1rem 1.2rem 1rem;border-bottom:1px solid var(--border)}
.logo-icon{width:34px;height:34px;border-radius:50%;background:var(--pink-light);display:flex;align-items:center;justify-content:center;margin-bottom:8px}
.logo-name{font-family:'Playfair Display',serif;font-size:16px;color:var(--text)}
.logo-sub{font-size:10px;color:var(--text3);letter-spacing:.04em}
.nav{flex:1;padding:.75rem 0}
.ni{display:flex;align-items:center;gap:9px;padding:8px 1.2rem;font-size:12.5px;color:var(--text2);cursor:pointer;border-left:2px solid transparent;transition:all .15s;user-select:none}
.ni:hover{background:#FAF7F5;color:var(--text)}
.ni.active{color:var(--pink);background:var(--pink-light);border-left-color:var(--pink);font-weight:500}
.ni svg{flex-shrink:0;opacity:.65}
.ni.active svg{opacity:1}
.side-bot{padding:.9rem 1.2rem;border-top:1px solid var(--border);display:flex;align-items:center;gap:9px}
.av{width:30px;height:30px;border-radius:50%;background:var(--pink-mid);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:500;color:var(--pink-dark);flex-shrink:0}
.av-lg{width:38px;height:38px;font-size:13px}

/* TOPBAR */
.pg-title{font-size:15px;font-weight:500}
.chip{font-size:10px;padding:4px 10px;border-radius:20px;background:var(--pink-light);color:var(--pink-dark);font-weight:500}

/* CARDS */
.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:.9rem 1.1rem}
.ct{font-size:12.5px;font-weight:500;margin-bottom:10px}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
.g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:10px}
.g4{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px;margin-bottom:10px}

/* METRIC */
.mc{background:#FAF7F5;border-radius:var(--radius);padding:13px}
.mc-lbl{font-size:10px;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px}
.mc-val{font-size:21px;font-weight:500}
.mc-sub{font-size:10px;color:var(--green);margin-top:3px}
.mc-sub.neg{color:var(--red)}

/* BADGES/PILLS */
.pill{font-size:10px;padding:2px 7px;border-radius:20px;font-weight:500}
.pill-done{background:var(--green-light);color:var(--green)}
.pill-now{background:var(--pink-light);color:var(--pink-dark)}
.pill-wait{background:var(--gray-light);color:var(--gray)}
.pill-gold{background:var(--gold-light);color:#412402}
.pill-silver{background:var(--gray-light);color:#2C2C2A}
.pill-bronze{background:var(--coral-light);color:#4A1B0C}
.pill-member{background:var(--green-light);color:var(--green)}

/* ROWS */
.row-item{display:flex;align-items:center;gap:8px;padding:7px 0;border-bottom:1px solid var(--border);font-size:12px}
.row-item:last-child{border-bottom:none}

/* BARS */
.bar-wrap{margin-bottom:9px}
.bar-info{display:flex;justify-content:space-between;font-size:11px;color:var(--text2);margin-bottom:3px}
.bar-track{height:5px;background:var(--gray-light);border-radius:10px;overflow:hidden}
.bar-fill{height:100%;border-radius:10px}

/* CHART */
.rev-chart{display:flex;align-items:flex-end;gap:5px;height:85px}
.rc{flex:1;display:flex;flex-direction:column;align-items:center;gap:3px}
.rb-wrap{flex:1;display:flex;align-items:flex-end;width:100%}
.rb{width:100%;border-radius:3px 3px 0 0;background:var(--pink-mid)}
.rb.hi{background:var(--pink)}
.rl{font-size:9px;color:var(--text3)}

/* FORMS */
.form-row{margin-bottom:10px}
.fl{font-size:10.5px;color:var(--text2);margin-bottom:4px}
input[type=text],input[type=number],select,textarea{
  width:100%;padding:8px 10px;font-size:12.5px;font-family:'DM Sans',sans-serif;
  border:1px solid var(--border-md);border-radius:var(--radius);
  background:var(--surface);color:var(--text);outline:none;transition:border-color .15s
}
input:focus,select:focus,textarea:focus{border-color:var(--pink)}
textarea{resize:vertical;min-height:65px;line-height:1.5}

/* BUTTONS */
.btn-pri{padding:9px 18px;background:var(--pink);color:white;border:none;border-radius:var(--radius);font-size:12.5px;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;transition:opacity .15s}
.btn-pri:hover{opacity:.87}
.btn-pri.full{width:100%}
.btn-out{padding:8px 14px;background:transparent;color:var(--text);border:1px solid var(--border-md);border-radius:var(--radius);font-size:12px;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background .15s}
.btn-out:hover{background:#FAF7F5}
.btn-out.full{width:100%}
.btn-del-sm{padding:4px 9px;font-size:11px;border:1px solid var(--red-mid);border-radius:8px;cursor:pointer;background:transparent;color:var(--red);font-family:'DM Sans',sans-serif;transition:background .15s}
.btn-del-sm:hover{background:var(--red-light)}
.btn-edit-sm{padding:4px 9px;font-size:11px;border:1px solid var(--border-md);border-radius:8px;cursor:pointer;background:transparent;color:var(--text2);font-family:'DM Sans',sans-serif;transition:background .15s}
.btn-edit-sm:hover{background:#FAF7F5;color:var(--text)}
.btn-exp{padding:6px 13px;border:1px solid var(--green-mid);border-radius:20px;font-size:11px;cursor:pointer;background:var(--green-light);color:var(--green);font-weight:500;font-family:'DM Sans',sans-serif;transition:opacity .15s}
.btn-exp:hover{opacity:.8}

/* PAYMENT */
.pay-methods{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:10px}
.pm{padding:11px 7px;text-align:center;border:1px solid var(--border);border-radius:var(--radius);cursor:pointer;font-size:11.5px;color:var(--text2);transition:all .15s}
.pm:hover,.pm.sel{border-color:var(--pink);background:var(--pink-light);color:var(--pink-dark);font-weight:500}
.pm-icon{font-size:20px;margin-bottom:4px}
.order-row{display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid var(--border);font-size:12px}
.order-row:last-child{border-bottom:none}
.order-total{display:flex;justify-content:space-between;padding:9px 0 0;font-weight:500;font-size:13px}

/* MEMBER */
.member-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:.85rem 1rem;margin-bottom:9px}
.poin-bar{height:5px;background:var(--gray-light);border-radius:10px;overflow:hidden;margin:6px 0 3px}
.poin-fill{height:100%;border-radius:10px;background:var(--pink)}
.ms{background:#FAF7F5;border-radius:var(--radius);padding:7px;text-align:center}
.ms-val{font-size:14px;font-weight:500}
.ms-lbl{font-size:9px;color:var(--text3)}

/* LAYANAN */
.svc-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:9px;margin-bottom:1rem}
.svc-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:.85rem 1rem;display:flex;flex-direction:column;gap:6px;transition:border-color .15s}
.svc-card:hover{border-color:var(--border-md)}
.svc-cat-pill{font-size:10px;padding:2px 8px;border-radius:20px;font-weight:500;white-space:nowrap}
.svc-price{font-size:14px;font-weight:500;color:var(--pink)}
.svc-dur{font-size:10px;color:var(--text3)}

/* MODAL */
.modal-bg{position:fixed;inset:0;background:rgba(0,0,0,.4);display:flex;align-items:center;justify-content:center;z-index:200}
.modal{background:var(--surface);border-radius:var(--radius-xl);padding:1.3rem;width:400px;max-width:95vw;box-shadow:0 20px 60px rgba(0,0,0,.15)}
.modal-title{font-size:14px;font-weight:500;margin-bottom:1rem}
.modal-actions{display:flex;gap:7px;justify-content:flex-end;margin-top:1rem}

/* REPORT TABLE */
.rep-table{width:100%;font-size:12px;border-collapse:collapse}
.rep-table th{text-align:left;padding:7px 10px;font-size:10px;color:var(--text3);font-weight:500;text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid var(--border)}
.rep-table td{padding:8px 10px;border-bottom:1px solid var(--border);color:var(--text)}
.rep-table tr:last-child td{border-bottom:none}
.rep-table tr:hover td{background:#FAF7F5}

/* TABS / FILTERS */
.tab-row{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:1rem}
.tab{padding:5px 13px;border:1px solid var(--border-md);border-radius:20px;font-size:11.5px;cursor:pointer;color:var(--text2);background:var(--surface);transition:all .15s;font-family:'DM Sans',sans-serif}
.tab:hover{background:#FAF7F5}
.tab.act{background:var(--pink);color:white;border-color:var(--pink)}

/* ALERTS */
.alert-success{background:var(--green-light);border:1px solid var(--green-mid);border-radius:var(--radius);padding:10px 14px;font-size:12px;color:var(--green);margin-bottom:.9rem;display:none}
.alert-success.show{display:block}

/* TOAST */
#toast{position:fixed;bottom:20px;right:20px;background:#2C2C2A;color:white;padding:9px 15px;border-radius:var(--radius);font-size:12px;opacity:0;transition:opacity .3s;pointer-events:none;z-index:999}
#toast.show{opacity:1}

/* MISC */
.sep{height:1px;background:var(--border);margin:10px 0}
.mb1{margin-bottom:.9rem}
.hidden{display:none}
.summary-bar{display:flex;gap:9px;margin-bottom:1rem}
.sm{background:#FAF7F5;border-radius:var(--radius);padding:10px 14px;flex:1}
.sm-val{font-size:17px;font-weight:500}
.sm-lbl{font-size:10px;color:var(--text3);margin-top:2px}
.birthday-row{display:flex;gap:7px;flex-wrap:wrap}
.bday-tag{background:var(--pink-light);border-radius:var(--radius);padding:7px 12px;font-size:11px}

.page{display:none}
.page.active{display:block}

.hint-member{font-size:10px;color:var(--pink);margin-top:3px;display:none}
.disc-row{display:none;flex-direction:row;justify-content:space-between;padding:5px 0;font-size:12px;color:var(--pink)}
.grand-row{display:none;flex-direction:row;justify-content:space-between;padding:8px 0 0;font-weight:500;font-size:13px;border-top:1px solid var(--border);margin-top:4px}
.poin-preview{display:none;background:var(--pink-light);border-radius:var(--radius);padding:8px 10px;font-size:11px;color:var(--pink-dark);margin-bottom:8px}
.change-row{display:none;padding:8px 0;margin-bottom:6px;border-top:1px solid var(--border)}
</style>
</head>
<body>

<div class="app">
<!-- SIDEBAR -->
<div class="sidebar">
  <div class="logo">
    <div class="logo-icon">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#D4537E" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    </div>
    <div class="logo-name">Salon Cantik</div>
    <div class="logo-sub">Beauty Management System</div>
  </div>
  <nav class="nav">
    <div class="ni active" onclick="goPage('dashboard',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </div>
    <div class="ni" onclick="goPage('payment',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
      Pembayaran
    </div>
    <div class="ni" onclick="goPage('members',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Data Member
    </div>
    <div class="ni" onclick="goPage('services',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
      Kelola Layanan
    </div>
    <div class="ni" onclick="goPage('report',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
      Laporan
    </div>
    <div class="ni" onclick="goPage('history',this)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
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

<!-- MAIN -->
<div class="main">
  <div class="topbar">
    <div class="pg-title" id="pg-title">Dashboard</div>
    <div style="display:flex;align-items:center;gap:9px">
      <span class="chip" id="date-chip"></span>
      <div class="av">SA</div>
    </div>
  </div>

  <div class="content">

    <!-- ===== DASHBOARD ===== -->
    <div class="page active" id="page-dashboard">
      <div class="g4">
        <div class="mc"><div class="mc-lbl">Pendapatan Hari Ini</div><div class="mc-val" id="d-rev">Rp 2,4jt</div><div class="mc-sub">+12% dari kemarin</div></div>
        <div class="mc"><div class="mc-lbl">Pelanggan Hari Ini</div><div class="mc-val" id="d-cust">14</div><div class="mc-sub">+3 dari kemarin</div></div>
        <div class="mc"><div class="mc-lbl">Anggota Aktif</div><div class="mc-val">87</div><div class="mc-sub">+5 bulan ini</div></div>
        <div class="mc"><div class="mc-lbl">Poin Diberikan</div><div class="mc-val">1.240</div><div class="mc-sub">Hari ini</div></div>
      </div>
      <div class="g2">
        <div class="card">
          <div class="ct">Antrian Hari Ini</div>
          <div class="row-item"><span style="font-size:10px;color:var(--text3);min-width:36px">09:00</span><span style="flex:1">Rina Dewi</span><span style="font-size:11px;color:var(--text2)">Creambath</span><span class="pill pill-done" style="margin-left:6px">Selesai</span></div>
          <div class="row-item"><span style="font-size:10px;color:var(--text3);min-width:36px">10:30</span><span style="flex:1">Maya Putri</span><span style="font-size:11px;color:var(--text2)">Smoothing</span><span class="pill pill-now" style="margin-left:6px">Berlangsung</span></div>
          <div class="row-item"><span style="font-size:10px;color:var(--text3);min-width:36px">11:00</span><span style="flex:1">Sari Indah</span><span style="font-size:11px;color:var(--text2)">Facial</span><span class="pill pill-wait" style="margin-left:6px">Menunggu</span></div>
          <div class="row-item"><span style="font-size:10px;color:var(--text3);min-width:36px">13:00</span><span style="flex:1">Dita Rahayu</span><span style="font-size:11px;color:var(--text2)">Potong</span><span class="pill pill-wait" style="margin-left:6px">Menunggu</span></div>
        </div>
        <div class="card">
          <div class="ct">Layanan Terpopuler</div>
          <div class="bar-wrap"><div class="bar-info"><span>Potong Rambut</span><span>38%</span></div><div class="bar-track"><div class="bar-fill" style="width:38%;background:var(--pink)"></div></div></div>
          <div class="bar-wrap"><div class="bar-info"><span>Creambath</span><span>27%</span></div><div class="bar-track"><div class="bar-fill" style="width:27%;background:#D85A30"></div></div></div>
          <div class="bar-wrap"><div class="bar-info"><span>Facial</span><span>20%</span></div><div class="bar-track"><div class="bar-fill" style="width:20%;background:#1D9E75"></div></div></div>
          <div class="bar-wrap"><div class="bar-info"><span>Smoothing</span><span>15%</span></div><div class="bar-track"><div class="bar-fill" style="width:15%;background:#378ADD"></div></div></div>
          <div style="margin-top:14px">
            <div class="ct" style="margin-bottom:7px">Pendapatan Minggu Ini</div>
            <div class="rev-chart" id="rev-chart"></div>
          </div>
        </div>
      </div>
      <div class="card mb1">
        <div class="ct">Member Ulang Tahun Bulan Ini 🎂</div>
        <div class="birthday-row">
          <div class="bday-tag"><span style="font-weight:500">Rina Dewi</span> <span style="color:var(--text3)">· 8 Apr · Gold</span></div>
          <div class="bday-tag"><span style="font-weight:500">Anita Sari</span> <span style="color:var(--text3)">· 15 Apr · Silver</span></div>
          <div class="bday-tag"><span style="font-weight:500">Dewi Lestari</span> <span style="color:var(--text3)">· 22 Apr · Bronze</span></div>
        </div>
      </div>
    </div>

    <!-- ===== PEMBAYARAN ===== -->
    <div class="page" id="page-payment">
      <div id="pay-success" class="alert-success">Pembayaran berhasil! Poin telah ditambahkan ke akun member.</div>
      <div class="g2">
        <div class="card">
          <div class="ct">Detail Transaksi</div>
          <div class="form-row">
            <div class="fl">Nama Pelanggan</div>
            <input type="text" id="cust-name" placeholder="Ketik nama atau cari member..." oninput="searchMember()">
            <div class="hint-member" id="member-hint"></div>
          </div>
          <div class="form-row">
            <div class="fl">Pilih Layanan</div>
            <select id="svc-sel"><option value="">-- Pilih Layanan --</option></select>
          </div>
          <button class="btn-out full" style="margin-bottom:10px" onclick="addSvc()">+ Tambah Layanan</button>
          <div id="order-list"></div>
          <div class="order-total hidden" id="order-subtotal"><span>Subtotal</span><span id="sub-val">Rp 0</span></div>
          <div class="disc-row" id="disc-row"><span>Diskon Member</span><span id="disc-val"></span></div>
          <div class="grand-row" id="grand-row"><span>Total Bayar</span><span id="grand-val" style="color:var(--pink)">Rp 0</span></div>
        </div>
        <div class="card">
          <div class="ct">Metode Pembayaran</div>
          <div class="pay-methods">
            <div class="pm sel" onclick="selPay(this,'Tunai')"><div class="pm-icon">💵</div>Tunai</div>
            <div class="pm" onclick="selPay(this,'QRIS')"><div class="pm-icon">📱</div>QRIS</div>
            <div class="pm" onclick="selPay(this,'Transfer')"><div class="pm-icon">🏦</div>Transfer</div>
          </div>
          <div class="form-row" id="cash-row">
            <div class="fl">Uang Diterima</div>
            <input type="number" id="cash-in" placeholder="0" oninput="calcChange()">
          </div>
          <div class="change-row" id="change-row">
            <div style="display:flex;justify-content:space-between;font-size:12px">
              <span style="color:var(--text2)">Kembalian</span>
              <span id="change-v" style="color:var(--green);font-weight:500">Rp 0</span>
            </div>
          </div>
          <div class="poin-preview" id="poin-preview"></div>
          <button class="btn-pri full" onclick="doPayment()">Proses Pembayaran</button>
        </div>
      </div>
    </div>

    <!-- ===== DATA MEMBER ===== -->
    <div class="page" id="page-members">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.9rem">
        <div class="tab-row" style="margin-bottom:0">
          <button class="tab act" onclick="filterMember('all',this)">Semua</button>
          <button class="tab" onclick="filterMember('Gold',this)">Gold</button>
          <button class="tab" onclick="filterMember('Silver',this)">Silver</button>
          <button class="tab" onclick="filterMember('Bronze',this)">Bronze</button>
        </div>
        <button class="btn-pri" onclick="openMemberModal()">+ Tambah Member</button>
      </div>
      <div id="member-list"></div>
    </div>

    <!-- ===== KELOLA LAYANAN ===== -->
    <div class="page" id="page-services">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.9rem">
        <div>
          <div style="font-size:13px;font-weight:500">Kelola Layanan</div>
          <div style="font-size:10px;color:var(--text3);margin-top:2px" id="svc-sub"></div>
        </div>
        <button class="btn-pri" onclick="openSvcModal()">+ Tambah Layanan</button>
      </div>
      <div class="summary-bar">
        <div class="sm"><div class="sm-val" id="ss-total">0</div><div class="sm-lbl">Total Layanan</div></div>
        <div class="sm"><div class="sm-val" id="ss-cat">0</div><div class="sm-lbl">Kategori</div></div>
        <div class="sm"><div class="sm-val" id="ss-low">—</div><div class="sm-lbl">Harga Terendah</div></div>
        <div class="sm"><div class="sm-val" id="ss-high">—</div><div class="sm-lbl">Harga Tertinggi</div></div>
      </div>
      <div class="tab-row" id="svc-tabs"></div>
      <div class="svc-grid" id="svc-grid"></div>
    </div>

    <!-- ===== LAPORAN ===== -->
    <div class="page" id="page-report">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.9rem;flex-wrap:wrap;gap:8px">
        <div class="tab-row" style="margin-bottom:0">
          <button class="tab act" onclick="setReport('harian',this)">Harian</button>
          <button class="tab" onclick="setReport('mingguan',this)">Mingguan</button>
          <button class="tab" onclick="setReport('bulanan',this)">Bulanan</button>
        </div>
        <div style="display:flex;gap:7px">
          <button class="btn-exp" onclick="exportCSV()">⬇ Ekspor CSV</button>
          <button class="btn-exp" onclick="printReport()">🖨 Cetak</button>
        </div>
      </div>
      <div class="g3 mb1" id="rep-summary"></div>
      <div class="card">
        <div class="ct" id="rep-title">Laporan Harian</div>
        <div style="overflow-x:auto">
          <table class="rep-table">
            <thead><tr><th>Waktu</th><th>Pelanggan</th><th>Layanan</th><th>Metode</th><th>Member</th><th style="text-align:right">Total</th></tr></thead>
            <tbody id="rep-body"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ===== RIWAYAT ===== -->
    <div class="page" id="page-history">
      <div class="card">
        <div class="ct">Riwayat Transaksi</div>
        <div id="hist-list">
          <div class="row-item"><span style="font-size:10px;color:var(--text3);min-width:36px">09:00</span><span style="flex:1">Rina Dewi</span><span style="font-size:11px;color:var(--text2)">Creambath + Potong</span><span style="font-size:11px;color:var(--text3);margin:0 7px">Tunai</span><span style="font-weight:500">Rp 165.000</span></div>
          <div class="row-item"><span style="font-size:10px;color:var(--text3);min-width:36px">09:45</span><span style="flex:1">Budi Santoso</span><span style="font-size:11px;color:var(--text2)">Potong Rambut</span><span style="font-size:11px;color:var(--text3);margin:0 7px">QRIS</span><span style="font-weight:500">Rp 45.000</span></div>
          <div class="row-item"><span style="font-size:10px;color:var(--text3);min-width:36px">10:15</span><span style="flex:1">Anita Sari</span><span style="font-size:11px;color:var(--text2)">Facial</span><span style="font-size:11px;color:var(--text3);margin:0 7px">Transfer</span><span style="font-weight:500">Rp 180.000</span></div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>

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

<script>
// ===== DATA =====
const pages=['dashboard','payment','members','services','report','history'];
const navEls=document.querySelectorAll('.ni');
const titles={dashboard:'Dashboard',payment:'Pembayaran',members:'Data Member',services:'Kelola Layanan',report:'Laporan',history:'Riwayat Transaksi'};

let dbServices = @json($services);
let services = dbServices.map(s => ({
  id: s.id,
  name: s.name,
  cat: s.category,
  price: s.price,
  dur: s.duration,
  desc: s.description
}));
// nextSvcId not needed anymore


let members=[
  {id:1,name:'Rina Dewi',initials:'RD',tier:'Gold',poin:2840,total:15,spent:4200000,bday:'8 Apr',phone:'081234567890'},
  {id:2,name:'Maya Putri',initials:'MP',tier:'Gold',poin:1920,total:11,spent:3100000,bday:'20 Jun',phone:'082345678901'},
  {id:3,name:'Anita Sari',initials:'AS',tier:'Silver',poin:940,total:7,spent:1850000,bday:'15 Apr',phone:'083456789012'},
  {id:4,name:'Sari Indah',initials:'SI',tier:'Silver',poin:680,total:5,spent:1200000,bday:'3 Sep',phone:'084567890123'},
  {id:5,name:'Dita Rahayu',initials:'DR',tier:'Bronze',poin:320,total:3,spent:580000,bday:'12 Nov',phone:'085678901234'},
  {id:6,name:'Linda Susanti',initials:'LS',tier:'Bronze',poin:190,total:2,spent:290000,bday:'27 Jan',phone:'086789012345'},
];
let nextMemId=7;

let reportRows=[
  {time:'10:15',name:'Anita Sari',svcs:'Facial',method:'Transfer',isMember:true,total:180000},
  {time:'09:45',name:'Budi Santoso',svcs:'Potong Rambut',method:'QRIS',isMember:false,total:45000},
  {time:'09:00',name:'Rina Dewi',svcs:'Creambath + Potong Rambut',method:'Tunai',isMember:true,total:165000},
];

let orderItems=[];
let payMethod='Tunai';
let grandTotal=0;
let activeSvcCat='Semua';
let editSvcId=null;
let delSvcId=null;

// ===== DATE =====
const now=new Date();
const dayNames=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
const monthNames=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
document.getElementById('date-chip').textContent=`${dayNames[now.getDay()]}, ${now.getDate()} ${monthNames[now.getMonth()]} ${now.getFullYear()}`;

// ===== NAVIGATION =====
function goPage(id,el){
  pages.forEach(p=>document.getElementById('page-'+p).classList.toggle('active',p===id));
  document.getElementById('pg-title').textContent=titles[id];
  navEls.forEach(n=>n.classList.remove('active'));
  if(el)el.classList.add('active');
  if(id==='report')renderReport('harian');
  if(id==='members')renderMembers('all');
  if(id==='services'){activeSvcCat='Semua';renderSvcPage();}
  if(id==='payment')populateSvcSelect();
}

// ===== DASHBOARD CHART =====
(function(){
  const days=['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
  const vals=[320,410,280,520,390,610,440];
  const mx=Math.max(...vals);
  const rc=document.getElementById('rev-chart');
  rc.innerHTML=days.map((d,i)=>`<div class="rc"><div class="rb-wrap"><div class="rb${i===5?' hi':''}" style="height:${Math.round(vals[i]/mx*72)}px"></div></div><div class="rl">${d}</div></div>`).join('');
})();

// ===== PAYMENT =====
const catColors={Rambut:{bg:'#FBEAF0',c:'#993556'},Wajah:{bg:'#E6F1FB',c:'#185FA5'},Kuku:{bg:'#EAF3DE',c:'#3B6D11'},Tubuh:{bg:'#FAEEDA',c:'#633806'},Paket:{bg:'#F1EFE8',c:'#444441'},Lainnya:{bg:'#FBEAF0',c:'#72243E'}};

function populateSvcSelect(){
  const sel=document.getElementById('svc-sel');
  sel.innerHTML='<option value="">-- Pilih Layanan --</option>'+services.map(s=>`<option value="${s.id}">${s.name} — Rp ${s.price.toLocaleString('id-ID')}</option>`).join('');
}

function searchMember(){
  const v=document.getElementById('cust-name').value.toLowerCase();
  const hint=document.getElementById('member-hint');
  if(v.length<2){hint.style.display='none';return;}
  const found=members.find(m=>m.name.toLowerCase().includes(v));
  if(found){
    hint.style.display='block';
    const disc=found.tier==='Gold'?'10%':found.tier==='Silver'?'5%':'0%';
    hint.textContent=`✓ Member: ${found.name} · ${found.tier} · ${found.poin.toLocaleString('id-ID')} poin · Diskon ${disc}`;
    updateTotals();
  } else {
    hint.style.display='none';
    updateTotals();
  }
}

function addSvc(){
  const sel=document.getElementById('svc-sel');
  if(!sel.value)return;
  const svc=services.find(s=>s.id==sel.value);
  if(!svc)return;
  orderItems.push({name:svc.name,price:svc.price});
  sel.value='';
  renderOrder();
}

function removeItem(i){orderItems.splice(i,1);renderOrder();}

function renderOrder(){
  const list=document.getElementById('order-list');
  list.innerHTML=orderItems.map((it,i)=>`<div class="order-row"><span>${it.name}</span><span style="display:flex;align-items:center;gap:7px">Rp ${it.price.toLocaleString('id-ID')}<span onclick="removeItem(${i})" style="cursor:pointer;color:var(--text3);font-size:14px;line-height:1">×</span></span></div>`).join('');
  updateTotals();
}

function updateTotals(){
  const sub=orderItems.reduce((s,i)=>s+i.price,0);
  const nameV=document.getElementById('cust-name').value.toLowerCase();
  const found=nameV.length>=2?members.find(m=>m.name.toLowerCase().includes(nameV)):null;
  let discPct=found?(found.tier==='Gold'?10:found.tier==='Silver'?5:0):0;
  const disc=Math.round(sub*discPct/100);
  grandTotal=sub-disc;

  document.getElementById('order-subtotal').classList.toggle('hidden',!orderItems.length);
  document.getElementById('sub-val').textContent='Rp '+sub.toLocaleString('id-ID');

  const discRow=document.getElementById('disc-row');
  const grandRow=document.getElementById('grand-row');
  if(disc>0&&orderItems.length){
    discRow.style.display='flex';
    document.getElementById('disc-val').textContent='-Rp '+disc.toLocaleString('id-ID');
    grandRow.style.display='flex';
    document.getElementById('grand-val').textContent='Rp '+grandTotal.toLocaleString('id-ID');
  } else {
    discRow.style.display='none';
    grandRow.style.display='none';
    grandTotal=sub;
  }

  const pp=document.getElementById('poin-preview');
  if(orderItems.length&&found){
    const pGet=Math.floor(grandTotal/1000);
    pp.style.display='block';
    pp.textContent=`Member akan mendapat +${pGet.toLocaleString('id-ID')} poin dari transaksi ini`;
  } else pp.style.display='none';
}

function selPay(el,m){
  document.querySelectorAll('.pm').forEach(p=>p.classList.remove('sel'));
  el.classList.add('sel');payMethod=m;
  document.getElementById('cash-row').style.display=m==='Tunai'?'block':'none';
  document.getElementById('change-row').style.display='none';
}

function calcChange(){
  const recv=parseInt(document.getElementById('cash-in').value)||0;
  const cr=document.getElementById('change-row');
  if(recv>0&&grandTotal>0){cr.style.display='block';document.getElementById('change-v').textContent='Rp '+Math.max(0,recv-grandTotal).toLocaleString('id-ID');}
}

function doPayment(){
  if(!orderItems.length){alert('Tambahkan layanan terlebih dahulu.');return;}
  const name=document.getElementById('cust-name').value.trim()||'Pelanggan';
  const t=new Date();
  const time=t.getHours().toString().padStart(2,'0')+':'+t.getMinutes().toString().padStart(2,'0');
  const svcs=orderItems.map(i=>i.name).join(' + ');
  const nameL=name.toLowerCase();
  const found=members.find(m=>m.name.toLowerCase().includes(nameL));

  const hl=document.getElementById('hist-list');
  const row=document.createElement('div');
  row.className='row-item';
  row.innerHTML=`<span style="font-size:10px;color:var(--text3);min-width:36px">${time}</span><span style="flex:1">${name}</span><span style="font-size:11px;color:var(--text2)">${svcs}</span><span style="font-size:11px;color:var(--text3);margin:0 7px">${payMethod}</span><span style="font-weight:500">Rp ${grandTotal.toLocaleString('id-ID')}</span>`;
  hl.prepend(row);

  reportRows.unshift({time,name,svcs,method:payMethod,isMember:!!found,total:grandTotal});

  if(found){const pGet=Math.floor(grandTotal/1000);found.poin+=pGet;found.total+=1;found.spent+=grandTotal;}

  orderItems=[];grandTotal=0;
  document.getElementById('cust-name').value='';
  document.getElementById('cash-in').value='';
  document.getElementById('member-hint').style.display='none';
  document.getElementById('change-row').style.display='none';
  document.getElementById('poin-preview').style.display='none';
  renderOrder();

  const msg=document.getElementById('pay-success');
  msg.classList.add('show');
  setTimeout(()=>msg.classList.remove('show'),4000);
}

// ===== MEMBERS =====
const tierColorMap={Gold:{av:'#FAEEDA',avC:'#633806',badge:'pill-gold'},Silver:{av:'#F1EFE8',avC:'#2C2C2A',badge:'pill-silver'},Bronze:{av:'#FAECE7',avC:'#4A1B0C',badge:'pill-bronze'}};
const tierMax={Gold:3000,Silver:1000,Bronze:500};

function renderMembers(filter){
  const list=document.getElementById('member-list');
  const filtered=filter==='all'?members:members.filter(m=>m.tier===filter);
  if(!filtered.length){list.innerHTML='<div style="text-align:center;padding:2rem;color:var(--text3);font-size:12.5px">Belum ada member di kategori ini.</div>';return;}
  list.innerHTML=filtered.map(m=>{
    const tc=tierColorMap[m.tier];
    const disc=m.tier==='Gold'?'10%':m.tier==='Silver'?'5%':'0%';
    return`<div class="member-card">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
        <div class="av av-lg" style="background:${tc.av};color:${tc.avC}">${m.initials}</div>
        <div style="flex:1">
          <div style="font-size:13px;font-weight:500">${m.name}</div>
          <span class="pill ${tc.badge}">${m.tier}</span>
        </div>
        <div style="text-align:right">
          <div style="font-size:17px;font-weight:500">${m.poin.toLocaleString('id-ID')}</div>
          <div style="font-size:10px;color:var(--text3)">poin</div>
        </div>
      </div>
      <div class="poin-bar"><div class="poin-fill" style="width:${Math.min(100,Math.round(m.poin/tierMax[m.tier]*100))}%"></div></div>
      <div style="display:flex;justify-content:space-between;font-size:10px;color:var(--text3);margin-bottom:9px">
        <span>${m.poin.toLocaleString('id-ID')} / ${tierMax[m.tier].toLocaleString('id-ID')} poin${m.tier!=='Gold'?' ke tier berikutnya':' (maks)'}</span>
        <span>Ultah: ${m.bday}</span>
      </div>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:6px">
        <div class="ms"><div class="ms-val">${m.total}x</div><div class="ms-lbl">Kunjungan</div></div>
        <div class="ms"><div class="ms-val">Rp ${(m.spent/1000000).toFixed(1)}jt</div><div class="ms-lbl">Total Belanja</div></div>
        <div class="ms"><div class="ms-val">${disc}</div><div class="ms-lbl">Diskon</div></div>
      </div>
      ${m.phone?`<div style="font-size:11px;color:var(--text3);margin-top:8px">📞 ${m.phone}</div>`:''}
    </div>`;
  }).join('');
}

function filterMember(f,el){
  document.querySelectorAll('#page-members .tab').forEach(b=>b.classList.remove('act'));
  el.classList.add('act');
  renderMembers(f);
}

function openMemberModal(){document.getElementById('m-name').value='';document.getElementById('m-phone').value='';document.getElementById('m-tier').value='Bronze';document.getElementById('m-bday').value='';document.getElementById('mem-modal').classList.remove('hidden');}
function closeMemModal(){document.getElementById('mem-modal').classList.add('hidden');}
function saveMember(){
  const name=document.getElementById('m-name').value.trim();
  if(!name){alert('Nama member wajib diisi.');return;}
  const initials=name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2);
  members.push({id:nextMemId++,name,initials,tier:document.getElementById('m-tier').value,poin:0,total:0,spent:0,bday:document.getElementById('m-bday').value,phone:document.getElementById('m-phone').value});
  closeMemModal();
  renderMembers('all');
  document.querySelectorAll('#page-members .tab').forEach((b,i)=>{b.classList.toggle('act',i===0)});
  showToast('Member baru berhasil ditambahkan');
}

// ===== SERVICES =====
function renderSvcPage(){
  const allCats=['Semua',...new Set(services.map(s=>s.cat))];
  document.getElementById('svc-tabs').innerHTML=allCats.map(c=>`<button class="tab${c===activeSvcCat?' act':''}" onclick="setSvcCat('${c}',this)">${c}${c==='Semua'?` (${services.length})`:` (${services.filter(s=>s.cat===c).length})`}</button>`).join('');
  const filtered=activeSvcCat==='Semua'?services:services.filter(s=>s.cat===activeSvcCat);
  document.getElementById('svc-sub').textContent=activeSvcCat==='Semua'?`${services.length} layanan dari ${new Set(services.map(s=>s.cat)).size} kategori`:`${filtered.length} layanan di kategori ${activeSvcCat}`;
  const prices=services.map(s=>s.price);
  document.getElementById('ss-total').textContent=services.length;
  document.getElementById('ss-cat').textContent=new Set(services.map(s=>s.cat)).size;
  document.getElementById('ss-low').textContent=prices.length?'Rp '+Math.min(...prices).toLocaleString('id-ID'):'—';
  document.getElementById('ss-high').textContent=prices.length?'Rp '+Math.max(...prices).toLocaleString('id-ID'):'—';
  const grid=document.getElementById('svc-grid');
  if(!filtered.length){grid.innerHTML=`<div style="text-align:center;padding:2rem;color:var(--text3);font-size:12.5px;grid-column:1/-1">Belum ada layanan. Klik "+ Tambah Layanan".</div>`;return;}
  grid.innerHTML=filtered.map(s=>{
    const c=catColors[s.cat]||catColors['Lainnya'];
    return`<div class="svc-card">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px">
        <div style="font-size:13px;font-weight:500">${s.name}</div>
        <span class="svc-cat-pill" style="background:${c.bg};color:${c.c}">${s.cat}</span>
      </div>
      ${s.desc?`<div style="font-size:11px;color:var(--text2);line-height:1.5">${s.desc}</div>`:''}
      <div style="display:flex;align-items:center;justify-content:space-between;margin-top:2px">
        <div><div class="svc-price">Rp ${s.price.toLocaleString('id-ID')}</div>${s.dur?`<div class="svc-dur">${s.dur} menit</div>`:''}</div>
        <div style="display:flex;gap:5px">
          <button class="btn-edit-sm" onclick="openEditSvc(${s.id})">Edit</button>
          <button class="btn-del-sm" onclick="openDelSvc(${s.id})">Hapus</button>
        </div>
      </div>
    </div>`;
  }).join('');
}

function setSvcCat(c,el){
  activeSvcCat=c;
  document.querySelectorAll('#svc-tabs .tab').forEach(t=>t.classList.remove('act'));
  if(el)el.classList.add('act');
  renderSvcPage();
}

function openSvcModal(){
  editSvcId=null;
  document.getElementById('svc-modal-title').textContent='Tambah Layanan Baru';
  ['f-name','f-price','f-dur','f-desc'].forEach(id=>document.getElementById(id).value='');
  document.getElementById('f-cat').value='';
  document.getElementById('svc-modal').classList.remove('hidden');
  setTimeout(()=>document.getElementById('f-name').focus(),50);
}

function openEditSvc(id){
  const s=services.find(x=>x.id===id);if(!s)return;
  editSvcId=id;
  document.getElementById('svc-modal-title').textContent='Edit Layanan';
  document.getElementById('f-name').value=s.name;
  document.getElementById('f-cat').value=s.cat;
  document.getElementById('f-price').value=s.price;
  document.getElementById('f-dur').value=s.dur||'';
  document.getElementById('f-desc').value=s.desc||'';
  document.getElementById('svc-modal').classList.remove('hidden');
}

function closeSvcModal(){document.getElementById('svc-modal').classList.add('hidden');editSvcId=null;}

async function saveSvc(){
  const name=document.getElementById('f-name').value.trim();
  const cat=document.getElementById('f-cat').value;
  const price=parseInt(document.getElementById('f-price').value)||0;
  const dur=parseInt(document.getElementById('f-dur').value)||0;
  const desc=document.getElementById('f-desc').value.trim();
  if(!name){alert('Nama layanan wajib diisi.');return;}
  if(!cat){alert('Pilih kategori layanan.');return;}
  if(!price){alert('Harga wajib diisi.');return;}

  const payload = {name, category: cat, price, duration: dur, description: desc};
  const headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  };

  if(editSvcId){
    const res = await fetch(`/services/${editSvcId}`, { method: 'PUT', headers, body: JSON.stringify(payload) });
    const data = await res.json();
    const idx=services.findIndex(s=>s.id===editSvcId);
    if(idx>=0)services[idx]={...services[idx],name,cat,price,dur,desc};
    showToast('Layanan berhasil diperbarui');
  } else {
    const res = await fetch(`/services`, { method: 'POST', headers, body: JSON.stringify(payload) });
    const data = await res.json();
    services.push({id: data.id, name, cat, price, dur, desc});
    showToast('Layanan baru berhasil ditambahkan');
  }
  closeSvcModal();
  renderSvcPage();
  populateSvcSelect();
}

function openDelSvc(id){
  delSvcId=id;
  const s=services.find(x=>x.id===id);
  document.getElementById('del-name').textContent=s?s.name:'layanan ini';
  document.getElementById('del-modal').classList.remove('hidden');
}
function closeDelModal(){document.getElementById('del-modal').classList.add('hidden');delSvcId=null;}
async function confirmDel(){
  if(delSvcId){
    const headers = {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
    await fetch(`/services/${delSvcId}`, { method: 'DELETE', headers });
    services=services.filter(s=>s.id!==delSvcId);
  }
  closeDelModal();
  if(activeSvcCat!=='Semua'&&!services.find(s=>s.cat===activeSvcCat))activeSvcCat='Semua';
  renderSvcPage();
  populateSvcSelect();
  showToast('Layanan berhasil dihapus');
}

// ===== REPORT =====
function renderReport(period){
  const sum=[
    {label:'Total Transaksi',val:reportRows.length+'x'},
    {label:'Total Pendapatan',val:'Rp '+reportRows.reduce((s,r)=>s+r.total,0).toLocaleString('id-ID')},
    {label:'Rata-rata Transaksi',val:'Rp '+(reportRows.length?Math.round(reportRows.reduce((s,r)=>s+r.total,0)/reportRows.length):0).toLocaleString('id-ID')},
  ];
  document.getElementById('rep-summary').innerHTML=sum.map(s=>`<div class="mc"><div class="mc-lbl">${s.label}</div><div class="mc-val" style="font-size:17px">${s.val}</div></div>`).join('');
  document.getElementById('rep-body').innerHTML=reportRows.map(r=>`<tr><td>${r.time}</td><td>${r.name}</td><td>${r.svcs}</td><td>${r.method}</td><td>${r.isMember?'<span class="pill pill-member">Member</span>':'—'}</td><td style="text-align:right;font-weight:500">Rp ${r.total.toLocaleString('id-ID')}</td></tr>`).join('');
}

function setReport(p,el){
  document.querySelectorAll('#page-report .tab').forEach(b=>b.classList.remove('act'));
  el.classList.add('act');
  renderReport(p);
}

function exportCSV(){
  const header='Waktu,Pelanggan,Layanan,Metode,Member,Total\n';
  const rows=reportRows.map(r=>`${r.time},"${r.name}","${r.svcs}",${r.method},${r.isMember?'Ya':'Tidak'},${r.total}`).join('\n');
  const blob=new Blob(['\uFEFF'+header+rows],{type:'text/csv;charset=utf-8'});
  const a=document.createElement('a');
  a.href=URL.createObjectURL(blob);
  a.download='laporan-salon-cantik.csv';
  a.click();
  showToast('File CSV berhasil diunduh');
}

function printReport(){window.print();}

// ===== TOAST =====
function showToast(msg){
  const t=document.getElementById('toast');
  t.textContent=msg;t.classList.add('show');
  setTimeout(()=>t.classList.remove('show'),2800);
}

// ===== CLOSE MODAL ON BG CLICK =====
document.getElementById('svc-modal').addEventListener('click',function(e){if(e.target===this)closeSvcModal();});
document.getElementById('del-modal').addEventListener('click',function(e){if(e.target===this)closeDelModal();});
document.getElementById('mem-modal').addEventListener('click',function(e){if(e.target===this)closeMemModal();});

renderReport('harian');
populateSvcSelect();
</script>
</body>
</html>
