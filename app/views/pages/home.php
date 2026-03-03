<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<section class="main-content">
    <section class="hero-section container-fluid">
        <div class="row align-items-center">

            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="hero-content text-center p-5">
                    <h1 class="hero-title">
                        Order Food, Get Instant Invoice
                    </h1>
                    <p class="hero-subtitle">
                        Delicious meals, quick delivery, and detailed invoices for every order.
                    </p>

                    <form action="<?= URLROOT; ?>/Pages/menu" method="GET" class="search-form">
                        <div class="search-box shadow">
                            <input type="text" name="query" placeholder="🔍 Search dishes, drinks, or desserts...">
                            <button type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <a href="<?= URLROOT; ?>/Pages/menu" class="btn hero-btn mt-3">
                        <i class="fas fa-utensils me-2"></i> Browse Menu
                    </a>
                </div>
            </div>

            <div class="col-md-6 p-0">
                <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?w=1920&q=80&auto=format&fit=crop" class="d-block w-100 hero-img" alt="Food 1">
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1551218808-94e220e084d2?w=1920&q=80&auto=format&fit=crop" class="d-block w-100 hero-img" alt="Food 2">
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=1920&q=80&auto=format&fit=crop" class="d-block w-100 hero-img" alt="Food 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <section class="cuisine-section py-5">
        <div class="container">
            <div class="text-center fw-bold mb-4 section-title-container">
                <h2 class="section-title slide-marquee">Explore Our Menu by Cuisine</h2>
            </div>
            <p class="text-center text-muted mb-5 section-subtitle animate-fade-in-up animate-delay-200">
                Discover a variety of delicious dishes from around the world.
            </p>
            <div class="row g-4 justify-content-center category-row">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 animate-fade-in-up" style="animation-delay: <?= 0.1 * ($category['id'] % 5 + 1) ?>s;">
                            <a href="<?= URLROOT; ?>/ProductController/category/<?= htmlspecialchars($category['id']); ?>" class="text-decoration-none">
                                <div class="category-card text-center p-4 h-100 position-relative">
                                    <div class="img-wrapper mx-auto mb-3">
                                        <img src="<?= URLROOT; ?>/img/categories/<?= htmlspecialchars($category['category_image']); ?>"
                                            alt="<?= htmlspecialchars($category['name']); ?>" class="rounded-circle img-fluid shadow-sm">
                                    </div>
                                    <h5 class="fw-bold text-dark mt-3 mb-2 category-title"><?= htmlspecialchars($category['name']); ?></h5>
                                    <p class="text-muted small-text mb-0 category-description">
                                        <?= htmlspecialchars($category['description']); ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-muted text-center w-100 p-5 border rounded-3 bg-white shadow-sm">No categories available at the moment. Please check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="container my-5 py-5 text-center how-it-works">
        <h2 class="fw-bold mb-5">How It Works</h2>
        <div class="row g-5">
            <div class="col-md-4">
                <div class="circle-icon mx-auto shadow-sm">
                    <i class="fas fa-map-marker-alt fa-2x"></i>
                </div>
                <h5 class="fw-bold">1. Find Your Place</h5>
                <p class="text-muted">Enter your location to discover a variety of restaurants near you.</p>
            </div>
            <div class="col-md-4">
                <div class="circle-icon mx-auto shadow-sm">
                    <i class="fas fa-utensils fa-2x"></i>
                </div>
                <h5 class="fw-bold">2. Choose Your Meal</h5>
                <p class="text-muted">Browse menus, read reviews, and select your perfect meal in minutes.</p>
            </div>
            <div class="col-md-4">
                <div class="circle-icon mx-auto shadow-sm">
                    <i class="fas fa-motorcycle fa-2x"></i>
                </div>
                <h5 class="fw-bold">3. Fast Delivery</h5>
                <p class="text-muted">Pay securely and track your order as it's delivered straight to your door.</p>
            </div>
        </div>
    </section>

    <section class="container my-5 py-5">
        <h2 class="text-center fw-bold mb-5">Best Selling Items</h2>
        <div class="row g-5">
            <?php if (!empty($data['hotProducts'])): ?>
                <?php foreach ($data['hotProducts'] as $product): ?>
                    <div class="col-md-4">
                        <div class="card product-card shadow-lg rounded-3 animate__animated animate__fadeInUp h-100">

                            <div class="product-img-container">
                                <img
                                    src="<?= URLROOT . '/img/products/' . htmlspecialchars($product['product_img']); ?>"
                                    alt="<?= htmlspecialchars($product['product_name']); ?>"
                                    class="card-img-top">
                                <?php if ($product['quantity'] <= 0): ?>
                                    <span class="badge out-of-stock-badge animate__animated animate__fadeIn">
                                        OUT OF STOCK
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="fw-bold text-dark mb-2"><?= htmlspecialchars($product['product_name']); ?></h5>
                                <p class="product-description text-muted small mb-3">
                                    <?= htmlspecialchars($product['description']); ?>
                                </p>
                                <p class="fw-bold fs-4 text-primary mb-2">
                                    $<?= htmlspecialchars($product['price']); ?>
                                </p>

                                <div class="mb-3">
                                    <?php
                                    $avg = isset($product['average_rating']) ? round($product['average_rating']) : 0;
                                    $count = isset($product['rating_count']) ? $product['rating_count'] : 0;
                                    ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= $avg ? 'text-warning' : 'text-secondary'; ?>"></i>
                                    <?php endfor; ?>
                                    <span class="ms-2 text-muted small">(<?= $count ?>)</span>
                                </div>

                                <form action="<?= URLROOT; ?>/CartController/addToCart" method="POST" class="mt-auto text-center">
                                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                    <div class="input-group justify-content-center mb-3">
                                        <button type="button" class="btn btn-secondary-outline btn-minus">-</button>
                                        <input
                                            type="number"
                                            name="quantity"
                                            class="form-control text-center"
                                            value="1"
                                            min="1"
                                            max="<?= $product['quantity']; ?>">
                                        <button type="button" class="btn btn-secondary-outline btn-plus">+</button>
                                    </div>
                                    <button
                                        type="submit"
                                        class="btn btn-primary fw-bold w-100"
                                        <?= ($product['quantity'] <= 0) ? 'disabled' : ''; ?>>
                                        <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted">No popular products found.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="container my-5 py-5 text-center bg-light rounded-3">
        <h2 class="fw-bold mb-5">What Our Customers Say</h2>
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-inner">
                <?php if (!empty($data['testimonials'])): ?>
                    <?php $is_first = true; ?>
                    <?php foreach ($data['testimonials'] as $testimonial): ?>
                        <div class="carousel-item <?= $is_first ? 'active' : ''; ?>">
                            <div class="px-md-5">

                                <!-- Use a default profile image because your table doesn't have profile_image -->
                                <img src="<?= URLROOT . '/uploads/profile/' . htmlspecialchars($testimonial['profile_image']); ?>" class="rounded-circle mb-3" width="80" height="80" alt="<?= htmlspecialchars($testimonial['user_name']) ?>'s Profile Image">

                                <p class="lead fst-italic">"<?= htmlspecialchars($testimonial['comment']) ?>"</p>

                                <div class="text-warning">
                                    <?php
                                    $rating = (int) $testimonial['rating'];
                                    for ($i = 1; $i <= 5; $i++):
                                    ?>
                                        <i class="fas fa-star <?= ($i <= $rating) ? '' : 'text-secondary'; ?>"></i>
                                    <?php endfor; ?>
                                </div>

                                <p class="fw-bold mt-2">
                                    — <?= htmlspecialchars($testimonial['user_name']) ?>
                                    <span class="fw-normal text-muted small ms-2">
                                        on <?= date('M d, Y', strtotime($testimonial['rated_at'])) ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <?php $is_first = false; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <div class="px-md-5">
                            <p class="text-muted">No testimonials yet.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const minusBtns = document.querySelectorAll('.btn-minus');
        const plusBtns = document.querySelectorAll('.btn-plus');

        // Minus Button Click
        minusBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.nextElementSibling; // minus -> input
                let value = parseInt(input.value);
                const min = parseInt(input.min) || 1;

                if (value > min) {
                    input.value = value - 1;
                }
            });
        });

        // Plus Button Click
        plusBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.previousElementSibling; // plus -> input
                let value = parseInt(input.value);
                const max = parseInt(input.max) || 99;

                if (value < max) {
                    input.value = value + 1;
                }
            });
        });
    });
</script>