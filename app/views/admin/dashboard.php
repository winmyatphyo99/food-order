<?php require_once APPROOT . '/views/inc/header.php' ?>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php' ?>
    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>
        <div class="content-area">
            <div class="container-fluid my-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 text-dark fw-bold"><i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard Overview</h4>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6 col-lg-3">
                        <a href="<?php echo URLROOT; ?>/OrderController/index" class="text-decoration-none">
                            <div class="card card-custom h-100 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted fw-bold mb-1">Total Orders</h5>
                                        <h2 class="card-text text-primary fw-bold"><?php echo $data['toalOrders']; ?></h2>
                                    </div>
                                    <div class="icon-circle bg-light-primary text-primary">
                                        <i class="fas fa-box fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?php echo URLROOT; ?>/InvoiceController/index" class="text-decoration-none">
                            <div class="card card-custom h-100 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted fw-bold mb-1">Revenue Today</h5>
                                        <h2 class="card-text text-success fw-bold">$<?php echo number_format($data['revenueToday'], 2); ?></h2>
                                    </div>
                                    <div class="icon-circle bg-light-success text-success">
                                        <i class="fas fa-dollar-sign fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?php echo URLROOT; ?>/AdminController/index" class="text-decoration-none">
                            <div class="card card-custom h-100 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted fw-bold mb-1">Pending Orders</h5>
                                        <h2 class="card-text text-warning fw-bold"><?php echo $data['pending_orders']; ?></h2>
                                    </div>
                                    <div class="icon-circle bg-light-warning text-warning">
                                        <i class="fas fa-clipboard-list fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?php echo URLROOT; ?>/AdminController/completed" class="text-decoration-none">
                            <div class="card card-custom h-100 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted fw-bold mb-1">Confirmed Orders</h5>
                                        <h2 class="card-text text-info fw-bold"><?php echo $data['completedOrdersCount']; ?></h2>
                                    </div>
                                    <div class="icon-circle bg-light-info text-info">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                    </div>
                </div>

                <div class="card shadow-lg rounded-4 border-0">
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
                                        <th scope="col">Sub Total</th>
                                        <th scope="col">Tax Amount</th>
                                        <th scope="col">Delivery Fee</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['recentInvoices'] as $invoice): ?>
                                        <tr>
                                            <td class="text-primary fw-bold"><?php echo htmlspecialchars($invoice['invoice_number']); ?></td>
                                            <td><?php echo htmlspecialchars($invoice['customer_name']); ?></td>
                                            <td>$<?php echo htmlspecialchars(number_format($invoice['order_subtotal'], 2)); ?></td>
                                            <td>$<?php echo htmlspecialchars(number_format($invoice['tax_amount'], 2)); ?></td>
                                            <td>$<?php echo htmlspecialchars(number_format($invoice['delivery_fee'], 2)); ?></td>
                                            <td class="fw-bold">$<?php echo htmlspecialchars(number_format($invoice['grand_total'], 2)); ?></td>
                                            <td><?php echo htmlspecialchars(date('M j, Y', strtotime($invoice['invoice_date']))); ?></td>
                                            <td>
                                                <span class="badge rounded-pill px-3 py-2 <?php
                                                                                            echo ($invoice['order_status'] == 'pending') ? 'bg-warning text-dark' : (($invoice['order_status'] == 'confirmed') ? 'bg-success' : 'bg-danger');
                                                                                            ?>">
                                                    <?php echo ucfirst(htmlspecialchars($invoice['order_status'])); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
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
</style>
<?php require_once APPROOT . '/views/inc/footer.php' ?>