<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>

<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h3 class="card-title text-center fw-bold mb-4 text-primary">My Order History</h3>
            <hr class="mb-4">

            <?php if (empty($data['orders'])): ?>
                <div class="alert alert-info text-center shadow-sm rounded">
                    You have no orders in your history.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase">
                            <tr>
                                <th scope="col" class="text-secondary fw-bold py-3">Order ID</th>
                                <th scope="col" class="text-secondary fw-bold py-3">Order Date</th>
                                <th scope="col" class="text-secondary fw-bold py-3">Total Amount</th>
                                <th scope="col" class="text-secondary fw-bold py-3">Payment Method</th>
                                <th scope="col" class="text-secondary fw-bold py-3">Status</th>
                                <th scope="col" class="text-center text-secondary fw-bold py-3">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['orders'] as $order): ?>
                                <tr>
                                    <td class="fw-bold text-primary">#<?php echo htmlspecialchars($order['order_id']); ?></td>
                                    <td><?php echo htmlspecialchars(date('M d, Y', strtotime($order['order_date']))); ?></td>
                                    <td class="text-success fw-bold">$<?php echo htmlspecialchars(number_format($order['grand_total'], 2)); ?></td>
                                    <td>
                                        <i class="fas fa-money-bill-wave text-info me-1"></i>
                                        <?php echo htmlspecialchars($order['payment_method']); ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $status = strtolower($order['status']);
                                            $badge_class = 'bg-secondary';
                                            switch ($status) {
                                                case 'pending': $badge_class = 'bg-warning text-dark'; break;
                                                case 'confirmed': $badge_class = 'bg-info text-white'; break;
                                                case 'completed': $badge_class = 'bg-success'; break;
                                                case 'cancelled': $badge_class = 'bg-danger'; break;
                                            }
                                        ?>
                                        <span class="badge <?php echo htmlspecialchars($badge_class); ?> px-3 py-2 rounded-pill fw-semibold">
                                            <?php echo htmlspecialchars(ucfirst($order['status'])); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($order['status'] == 'completed' || $order['status'] == 'confirmed'): ?>
                                            <a href="<?php echo URLROOT; ?>/OrderController/userInvoice/<?php echo htmlspecialchars($order['order_id']); ?>" class="btn btn-sm btn-outline-primary shadow-sm rounded-pill">
                                                <i class="fas fa-eye me-1"></i> View Invoice Details
                                            </a>
                                        <?php elseif ($order['status'] == 'pending'): ?>
                                            <a href="<?php echo URLROOT; ?>/OrderController/cancel/<?php echo htmlspecialchars($order['order_id']); ?>"
                                               class="btn btn-sm btn-outline-danger shadow-sm rounded-pill"
                                               onclick="return confirm('Are you sure you want to cancel this order?');">
                                                <i class="fas fa-times-circle me-1"></i> Cancel Order
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">No details available</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>