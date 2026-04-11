/**
 * =============================================================
 * api.js — Semua komunikasi AJAX ke server Laravel
 * =============================================================
 */

import { getRequestHeaders } from './utils.js';

/**
 * Mengirim request ke API dan menangani error secara konsisten.
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

    // --- BAGIAN YANG DIPERBAIKI ---
    const result = await response.json();

    // Jika respons dari Laravel dibungkus dalam properti 'data' (seperti yang kita buat di Controller),
    // kita langsung kembalikan isinya saja. Jika tidak, kembalikan utuh.
    return result.data !== undefined ? result.data : result;
}

// ==================== SERVICES API ====================

export async function createService(serviceData) {
    return apiRequest('/services', 'POST', serviceData);
}

export async function updateService(id, serviceData) {
    return apiRequest(`/services/${id}`, 'PUT', serviceData);
}

export async function deleteService(id) {
    return apiRequest(`/services/${id}`, 'DELETE');
}

// ==================== MEMBERS API ====================

export async function createMember(memberData) {
    return apiRequest('/members', 'POST', memberData);
}

// ==================== TRANSACTIONS API ====================

export async function createTransaction(transactionData) {
    return apiRequest('/transactions', 'POST', transactionData);
}