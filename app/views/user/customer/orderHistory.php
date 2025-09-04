<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>

<div class="main-content">
    <div class="container">
        <h2 class="fw-bold mb-4">📜 Order History</h2>
        
        <?php if (!empty($data['orders'])): ?>
            <div class="orders-list">
                <?php foreach ($data['orders'] as $order): ?>
                    <div class="order-card p-4 mb-3 rounded-4 shadow-sm d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <i class="fas fa-receipt text-primary me-3" style="font-size: 2rem;"></i>
                            <div>
                                <h5 class="fw-bold mb-0">Order #<?php echo htmlspecialchars($order['id']); ?></h5>
                                <p class="text-muted mb-0"><small>Placed on <?php echo date('M d, Y', strtotime($order['created_at'])); ?></small></p>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
                            <div class="text-start text-md-center">
                                <p class="mb-0 text-muted"><small>Total Amount</small></p>
                                <h6 class="fw-bold mb-0 text-success">$<?php echo number_format($order['total_amt'], 2); ?></h6>
                            </div>
                            <div class="text-start text-md-center">
                                <p class="mb-0 text-muted"><small>Status</small></p>
                                <span class="badge 
                                    <?php 
                                        if ($order['status'] == 'Confirmed') echo 'bg-success';
                                        elseif ($order['status'] == 'Pending') echo 'bg-warning text-dark';
                                        elseif ($order['status'] == 'Cancelled') echo 'bg-danger';
                                        else echo 'bg-secondary'; 
                                    ?>
                                ">
                                    <?php echo htmlspecialchars($order['status']); ?>
                                </span>
                            </div>
                            <div class="ms-md-4">
                                <a href="<?php echo URLROOT; ?>/CartController/orderConfirmation/<?php echo $order['id']; ?>" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-info-circle me-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center mt-5" role="alert">
                <i class="fas fa-info-circle me-2"></i> You have not placed any orders yet.
            </div>
        <?php endif; ?>
    </div>
</div>
<style>/* Card-based Order History Layout */
.container {
    padding: 2rem;
}

.order-card {
    background-color: #fff;
    border: 1px solid #e9ecef;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.order-card h5 {
    color: #2c3e50;
    font-size: 1.25rem;
}

.order-card .text-muted {
    font-size: 0.85rem;
}

/* Specific badge styles */
.badge.bg-warning {
    color: #333 !important;
}

.btn-primary {
    background-color: #3498db;
    border-color: #3498db;
}

.btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

/* Main Content Wrapper */
.main-content {
    margin-left: 250px; /* This is the key. It offsets the main content by the width of the sidebar. */
    padding: 2rem; /* Add padding for spacing */
    flex-grow: 1; /* Allows it to take up the remaining space */
    background-color: #f8f9fa; /* A light, professional background color */
}</style>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>