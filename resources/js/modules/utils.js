/**
 * =============================================================
 * utils.js — Fungsi utilitas yang dipakai di seluruh aplikasi
 * =============================================================
 *
 * Berisi helper functions seperti format Rupiah, CSRF token,
 * dan notifikasi toast.
 */

/**
 * Mengambil CSRF token dari meta tag untuk keamanan AJAX requests.
 * @returns {string} CSRF token value
 */
export function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/**
 * Membuat headers standar untuk semua AJAX requests.
 * @returns {Object} Headers object dengan Content-Type, CSRF, dan Accept
 */
export function getRequestHeaders() {
    return {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
        'Accept': 'application/json',
    };
}

/**
 * Format angka menjadi format Rupiah Indonesia.
 * @param {number} amount - Jumlah yang akan diformat
 * @returns {string} Format Rupiah, contoh: "Rp 50.000"
 */
export function formatRupiah(amount) {
    return 'Rp ' + Number(amount).toLocaleString('id-ID');
}

/**
 * Menampilkan notifikasi toast di pojok kanan bawah layar.
 * Toast akan hilang otomatis setelah 2.8 detik.
 * @param {string} message - Pesan yang ditampilkan
 */
export function showToast(message) {
    const toast = document.getElementById('toast');
    if (!toast) return;

    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2800);
}
