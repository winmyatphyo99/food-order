<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<style>
    /* Dashboard and General Styles */
    body {
        background-color: #f4f7f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-wrapper {
        display: flex;
        min-height: 100vh;
    }

    .main-content {
        flex: 1;
        padding: 30px;
    }

    /* Page Title */
    .container-fluid h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        border-bottom: 3px solid #e1e4e8;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .table {
        background-color: #ffffff;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background-color: #3498db;
        color: #ffffff;
        border-bottom: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.005);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .table td,
    .table th {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
    }

    /* Rounded corners for the table */
    .table thead tr:first-child th:first-child {
        border-top-left-radius: 10px;
    }

    .table thead tr:first-child th:last-child {
        border-top-right-radius: 10px;
    }

    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 10px;
    }

    .table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 10px;
    }

    /* Badge Styles */
    .badge {
        padding: 8px 15px;
        font-weight: 600;
        border-radius: 20px;
        min-width: 100px;
        display: inline-block;
        text-align: center;
    }

    .badge.bg-success {
        background-color: #2ecc71 !important;
    }

    .badge.bg-warning {
        background-color: #f1c40f !important;
    }

    .badge.bg-danger {
        background-color: #e74c3c !important;
    }

    /* Action Button */
    .btn-info {
        background-color: #3498db;
        border-color: #3498db;
        border-radius: 50px;
        padding: 8px 20px;
        transition: background-color 0.3s ease;
    }

    .btn-info:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }

    /* Empty State Message */
    .alert-info {
        background-color: #e8f3ff;
        border: 1px solid #d4e8ff;
        color: #2980b9;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .alert-info i {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    * Pagination Styles */ .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .page-item .page-link {
        border-radius: 50px;
        margin: 0 5px;
        color: #3498db;
        border-color: #dee2e6;
        transition: all 0.3s ease;
    }

    .page-item.active .page-link {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff;
    }

    .page-item .page-link:hover {
        background-color: #f8f9fa;
        color: #2980b9;
        border-color: #3498db;
    }
</style>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <div class="main-content">
        <div class="container my-5">
            <h4 class="mb-4 text-dark fw-bold"><?php echo htmlspecialchars($data['heading']); ?></h4>
            <?php if (!empty($data['orders'])): ?>
                <div class="table-responsive">
                    
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['orders'] as $order): ?>
                                <tr>
                                    <th scope="row">#<?php echo htmlspecialchars($order['id']); ?></th>
                                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                    <td>$<?php echo number_format($order['total_amt'], 2); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php
                                            if ($order['status'] == 'Confirmed') echo 'bg-success';
                                            elseif ($order['status'] == 'Pending') echo 'bg-warning ';
                                            elseif ($order['status'] == 'Cancelled') echo 'bg-danger';
                                            else echo 'bg-secondary';
                                            ?>
                                        ">
                                            <?php echo htmlspecialchars($order['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/CartController/orderConfirmation/<?php echo $order['id']; ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-info-circle me-1"></i> Details
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i>
                    <p class="mb-0 mt-2">You have not placed any orders yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>