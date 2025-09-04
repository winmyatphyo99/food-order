<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<div class="container my-5">
    <h3 class="mb-4">Edit Profile</h3>

    <?php require APPROOT . '/views/components/auth_message.php'; ?>

    <form action="<?php echo URLROOT; ?>/UserController/editProfile" 
          method="POST" enctype="multipart/form-data" 
          class="p-4 border rounded bg-light shadow-sm">

        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" 
                   value="<?php echo htmlspecialchars($data['user']->name ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email Address</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="<?php echo htmlspecialchars($data['user']->email ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label fw-bold">Phone Number</label>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>
