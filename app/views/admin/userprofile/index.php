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
                    <h4 class="mb-3 mb-md-0 text-dark fw-bold"><i class="fas fa-users me-2 text-primary"></i>All Customer Lists</h4>
                    <!-- <a href="<?php echo URLROOT; ?>/user/create" class="btn btn-primary px-4 shadow-sm fw-bold">
                        <i class="fas fa-plus me-2"></i> Add New User
                    </a> -->
                </div>

                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <div class="card shadow-lg rounded-4 border-0">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <?php if (!empty($data['users'])): ?>
                                <table class="table table-hover align-middle">
                                    <thead class="text-uppercase text-muted">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Profile</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Total Orders</th>
                                            <th scope="col" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['users'] as $user): ?>
                                            <tr>
                                                <td>
                                                    <h6 class="mb-0 fw-bold text-primary"><?php echo htmlspecialchars($user['id']); ?></h6>
                                                </td>
                                                <td>
                                                    <?php if ($user['profile_image']): ?>
                                                        <img src="<?php echo URLROOT; ?>/uploads/profile/<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile" width="50" height="50" class="rounded-circle">
                                                    <?php else: ?>
                                                        N/A
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <!-- <td>
                                                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                        <?php echo htmlspecialchars(ucfirst($user['role'])); ?>
                                                    </span>
                                                </td> -->
                                                <td>
                                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                                        <?php echo htmlspecialchars($user['total_orders']); ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <!-- <a href="<?php echo URLROOT; ?>/user/edit/<?php echo htmlspecialchars($user['id']); ?>"
                                                            class="btn btn-sm btn-outline-secondary me-2" title="Edit User">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?php echo URLROOT; ?>/user/changePassword/<?php echo htmlspecialchars($user['id']); ?>"
                                                            class="btn btn-sm btn-outline-info me-2" title="Change Password">
                                                            <i class="fas fa-key"></i>
                                                        </a> -->
                                                        <a href="<?php echo URLROOT; ?>/user/delete/<?php echo htmlspecialchars($user['id']); ?>"
                                                            class="btn btn-sm btn-outline-danger" title="Delete User"
                                                            onclick="return confirm('Are you sure you want to delete this user?');">
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
                                    <i class="fas fa-info-circle me-2"></i> No users found. Please add a new one.
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