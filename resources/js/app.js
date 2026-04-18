/**
 * =============================================================
 * app.js — Entry Point Aplikasi
 * =============================================================
 */

import './bootstrap';

// ==================== Import Modul ====================
import { initializeState } from './modules/state.js';
import { showToast } from './modules/utils.js';
import { goPage, initDateDisplay, toggleSidebar } from './modules/navigation.js';
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
    confirmQrisPayment,
    cancelQrisPayment,
} from './modules/payment.js';
import {
    renderMembers,
    renderMemberDatalist,
    filterMember,
    openMemberModal,
    openEditMember,
    closeMemberModal,
    saveMember,
    openDeleteMember,
    closeDeleteMemberModal,
    confirmDeleteMember,
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
import {
    loadTransactionHistory,
    searchTransactionHistory,
    filterTransactionStatus,
    histPrevPage,
    histNextPage,
    openVoidModal,
    closeVoidModal,
    confirmVoidTransaction,
    printInvoice,
} from './modules/invoice.js';

// ==================== Expose ke Window ====================
window.SalonApp = {
    // Navigasi
    goPage,
    toggleSidebar,

    // Payment
    searchMember,
    addService: addServiceToOrder,
    removeOrderItem,
    selectPaymentMethod,
    calculateChange,
    setCashAmount,
    copyAccountNumber,
    processPayment,
    confirmQrisPayment,
    cancelQrisPayment,

    // Members
    filterMember,
    openMemberModal,
    openEditMember,
    closeMemberModal,
    saveMember,
    openDeleteMember,
    closeDeleteMemberModal,
    confirmDeleteMember,

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

    // Invoice & Riwayat
    printInvoice,
    loadTransactionHistory,
    searchTransactionHistory,
    filterTransactionStatus,
    histPrevPage,
    histNextPage,

    // Void Transaksi
    openVoidModal,
    closeVoidModal,
    confirmVoidTransaction,

    // Utils
    showToast,
};

// ==================== Inisialisasi ====================
window.SalonApp.initialize = function (serverData) {
    // 1. Inisialisasi state dengan data dari server
    initializeState(serverData);

    // 2. Tampilkan tanggal hari ini
    initDateDisplay();

    // 3. Render chart dashboard (async - loads from API)
    initDashboardChart();

    // 4. Render data awal
    populateServiceSelect();
    renderMemberDatalist();

    // 5. Setup event listener modal
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
        { id: 'del-mem-modal', closeFn: closeDeleteMemberModal },
        { id: 'void-trx-modal', closeFn: closeVoidModal },
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
