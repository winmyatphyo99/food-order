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
                    <h3 class="mb-0">Edit Product</h3>
                    <a href="<?php echo URLROOT; ?>/ProductController/index" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>

                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card shadow border-0">
                            <div class="card-header bg-warning text-white">
                                <h4 class="mb-0">Product Details</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo URLROOT; ?>/ProductController/update" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['product']['id']); ?>">
                                    <input type="hidden" name="current_img" value="<?php echo htmlspecialchars($data['product']['product_img']); ?>">

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select name="category_id" id="category_id" class="form-control" required>
                                            <option value="">Select a Category</option>
                                            <?php foreach ($data['categories'] as $category): ?>
                                                <option value="<?php echo $category['id']; ?>" 
                                                    <?php echo ($category['id'] == $data['product']['category_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" name="product_name" id="product_name" class="form-control" 
                                               placeholder="Enter product name here" 
                                               value="<?php echo htmlspecialchars($data['product']['product_name']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" 
                                                  placeholder="Enter a short description" required><?php echo htmlspecialchars($data['product']['description']); ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" name="price" id="price" class="form-control" 
                                               placeholder="Enter product price" step="0.01" 
                                               value="<?php echo htmlspecialchars($data['product']['price']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" 
                                               placeholder="Enter product quantity" 
                                               value="<?php echo htmlspecialchars($data['product']['quantity']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Current Image</label>
                                        <?php if (!empty($data['product']['product_img'])): ?>
                                            <img src="<?php echo URLROOT; ?>/img/products/<?php echo htmlspecialchars($data['product']['product_img']); ?>" 
                                                 alt="Current Product Image" 
                                                 class="img-thumbnail d-block mb-2" 
                                                 style="max-width: 40px;">
                                        <?php else: ?>
                                            <p class="text-muted">No image currently set.</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_img" class="form-label">Upload New Image</label>
                                        <input type="file" name="product_img" id="product_img" class="form-control" accept="image/*">
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="is_available" id="is_available" value="1" 
                                               <?php echo $data['product']['is_available'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="is_available">
                                            Is Available
                                        </label>
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" name="is_hot" id="is_hot" value="1" 
                                               <?php echo $data['product']['is_hot'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="is_hot">
                                            Is Hot
                                        </label>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-sync-alt"></i> Update Product
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