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
                                echo 'Guest'; // Or leave it blank
                            }
                        ?>!
                    </strong>
                </span>
                <a href="<?php echo URLROOT; ?>/auth/logout" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>

        <div class="content-area">
            <div class="container mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Edit Category</h3>
                    <a href="<?php echo URLROOT; ?>/CategoryController/index" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
                </div>

                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card shadow border-0">
                            <div class="card-header bg-warning text-white">
                                <h4 class="mb-0">Category Details</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo URLROOT; ?>/CategoryController/update" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['category']['id']); ?>">
                                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($data['category']['category_image']); ?>">

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Category Name</label>
                                        <input type="text" name="name" id="name" class="form-control" 
                                               placeholder="Enter category name here" 
                                               value="<?php echo htmlspecialchars($data['category']['name']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" 
                                                  placeholder="Enter a short description" required><?php echo htmlspecialchars($data['category']['description']); ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Current Image</label>
                                        <?php if (!empty($data['category']['category_image'])): ?>
                                            <img src="<?php echo URLROOT; ?>/img/categories/<?php echo htmlspecialchars($data['category']['category_image']); ?>" 
                                                 alt="Current Category Image" 
                                                 class="img-thumbnail d-block mb-2" 
                                                 style="max-width: 40px;">
                                        <?php else: ?>
                                            <p class="text-muted">No image currently set.</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_image" class="form-label">Upload New Image</label>
                                        <input type="file" name="category_image" id="category_image" class="form-control" accept="image/*">
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                                               <?php echo $data['category']['is_active'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="is_active">
                                            Is Active
                                        </label>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-sync-alt"></i> Update Category
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>