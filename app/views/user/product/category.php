<?php require_once APPROOT . '/views/user/inc/header.php' ?>

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
    background-color: #f4f6f9;
}

.main-content {
    flex: 1;
    padding: 20px;
}

/* Pagination Styles */
.pagination-container {
    margin-top: 3rem;
    display: flex;
    justify-content: center;
}

.pagination .page-item .page-link {
    border-radius: 8px;
    margin: 0 4px;
    color: #007bff;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
}

.pagination .page-item .page-link:hover {
    background-color: #e9ecef;
    border-color: #e9ecef;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    cursor: not-allowed;
    background-color: #f8f9fa;
}


/* Content Area - Inherited from your dashboard code */
.content-area {
    padding: 2rem;
    flex-grow: 1;
}

/* New: Dashboard Header for consistency */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 2rem 2rem 1rem;
    background-color: #fff;
    border-bottom: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.dashboard-header h4 {
    font-size: 1.5rem;
    font-weight: 700;
}

.dashboard-header .breadcrumb {
    margin-bottom: 0;
}

/* Category Cards Adjustments */
.category-card {
    min-width: 140px;
    height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out, border-color 0.3s ease, background-color 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    margin: 0.75rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.category-card i {
    transition: color 0.3s ease, transform 0.3s ease;
    color: #6c757d;
    font-size: 2.5rem;
    margin-bottom: 0.75rem;
}

.category-card p {
    font-size: 1.1rem;
    color: #6c757d;
    transition: color 0.3s ease;
    font-weight: 600;
    margin-bottom: 0;
}

.active-category {
    border-color: #0d6efd !important;
    background-color: #0d6efd !important;
    box-shadow: 0 0 20px rgba(13, 110, 253, 0.4) !important;
    transform: scale(1.05);
}

.active-category i,
.active-category p {
    color: #fff !important;
}

/* Product Cards */
.product-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    position: relative;
    border: none !important;
    background-color: #fff;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
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

/* New: Footer Styling (if you want to keep it) */
footer {
    background-color: #2c3e50;
    color: #ecf0f1;
    padding: 3rem 0;
}
</style>


<div class="dashboard-wrapper">
    <?php if (isset($_SESSION['user_id'])): ?>
            <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
        <?php endif ?>
    <div class="main-content">
        
        <div class="content-area">
            <div class="container-fluid my-5">
                <h3 class="text-center mb-5 fw-bold text-dark animate__animated animate__fadeInDown">
                    Browse by Category
                </h3>

                <div class="d-flex flex-wrap justify-content-center mb-5">
                    <a href="<?= URLROOT; ?>/Pages/menu" class="text-decoration-none animate__animated animate__bounceIn">
                        <div class="category-card text-center rounded-4 p-3 shadow-sm border <?= empty($data['selected_category_id']) ? 'active-category' : ''; ?>">
                            <i class="fas fa-list-ul fa-2x mb-2"></i>
                            <p class="mb-0 fw-bold fs-6">All</p>
                        </div>
                    </a>

                    <?php foreach ($data['categories'] as $category): ?>
                        <a href="<?= URLROOT; ?>/Pages/menu/<?= $category['id']; ?>" class="text-decoration-none animate__animated animate__bounceIn">
                            <div class="category-card text-center rounded-4 p-3 shadow-sm border <?= ($data['selected_category_id'] == $category['id']) ? 'active-category' : ''; ?>">
                                <i class="<?= htmlspecialchars($category['icon_class']); ?> fa-2x mb-2"></i>
                                <p class="mb-0 fw-bold fs-6"><?= htmlspecialchars($category['name']); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="row g-4 mt-4">
                    <?php if (!empty($data['products']) && is_array($data['products'])): ?>
                        <?php foreach ($data['products'] as $product): ?>
                            <div class="col-md-4 animate__animated animate__fadeInUp">
                                <div class="card product-card h-100 rounded-4">
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

                <?php if ($data['totalPages'] > 1): ?>
                <div class="pagination-container">
                    <nav aria-label="Product Page Navigation">
                        <ul class="pagination justify-content-center">
                            
                            <li class="page-item <?= ($data['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?= URLROOT; ?>/Pages/menu/<?= $data['selected_category_id'] ?? ''; ?>?page=<?= $data['currentPage'] - 1; ?>">Previous</a>
                            </li>

                            <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                                <li class="page-item <?= ($i == $data['currentPage']) ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?= URLROOT; ?>/Pages/menu/<?= $data['selected_category_id'] ?? ''; ?>?page=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?= URLROOT; ?>/Pages/menu/<?= $data['selected_category_id'] ?? ''; ?>?page=<?= $data['currentPage'] + 1; ?>">Next</a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
    
    </div>
    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-plus').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const max = parseInt(input.getAttribute('max'));
                if (parseInt(input.value) < max) {
                    input.value = parseInt(input.value) + 1;
                }
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

<?php require_once APPROOT . '/views/user/inc/footer.php' ?>