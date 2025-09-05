<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<style>/* ------------------------------
   Global Layout
---------------------------------*/
.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
    background-color: #f4f6f9;
}

body {
        background-color: #f0f2f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--dark);
        line-height: 1.6;
    }
.main-content {
    flex: 1;
    padding: 20px;
}

/* ------------------------------
   Cart Page Styling
---------------------------------*/
h2 {
    font-size: 1.8rem;
    color: #333;
}

.list-group {
    border: none;
    background: transparent;
}

.list-group-item {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.list-group-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}
/* Card header toggle button */
.card-body > button {
    font-size: 1.1rem;
    font-weight: 600;
}

.card-body > button i {
    transition: transform 0.3s ease;
}

.card-body > button[aria-expanded="true"] i {
    transform: rotate(180deg); /* Rotate arrow when open */
}

/* Product Image */
.list-group-item img {
    border: 2px solid #eee;
    transition: border-color 0.3s;
}
.list-group-item img:hover {
    border-color: #007bff;
}

/* Product Name & Price */
.list-group-item h5 {
    font-size: 1.1rem;
    color: #212529;
}
.list-group-item span.text-muted {
    font-size: 0.9rem;
}

/* Quantity Input Group */
.input-group .btn {
    border: none;
    background-color: #f1f3f5;
    transition: background 0.2s;
}
.input-group .btn:hover {
    background-color: #e9ecef;
}
.quantity-input {
    max-width: 60px;
    font-weight: 600;
}

/* Subtotal Price */
.subtotal-price {
    font-size: 1rem;
    color: #28a745;
}

/* Remove Button */
.remove-form button {
    transition: background 0.2s, color 0.2s;
}
.remove-form button:hover {
    background: #dc3545;
    color: #fff;
}

/* ------------------------------
   Empty Cart Message
---------------------------------*/
.alert {
    max-width: 500px;
    margin: auto;
    border-radius: 15px;
}

/* ------------------------------
   Order Summary Card
---------------------------------*/
.card {
    border-radius: 20px;
    overflow: hidden;
}
.card-body h4 {
    font-size: 1.3rem;
    color: #444;
}
#cart-subtotal, #cart-total {
    font-size: 1.1rem;
}

/* Order Summary Buttons */
.card .btn {
    font-weight: 600;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
}

/* Continue Shopping */
.card .btn-light {
    border: 1px solid #ddd;
}
.card .btn-light:hover {
    background-color: #f8f9fa;
}

/* Sticky Sidebar */
.sticky-top {
    z-index: 1020;
}
</style>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <div class="main-content">
        <div class="container py-5" style="background-color: #f8f9fa;">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <h2 class="fw-bold mb-4 text-dark">🛍 Your Cart</h2>
            <?php if (isset($data['cart']) && !empty($data['cart'])) : ?>

                <form id="updateCartForm" action="<?php echo URLROOT; ?>/CartController/updateCart" method="POST" class="d-none">
                    <?php foreach ($data['cart'] as $item) : ?>
                        <input type="hidden" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo htmlspecialchars($item['quantity']); ?>" class="quantity-input-hidden" data-product-id="<?php echo $item['id']; ?>">
                    <?php endforeach; ?>
                </form>

                <div class="list-group shadow-sm rounded-4">
                    <?php
                    $total = 0;
                    foreach ($data['cart'] as $item) :
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <div class="list-group-item border-0 d-flex flex-column flex-md-row align-items-center justify-content-between p-4 bg-white mb-3 rounded-4 shadow-sm">
                            <div class="d-flex align-items-center mb-3 mb-md-0">
                                <img src="<?php echo URLROOT; ?>/img/products/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>"
                                    class="rounded-3 me-3"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <h5 class="fw-semibold mb-1"><?php echo htmlspecialchars($item['name']); ?></h5>
                                    <span class="text-muted small">$<?php echo htmlspecialchars($item['price']); ?> </span>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                                <div class="input-group input-group-sm shadow-sm rounded-3 overflow-hidden">
                                    <button type="button" class="btn btn-light decrease-quantity" data-id="<?php echo $item['id']; ?>">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number"
                                        class="form-control text-center border-0 quantity-input"
                                        data-product-id="<?php echo $item['id']; ?>"
                                        value="<?php echo htmlspecialchars($item['quantity']); ?>"
                                        min="1" readonly>
                                    <button type="button" class="btn btn-light increase-quantity" data-id="<?php echo $item['id']; ?>">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="text-center">
                                    <p class="fw-bold text-success mb-0 subtotal-price" data-price="<?php echo htmlspecialchars($item['price']); ?>">$<?php echo number_format($subtotal, 2); ?></p>
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <form action="<?php echo URLROOT; ?>/CartController/removeFromCart" method="POST" class="remove-form d-inline-block">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
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

        <?php if (isset($data['cart']) && !empty($data['cart'])) : ?>
        <div class="col-lg-4">
    <div class="card shadow-lg rounded-4 border-0 sticky-top" style="top: 90px;">
        <div class="card-body p-0">
            
            <!-- Dropdown Toggle inside the card header -->
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

            <!-- Collapsible Content -->
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
        const updateCartForm = document.getElementById('updateCartForm');
        const updateCartBtn = document.getElementById('updateCartBtn');

        if (updateCartBtn && updateCartForm) {
            updateCartBtn.addEventListener('click', function() {
                updateCartForm.submit();
            });
        }

        document.querySelectorAll('.increase-quantity, .decrease-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.id;
                const quantityInput = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
                const hiddenInput = document.querySelector(`.quantity-input-hidden[data-product-id="${productId}"]`);

                let currentValue = parseInt(quantityInput.value);
                const isIncrease = this.classList.contains('increase-quantity');

                if (isIncrease) {
                    currentValue++;
                } else if (currentValue > 1) {
                    currentValue--;
                }

                quantityInput.value = currentValue;
                hiddenInput.value = currentValue;
            });
        });
    });
</script>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>