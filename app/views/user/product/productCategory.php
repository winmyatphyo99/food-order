<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<style>
    
</style>
<div class="product-page dashboard-wrapper">
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <?php endif ?>

    <div class="main-content">
        <section class="container py-5">
            <h2 class="text-center mb-5 fw-bold text-dark animate__animated animate__fadeInDown">
                Explore Our Delicious Offerings!
            </h2>

           <div class="row custom-gap justify-content-center">
                <?php if (!empty($data['products'])): ?>
                    <?php foreach ($data['products'] as $product): ?>
                        <?php
                        $avg = round($product['average_rating'] ?? 0);
                        $count = $product['rating_count'] ?? 0;
                        ?>
                        <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp">
                            <div class="card product-card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                                <div class="product-card-header position-relative">
                                    <img src="<?= URLROOT ?>/img/products/<?= htmlspecialchars($product['product_img']) ?>"
                                        class="card-img-top product-image"
                                        alt="<?= htmlspecialchars($product['product_name']) ?>">
                                    <?php if ($product['quantity'] <= 0): ?>
                                        <span class="badge bg-danger rounded-pill position-absolute top-0 end-0 mt-3 me-3 animate__bounceIn">
                                            OUT OF STOCK
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fw-bold text-dark mb-2 fs-4"><?= htmlspecialchars($product['product_name']) ?></h5>
                                    <p class="card-text text-muted mb-3 flex-grow-1 line-clamp-3"><?= htmlspecialchars($product['description']) ?></p>

                                    <!-- Rating -->
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?= $i <= $avg ? 'text-warning' : 'text-secondary' ?>"></i>
                                        <?php endfor; ?>
                                        <span class="ms-2 text-muted small">(<?= $count ?>)</span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <p class="fw-bold fs-3 text-warning mb-0 price-tag">$<?= number_format($product['price'], 2) ?></p>
                                        <form action="<?= URLROOT ?>/CartController/addToCart" method="POST" class="d-flex flex-column align-items-center">
                                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                            <div class="input-group mb-3 w-75">
                                                <button type="button" class="btn btn-secondary-outline btn-minus">-</button>
                                                <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="<?= $product['quantity'] ?>">
                                                <button type="button" class="btn btn-secondary-outline btn-plus">+</button>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 text-white fw-bold" <?= $product['quantity'] <= 0 ? 'disabled' : '' ?>>
                                                <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                            </button>
                                            <button type="button" class="btn btn-secondary-outline w-100 fw-bold"
                                                data-bs-toggle="modal" data-bs-target="#ratingModal"
                                                data-product-id="<?= $product['id'] ?>">
                                                <i class="fas fa-star me-1"></i> Rate Product
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center py-5 rounded-4 border-0 animate__fadeIn">
                            <i class="fas fa-info-circle me-2 fs-4"></i>
                            <p class="mb-0 mt-2 fs-5">No delicious items found in this category right now. Check back soon!</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <!-- Pagination -->
            <?php if (!empty($data['totalPages']) && $data['totalPages'] > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                            <li class="page-item <?= ($i == $data['currentPage']) ? 'active' : '' ?>">
                                <a class="page-link" href="<?= URLROOT ?>/CategoryController/menuCategory/<?= $data['selectedCategory'] ?>/<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>


        </section>
       <?php
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Footer logic
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 0) {
            // Logged-in customer
            // require_once APPROOT . '/views/user/customer/footer.php';
        } else {
    // Public / guest users
    require_once APPROOT . '/views/user/inc/footer.php';
}
        ?>
    </div>
</div>
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Rate this Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm" action="<?= URLROOT; ?>/RatingController/submit" method="POST">
                    <input type="hidden" name="product_id" id="rating_product_id">
                    <p class="text-center mb-4">How many stars would you give this product?</p>
                    <div class="rating-stars text-center fs-3 mb-4">
                        <i class="fas fa-star" data-rating="1"></i>
                        <i class="fas fa-star" data-rating="2"></i>
                        <i class="fas fa-star" data-rating="3"></i>
                        <i class="fas fa-star" data-rating="4"></i>
                        <i class="fas fa-star" data-rating="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="selected_rating" required>
                    <div class="mb-4">
                        <label for="comment" class="form-label">Your Comment (Optional):</label>
                        <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ratingModal = document.getElementById('ratingModal');
        ratingModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-product-id');
            ratingModal.querySelector('#rating_product_id').value = productId;
        });

        const stars = document.querySelectorAll('#ratingModal .rating-stars .fas.fa-star');
        const selectedRatingInput = document.getElementById('selected_rating');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const ratingValue = star.dataset.rating;
                selectedRatingInput.value = ratingValue;

                stars.forEach(s => s.classList.toggle('text-warning', s.dataset.rating <= ratingValue));
                stars.forEach(s => s.classList.toggle('text-secondary', s.dataset.rating > ratingValue));
            });
        });
    });

   
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
        const btnPlus = card.querySelector('.btn-plus');
        const btnMinus = card.querySelector('.btn-minus');
        const qtyInput = card.querySelector('input[name="quantity"]');
        const maxQty = parseInt(qtyInput.getAttribute('max')) || 1;
        const minQty = parseInt(qtyInput.getAttribute('min')) || 1;

        btnPlus.addEventListener('click', () => {
            let currentVal = parseInt(qtyInput.value) || 1;
            if (currentVal < maxQty) {
                qtyInput.value = currentVal + 1;
            }
        });

        btnMinus.addEventListener('click', () => {
            let currentVal = parseInt(qtyInput.value) || 1;
            if (currentVal > minQty) {
                qtyInput.value = currentVal - 1;
            }
        });
    });

</script>


