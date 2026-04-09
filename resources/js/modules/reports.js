/**
 * =============================================================
 * reports.js — Logika halaman Laporan & Export
 * =============================================================
 *
 * Menangani:
 * - Render tabel laporan transaksi
 * - Ringkasan statistik (total transaksi, pendapatan, rata-rata)
 * - Export data ke file CSV
 * - Cetak laporan
 */

import { state } from './state.js';
import { formatRupiah, showToast } from './utils.js';

/**
 * Render laporan dengan ringkasan dan tabel detail transaksi.
 * @param {string} period - Periode laporan: 'harian', 'mingguan', atau 'bulanan'
 */
export function renderReport(period) {
    renderReportSummary();
    renderReportTable();
}

/**
 * Render kartu ringkasan laporan (total transaksi, pendapatan, rata-rata).
 */
function renderReportSummary() {
    const totalRevenue = state.reportRows.reduce((sum, row) => sum + row.total, 0);
    const averageTransaction = state.reportRows.length
        ? Math.round(totalRevenue / state.reportRows.length)
        : 0;

    const summaryData = [
        { label: 'Total Transaksi', value: state.reportRows.length + 'x' },
        { label: 'Total Pendapatan', value: formatRupiah(totalRevenue) },
        { label: 'Rata-rata Transaksi', value: formatRupiah(averageTransaction) },
    ];

    const summaryContainer = document.getElementById('rep-summary');
    if (summaryContainer) {
        summaryContainer.innerHTML = summaryData.map(item => `
            <div class="mc">
                <div class="mc-lbl">${item.label}</div>
                <div class="mc-val" style="font-size:17px">${item.value}</div>
            </div>
        `).join('');
    }
}

/**
 * Render tabel detail transaksi.
 */
function renderReportTable() {
    const tableBody = document.getElementById('rep-body');
    if (!tableBody) return;

    tableBody.innerHTML = state.reportRows.map(row => `
        <tr>
            <td>${row.time}</td>
            <td>${row.name}</td>
            <td>${row.svcs}</td>
            <td>${row.method}</td>
            <td>${row.isMember ? '<span class="pill pill-member">Member</span>' : '—'}</td>
            <td style="text-align:right;font-weight:500">${formatRupiah(row.total)}</td>
        </tr>
    `).join('');
}

/**
 * Mengubah tab periode laporan.
 * @param {string} period - Periode yang dipilih
 * @param {HTMLElement} element - Tombol tab yang diklik
 */
export function setReportPeriod(period, element) {
    document.querySelectorAll('#page-report .tab').forEach(
        btn => btn.classList.remove('act')
    );
    element.classList.add('act');
    renderReport(period);
}

/**
 * Export data laporan ke file CSV dan download otomatis.
 */
export function exportCSV() {
    const header = 'Waktu,Pelanggan,Layanan,Metode,Member,Total\n';
    const rows = state.reportRows.map(row =>
        `${row.time},"${row.name}","${row.svcs}",${row.method},${row.isMember ? 'Ya' : 'Tidak'},${row.total}`
    ).join('\n');

    // BOM (\uFEFF) agar Excel bisa membaca karakter Indonesia dengan benar
    const blob = new Blob(['\uFEFF' + header + rows], {
        type: 'text/csv;charset=utf-8',
    });

    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'laporan-salon-cantik.csv';
    link.click();

    showToast('File CSV berhasil diunduh');
}

/**
 * Cetak laporan menggunakan fungsi print browser.
 */
export function printReport() {
    window.print();
}
