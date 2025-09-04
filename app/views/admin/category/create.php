<?php require_once APPROOT . '/views/inc/header.php' ?>

<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php' ?>

    <main class="main-content">
       <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container my-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Create New Category</h3>
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
                                <form action="<?php echo URLROOT; ?>/CategoryController/store" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Category Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter category name here" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter a short description" required></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="category_image" class="form-label">Category Image</label>
                                        <input type="file" name="category_image" id="category_image" class="form-control" accept="image/*">
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                        <label class="form-check-label" for="is_active">
                                            Is Active
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-warning px-5 d-block w-100">
                                        <i class="fas fa-plus-circle"></i> Add Category
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once APPROOT . '/views/inc/footer.php' ?>