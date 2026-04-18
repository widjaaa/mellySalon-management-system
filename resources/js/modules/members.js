/**
 * =============================================================
 * members.js — CRUD member lengkap
 * =============================================================
 */

import { state } from './state.js';
import { formatRupiah, showToast } from './utils.js';
import { createMember, updateMember, deleteMember } from './api.js';
import { populateServiceSelect } from './payment.js';

/**
 * Format tanggal lahir untuk display.
 */
function formatBirthday(bday) {
    if (!bday) return '';
    try {
        const d = new Date(bday);
        if (isNaN(d.getTime())) return bday;
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    } catch {
        return bday;
    }
}

/**
 * Format tanggal lahir untuk input date (YYYY-MM-DD).
 */
function formatBdayForInput(bday) {
    if (!bday) return '';
    try {
        const d = new Date(bday);
        if (isNaN(d.getTime())) return '';
        return d.toISOString().split('T')[0];
    } catch {
        return '';
    }
}

const TIER_STYLES = {
    Gold:   { bg: 'bg-yellow-50', border: 'border-yellow-200', text: 'text-yellow-700', dot: 'bg-yellow-400', badge: 'bg-yellow-100 text-yellow-800' },
    Silver: { bg: 'bg-gray-50', border: 'border-gray-200', text: 'text-gray-600', dot: 'bg-gray-400', badge: 'bg-gray-100 text-gray-700' },
    Bronze: { bg: 'bg-orange-50', border: 'border-orange-200', text: 'text-orange-700', dot: 'bg-orange-400', badge: 'bg-orange-100 text-orange-800' },
};

/**
 * Render daftar member.
 */
export function renderMembers(filter = 'all') {
    const container = document.getElementById('member-list');
    if (!container) return;

    const filtered = filter === 'all'
        ? state.members
        : state.members.filter(m => m.tier === filter);

    if (filtered.length === 0) {
        container.innerHTML = `
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Tidak ada member ditemukan.</p>
            </div>`;
        return;
    }

    container.innerHTML = filtered.map(member => {
        const style = TIER_STYLES[member.tier] || TIER_STYLES.Bronze;
        const poinPercent = Math.min(100, (member.poin / 5000) * 100);

        return `
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-all">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full ${style.bg} ${style.text} font-bold flex items-center justify-center text-sm flex-shrink-0 ring-2 ring-white">
                    ${member.initials}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="font-bold text-gray-800 truncate">${member.name}</h4>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full ${style.badge}">${member.tier}</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-gray-500">
                        ${member.phone ? `<span>📱 ${member.phone}</span>` : ''}
                        ${member.bday ? `<span>🎂 ${formatBirthday(member.bday)}</span>` : ''}
                    </div>

                    <!-- Poin Bar -->
                    <div class="mt-3">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-semibold text-brand-purple">${member.poin.toLocaleString('id-ID')} poin</span>
                            <span class="text-gray-400">/ 5.000</span>
                        </div>
                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-brand-purple to-brand-purple-mid rounded-full transition-all duration-500" style="width:${poinPercent}%"></div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-3 mt-3">
                        <div class="bg-gray-50 rounded-lg p-2 text-center">
                            <div class="text-sm font-bold text-gray-800">${member.total}</div>
                            <div class="text-[10px] text-gray-500">Kunjungan</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-2 text-center">
                            <div class="text-sm font-bold text-gray-800">${formatRupiah(member.spent)}</div>
                            <div class="text-[10px] text-gray-500">Total Belanja</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-2 text-center">
                            <div class="text-sm font-bold text-gray-800">${member.tier === 'Gold' ? '10%' : member.tier === 'Silver' ? '5%' : '0%'}</div>
                            <div class="text-[10px] text-gray-500">Diskon</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-2 flex-shrink-0">
                    <button onclick="SalonApp.openEditMember(${member.id})" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button onclick="SalonApp.openDeleteMember(${member.id})" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>`;
    }).join('');
}

/**
 * Render datalist member untuk form pembayaran.
 */
export function renderMemberDatalist() {
    const datalist = document.getElementById('members-list');
    if (datalist) {
        datalist.innerHTML = state.members.map(m =>
            `<option value="${m.name}">`
        ).join('');
    }
}

/**
 * Filter member berdasarkan tier.
 */
export function filterMember(tier, element) {
    document.querySelectorAll('#page-members .tab-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-brand-purple', 'text-white', 'border-brand-purple');
        btn.classList.add('border-gray-200', 'bg-white', 'text-gray-600');
    });
    element.classList.add('active', 'bg-brand-purple', 'text-white', 'border-brand-purple');
    element.classList.remove('border-gray-200', 'bg-white', 'text-gray-600');
    renderMembers(tier);
}

/**
 * Buka modal tambah member.
 */
export function openMemberModal() {
    state.editMemberId = null;
    document.getElementById('mem-modal-title').textContent = 'Tambah Member Baru';
    document.getElementById('m-name').value = '';
    document.getElementById('m-phone').value = '';
    document.getElementById('m-tier').value = 'Bronze';
    document.getElementById('m-bday').value = '';
    document.getElementById('mem-modal').classList.remove('hidden');
}

/**
 * Buka modal edit member.
 */
export function openEditMember(id) {
    const member = state.members.find(m => m.id === id);
    if (!member) return;

    state.editMemberId = id;
    document.getElementById('mem-modal-title').textContent = 'Edit Member';
    document.getElementById('m-name').value = member.name;
    document.getElementById('m-phone').value = member.phone;
    document.getElementById('m-tier').value = member.tier;
    document.getElementById('m-bday').value = formatBdayForInput(member.bday);
    document.getElementById('mem-modal').classList.remove('hidden');
}

/**
 * Tutup modal member.
 */
export function closeMemberModal() {
    document.getElementById('mem-modal').classList.add('hidden');
    state.editMemberId = null;
}

/**
 * Simpan member (baru atau edit).
 */
export async function saveMember() {
    const name = document.getElementById('m-name').value.trim();
    const phone = document.getElementById('m-phone').value.trim();
    const tier = document.getElementById('m-tier').value;
    const bday = document.getElementById('m-bday').value.trim();

    if (!name) {
        showToast('Nama member harus diisi.', 'error');
        return;
    }

    const memberData = { name, phone, tier, bday };

    try {
        if (state.editMemberId) {
            // Edit existing
            const updated = await updateMember(state.editMemberId, memberData);
            const idx = state.members.findIndex(m => m.id === state.editMemberId);
            if (idx !== -1) {
                state.members[idx] = {
                    ...state.members[idx],
                    name: updated.name || name,
                    phone: updated.phone || phone,
                    tier: updated.tier || tier,
                    bday: updated.bday || bday,
                    initials: name.split(' ').map(w => w[0] || '').join('').toUpperCase().slice(0, 2),
                };
            }
            showToast('Member berhasil diperbarui!');
        } else {
            // Create new
            const created = await createMember(memberData);
            state.members.push({
                id: created.id,
                name: created.name || name,
                initials: name.split(' ').map(w => w[0] || '').join('').toUpperCase().slice(0, 2),
                tier: created.tier || tier,
                poin: 0,
                total: 0,
                spent: 0,
                bday: created.bday || bday,
                phone: created.phone || phone,
            });
            showToast('Member berhasil ditambahkan!');
        }

        closeMemberModal();
        renderMembers();
        renderMemberDatalist();
    } catch (error) {
        showToast(error.message, 'error');
    }
}

/**
 * Buka modal hapus member.
 */
export function openDeleteMember(id) {
    const member = state.members.find(m => m.id === id);
    if (!member) return;
    state.deleteMemberId = id;
    document.getElementById('del-mem-name').textContent = member.name;
    document.getElementById('del-mem-modal').classList.remove('hidden');
}

/**
 * Tutup modal hapus member.
 */
export function closeDeleteMemberModal() {
    document.getElementById('del-mem-modal').classList.add('hidden');
    state.deleteMemberId = null;
}

/**
 * Konfirmasi hapus member.
 */
export async function confirmDeleteMember() {
    if (!state.deleteMemberId) return;

    try {
        await deleteMember(state.deleteMemberId);
        state.members = state.members.filter(m => m.id !== state.deleteMemberId);
        closeDeleteMemberModal();
        renderMembers();
        renderMemberDatalist();
        showToast('Member berhasil dihapus!');
    } catch (error) {
        showToast(error.message, 'error');
    }
}
