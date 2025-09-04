<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container-fluid my-5">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h4 class="mb-3 mb-md-0 text-dark fw-bold"><i class="fas fa-shopping-bag me-2 text-primary"></i> All Orders</h4>
                    <a href="<?php echo URLROOT; ?>/OrderController/create" class="btn btn-primary px-4 shadow-sm fw-bold">
                        <i class="fas fa-plus me-2"></i> Add New Order
                    </a>
                </div>

                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <div class="card shadow-lg rounded-4 border-0">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <?php if (!empty($data['orders'])): ?>
                                <table class="table table-hover align-middle">
                                    <thead class="text-uppercase text-muted">
                                        <tr>
                                            <th scope="col">Order #</th>
                                            <th scope="col">Customer #</th>
                                            <th scope="col">Total Amount</th>
                                            <th scope="col">Order Status</th>
                                            <th scope="col">Order Date</th>
                                            <th scope="col" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['orders'] as $order): ?>
                                            <tr>
                                                <td>
                                                    <h6 class="mb-0 fw-bold text-primary">#<?php echo htmlspecialchars($order['id']); ?></h6>
                                                </td>
                                                <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                                                <td class="fw-bold text-success">$<?php echo htmlspecialchars(number_format($order['total_amt'], 2)); ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $status = strtolower($order['status']);
                                                    $badge_class = '';
                                                    $status_text = '';

                                                    switch ($status) {
                                                        case 'pending':
                                                            $badge_class = 'bg-warning text-dark';
                                                            $status_text = 'Pending';
                                                            break;
                                                        case 'processing':
                                                            $badge_class = 'bg-info text-white';
                                                            $status_text = 'Processing';
                                                            break;
                                                        case 'confirmed': 
                                                            $badge_class = 'bg-success';
                                                            $status_text = 'Confirmed';
                                                            break;
                                                        case 'completed':
                                                            $badge_class = 'bg-success';
                                                            $status_text = 'Completed';
                                                            break;
                                                        case 'cancelled':
                                                            $badge_class = 'bg-danger';
                                                            $status_text = 'Cancelled';
                                                            break;
                                                        default:
                                                            $badge_class = 'bg-secondary';
                                                            $status_text = 'Unknown';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $badge_class; ?> rounded-pill px-3 py-2">
                                                        <?php echo $status_text; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars(date('M d, Y', strtotime($order['created_at']))); ?></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="<?php echo URLROOT; ?>/OrderItemController/show/<?php echo $order['id']; ?>"
                                                            class="btn btn-sm btn-outline-primary me-2" title="View Order Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?php echo URLROOT; ?>/OrderController/edit/<?php echo $order['id']; ?>"
                                                            class="btn btn-sm btn-outline-secondary me-2" title="Edit Order">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <?php if ($order['status'] != 'cancelled' && $order['status'] != 'completed'): ?>
                                                            <a href="<?php echo URLROOT; ?>/OrderController/cancel/<?php echo base64_encode($order['id']); ?>"
                                                               class="btn btn-sm btn-outline-danger me-2" title="Cancel Order"
                                                               onclick="return confirm('Are you sure you want to cancel this order? This will restore the products to stock.');">
                                                                <i class="fas fa-times-circle"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <a href="<?php echo URLROOT; ?>/OrderController/destroy/<?php echo base64_encode($order['id']); ?>"
                                                            class="btn btn-sm btn-outline-danger" title="Delete Order"
                                                            onclick="return confirm('Are you sure you want to delete this order?');">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info text-center py-5 rounded-4 border-0" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> No orders found. Please add a new one.
                                </div>
                            <?php endif; ?>
                        </div>
                         <?php if (isset($data['pagination']) && $data['pagination']['totalPages'] > 1): ?>
                            <nav aria-label="Order Page Navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php
                                    $currentPage = $data['pagination']['currentPage'];
                                    $totalPages = $data['pagination']['totalPages'];
                                    $urlRoot = URLROOT . '/OrderController/index';
                                    ?>
                                    
                                    <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo $urlRoot; ?>?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                            <a class="page-link" href="<?php echo $urlRoot; ?>?page=<?php echo $i; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo $urlRoot; ?>?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>