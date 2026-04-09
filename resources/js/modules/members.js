/**
 * =============================================================
 * members.js — Logika halaman Data Member
 * =============================================================
 *
 * Menangani:
 * - Render daftar member (dengan filter per tier)
 * - Form tambah member baru
 * - Modal member
 */

import { state } from './state.js';
import { showToast } from './utils.js';
import { createMember } from './api.js';

/** Warna avatar & badge berdasarkan tier member */
const TIER_COLORS = {
    Gold:   { avatarBg: '#FAEEDA', avatarColor: '#633806', badgeClass: 'pill-gold' },
    Silver: { avatarBg: '#F1EFE8', avatarColor: '#2C2C2A', badgeClass: 'pill-silver' },
    Bronze: { avatarBg: '#FAECE7', avatarColor: '#4A1B0C', badgeClass: 'pill-bronze' },
};

/** Batas poin maksimal untuk setiap tier */
const TIER_MAX_POINTS = {
    Gold: 3000,
    Silver: 1000,
    Bronze: 500,
};

/**
 * Render daftar member dengan filter tertentu.
 * @param {string} filter - Filter tier: 'all', 'Gold', 'Silver', atau 'Bronze'
 */
export function renderMembers(filter) {
    const listElement = document.getElementById('member-list');
    if (!listElement) return;

    const filteredMembers = filter === 'all'
        ? state.members
        : state.members.filter(member => member.tier === filter);

    if (!filteredMembers.length) {
        listElement.innerHTML = `
            <div style="text-align:center;padding:2rem;color:var(--text3);font-size:12.5px">
                Belum ada member di kategori ini.
            </div>
        `;
        return;
    }

    listElement.innerHTML = filteredMembers.map(member => {
        const colors = TIER_COLORS[member.tier] || TIER_COLORS.Bronze;
        const discountText = member.tier === 'Gold' ? '10%' : member.tier === 'Silver' ? '5%' : '0%';
        const maxPoints = TIER_MAX_POINTS[member.tier] || 500;
        const poinProgress = Math.min(100, Math.round(member.poin / maxPoints * 100));
        const tierLabel = member.tier !== 'Gold' ? ' ke tier berikutnya' : ' (maks)';

        return `
            <div class="member-card">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
                    <div class="av av-lg" style="background:${colors.avatarBg};color:${colors.avatarColor}">
                        ${member.initials}
                    </div>
                    <div style="flex:1">
                        <div style="font-size:13px;font-weight:500">${member.name}</div>
                        <span class="pill ${colors.badgeClass}">${member.tier}</span>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:17px;font-weight:500">${member.poin.toLocaleString('id-ID')}</div>
                        <div style="font-size:10px;color:var(--text3)">poin</div>
                    </div>
                </div>
                <div class="poin-bar">
                    <div class="poin-fill" style="width:${poinProgress}%"></div>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:10px;color:var(--text3);margin-bottom:9px">
                    <span>${member.poin.toLocaleString('id-ID')} / ${maxPoints.toLocaleString('id-ID')} poin${tierLabel}</span>
                    <span>Ultah: ${member.bday}</span>
                </div>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:6px">
                    <div class="ms">
                        <div class="ms-val">${member.total}x</div>
                        <div class="ms-lbl">Kunjungan</div>
                    </div>
                    <div class="ms">
                        <div class="ms-val">Rp ${(member.spent / 1000000).toFixed(1)}jt</div>
                        <div class="ms-lbl">Total Belanja</div>
                    </div>
                    <div class="ms">
                        <div class="ms-val">${discountText}</div>
                        <div class="ms-lbl">Diskon</div>
                    </div>
                </div>
                ${member.phone ? `<div style="font-size:11px;color:var(--text3);margin-top:8px">📞 ${member.phone}</div>` : ''}
            </div>
        `;
    }).join('');
}

/**
 * Mengisi datalist autocomplete untuk input nama pelanggan.
 */
export function renderMemberDatalist() {
    const datalist = document.getElementById('members-list');
    if (datalist) {
        datalist.innerHTML = state.members.map(
            member => `<option value="${member.name}"></option>`
        ).join('');
    }
}

/**
 * Filter member berdasarkan tier (dipanggil dari tombol tab).
 * @param {string} filter - Tier yang dipilih
 * @param {HTMLElement} element - Tombol tab yang diklik
 */
export function filterMember(filter, element) {
    document.querySelectorAll('#page-members .tab').forEach(
        btn => btn.classList.remove('act')
    );
    element.classList.add('act');
    renderMembers(filter);
}

/**
 * Membuka modal tambah member baru dan mengosongkan form.
 */
export function openMemberModal() {
    document.getElementById('m-name').value = '';
    document.getElementById('m-phone').value = '';
    document.getElementById('m-tier').value = 'Bronze';
    document.getElementById('m-bday').value = '';
    document.getElementById('mem-modal').classList.remove('hidden');
}

/**
 * Menutup modal member.
 */
export function closeMemberModal() {
    document.getElementById('mem-modal').classList.add('hidden');
}

/**
 * Menyimpan member baru ke database dan memperbarui tampilan.
 */
export async function saveMember() {
    const name = document.getElementById('m-name').value.trim();
    if (!name) {
        alert('Nama member wajib diisi.');
        return;
    }

    const phone = document.getElementById('m-phone').value.trim();
    const bday = document.getElementById('m-bday').value.trim();
    const tier = document.getElementById('m-tier').value;

    try {
        const data = await createMember({ name, phone, bday, tier });

        // Tambah ke state lokal
        const initials = data.name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2);
        state.members.push({
            id: data.id,
            name: data.name,
            initials,
            tier: data.tier || 'Bronze',
            poin: data.poin || 0,
            total: data.total_visits || 0,
            spent: data.total_spent || 0,
            bday: data.bday || '',
            phone: data.phone || '',
        });

        closeMemberModal();
        renderMembers('all');

        // Reset tab ke "Semua"
        document.querySelectorAll('#page-members .tab').forEach(
            (btn, index) => btn.classList.toggle('act', index === 0)
        );

        showToast('Member baru berhasil disimpan ke database!');
    } catch (error) {
        alert('Gagal menyimpan member: ' + error.message);
    }
}
