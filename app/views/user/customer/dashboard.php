<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<style>
    /* Base Styles */
    body {
        background-color: #f4f7f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Dashboard Layout */
    .dashboard-wrapper {
        display: flex;
        min-height: 100vh;
    }
    .profile-logo {
    border-radius: 50% !important;
    width: 40px; 
    height: 40px; 
    object-fit: cover;
}

    .main-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .content-area {
        padding: 2rem;
        flex-grow: 1;
    }

    /* Summary Cards */
    .card-custom {
        border-radius: 1rem;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .icon-circle {
        width: 65px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* Color Classes for Cards */
    .bg-light-primary {
        background-color: #e0f7fa !important;
    }

    .bg-light-success {
        background-color: #e8f5e9 !important;
    }

    .bg-light-warning {
        background-color: #fffde7 !important;
    }

    .bg-light-info {
        background-color: #e1f5fe !important;
    }

    .bg-light-danger {
        background-color: #fdecea !important;
    }

    /* Table Styles */
    .badge {
        font-size: 0.8em;
        font-weight: 600;
        padding: 0.5em 1.2em;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
    }

    /* Footer */
    .dashboard-footer {
        background-color: #fff;
        border-top: 1px solid #e9ecef;
        box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Quick Action Buttons */
    .quick-actions a {
        padding: 0.5rem 1.5rem;
        font-weight: 600;
    }

    /* Recent Orders Images */
    .recent-orders-images img {
        border-radius: 0.5rem;
        border: 1px solid #ddd;
        transition: transform 0.3s;
        width: 150px;
        /* Example size */
        height: 150px;
        object-fit: cover;
    }

    .recent-orders-images img:hover {
        transform: scale(1.1);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .quick-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .card-body h2 {
            font-size: 1.5rem;
        }
    }


</style>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>

    <main class="main-content">
        <div class="content-area container-fluid my-5">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h4 class="mb-3 mb-md-0 text-dark fw-bold">
                    <i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard Overview
                </h4>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="quick-actions d-flex gap-3 flex-wrap">
                        <a href="<?= URLROOT; ?>/Pages/menu" class="btn btn-primary">+ New Order</a>
                        
                    </div>
                <?php endif; ?>
            </div>

            <div class="row g-4 mb-5">
                <?php
                $summaryCards = [
                    ['title' => 'Total Orders', 'value' => $data['totalOrders'] ?? 0, 'icon' => 'fa-box', 'bg' => 'bg-light-primary', 'text' => 'text-primary', 'link' => URLROOT . '/OrderController/orderHistory', 'data-id' => 'total'],
                    ['title' => 'Cancelled Orders', 'value' => $data['cancelledOrders'] ?? 0, 'icon' => 'fa-times-circle', 'bg' => 'bg-light-danger', 'text' => 'text-danger', 'link' => URLROOT . '/CustomerController/orderHistory?status=cancelled', 'data-id' => 'cancelled'],
                    ['title' => 'Pending Orders', 'value' => $data['pendingOrders'] ?? 0, 'icon' => 'fa-clock', 'bg' => 'bg-light-warning', 'text' => 'text-warning', 'link' => URLROOT . '/CustomerController/orderHistory?status=pending', 'data-id' => 'pending'],
                    ['title' => 'Last Order Date', 'value' => $data['lastOrderDate'] ?? 'N/A', 'icon' => 'fa-check-circle', 'bg' => 'bg-light-info', 'text' => 'text-info', 'link' => URLROOT . '/OrderController/orderHistory', 'data-id' => 'last-date'],
                ];
                foreach ($summaryCards as $card) {
                    echo "
                    <div class='col-md-6 col-lg-3'>
                        <a href='{$card['link']}' class='text-decoration-none'>
                            <div class='card card-custom h-100 shadow-sm' data-card-id='{$card['data-id']}'>
                                <div class='card-body d-flex align-items-center justify-content-between'>
                                    <div>
                                        <h5 class='card-title text-muted fw-bold mb-1'>{$card['title']}</h5>
                                        <h2 class='card-text {$card['text']} fw-bold'>{$card['value']}</h2>
                                    </div>
                                    <div class='icon-circle {$card['bg']} {$card['text']}'>
                                        <i class='fas {$card['icon']} fa-2x'></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    ";
                }
                ?>
            </div>

            <div class="row mb-5 g-4">
                <div class="col-md-6">
                    <div class="card card-custom shadow-sm h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h5 class="card-title mb-4 fw-bold">Orders Status Overview</h5>
                            <canvas id="ordersChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-custom shadow-sm h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title fw-bold m-0">Recent Orders</h5>
                                <a href="<?= URLROOT; ?>/CustomerController/orderHistory?status=pending" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
                            </div>

                            <a href="<?php echo URLROOT; ?>/CustomerController/orderHistory?status=pending" class="text-decoration-none">
                                <div class="recent-orders-images d-flex flex-wrap justify-content-center gap-2">
                                    <?php if (!empty($data['recentOrders_withImg'])): ?>
                                        <?php foreach ($data['recentOrders_withImg'] as $order): ?>
                                            <?php if (!empty($order['product_img'])): ?>
                                                <div class="order-img-wrapper">
                                                    <img src="<?= URLROOT . '/img/products/' . htmlspecialchars($order['product_img']); ?>" alt="Order #<?= $order['order_id']; ?>" class="order-img rounded">
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
                                    <tr data-status="<?= htmlspecialchars($order['status']); ?>">
                                        <td>#<?= $order['id']; ?></td>
                                        <td><?= date('M d, Y', strtotime($order['created_at'])); ?></td>
                                        <td>$<?= number_format($order['total_amt'], 2); ?></td>
                                        <td>
                                            <?php
                                            $statusClass = 'bg-info';
                                            if ($order['status'] == 'Completed') $statusClass = 'bg-success';
                                            elseif ($order['status'] == 'Pending') $statusClass = 'bg-warning text-dark';
                                            elseif ($order['status'] == 'Cancelled') $statusClass = 'bg-danger text-white';
                                            ?>
                                            <span class="badge <?= $statusClass; ?>"><?= htmlspecialchars($order['status']); ?></span>
                                        </td>
                                        <td>
                                            <a href="<?= URLROOT; ?>/OrderController/orderHistory/" class="btn btn-sm btn-outline-primary rounded-pill">View Details</a>
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
        <?php require_once APPROOT . '/views/user/customer/footer.php'; ?>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('ordersChart');
        if (ctx) {
            const completed = parseInt(document.querySelector("[data-card-id='total'] .card-text").textContent) - parseInt(document.querySelector("[data-card-id='pending'] .card-text").textContent) - parseInt(document.querySelector("[data-card-id='cancelled'] .card-text").textContent);
            const pending = parseInt(document.querySelector("[data-card-id='pending'] .card-text").textContent);
            const cancelled = parseInt(document.querySelector("[data-card-id='cancelled'] .card-text").textContent);

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Pending', 'Cancelled'],
                    datasets: [{
                        data: [completed, pending, cancelled],
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
                            labels: {
                                boxWidth: 15,
                                padding: 15
                            }
                        }
                    }
                }
            });
        }
    });
</script>

