/**
 * =============================================================
 * payment.js — Logika halaman Pembayaran (Point of Sales)
 * =============================================================
 */

import { state } from './state.js';
import { formatRupiah, showToast } from './utils.js';
import { createTransaction } from './api.js';
import { goPage } from './navigation.js';
import { loadTransactionHistory } from './invoice.js';

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
        quantity: 1,
    });

    selectElement.value = '';
    renderOrderList();
}

/**
 * Menghapus item dari daftar pesanan berdasarkan index.
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

    if (state.orderItems.length === 0) {
        listElement.innerHTML = '';
        updateTotals();
        return;
    }

    listElement.innerHTML = state.orderItems.map((item, index) => `
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 group hover:border-gray-200 transition-colors">
            <div class="flex-1">
                <span class="text-sm font-medium text-gray-800">${item.name}</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-gray-700">${formatRupiah(item.price)}</span>
                <button onclick="window.SalonApp.removeOrderItem(${index})"
                    class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    `).join('');

    updateTotals();
}

/**
 * Menghitung ulang subtotal, diskon member, grand total.
 */
function updateTotals() {
    const subtotal = state.orderItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    const customerName = document.getElementById('cust-name').value.toLowerCase();
    const foundMember = customerName.length >= 2
        ? state.members.find(member => member.name.toLowerCase().includes(customerName))
        : null;

    const discountPercent = foundMember
        ? (foundMember.tier === 'Gold' ? 10 : foundMember.tier === 'Silver' ? 5 : 0)
        : 0;
    const discountAmount = Math.round(subtotal * discountPercent / 100);
    state.subtotal = subtotal;
    state.discountAmount = discountAmount;
    state.grandTotal = subtotal - discountAmount;

    // Update subtotal display
    const subtotalRow = document.getElementById('order-subtotal');
    if (subtotalRow) {
        subtotalRow.classList.toggle('hidden', !state.orderItems.length);
        subtotalRow.classList.toggle('flex', state.orderItems.length > 0);
    }
    const subtotalValue = document.getElementById('sub-val');
    if (subtotalValue) subtotalValue.textContent = formatRupiah(subtotal);

    // Update discount & grand total
    const discountRow = document.getElementById('disc-row');
    const grandVal = document.getElementById('grand-val');

    if (discountAmount > 0 && state.orderItems.length) {
        if (discountRow) {
            discountRow.classList.remove('hidden');
            discountRow.classList.add('flex');
            document.getElementById('disc-val').textContent = '-' + formatRupiah(discountAmount);
        }
    } else {
        if (discountRow) {
            discountRow.classList.add('hidden');
            discountRow.classList.remove('flex');
        }
    }

    if (grandVal) grandVal.textContent = formatRupiah(state.grandTotal);

    // Update poin preview
    const poinPreview = document.getElementById('poin-preview');
    if (poinPreview) {
        if (state.orderItems.length && foundMember) {
            const pointsToEarn = Math.floor(state.grandTotal / 1000);
            poinPreview.classList.remove('hidden');
            poinPreview.textContent = `Member akan mendapat +${pointsToEarn.toLocaleString('id-ID')} poin dari transaksi ini`;
        } else {
            poinPreview.classList.add('hidden');
        }
    }
}

/**
 * Memilih metode pembayaran.
 */
export function selectPaymentMethod(element, method) {
    document.querySelectorAll('.pm').forEach(btn => {
        btn.classList.remove('sel', 'border-brand-purple', 'bg-brand-purple-light', 'text-brand-purple-dark');
        btn.classList.add('border-gray-200', 'bg-white', 'text-gray-600');
    });
    element.classList.add('sel', 'border-brand-purple', 'bg-brand-purple-light', 'text-brand-purple-dark');
    element.classList.remove('border-gray-200', 'bg-white', 'text-gray-600');
    state.paymentMethod = method;

    const sections = { 'Tunai': 'cash-section', 'QRIS': 'qris-section', 'Transfer': 'transfer-section' };
    Object.entries(sections).forEach(([key, id]) => {
        const section = document.getElementById(id);
        if (section) {
            section.classList.toggle('hidden', key !== method);
        }
    });

    if (method === 'Tunai') calculateChange();
}

/**
 * Menghitung kembalian.
 */
export function calculateChange() {
    const receivedAmount = parseInt(document.getElementById('cash-in').value) || 0;
    const changeRow = document.getElementById('change-row');
    if (!changeRow) return;

    if (receivedAmount > 0 && state.grandTotal > 0) {
        changeRow.classList.remove('hidden');
        changeRow.classList.add('flex');
        const changeValue = document.getElementById('change-v');
        if (changeValue) {
            const change = Math.max(0, receivedAmount - state.grandTotal);
            changeValue.textContent = formatRupiah(change);
            changeValue.classList.toggle('text-red-500', receivedAmount < state.grandTotal);
            changeValue.classList.toggle('text-green-600', receivedAmount >= state.grandTotal);
        }
    } else {
        changeRow.classList.add('hidden');
        changeRow.classList.remove('flex');
    }
}

/**
 * Set jumlah uang tunai.
 */
export function setCashAmount(value) {
    const cashInput = document.getElementById('cash-in');
    if (!cashInput) return;
    cashInput.value = value === 'pas' ? state.grandTotal : value;
    calculateChange();
}

/**
 * Menyalin nomor rekening.
 */
export function copyAccountNumber(accountNumber) {
    navigator.clipboard.writeText(accountNumber);
    showToast('Nomor Rekening ' + accountNumber + ' disalin!');
}

/**
 * Memproses pembayaran.
 */
export async function processPayment() {
    if (!state.orderItems.length) {
        showToast('Tambahkan layanan terlebih dahulu.', 'error');
        return;
    }

    const customerName = document.getElementById('cust-name').value.trim() || 'Pelanggan';
    const servicesSummary = state.orderItems.map(item => item.name).join(' + ');

    const nameLower = customerName.toLowerCase();
    const foundMember = state.members.find(
        member => member.name.toLowerCase().includes(nameLower)
    );
    const pointsEarned = foundMember ? Math.floor(state.grandTotal / 1000) : 0;

    // Cash validation
    let cashReceived = null;
    let cashChange = null;
    if (state.paymentMethod === 'Tunai') {
        cashReceived = parseInt(document.getElementById('cash-in').value) || 0;
        if (cashReceived < state.grandTotal) {
            showToast('Uang yang diterima kurang dari total pembayaran.', 'error');
            return;
        }
        cashChange = cashReceived - state.grandTotal;
    }

    const payload = {
        member_id: foundMember ? foundMember.id : null,
        customer_name: customerName,
        services_summary: servicesSummary,
        subtotal: state.subtotal,
        discount_amount: state.discountAmount,
        total_amount: state.grandTotal,
        payment_method: state.paymentMethod,
        cash_received: cashReceived,
        cash_change: cashChange,
        poin_awarded: pointsEarned,
        items: state.orderItems.map(item => ({
            service_name: item.name,
            service_price: item.price,
            quantity: item.quantity || 1,
        })),
    };

    try {
        const result = await createTransaction(payload);

        // Update member data locally
        if (foundMember) {
            foundMember.poin += pointsEarned;
            foundMember.total += 1;
            foundMember.spent += state.grandTotal;
        }

        resetPaymentForm();
        showToast('Pembayaran berhasil! Invoice: ' + (result.transaction?.invoice_number || ''));

        // Reload transaction history
        loadTransactionHistory();

        // Navigate to history
        goPage('history', document.querySelectorAll('.ni')[5]);

    } catch (error) {
        showToast(error.message, 'error');
    }
}

/**
 * Reset form pembayaran.
 */
function resetPaymentForm() {
    state.orderItems = [];
    state.grandTotal = 0;
    state.subtotal = 0;
    state.discountAmount = 0;

    const fields = { 'cust-name': '', 'cash-in': '' };
    Object.entries(fields).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (el) el.value = value;
    });

    const hiddenElements = ['member-hint', 'poin-preview'];
    hiddenElements.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.add('hidden');
    });

    document.getElementById('order-list').innerHTML = '';
    const grandVal = document.getElementById('grand-val');
    if (grandVal) grandVal.textContent = 'Rp 0';

    const subRow = document.getElementById('order-subtotal');
    if (subRow) { subRow.classList.add('hidden'); subRow.classList.remove('flex'); }

    const discRow = document.getElementById('disc-row');
    if (discRow) { discRow.classList.add('hidden'); discRow.classList.remove('flex'); }

    const changeRow = document.getElementById('change-row');
    if (changeRow) { changeRow.classList.add('hidden'); changeRow.classList.remove('flex'); }
}
