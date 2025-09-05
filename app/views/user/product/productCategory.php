<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<style>
    .dashboard-wrapper {
        display: flex;
        min-height: 100vh;
        background-color: #f4f7f9;
    }

    .main-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        /* Default to full width on small screens */
    }

    /* Google Fonts for better typography */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap');

    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f8f9fa;
        /* Light background */
    }

    h2.text-center {
        font-family: 'Playfair Display', serif;
        font-size: 2.8rem;
        color: #343a40;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
    }

    .product-card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border: none;
        /* Remove default border */
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        /* Softer, deeper shadow */
        background-color: #ffffff;
    }

    .product-card:hover {
        transform: translateY(-8px) scale(1.01);
        /* Lift more and slightly scale */
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        /* More pronounced shadow on hover */
    }

    .product-image {
        width: 100%;
        height: 200px;
        /* Fixed height for consistency */
        object-fit: cover;
        /* Ensures image covers the area nicely */
        border-bottom: 1px solid #eee;
        /* Subtle separator */
    }

    .product-card-header {
        position: relative;
    }

    .badge.rounded-pill {
        font-size: 0.8rem;
        padding: 0.5em 1em;
        letter-spacing: 0.5px;
        z-index: 10;
    }

    .card-title {
        font-family: 'Playfair Display', serif;
        color: #343a40;
    }

    .card-text {
        font-size: 0.95rem;
        line-height: 1.5;
        color: #6c757d;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .price-tag {
        color: #ffc107;
        /* Bootstrap warning yellow */
        font-size: 1rem !important;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .quantity-input-group .btn {
        border-color: #dee2e6;
        color: #495057;
    }

    .quantity-input-group .form-control {
        border-color: #dee2e6;
    }

    .quantity-input-group .btn:hover {
        background-color: #e2e6ea;
    }

    .add-to-cart-btn {
        background-color: #ffc107;
        /* Bootstrap warning yellow */
        border-color: #ffc107;
        color: #fff;
        padding: 0.6rem 1.2rem;
        font-size: 0.95rem;
        transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.2s ease;
    }

    .add-to-cart-btn:hover:not(:disabled) {
        background-color: #e0a800;
        /* Darker yellow on hover */
        border-color: #e0a800;
        transform: translateY(-2px);
    }

    .add-to-cart-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background-color: #cccccc !important;
        border-color: #cccccc !important;
    }

    /* Optional: Animate.css for subtle animations */
    .animate__animated {
        -webkit-animation-duration: 0.8s;
        animation-duration: 0.8s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }

    .animate__fadeInDown {
        -webkit-animation-name: fadeInDown;
        animation-name: fadeInDown;
    }

    .animate__fadeInUp {
        -webkit-animation-name: fadeInUp;
        animation-name: fadeInUp;
    }

    .animate__bounceIn {
        -webkit-animation-name: bounceIn;
        animation-name: bounceIn;
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
    <div class="dashboard-wrapper">
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
        <?php endif ?>
        
        <div class="main-content">
            <section class="container py-5">
                <h2 class="text-center mb-5 fw-bold text-dark animate__animated animate__fadeInDown">
                    Explore Our Delicious Offerings!
                </h2>

                <div class="row g-4 justify-content-center">
                    <?php if (!empty($data['products']) && is_array($data['products'])): ?>
                        <?php foreach ($data['products'] as $product): ?>
                            <div class="col-12 col-md-6 col-lg-4 animate__animated animate__fadeInUp">
                                <div class="card product-card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                                    <div class="product-card-header position-relative">
                                        <img src="<?= URLROOT; ?>/img/products/<?php echo htmlspecialchars($product['product_img']); ?>"
                                            class="card-img-top product-image"
                                            alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                        <?php if ($product['quantity'] <= 0): ?>
                                            <span
                                                class="badge bg-danger rounded-pill position-absolute top-0 end-0 mt-3 me-3 animate__animated animate__bounceIn">OUT
                                                OF STOCK</span>
                                        <?php endif; ?>
                                        <?php // Optional: Add a "New" or "Popular" badge if applicable
                                                /*
                                                <span class="badge bg-success rounded-pill position-absolute top-0 start-0 mt-3 ms-3">NEW</span>
                                                */ ?>
                                    </div>

                                    <div class="card-body d-flex flex-column p-4">
                                        <h5 class="card-title fw-bold text-dark mb-2 fs-4">
                                            <?php echo htmlspecialchars($product['product_name']); ?>
                                        </h5>
                                        <p class="card-text text-muted mb-3 flex-grow-1 line-clamp-3">
                                            <?php echo htmlspecialchars($product['description']); ?>
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <p class="fw-bold fs-3 text-warning mb-0 price-tag">
                                                $<?php echo htmlspecialchars(number_format($product['price'], 2)); ?>
                                            </p>
                                            <?php if (isset($_SESSION['user_id'])): ?>
                                                <form action="<?= URLROOT; ?>/CartController/addToCart" method="POST"
                                                    class="d-flex align-items-center">
                                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                                    <div class="input-group input-group-sm me-2 quantity-input-group">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="this.nextElementSibling.stepDown()">-</button>
                                                        <input type="number" name="quantity"
                                                            class="form-control text-center quantity-field" value="1" min="1"
                                                            max="<?= htmlspecialchars($product['quantity']); ?>"
                                                            style="width: 50px;">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="this.previousElementSibling.stepUp()">+</button>
                                                    </div>
                                                    <button type="submit" class="btn btn-warning add-to-cart-btn fw-bold" <?php echo ($product['quantity'] <= 0) ? 'disabled' : ''; ?>>
                                                        <i class="fas fa-cart-plus me-1"></i> Add
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <form action="<?= URLROOT; ?>/CartController/addToSession" method="POST"
                                                    class="d-flex align-items-center">
                                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                                    <input type="number" name="quantity"
                                                        class="form-control text-center quantity-field" value="1" min="1"
                                                        max="<?= htmlspecialchars($product['quantity']); ?>" style="width: 50px;">
                                                    <button type="submit" class="btn btn-warning add-to-cart-btn fw-bold">
                                                        <i class="fas fa-cart-plus me-1"></i> Add
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center py-5 rounded-4 border-0 animate__animated animate__fadeIn"
                                role="alert">
                                <i class="fas fa-info-circle me-2 fs-4"></i><br>
                                <p class="mb-0 mt-2 fs-5">No delicious items found in this category right now. Check back
                                    soon!</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>




<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>