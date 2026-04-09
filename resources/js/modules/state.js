/**
 * =============================================================
 * state.js — State (data) management terpusat
 * =============================================================
 *
 * Menggantikan variabel global yang berserakan.
 * Semua data aplikasi disimpan di satu objek,
 * sehingga mudah dilacak dan di-debug.
 */

/**
 * State global aplikasi.
 * Diakses oleh modul lain via import { state } from './state.js'
 */
const state = {
    /** @type {Array<Object>} Daftar layanan dari database */
    services: [],

    /** @type {Array<Object>} Daftar member dari database */
    members: [],

    /** @type {Array<Object>} Item pesanan dalam transaksi aktif */
    orderItems: [],

    /** @type {Array<Object>} Data laporan transaksi (session ini) */
    reportRows: [],

    /** @type {string} Metode pembayaran yang dipilih */
    paymentMethod: 'Tunai',

    /** @type {number} Total yang harus dibayar */
    grandTotal: 0,

    /** @type {string} Kategori layanan yang aktif di filter */
    activeServiceCategory: 'Semua',

    /** @type {number|null} ID layanan yang sedang di-edit */
    editServiceId: null,

    /** @type {number|null} ID layanan yang akan dihapus */
    deleteServiceId: null,
};

/**
 * Inisialisasi state dengan data dari server (Laravel).
 * Dipanggil sekali saat aplikasi pertama kali dimuat.
 *
 * @param {Object} serverData - Data dari Laravel @json()
 * @param {Array} serverData.services - Data layanan dari database
 * @param {Array} serverData.members - Data member dari database
 */
export function initializeState(serverData) {
    // Map data layanan dari format database ke format frontend
    state.services = serverData.services.map(service => ({
        id: service.id,
        name: service.name,
        cat: service.category,
        price: service.price,
        dur: service.duration,
        desc: service.description,
    }));

    // Map data member dari format database ke format frontend
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
