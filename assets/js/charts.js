document.querySelectorAll('canvas[data-chart]').forEach((canvas) => {
    const chart = JSON.parse(canvas.dataset.chart);
    new Chart(canvas, { type: chart.type, data: { labels: chart.labels, datasets: chart.datasets }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8 } } }, scales: { y: { beginAtZero: true, ticks: { callback: (value) => '৳ ' + Number(value).toLocaleString() } } } } });
});
