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
            <div class="container my-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Edit Order</h3>
                    <a href="<?php echo URLROOT; ?>/OrderController/index" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
                
                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card shadow border-0">
                            <div class="card-header bg-warning text-white">
                                <h4 class="mb-0">Order Details</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo URLROOT; ?>/OrderController/update" method="POST">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['order']['id']); ?>">
                                    
                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">User ID</label>
                                        <input type="number" name="user_id" id="user_id" class="form-control" 
                                               value="<?php echo htmlspecialchars($data['order']['user_id']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                    <label class="form-label">Select Payment Method</label>
                                    <?php if (!empty($data['payments'])): ?>
                                        <div class="payment-methods-list">
                                            <?php foreach ($data['payments'] as $method): ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="payment_method_id"
                                                        id="method_<?php echo htmlspecialchars($method['id']); ?>"
                                                        value="<?php echo htmlspecialchars($method['id']); ?>"
                                                        <?php echo ($data['order']['payment_method_id'] == $method['id']) ? 'checked' : ''; ?>
                                                        required>
                                                    <label class="form-check-label" for="method_<?php echo htmlspecialchars($method['id']); ?>">
                                                        <?php if (!empty($method['logo_url'])): ?>
                                                            <img src="<?php echo URLROOT . '/public/img/payment_logos/' . htmlspecialchars($method['logo_url']); ?>"
                                                                alt="<?php echo htmlspecialchars($method['payment_name']); ?>"
                                                                style="width: 30px; height: 30px; vertical-align: middle;">
                                                        <?php endif; ?>
                                                        <?php echo htmlspecialchars($method['payment_name']); ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning mt-2">No active payment methods found.</div>
                                    <?php endif; ?>
                                </div>

                                    <div class="mb-3">
                                        <label for="total_amt" class="form-label">Total Amount</label>
                                        <input type="number" name="total_amt" id="total_amt" class="form-control" 
                                               value="<?php echo htmlspecialchars($data['order']['total_amt']); ?>" step="0.01" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="delivery_address" class="form-label">Delivery Address</label>
                                        <input type="text" name="delivery_address" id="delivery_address" class="form-control" 
                                               value="<?php echo htmlspecialchars($data['order']['delivery_address']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="pending" <?php echo ($data['order']['status'] == 'pending' || $data['order']['status'] == 0) ? 'selected' : ''; ?>>Pending</option>
                                            <option value="processing" <?php echo ($data['order']['status'] == 'processing' || $data['order']['status'] == 1) ? 'selected' : ''; ?>>Processing</option>
                                            <option value="completed" <?php echo ($data['order']['status'] == 'completed' || $data['order']['status'] == 2) ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo ($data['order']['status'] == 'cancelled' || $data['order']['status'] == 3) ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-warning px-5 d-block w-100">
                                        <i class="fas fa-sync-alt"></i> Update Order
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

<?php require_once APPROOT . '/views/inc/footer.php'; ?>