<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<section class="container my-5">

    <!-- Category Section -->
    <h3 class="text-center mb-4 fw-bold text-dark">Browse by Category</h3>
    <div class="d-flex flex-wrap justify-content-center">

        <!-- All Category -->
        <a href="<?= URLROOT; ?>/Pages/menu" class="text-decoration-none mx-2 my-2">
            <div class="category-card text-center rounded-4 p-3 shadow-sm border <?= empty($data['selected_category_id']) ? 'active-category' : ''; ?>">
                <i class="fas fa-list-ul fa-2x mb-2 text-primary"></i>
                <p class="mb-0 fw-bold">All</p>
            </div>
        </a>

        <!-- Dynamic Categories -->
        <?php foreach ($data['categories'] as $category): ?>
            <a href="<?= URLROOT; ?>/Pages/menu/<?= $category['id']; ?>" class="text-decoration-none mx-2 my-2">
                <div class="category-card text-center rounded-4 p-3 shadow-sm border <?= ($data['selected_category_id'] == $category['id']) ? 'active-category' : ''; ?>">
                    <i class="<?= htmlspecialchars($category['icon_class']); ?> fa-2x mb-2 text-primary"></i>
                    <p class="mb-0 fw-bold"><?= htmlspecialchars($category['name']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Product Section -->
    <div class="row g-4 mt-4">
        <?php if (!empty($data['products']) && is_array($data['products'])): ?>
            <?php foreach ($data['products'] as $product): ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                        <!-- Product Image -->
                        <img src="<?= URLROOT; ?>/img/products/<?= htmlspecialchars($product['product_img']); ?>"
                             class="card-img-top product-img"
                             alt="<?= htmlspecialchars($product['product_name']); ?>">

                        <!-- Product Details -->
                        <div class="card-body text-center">
                            <h5 class="fw-bold text-dark"><?= htmlspecialchars($product['product_name']); ?></h5>
                            <p class="text-muted small"><?= htmlspecialchars($product['description']); ?></p>
                            <p class="fw-bold fs-5 text-primary">
                                $<?= htmlspecialchars(number_format($product['price'], 2)); ?>
                            </p>

                            <!-- Add to Cart -->
                            <form action="<?= URLROOT; ?>/CartController/addToCart" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                <div class="input-group mb-3">
                                    <input type="number" name="quantity" class="form-control" value="1" min="1" max="<?= $product['quantity']; ?>">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-cart-plus"></i> Order Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Empty State -->
            <p class="text-center text-muted">No products found in this category.</p>
        <?php endif; ?>
    </div>

</section>

<!-- Styles -->
<style>
    .category-card {
        width: 120px;
        height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .category-card p {
        font-size: 0.9rem;
        color: #495057;
    }
    .active-category {
        border-color: #007bff !important;
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.2);
    }
    .active-category i,
    .active-category p {
        color: #007bff !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>
