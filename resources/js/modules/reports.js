/**
 * =============================================================
 * reports.js — Logika halaman Laporan & Rekapitulasi
 * =============================================================
 */

import { state } from './state.js';
import { formatRupiah, showToast, formatTime, formatDate } from './utils.js';
import { fetchReportData } from './api.js';
import * as XLSX from 'xlsx';

/**
 * Render laporan dari API.
 */
export async function renderReport(period = 'harian') {
    state.reportPeriod = period;

    try {
        const data = await fetchReportData(period);
        state.reportData = data;
        renderReportSummary(data);
        renderPaymentBreakdown(data);
        renderReportTable(data);
        updateReportTitle(period);
    } catch (error) {
        console.error('Gagal memuat laporan:', error);
    }
}

/**
 * Render kartu ringkasan.
 */
function renderReportSummary(data) {
    const s = data.summary;
    const el = (id, val) => {
        const e = document.getElementById(id);
        if (e) e.textContent = val;
    };

    el('rep-total-trx', s.total_transactions + 'x');
    el('rep-total-rev', formatRupiah(s.total_revenue));
    el('rep-avg', formatRupiah(s.average_transaction));
    el('rep-member-trx', s.member_transactions + 'x');
}

/**
 * Render breakdown metode pembayaran.
 */
function renderPaymentBreakdown(data) {
    const pb = data.payment_breakdown || {};

    const update = (method, idTotal, idCount) => {
        const info = pb[method] || { count: 0, total: 0 };
        const elTotal = document.getElementById(idTotal);
        const elCount = document.getElementById(idCount);
        if (elTotal) elTotal.textContent = formatRupiah(info.total);
        if (elCount) elCount.textContent = info.count + ' transaksi';
    };

    update('Tunai', 'pm-cash', 'pm-cash-count');
    update('QRIS', 'pm-qris', 'pm-qris-count');
    update('Transfer', 'pm-transfer', 'pm-transfer-count');
}

/**
 * Render tabel detail transaksi.
 */
function renderReportTable(data) {
    const tbody = document.getElementById('rep-body');
    if (!tbody) return;

    const transactions = data.transactions || [];

    if (transactions.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-12 text-gray-400 text-sm">Belum ada data transaksi untuk periode ini.</td></tr>';
        return;
    }

    tbody.innerHTML = transactions.map(trx => {
        const time = formatTime(trx.created_at);
        const memberBadge = trx.member_id
            ? '<span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-700">Member</span>'
            : '<span class="text-gray-400">—</span>';

        return `
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-3 text-sm text-gray-500">${time}</td>
            <td class="px-6 py-3 text-sm font-medium text-gray-800">${trx.customer_name}</td>
            <td class="px-6 py-3 text-sm text-gray-600">${trx.services_summary}</td>
            <td class="px-6 py-3"><span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-brand-purple-light text-brand-purple-dark">${trx.payment_method}</span></td>
            <td class="px-6 py-3">${memberBadge}</td>
            <td class="px-6 py-3 text-sm font-bold text-gray-800 text-right">${formatRupiah(trx.total_amount)}</td>
        </tr>`;
    }).join('');
}

/**
 * Update judul laporan.
 */
function updateReportTitle(period) {
    const title = document.getElementById('rep-title');
    if (title) {
        const labels = { harian: 'Laporan Harian', mingguan: 'Laporan Mingguan', bulanan: 'Laporan Bulanan' };
        title.textContent = labels[period] || 'Laporan';
    }
}

/**
 * Mengubah tab periode laporan.
 */
export function setReportPeriod(period, element) {
    document.querySelectorAll('#page-report .report-tab').forEach(btn => {
        btn.classList.remove('active', 'bg-brand-purple', 'text-white', 'border-brand-purple');
        btn.classList.add('border-gray-200', 'bg-white', 'text-gray-600');
    });
    element.classList.add('active', 'bg-brand-purple', 'text-white', 'border-brand-purple');
    element.classList.remove('border-gray-200', 'bg-white', 'text-gray-600');
    renderReport(period);
}

/**
 * Export ke Excel (.xlsx) murni.
 */
export function exportExcel() {
    if (!state.reportData || !state.reportData.transactions.length) {
        showToast('Tidak ada data untuk diekspor.', 'error');
        return;
    }

    // 1. Siapkan header tabel
    const excelData = [
        ['Tanggal', 'Pelanggan', 'Layanan', 'Metode', 'Member', 'Total']
    ];

    // 2. Isi data row dari transactions
    state.reportData.transactions.forEach(trx => {
        const date = formatDate(trx.created_at);
        excelData.push([
            date, 
            trx.customer_name, 
            trx.services_summary, 
            trx.payment_method, 
            trx.member_id ? 'Ya' : 'Tidak', 
            trx.total_amount
        ]);
    });

    // Tambahkan baris kosong dan baris Total Pendapatan
    excelData.push([]);
    excelData.push([
        '', '', '', '', 'TOTAL PENDAPATAN:', state.reportData.summary.total_revenue
    ]);

    // 3. Konversi array ke format worksheet SheetJS
    const ws = XLSX.utils.aoa_to_sheet(excelData);

    // Styling simpel (opsional/tergantung versi xlsx)
    ws['!cols'] = [
        { wch: 15 }, // Tanggal
        { wch: 25 }, // Pelanggan
        { wch: 40 }, // Layanan
        { wch: 15 }, // Metode
        { wch: 20 }, // Member (diperlebar untuk teks TOTAL PENDAPATAN)
        { wch: 15 }  // Total
    ];

    // 4. Buat Workbook baru
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Laporan Transaksi");

    // 5. Trigger download file Excel (.xlsx)
    XLSX.writeFile(wb, `Laporan_Melly_Salon_${state.reportPeriod}.xlsx`);

    showToast('File Excel berhasil diunduh!');
}

/**
 * Cetak laporan.
 */
export function printReport() {
    window.print();
}
