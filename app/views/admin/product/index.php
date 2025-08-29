<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>
    
    <main class="main-content">
        <header class="top-header">
            <div class="header-left">
                <a href="#" class="logo-link">Admin Dashboard</a>
            </div>
            <div class="header-right">
                <span>
                    Welcome, 
                    <strong>
                        <?php 
                            if (isset($_SESSION['user_name'])) {
                                echo htmlspecialchars($_SESSION['user_name']);
                            } else {
                                echo 'Guest';
                            }
                        ?>!
                    </strong>
                </span>
                <a href="<?php echo URLROOT; ?>/auth/logout" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>

        <div class="content-area">
            <div class="container-fluid my-5">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <h4 class="mb-3 mb-md-0 text-dark fw-bold"><i class="fas fa-box-open me-2 text-primary"></i> Manage Products</h4>
                    <a href="<?php echo URLROOT; ?>/ProductController/create" class="btn btn-primary px-4 shadow-sm fw-bold">
                        <i class="fas fa-plus me-2"></i> Add New Product
                    </a>
                </div>

                <?php require APPROOT . '/views/components/auth_message.php'; ?>
                
                <div class="card shadow-lg rounded-4 border-0">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <?php if (!empty($data['products'])): ?>
                                <table class="table table-hover align-middle">
                                    <thead class="text-uppercase text-muted">
                                        <tr>
                                            <th scope="col" style="width: 10%;">Image</th>
                                            <th scope="col" style="width: 20%;">Name</th>
                                            <th scope="col" style="width: 30%;">Description</th>
                                            <th scope="col" style="width: 15%;">Category</th>
                                            <th scope="col" style="width: 10%;">Price</th>
                                            <th scope="col" style="width: 10%;">Quantity</th>
                                            <th scope="col" style="width: 10%;">Status</th>
                                            <th scope="col" class="text-center" style="width: 15%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['products'] as $product): ?>
                                            <tr>
                                                <td>
                                                    <?php if (!empty($product['product_img'])): ?>
                                                        <img src="<?php echo URLROOT; ?>/img/products/<?php echo htmlspecialchars($product['product_img']); ?>"
                                                             alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                                             class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <i class="fas fa-image fa-3x text-muted" style="opacity: 0.5;"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 fw-bold text-primary"><?php echo htmlspecialchars($product['product_name']); ?></h6>
                                                </td>
                                                <td>
                                                    <p class="text-truncate mb-0" style="max-width: 250px;"><?php echo htmlspecialchars($product['description']); ?></p>
                                                </td>
                                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                                <td class="fw-bold text-success">$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                                                <td>
                                                    <span class="badge <?php echo $product['is_available'] ? 'bg-success' : 'bg-danger'; ?> rounded-pill px-3 py-2">
                                                        <?php echo $product['is_available'] ? 'Available' : 'Unavailable'; ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="<?php echo URLROOT; ?>/ProductController/edit/<?php echo $product['id']; ?>"
                                                           class="btn btn-sm btn-outline-primary me-2" title="Edit Product">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?php echo URLROOT; ?>/ProductController/destroy/<?php echo base64_encode($product['id']); ?>"
                                                           class="btn btn-sm btn-outline-danger" title="Delete Product"
                                                           onclick="return confirm('Are you sure you want to delete this product?');">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info text-center py-5 rounded-4 border-0" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> No products found. Please add a new one.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>