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

    const result = await response.json();
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
    return apiRequest(`/transactions/${id}`);
}

// ==================== REPORTS API ====================

export async function fetchReportData(period = 'harian') {
    return apiRequest(`/reports?period=${period}`);
}

export async function fetchPerformanceData() {
    return apiRequest('/reports/performance');
}