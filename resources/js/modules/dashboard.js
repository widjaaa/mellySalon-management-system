/**
 * =============================================================
 * dashboard.js — Logika halaman Dashboard
 * =============================================================
 *
 * Menangani rendering chart pendapatan mingguan
 * dan widgets dashboard lainnya.
 */

/**
 * Menggambar chart bar pendapatan mingguan di dashboard.
 * Menggunakan data dummy untuk saat ini.
 * TODO: Ambil data real dari backend via API
 */
export function initDashboardChart() {
    const DAYS = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    const VALUES = [320, 410, 280, 520, 390, 610, 440];
    const MAX_VALUE = Math.max(...VALUES);
    const HIGHLIGHT_INDEX = 5; // Sabtu = hari tersibuk

    const chartContainer = document.getElementById('rev-chart');
    if (!chartContainer) return;

    chartContainer.innerHTML = DAYS.map((day, index) => {
        const barHeight = Math.round(VALUES[index] / MAX_VALUE * 72);
        const isHighlight = index === HIGHLIGHT_INDEX;

        return `
            <div class="rc">
                <div class="rb-wrap">
                    <div class="rb${isHighlight ? ' hi' : ''}" style="height:${barHeight}px"></div>
                </div>
                <div class="rl">${day}</div>
            </div>
        `;
    }).join('');
}
