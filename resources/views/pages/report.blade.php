<div class="page" id="page-report">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.9rem;flex-wrap:wrap;gap:8px">
        <div class="tab-row" style="margin-bottom:0">
          <button class="tab act" onclick="SalonApp.setReportPeriod('harian',this)">Harian</button>
          <button class="tab" onclick="SalonApp.setReportPeriod('mingguan',this)">Mingguan</button>
          <button class="tab" onclick="SalonApp.setReportPeriod('bulanan',this)">Bulanan</button>
        </div>
        <div style="display:flex;gap:7px">
          <button class="btn-exp" onclick="SalonApp.exportCSV()">⬇ Ekspor CSV</button>
          <button class="btn-exp" onclick="SalonApp.printReport()">🖨 Cetak</button>
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
