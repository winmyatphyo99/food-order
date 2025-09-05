<?php require_once APPROOT . '/views/user/inc/header.php'; ?>
<style> .dashboard-wrapper {
        display: flex;
        min-height: 100vh;
        background-color: #f4f7f9;
    }

    .main-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        /* Default to full width on small screens */
    }

    /* Custom styles for the profile edit form */

/* General form styling */
.profile-form {
    max-width: 500px;
    margin: 40px auto;
    padding: 3rem;
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    transition: transform 0.3s ease-in-out;
}

.profile-form:hover {
    transform: translateY(-5px);
}

/* Form labels */
.profile-form .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    display: block;
}

/* Form input fields */
.profile-form .form-control {
    border: 1px solid #ced4da;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    color: #495057;
    transition: all 0.3s ease-in-out;
}

.profile-form .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    outline: none;
}

/* Image preview section */
.profile-image-container {
    text-align: center;
    margin-bottom: 1.5rem;
}

.profile-image-preview {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #ffffff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Update profile button */
.profile-form .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 8px;
    transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
    letter-spacing: 0.5px;
}

.profile-form .btn-primary:hover {
    background-color: #0056b3;
    border-color: #004d9c;
    transform: translateY(-2px);
}

.profile-form .btn-primary:active {
    background-color: #004d9c;
    transform: translateY(0);
}
</style>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <div class="main-content">
        <div class="container my-5">
    <h3 class="mb-4">Edit Profile</h3>

    <?php require APPROOT . '/views/components/auth_message.php'; ?>

    <form action="<?php echo URLROOT; ?>/UserController/editProfile" 
          method="POST" enctype="multipart/form-data" 
          class="p-4 border rounded bg-light shadow-sm profile-form">

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

        <div class="mt-2 profile-image-container">
            <label for="profile_image" class="form-label fw-bold">Profile Image</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control">

            <?php if (!empty($data['user']->profile_image)): ?>
                <div class="mt-2">
                    <img src="<?php 
                        echo strpos($data['user']->profile_image, 'http') === 0
                            ? htmlspecialchars($data['user']->profile_image)
                            : URLROOT . '/uploads/profile/' . htmlspecialchars($data['user']->profile_image);
                        ?>" 
                        alt="Profile" width="100" class="rounded-circle border  profile-image-preview">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
    </form>
</div>
    </div>
    
</div>


<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>
