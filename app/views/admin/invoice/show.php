<?php 
    require_once APPROOT . '/views/inc/header.php'; 
    
    // Initialize subtotal and calculate it from the fetched items
    $subtotal = 0;
    if (!empty($data['items'])) {
        foreach ($data['items'] as $item) {
            $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        }
    }
    // Get the fees and calculate the grand total
    $deliveryFee = $data['order']->delivery_fee ?? 0;
    $taxAmount = $data['order']->tax_amount ?? 0;
    $grandTotal = $subtotal + $deliveryFee + $taxAmount;
?>

<div class="dashboard-wrapper">
    <?php if ($data['role'] === 'admin'): ?>
        <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>
    <?php endif; ?>

    <main class="main-content">
        <?php if ($data['role'] === 'admin'): ?>
            <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>
        <?php endif; ?>

        <div class="content-area">
            <div class="container-fluid my-5">
                <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
                    <h4 class="mb-0 text-dark fw-bold">
                        <i class="fas fa-receipt me-2 text-primary"></i> Invoice
                    </h4>
                    <div>
                        <?php if ($data['role'] === 'admin'): ?>
                            <a href="<?php echo URLROOT; ?>/OrderController/index" 
                               class="btn btn-outline-secondary px-4 me-2">
                               <i class="fas fa-arrow-left me-2"></i> Back to Orders
                            </a>
                        <?php else: ?>
                            <a href="<?php echo URLROOT; ?>/OrderController/orderHistory" 
                               class="btn btn-outline-secondary px-4 me-2">
                               <i class="fas fa-list me-2"></i> My Orders
                            </a>
                        <?php endif; ?>

                        <button onclick="printInvoice()" class="btn btn-primary px-4">
                            <i class="fas fa-print me-2"></i> 
                            <?php echo ($data['role'] === 'admin') ? 'Print Official Copy' : 'Print'; ?>
                        </button>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div id="invoiceArea" class="card shadow-lg border-0 rounded-4">
                            <div class="card-body p-4 p-md-5">
                                <div class="row align-items-center mb-5">
                                    <div class="col-md-6">
                                        <h1 class="mb-1 text-primary fw-bold">Invoice</h1>
                                        <p class="text-muted small">
                                            #<?php echo htmlspecialchars($data['order']->invoice_number ?? 'N/A'); ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <h5 class="mb-1 text-dark fw-bold">Your Restaurant Name</h5>
                                        <p class="mb-0 text-muted">123 Main Street, Yangon</p>
                                        <p class="mb-0 text-muted">Phone: (123) 456-7890</p>
                                        <p class="mb-0 text-muted">
                                            Date: <?php echo htmlspecialchars(date('M d, Y', strtotime($data['order']->created_at ?? 'now'))); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <h6 class="text-dark fw-bold mb-2">Bill To:</h6>
                                        <p class="mb-0 fw-bold"><?php echo htmlspecialchars($data['order']->customer_name ?? 'N/A'); ?></p>
                                        <p class="mb-0 text-muted"><?php echo htmlspecialchars($data['order']->customer_email ?? 'N/A'); ?></p>
                                        <p class="mb-0 text-muted"><?php echo htmlspecialchars($data['order']->customer_phone_number ?? 'N/A'); ?></p>
                                        <p class="mb-0 text-muted"><?php echo htmlspecialchars($data['order']->delivery_address ?? 'N/A'); ?></p>
                                    </div>
                                    <div class="col-md-6 mt-4 mt-md-0 text-md-end">
                                        <h6 class="text-dark fw-bold mb-2">Order Information:</h6>
                                        <p class="mb-0"><span class="text-muted me-2">Order ID:</span> 
                                            <span class="fw-bold">#<?php echo htmlspecialchars($data['order']->order_id ?? 'N/A'); ?></span>
                                        </p>
                                        <p class="mb-0"><span class="text-muted me-2">Payment:</span> 
                                            <?php echo htmlspecialchars($data['order']->payment_method_name ?? 'N/A'); ?>
                                        </p>
                                        <p class="mb-0">
                                            <span class="text-muted me-2">Status:</span>
                                            <?php
                                                $status = strtolower($data['order']->status_name ?? 'unknown');
                                                $badge_class = match ($status) {
                                                    'pending'   => 'bg-warning text-dark',
                                                    'confirmed' => 'bg-primary',
                                                    'completed' => 'bg-success',
                                                    'cancelled' => 'bg-danger',
                                                    default     => 'bg-secondary',
                                                };
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>">
                                                <?php echo ucfirst($status); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="table-responsive mb-4">
                                    <h6 class="fw-bold mb-3">Order Items</h6>
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light text-uppercase text-muted">
                                            <tr>
                                                <th>Description</th>
                                                <th class="text-end">Price</th>
                                                <th class="text-end">Qty</th>
                                                <th class="text-end">Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($data['items'])): ?>
                                                <?php foreach ($data['items'] as $item) : ?>
                                                    <?php
                                                    $itemTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($item['product_name'] ?? 'N/A'); ?></td>
                                                        <td class="text-end">$<?php echo number_format($item['price'] ?? 0, 2); ?></td>
                                                        <td class="text-end"><?php echo htmlspecialchars($item['quantity'] ?? 0); ?></td>
                                                        <td class="text-end fw-bold">$<?php echo number_format($itemTotal, 2); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-5">No items found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-sm-6 col-md-5">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td class="text-end text-muted">Subtotal:</td>
                                                    <td class="text-end fw-bold">$<?php echo number_format($subtotal, 2); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-end text-muted">Delivery Fee:</td>
                                                    <td class="text-end fw-bold">$<?php echo number_format($deliveryFee, 2); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-end text-muted">Tax:</td>
                                                    <td class="text-end fw-bold">$<?php echo number_format($taxAmount, 2); ?></td>
                                                </tr>
                                                <tr class="fw-bold h5">
                                                    <td class="text-end border-top pt-3 text-dark">Grand Total:</td>
                                                    <td class="text-end border-top pt-3 text-primary">$<?php echo number_format($grandTotal, 2); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function printInvoice() {
        let content = document.getElementById("invoiceArea").innerHTML;
        let original = document.body.innerHTML;
        document.body.innerHTML = content;
        window.print();
        document.body.innerHTML = original;
        location.reload();
    }
    </script>

    <style>
    @media print {
        body * { visibility: hidden; }
        #invoiceArea, #invoiceArea * { visibility: visible; }
        #invoiceArea { position: absolute; left: 0; top: 0; width: 100%; }
        .d-print-none { display: none !important; }
    }
    </style>

    <?php require_once APPROOT . '/views/inc/footer.php'; ?>