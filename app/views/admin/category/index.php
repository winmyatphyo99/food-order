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
                    <h4 class="mb-3 mb-md-0 text-dark fw-bold"><i class="fas fa-folder-open me-2 text-warning"></i> Manage Categories</h4>
                    <a href="<?php echo URLROOT; ?>/CategoryController/create" class="btn btn-warning px-4 shadow-sm fw-bold">
                        <i class="fas fa-plus me-2"></i> Add New Category
                    </a>
                </div>

                <?php require APPROOT . '/views/components/auth_message.php'; ?>
                
                <div class="card shadow-lg rounded-4 border-0">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <?php if (!empty($data['categories'])): ?>
                                <table class="table table-hover align-middle">
                                    <thead class="text-uppercase text-muted">
                                        <tr>
                                            <th scope="col" style="width: 10%;">Image</th>
                                            <th scope="col" style="width: 20%;">Name</th>
                                            <th scope="col" style="width: 40%;">Description</th>
                                            <th scope="col" style="width: 15%;">Status</th>
                                            <th scope="col" class="text-center" style="width: 15%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['categories'] as $category): ?>
                                            <tr>
                                                <td>
                                                    <?php if (!empty($category['category_image'])): ?>
                                                        <img src="<?php echo URLROOT; ?>/img/categories/<?php echo htmlspecialchars($category['category_image']); ?>"
                                                             alt="<?php echo htmlspecialchars($category['name']); ?>"
                                                             class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <i class="fas fa-image fa-3x text-muted" style="opacity: 0.5;"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <h6 class="mb-0 fw-bold text-primary"><?php echo htmlspecialchars($category['name']); ?></h6>
                                                </td>
                                                <td>
                                                    <p class="text-truncate mb-0" style="max-width: 300px;"><?php echo htmlspecialchars($category['description']); ?></p>
                                                </td>
                                                <td>
                                                    <span class="badge <?php echo $category['is_active'] ? 'bg-success' : 'bg-danger'; ?> rounded-pill px-3 py-2">
                                                        <?php echo $category['is_active'] ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Category actions">
                                                        <a href="<?php echo URLROOT; ?>/CategoryController/edit/<?php echo $category['id']; ?>"
                                                           class="btn btn-outline-primary btn-sm" title="Edit Category">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <a href="<?php echo URLROOT; ?>/CategoryController/destroy/<?php echo base64_encode($category['id']); ?>"
                                                           class="btn btn-outline-danger btn-sm ms-2" title="Delete Category"
                                                           onclick="return confirm('Are you sure you want to delete this category?');">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info text-center py-5 rounded-4 border-0" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> No categories found. Please add a new one.
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