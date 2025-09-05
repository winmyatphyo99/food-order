<?php require_once APPROOT . '/views/inc/header.php' ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php' ?>

    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container-fluid my-5">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h4 class="mb-3 mb-md-0 text-dark fw-bold"><i class="fas fa-receipt me-2 text-primary"></i> All Invoices</h4>
                    
                       
                    
                </div>

                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <div class="card shadow-lg rounded-4 border-0">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <?php if (isset($data['invoices']) && !empty($data['invoices'])): ?>
                                <table class="table table-hover align-middle">
                                    <thead class="text-uppercase text-muted">
                                        <tr>
                                            <th scope="col" style="width: 10%;">Invoice #</th>
                                            <th scope="col" style="width: 20%;">Customer</th>
                                            <th scope="col" style="width: 10%;">Subtotal</th>
                                            <th scope="col" style="width: 10%;">Delivery Fee</th>
                                            <th scope="col" style="width: 10%;">Tax</th>
                                            <th scope="col" style="width: 15%;">Grand Total</th>
                                            <th scope="col" style="width: 15%;">Date</th>
                                            <th scope="col" class="text-center" style="width: 10%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['invoices'] as $invoice): ?>
                                            <tr>
                                                <td class="fw-bold text-primary">#<?php echo htmlspecialchars($invoice['invoice_number']); ?></td>
                                                <td><?php echo htmlspecialchars($invoice['customer_name']); ?></td>
                                                <td class="text-success">$<?php echo htmlspecialchars(number_format($invoice['order_subtotal'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($invoice['delivery_fee'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($invoice['tax_amount'], 2)); ?></td>
                                                <td class="fw-bold text-dark">$<?php echo htmlspecialchars(number_format($invoice['grand_total'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars(date('M d, Y', strtotime($invoice['invoice_date']))); ?></td>
                                                <td class="text-center">
                                                    <a href="<?php echo URLROOT; ?>/OrderController/adminInvoice/<?php echo urlencode($invoice['order_id']); ?>"
                                                        class="btn btn-sm btn-outline-primary" title="View Invoice">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info text-center py-5 rounded-4 border-0" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> No invoices found.
                                </div>
                            <?php endif; ?>
                            <?php if (isset($data['invoices']) && !empty($data['invoices'])): ?>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div class="text-muted small">
                                        Showing
                                        <strong><?php echo htmlspecialchars(($data['currentPage'] - 1) * $data['invoicesPerPage'] + 1); ?></strong>
                                        to
                                        <strong><?php echo htmlspecialchars(min($data['currentPage'] * $data['invoicesPerPage'], $data['totalInvoices'])); ?></strong>
                                        of
                                        <strong><?php echo htmlspecialchars($data['totalInvoices']); ?></strong>
                                        entries
                                    </div>

                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mb-0">
                                            <li class="page-item <?php echo ($data['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="<?php echo URLROOT; ?>/InvoiceController/index/<?php echo htmlspecialchars($data['currentPage'] - 1); ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>

                                            <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                                                <li class="page-item <?php echo ($i == $data['currentPage']) ? 'active' : ''; ?>">
                                                    <a class="page-link" href="<?php echo URLROOT; ?>/InvoiceController/index/<?php echo htmlspecialchars($i); ?>">
                                                        <?php echo htmlspecialchars($i); ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>

                                            <li class="page-item <?php echo ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="<?php echo URLROOT; ?>/InvoiceController/index/<?php echo htmlspecialchars($data['currentPage'] + 1); ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>



<?php require_once APPROOT . '/views/inc/footer.php' ?>