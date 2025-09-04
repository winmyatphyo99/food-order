<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<style>
/* Google Fonts Import - Montserrat & Playfair Display */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap');

/* Global Body and Fonts */
body {
    background-color: #f0f2f5;
    /* Soft gray background */
    font-family: 'Montserrat', sans-serif;
    color: #495057;
    /* Dark gray text */
}

/* Dashboard Layout */
.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
    /* Ensure full height */
}

/* Main Content Area */
.main-content {
    flex-grow: 1;
    padding: 3rem;
    margin-left: 250px;
    /* Offset for the fixed sidebar */
}

.dashboard-header {
    margin-bottom: 2rem;
}

.dashboard-header h1 {
    font-weight: 700;
    color: #212529;
    font-size: 2.5rem;
    font-family: 'Playfair Display', serif;
}

.dashboard-header p {
    color: #6c757d;
}

/* Stat Cards */
.stat-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2.5rem 2rem;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.stat-card .icon-circle {
    background-color: #e9ecef;
    color: #495057;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin: 0 auto 1.2rem;
    border: 2px solid #ced4da;
}

.stat-card h3 {
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: #212529;
    font-size: 2rem;
}

.stat-card p {
    color: #6c757d;
    font-size: 1rem;
    margin-bottom: 0;
}

.stat-card.total .icon-circle {
    background-color: #d1e7dd;
    color: #0f5132;
    border-color: #a3cfb5;
}

.stat-card.pending .icon-circle {
    background-color: #fff3cd;
    color: #664d03;
    border-color: #ffecb5;
}

.stat-card.last-order .icon-circle {
    background-color: #cfe2ff;
    color: #084298;
    border-color: #b9d1f5;
}

/* Recent Orders Table */
.recent-orders-section {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 2rem;
    margin-top: 2rem;
}

.recent-orders-section h4 {
    font-weight: 700;
    color: #212529;
    font-family: 'Playfair Display', serif;
    margin-bottom: 1.5rem;
}

.table {
    border-collapse: separate;
    border-spacing: 0 0.5rem;
}

.table thead th {
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #6c757d;
    padding-bottom: 1rem;
}

.table tbody tr {
    transition: background-color 0.2s ease;
    border-radius: 8px;
    overflow: hidden;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
    border-top: none;
    padding: 1rem;
}

.table td:first-child {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.table td:last-child {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.badge {
    padding: 0.5em 0.8em;
    font-size: 0.8rem;
    font-weight: 600;
    border-radius: 50rem;
}
</style>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <div class="main-content">
        <div class="dashboard-header">
            <h1 class="fw-bold">Welcome, <?php echo htmlspecialchars($data['userName']); ?>!</h1>
            <p>Your dashboard provides a quick overview of your activity.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <a href="<?php echo URLROOT; ?>/OrderController/orderHistory" class="text-decoration-none">
                    <div class="stat-card total">
                        <div class="icon-circle">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h3><?php echo $data['totalOrders'] ?? 0; ?></h3>
                        <p>Total Orders</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?php echo URLROOT; ?>/CustomerController/orderHistory?status=pending" class="text-decoration-none">
                    <div class="stat-card pending">
                        <div class="icon-circle">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3><?php echo $data['pendingOrders'] ?? 0; ?></h3>
                        <p>Pending Orders</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?php echo URLROOT; ?>/OrderController/orderHistory" class="text-decoration-none">
                    <div class="stat-card last-order">
                        <div class="icon-circle">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3><?php echo $data['lastOrderDate'] ? date('M d, Y', strtotime($data['lastOrderDate'])) : 'N/A'; ?></h3>
                        <p>Last Order Date</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="recent-orders-section mt-5">
            <h4>Recent Orders</h4>
            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['recentOrders'])): ?>
                            <?php foreach ($data['recentOrders'] as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                    <td>$<?php echo number_format($order['total_amt'], 2); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php
                                            if ($order['status'] == 'Completed') echo 'bg-success';
                                            elseif ($order['status'] == 'Pending') echo 'bg-warning text-dark';
                                            else echo 'bg-info';
                                            ?>
                                        ">
                                            <?php echo htmlspecialchars($order['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/OrderController/orderHistory/<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill">View Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No recent orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>