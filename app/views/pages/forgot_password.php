<?php require_once APPROOT . '/views/inc/header.php' ?>
<section class="vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card">
                    <div class="card-body p-4 p-lg-5">
                        <form method="POST" action="<?php echo URLROOT; ?>/auth/forgotPassword">
                            <?php require APPROOT . '/views/components/auth_message.php'; ?>
                            <div class="text-center mb-4">
                                <h1>Forgot Password</h1>
                                <p>Enter your email address below to receive a password reset link.</p>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                            </div>
                            
                            <button class="btn btn-custom btn-lg w-100 mb-3" type="submit">Send Reset Link</button>
                            
                            <p class="text-center">
                                Remember your password?
                                <a href="<?php echo URLROOT; ?>/auth/login" class="text-primary-color">Login here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once APPROOT . '/views/inc/footer.php' ?>