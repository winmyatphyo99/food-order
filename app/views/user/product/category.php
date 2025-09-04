<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
<section class="container my-5 animate__animated animate__fadeInUp">
    <h3 class="text-center mb-5 fw-bold text-dark animate__animated animate__fadeInDown">
        Browse by Category
    </h3>

    <div class="d-flex flex-wrap justify-content-center mb-5">
        <a href="<?= URLROOT; ?>/Pages/menu" class="text-decoration-none mx-2 my-2 animate__animated animate__bounceIn">
            <div class="category-card text-center rounded-4 p-3 shadow-sm border <?= empty($data['selected_category_id']) ? 'active-category' : ''; ?>">
                <i class="fas fa-list-ul fa-2x mb-2 text-primary"></i>
                <p class="mb-0 fw-bold fs-6">All</p>
            </div>
        </a>

        <?php foreach ($data['categories'] as $category): ?>
            <a href="<?= URLROOT; ?>/Pages/menu/<?= $category['id']; ?>" class="text-decoration-none mx-2 my-2 animate__animated animate__bounceIn">
                <div class="category-card text-center rounded-4 p-3 shadow-sm border <?= ($data['selected_category_id'] == $category['id']) ? 'active-category' : ''; ?>">
                    <i class="<?= htmlspecialchars($category['icon_class']); ?> fa-2x mb-2 text-primary"></i>
                    <p class="mb-0 fw-bold fs-6"><?= htmlspecialchars($category['name']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="row g-4 mt-4">
        <?php if (!empty($data['products']) && is_array($data['products'])): ?>
            <?php foreach ($data['products'] as $product): ?>
                <div class="col-md-4 animate__animated animate__fadeInUp">
                    <div class="card product-card border-0 shadow h-100 rounded-4 overflow-hidden">
                        <div class="product-image-container">
                            <img src="<?= URLROOT; ?>/img/products/<?= htmlspecialchars($product['product_img']); ?>"
                                class="card-img-top product-img"
                                alt="<?= htmlspecialchars($product['product_name']); ?>">
                            <?php if ($product['quantity'] <= 0): ?>
                                <span class="badge bg-danger text-white position-absolute top-0 w-100 py-2 animate__animated animate__fadeIn">OUT OF STOCK</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body text-center d-flex flex-column">
                            <h5 class="fw-bold text-dark fs-5 mb-2"><?= htmlspecialchars($product['product_name']); ?></h5>
                            <p class="text-muted small mb-3 flex-grow-1 line-clamp-2"><?= htmlspecialchars($product['description']); ?></p>

                            <p class="fw-bold fs-4 text-warning mb-2">
                                $<?= htmlspecialchars(number_format($product['price'], 2)); ?>
                            </p>

                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form action="<?= URLROOT; ?>/CartController/addToCart" method="POST" class="d-flex flex-column align-items-center">
                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                    <div class="input-group mb-3 w-75">
                                        <button type="button" class="btn btn-outline-secondary btn-minus">-</button>
                                        <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="<?= $product['quantity']; ?>">
                                        <button type="button" class="btn btn-outline-secondary btn-plus">+</button>
                                    </div>
                                    <button type="submit" class="btn btn-warning w-100 text-white fw-bold" <?= ($product['quantity'] <= 0) ? 'disabled' : ''; ?>>
                                        <i class="fas fa-cart-plus me-1"></i> Order Now
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?= URLROOT; ?>/CartController/addToSession" method="POST" class="d-flex flex-column align-items-center">
                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                    <input type="hidden" name="quantity" class="form-control text-center" value="1" min="1" max="<?= $product['quantity']; ?>">
                                    <button type="submit" class="btn btn-warning w-100 text-white fw-bold">
                                        <i class="fas fa-cart-plus me-1"></i> Order Now
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center py-5 rounded-4 border-0" role="alert">
                    <i class="fas fa-info-circle me-2 fs-4"></i><br>
                    <p class="mb-0 mt-2 fs-5">No delicious items found in this category right now. Check back soon!</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* Font Imports */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap');

body {
    font-family: 'Montserrat', sans-serif;
    background-color: #f0f2f5;
    color: #495057;
}

h3.text-dark {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    color: #212529 !important;
}

.category-card {
    width: 120px;
    height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    border: 1px solid #dee2e6;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out, border-color 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.category-card i {
    transition: color 0.3s ease, transform 0.3s ease;
    color: #6c757d;
}

.category-card p {
    font-size: 0.9rem;
    color: #6c757d;
    transition: color 0.3s ease;
    font-weight: 600;
}

.category-card:hover i,
.category-card:hover p {
    color: #0d6efd;
}

.active-category {
    border-color: #0d6efd !important;
    box-shadow: 0 0 20px rgba(13, 110, 253, 0.3);
    transform: scale(1.05);
}

.active-category i,
.active-category p {
    color: #0d6efd !important;
}

.product-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    position: relative;
    border: 1px solid #e9ecef;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.product-image-container {
    position: relative;
    overflow: hidden;
}

.product-img {
    height: 250px;
    object-fit: cover;
    width: 100%;
    transition: transform 0.5s ease-in-out;
}

.product-card:hover .product-img {
    transform: scale(1.1);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.card-body .fs-4 {
    color: #ffc107 !important;
    font-weight: 700;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #fff;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #e0a800;
}

.btn-outline-secondary {
    border-color: #ced4da;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #e9ecef;
    border-color: #adb5bd;
}

/* Animations */
.animate__fadeInUp {
    animation: fadeInUp 1s both;
}

.animate__fadeInDown {
    animation: fadeInDown 1s both;
}

.animate__bounceIn {
    animation: bounceIn 1s both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 20px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translate3d(0, -20px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

@keyframes bounceIn {
    from,
    20%,
    40%,
    60%,
    80%,
    to {
        animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    }
    0% {
        opacity: 0;
        transform: scale3d(.3, .3, .3);
    }
    20% {
        transform: scale3d(1.1, 1.1, 1.1);
    }
    40% {
        transform: scale3d(.9, .9, .9);
    }
    60% {
        opacity: 1;
        transform: scale3d(1.03, 1.03, 1.03);
    }
    80% {
        transform: scale3d(.97, .97, .97);
    }
    to {
        opacity: 1;
        transform: scale3d(1, 1, 1);
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-plus').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                input.value = parseInt(input.value) + 1;
            });
        });
        document.querySelectorAll('.btn-minus').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.nextElementSibling;
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });
    });
</script>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>