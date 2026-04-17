/**
 * =============================================================
 * state.js — State (data) management terpusat
 * =============================================================
 */

const state = {
    /** @type {Array<Object>} Daftar layanan dari database */
    services: [],

    /** @type {Array<Object>} Daftar member dari database */
    members: [],

    /** @type {Array<Object>} Riwayat transaksi dari database */
    transactions: [],

    /** @type {Array<Object>} Item pesanan dalam transaksi aktif */
    orderItems: [],

    /** @type {string} Metode pembayaran yang dipilih */
    paymentMethod: 'Tunai',

    /** @type {number} Total yang harus dibayar */
    grandTotal: 0,

    /** @type {number} Subtotal sebelum diskon */
    subtotal: 0,

    /** @type {number} Jumlah diskon */
    discountAmount: 0,

    /** @type {string} Kategori layanan yang aktif di filter */
    activeServiceCategory: 'Semua',

    /** @type {number|null} ID layanan yang sedang di-edit */
    editServiceId: null,

    /** @type {number|null} ID layanan yang akan dihapus */
    deleteServiceId: null,

    /** @type {number|null} ID member yang sedang di-edit */
    editMemberId: null,

    /** @type {number|null} ID member yang akan dihapus */
    deleteMemberId: null,

    /** @type {string} Periode laporan aktif */
    reportPeriod: 'harian',

    /** @type {Object|null} Data performa dashboard */
    performanceData: null,

    /** @type {Object|null} Data laporan */
    reportData: null,
};

/**
 * Inisialisasi state dengan data dari server (Laravel).
 */
export function initializeState(serverData) {
    state.services = serverData.services.map(service => ({
        id: service.id,
        name: service.name,
        cat: service.category,
        price: service.price,
        dur: service.duration,
        desc: service.description,
    }));

    state.members = serverData.members.map(member => ({
        id: member.id,
        name: member.name,
        initials: member.name
            ? member.name.split(' ').map(word => word ? word[0] : '').join('').toUpperCase().slice(0, 2)
            : 'M',
        tier: member.tier || 'Bronze',
        poin: member.poin || 0,
        total: member.total_visits || 0,
        spent: member.total_spent || 0,
        bday: member.bday || '',
        phone: member.phone || '',
    }));
}

export { state };
