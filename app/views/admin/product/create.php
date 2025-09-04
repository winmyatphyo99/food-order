<?php require_once APPROOT . '/views/inc/header.php' ?>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php' ;?>
    
    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container my-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Create New Product</h3>
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
                                <form action="<?php echo URLROOT; ?>/ProductController/store" method="POST" enctype="multipart/form-data">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="align-middle fw-bold">Category</td>
                                                <td>
                                                    <select name="category_id" id="category_id" class="form-control" required>
                                                        <option value="">Select a Category</option>
                                                        <?php foreach ($data['categories'] as $category): ?>
                                                            <option value="<?php echo $category['id']; ?>">
                                                                <?php echo htmlspecialchars($category['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle fw-bold">Product Name</td>
                                                <td>
                                                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name here" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle fw-bold">Description</td>
                                                <td>
                                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter a short description" required></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle fw-bold">Price</td>
                                                <td>
                                                    <input type="number" name="price" id="price" class="form-control" placeholder="Enter product price" step="0.01" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle fw-bold">Quantity</td>
                                                <td>
                                                    <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter product quantity" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle fw-bold">Product Image</td>
                                                <td>
                                                    <input type="file" name="product_img" id="product_img" class="form-control" accept="image/*">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle fw-bold">Status</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="is_available" id="is_available" value="1" checked>
                                                        <label class="form-check-label" for="is_available">
                                                            Is Available
                                                        </label>
                                                    </div>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" name="is_hot" id="is_hot" value="1" checked>
                                                        <label class="form-check-label" for="is_hot">
                                                            🔥 Mark as Hot Product
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-warning px-5 d-block w-100">
                                            <i class="fas fa-plus-circle"></i> Add Product
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

<?php require_once APPROOT . '/views/inc/footer.php' ?>