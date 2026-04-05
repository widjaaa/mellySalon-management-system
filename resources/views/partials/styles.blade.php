<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0
  }

  :root {
    --purple: #9736c4;
    --purple-light: #f4e8fa;
    --purple-mid: #d8a4ef;
    --purple-dark: #621e85;
    --gold: #BA7517;
    --gold-light: #FAEEDA;
    --gold-mid: #FAC775;
    --green: #3B6D11;
    --green-light: #EAF3DE;
    --green-mid: #C0DD97;
    --blue: #185FA5;
    --blue-light: #E6F1FB;
    --blue-mid: #B5D4F4;
    --red: #A32D2D;
    --red-light: #FCEBEB;
    --red-mid: #F09595;
    --gray: #5F5E5A;
    --gray-light: #F1EFE8;
    --gray-mid: #D3D1C7;
    --coral: #993C1D;
    --coral-light: #FAECE7;
    --coral-mid: #F5C4B3;
    --bg: #F7F5F2;
    --surface: #FFFFFF;
    --border: #E8E4DF;
    --border-md: #D0CBC4;
    --text: #1A1917;
    --text2: #5F5E5A;
    --text3: #9A9690;
    --radius: 10px;
    --radius-lg: 14px;
    --radius-xl: 18px;
    --shadow: 0 1px 3px rgba(0, 0, 0, .07), 0 4px 12px rgba(0, 0, 0, .04);
  }

  html,
  body {
    height: 100%;
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    font-size: 14px
  }

  /* LAYOUT */
  .app {
    display: flex;
    height: 100vh;
    overflow: hidden
  }

  .sidebar {
    width: 220px;
    background: var(--surface);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0
  }

  .main {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden
  }

  .topbar {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: .85rem 1.4rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0
  }

  .content {
    flex: 1;
    overflow-y: auto;
    padding: 1.25rem 1.4rem
  }

  /* SIDEBAR */
  .logo {
    padding: 1.1rem 1.2rem 1rem;
    border-bottom: 1px solid var(--border)
  }

  .logo-icon {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--purple-light);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 8px
  }

  .logo-name {
    font-family: 'Playfair Display', serif;
    font-size: 16px;
    color: var(--text)
  }

  .logo-sub {
    font-size: 10px;
    color: var(--text3);
    letter-spacing: .04em
  }

  .nav {
    flex: 1;
    padding: .75rem 0
  }

  .ni {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 8px 1.2rem;
    font-size: 12.5px;
    color: var(--text2);
    cursor: pointer;
    border-left: 2px solid transparent;
    transition: all .15s;
    user-select: none
  }

  .ni:hover {
    background: #FAF7F5;
    color: var(--text)
  }

  .ni.active {
    color: var(--purple);
    background: var(--purple-light);
    border-left-color: var(--purple);
    font-weight: 500
  }

  .ni svg {
    flex-shrink: 0;
    opacity: .65
  }

  .ni.active svg {
    opacity: 1
  }

  .side-bot {
    padding: .9rem 1.2rem;
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 9px
  }

  .av {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--purple-mid);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 500;
    color: var(--purple-dark);
    flex-shrink: 0
  }

  .av-lg {
    width: 38px;
    height: 38px;
    font-size: 13px
  }

  /* TOPBAR */
  .pg-title {
    font-size: 15px;
    font-weight: 500
  }

  .chip {
    font-size: 10px;
    padding: 4px 10px;
    border-radius: 20px;
    background: var(--purple-light);
    color: var(--purple-dark);
    font-weight: 500
  }

  /* CARDS */
  .card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: .9rem 1.1rem
  }

  .ct {
    font-size: 12.5px;
    font-weight: 500;
    margin-bottom: 10px
  }

  .g2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 10px
  }

  .g3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
    margin-bottom: 10px
  }

  .g4 {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 10px;
    margin-bottom: 10px
  }

  /* METRIC */
  .mc {
    background: #FAF7F5;
    border-radius: var(--radius);
    padding: 13px
  }

  .mc-lbl {
    font-size: 10px;
    color: var(--text3);
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: 5px
  }

  .mc-val {
    font-size: 21px;
    font-weight: 500
  }

  .mc-sub {
    font-size: 10px;
    color: var(--green);
    margin-top: 3px
  }

  .mc-sub.neg {
    color: var(--red)
  }

  /* BADGES/PILLS */
  .pill {
    font-size: 10px;
    padding: 2px 7px;
    border-radius: 20px;
    font-weight: 500
  }

  .pill-done {
    background: var(--green-light);
    color: var(--green)
  }

  .pill-now {
    background: var(--purple-light);
    color: var(--purple-dark)
  }

  .pill-wait {
    background: var(--gray-light);
    color: var(--gray)
  }

  .pill-gold {
    background: var(--gold-light);
    color: #412402
  }

  .pill-silver {
    background: var(--gray-light);
    color: #2C2C2A
  }

  .pill-bronze {
    background: var(--coral-light);
    color: #4A1B0C
  }

  .pill-member {
    background: var(--green-light);
    color: var(--green)
  }

  /* ROWS */
  .row-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 7px 0;
    border-bottom: 1px solid var(--border);
    font-size: 12px
  }

  .row-item:last-child {
    border-bottom: none
  }

  /* BARS */
  .bar-wrap {
    margin-bottom: 9px
  }

  .bar-info {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: var(--text2);
    margin-bottom: 3px
  }

  .bar-track {
    height: 5px;
    background: var(--gray-light);
    border-radius: 10px;
    overflow: hidden
  }

  .bar-fill {
    height: 100%;
    border-radius: 10px
  }

  /* CHART */
  .rev-chart {
    display: flex;
    align-items: flex-end;
    gap: 5px;
    height: 85px
  }

  .rc {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px
  }

  .rb-wrap {
    flex: 1;
    display: flex;
    align-items: flex-end;
    width: 100%
  }

  .rb {
    width: 100%;
    border-radius: 3px 3px 0 0;
    background: var(--purple-mid)
  }

  .rb.hi {
    background: var(--purple)
  }

  .rl {
    font-size: 9px;
    color: var(--text3)
  }

  /* FORMS */
  .form-row {
    margin-bottom: 10px
  }

  .fl {
    font-size: 10.5px;
    color: var(--text2);
    margin-bottom: 4px
  }

  input[type=text],
  input[type=number],
  select,
  textarea {
    width: 100%;
    padding: 8px 10px;
    font-size: 12.5px;
    font-family: 'DM Sans', sans-serif;
    border: 1px solid var(--border-md);
    border-radius: var(--radius);
    background: var(--surface);
    color: var(--text);
    outline: none;
    transition: border-color .15s
  }

  input:focus,
  select:focus,
  textarea:focus {
    border-color: var(--purple)
  }

  textarea {
    resize: vertical;
    min-height: 65px;
    line-height: 1.5
  }

  /* BUTTONS */
  .btn-pri {
    padding: 9px 18px;
    background: var(--purple);
    color: white;
    border: none;
    border-radius: var(--radius);
    font-size: 12.5px;
    font-weight: 500;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: opacity .15s
  }

  .btn-pri:hover {
    opacity: .87
  }

  .btn-pri.full {
    width: 100%
  }

  .btn-out {
    padding: 8px 14px;
    background: transparent;
    color: var(--text);
    border: 1px solid var(--border-md);
    border-radius: var(--radius);
    font-size: 12px;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: background .15s
  }

  .btn-out:hover {
    background: #FAF7F5
  }

  .btn-out.full {
    width: 100%
  }

  .btn-del-sm {
    padding: 4px 9px;
    font-size: 11px;
    border: 1px solid var(--red-mid);
    border-radius: 8px;
    cursor: pointer;
    background: transparent;
    color: var(--red);
    font-family: 'DM Sans', sans-serif;
    transition: background .15s
  }

  .btn-del-sm:hover {
    background: var(--red-light)
  }

  .btn-edit-sm {
    padding: 4px 9px;
    font-size: 11px;
    border: 1px solid var(--border-md);
    border-radius: 8px;
    cursor: pointer;
    background: transparent;
    color: var(--text2);
    font-family: 'DM Sans', sans-serif;
    transition: background .15s
  }

  .btn-edit-sm:hover {
    background: #FAF7F5;
    color: var(--text)
  }

  .btn-exp {
    padding: 6px 13px;
    border: 1px solid var(--green-mid);
    border-radius: 20px;
    font-size: 11px;
    cursor: pointer;
    background: var(--green-light);
    color: var(--green);
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    transition: opacity .15s
  }

  .btn-exp:hover {
    opacity: .8
  }

  /* PAYMENT */
  .pay-methods{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:10px}
  .pm{padding:11px 7px;text-align:center;border:1px solid var(--border);border-radius:var(--radius);cursor:pointer;font-size:11.5px;color:var(--text2);transition:all .15s}
  .pm:hover,.pm.sel{border-color:var(--purple);background:var(--purple-light);color:var(--purple-dark);font-weight:500}
  .pm-icon{font-size:20px;margin-bottom:4px}
  .order-row{display:flex;justify-content:space-between;align-items:center;padding:6px 0;border-bottom:1px solid var(--border);font-size:12px}
  .order-row:last-child{border-bottom:none}
  .order-total{display:flex;justify-content:space-between;padding:9px 0 0;font-weight:500;font-size:13px}

  .quick-cash-row{display:flex;gap:6px;margin-top:6px}
  .btn-quick-cash{flex:1;padding:5px;border:1px solid var(--border-md);background:var(--surface);border-radius:6px;font-size:10px;cursor:pointer;color:var(--text2)}
  .btn-quick-cash:hover{background:#FAF7F5}
  .bank-card{padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius);background:#FAF7F5;margin-bottom:8px}
  .btn-copy{padding:3px 8px;font-size:10px;background:white;border:1px solid var(--border-md);border-radius:4px;cursor:pointer;transition:all .1s}
  .btn-copy:hover{background:var(--purple);color:white;border-color:var(--purple)}

  /* MEMBER */
  .member-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: .85rem 1rem;
    margin-bottom: 9px
  }

  .poin-bar {
    height: 5px;
    background: var(--gray-light);
    border-radius: 10px;
    overflow: hidden;
    margin: 6px 0 3px
  }

  .poin-fill {
    height: 100%;
    border-radius: 10px;
    background: var(--purple)
  }

  .ms {
    background: #FAF7F5;
    border-radius: var(--radius);
    padding: 7px;
    text-align: center
  }

  .ms-val {
    font-size: 14px;
    font-weight: 500
  }

  .ms-lbl {
    font-size: 9px;
    color: var(--text3)
  }

  /* LAYANAN */
  .svc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 9px;
    margin-bottom: 1rem
  }

  .svc-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: .85rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 6px;
    transition: border-color .15s
  }

  .svc-card:hover {
    border-color: var(--border-md)
  }

  .svc-cat-pill {
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 500;
    white-space: nowrap
  }

  .svc-price {
    font-size: 14px;
    font-weight: 500;
    color: var(--purple)
  }

  .svc-dur {
    font-size: 10px;
    color: var(--text3)
  }

  /* MODAL */
  .modal-bg {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .4);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 200
  }

  .modal {
    background: var(--surface);
    border-radius: var(--radius-xl);
    padding: 1.3rem;
    width: 400px;
    max-width: 95vw;
    box-shadow: 0 20px 60px rgba(0, 0, 0, .15)
  }

  .modal-title {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 1rem
  }

  .modal-actions {
    display: flex;
    gap: 7px;
    justify-content: flex-end;
    margin-top: 1rem
  }

  /* REPORT TABLE */
  .rep-table {
    width: 100%;
    font-size: 12px;
    border-collapse: collapse
  }

  .rep-table th {
    text-align: left;
    padding: 7px 10px;
    font-size: 10px;
    color: var(--text3);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .04em;
    border-bottom: 1px solid var(--border)
  }

  .rep-table td {
    padding: 8px 10px;
    border-bottom: 1px solid var(--border);
    color: var(--text)
  }

  .rep-table tr:last-child td {
    border-bottom: none
  }

  .rep-table tr:hover td {
    background: #FAF7F5
  }

  /* TABS / FILTERS */
  .tab-row {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 1rem
  }

  .tab {
    padding: 5px 13px;
    border: 1px solid var(--border-md);
    border-radius: 20px;
    font-size: 11.5px;
    cursor: pointer;
    color: var(--text2);
    background: var(--surface);
    transition: all .15s;
    font-family: 'DM Sans', sans-serif
  }

  .tab:hover {
    background: #FAF7F5
  }

  .tab.act {
    background: var(--purple);
    color: white;
    border-color: var(--purple)
  }

  /* ALERTS */
  .alert-success {
    background: var(--green-light);
    border: 1px solid var(--green-mid);
    border-radius: var(--radius);
    padding: 10px 14px;
    font-size: 12px;
    color: var(--green);
    margin-bottom: .9rem;
    display: none
  }

  .alert-success.show {
    display: block
  }

  /* TOAST */
  #toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #2C2C2A;
    color: white;
    padding: 9px 15px;
    border-radius: var(--radius);
    font-size: 12px;
    opacity: 0;
    transition: opacity .3s;
    pointer-events: none;
    z-index: 999
  }

  #toast.show {
    opacity: 1
  }

  /* MISC */
  .sep {
    height: 1px;
    background: var(--border);
    margin: 10px 0
  }

  .mb1 {
    margin-bottom: .9rem
  }

  .hidden {
    display: none
  }

  .summary-bar {
    display: flex;
    gap: 9px;
    margin-bottom: 1rem
  }

  .sm {
    background: #FAF7F5;
    border-radius: var(--radius);
    padding: 10px 14px;
    flex: 1
  }

  .sm-val {
    font-size: 17px;
    font-weight: 500
  }

  .sm-lbl {
    font-size: 10px;
    color: var(--text3);
    margin-top: 2px
  }

  .birthday-row {
    display: flex;
    gap: 7px;
    flex-wrap: wrap
  }

  .bday-tag {
    background: var(--purple-light);
    border-radius: var(--radius);
    padding: 7px 12px;
    font-size: 11px
  }

  .page {
    display: none
  }

  .page.active {
    display: block
  }

  .hint-member {
    font-size: 10px;
    color: var(--purple);
    margin-top: 3px;
    display: none
  }

  .disc-row {
    display: none;
    flex-direction: row;
    justify-content: space-between;
    padding: 5px 0;
    font-size: 12px;
    color: var(--purple)
  }

  .grand-row {
    display: none;
    flex-direction: row;
    justify-content: space-between;
    padding: 8px 0 0;
    font-weight: 500;
    font-size: 13px;
    border-top: 1px solid var(--border);
    margin-top: 4px
  }

  .poin-preview {
    display: none;
    background: var(--purple-light);
    border-radius: var(--radius);
    padding: 8px 10px;
    font-size: 11px;
    color: var(--purple-dark);
    margin-bottom: 8px
  }

  .change-row {
    display: none;
    padding: 8px 0;
    margin-bottom: 6px;
    border-top: 1px solid var(--border)
  }
</style>