<?php require_once APPROOT . '/views/inc/header.php' ?>
<section class="vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card">
                    <div class="card-body p-4 p-lg-5">
                        <form method="POST" action="<?php echo URLROOT; ?>/auth/resetPassword/<?php echo $data['token']; ?>">
                            <?php require APPROOT . '/views/components/auth_message.php'; ?>
                            <div class="text-center mb-4">
                                <h1>Reset Your Password</h1>
                                <p>Enter and confirm your new password below.</p>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" required />
                                    <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" id="confirm_password" name="confirm_password"
                                    class="form-control form-control-lg" required />
                            </div>

                            <button class="btn btn-custom btn-lg w-100 mb-3" type="submit">Reset Password</button>

                            <p class="text-center">
                                <a href="<?php echo URLROOT; ?>/auth/login" class="text-primary-color">Cancel and go back to login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#toggle-password');
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const icon = this.querySelector('i');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }
    });
</script>
<?php require_once APPROOT . '/views/inc/footer.php' ?>