<?php require_once APPROOT . '/views/inc/header.php' ?>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php' ?>
    <main class="main-content">
        <header class="top-header">
            <div class="header-left">
                <a href="#" class="logo-link">Admin Dashboard</a>
            </div>
            <div class="header-right">
                <span>
                    Welcome,
                    <strong>
                        <?php
                        if (isset($_SESSION['user_name'])) {
                            echo htmlspecialchars($_SESSION['user_name']);
                        } else {
                            echo 'Guest';
                        }
                        ?>!
                    </strong>
                </span>
                <a href="<?php echo URLROOT; ?>/auth/logout" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>
        <div class="content-area">
            <h1 class="page-title">Dashboard Overview</h1>
            <div class="content-grid-area">
                <div class="stats-panel">
                    <div class="stat-card">
                        <div class="stat-icon-wrapper"><i class="fas fa-box"></i></div>
                        <div class="stat-info">
                            <span class="stat-label">Total Orders</span>
                            <span class="stat-value"><?php echo $data['toalOrders']; ?></span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon-wrapper"><i class="fas fa-dollar-sign"></i></div>
                        <div class="stat-info">
                            <span class="stat-label">Revenue Today</span>
                            <span class="stat-value">$1,200</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon-wrapper"><i class="fas fa-clipboard-list"></i></div>
                        <div class="stat-info">
                            <span class="stat-label">Pending Invoices</span>
                            <span class="stat-value">12</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon-wrapper"><i class="fas fa-bell"></i></div>
                        <div class="stat-info">
                            <span class="stat-label">Notifications</span>
                            <span class="stat-value">5</span>
                        </div>
                    </div>
                </div>


                <div class="recent-activity-panel">
                    <h2>Recent Invoices</h2>
                    <div class="table-placeholder">
                        <table class="recent-invoices-table">
                            <thead>
                                <tr>
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>Sub Total</th>
                                    <th>Tax Amount</th>
                                    <th>Delivery Fee</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['recentInvoices'] as $invoice): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($invoice['invoice_number']); ?></td>
                                        <td><?php echo htmlspecialchars($invoice['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($invoice['order_subtotal']); ?></td>
                                        <td><?php echo htmlspecialchars($invoice['tax_amount']); ?></td>
                                        <td><?php echo htmlspecialchars($invoice['delivery_fee']); ?></td>
                                        <td><?php echo htmlspecialchars($invoice['grand_total']); ?></td>
                                        <td><?php echo htmlspecialchars($invoice['invoice_date']); ?></td>
                                        <td><?php echo htmlspecialchars($invoice['order_status']); ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    /* Styling for the table container */
    .recent-invoices-table {
        width: 100%;
        /* Make table fill its container */
        border-collapse: collapse;
        /* Collapse borders for a clean look */
        margin-top: 15px;
        font-size: 14px;
        text-align: left;
    }

    /* Style table header */
    .recent-invoices-table thead th {
        background-color: #f8f9fa;
        /* Light background for header */
        padding: 12px 15px;
        /* Add padding for space */
        color: #495057;
        /* Dark gray text color */
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        /* Separator line */
    }

    /* Style table rows */
    .recent-invoices-table tbody tr {
        border-bottom: 1px solid #dee2e6;
        /* Separator line between rows */
    }

    /* Hover effect for rows */
    .recent-invoices-table tbody tr:hover {
        background-color: #f1f3f5;
        /* Light gray background on hover */
    }

    /* Style table cells */
    .recent-invoices-table tbody td {
        padding: 12px 15px;
        /* Consistent padding */
        color: #6c757d;
        /* Slightly lighter text */
    }

    /* Style for the first column (Invoice No.) to make it bold */
    .recent-invoices-table tbody td:first-child {
        font-weight: bold;
        color: #343a40;

    }
</style>
<?php require_once APPROOT . '/views/inc/footer.php' ?>