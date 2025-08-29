<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<div class="container my-5">
    <div class="card shadow p-5">
        <h4 class="mb-4">Order Details</h4>

        <table class="table table-striped mb-4">
            <tbody>
                <tr>
                    <td style="width: 30%;"><strong>Order ID:</strong></td>
                    <td>#<?php echo htmlspecialchars($data['order_details']->order_id); ?></td>
                </tr>
                <tr>
                    <td><strong>Order Date:</strong></td>
                    <td><?php echo htmlspecialchars(date("F j, Y", strtotime($data['order_details']->created_at))); ?></td>
                </tr>
                <tr>
                    <td><strong>Status:</strong></td>
                    <td><?php echo htmlspecialchars(ucfirst($data['order_details']->status_name)); ?></td>
                </tr>
                <tr>
                    <td><strong>Payment Method:</strong></td>
                    <td><?php echo htmlspecialchars(ucfirst($data['order_details']->payment_method_name)); ?></td>
                </tr>
            </tbody>
        </table>

        <h5 class="fw-bold mt-4 mb-3">Order Items</h5>
        
        <div class="table-responsive">
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
                    <?php foreach ($data['order_items'] as $item) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td class="text-end">$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td class="text-end">$<?php echo htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="text-end fw-bold">Subtotal:</td>
                            <td class="text-end">$<?php echo htmlspecialchars(number_format($data['order_details']->total_amt, 2)); ?></td>
                        </tr>
                        <tr>
                            <td class="text-end fw-bold">Delivery Fee:</td>
                            <td class="text-end">$<?php echo htmlspecialchars(number_format($data['order_details']->delivery_fee, 2)); ?></td>
                        </tr>
                        <tr>
                            <td class="text-end fw-bold">Tax:</td>
                            <td class="text-end">$<?php echo htmlspecialchars(number_format($data['order_details']->tax_amount, 2)); ?></td>
                        </tr>
                        <tr class="table-active fw-bold">
                            <td class="text-end">Grand Total:</td>
                            <td class="text-end">$<?php echo htmlspecialchars(number_format($data['order_details']->grand_total, 2)); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo URLROOT; ?>/OrderController/orderHistory" class="btn btn-primary text-white"><i class="fas fa-list"></i> Go to Order List</a>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>