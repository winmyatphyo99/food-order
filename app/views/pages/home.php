<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<style>
    :root {
        --primary-color: #5e8bbb;
        /* Darker Blue for a richer feel */
        --secondary-color: #e3e8edff;
        /* Muted Gray for text */
        --accent-color: #28a745;
        /* Vibrant Green for emphasis */
        --dark-bg: #343a40;
        /* Dark Charcoal */
        --light-bg: #f8f9fa;
        /* White Smoke */
        --text-light: #ffffff;
        --text-dark: #333333;
    }

    /* General Body and Typography */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--light-bg);
        color: var(--text-dark);
    }

    /* Header & Footer (as requested) */
    .header-section,
    footer {
        background-color: var(--primary-color);
        color: var(--text-light);
    }

    .header-section a {
        color: var(--text-light);
        transition: color 0.3s ease;
    }

    .header-section a:hover {
        color: var(--accent-color);
    }

    /* Hero Section */
    .hero-section {
        position: relative;
        background: url('https://images.unsplash.com/photo-1506368249639-73a05d6f6488?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nzh8fHRoYWklMjBmb29kfGVufDB8fDB8fHww') center/cover no-repeat;
        min-height: 85vh;
        display: flex;
        align-items: center;
        text-align: center;
        color: var(--text-light);
        padding: 50px 20px;
    }

    .hero-section .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* Dark overlay for better text contrast */
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        color: var(--text-light);
        /* White title */
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.4);
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.8);
        /* Slightly transparent white for subtitle */
        margin-bottom: 2rem;
    }

    .search-box {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        /* Frosted glass effect */
        border-radius: 50px;
        padding: 8px 15px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        max-width: 600px;
        margin: auto;
    }

    .search-box .form-control {
        border: none;
        background: transparent;
        color: var(--text-light);
        padding: 12px 20px;
        font-size: 1.1rem;
        outline: none;
        flex: 1;
    }

    .search-box .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    /* .search-btn {
        background: var(--primary-color);
        border: none;
        color: var(--text-light);
        font-size: 1.2rem;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }
    .search-btn:hover {
        background-color: #003e80;
    } */

    /* How It Works Section */
    .circle-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 20px;
        color: var(--text-light);
        transition: transform 0.3s ease;
    }

    .circle-icon:hover {
        transform: translateY(-5px);
    }

    /* Product Cards */
    .product-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        background: white;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .product-img-container {
        height: 220px;
        overflow: hidden;
        border-radius: 15px 15px 0 0;
    }

    .product-img-container img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card .btn {
        background: var(--primary-color);
        border: none;
        color: white;
        transition: background-color 0.3s ease;
    }

    .product-card .btn:hover {
        background: #003e80;
    }

    /* CTA */
    .cta-section {
        background: var(--primary-color);
        color: var(--text-light);
        padding: 4rem 0;
        border-radius: 20px;
    }

    .cta-section .btn {
        background: var(--accent-color);
        border: none;
        font-weight: bold;
        padding: 12px 40px;
        border-radius: 50px;
        transition: 0.3s;
    }

    .cta-section .btn:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    /* Footer */
    footer {
        background: var(--primary-color);
        color: var(--text-light);
        padding: 3rem 0 1.5rem;
    }

    footer h5 {
        color: var(--accent-color);
    }

    footer a {
        color: var(--text-light);
        text-decoration: none;
        transition: color 0.3s;
    }

    footer a:hover {
        color: var(--accent-color);
    }

    .social-icons a {
        color: var(--text-light);
        transition: color 0.3s ease;
    }

    .social-icons a:hover {
        color: var(--accent-color);
    }

    .newsletter-btn {
        background-color: var(--accent-color);
        color: var(--text-light);
        border: none;
    }

    .newsletter-btn:hover {
        background-color: #218838;
    }
</style>

<div class="header-section">
</div>

<header class="hero-section d-flex align-items-center">
    <div class="overlay"></div>
    <div class="container text-center hero-content">

        <h1 class="fw-bold display-3 mb-3 hero-title animate__animated animate__fadeInDown">
            Your Culinary Journey Starts Here
        </h1>

        <p class="lead mb-5 hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
            Find the best food near you and get it delivered in minutes.
        </p>

        <div class="d-flex justify-content-center mb-4 animate__animated animate__zoomIn animate__delay-2s">
            <form action="<?= URLROOT; ?>/Pages/menu" method="GET" class="search-form">
                <div class="search-box shadow-sm">
                    <input type="text" name="query" class="form-control" placeholder="🔍 Search dishes..." aria-label="Search food">
                    <button class="btn search-btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <a href="<?= URLROOT; ?>/Pages/menu"
            class="btn btn-outline-light btn-lg px-5 fw-bold animate__animated animate__fadeInUp animate__delay-3s">
            <i class="fas fa-utensils me-2"></i> Browse Our Menu
        </a>
    </div>
</header>
<hr>

<section class="container my-5 py-5 text-center">
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

<hr>

<section class="container my-5 py-5">
    <h2 class="text-center fw-bold mb-5">🔥 Popular Menu</h2>
    <div class="row g-4">
        <?php if (!empty($data['hotProducts'])): ?>
            <?php foreach ($data['hotProducts'] as $product): ?>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-lg rounded-3 product-card animate__animated animate__fadeInUp">
                        <div class="product-img-container rounded-top-3">
                            <img
                                src="<?= URLROOT . '/img/products/' . htmlspecialchars($product['product_img']); ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($product['product_name']); ?>">
                        </div>
                        <div class="card-body text-center p-4">
                            <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($product['product_name']); ?></h5>
                            <p class="text-muted small mb-3"><?= htmlspecialchars($product['description']); ?></p>
                            <p class="fw-bold fs-4 text-primary mb-3">
                                $<?= htmlspecialchars($product['price']); ?>
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
                <p class="text-center text-muted">No popular products found.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<hr>

<section class="cta-section" style="background-color: var(--primary-color); color: var(--text-light); padding: 3rem 0;">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Hungry? Get Your Order Started Now!</h2>
        <p class="lead mb-4">Discover the best food in town, delivered right to your door in minutes.</p>
        <a href="<?= URLROOT; ?>/Pages/menu" class="btn btn-custom-primary btn-lg px-5 fw-bold shadow">
            <i class="fas fa-shopping-basket me-2"></i> Order Now
        </a>
    </div>
</section>

<hr>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>