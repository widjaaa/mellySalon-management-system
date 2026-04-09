/**
 * =============================================================
 * services.js — Logika halaman Kelola Layanan
 * =============================================================
 *
 * Menangani:
 * - Render grid layanan dengan filter kategori
 * - Form tambah & edit layanan (modal)
 * - Konfirmasi hapus layanan
 * - Statistik layanan (total, kategori, harga min/max)
 */

import { state } from './state.js';
import { formatRupiah, showToast } from './utils.js';
import { createService, updateService, deleteService } from './api.js';
import { populateServiceSelect } from './payment.js';

/** Warna badge untuk setiap kategori layanan */
const CATEGORY_COLORS = {
    Rambut:  { bg: '#FBEAF0', color: '#993556' },
    Wajah:   { bg: '#E6F1FB', color: '#185FA5' },
    Kuku:    { bg: '#EAF3DE', color: '#3B6D11' },
    Tubuh:   { bg: '#FAEEDA', color: '#633806' },
    Paket:   { bg: '#F1EFE8', color: '#444441' },
    Lainnya: { bg: '#FBEAF0', color: '#72243E' },
};

/**
 * Render seluruh halaman layanan: tabs, statistik, dan grid kartu layanan.
 */
export function renderServicePage() {
    renderServiceTabs();
    renderServiceStats();
    renderServiceGrid();
}

/**
 * Render tab filter kategori.
 */
function renderServiceTabs() {
    const tabsContainer = document.getElementById('svc-tabs');
    if (!tabsContainer) return;

    const allCategories = ['Semua', ...new Set(state.services.map(s => s.cat))];

    tabsContainer.innerHTML = allCategories.map(category => {
        const count = category === 'Semua'
            ? state.services.length
            : state.services.filter(s => s.cat === category).length;
        const isActive = category === state.activeServiceCategory;

        return `<button class="tab${isActive ? ' act' : ''}"
                    onclick="window.SalonApp.setServiceCategory('${category}', this)">
                    ${category} (${count})
                </button>`;
    }).join('');
}

/**
 * Render statistik ringkasan layanan (total, kategori, harga min/max).
 */
function renderServiceStats() {
    const filteredServices = state.activeServiceCategory === 'Semua'
        ? state.services
        : state.services.filter(s => s.cat === state.activeServiceCategory);

    // Update subtitle
    const subtitle = document.getElementById('svc-sub');
    if (subtitle) {
        const categoryCount = new Set(state.services.map(s => s.cat)).size;
        subtitle.textContent = state.activeServiceCategory === 'Semua'
            ? `${state.services.length} layanan dari ${categoryCount} kategori`
            : `${filteredServices.length} layanan di kategori ${state.activeServiceCategory}`;
    }

    // Update stat cards
    const prices = state.services.map(s => s.price);
    const stats = {
        'ss-total': state.services.length,
        'ss-cat': new Set(state.services.map(s => s.cat)).size,
        'ss-low': prices.length ? formatRupiah(Math.min(...prices)) : '—',
        'ss-high': prices.length ? formatRupiah(Math.max(...prices)) : '—',
    };

    Object.entries(stats).forEach(([id, value]) => {
        const element = document.getElementById(id);
        if (element) element.textContent = value;
    });
}

/**
 * Render grid kartu layanan berdasarkan filter kategori aktif.
 */
function renderServiceGrid() {
    const gridContainer = document.getElementById('svc-grid');
    if (!gridContainer) return;

    const filteredServices = state.activeServiceCategory === 'Semua'
        ? state.services
        : state.services.filter(s => s.cat === state.activeServiceCategory);

    if (!filteredServices.length) {
        gridContainer.innerHTML = `
            <div style="text-align:center;padding:2rem;color:var(--text3);font-size:12.5px;grid-column:1/-1">
                Belum ada layanan. Klik "+ Tambah Layanan".
            </div>
        `;
        return;
    }

    gridContainer.innerHTML = filteredServices.map(service => {
        const colors = CATEGORY_COLORS[service.cat] || CATEGORY_COLORS.Lainnya;

        return `
            <div class="svc-card">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px">
                    <div style="font-size:13px;font-weight:500">${service.name}</div>
                    <span class="svc-cat-pill" style="background:${colors.bg};color:${colors.color}">
                        ${service.cat}
                    </span>
                </div>
                ${service.desc ? `<div style="font-size:11px;color:var(--text2);line-height:1.5">${service.desc}</div>` : ''}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:2px">
                    <div>
                        <div class="svc-price">${formatRupiah(service.price)}</div>
                        ${service.dur ? `<div class="svc-dur">${service.dur} menit</div>` : ''}
                    </div>
                    <div style="display:flex;gap:5px">
                        <button class="btn-edit-sm" onclick="window.SalonApp.openEditService(${service.id})">Edit</button>
                        <button class="btn-del-sm" onclick="window.SalonApp.openDeleteService(${service.id})">Hapus</button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

/**
 * Mengubah filter kategori layanan.
 * @param {string} category - Kategori yang dipilih
 * @param {HTMLElement} element - Tombol tab yang diklik
 */
export function setServiceCategory(category, element) {
    state.activeServiceCategory = category;
    document.querySelectorAll('#svc-tabs .tab').forEach(tab => tab.classList.remove('act'));
    if (element) element.classList.add('act');
    renderServicePage();
}

// ==================== MODAL TAMBAH/EDIT ====================

/**
 * Membuka modal untuk menambah layanan baru.
 */
export function openServiceModal() {
    state.editServiceId = null;
    document.getElementById('svc-modal-title').textContent = 'Tambah Layanan Baru';

    // Reset semua field
    ['f-name', 'f-price', 'f-dur', 'f-desc'].forEach(id => {
        document.getElementById(id).value = '';
    });
    document.getElementById('f-cat').value = '';
    document.getElementById('svc-modal').classList.remove('hidden');

    setTimeout(() => document.getElementById('f-name').focus(), 50);
}

/**
 * Membuka modal untuk mengedit layanan yang ada.
 * @param {number} serviceId - ID layanan yang akan diedit
 */
export function openEditService(serviceId) {
    const service = state.services.find(s => s.id === serviceId);
    if (!service) return;

    state.editServiceId = serviceId;
    document.getElementById('svc-modal-title').textContent = 'Edit Layanan';
    document.getElementById('f-name').value = service.name;
    document.getElementById('f-cat').value = service.cat;
    document.getElementById('f-price').value = service.price;
    document.getElementById('f-dur').value = service.dur || '';
    document.getElementById('f-desc').value = service.desc || '';
    document.getElementById('svc-modal').classList.remove('hidden');
}

/**
 * Menutup modal layanan.
 */
export function closeServiceModal() {
    document.getElementById('svc-modal').classList.add('hidden');
    state.editServiceId = null;
}

/**
 * Menyimpan layanan (baru atau edit) ke database.
 */
export async function saveService() {
    const name = document.getElementById('f-name').value.trim();
    const category = document.getElementById('f-cat').value;
    const price = parseInt(document.getElementById('f-price').value) || 0;
    const duration = parseInt(document.getElementById('f-dur').value) || 0;
    const description = document.getElementById('f-desc').value.trim();

    // Validasi input
    if (!name) { alert('Nama layanan wajib diisi.'); return; }
    if (!category) { alert('Pilih kategori layanan.'); return; }
    if (!price) { alert('Harga wajib diisi.'); return; }

    const payload = { name, category, price, duration, description };

    try {
        if (state.editServiceId) {
            // Mode edit
            await updateService(state.editServiceId, payload);
            const index = state.services.findIndex(s => s.id === state.editServiceId);
            if (index >= 0) {
                state.services[index] = {
                    ...state.services[index],
                    name, cat: category, price, dur: duration, desc: description,
                };
            }
            showToast('Layanan berhasil diperbarui');
        } else {
            // Mode tambah baru
            const data = await createService(payload);
            state.services.push({
                id: data.id, name, cat: category, price, dur: duration, desc: description,
            });
            showToast('Layanan baru berhasil ditambahkan');
        }

        closeServiceModal();
        renderServicePage();
        populateServiceSelect();

    } catch (error) {
        alert('Gagal menyimpan layanan: ' + error.message);
    }
}

// ==================== MODAL HAPUS ====================

/**
 * Membuka modal konfirmasi hapus layanan.
 * @param {number} serviceId - ID layanan yang akan dihapus
 */
export function openDeleteService(serviceId) {
    state.deleteServiceId = serviceId;
    const service = state.services.find(s => s.id === serviceId);
    document.getElementById('del-name').textContent = service ? service.name : 'layanan ini';
    document.getElementById('del-modal').classList.remove('hidden');
}

/**
 * Menutup modal konfirmasi hapus.
 */
export function closeDeleteModal() {
    document.getElementById('del-modal').classList.add('hidden');
    state.deleteServiceId = null;
}

/**
 * Mengkonfirmasi penghapusan layanan dan mengirim ke server.
 */
export async function confirmDeleteService() {
    if (!state.deleteServiceId) return;

    try {
        await deleteService(state.deleteServiceId);
        state.services = state.services.filter(s => s.id !== state.deleteServiceId);

        closeDeleteModal();

        // Reset filter jika kategori yang aktif sudah tidak ada layanan
        if (state.activeServiceCategory !== 'Semua' &&
            !state.services.find(s => s.cat === state.activeServiceCategory)) {
            state.activeServiceCategory = 'Semua';
        }

        renderServicePage();
        populateServiceSelect();
        showToast('Layanan berhasil dihapus');

    } catch (error) {
        alert('Gagal menghapus layanan: ' + error.message);
    }
}
