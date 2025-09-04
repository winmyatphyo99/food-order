<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>
    
    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <?php $database = new Database(); ?>
            <?php $orderItem = $database->readAll('order_items'); ?>

            <div class="container my-5">
                <div class="card shadow p-5">
                    <h4 class="mb-4">📜 Order Details</h4>

                    <?php require APPROOT . '/views/components/auth_message.php'; ?>

                    <?php if (!empty($data['order'])): ?>
                        <table class="table table-striped mb-4">
                            <tbody>
                                <tr>
                                    <td style="width: 30%;"><strong>Order ID:</strong></td>
                                    <td>#<?php echo htmlspecialchars($data['order']['order_id']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Customer Name:</strong></td>
                                    <td><?php echo htmlspecialchars($data['order']['customer_name']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Order Date:</strong></td>
                                    <td><?php echo htmlspecialchars(date("F j, Y", strtotime($data['order']['created_at']))); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($data['order']['status_name']); ?></span></td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Method:</strong></td>
                                    <td><?php echo htmlspecialchars(ucfirst($data['order']['payment_method_name'])); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <h5 class="fw-bold mt-4 mb-3">Order Items</h5>

                    <div class="table-responsive">
                        <?php if (!empty($data['order_items'])): ?>
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['order_items'] as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                            <td class="text-end">$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                            <td class="text-end">$<?php echo htmlspecialchars(number_format($item['quantity'] * $item['price'], 2)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-info text-center" role="alert">
                                No order items found for this order.
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($data['order'])): ?>
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-end fw-bold">Total Amount:</td>
                                            <td class="text-end">$<?php echo htmlspecialchars(number_format($data['order']['total_amt'], 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end fw-bold">Delivery fee:</td>
                                            <td class="text-end">$<?php echo htmlspecialchars(number_format($data['order']['delivery_fee'], 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end fw-bold">Tax Amount</td>
                                            <td class="text-end">$<?php echo htmlspecialchars(number_format($data['order']['tax_amount'], 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-end fw-bold">Grand Total:</td>
                                            <td class="text-end">$<?php echo htmlspecialchars(number_format($data['order']['grand_total'], 2)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="text-center mt-4">
                        <a href="<?php echo URLROOT; ?>/OrderController/index" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>