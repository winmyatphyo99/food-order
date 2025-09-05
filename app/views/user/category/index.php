<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<style>
/* Base Layout and Colors */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7f9;
    color: #495057;
    overflow-x: hidden;
}

.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
}

.main-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

/* Content Area */
.content-area {
    padding: 2rem;
    flex-grow: 1;
}

/* Original Category and Product Card Styles */
.category-card {
    border-radius: 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.2);
}

.object-fit-cover {
    object-fit: cover;
    height: 100%;
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

/* === New CSS for Image Consistency === */
.category-image-container {
    width: 100%;
    height: 200px; /* Set a fixed height for the container */
    overflow: hidden; /* Ensures no content spills out */
}

.category-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* This is the key property for consistent images */
}
/* === End New CSS === */

/* Adjustments for the new layout */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        width: 100%;
    }
}
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
    </main>
</div>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>