<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>
        <div class="content-area">
            <div class="container-fluid my-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 text-dark fw-bold"><i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard Overview</h4>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= URLROOT; ?>/OrderController/index" class="text-decoration-none">
                            <div class="card card-custom h-100 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted fw-bold mb-1">Total Orders</h5>
                                        <h2 class="card-text text-primary fw-bold"><?= $data['toalOrders'] ?? 0; ?></h2>
                                    </div>
                                    <div class="icon-circle bg-light-primary text-primary">
                                        <i class="fas fa-box fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= URLROOT; ?>/InvoiceController/index" class="text-decoration-none">
                            <div class="card card-custom h-100 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted fw-bold mb-1">Revenue Today</h5>
                                        <h2 class="card-text text-success fw-bold">$<?= number_format($data['revenueToday'] ?? 0, 2); ?></h2>
                                    </div>
                                    <div class="icon-circle bg-light-success text-success">
                                        <i class="fas fa-dollar-sign fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <a href="<?= URLROOT; ?>/AdminController/pending" class="text-decoration-none">
                            <div class="card card-custom h-100 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted fw-bold mb-1">Pending Orders</h5>
                                        <h2 class="card-text text-warning fw-bold"><?= $data['pending_orders'] ?? 0; ?></h2>
                                    </div>
                                    <div class="icon-circle bg-light-warning text-warning">
                                        <i class="fas fa-clipboard-list fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <a href="<?= URLROOT; ?>/AdminController/completed" class="text-decoration-none">
                            <div class="card card-custom h-100 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted fw-bold mb-1">Confirmed Orders</h5>
                                        <h2 class="card-text text-info fw-bold"><?= $data['completedOrdersCount'] ?? 0; ?></h2>
                                    </div>
                                    <div class="icon-circle bg-light-info text-info">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-lg-6">
                        <div class="card card-custom shadow-sm h-100">
                            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                                <h5 class="mb-0 text-dark fw-bold">Sales Overview</h5>
                            </div>
                            <div class="card-body p-4">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card card-custom shadow-sm h-100">
                            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                                <h5 class="mb-0 text-dark fw-bold">Recent Invoices</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle recent-invoices-table">
                                        <thead class="text-uppercase text-muted">
                                            <tr>
                                                <th scope="col">Invoice No.</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Total Amount</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($data['recentInvoices'])): ?>
                                                <?php foreach ($data['recentInvoices'] as $invoice): ?>
                                                    <tr>
                                                        <td class="text-primary fw-bold"><?= htmlspecialchars($invoice['invoice_number']); ?></td>
                                                        <td><?= htmlspecialchars($invoice['customer_name']); ?></td>
                                                        <td class="fw-bold">$<?= htmlspecialchars(number_format($invoice['grand_total'], 2)); ?></td>
                                                        <td><?= htmlspecialchars(date('M j, Y', strtotime($invoice['invoice_date']))); ?></td>
                                                        <td>
                                                            <?php 
                                                            $statusClass = 'bg-info';
                                                            if ($invoice['order_status'] == 'completed') $statusClass = 'bg-success';
                                                            elseif ($invoice['order_status'] == 'pending') $statusClass = 'bg-warning text-dark';
                                                            elseif ($invoice['order_status'] == 'cancelled') $statusClass = 'bg-danger';
                                                            ?>
                                                            <span class="badge rounded-pill px-3 py-2 <?= $statusClass; ?>">
                                                                <?= ucfirst(htmlspecialchars($invoice['order_status'])); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No recent invoices found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Sales Chart
        const salesData = <?= json_encode($data['salesData'] ?? []); ?>;
        const labels = salesData.map(d => d.date);
        const data = salesData.map(d => d.total_sales);

        const ctx = document.getElementById('salesChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales ($)',
                        data: data,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.2)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<style>
    /* Base Layout */
    body {
        background-color: #f4f7f9;
    }

    .dashboard-wrapper {
        display: flex;
        height: 100vh;
    }

    .main-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        padding: 0;
    }

    /* Top Header */
    .top-header {
        background-color: #fff;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .header-left .logo-link {
        font-size: 1.25rem;
        font-weight: 700;
        color: #344767;
        text-decoration: none;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .header-right span {
        font-size: 1rem;
        color: #555;
    }

    .logout-link {
        color: #6c757d;
        text-decoration: none;
        font-weight: 500;
    }

    .logout-link:hover {
        color: #dc3545;
    }

    /* Content Area */
    .content-area {
        padding: 2rem;
        flex-grow: 1;
    }

    /* Custom Card & Icons */
    .card-custom {
        background-color: #fff;
        border: none;
        border-radius: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .icon-circle {
        width: 65px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .bg-light-primary {
        background-color: #e0f7fa !important;
    }

    .bg-light-success {
        background-color: #e8f5e9 !important;
    }

    .bg-light-warning {
        background-color: #fffde7 !important;
    }

    .bg-light-info {
        background-color: #e1f5fe !important;
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
    }

    .recent-invoices-table thead th {
        font-weight: 600;
        color: #999;
        border-bottom: 2px solid #e9ecef;
    }

    .recent-invoices-table tbody td {
        color: #333;
        padding: 1rem;
    }

    /* Status Badges */
    .badge {
        font-size: 0.8em;
        font-weight: 600;
        padding: 0.5em 1.2em;
    }

    /* Additions and refinements for a more professional look */
    .content-area {
        background-color: #f4f7f9;
    }
    .card-custom {
        transition: all 0.2s ease-in-out;
    }
    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
</style>
<?php require_once APPROOT . '/views/inc/footer.php' ?>