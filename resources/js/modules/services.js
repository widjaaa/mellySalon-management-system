/**
 * =============================================================
 * services.js — CRUD layanan
 * =============================================================
 */

import { state } from './state.js';
import { formatRupiah, showToast } from './utils.js';
import { createService, updateService, deleteService } from './api.js';
import { populateServiceSelect } from './payment.js';

const CATEGORY_COLORS = {
    Rambut:  { bg: 'bg-pink-50', text: 'text-pink-700', border: 'border-pink-200' },
    Wajah:   { bg: 'bg-blue-50', text: 'text-blue-700', border: 'border-blue-200' },
    Kuku:    { bg: 'bg-green-50', text: 'text-green-700', border: 'border-green-200' },
    Tubuh:   { bg: 'bg-amber-50', text: 'text-amber-700', border: 'border-amber-200' },
    Paket:   { bg: 'bg-gray-50', text: 'text-gray-700', border: 'border-gray-200' },
    Lainnya: { bg: 'bg-purple-50', text: 'text-purple-700', border: 'border-purple-200' },
};

/**
 * Render halaman layanan lengkap.
 */
export function renderServicePage() {
    renderServiceStats();
    renderServiceTabs();
    renderServiceGrid();
}

/**
 * Render statistik layanan.
 */
function renderServiceStats() {
    const services = state.services;
    const cats = [...new Set(services.map(s => s.cat).filter(Boolean))];
    const prices = services.map(s => s.price).filter(p => p > 0);

    const total = document.getElementById('ss-total');
    const cat = document.getElementById('ss-cat');
    const low = document.getElementById('ss-low');
    const high = document.getElementById('ss-high');

    if (total) total.textContent = services.length;
    if (cat) cat.textContent = cats.length;
    if (low) low.textContent = prices.length ? formatRupiah(Math.min(...prices)) : '—';
    if (high) high.textContent = prices.length ? formatRupiah(Math.max(...prices)) : '—';

    const sub = document.getElementById('svc-sub');
    if (sub) sub.textContent = `${services.length} layanan tersedia dalam ${cats.length} kategori`;
}

/**
 * Render tab filter kategori.
 */
function renderServiceTabs() {
    const container = document.getElementById('svc-tabs');
    if (!container) return;

    const cats = ['Semua', ...new Set(state.services.map(s => s.cat).filter(Boolean))];

    container.innerHTML = cats.map(cat => {
        const isActive = cat === state.activeServiceCategory;
        const activeClass = isActive
            ? 'bg-brand-purple text-white border-brand-purple'
            : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50';
        return `<button class="px-4 py-2 text-xs font-bold rounded-full border transition-all cursor-pointer ${activeClass}" onclick="SalonApp.setServiceCategory('${cat}',this)">${cat}</button>`;
    }).join('');
}

/**
 * Render grid kartu layanan.
 */
function renderServiceGrid() {
    const container = document.getElementById('svc-grid');
    if (!container) return;

    const filtered = state.activeServiceCategory === 'Semua'
        ? state.services
        : state.services.filter(s => s.cat === state.activeServiceCategory);

    if (filtered.length === 0) {
        container.innerHTML = `
            <div class="col-span-full text-center py-16">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Tidak ada layanan dalam kategori ini.</p>
            </div>`;
        return;
    }

    container.innerHTML = filtered.map(service => {
        const color = CATEGORY_COLORS[service.cat] || CATEGORY_COLORS.Lainnya;
        return `
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex items-start justify-between mb-3">
                <span class="px-3 py-1 text-[10px] font-bold rounded-full ${color.bg} ${color.text}">${service.cat || 'Lainnya'}</span>
                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button onclick="SalonApp.openEditService(${service.id})" class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Edit">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button onclick="SalonApp.openDeleteService(${service.id})" class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors" title="Hapus">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
            <h4 class="font-bold text-gray-800 mb-1">${service.name}</h4>
            ${service.desc ? `<p class="text-xs text-gray-500 mb-3 line-clamp-2">${service.desc}</p>` : '<div class="mb-3"></div>'}
            <div class="flex items-center justify-between">
                <span class="text-lg font-bold text-brand-purple">${formatRupiah(service.price)}</span>
                ${service.dur ? `<span class="text-xs text-gray-400 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>${service.dur} menit</span>` : ''}
            </div>
        </div>`;
    }).join('');
}

/**
 * Set kategori layanan aktif.
 */
export function setServiceCategory(cat, element) {
    state.activeServiceCategory = cat;
    renderServiceTabs();
    renderServiceGrid();
}

/**
 * Buka modal tambah layanan.
 */
export function openServiceModal() {
    state.editServiceId = null;
    document.getElementById('svc-modal-title').textContent = 'Tambah Layanan Baru';
    document.getElementById('f-name').value = '';
    document.getElementById('f-cat').value = '';
    document.getElementById('f-price').value = '';
    document.getElementById('f-dur').value = '';
    document.getElementById('f-desc').value = '';
    document.getElementById('svc-modal').classList.remove('hidden');
}

/**
 * Buka modal edit layanan.
 */
export function openEditService(id) {
    const service = state.services.find(s => s.id === id);
    if (!service) return;

    state.editServiceId = id;
    document.getElementById('svc-modal-title').textContent = 'Edit Layanan';
    document.getElementById('f-name').value = service.name;
    document.getElementById('f-cat').value = service.cat || '';
    document.getElementById('f-price').value = service.price;
    document.getElementById('f-dur').value = service.dur || '';
    document.getElementById('f-desc').value = service.desc || '';
    document.getElementById('svc-modal').classList.remove('hidden');
}

/**
 * Tutup modal layanan.
 */
export function closeServiceModal() {
    document.getElementById('svc-modal').classList.add('hidden');
    state.editServiceId = null;
}

/**
 * Simpan layanan (baru atau edit).
 */
export async function saveService() {
    const name = document.getElementById('f-name').value.trim();
    const category = document.getElementById('f-cat').value;
    const price = parseInt(document.getElementById('f-price').value) || 0;
    const duration = parseInt(document.getElementById('f-dur').value) || null;
    const description = document.getElementById('f-desc').value.trim();

    if (!name || !price) {
        showToast('Nama dan harga layanan harus diisi.', 'error');
        return;
    }

    const serviceData = { name, category, price, duration, description };

    try {
        if (state.editServiceId) {
            const updated = await updateService(state.editServiceId, serviceData);
            const idx = state.services.findIndex(s => s.id === state.editServiceId);
            if (idx !== -1) {
                state.services[idx] = {
                    id: state.editServiceId,
                    name: updated.name || name,
                    cat: updated.category || category,
                    price: updated.price || price,
                    dur: updated.duration || duration,
                    desc: updated.description || description,
                };
            }
            showToast('Layanan berhasil diperbarui!');
        } else {
            const created = await createService(serviceData);
            state.services.push({
                id: created.id,
                name: created.name || name,
                cat: created.category || category,
                price: created.price || price,
                dur: created.duration || duration,
                desc: created.description || description,
            });
            showToast('Layanan berhasil ditambahkan!');
        }

        closeServiceModal();
        renderServicePage();
        populateServiceSelect();
    } catch (error) {
        showToast(error.message, 'error');
    }
}

/**
 * Buka modal hapus layanan.
 */
export function openDeleteService(id) {
    const service = state.services.find(s => s.id === id);
    if (!service) return;
    state.deleteServiceId = id;
    document.getElementById('del-name').textContent = service.name;
    document.getElementById('del-modal').classList.remove('hidden');
}

/**
 * Tutup modal hapus.
 */
export function closeDeleteModal() {
    document.getElementById('del-modal').classList.add('hidden');
    state.deleteServiceId = null;
}

/**
 * Konfirmasi hapus layanan.
 */
export async function confirmDeleteService() {
    if (!state.deleteServiceId) return;

    try {
        await deleteService(state.deleteServiceId);
        state.services = state.services.filter(s => s.id !== state.deleteServiceId);
        closeDeleteModal();
        renderServicePage();
        populateServiceSelect();
        showToast('Layanan berhasil dihapus!');
    } catch (error) {
        showToast(error.message, 'error');
    }
}
