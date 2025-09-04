<?php require_once APPROOT . '/views/inc/header.php'; ?>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>

    <main class="main-content">
        <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container my-5">
                <h3 class="mb-4">My Account</h3>
                
                <div class="card shadow-sm p-4 mx-auto" style="max-width:600px;">
                    <ul class="nav nav-tabs" id="myProfileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="view-profile-tab" data-bs-toggle="tab" data-bs-target="#view-profile" type="button" role="tab" aria-controls="view-profile" aria-selected="true">View Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-profile-tab" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button" role="tab" aria-controls="edit-profile" aria-selected="false">Edit Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="change-password-tab" data-bs-toggle="tab" data-bs-target="#change-password" type="button" role="tab" aria-controls="change-password" aria-selected="false">Change Password</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myProfileTabContent">
                        
                        <div class="tab-pane fade show active" id="view-profile" role="tabpanel" aria-labelledby="view-profile-tab">
                            <h5 class="card-title text-center mt-4 mb-4">Profile Information</h5>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="text-end" style="width: 30%;">Name:</th>
                                            <td><?php echo htmlspecialchars($data['user']->name); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-end">Email:</th>
                                            <td><?php echo htmlspecialchars($data['user']->email); ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="text-end">Phone:</th>
                                            <td><?php echo htmlspecialchars($data['user']->phone_number); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
                            <h5 class="card-title text-center mt-4 mb-4">Update Profile Information</h5>
                            <form action="<?php echo URLROOT; ?>/AdminController/editProfile" method="POST" enctype="multipart/form-data">
                                <div class="text-center mb-4">
                                    <img src="<?php 
                                        echo !empty($data['user']->profile_image) 
                                            ? URLROOT . '/uploads/profile/' . htmlspecialchars($data['user']->profile_image) 
                                            : URLROOT . '/uploads/profile/default_profile.jpg';
                                    ?>" 
                                    alt="Profile" class="rounded-circle border shadow-sm" 
                                    style="width:120px; height:120px; object-fit:cover;">
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Full Name</label>
                                    <input type="text" name="name" id="name" class="form-control" 
                                           value="<?php echo htmlspecialchars($data['user']->name); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" 
                                           value="<?php echo htmlspecialchars($data['user']->email); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label fw-bold">Phone</label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control" 
                                           value="<?php echo htmlspecialchars($data['user']->phone_number); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="profile_image" class="form-label fw-bold">Profile Image</label>
                                    <input type="file" name="profile_image" id="profile_image" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                            <h5 class="card-title text-center mt-4 mb-4">Change Password</h5>
                            <form action="<?php echo URLROOT; ?>/AdminController/changePassword" method="POST">
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
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                    <a href="<?php echo URLROOT; ?>/AdminController/profile" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>