<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <div class="main-content">
        <div class="container my-5">
            <h2 class="text-center mb-4 fw-bold animated-title">Checkout</h2>
            <div class="row">
                <div class="col-md-7">
                    <div class="card shadow mb-4 floating-card">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Shipping Details</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo URLROOT; ?>/CartController/placeOrder" method="POST">
                                <div class="mb-3 animated-field">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">
                                </div>
                                <div class="mb-3 animated-field">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>">
                                </div>
                                <div class="mb-3 animated-field">
                                    <label for="delivery_address" class="form-label">Shipping Address</label>
                                    <textarea class="form-control" id="delivery_address" name="delivery_address" rows="3" required ></textarea>
                                </div>
                                <div class="mb-3 animated-field">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo isset($data['user_phone_number']) ? htmlspecialchars($data['user_phone_number']): ''; ?>">
                                </div>

                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-primary">Payment Method</h6>
                                    <?php if(isset($data['payments']) && is_array($data['payments'])): ?>
                                    <?php foreach ($data['payments'] as $index => $payment) : ?>
                                    <div class="form-check payment-option animated-field" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <input class="form-check-input" type="radio" name="payment_method_id" id="payment-<?php echo htmlspecialchars($payment['id']); ?>" value="<?php echo htmlspecialchars($payment['id']); ?>"<?php echo ($payment['id'] == 1 ) ? 'checked' : '' ;?>>
                                        <label class="form-check-label" for="payment-<?php echo htmlspecialchars($payment['id']); ?>">
                                           <?php echo htmlspecialchars($payment['payment_name']); ?>
                                           </label>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                       <p class="text-danger">No Payments Available.</p>
                                    <?php endif;?>
                                </div>

                                <hr class="my-4">
                                <button type="submit" class="btn btn-warning btn-lg w-100 pulse-animation">Place Order</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card shadow mb-4 floating-card">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Order Summary</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush mb-3">
                                <?php if (isset($data['cart']) && is_array($data['cart'])): ?>
                                    <?php foreach ($data['cart'] as $index => $item) : ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center animated-item" style="animation-delay: <?php echo $index * 0.07; ?>s">
                                            <div>
                                                <h6 class="my-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                                <small class="text-muted">Qty: <?php echo htmlspecialchars($item['quantity']); ?> x $<?php echo htmlspecialchars($item['price']); ?></small>
                                            </div>
                                            <span class="text-muted">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>

                            <hr>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr class="animated-summary-item">
                                        <td class="text-right"><strong>Subtotal:</strong></td>
                                        <td class="text-right">$<?php echo htmlspecialchars(number_format($data['subtotal'], 2)); ?></td>
                                    </tr>
                                    <tr class="animated-summary-item" style="animation-delay: 0.1s">
                                        <td class="text-right"><strong>Delivery Fee:</strong></td>
                                        <td class="text-right">$<?php echo htmlspecialchars(number_format($data['delivery_fee'], 2)); ?></td>
                                    </tr>
                                    <tr class="animated-summary-item" style="animation-delay: 0.2s">
                                        <td class="text-right"><strong>Tax (5%):</strong></td>
                                        <td class="text-right">$<?php echo htmlspecialchars(number_format($data['tax_amount'], 2)); ?></td>
                                    </tr>
                                    <tr class="table-active animated-summary-item" style="animation-delay: 0.3s">
                                        <td class="text-right"><strong>Grand Total:</strong></td>
                                        <td class="text-right"><strong>$<?php echo htmlspecialchars(number_format($data['grand_total'], 2)); ?></strong></td>
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

<style>
.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
    background-color: #f4f6f9;
}

.main-content {
    flex: 1;
    padding: 20px;
    margin-left: 100px;
    margin-right: 100px;
    background-color: #f8f9fa;
}
body {
    background-color: #f4f7f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}



/* Floating animation for cards */
.floating-card {
    animation: float 6s ease-in-out infinite;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.floating-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
}

/* Title animation */
.animated-title {
    animation: fadeInDown 1s ease-out, subtleFloat 4s ease-in-out infinite;
    animation-delay: 0.1s;
    color: #2c3e50;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
}

/* Form field animations */
.animated-field {
    opacity: 0;
    animation: slideInLeft 0.7s forwards;
}

/* Cart item animations */
.animated-item {
    opacity: 0;
    animation: fadeInRight 0.7s forwards;
}

/* Summary animations */
.animated-summary-item {
    opacity: 0;
    animation: fadeInUp 0.7s forwards;
}

/* Payment option styling */
.payment-option {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 8px;
    transition: all 0.3s ease;
}

.payment-option:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

/* Place order button animation */
.pulse-animation {
    animation: pulse 2s infinite;
    transition: all 0.3s ease;
}

.pulse-animation:hover {
    transform: scale(1.03);
    animation: none;
}

/* Keyframe animations */
@keyframes float {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
    100% {
        transform: translateY(0px);
    }
}

@keyframes subtleFloat {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-5px);
    }
    100% {
        transform: translateY(0px);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
    }
}

/* Staggered animations for form fields */
.animated-field:nth-child(1) { animation-delay: 0.1s; }
.animated-field:nth-child(2) { animation-delay: 0.2s; }
.animated-field:nth-child(3) { animation-delay: 0.3s; }
.animated-field:nth-child(4) { animation-delay: 0.4s; }

/* Responsive adjustments */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
    }
    
    .floating-card {
        animation: subtleFloat 6s ease-in-out infinite;
    }
}
</style>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>