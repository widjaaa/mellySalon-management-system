/**
 * =============================================================
 * inventory.js — Logika Halaman Inventaris & Stok
 * =============================================================
 */

import { state } from './state.js';
import { showToast, getRequestHeaders } from './utils.js';

let editItemId = null;
let deleteItemId = null;

// ==================== OPERASI API & RENDER ====================

/**
 * Fetch dan render data inventaris.
 */
export async function renderInventories() {
    try {
        const response = await fetch('/inventories', { headers: getRequestHeaders() });
        const text = await response.text();
        if (!response.ok) throw new Error(text);
        
        const data = JSON.parse(text);
        state.inventories = Array.isArray(data) ? data : (data.data || []);
        
        filterInventory(); // Memanggil perender tabel dengan/tanpa pencarian
        checkLowStock(); // Mengecek stok yang <= 1
    } catch (error) {
        console.error('Gagal memuat data inventaris:', error);
        showToast('Gagal memuat data inventaris', 'error');
    }
}

/**
 * Render tabel inventaris berdasarkan filter/search.
 */
export function filterInventory() {
    const list = document.getElementById('inv-list');
    if (!list) return;

    let filtered = [...(state.inventories || [])];
    const term = (document.getElementById('inv-search')?.value || '').toLowerCase();

    if (term) {
        filtered = filtered.filter(inv => inv.name.toLowerCase().includes(term));
    }

    if (!filtered.length) {
        list.innerHTML = `<tr><td colspan="5" class="text-center py-12 text-gray-400 text-sm">
            ${term ? 'Tidak ada barang yang cocok.' : 'Belum ada data barang.'}
        </td></tr>`;
        return;
    }

    list.innerHTML = filtered.map(inv => {
        // Logika warna badge sisa stok
        let stockBadgeColor = 'bg-gray-100 text-gray-700';
        if (inv.stock > 10) stockBadgeColor = 'bg-emerald-100 text-emerald-700';
        else if (inv.stock > 1) stockBadgeColor = 'bg-amber-100 text-amber-700';
        else stockBadgeColor = 'bg-red-100 text-red-700 animate-pulse';

        return `
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4">
                <div class="font-bold text-gray-800 text-sm">${inv.name}</div>
            </td>
            <td class="px-6 py-4 text-center">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">${inv.unit}</span>
            </td>
            <td class="px-6 py-4 text-center">
                <span class="px-3 py-1 rounded-full text-xs font-bold ${stockBadgeColor}">
                    ${inv.stock}
                </span>
            </td>
            <td class="px-6 py-4 text-center">
                <div class="flex items-center justify-center gap-1">
                    <button onclick="SalonApp.adjustInventoryStock(${inv.id}, -1)" class="w-7 h-7 flex items-center justify-center rounded bg-red-50 text-red-600 hover:bg-red-100 transition-colors font-bold" title="Kurangi 1">
                        -
                    </button>
                    <button onclick="SalonApp.adjustInventoryStock(${inv.id}, 1)" class="w-7 h-7 flex items-center justify-center rounded bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors font-bold" title="Tambah 1">
                        +
                    </button>
                </div>
            </td>
            <td class="px-6 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-end gap-2">
                    <button onclick="SalonApp.openEditInventory(${inv.id})" class="px-3 py-1.5 text-xs font-semibold text-brand-purple bg-brand-purple-light hover:bg-brand-purple-mid/30 rounded-lg transition-colors">
                        Edit
                    </button>
                    <button onclick="SalonApp.openDeleteInventory(${inv.id})" class="px-3 py-1.5 text-xs font-semibold text-red-500 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                        Hapus
                    </button>
                </div>
            </td>
        </tr>`;
    }).join('');
}

/**
 * Filter kotak pencarian dari input pengguna.
 */
export function searchInventory() {
    filterInventory();
}

/**
 * Cek peringatan stok menipis (Stok <= 1).
 */
function checkLowStock() {
    const alertBox = document.getElementById('inv-low-alert');
    const lowList = document.getElementById('inv-low-list');
    if (!alertBox || !lowList) return;

    const lowItems = state.inventories.filter(inv => inv.stock <= 1);

    if (lowItems.length > 0) {
        lowList.innerHTML = lowItems.map(inv => `<li>${inv.name} (Sisa: ${inv.stock} ${inv.unit})</li>`).join('');
        alertBox.classList.remove('hidden');
    } else {
        alertBox.classList.add('hidden');
    }
}

// ==================== MODALS & FORM ====================

/**
 * Buka modal tambah barang baru.
 */
export function openInventoryModal() {
    editItemId = null;
    document.getElementById('inv-modal-title').textContent = 'Tambah Barang Baru';
    
    document.getElementById('i-name').value = '';
    document.getElementById('i-stock').value = '';
    document.getElementById('i-unit').value = 'Pcs';
    
    const modal = document.getElementById('inv-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

/**
 * Buka modal edit barang yang sudah ada.
 */
export function openEditInventory(id) {
    const inv = state.inventories.find(i => i.id === id);
    if (!inv) return;

    editItemId = id;
    document.getElementById('inv-modal-title').textContent = 'Edit Barang';
    
    document.getElementById('i-name').value = inv.name;
    document.getElementById('i-stock').value = inv.stock;
    document.getElementById('i-unit').value = inv.unit;

    const modal = document.getElementById('inv-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

/**
 * Tutup modal barang.
 */
export function closeInventoryModal() {
    const modal = document.getElementById('inv-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    editItemId = null;
}

/**
 * Simpan data barang (Buat baru / Update).
 */
export async function saveInventory() {
    const nameInput = document.getElementById('i-name');
    const stockInput = document.getElementById('i-stock');
    const unitInput = document.getElementById('i-unit');

    const name = nameInput.value.trim();
    const stock = parseInt(stockInput.value, 10);
    const unit = unitInput.value;

    if (!name || isNaN(stock) || stock < 0) {
        showToast('Nama dan stok tidak valid. Stok minimal 0.', 'error');
        return;
    }

    const payload = { name, stock, unit };
    const method = editItemId ? 'PUT' : 'POST';
    const url = editItemId ? `/inventories/${editItemId}` : '/inventories';

    nameInput.disabled = true;

    try {
        const response = await fetch(url, {
            method,
            headers: getRequestHeaders(),
            body: JSON.stringify(payload)
        });

        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Error server');

        showToast(editItemId ? 'Barang diperbarui!' : 'Barang ditambahkan!');
        closeInventoryModal();
        renderInventories();
    } catch (error) {
        console.error(error);
        showToast(error.message, 'error');
    } finally {
        nameInput.disabled = false;
    }
}

/**
 * Penyesuaian stok instan (Tombol + / -).
 */
export async function adjustInventoryStock(id, amount) {
    const inv = state.inventories.find(i => i.id === id);
    if (!inv) return;

    const newStock = Math.max(0, inv.stock + amount);
    if (newStock === inv.stock) {
        if (amount < 0 && inv.stock === 0) {
             showToast('Stok sudah habis (0).', 'error');
        }
        return; // Tidak ada perubahan
    }

    // Lakukan PUT rekuwes tanpa membuka modal
    const payload = {
        name: inv.name,
        stock: newStock,
        unit: inv.unit
    };

    try {
        const response = await fetch(`/inventories/${id}`, {
            method: 'PUT',
            headers: getRequestHeaders(),
            body: JSON.stringify(payload)
        });

        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Error server');

        renderInventories();
        showToast(`Stok ${inv.name} menjadi ${newStock}`);
    } catch (error) {
        console.error(error);
        showToast(error.message, 'error');
    }
}

// ==================== DELETE MODAL ====================

export function openDeleteInventory(id) {
    const inv = state.inventories.find(i => i.id === id);
    if (!inv) return;

    deleteItemId = id;
    document.getElementById('del-inv-name').textContent = inv.name;
    
    const modal = document.getElementById('del-inv-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

export function closeDeleteInventoryModal() {
    const modal = document.getElementById('del-inv-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    deleteItemId = null;
}

export async function confirmDeleteInventory() {
    if (!deleteItemId) return;

    try {
        const response = await fetch(`/inventories/${deleteItemId}`, {
            method: 'DELETE',
            headers: getRequestHeaders()
        });

        if (!response.ok) {
            const data = await response.json();
            throw new Error(data.message || 'Error menghapus barang');
        }

        showToast('Barang dihapus!');
        closeDeleteInventoryModal();
        renderInventories();
    } catch (error) {
        console.error(error);
        showToast(error.message, 'error');
    }
}
