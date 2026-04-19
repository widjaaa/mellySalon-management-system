/**
 * =============================================================
 * invoice.js — Riwayat Transaksi, Invoice, Void, Pagination
 * =============================================================
 */

import { state } from './state.js';
import { formatRupiah, formatDate, formatTime, showToast } from './utils.js';
import { fetchTransactions, fetchTransactionDetail, voidTransaction } from './api.js';

// ==================== State untuk Riwayat ====================
let historyState = {
    currentPage: 1,
    lastPage: 1,
    total: 0,
    search: '',
    statusFilter: 'all',
    voidTargetId: null,
    voidTargetInvoice: '',
    debounceTimer: null,
};

/**
 * Muat riwayat transaksi dengan search & pagination.
 */
export async function loadTransactionHistory(page = 1) {
    try {
        historyState.currentPage = page;

        const params = { page, per_page: 15 };
        if (historyState.search) params.search = historyState.search;
        if (historyState.statusFilter !== 'all') params.status = historyState.statusFilter;

        const result = await fetchTransactions(params);
        const transactions = result.data || [];
        const pagination = result.pagination || {};

        historyState.lastPage = pagination.last_page || 1;
        historyState.total = pagination.total || 0;

        state.transactions = transactions;
        renderTransactionHistory(transactions);
        renderPagination(pagination);
    } catch (error) {
        console.error('Gagal memuat riwayat:', error);
    }
}

/**
 * Debounced search handler.
 */
export function searchTransactionHistory() {
    clearTimeout(historyState.debounceTimer);
    historyState.debounceTimer = setTimeout(() => {
        const input = document.getElementById('hist-search');
        historyState.search = input ? input.value.trim() : '';
        loadTransactionHistory(1);
    }, 400);
}

/**
 * Filter berdasarkan status transaksi.
 */
export function filterTransactionStatus(status, btn) {
    historyState.statusFilter = status;

    // Update button active state
    document.querySelectorAll('.hist-status-btn').forEach(b => {
        b.classList.remove('active');
        b.classList.add('border-gray-200', 'bg-white', 'text-gray-600');
    });
    if (btn) {
        btn.classList.add('active');
        btn.classList.remove('border-gray-200', 'bg-white', 'text-gray-600');
    }

    loadTransactionHistory(1);
}

/**
 * Navigasi halaman.
 */
export function histPrevPage() {
    if (historyState.currentPage > 1) {
        loadTransactionHistory(historyState.currentPage - 1);
    }
}

export function histNextPage() {
    if (historyState.currentPage < historyState.lastPage) {
        loadTransactionHistory(historyState.currentPage + 1);
    }
}

/**
 * Render tabel riwayat transaksi.
 */
function renderTransactionHistory(transactions) {
    const tbody = document.getElementById('hist-list');
    const countEl = document.getElementById('hist-count');
    if (!tbody) return;

    if (countEl) countEl.textContent = `${historyState.total} transaksi tercatat`;

    if (!transactions.length) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-center py-12 text-gray-400 text-sm">
            ${historyState.search ? 'Tidak ada transaksi yang cocok.' : 'Belum ada riwayat transaksi.'}
        </td></tr>`;
        return;
    }

    tbody.innerHTML = transactions.map(trx => {
        const isVoided = trx.status === 'voided';
        const statusBadge = isVoided
            ? `<span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-red-50 text-red-600 border border-red-100">Dibatalkan</span>`
            : `<span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">Selesai</span>`;

        const voidBtn = !isVoided
            ? `<button onclick="SalonApp.openVoidModal(${trx.id},'${trx.invoice_number}')"
                class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-semibold text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors border border-amber-100"
                title="Batalkan Transaksi">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                Void
            </button>`
            : '';

        return `
        <tr class="hover:bg-gray-50 transition-colors ${isVoided ? 'opacity-60' : ''}">
            <td class="px-6 py-3">
                <span class="text-xs font-mono font-bold text-brand-purple bg-brand-purple-light px-2 py-0.5 rounded">${trx.invoice_number}</span>
            </td>
            <td class="px-6 py-3 text-sm text-gray-500">${formatDate(trx.created_at)} ${formatTime(trx.created_at)}</td>
            <td class="px-6 py-3 text-sm font-medium text-gray-800">${trx.customer_name}</td>
            <td class="px-6 py-3 text-sm text-gray-600 max-w-[200px] truncate">${trx.services_summary}</td>
            <td class="px-6 py-3">
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-brand-purple-light text-brand-purple-dark">${trx.payment_method}</span>
            </td>
            <td class="px-6 py-3 text-center">${statusBadge}</td>
            <td class="px-6 py-3 text-sm font-bold text-gray-800 text-right ${isVoided ? 'line-through' : ''}">${formatRupiah(trx.total_amount)}</td>
            <td class="px-6 py-3 text-center">
                <div class="flex items-center justify-center gap-1.5">
                    <button onclick="SalonApp.sendWhatsAppReceipt(${trx.id})"
                        class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-semibold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors"
                        title="Kirim ke WhatsApp">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        WA
                    </button>
                    <button onclick="SalonApp.printInvoice(${trx.id})"
                        class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-semibold text-brand-purple bg-brand-purple-light hover:bg-brand-purple-mid/30 rounded-lg transition-colors"
                        title="Cetak Invoice">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Invoice
                    </button>
                    ${voidBtn}
                </div>
            </td>
        </tr>`;
    }).join('');
}

/**
 * Render pagination controls.
 */
function renderPagination(pagination) {
    const paginationEl = document.getElementById('hist-pagination');
    const pageInfo = document.getElementById('hist-page-info');
    const pageNum = document.getElementById('hist-page-num');
    const prevBtn = document.getElementById('hist-prev');
    const nextBtn = document.getElementById('hist-next');

    if (!paginationEl) return;

    if (pagination.total > 0) {
        paginationEl.classList.remove('hidden');
        paginationEl.classList.add('flex');
    } else {
        paginationEl.classList.add('hidden');
        paginationEl.classList.remove('flex');
        return;
    }

    const start = ((pagination.current_page - 1) * pagination.per_page) + 1;
    const end = Math.min(pagination.current_page * pagination.per_page, pagination.total);

    if (pageInfo) pageInfo.textContent = `Menampilkan ${start}–${end} dari ${pagination.total} transaksi`;
    if (pageNum) pageNum.textContent = `${pagination.current_page} / ${pagination.last_page}`;
    if (prevBtn) prevBtn.disabled = pagination.current_page <= 1;
    if (nextBtn) nextBtn.disabled = pagination.current_page >= pagination.last_page;
}

// ==================== VOID TRANSAKSI ====================

export function openVoidModal(id, invoiceNumber) {
    historyState.voidTargetId = id;
    historyState.voidTargetInvoice = invoiceNumber;

    const invoiceEl = document.getElementById('void-trx-invoice');
    if (invoiceEl) invoiceEl.textContent = invoiceNumber;

    const modal = document.getElementById('void-trx-modal');
    if (modal) modal.classList.remove('hidden');
}

export function closeVoidModal() {
    const modal = document.getElementById('void-trx-modal');
    if (modal) modal.classList.add('hidden');
    historyState.voidTargetId = null;
}

export async function confirmVoidTransaction() {
    if (!historyState.voidTargetId) return;

    try {
        await voidTransaction(historyState.voidTargetId);
        showToast(`Transaksi ${historyState.voidTargetInvoice} berhasil dibatalkan.`);
        closeVoidModal();
        loadTransactionHistory(historyState.currentPage);
    } catch (error) {
        showToast('Gagal membatalkan transaksi: ' + error.message, 'error');
    }
}

// ==================== INVOICE / CETAK ====================

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

    const voidedBanner = trx.status === 'voided' ? `
        <div style="background:#fef2f2;border:2px solid #fca5a5;border-radius:8px;padding:8px;text-align:center;margin-bottom:16px;color:#dc2626;font-weight:700;font-size:14px">
            ❌ TRANSAKSI DIBATALKAN
        </div>` : '';

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
    ${voidedBanner}
    <div style="text-align:center;margin-bottom:20px;padding-bottom:16px;border-bottom:2px dashed #ddd">
        <div style="font-size:22px;font-weight:700;color:#9736c4;margin-bottom:2px">Melly Salon</div>
        <div style="font-size:11px;color:#888;letter-spacing:1px">Sanggar Wedding & Kecantikan</div>
        <div style="font-size:11px;color:#999;margin-top:6px">Perum Bumi Cikarang Makmur, Blok EII No. 15, Cikarang Selatan, Bekasi</div>
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
        <div style="font-size:10px;color:#ccc;margin-top:4px">Instagram: wedding_melly_group</div>
    </div>

    <script>window.onload=function(){window.print()}<\/script>
</body>
</html>`;

    const printWindow = window.open('', '_blank', 'width=450,height=700');
    printWindow.document.write(html);
    printWindow.document.close();
}

/**
 * Kirim struk (receipt) ke WhatsApp via tautan wa.me
 */
export async function sendWhatsAppReceipt(transactionId) {
    try {
        const trx = await fetchTransactionDetail(transactionId);
        
        let phoneNumber = '';
        if (trx.member && trx.member.phone) {
            phoneNumber = trx.member.phone;
            // Jika diawali 0, ubah ke 62
            if (phoneNumber.startsWith('0')) {
                phoneNumber = '62' + phoneNumber.substring(1);
            }
        }

        if (!phoneNumber) {
            const userInput = prompt(`Nomor HP pelanggan (contoh: 08123... atau 62812...)\nKosongkan jika ingin memilih manual di WhatsApp:`);
            if (userInput !== null) {
                phoneNumber = userInput.trim();
                if (phoneNumber.startsWith('0')) {
                    phoneNumber = '62' + phoneNumber.substring(1);
                }
            } else {
                return; // User clicked Cancel
            }
        }

        const date = new Date(trx.created_at);
        const dateStr = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        
        // Build the message
        let msg = `*MELLY SALON* — Struk Pembayaran\n`;
        msg += `Jl. Perum Bumi Cikarang Makmur, Bekasi\n`;
        msg += `--------------------------------------\n`;
        msg += `No. Inv : ${trx.invoice_number}\n`;
        msg += `Tanggal : ${dateStr}\n`;
        msg += `Pelanggan: ${trx.customer_name}\n`;
        if (trx.member) {
            msg += `Status  : Member ${trx.member.tier}\n`;
        }
        msg += `--------------------------------------\n`;
        
        // Items
        trx.items.forEach(item => {
            msg += `▪ ${item.service_name}\n`;
            msg += `  ${item.quantity} x Rp ${item.service_price.toLocaleString('id-ID')} = Rp ${(item.quantity * item.service_price).toLocaleString('id-ID')}\n`;
        });
        
        msg += `--------------------------------------\n`;
        msg += `Subtotal : Rp ${trx.subtotal.toLocaleString('id-ID')}\n`;
        
        if (trx.discount_amount > 0) {
            msg += `Diskon   : -Rp ${trx.discount_amount.toLocaleString('id-ID')}\n`;
        }
        
        msg += `*TOTAL    : Rp ${trx.total_amount.toLocaleString('id-ID')}*\n`;
        msg += `Metode   : ${trx.payment_method}\n`;
        
        if (trx.poin_awarded > 0) {
            msg += `\n🎁 *Hore!* Kamu mendapatkan *+${trx.poin_awarded} Poin* dari kunjungan ini.\n`;
        }
        
        msg += `\nTerima kasih telah mempercayakan perawatan salon Anda di Melly Salon! ✨\n`;
        msg += `_Instagram: @wedding_melly_group_`;

        // Redirect to wa.me
        const waLink = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(msg)}`;
        window.open(waLink, '_blank');
        
    } catch (error) {
        console.error(error);
        showToast('Gagal memuat data untuk WhatsApp.', 'error');
    }
}
