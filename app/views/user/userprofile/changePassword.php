<?php require_once APPROOT . '/views/user/inc/header.php'; ?>

<style>
.password-container {
    background-color: #ffffff;
    padding: 2.5rem;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    width: 100%;
    margin: 0 auto;
}

.dashboard-wrapper {
        display: flex;
        min-height: 100vh;
        background-color: #f4f7f9;
    }

    .main-content {
        flex-grow: 1;
        display: flex;
        padding: 10rem;
        flex-direction: column;
        /* Default to full width on small screens */
    }

.password-container h3 {
    color: #343a40;
    font-weight: 600;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 1rem;
    margin-bottom: 2rem;
}

.password-container .form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.password-container .form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 0.9rem;
    width: 100%;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

.password-container .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    outline: none;
}

.password-container .btn-success {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.password-container .btn-success:hover {
    background-color: #218838;
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
}</style>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/user/customer/sidebar.php'; ?>
    <div class="main-content">
    <div class="password-container">
    <h3 class="mb-4">Change Password</h3>

    <?php require APPROOT . '/views/components/auth_message.php'; ?>

    <form action="<?php echo URLROOT; ?>/user/changePassword" method="POST">
        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Update Password</button>
    </form>
</div>
    </div>
    
</div>


<?php require_once APPROOT . '/views/user/inc/footer.php'; ?>
