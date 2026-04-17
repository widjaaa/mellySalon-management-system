/**
 * =============================================================
 * utils.js — Helper functions
 * =============================================================
 */

/**
 * Format angka ke format Rupiah Indonesia.
 * @param {number} num - Angka yang akan diformat
 * @returns {string} String format Rupiah
 */
export function formatRupiah(num) {
    if (num === null || num === undefined) return 'Rp 0';
    return 'Rp ' + num.toLocaleString('id-ID');
}

/**
 * Tampilkan toast notification.
 * @param {string} message - Pesan yang ditampilkan
 * @param {string} type - Tipe toast: 'success', 'error', 'info'
 */
export function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    if (!toast) return;

    // Set color based on type
    toast.className = 'fixed bottom-5 right-5 px-5 py-3 rounded-xl text-sm font-medium shadow-xl transition-all duration-300 z-[999]';
    switch (type) {
        case 'error':
            toast.classList.add('bg-red-600', 'text-white');
            break;
        case 'info':
            toast.classList.add('bg-blue-600', 'text-white');
            break;
        default:
            toast.classList.add('bg-gray-800', 'text-white');
    }

    toast.textContent = message;
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';

    clearTimeout(toast._timeout);
    toast._timeout = setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(8px)';
    }, 3000);
}

/**
 * Mendapatkan headers untuk request ke Laravel API.
 */
export function getRequestHeaders() {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    return {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': token || '',
        'X-Requested-With': 'XMLHttpRequest',
    };
}

/**
 * Format tanggal ke format Indonesia.
 * @param {string} dateString - ISO date string
 * @returns {string} Formatted date
 */
export function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
}

/**
 * Format waktu dari ISO string.
 * @param {string} dateString - ISO date string
 * @returns {string} HH:MM format
 */
export function formatTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
    });
}
