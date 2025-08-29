<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<section class="container my-5">
    <h2 class="text-center mb-4 fw-bold">View All Menu Categories</h2>
    <div class="row g-4 justify-content-center">
        <?php if (isset($data['categories']) && is_array($data['categories'])) : ?>
            <?php foreach($data['categories'] as $category) : ?>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 d-flex">
                    <div class="card h-100 border-0 shadow-sm category-card text-center">
                        <a href="<?php echo URLROOT; ?>/ProductController/category/<?php echo $category['id']; ?>" class="text-decoration-none text-dark">
                            <img src="<?php echo URLROOT; ?>/img/categories/<?php echo htmlspecialchars($category['category_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($category['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-0"><?php echo htmlspecialchars($category['name']); ?></h5>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center text-muted">No categories found. Please add some from the admin panel.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    .category-card {
        border-radius: 12px;
        transition: all 0.3s ease-in-out;
        overflow: hidden;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }

    .category-card img {
        height: 200px; /* Fixed height for image consistency */
        object-fit: cover;
        width: 100%;
    }

    .card-body {
        padding: 1rem;
    }
</style>

<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>