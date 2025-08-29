<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<section class="container my-5">
    <h2 class="text-center mb-4 fw-bold fs-5">Menu Categories</h2>
    <div class="row g-4">
        <?php 
        if (isset($data['products']) && is_array($data['products'])) : 
            foreach($data['products'] as $product) : 
        ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                        <img src="<?php echo URLROOT; ?>/img/products/<?php echo htmlspecialchars($product['product_img']); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                        <div class="card-body text-center">
                            <h5 class="fw-bold text-dark"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                            <p class="text-muted small"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="fw-bold fs-5 text-primary">$<?php echo htmlspecialchars($product['price']); ?></p>
                            <form action="<?php echo URLROOT; ?>/CartController/addToCart" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <div class="input-group mb-3">
                                    <input type="number" name="quantity" class="form-control" value="1" min="1">
                                    <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-cart-plus"></i>Add to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; 
        else: ?>
            <p class="text-center text-muted">No products found in this category.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>