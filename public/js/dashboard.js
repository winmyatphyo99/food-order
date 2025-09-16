document.addEventListener('DOMContentLoaded', () => {
    const ordersChartCtx = document.getElementById('ordersChart');
    if (ordersChartCtx) {
        // Data passed from PHP using a data attribute (or similar method)
        // For this example, let's assume it's passed as a global JS variable.
        // A better approach would be to use a data attribute on the canvas element itself.
        const pendingOrders = parseInt(document.querySelector('.summary-card-pending .card-text').textContent) || 0;
        const cancelledOrders = parseInt(document.querySelector('.summary-card-cancelled .card-text').textContent) || 0;
        const totalOrders = parseInt(document.querySelector('.summary-card-total .card-text').textContent) || 0;
        const completedOrders = totalOrders - pendingOrders - cancelledOrders;

        new Chart(ordersChartCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [completedOrders, pendingOrders, cancelledOrders],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 1,
                    cutout: '65%'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 15,
                            padding: 15
                        }
                    }
                }
            }
        });
    }
});