/**
 * =============================================================
 * invoice.js — Generate & cetak Invoice
 * =============================================================
 */

import { state } from './state.js';
import { formatRupiah, formatDate, formatTime, showToast } from './utils.js';
import { fetchTransactions, fetchTransactionDetail } from './api.js';

/**
 * Muat riwayat transaksi dari database.
 */
export async function loadTransactionHistory() {
    try {
        const transactions = await fetchTransactions();
        state.transactions = transactions;
        renderTransactionHistory(transactions);
    } catch (error) {
        console.error('Gagal memuat riwayat:', error);
    }
}

/**
 * Render tabel riwayat transaksi.
 */
function renderTransactionHistory(transactions) {
    const tbody = document.getElementById('hist-list');
    const countEl = document.getElementById('hist-count');
    if (!tbody) return;

    if (countEl) countEl.textContent = `${transactions.length} transaksi tercatat`;

    if (!transactions.length) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-12 text-gray-400 text-sm">Belum ada riwayat transaksi.</td></tr>';
        return;
    }

    tbody.innerHTML = transactions.map(trx => `
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-3">
                <span class="text-xs font-mono font-bold text-brand-purple bg-brand-purple-light px-2 py-0.5 rounded">${trx.invoice_number}</span>
            </td>
            <td class="px-6 py-3 text-sm text-gray-500">${formatDate(trx.created_at)} ${formatTime(trx.created_at)}</td>
            <td class="px-6 py-3 text-sm font-medium text-gray-800">${trx.customer_name}</td>
            <td class="px-6 py-3 text-sm text-gray-600 max-w-[200px] truncate">${trx.services_summary}</td>
            <td class="px-6 py-3">
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-brand-purple-light text-brand-purple-dark">${trx.payment_method}</span>
            </td>
            <td class="px-6 py-3 text-sm font-bold text-gray-800 text-right">${formatRupiah(trx.total_amount)}</td>
            <td class="px-6 py-3 text-center">
                <button onclick="SalonApp.printInvoice(${trx.id})"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-brand-purple bg-brand-purple-light hover:bg-brand-purple-mid/30 rounded-lg transition-colors"
                    title="Cetak Invoice">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Invoice
                </button>
            </td>
        </tr>
    `).join('');
}

/**
 * Cetak invoice untuk transaksi tertentu.
 */
export async function printInvoice(transactionId) {
    try {
        const trx = await fetchTransactionDetail(transactionId);
        openInvoiceWindow(trx);
    } catch (error) {
        showToast('Gagal memuat detail invoice.', 'error');
    }
}

/**
 * Buka window cetak invoice.
 */
function openInvoiceWindow(trx) {
    const items = trx.items || [];
    const date = new Date(trx.created_at);

    const itemsRows = items.map(item => `
        <tr>
            <td style="padding:8px 0;border-bottom:1px solid #eee;font-size:13px">${item.service_name}</td>
            <td style="padding:8px 0;border-bottom:1px solid #eee;font-size:13px;text-align:center">${item.quantity}</td>
            <td style="padding:8px 0;border-bottom:1px solid #eee;font-size:13px;text-align:right">${formatRupiah(item.service_price)}</td>
            <td style="padding:8px 0;border-bottom:1px solid #eee;font-size:13px;text-align:right">${formatRupiah(item.service_price * item.quantity)}</td>
        </tr>
    `).join('');

    const discountRow = trx.discount_amount > 0 ? `
        <tr>
            <td colspan="3" style="padding:6px 0;text-align:right;font-size:13px;color:#666">Diskon Member</td>
            <td style="padding:6px 0;text-align:right;font-size:13px;color:#16a34a;font-weight:600">-${formatRupiah(trx.discount_amount)}</td>
        </tr>` : '';

    const cashRow = trx.payment_method === 'Tunai' && trx.cash_received ? `
        <tr>
            <td colspan="3" style="padding:4px 0;text-align:right;font-size:12px;color:#888">Tunai Diterima</td>
            <td style="padding:4px 0;text-align:right;font-size:12px;color:#888">${formatRupiah(trx.cash_received)}</td>
        </tr>
        <tr>
            <td colspan="3" style="padding:4px 0;text-align:right;font-size:12px;color:#888">Kembalian</td>
            <td style="padding:4px 0;text-align:right;font-size:12px;color:#888">${formatRupiah(trx.cash_change)}</td>
        </tr>` : '';

    const html = `<!DOCTYPE html>
<html>
<head>
    <title>Invoice ${trx.invoice_number}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DM Sans',sans-serif; padding:20px; max-width:400px; margin:0 auto; color:#1a1917; }
        @media print { body { padding:0; } }
    </style>
</head>
<body>
    <div style="text-align:center;margin-bottom:20px;padding-bottom:16px;border-bottom:2px dashed #ddd">
        <div style="font-size:22px;font-weight:700;color:#9736c4;margin-bottom:2px">♥ Melly Salon</div>
        <div style="font-size:11px;color:#888;letter-spacing:1px">BEAUTY & WELLNESS</div>
        <div style="font-size:11px;color:#999;margin-top:6px">Jl. Contoh Alamat No. 123</div>
    </div>

    <div style="display:flex;justify-content:space-between;margin-bottom:16px;font-size:12px;color:#666">
        <div>
            <div style="font-weight:600;color:#333;font-size:13px">${trx.invoice_number}</div>
            <div style="margin-top:2px">${date.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}</div>
            <div>${date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })} WIB</div>
        </div>
        <div style="text-align:right">
            <div style="font-weight:600;color:#333">${trx.customer_name}</div>
            ${trx.member ? `<div style="color:#9736c4;font-weight:600;font-size:11px">${trx.member.tier} Member</div>` : ''}
        </div>
    </div>

    <table style="width:100%;border-collapse:collapse;margin-bottom:12px">
        <thead>
            <tr style="border-bottom:2px solid #333">
                <th style="padding:8px 0;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;color:#888">Layanan</th>
                <th style="padding:8px 0;text-align:center;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;color:#888">Qty</th>
                <th style="padding:8px 0;text-align:right;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;color:#888">Harga</th>
                <th style="padding:8px 0;text-align:right;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;color:#888">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            ${itemsRows}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="padding:8px 0;text-align:right;font-size:13px;color:#666">Subtotal</td>
                <td style="padding:8px 0;text-align:right;font-size:13px">${formatRupiah(trx.subtotal)}</td>
            </tr>
            ${discountRow}
            <tr style="border-top:2px solid #333">
                <td colspan="3" style="padding:10px 0;text-align:right;font-size:16px;font-weight:700">TOTAL</td>
                <td style="padding:10px 0;text-align:right;font-size:16px;font-weight:700;color:#9736c4">${formatRupiah(trx.total_amount)}</td>
            </tr>
            ${cashRow}
        </tfoot>
    </table>

    <div style="text-align:center;padding:12px 0;border-top:2px dashed #ddd;margin-top:8px">
        <div style="font-size:12px;color:#666;margin-bottom:2px">Metode Pembayaran: <strong>${trx.payment_method}</strong></div>
        ${trx.poin_awarded > 0 ? `<div style="font-size:11px;color:#9736c4;font-weight:600;margin-top:4px">+${trx.poin_awarded} poin diberikan</div>` : ''}
        <div style="font-size:11px;color:#aaa;margin-top:12px">Terima kasih telah berkunjung! ♥</div>
        <div style="font-size:10px;color:#ccc;margin-top:4px">www.mellysalon.com</div>
    </div>

    <script>window.onload=function(){window.print()}<\/script>
</body>
</html>`;

    const printWindow = window.open('', '_blank', 'width=450,height=700');
    printWindow.document.write(html);
    printWindow.document.close();
}
