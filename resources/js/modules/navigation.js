/**
 * =============================================================
 * navigation.js — Navigasi antar halaman (SPA-style)
 * =============================================================
 *
 * Menangani navigasi antar "halaman" (div yang disembunyikan/ditampilkan)
 * dan update tanggal di topbar.
 */

import { renderReport } from './reports.js';
import { renderMembers, renderMemberDatalist } from './members.js';
import { renderServicePage } from './services.js';
import { populateServiceSelect } from './payment.js';
import { state } from './state.js';

/** Daftar nama halaman yang tersedia */
const PAGE_IDS = ['dashboard', 'payment', 'members', 'services', 'report', 'history'];

/** Mapping ID halaman ke judul yang ditampilkan di topbar */
const PAGE_TITLES = {
    dashboard: 'Dashboard',
    payment: 'Pembayaran',
    members: 'Data Member',
    services: 'Kelola Layanan',
    report: 'Laporan',
    history: 'Riwayat Transaksi',
};

/**
 * Berpindah ke halaman tertentu.
 *
 * @param {string} pageId - ID halaman tujuan (misal: 'dashboard', 'payment')
 * @param {HTMLElement|null} navElement - Elemen navigasi yang diklik (untuk highlight aktif)
 */
export function goPage(pageId, navElement) {
    // Toggle visibility halaman
    PAGE_IDS.forEach(id => {
        const page = document.getElementById('page-' + id);
        if (page) page.classList.toggle('active', id === pageId);
    });

    // Update judul di topbar
    const titleElement = document.getElementById('pg-title');
    if (titleElement) {
        titleElement.textContent = PAGE_TITLES[pageId] || pageId;
    }

    // Update highlight navigasi sidebar
    const navItems = document.querySelectorAll('.ni');
    navItems.forEach(item => item.classList.remove('active'));
    if (navElement) navElement.classList.add('active');

    // Trigger render khusus untuk halaman tertentu
    if (pageId === 'report') renderReport('harian');
    if (pageId === 'members') renderMembers('all');
    if (pageId === 'services') {
        state.activeServiceCategory = 'Semua';
        renderServicePage();
    }
    if (pageId === 'payment') populateServiceSelect();
}

/**
 * Menampilkan tanggal hari ini di chip topbar.
 * Format: "Senin, 9 Apr 2026"
 */
export function initDateDisplay() {
    const DAY_NAMES = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const MONTH_NAMES = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    const now = new Date();
    const dateChip = document.getElementById('date-chip');
    if (dateChip) {
        dateChip.textContent = `${DAY_NAMES[now.getDay()]}, ${now.getDate()} ${MONTH_NAMES[now.getMonth()]} ${now.getFullYear()}`;
    }
}
