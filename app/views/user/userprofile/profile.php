<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>

<div class="container my-5">
    <h3 class="mb-4">My Account</h3>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" 
                    type="button" role="tab">Profile Info</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" 
                    type="button" role="tab">Edit Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" 
                    type="button" role="tab">Change Password</button>
        </li>
    </ul>

    <div class="tab-content" id="profileTabContent">

        <!-- Profile View -->
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
            <div class="card shadow-sm p-4 mx-auto" style="max-width:600px;">
                <div class="text-center mb-4">
                    <img src="<?php 
                        echo !empty($data['user']->profile_image) 
                            ? URLROOT . '/uploads/profile/' . htmlspecialchars($data['user']->profile_image) 
                            : URLROOT . '/uploads/profile/default_profile.jpg';
                    ?>" 
                    alt="Profile" class="rounded-circle border shadow-sm" 
                    style="width:120px; height:120px; object-fit:cover;">
                    <h5 class="mt-3"><?php echo htmlspecialchars($data['user']->name); ?></h5>
                    <small class="text-muted"><?php echo htmlspecialchars($data['user']->email); ?></small>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Username:</span>
                        <span><?php echo htmlspecialchars($data['user']->name); ?></span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Mobile:</span>
                        <span><?php echo htmlspecialchars($data['user']->phone_number); ?></span>
                    </div>
                   
                </div>
            </div>
        </div>

        <!-- Edit Profile -->
        <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
            <div class="card shadow-sm p-4 mx-auto" style="max-width:600px;">
                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <form action="<?php echo URLROOT; ?>/UserController/editProfile" 
                      method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" 
                               value="<?php echo htmlspecialchars($data['user']->name ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control" 
                               value="<?php echo htmlspecialchars($data['user']->email ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label fw-bold">Phone</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" 
                               value="<?php echo htmlspecialchars($data['user']->phone_number ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="profile_image" class="form-label fw-bold">Profile Image</label>
                        <input type="file" name="profile_image" id="profile_image" class="form-control">

                        <?php if (!empty($data['user']->profile_image)): ?>
                            <div class="mt-2">
                                <img src="<?php 
                                    echo strpos($data['user']->profile_image, 'http') === 0
                                        ? htmlspecialchars($data['user']->profile_image)
                                        : URLROOT . '/uploads/profile/' . htmlspecialchars($data['user']->profile_image);
                                ?>" 
                                alt="Profile" width="100" class="rounded-circle border">
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
            <div class="card shadow-sm p-4 mx-auto" style="max-width:600px;">
                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <form action="<?php echo URLROOT; ?>/UserController/changePassword" method="POST">
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-bold">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-bold">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label fw-bold">Confirm New Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Update Password</button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>
