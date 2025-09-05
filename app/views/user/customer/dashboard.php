<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<div class="dashboard-wrapper">

    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>

    <main class="main-content">

        <div class="content-area container-fluid my-5">

            <!-- Dashboard Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h4 class="mb-3 mb-md-0 text-dark fw-bold">
                    <i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard Overview
                </h4>

                <!-- Quick Action Buttons -->
               <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="quick-actions d-flex gap-3 flex-wrap">
                    <a href="<?php echo URLROOT; ?>/Pages/menu" class="btn btn-primary">+ New Order</a>
                    <a href="<?php echo URLROOT; ?>/UserController/profile" class="btn btn-outline-secondary">View Profile</a>
                </div>
                    <?php endif ?>
            </div>

            <!-- Summary Cards -->
            <div class="row g-4 mb-5">
                <?php 
                $cards = [
                    ['title' => 'Total Orders', 'value' => $data['totalOrders'] ?? 0, 'icon' => 'fa-box', 'bg' => 'bg-light-primary', 'text' => 'text-primary', 'link' => URLROOT.'/OrderController/orderHistory'],
                    ['title' => 'Cancelled Orders', 'value' => $data['cancelledOrders'] ?? 0, 'icon' => 'fa-times-circle', 'bg' => 'bg-light-danger', 'text' => 'text-danger', 'link' => URLROOT.'/CustomerController/orderHistory?status=cancelled'],
                    ['title' => 'Pending Orders', 'value' => $data['pendingOrders'] ?? 0, 'icon' => 'fa-clock', 'bg' => 'bg-light-warning', 'text' => 'text-warning', 'link' => URLROOT.'/CustomerController/orderHistory?status=pending'],
                    ['title' => 'Last Order Date', 'value' => $data['lastOrderDate'] ? date('M d, Y', strtotime($data['lastOrderDate'])) : 'N/A', 'icon' => 'fa-check-circle', 'bg' => 'bg-light-info', 'text' => 'text-info', 'link' => URLROOT.'/OrderController/orderHistory'],
                ];

                foreach($cards as $card): ?>
                    <div class="col-md-6 col-lg-3">
                        <a href="<?= $card['link'] ?>" class="text-decoration-none">
                            <div class="card card-custom h-100 shadow-sm">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title text-muted fw-bold mb-1"><?= $card['title'] ?></h5>
                                        <h2 class="card-text <?= $card['text'] ?> fw-bold"><?= $card['value'] ?></h2>
                                    </div>
                                    <div class="icon-circle <?= $card['bg'] ?> <?= $card['text'] ?>">
                                        <i class="fas <?= $card['icon'] ?> fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Chart Section + Recent Orders Images -->
<div class="row mb-5 justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card card-custom shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title mb-4 fw-bold">Orders Status Overview</h5>
                
                <!-- Chart -->
                <canvas id="ordersChart"></canvas>

                <!-- Recent Orders Images -->
                <div class="recent-orders-images mt-4 d-flex flex-wrap justify-content-center gap-2">
                    <?php if (!empty($data['recentOrders'])): ?>
                        <?php foreach($data['recentOrders'] as $order): ?>
                            <?php if(!empty($order['img'])): ?>
                                <div class="order-img-wrapper">
                                    <img src="<?= URLROOT . '/img/products/' . htmlspecialchars($order['img']) ?>" 
                                         alt="Order #<?= $order['id'] ?>" 
                                         class="order-img rounded">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted mt-2">No recent order images available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- Recent Orders Table -->
            <div class="recent-orders-section">
                <h4 class="mb-3">Recent Orders</h4>
                
                

                <div class="table-responsive">
                    <table class="table table-borderless table-hover align-middle" id="ordersTable">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['recentOrders'])): ?>
                                <?php foreach ($data['recentOrders'] as $order): ?>
                                    <tr data-status="<?= htmlspecialchars($order['status']) ?>">
                                        <td>#<?= $order['id'] ?></td>
                                        <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                        <td>$<?= number_format($order['total_amt'], 2) ?></td>
                                        <td>
                                            <?php
                                                $statusClass = 'bg-info';
                                                if ($order['status'] == 'Completed') $statusClass = 'bg-success';
                                                elseif ($order['status'] == 'Pending') $statusClass = 'bg-warning text-dark';
                                                elseif ($order['status'] == 'Cancelled') $statusClass = 'bg-danger text-white';
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($order['status']) ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= URLROOT ?>/OrderController/orderHistory/<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill">View Details</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No recent orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <footer class="dashboard-footer text-center py-3 mt-auto">
            <div class="container">
                <span class="text-muted">&copy; <?= date('Y') ?> MyCompany. All rights reserved.</span>
            </div>
        </footer>

    </main>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Orders Chart
    const ctx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending', 'Cancelled'],
            datasets: [{
                data: [
                    <?= ($data['totalOrders'] ?? 0) - ($data['pendingOrders'] ?? 0) - ($data['cancelledOrders'] ?? 0); ?>,
                    <?= $data['pendingOrders'] ?? 0; ?>,
                    <?= $data['cancelledOrders'] ?? 0; ?>
                ],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                borderWidth: 1,
                cutout: '65%'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 15, padding: 15 }
                }
            }
        }
    });

    
    
</script>

<style>
    body {
        background-color: #f4f7f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .dashboard-wrapper { display: flex; min-height: 100vh; }
    .main-content { flex-grow: 1; display: flex; flex-direction: column; }
    .content-area { padding: 2rem; flex-grow: 1; }

    .card-custom { border-radius: 1rem; transition: transform 0.3s, box-shadow 0.3s; }
    .card-custom:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .icon-circle { width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }

    .bg-light-primary { background-color: #e0f7fa !important; }
    .bg-light-success { background-color: #e8f5e9 !important; }
    .bg-light-warning { background-color: #fffde7 !important; }
    .bg-light-info { background-color: #e1f5fe !important; }
    .bg-light-danger { background-color: #fdecea !important; }

    .badge { font-size: 0.8em; font-weight: 600; padding: 0.5em 1.2em; }
    .table-hover tbody tr:hover { background-color: #f8f9fa !important; }

    .dashboard-footer { background-color: #fff; border-top: 1px solid #e9ecef; box-shadow: 0 -2px 4px rgba(0,0,0,0.05); font-size: 0.9rem; color: #6c757d; }

    .quick-actions a { padding: 0.5rem 1.5rem; font-weight: 600; }

    /* Responsive Table */
    @media (max-width: 768px) {
        .quick-actions { flex-direction: column; gap: 1rem; }
        .card-body h2 { font-size: 1.5rem; }
    }
</style>
<!-- 
<?php require_once APPROOT . '/views/user/inc/footer.php' ?> -->
