<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<style>
    /* Customer Dashboard Category Page Styling Start */
 body {
   font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f7fa;
    color: #333;
    line-height: 1.6;
}

.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
}

.main-content {
    flex: 1;
    padding: 0;
}

/* Category Cards */
.category-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 1.5rem; /* Larger border-radius */
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Softer shadow */
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.category-card .card-body {
    padding: 2.5rem; /* More padding for a cleaner look */
}

.category-card-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.category-image-container {
    height: 250px; /* Fixed height for image container */
    overflow: hidden;
    position: relative;
    border-top-left-radius: 1.5rem;
    border-top-right-radius: 1.5rem;
}

.category-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.category-card:hover img {
    transform: scale(1.05); /* Slight zoom on hover */
}

.card-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}

.card-text {
    font-size: 1rem;
    color: #666;
}

.btn-custom {
    background-color: #ffb86c;
    color: #fff;
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 2rem; /* Pill-shaped button */
    transition: background-color 0.3s ease, transform 0.3s ease;
    border: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-custom:hover {
    background-color: #e6a75a;
    transform: translateY(-2px);
}
/* Customer Dashboard Category Page Styling End */
</style>
<div class="dashboard-wrapper">
    <?php if (isset($_SESSION['user_id'])): ?>
            <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
        <?php endif ?>

    <main class="main-content">
        <section class="container my-5">
            <h2 class="text-center mb-5 fw-bold text-dark">Our Categories</h2>
            <div class="row g-4">
                <?php if (isset($data['categories']) && is_array($data['categories'])) : ?>
                    <?php foreach ($data['categories'] as $category) : ?>
                        <div class="col-12 col-md-6">
                            <a href="<?php echo URLROOT; ?>/ProductController/category/<?php echo $category['id']; ?>" class="text-decoration-none text-dark">
                                <div class="card h-100 border-0 shadow-lg category-card overflow-hidden">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-md-5 category-image-container">
                                            <img src="<?php echo URLROOT; ?>/img/categories/<?php echo htmlspecialchars($category['category_image']); ?>"
                                                class="img-fluid rounded-start"
                                                alt="<?php echo htmlspecialchars($category['name']); ?>">
                                        </div>

                                        <div class="col-md-7 d-flex flex-column justify-content-center p-4">
                                            <h5 class="fw-bold mb-2 text-uppercase">
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </h5>
                                            <p class="text-muted mb-3">
                                                <?php echo htmlspecialchars($category['description']); ?>
                                            </p>
                                            <div class="mt-auto">
                                                <span class="btn btn-warning text-white fw-bold rounded-pill">
                                                    Order Now
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center text-muted">No categories found. Please add some from the admin panel.</p>
                    </div>
                <?php endif; ?>
            </div>
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
    </main>
   
</div>


