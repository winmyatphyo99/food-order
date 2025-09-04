<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>

<section class="container my-5">
    <h2 class="text-center mb-5 fw-bold text-dark">Our Categories</h2>

    <div class="row g-4">
        <?php if (isset($data['categories']) && is_array($data['categories'])) : ?>
            <?php foreach($data['categories'] as $category) : ?>
                <div class="col-12">
                    <div class="card h-100 border-0 shadow-lg category-card overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-5">
                                <img src="<?php echo URLROOT; ?>/img/categories/<?php echo htmlspecialchars($category['category_image']); ?>" 
                                     class="img-fluid w-100 h-100 object-fit-cover rounded-start" 
                                     alt="<?php echo htmlspecialchars($category['name']); ?>">
                            </div>

                            <div class="col-md-7 d-flex flex-column justify-content-center p-4">
                                <h5 class="fw-bold mb-2 text-uppercase text-dark">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </h5>
                                <p class="text-muted mb-3">
                                    <?php echo htmlspecialchars($category['description']); ?>
                                </p>
                                <a href="<?php echo URLROOT; ?>/ProductController/category/<?php echo $category['id']; ?>" 
                                   class="btn btn-warning text-white fw-bold rounded-pill align-self-start">
                                    Order Now
                                </a>
                            </div>
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
/* Font Imports */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap');

body {
    font-family: 'Montserrat', sans-serif;
    background-color: #f0f2f5;
    color: #495057;
}

h2.text-dark {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    color: #212529 !important;
    font-weight: 700;
}

h5.text-dark {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700 !important;
    color: #212529 !important;
}

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
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>