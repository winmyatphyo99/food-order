<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<div class="container my-5">
    <div class="card shadow-lg rounded-4 border-0">
        <!-- Header -->
        <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
            <h2 class="mb-0 fw-bold fs-5">All Menu Lists</h2>
        </div>

        <!-- Body -->
        <div class="card-body p-4">
            <?php if (!empty($data['products']) && is_array($data['products'])): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="text-uppercase text-muted">
                            <tr>
                                <th scope="col" style="width: 10%;">Image</th>
                                <th scope="col" style="width: 25%;">Name</th>
                                <th scope="col" style="width: 40%;">Description</th>
                                <th scope="col" style="width: 10%;">Price</th>
                                <th scope="col" style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['products'] as $product): ?>
                                <tr>
                                    <!-- Image -->
                                    <td>
                                        <?php if (!empty($product['product_img'])): ?>
                                            <img src="<?= URLROOT; ?>/img/products/<?= htmlspecialchars($product['product_img']); ?>"
                                                 class="rounded-3"
                                                 style="width: 60px; height: 60px; object-fit: cover;"
                                                 alt="<?= htmlspecialchars($product['product_name']); ?>">
                                        <?php else: ?>
                                            <i class="fas fa-image fa-2x text-muted opacity-50"></i>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Name -->
                                    <td>
                                        <h6 class="mb-0 fw-bold text-dark">
                                            <?= htmlspecialchars($product['product_name']); ?>
                                        </h6>
                                    </td>

                                    <!-- Description -->
                                    <td>
                                        <p class="text-truncate mb-0" style="max-width: 300px;">
                                            <?= htmlspecialchars($product['description']); ?>
                                        </p>
                                    </td>

                                    <!-- Price -->
                                    <td class="fw-bold text-success">
                                        $<?= htmlspecialchars(number_format($product['price'], 2)); ?>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <form action="<?= URLROOT; ?>/CartController/addToCart" method="POST">
                                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                            <div class="input-group">
                                                <input type="number"
                                                       name="quantity"
                                                       class="form-control form-control-sm"
                                                       value="1"
                                                       min="1"
                                                       max="<?= $product['quantity']; ?>">
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-cart-plus me-1"></i>
                                                    <span class="d-none d-md-inline">Add</span>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="alert alert-info text-center py-5 rounded-4 border-0" role="alert">
                    <i class="fas fa-info-circle me-2"></i>No products found in this category.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>
