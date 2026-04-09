/**
 * =============================================================
 * api.js — Semua komunikasi AJAX ke server Laravel
 * =============================================================
 *
 * Memusatkan semua fetch() calls di satu tempat agar:
 * - Mudah di-debug (satu tempat untuk cek error)
 * - Konsisten error handling
 * - Mudah diganti ke axios jika diperlukan nanti
 */

import { getRequestHeaders } from './utils.js';

/**
 * Mengirim request ke API dan menangani error secara konsisten.
 * @param {string} url - URL endpoint
 * @param {string} method - HTTP method (GET, POST, PUT, DELETE)
 * @param {Object|null} body - Request body (akan di-JSON.stringify)
 * @returns {Promise<Object>} Response data dari server
 * @throws {Error} Jika response tidak OK
 */
async function apiRequest(url, method = 'GET', body = null) {
    const options = {
        method,
        headers: getRequestHeaders(),
    };

    if (body && method !== 'GET') {
        options.body = JSON.stringify(body);
    }

    const response = await fetch(url, options);

    if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        const message = errorData.message || `Request gagal (${response.status})`;
        throw new Error(message);
    }

    return response.json();
}

// ==================== SERVICES API ====================

/**
 * Membuat layanan baru.
 * @param {Object} serviceData - Data layanan {name, category, price, duration, description}
 * @returns {Promise<Object>} Data layanan yang baru dibuat (termasuk id)
 */
export async function createService(serviceData) {
    return apiRequest('/services', 'POST', serviceData);
}

/**
 * Memperbarui layanan yang sudah ada.
 * @param {number} id - ID layanan yang akan diupdate
 * @param {Object} serviceData - Data layanan yang diperbarui
 * @returns {Promise<Object>} Data layanan yang telah diperbarui
 */
export async function updateService(id, serviceData) {
    return apiRequest(`/services/${id}`, 'PUT', serviceData);
}

/**
 * Menghapus layanan berdasarkan ID.
 * @param {number} id - ID layanan yang akan dihapus
 * @returns {Promise<Object>} Response sukses dari server
 */
export async function deleteService(id) {
    return apiRequest(`/services/${id}`, 'DELETE');
}

// ==================== MEMBERS API ====================

/**
 * Membuat member baru.
 * @param {Object} memberData - Data member {name, phone, bday, tier}
 * @returns {Promise<Object>} Data member yang baru dibuat (termasuk id)
 */
export async function createMember(memberData) {
    return apiRequest('/members', 'POST', memberData);
}

// ==================== TRANSACTIONS API ====================

/**
 * Membuat transaksi pembayaran baru.
 * @param {Object} transactionData - Data transaksi
 * @returns {Promise<Object>} Response termasuk transaction data dan total
 */
export async function createTransaction(transactionData) {
    return apiRequest('/transactions', 'POST', transactionData);
}
