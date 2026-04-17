/**
 * =============================================================
 * dashboard.js — Dashboard widgets & chart
 * =============================================================
 */

import { state } from './state.js';
import { formatRupiah } from './utils.js';
import { fetchPerformanceData } from './api.js';

/**
 * Inisialisasi dashboard — muat data performa dari API.
 */
export async function initDashboardChart() {
    try {
        const data = await fetchPerformanceData();
        state.performanceData = data;
        renderDashboardStats(data);
        renderWeeklyChart(data.weekly_revenue);
        renderBirthdayMembers(data.birthday_members);
    } catch (error) {
        console.error('Gagal memuat data dashboard:', error);
    }
}

/**
 * Render statistik dashboard.
 */
function renderDashboardStats(data) {
    const el = (id, val) => {
        const e = document.getElementById(id);
        if (e) e.textContent = val;
    };

    el('d-rev', formatRupiah(data.today_revenue));
    el('d-rev-info', `Dari ${data.today_customers} transaksi`);
    el('d-cust', data.today_customers);
    el('d-cust-info', data.today_customers > 0 ? `${data.today_customers} pelanggan dilayani` : 'Belum ada pelanggan');
    el('d-members', data.active_members);
    el('d-points', data.today_points.toLocaleString('id-ID'));
}

/**
 * Render chart pendapatan 7 hari terakhir.
 */
function renderWeeklyChart(weeklyData) {
    const container = document.getElementById('rev-chart');
    if (!container || !weeklyData) return;

    const maxRevenue = Math.max(...weeklyData.map(d => d.revenue), 1);

    container.innerHTML = weeklyData.map((day, index) => {
        const heightPercent = maxRevenue > 0 ? (day.revenue / maxRevenue) * 100 : 0;
        const isToday = index === weeklyData.length - 1;
        const barColor = isToday
            ? 'bg-brand-purple shadow-sm shadow-brand-purple/30'
            : 'bg-brand-purple-mid hover:bg-brand-purple transition-colors';

        return `
            <div class="flex-1 flex flex-col items-center gap-1 h-full">
                <div class="flex-1 flex items-end w-full px-0.5">
                    <div class="w-full rounded-t-md ${barColor} transition-all duration-500 cursor-pointer relative group"
                         style="height: ${Math.max(heightPercent, 4)}%"
                         title="${formatRupiah(day.revenue)}">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 hidden group-hover:block bg-gray-800 text-white text-[10px] px-2 py-1 rounded-md whitespace-nowrap z-10">
                            ${formatRupiah(day.revenue)}
                        </div>
                    </div>
                </div>
                <span class="text-[10px] ${isToday ? 'text-brand-purple font-bold' : 'text-gray-400'}">${day.day}</span>
            </div>`;
    }).join('');
}

/**
 * Render member ulang tahun bulan ini.
 */
function renderBirthdayMembers(members) {
    const container = document.getElementById('birthday-list');
    if (!container) return;

    if (!members || members.length === 0) {
        container.innerHTML = '<p class="text-sm text-gray-600 font-medium">Tidak ada member yang berulang tahun bulan ini.</p>';
        return;
    }

    container.innerHTML = members.map(member => `
        <span class="bg-brand-purple-light text-brand-purple-dark px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5">
            🎂 ${member.name} ${member.bday ? '(' + member.bday + ')' : ''}
        </span>
    `).join('');
}
