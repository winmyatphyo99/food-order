<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<style>
    /*
    * ----------------------------------------
    * Refactored Order History CSS
    * ----------------------------------------
    */

    :root {
        --primary-color: #3498db;
        --success-color: #2ecc71;
        --warning-color: #e67e22; /* deeper orange */
        --danger-color: #e74c3c;
        --text-color: #2c3e50;
        --secondary-text-color: #7f8c8d;
        --background-color: #f4f7f9;
        --card-bg-color: #ffffff;
        --border-color: #e1e4e8;
        --box-shadow-light: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--background-color);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-wrapper {
        display: flex;
        min-height: 100vh;
    }

    .main-content {
        flex: 1;
        padding: 2rem;
    }

    /* Page Title */
    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-color);
        border-bottom: 3px solid var(--border-color);
        padding-bottom: 15px;
        margin-bottom: 30px;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 10px;
        box-shadow: var(--box-shadow-light);
        overflow-x: auto;
    }

    .table {
        background-color: var(--card-bg-color);
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }
    

    .table thead th {
        background-color: var(--primary-color);
        color: #ffffff;
        border-bottom: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    /* Remove hover effect */
    .table tbody tr:hover {
        background-color: inherit;
        transform: none;
        box-shadow: none;
    }

    .table td,
    .table th {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
    }

    /* Rounded corners for the table */
    .table thead tr:first-child th:first-child { border-top-left-radius: 10px; }
    .table thead tr:first-child th:last-child { border-top-right-radius: 10px; }
    .table tbody tr:last-child td:first-child { border-bottom-left-radius: 10px; }
    .table tbody tr:last-child td:last-child { border-bottom-right-radius: 10px; }

    /* Status-based row background colors */
    .table tbody tr.status-Confirmed { background-color: #eafaf1; } /* soft green */
    .table tbody tr.status-Pending { background-color: #fff4e6; }   /* soft orange */
    .table tbody tr.status-Cancelled { background-color: #ffeaea; } /* soft red */

    /* Badge Styles */
    .status-badge {
    padding: 8px 15px;
    font-weight: 600;
    border-radius: 20px;
    min-width: 100px;
    display: inline-block;
    text-align: center;
}

    .status-badge.Confirmed { background-color: var(--success-color); color: #fff; }
    .status-badge.Pending { background-color: var(--warning-color); color: #fff; }
    .status-badge.Cancelled { background-color: var(--danger-color); color: #fff; }

    /* Action Button */
    .btn-details {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #ffffff;
        border-radius: 50px;
        padding: 8px 20px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-details:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-2px);
    }

    /* Empty State Message */
    .empty-state {
        background-color: #e8f3ff;
        border: 1px solid #d4e8ff;
        color: var(--primary-color);
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        box-shadow: var(--box-shadow-light);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .empty-state .btn {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
    }
</style>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <div class="main-content">
        <div class="container-fluid my-5">
            <h4 class="mb-4 text-dark fw-bold page-title"><?php echo htmlspecialchars($data['heading']); ?></h4>
            
            <?php if (!empty($data['orders'])): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
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
                                <tr class="status-<?php echo ucfirst(strtolower($order['status'])); ?>">
    <th scope="row">#<?php echo htmlspecialchars($order['id']); ?></th>
    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
    <td>$<?php echo number_format($order['total_amt'], 2); ?></td>
    <td>
        <span class="badge status-badge <?php echo ucfirst(strtolower($order['status'])); ?>">
            <?php echo htmlspecialchars($order['status']); ?>
        </span>
    </td>
    <td>
        <a href="<?php echo URLROOT; ?>/CartController/orderConfirmation/<?php echo $order['id']; ?>" class="btn btn-sm btn-details">
            <i class="fas fa-info-circle me-1"></i> Details
        </a>
    </td>
</tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <p class="mb-3 mt-2 fs-5 text-muted">You haven't placed any orders yet.</p>
                    <a href="<?= URLROOT; ?>/Pages/menu" class="btn btn-primary btn-lg">Browse Menu</a>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>


