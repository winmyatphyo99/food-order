<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>
    
    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container my-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Create New Order</h3>
                    <a href="<?php echo URLROOT; ?>/OrderController/index" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
                
                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card shadow border-0">
                            <div class="card-header bg-warning text-white">
                                <h4 class="mb-0">Order Details</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo URLROOT; ?>/OrderController/store" method="POST">
                                    
                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">Select User</label>
                                        <select name="user_id" id="user_id" class="form-control" required>
                                            <option value="">Choose a User</option>
                                            <?php foreach ($data['users'] as $user): ?>
                                                <option value="<?php echo htmlspecialchars($user['id']); ?>">
                                                    <?php echo htmlspecialchars($user['name']); ?> (ID: <?php echo htmlspecialchars($user['id']); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Select Payment Method</label>
                                        <?php if (!empty($data['payments'])): ?>
                                            <div class="payment-methods-list">
                                                <?php foreach ($data['payments'] as $method): ?>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="payment_method_id" id="method_<?php echo htmlspecialchars($method['id']); ?>" value="<?php echo htmlspecialchars($method['id']); ?>" required>
                                                        <label class="form-check-label" for="method_<?php echo htmlspecialchars($method['id']); ?>">
                                                            <?php if (!empty($method['logo_url'])): ?>
                                                                <img src="<?php echo URLROOT . '/public/img/payment_logos/' . $method['logo_url']; ?>" alt="<?php echo htmlspecialchars($method['payment_name']); ?>" style="width: 30px; height: 30px; vertical-align: middle;">
                                                            <?php endif; ?>
                                                            <?php echo htmlspecialchars($method['payment_name']); ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-warning mt-2">No active payment methods found.</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="products" class="form-label">Select Products</label>
                                        <div id="product-list-container">
                                            <div class="input-group mb-2 product-row">
                                                <select name="product_id[]" class="form-control" required>
                                                    <option value="">Choose Product</option>
                                                    <?php foreach ($data['products'] as $product): ?>
                                                        <option value="<?php echo htmlspecialchars($product['id']); ?>" 
                                                            data-price="<?php echo htmlspecialchars($product['price']); ?>">
                                                            <?php echo htmlspecialchars($product['product_name']); ?> ($<?php echo htmlspecialchars($product['price']); ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="number" name="quantity[]" class="form-control quantity-input" 
                                                    placeholder="Qty" min="1" required>
                                                <button type="button" class="btn btn-danger remove-product-btn">Remove</button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-sm" id="add-product-btn">Add Another Product</button>
                                    </div>
                                    
                                    
                                    <div class="mb-3">
                                        <label for="delivery_address" class="form-label">Delivery Address</label>
                                        <input type="text" name="delivery_address" id="delivery_address" class="form-control" placeholder="Enter delivery address" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="pending" selected>Pending</option>
                                            <option value="processing">Processing</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-warning px-5 d-block w-100">
                                        <i class="fas fa-plus-circle"></i> Create Order
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
     document.addEventListener('DOMContentLoaded', function() {
        const productContainer = document.getElementById('product-list-container');
        const addProductBtn = document.getElementById('add-product-btn');

        addProductBtn.addEventListener('click', function() {
            const productRow = productContainer.querySelector('.product-row');
            if (productRow) {
                const newRow = productRow.cloneNode(true);
                // Clear selected value and quantity for the new row
                newRow.querySelector('select').selectedIndex = 0;
                newRow.querySelector('input[type="number"]').value = '';
                productContainer.appendChild(newRow);
            }
        });

        // Use event delegation for remove buttons
        productContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product-btn')) {
                const productRow = e.target.closest('.product-row');
                // Ensure at least one row remains
                if (productContainer.childElementCount > 1) {
                    productRow.remove();
                } else {
                    alert('You must select at least one product.');
                }
            }
        });
    });
    
</script>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>