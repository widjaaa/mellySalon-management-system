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

    return await response.json();
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

export async function updateMember(id, memberData) {
    return apiRequest(`/members/${id}`, 'PUT', memberData);
}

export async function deleteMember(id) {
    return apiRequest(`/members/${id}`, 'DELETE');
}

// ==================== TRANSACTIONS API ====================

export async function createTransaction(transactionData) {
    return apiRequest('/transactions', 'POST', transactionData);
}

export async function fetchTransactions(params = {}) {
    const query = new URLSearchParams(params).toString();
    const url = query ? `/transactions?${query}` : '/transactions';
    return apiRequest(url);
}

export async function fetchTransactionDetail(id) {
    const result = await apiRequest(`/transactions/${id}`);
    return result.data !== undefined ? result.data : result;
}

export async function voidTransaction(id) {
    return apiRequest(`/transactions/${id}/void`, 'PATCH');
}

// ==================== REPORTS API ====================

export async function fetchReportData(period = 'harian') {
    const result = await apiRequest(`/reports?period=${period}`);
    return result.data !== undefined ? result.data : result;
}

export async function fetchPerformanceData() {
    const result = await apiRequest(`/reports/performance`);
    return result.data !== undefined ? result.data : result;
}