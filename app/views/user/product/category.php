<?php require_once APPROOT . '/views/user/inc/header.php' ?>
<div class="dashboard-wrapper">
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <?php endif ?>

    <div class="main-content">
        <div class="menu-header">
            <div class="container-fluid">
                <h2>Our Delicious Menu 🍽️</h2>
                <form method="GET" action="<?= URLROOT; ?>/Pages/menu">
                    <div class="input-group search-input-group">
                        <input type="text"
                            name="search"
                            id="menu-search-input"
                            class="form-control"
                            placeholder="Search for your next craving..."
                            value="<?= htmlspecialchars($data['searchQuery'] ?? '') ?>">
                        <button type="submit" class="input-group-text  border-0">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="content-area py-5">
            <div class="container">
                <div class="category-nav">
                    <a href="<?= URLROOT; ?>/Pages/menu" class="text-decoration-none ">
                        <div
                            class="category-card text-center rounded-4 shadow-sm border <?= empty($data['selected_category_id']) ? 'active-category' : ''; ?>">
                            <i class="fas fa-list-ul fa-2x"></i>
                            <p class="mb-0 fw-bold fs-6">All</p>
                        </div>
                    </a>

                    <?php foreach ($data['categories'] as $category): ?>
                        <a href="<?= URLROOT; ?>/Pages/menu/<?= $category['id']; ?>"
                            class="text-decoration-none ">
                            <div
                                class="category-card text-center rounded-4 shadow-sm border <?= ($data['selected_category_id'] == $category['id']) ? 'active-category' : ''; ?>">
                                <i class="<?= htmlspecialchars($category['icon_class']); ?> fa-2x"></i>
                                <p class="mb-0 fw-bold fs-5"><?= htmlspecialchars($category['name']); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0 text-muted">Showing <strong><?= count($data['products']); ?></strong> delicious items
                    </p>
                    <div class="dropdown">
                        <button class="btn btn-secondary-outline dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Sort by:
                            <?php
                            $sortText = [
                                'newest' => 'Newest',
                                'price_low_high' => 'Price: Low to High',
                                'price_high_low' => 'Price: High to Low',
                                'name_az' => 'Name: A-Z'
                            ];
                            echo $sortText[$data['sortOrder']];
                            ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item sort-option" href="#" data-sort-value="newest">Newest</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort-value="price_low_high">Price: Low to High</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort-value="price_high_low">Price: High to Low</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort-value="name_az">Name: A-Z</a></li>
                        </ul>
                    </div>
                </div>

                <div class="product-grid">
                    <?php if (!empty($data['products']) && is_array($data['products'])): ?>
                        <?php foreach ($data['products'] as $product): ?>
                            <div class="">
                                <div class="card product-card h-100 rounded-4">
                                    <div class="product-image-container">
                                        <img src="<?= URLROOT; ?>/img/products/<?= htmlspecialchars($product['product_img']); ?>"
                                            class="card-img-top product-img"
                                            alt="<?= htmlspecialchars($product['product_name']); ?>">
                                       <?php if ($product['quantity'] <= 0): ?>
                                        <span class="badge bg-danger rounded-pill position-absolute top-0 end-0 mt-3 me-3 animate__bounceIn">
                                            OUT OF STOCK
                                        </span>
                                    <?php endif; ?>
                                    </div>

                                    <div class="card-body text-center d-flex flex-column">
                                        <h5 class="fw-bold text-dark fs-5 mb-2">
                                            <?= htmlspecialchars($product['product_name']); ?></h5>
                                        <p class="text-muted small mb-3 flex-grow-1 line-clamp-2">
                                            <?= htmlspecialchars($product['description']); ?></p>
                                        <div class="d-flex justify-content-center align-items-center mb-2">
                                            <?php
                                            // The average_rating is a property of the product object
                                            $averageRating = isset($product['average_rating']) ? round($product['average_rating']) : 0;
                                            $ratingCount   = isset($product['rating_count']) ? $product['rating_count'] : 0;

                                            ?>
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?= $i <= $averageRating ? 'text-warning' : 'text-secondary'; ?>"></i>
                                            <?php endfor; ?>
                                            <span class="ms-2 text-muted small">(<?= $ratingCount ?>)</span>

                                        </div>
                                        <p class="fw-bold fs-4 text-warning mb-2">
                                            $<?= htmlspecialchars(number_format($product['price'], 2)); ?>
                                        </p>
                                        <form action="<?= URLROOT; ?>/CartController/addToCart" method="POST"
                                            class="d-flex flex-column align-items-center">
                                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                                            <div class="input-group mb-3 w-75">
                                                <button type="button" class="btn btn-secondary-outline btn-minus">-</button>
                                                <input type="number" name="quantity" class="form-control text-center" value="1"
                                                    min="1" max="<?= $product['quantity']; ?>">
                                                <button type="button" class="btn btn-secondary-outline btn-plus">+</button>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 text-white fw-bold mb-2"
                                                <?= ($product['quantity'] <= 0) ? 'disabled' : ''; ?>>
                                                <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                            </button>
                                            <button type="button" class="btn btn-secondary-outline w-100 fw-bold"
                                                data-bs-toggle="modal" data-bs-target="#ratingModal"
                                                data-product-id="<?= $product['id']; ?>">
                                                <i class="fas fa-star me-1"></i> Rate Product
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
                                <p class="mb-0 mt-2 fs-5">No delicious items found in this category right now. Check back
                                    soon!</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="pagination-container my-5">
                    <nav aria-label="Product Page Navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= ($data['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link"
                                    href="<?= URLROOT; ?>/Pages/menu/<?= $data['selected_category_id'] ?? ''; ?>?page=<?= $data['currentPage'] - 1; ?>&search=<?= urlencode($data['searchQuery']); ?>&sort=<?= htmlspecialchars($data['sortOrder']); ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                                <li class="page-item <?= ($i == $data['currentPage']) ? 'active' : ''; ?>">
                                    <a class="page-link"
                                        href="<?= URLROOT; ?>/Pages/menu/<?= $data['selected_category_id'] ?? ''; ?>?page=<?= $i; ?>&search=<?= urlencode($data['searchQuery']); ?>&sort=<?= htmlspecialchars($data['sortOrder']); ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($data['currentPage'] >= $data['totalPages']) ? 'disabled' : ''; ?>">
                                <a class="page-link"
                                    href="<?= URLROOT; ?>/Pages/menu/<?= $data['selected_category_id'] ?? ''; ?>?page=<?= $data['currentPage'] + 1; ?>&search=<?= urlencode($data['searchQuery']); ?>&sort=<?= htmlspecialchars($data['sortOrder']); ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
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
    </div>

</div>

<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Rate this Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ratingForm" action="<?= URLROOT; ?>/RatingController/submit" method="POST">
                    <input type="hidden" name="product_id" id="rating_product_id">
                    <p class="text-center mb-4">How many stars would you give this product?</p>
                    <div class="rating-stars text-center fs-3 mb-4">
                        <i class="fas fa-star" data-rating="1"></i>
                        <i class="fas fa-star" data-rating="2"></i>
                        <i class="fas fa-star" data-rating="3"></i>
                        <i class="fas fa-star" data-rating="4"></i>
                        <i class="fas fa-star" data-rating="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="selected_rating" required>
                    <div class="mb-4">
                        <label for="comment" class="form-label">Your Comment (Optional):</label>
                        <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Rating modal script
    const ratingModal = document.getElementById('ratingModal');
    ratingModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        const button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        const productId = button.getAttribute('data-product-id');

        // Update the modal's hidden input
        const modalInput = ratingModal.querySelector('#rating_product_id');
        modalInput.value = productId;
    });

    // Star rating functionality
    const stars = document.querySelectorAll('#ratingModal .rating-stars .fas.fa-star');
    const selectedRatingInput = document.getElementById('selected_rating');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const ratingValue = star.getAttribute('data-rating');
            selectedRatingInput.value = ratingValue;

            // Update star colors
            stars.forEach(s => {
                const sRating = s.getAttribute('data-rating');
                if (sRating <= ratingValue) {
                    s.classList.add('text-warning');
                    s.classList.remove('text-secondary');
                } else {
                    s.classList.add('text-secondary');
                    s.classList.remove('text-warning');
                }
            });
        });
    });


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

        const searchInput = document.getElementById('menu-search-input');
        searchInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                const url = new URL(window.location.href);
                url.searchParams.set('search', this.value);
                url.searchParams.set('page', 1); // Reset to page 1 on new search
                window.location.href = url.toString();
            }
        });

        // New Logic for Sort Dropdown
        const sortOptions = document.querySelectorAll('.sort-option');
        sortOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const sortValue = this.dataset.sortValue;
                const url = new URL(window.location.href);
                url.searchParams.set('sort', sortValue);
                url.searchParams.set('page', 1); // Reset to page 1 on new sort
                window.location.href = url.toString();
            });
        });
    });
</script>
<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// // Show footer for public users (role != admin)
// // Assuming admin role = 1
// if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
//     require_once APPROOT . '/views/user/inc/footer.php';
// }
// 
?>