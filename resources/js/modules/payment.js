/**
 * =============================================================
 * payment.js — Logika halaman Pembayaran (Point of Sales)
 * =============================================================
 *
 * Menangani:
 * - Pemilihan layanan untuk transaksi
 * - Pencarian & deteksi member (diskon otomatis)
 * - Kalkulasi subtotal, diskon, dan grand total
 * - Pemilihan metode pembayaran (Tunai/QRIS/Transfer)
 * - Proses pembayaran ke server
 */

import { state } from './state.js';
import { formatRupiah, showToast } from './utils.js';
import { createTransaction } from './api.js';
import { goPage } from './navigation.js';

/** Warna kategori untuk badge layanan di dropdown */
const CATEGORY_COLORS = {
    Rambut:  { bg: '#FBEAF0', color: '#993556' },
    Wajah:   { bg: '#E6F1FB', color: '#185FA5' },
    Kuku:    { bg: '#EAF3DE', color: '#3B6D11' },
    Tubuh:   { bg: '#FAEEDA', color: '#633806' },
    Paket:   { bg: '#F1EFE8', color: '#444441' },
    Lainnya: { bg: '#FBEAF0', color: '#72243E' },
};

/**
 * Mengisi dropdown pilihan layanan dengan data dari state.
 */
export function populateServiceSelect() {
    const selectElement = document.getElementById('svc-sel');
    if (!selectElement) return;

    selectElement.innerHTML = '<option value="">-- Pilih Layanan --</option>'
        + state.services.map(service =>
            `<option value="${service.id}">${service.name} — ${formatRupiah(service.price)}</option>`
        ).join('');
}

/**
 * Mencari member berdasarkan nama yang diketik di input.
 * Jika ditemukan, menampilkan info tier & diskon.
 */
export function searchMember() {
    const inputValue = document.getElementById('cust-name').value.toLowerCase();
    const hintElement = document.getElementById('member-hint');
    if (!hintElement) return;

    if (inputValue.length < 2) {
        hintElement.style.display = 'none';
        updateTotals();
        return;
    }

    const foundMember = state.members.find(
        member => member.name.toLowerCase().includes(inputValue)
    );

    if (foundMember) {
        const discountText = foundMember.tier === 'Gold' ? '10%'
            : foundMember.tier === 'Silver' ? '5%' : '0%';

        hintElement.style.display = 'block';
        hintElement.textContent = `✓ Member: ${foundMember.name} · ${foundMember.tier} · ${foundMember.poin.toLocaleString('id-ID')} poin · Diskon ${discountText}`;
    } else {
        hintElement.style.display = 'none';
    }

    updateTotals();
}

/**
 * Menambah layanan yang dipilih ke daftar pesanan.
 */
export function addService() {
    const selectElement = document.getElementById('svc-sel');
    if (!selectElement || !selectElement.value) return;

    const selectedService = state.services.find(
        service => service.id == selectElement.value
    );
    if (!selectedService) return;

    state.orderItems.push({
        name: selectedService.name,
        price: selectedService.price,
    });

    selectElement.value = '';
    renderOrderList();
}

/**
 * Menghapus item dari daftar pesanan berdasarkan index.
 * @param {number} index - Index item yang akan dihapus
 */
export function removeOrderItem(index) {
    state.orderItems.splice(index, 1);
    renderOrderList();
}

/**
 * Render daftar pesanan dalam tampilan pembayaran.
 */
function renderOrderList() {
    const listElement = document.getElementById('order-list');
    if (!listElement) return;

    listElement.innerHTML = state.orderItems.map((item, index) => `
        <div class="order-row">
            <span>${item.name}</span>
            <span style="display:flex;align-items:center;gap:7px">
                ${formatRupiah(item.price)}
                <span onclick="window.SalonApp.removeOrderItem(${index})"
                      style="cursor:pointer;color:var(--text3);font-size:14px;line-height:1">×</span>
            </span>
        </div>
    `).join('');

    updateTotals();
}

/**
 * Menghitung ulang subtotal, diskon member, grand total,
 * dan preview poin yang akan didapatkan.
 */
function updateTotals() {
    const subtotal = state.orderItems.reduce((sum, item) => sum + item.price, 0);

    // Cek apakah pelanggan adalah member
    const customerName = document.getElementById('cust-name').value.toLowerCase();
    const foundMember = customerName.length >= 2
        ? state.members.find(member => member.name.toLowerCase().includes(customerName))
        : null;

    // Hitung diskon berdasarkan tier
    const discountPercent = foundMember
        ? (foundMember.tier === 'Gold' ? 10 : foundMember.tier === 'Silver' ? 5 : 0)
        : 0;
    const discountAmount = Math.round(subtotal * discountPercent / 100);
    state.grandTotal = subtotal - discountAmount;

    // Update tampilan subtotal
    const subtotalRow = document.getElementById('order-subtotal');
    if (subtotalRow) {
        subtotalRow.classList.toggle('hidden', !state.orderItems.length);
    }
    const subtotalValue = document.getElementById('sub-val');
    if (subtotalValue) {
        subtotalValue.textContent = formatRupiah(subtotal);
    }

    // Update tampilan diskon & grand total
    const discountRow = document.getElementById('disc-row');
    const grandRow = document.getElementById('grand-row');

    if (discountAmount > 0 && state.orderItems.length) {
        if (discountRow) {
            discountRow.style.display = 'flex';
            document.getElementById('disc-val').textContent = '-' + formatRupiah(discountAmount);
        }
        if (grandRow) {
            grandRow.style.display = 'flex';
            document.getElementById('grand-val').textContent = formatRupiah(state.grandTotal);
        }
    } else {
        if (discountRow) discountRow.style.display = 'none';
        if (grandRow) grandRow.style.display = 'none';
        state.grandTotal = subtotal;
    }

    // Update preview poin
    const poinPreview = document.getElementById('poin-preview');
    if (poinPreview) {
        if (state.orderItems.length && foundMember) {
            const pointsToEarn = Math.floor(state.grandTotal / 1000);
            poinPreview.style.display = 'block';
            poinPreview.textContent = `Member akan mendapat +${pointsToEarn.toLocaleString('id-ID')} poin dari transaksi ini`;
        } else {
            poinPreview.style.display = 'none';
        }
    }
}

/**
 * Memilih metode pembayaran dan menampilkan section yang sesuai.
 * @param {HTMLElement} element - Tombol metode yang diklik
 * @param {string} method - Metode pembayaran: 'Tunai', 'QRIS', atau 'Transfer'
 */
export function selectPaymentMethod(element, method) {
    // Highlight tombol yang dipilih
    document.querySelectorAll('.pm').forEach(btn => btn.classList.remove('sel'));
    element.classList.add('sel');
    state.paymentMethod = method;

    // Toggle visibility section pembayaran
    const sections = { 'Tunai': 'cash-section', 'QRIS': 'qris-section', 'Transfer': 'transfer-section' };
    Object.entries(sections).forEach(([key, id]) => {
        const section = document.getElementById(id);
        if (section) section.style.display = key === method ? 'block' : 'none';
    });

    if (method === 'Tunai') calculateChange();
}

/**
 * Menghitung kembalian berdasarkan uang yang diterima.
 */
export function calculateChange() {
    const receivedAmount = parseInt(document.getElementById('cash-in').value) || 0;
    const changeRow = document.getElementById('change-row');
    if (!changeRow) return;

    if (receivedAmount > 0 && state.grandTotal > 0) {
        changeRow.style.display = 'flex';
        const changeValue = document.getElementById('change-v');
        if (changeValue) {
            changeValue.textContent = formatRupiah(Math.max(0, receivedAmount - state.grandTotal));
        }
    } else {
        changeRow.style.display = 'none';
    }
}

/**
 * Set jumlah uang tunai yang diterima (dari tombol quick cash).
 * @param {number|string} value - Nominal uang atau 'pas' untuk uang pas
 */
export function setCashAmount(value) {
    const cashInput = document.getElementById('cash-in');
    if (!cashInput) return;

    cashInput.value = value === 'pas' ? state.grandTotal : value;
    calculateChange();
}

/**
 * Menyalin nomor rekening ke clipboard.
 * @param {string} accountNumber - Nomor rekening yang akan disalin
 */
export function copyAccountNumber(accountNumber) {
    navigator.clipboard.writeText(accountNumber);
    showToast('Nomor Rekening ' + accountNumber + ' disalin!');
}

/**
 * Memproses pembayaran — mengirim transaksi ke server
 * dan mereset form setelah berhasil.
 */
export async function processPayment() {
    if (!state.orderItems.length) {
        alert('Tambahkan layanan terlebih dahulu.');
        return;
    }

    const customerName = document.getElementById('cust-name').value.trim() || 'Pelanggan';
    const now = new Date();
    const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    const servicesSummary = state.orderItems.map(item => item.name).join(' + ');

    // Cek apakah pelanggan adalah member
    const nameLower = customerName.toLowerCase();
    const foundMember = state.members.find(
        member => member.name.toLowerCase().includes(nameLower)
    );
    const pointsEarned = foundMember ? Math.floor(state.grandTotal / 1000) : 0;

    const payload = {
        member_id: foundMember ? foundMember.id : null,
        customer_name: customerName,
        services_summary: servicesSummary,
        total_amount: state.grandTotal,
        payment_method: state.paymentMethod,
        poin_awarded: pointsEarned,
    };

    try {
        await createTransaction(payload);

        // === Update UI: Tambah ke riwayat ===
        const historyList = document.getElementById('hist-list');
        if (historyList) {
            const row = document.createElement('div');
            row.className = 'row-item';
            row.innerHTML = `
                <span style="font-size:10px;color:var(--text3);min-width:36px">${timeString}</span>
                <span style="flex:1">${customerName}</span>
                <span style="font-size:11px;color:var(--text2)">${servicesSummary}</span>
                <span style="font-size:11px;color:var(--text3);margin:0 7px">${state.paymentMethod}</span>
                <span style="font-weight:500">${formatRupiah(state.grandTotal)}</span>
            `;

            // Hapus teks 'Belum ada riwayat' jika ada
            if (historyList.innerHTML.includes('Belum ada riwayat')) {
                historyList.innerHTML = '';
            }
            historyList.prepend(row);
        }

        // Tambah ke data laporan lokal
        state.reportRows.unshift({
            time: timeString,
            name: customerName,
            svcs: servicesSummary,
            method: state.paymentMethod,
            isMember: !!foundMember,
            total: state.grandTotal,
        });

        // Update data member lokal
        if (foundMember) {
            foundMember.poin += pointsEarned;
            foundMember.total += 1;
            foundMember.spent += state.grandTotal;
        }

        // Reset form pembayaran
        resetPaymentForm();

        showToast('Pembayaran berhasil & tersimpan!');
        goPage('history', document.querySelectorAll('.ni')[5]);

    } catch (error) {
        alert(error.message);
    }
}

/**
 * Reset semua input dan state form pembayaran ke kondisi awal.
 */
function resetPaymentForm() {
    state.orderItems = [];
    state.grandTotal = 0;

    const fields = {
        'cust-name': '',
        'cash-in': '',
    };

    Object.entries(fields).forEach(([id, value]) => {
        const element = document.getElementById(id);
        if (element) element.value = value;
    });

    const hiddenElements = ['member-hint', 'change-row', 'poin-preview'];
    hiddenElements.forEach(id => {
        const element = document.getElementById(id);
        if (element) element.style.display = 'none';
    });

    renderOrderList();
}
