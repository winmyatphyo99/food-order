<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>
    
    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container-fluid my-5">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h4 class="mb-3 mb-md-0 text-dark fw-bold"><i class="fas fa-spinner me-2 text-warning"></i> Pending Orders</h4>
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
                                            <th scope="col">User ID</th>
                                            <th scope="col">Grand Total</th>
                                            <th scope="col">Status</th>
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
                                                <td class="fw-bold text-success">
                                                    $<?php echo htmlspecialchars(number_format($order['grand_total'], 2)); ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                        Pending
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars(date('M d, Y', strtotime($order['created_at']))); ?></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="<?php echo URLROOT; ?>/OrderItemController/show/<?php echo $order['id']; ?>"
                                                            class="btn btn-sm btn-outline-info me-2" title="View Order Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?php echo URLROOT; ?>/admin/confirmOrder/<?php echo $order['id']; ?>"
                                                            class="btn btn-sm btn-outline-success" title="Confirm Order"
                                                            onclick="return confirm('Are you sure you want to confirm this order?');">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info text-center py-5 rounded-4 border-0" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> No pending orders found.
                                </div>
                            <?php endif; ?>
                            <!-- Pagination -->
<?php if (isset($data['pagination']) && $data['pagination']['totalPages'] > 1): ?>
    <nav aria-label="Order Page Navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php
            $currentPage = $data['pagination']['currentPage'];
            $totalPages  = $data['pagination']['totalPages'];
            $urlRoot = URLROOT . '/AdminController/home'; 
            ?>
            
            <!-- Prev Button -->
            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $urlRoot; ?>?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link" href="<?php echo $urlRoot; ?>?page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next Button -->
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
        </div>
    </main>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>