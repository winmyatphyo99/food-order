<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<section class="container my-5">
    <h2 class="text-center mb-5 fw-bold text-dark">Our Categories</h2>
    <div class="row g-4 justify-content-center">
        <?php if (isset($data['categories']) && is_array($data['categories'])) : ?>
            <?php foreach($data['categories'] as $category) : ?>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 d-flex">
                    <div class="card h-100 border-0 shadow-lg category-card text-center text-white bg-dark">
                        <img src="<?php echo URLROOT; ?>/img/categories/<?php echo htmlspecialchars($category['category_image']); ?>" class="card-img" alt="<?php echo htmlspecialchars($category['name']); ?>">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3 rounded-4">
                            <h5 class="card-title fw-bold mb-1 text-uppercase"><?php echo htmlspecialchars($category['name']); ?></h5>
                            
                            <a href="<?php echo URLROOT; ?>/ProductController/category/<?php echo $category['id']; ?>" class="btn btn-warning text-white fw-bold rounded-pill">Order Now</a>
                        </div>
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
        border-radius: 1rem;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        overflow: hidden;
        position: relative;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.2) !important;
    }

    .category-card .card-img {
        height: 250px;
        object-fit: cover;
        width: 100%;
        transition: transform 0.5s ease;
    }

    .category-card:hover .card-img {
        transform: scale(1.05);
    }

    .card-img-overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.1));
        border-radius: 1rem;
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    .category-card:hover .card-img-overlay {
        opacity: 0.9;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>