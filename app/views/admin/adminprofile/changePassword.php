<?php require_once APPROOT . '/views/inc/header.php'; ?>
<style>/* General body and typography styles */
body {
    background-color: #f0f2f5;
    font-family: 'Arial', sans-serif;
    color: #333;
}

/* Dashboard layout styles */
.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
}

.main-content {
    flex-grow: 1;
    padding: 20px;
    background-color: #f0f2f5;
}

.content-area {
    padding: 20px;
}

/* Card and form container styles */
.card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 20px;
}

/* Form element styles */
.form-label {
    font-weight: bold;
    color: #555;
    margin-bottom: .5rem;
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    font-size: 1rem;
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.form-control:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
    outline: none;
}

.mb-3 {
    margin-bottom: 1.5rem;
}

/* Button styles */
.btn {
    padding: 12px 20px;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
}

.btn-success {
    background-color: #28a745;
    color: #fff;
}

.btn-success:hover {
    background-color: #218838;
    transform: translateY(-2px);
}

.btn-secondary {
    background-color: #6c757d;
    color: #fff;
    margin-top: 10px;
}

.btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}

.w-100 {
    width: 100%;
}

.mt-2 {
    margin-top: 0.5rem;
}

/* Utility classes */
.my-5 {
    margin-top: 3rem;
    margin-bottom: 3rem;
}

.mb-4 {
    margin-bottom: 1.5rem;
}

.p-4 {
    padding: 1.5rem !important;
}

.mx-auto {
    margin-left: auto;
    margin-right: auto;
}

.text-center {
    text-align: center;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}</style>
<div class="dashboard-wrapper">
    <?php require_once APPROOT . '/views/inc/sidebar.php'; ?>

    <main class="main-content">
       <?php require_once APPROOT . '/views/inc/admin_logo.php'; ?>

        <div class="content-area">
            <div class="container my-5">
                <h3 class="mb-4">Change Password</h3>

                <div class="card shadow-sm p-4 mx-auto" style="max-width:600px;">
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

                        <button type="submit" class="btn btn-success w-100">Update Password</button>
                        <a href="<?php echo URLROOT; ?>/AdminController/profile" class="btn btn-secondary w-100 mt-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once APPROOT . '/views/inc/footer.php'; ?>