// Dedicated entry for pages with charts (admin dashboard, reports, jobseeker
// dashboard). Keeps Chart.js (~70KB gz) out of the global bundle so pages
// without charts never download it.
import Chart from 'chart.js/auto';

window.Chart = Chart;

/** Hide chart skeleton placeholders once charts have rendered. */
function chartReady() {
    document.querySelectorAll('.skeleton-chart').forEach(el => el.remove());
}

window.chartReady = chartReady;
