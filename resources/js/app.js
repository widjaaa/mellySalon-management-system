/**
 * =============================================================
 * app.js — Entry Point Aplikasi
 * =============================================================
 *
 * File ini adalah titik masuk utama yang:
 * 1. Import semua modul
 * 2. Expose fungsi ke window (agar onclick di HTML tetap berfungsi)
 * 3. Menunggu event DOMContentLoaded agar aman dieksekusi
 *
 * Struktur modul:
 *   app.js
 *   ├── modules/state.js        → State management terpusat
 *   ├── modules/utils.js        → Helper functions (toast, format Rupiah)
 *   ├── modules/api.js          → Semua AJAX/fetch calls
 *   ├── modules/navigation.js   → Navigasi antar halaman
 *   ├── modules/dashboard.js    → Chart & widgets dashboard
 *   ├── modules/payment.js      → Logika kasir/POS
 *   ├── modules/members.js      → CRUD member
 *   ├── modules/services.js     → CRUD layanan
 *   └── modules/reports.js      → Laporan & export
 */

import './bootstrap';

// ==================== Import Modul ====================
import { initializeState } from './modules/state.js';
import { showToast } from './modules/utils.js';
import { goPage, initDateDisplay } from './modules/navigation.js';
import { initDashboardChart } from './modules/dashboard.js';
import {
    populateServiceSelect,
    searchMember,
    addService as addServiceToOrder,
    removeOrderItem,
    selectPaymentMethod,
    calculateChange,
    setCashAmount,
    copyAccountNumber,
    processPayment,
} from './modules/payment.js';
import {
    renderMembers,
    renderMemberDatalist,
    filterMember,
    openMemberModal,
    closeMemberModal,
    saveMember,
} from './modules/members.js';
import {
    renderServicePage,
    setServiceCategory,
    openServiceModal,
    openEditService,
    closeServiceModal,
    saveService,
    openDeleteService,
    closeDeleteModal,
    confirmDeleteService,
} from './modules/services.js';
import {
    renderReport,
    setReportPeriod,
    exportCSV,
    printReport,
} from './modules/reports.js';

// ==================== Expose ke Window ====================
// Karena HTML menggunakan onclick="..." inline, fungsi harus
// dapat diakses dari window/global scope melalui SalonApp namespace.
// Ini lebih aman daripada langsung menaruh di window.

window.SalonApp = {
    // Navigasi
    goPage,

    // Payment
    searchMember,
    addService: addServiceToOrder,
    removeOrderItem,
    selectPaymentMethod,
    calculateChange,
    setCashAmount,
    copyAccountNumber,
    processPayment,

    // Members
    filterMember,
    openMemberModal,
    closeMemberModal,
    saveMember,

    // Services
    setServiceCategory,
    openServiceModal,
    openEditService,
    closeServiceModal,
    saveService,
    openDeleteService,
    closeDeleteModal,
    confirmDeleteService,

    // Reports
    setReportPeriod,
    exportCSV,
    printReport,

    // Utils
    showToast,
};

// ==================== Inisialisasi ====================
// Akan dipanggil oleh scripts.blade.php setelah data Laravel tersedia.
window.SalonApp.initialize = function (serverData) {
    // 1. Inisialisasi state dengan data dari server
    initializeState(serverData);

    // 2. Tampilkan tanggal hari ini
    initDateDisplay();

    // 3. Render chart dashboard
    initDashboardChart();

    // 4. Render data awal
    renderReport('harian');
    populateServiceSelect();
    renderMemberDatalist();

    // 5. Setup event listener modal (close on background click)
    setupModalBackgroundClose();

    console.log('✅ Melly Salon Management System berhasil dimuat.');
};

/**
 * Setup event listener untuk menutup modal saat background diklik.
 */
function setupModalBackgroundClose() {
    const modals = [
        { id: 'svc-modal', closeFn: closeServiceModal },
        { id: 'del-modal', closeFn: closeDeleteModal },
        { id: 'mem-modal', closeFn: closeMemberModal },
    ];

    modals.forEach(({ id, closeFn }) => {
        const modalElement = document.getElementById(id);
        if (modalElement) {
            modalElement.addEventListener('click', function (event) {
                if (event.target === this) closeFn();
            });
        }
    });
}
