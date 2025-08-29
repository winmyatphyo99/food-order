<?php require_once APPROOT . '/views/inc/header.php'; ?>

<div class="register-wrapper">
    <div class="register-container">
        
        <div class="register-image"></div>

        <div class="register-form">
            <h2>Create Account</h2>

            <form method="POST" action="<?php echo URLROOT; ?>/auth/register" autocomplete="off">
                <?php require APPROOT . '/views/components/auth_message.php'; ?>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Enter Email" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" placeholder="Enter Phone Number" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required>
                    <span class="toggle-password" onclick="togglePassword('password')">&#128065;</span>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                    <span class="toggle-password" onclick="togglePassword('confirm_password')">&#128065;</span>
                </div>
                
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6Lco-rYrAAAAAE4gIHjCXSlpI191sLq6OXKrVd6N"></div>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="agree-term" id="agree-term" required>
                    <label for="agree-term">I agree to the <a href="#">Terms of Service</a></label>
                </div>

                <input type="submit" class="form-submit" value="Register">
            </form>

            <div class="text-center">
                Already have an account? <a href="<?php echo URLROOT; ?>/pages/login">Login</a>
            </div>
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    passwordField.type = passwordField.type === "password" ? "text" : "password";
}
</script>

<?php require_once APPROOT . '/views/inc/footer.php' ?>