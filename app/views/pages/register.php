<?php require_once APPROOT . '/views/inc/header.php'; ?>
<style>
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
    /* Removed overflow: hidden so content can scroll if needed */
}

.register-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.register-container {
    display: flex;
    width: 600px; /* Reduced the overall container width */
    max-width: 100%;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    background: #fff;
    transition: transform 0.3s ease;
}

.register-container:hover {
    transform: translateY(-5px);
}



/* Rigister form section */
.register-form {
    flex: 1;
    padding: 50px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    max-width: 700px; /* Prevents the form from becoming too wide */
    margin: 0 auto; /* Centers the form content if its narrower */
}

.register-form h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 28px;
    color: #1a1a1a;
}

.form-group {
    position: relative;
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="password"] {
    width: 100%;
    padding: 14px 45px 14px 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 15px;
    outline: none;
    transition: 0.3s;
}

.form-group input:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0,123,255,0.2);
}

.toggle-password {
    position: absolute;
    right: 15px;
    top: 38px;
    cursor: pointer;
    font-size: 18px;
    color: #888;
    transition: color 0.3s;
}

.toggle-password:hover {
    color: #007bff;
}

.form-group input[type="checkbox"] {
    margin-right: 8px;
}

.form-submit {
    width: 100%;
    padding: 14px;
    background: linear-gradient(90deg, #ff7e5f, #feb47b);
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.form-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.text-center {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

.text-center a {
    color: #007bff;
    text-decoration: none;
}

.text-center a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 900px) {
    .register-container {
        flex-direction: column;
    }
    .register-image {
        height: 200px;
        /* The image takes the full width of the container */
    }
    .register-form {
        padding: 30px 20px;
        max-width: 100%; /* Ensures the form takes up the full width of the container on smaller screens */
    }
}
</style>
<div class="register-wrapper">
    <div class="register-container">
        
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
                Already have an account? <a href="<?php echo URLROOT; ?>/auth/login">Login</a>
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