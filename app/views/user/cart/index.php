<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <div class="main-content">
        <div class="container py-5" style="background-color: #f8f9fa;">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <h2 class="fw-bold mb-4 text-dark">🛍 Your Cart</h2>

                    <?php if (isset($data['cart_items']) && !empty($data['cart_items'])) : ?>

                        <form id="updateCartForm" action="<?php echo URLROOT; ?>/CartController/updateCart" method="POST" class="d-none">
                            <?php foreach ($data['cart_items'] as $item) : ?>
                                <input type="hidden" 
                                name="quantity[<?php echo $item['product_id']; ?>]" 
                                value="<?php echo htmlspecialchars($item['quantity']); ?>" 
                                class="quantity-input-hidden" 
                                data-product-id="<?php echo $item['product_id']; ?>">
                            <?php endforeach; ?>
                        </form>


                        <div class="list-group shadow-sm rounded-4">
                            <?php
                            $total = 0;
                            // CORRECTED: Change $data['cart'] to $data['cart_items']
                            foreach ($data['cart_items'] as $item) :
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            ?>
                                <div class="list-group-item border-0 d-flex flex-column flex-md-row align-items-center justify-content-between p-4 bg-white mb-3 rounded-4 shadow-sm">
                                    <div class="d-flex align-items-center mb-3 mb-md-0">
                                        <img src="<?php echo URLROOT; ?>/public/img/products/<?php echo htmlspecialchars($item['product_img']); ?>"
                                            alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                            class="rounded-3 me-3"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                        <div>
                                            <h5 class="fw-semibold mb-1"><?php echo htmlspecialchars($item['product_name']); ?></h5>
                                            <span class="text-muted small">$<?php echo htmlspecialchars($item['price']); ?> </span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                                        <div class="input-group input-group-sm shadow-sm rounded-3 overflow-hidden">
                                            <button type="button" class="btn btn-light decrease-quantity" data-id="<?php echo $item['product_id']; ?>">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number"
                                                class="form-control text-center border-0 quantity-input"
                                                data-product-id="<?php echo $item['product_id']; ?>"
                                                name="visible_quantity[<?php echo $item['product_id']; ?>]"
                                                value="<?php echo htmlspecialchars($item['quantity']); ?>"
                                                min="1" readonly>
                                            <button type="button" class="btn btn-light increase-quantity" data-id="<?php echo $item['product_id']; ?>">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="text-center">
                                            <p class="fw-bold text-success mb-0 subtotal-price" data-price="<?php echo htmlspecialchars($item['price']); ?>">$<?php echo number_format($subtotal, 2); ?></p>
                                        </div>
                                    </div>
                                    <div class="mt-3 mt-md-0">
                                        <form action="<?php echo URLROOT; ?>/CartController/removeFromCart" method="POST" class="remove-form d-inline-block">
                                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="fas fa-trash me-1"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-light border text-center py-5 rounded-4 shadow-sm">
                            <h5 class="fw-semibold mb-2">Your cart is empty 🛒</h5>
                            <p class="text-muted mb-3">Browse our menu and add something delicious.</p>
                            <a href="<?php echo URLROOT; ?>/Pages/menu" class="btn btn-primary rounded-pill">
                                <i class="fas fa-utensils me-2"></i> Start Shopping
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (isset($data['cart_items']) && !empty($data['cart_items'])) : ?>
                    <div class="col-lg-4">
                        <div class="card shadow-lg rounded-4 border-0 sticky-top" style="top: 90px;">
                            <div class="card-body p-0">
                                <button class="btn w-100 text-start fw-bold d-flex justify-content-between align-items-center p-3 rounded-top-4"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#orderSummaryCollapse"
                                    aria-expanded="true"
                                    aria-controls="orderSummaryCollapse"
                                    style="background-color:#ffc107; border: none;">
                                    <span><i class="fas fa-receipt me-2"></i> Order Summary</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>

                                <div class="collapse show" id="orderSummaryCollapse">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="text-muted">Subtotal</span>
                                            <span class="fw-semibold" id="cart-subtotal">$<?php echo number_format($total, 2); ?></span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="fw-bold">Grand Total</h5>
                                            <h5 class="fw-bold text-success" id="cart-total">$<?php echo number_format($total, 2); ?></h5>
                                        </div>
                                        <div class="d-grid gap-3">
                                            <button type="button" id="updateCartBtn" class="btn btn-outline-primary btn-lg rounded-pill shadow-sm">
                                                <i class="fas fa-sync-alt me-2"></i> Update Cart
                                            </button>

                                            <form action="<?php echo URLROOT; ?>/CartController/removeAll" method="POST" class="d-block">
                                                <button type="submit" class="btn btn-danger btn-lg rounded-pill shadow-sm w-100">
                                                    <i class="fas fa-trash-alt me-2"></i> Clear Cart
                                                </button>
                                            </form>
                                            <a href="<?php echo URLROOT; ?>/CartController/checkout"
                                                class="btn btn-warning btn-lg rounded-pill shadow-sm text-dark">
                                                <i class="fas fa-cash-register me-2"></i> Proceed to Checkout
                                            </a>
                                            <a href="<?php echo URLROOT; ?>/Pages/menu"
                                                class="btn btn-light btn-lg rounded-pill shadow-sm">
                                                <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateCartBtn = document.getElementById('updateCartBtn');
    const hiddenForm = document.getElementById('updateCartForm');

    // Plus/Minus buttons
    document.querySelectorAll('.increase-quantity, .decrease-quantity').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const input = document.querySelector(`input.quantity-input[data-product-id="${productId}"]`);
            const hiddenInput = document.querySelector(`input.quantity-input-hidden[data-product-id="${productId}"]`);
            let qty = parseInt(input.value);

            if (this.classList.contains('increase-quantity')) qty++;
            if (this.classList.contains('decrease-quantity')) qty = Math.max(0, qty - 1);

            input.value = qty;
            hiddenInput.value = qty;

            // Update subtotal price per item
            const price = parseFloat(input.closest('.list-group-item').querySelector('.subtotal-price').getAttribute('data-price'));
            input.closest('.list-group-item').querySelector('.subtotal-price').textContent = '$' + (price * qty).toFixed(2);
        });
    });

    // Update Cart button
    updateCartBtn.addEventListener('click', function() {
        const formData = new FormData(hiddenForm);

        fetch(hiddenForm.action, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Reload page after update to reflect latest cart from session/database
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error(err));
    });
});
</script>

