<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<style>
    /* Modern CSS Variables for Consistent Theme */
    :root {
        --primary: #3498db;
        --primary-dark: #2980b9;
        --secondary: #2ecc71;
        --accent: #f39c12;
        --light: #f8f9fa;
        --dark: #343a40;
        --gray: #6c757d;
        --light-gray: #e9ecef;
        --border-radius: 0.75rem;
        --box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    /* General body and container styling */
    body {
        background-color: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--dark);
        line-height: 1.6;
    }

    .main-content {
        flex-grow: 1;
        padding-bottom: 5rem;
    }

    .container.my-5 {
        padding-top: 5rem;
        padding-bottom: 5rem;
    }
    
    /* Card Styling */
    .card.shadow {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        overflow: hidden;
        background: white;
    }

    .card.shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.12);
    }
    
    .card-header {
        background: linear-gradient(120deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 1.5rem;
        border-bottom: 0;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    /* Table Styling */
    .table-striped > tbody > tr:nth-of-type(odd) > * {
        background-color: rgba(52, 152, 219, 0.05);
    }

    .table-bordered {
        border-radius: var(--border-radius);
        overflow: hidden;
        border: 1px solid var(--light-gray);
    }
    
    .table thead th {
        background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
        border-top: 0;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        color: var(--dark);
        vertical-align: middle;
    }
    
    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-color: var(--light-gray);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.1);
        transform: scale(1.01);
        transition: var(--transition);
    }
    
    /* Active Row for Totals */
    .table-active {
        background: linear-gradient(to right, rgba(52, 152, 219, 0.2), rgba(52, 152, 219, 0.1)) !important;
        font-weight: bold;
        color: var(--primary-dark);
    }
    
    .table-active td {
        border-top: 2px solid var(--primary);
        font-size: 1.1rem;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 0.35rem 0.8rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Button Styling */
    .btn-primary {
        background: linear-gradient(to right, var(--primary), var(--primary-dark));
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(52, 152, 219, 0.4);
        background: linear-gradient(to right, var(--primary-dark), var(--primary));
    }
    
    .btn-primary:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: 0.5s;
    }
    
    .btn-primary:hover:before {
        left: 100%;
    }

    /* Order Summary Section */
    .order-summary {
        background: var(--light);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
    }
    
    .summary-title {
        border-bottom: 2px solid var(--primary);
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
        color: var(--primary-dark);
        font-weight: 600;
    }
    
    /* Info Cards */
    .info-card {
        background: var(--light);
        border-left: 4px solid var(--primary);
        border-radius: 0 var(--border-radius) var(--border-radius) 0;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, 0.03);
        transition: var(--transition);
    }
    
    .info-card:hover {
        transform: translateX(5px);
        box-shadow: 0 0.35rem 0.75rem rgba(0, 0, 0, 0.06);
    }
    
    .info-card strong {
        color: var(--primary-dark);
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-card span {
        color: var(--dark);
        font-size: 1.1rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        .table thead {
            display: none;
        }
        
        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid var(--light-gray);
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        
        .table tbody td {
            display: block;
            text-align: right;
            padding: 0.75rem;
            position: relative;
            padding-left: 50%;
        }
        
        .table tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 0.75rem;
            width: calc(50% - 0.75rem);
            padding-right: 0.75rem;
            text-align: left;
            font-weight: 600;
            color: var(--primary-dark);
        }
        
        .order-summary {
            padding: 1rem;
        }
    }
    
    /* Animation for page load */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card.shadow {
        animation: fadeIn 0.6s ease-out;
    }
    
    /* Hover effects for table rows */
    .table-hover tbody tr {
        transition: var(--transition);
    }
    
    /* Icon styling */
    .fas {
        margin-right: 0.5rem;
    }
</style>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <div class="main-content">
        <div class="container my-5">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-receipt"></i> Order Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-card">
                                <strong>Order ID</strong>
                                <span>#<?php echo htmlspecialchars($data['order_details']->order_id); ?></span>
                            </div>
                            <div class="info-card">
                                <strong>Order Date</strong>
                                <span><?php echo htmlspecialchars(date("F j, Y", strtotime($data['order_details']->created_at))); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <strong>Status</strong>
                                <span class="status-badge" style="background: <?php 
                                    $status = strtolower($data['order_details']->status_name);
                                    if($status == 'completed') echo '#2ecc71';
                                    elseif($status == 'pending') echo '#f39c12';
                                    else echo '#3498db';
                                ?>; color: white;">
                                    <?php echo htmlspecialchars(ucfirst($data['order_details']->status_name)); ?>
                                </span>
                            </div>
                            <div class="info-card">
                                <strong>Payment Method</strong>
                                <span><?php echo htmlspecialchars(ucfirst($data['order_details']->payment_method_name)); ?></span>
                            </div>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-4 mb-3"><i class="fas fa-shopping-basket"></i> Order Items</h5>
                    
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
                                        <td data-label="Product"><?php echo htmlspecialchars($item['product_name']); ?></td>
                                        <td data-label="Price" class="text-end">$<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                                        <td data-label="Quantity" class="text-center"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td data-label="Subtotal" class="text-end">$<?php echo htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end mt-4">
                        <div class="col-md-6">
                            <div class="order-summary">
                                <h5 class="summary-title">Order Summary</h5>
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
                    </div>

                    <div class="text-center mt-5">
                        <a href="<?php echo URLROOT; ?>/OrderController/orderHistory" class="btn btn-primary text-white"><i class="fas fa-arrow-left"></i> Back to Order List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>