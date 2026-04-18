/**
 * =============================================================
 * navigation.js — Navigasi antar halaman (SPA-style)
 * =============================================================
 */

import { renderMembers, renderMemberDatalist } from './members.js';
import { renderServicePage } from './services.js';
import { renderReport } from './reports.js';
import { loadTransactionHistory } from './invoice.js';

const PAGE_TITLES = {
    dashboard: 'Dashboard',
    payment: 'Pembayaran',
    members: 'Data Member',
    services: 'Kelola Layanan',
    report: 'Laporan & Rekapitulasi',
    history: 'Riwayat Transaksi',
};

/**
 * Navigasi ke halaman tertentu.
 */
export function goPage(pageId, navItem) {
    // Hide all pages
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));

    // Show target page
    const targetPage = document.getElementById('page-' + pageId);
    if (targetPage) {
        targetPage.classList.add('active');
        // Add fade-in animation
        targetPage.classList.remove('animate-fade-in-up');
        void targetPage.offsetWidth; // trigger reflow
        targetPage.classList.add('animate-fade-in-up');
    }

    // Update nav active state
    if (navItem) {
        document.querySelectorAll('.ni').forEach(n => n.classList.remove('active'));
        navItem.classList.add('active');

        // Auto close mobile sidebar
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (sidebar && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            if (overlay) overlay.classList.remove('active');
        }
    }

    // Update page title
    const titleEl = document.getElementById('pg-title');
    if (titleEl) titleEl.textContent = PAGE_TITLES[pageId] || pageId;

    // Lazy-load data per halaman
    switch (pageId) {
        case 'members':
            renderMembers();
            break;
        case 'services':
            renderServicePage();
            break;
        case 'report':
            renderReport('harian');
            break;
        case 'history':
            loadTransactionHistory();
            break;
    }
}

/**
 * Tampilkan tanggal hari ini di topbar chip.
 */
export function initDateDisplay() {
    const dateChip = document.getElementById('date-chip');
    if (!dateChip) return;

    const now = new Date();
    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    const formatted = now.toLocaleDateString('id-ID', options);

    // Replace inner text (keep SVG icon)
    const svg = dateChip.querySelector('svg');
    dateChip.textContent = '';
    if (svg) dateChip.appendChild(svg);
    dateChip.appendChild(document.createTextNode(' ' + formatted));
}

/**
 * Toggle sidebar di mobile.
 */
export function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (sidebar) sidebar.classList.toggle('open');
    if (overlay) overlay.classList.toggle('active');
}
