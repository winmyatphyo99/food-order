<?php require_once APPROOT . '/views/inc/header.php' ?>
<style>
/* ===== Global ===== */
body {
    margin: 0;
    font-family: "Poppins", sans-serif;
    background: linear-gradient(135deg, #f0f4f7, #e0e9ec);
    color: #495057;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* ===== Login Container ===== */
.login-container {
    background: #fff;
    border-radius: 1.5rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 3rem 2.5rem;
    width: 100%;
    max-width: 600px;
    transition: transform 0.3s ease;
}

/* ===== Header ===== */
.login-header {
    text-align: center;
    margin-bottom: 2rem;
}
.login-header h2 {
    font-weight: 700;
    color: #2b7a78;
    margin-bottom: 0.5rem;
}
.login-header p {
    color: #888;
    font-size: 0.95rem;
}

/* ===== Form Elements ===== */
.form-label {
    font-weight: 500;
    color: #555;
}
.form-control {
    border-radius: 0.75rem;
    padding: 0.9rem 1.2rem;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
    width: 100%;
    box-sizing: border-box;
}
.form-control:focus {
    border-color: #2b7a78;
    box-shadow: 0 0 0 0.25rem rgba(43, 122, 120, 0.15);
}

.input-group {
    position: relative;
    width: 100%;
}
.input-group .form-control {
    padding-right: 3rem;
}
.input-group-text {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    cursor: pointer;
    background: transparent;
    border: none;
    padding: 0;
}

/* ===== Button ===== */
.btn-login {
    background: #2b7a78;
    color: #fff;
    border: none;
    border-radius: 0.75rem;
    padding: 1rem;
    font-weight: 600;
    width: 100%;
    margin-top: 1.5rem;
    letter-spacing: 0.5px;
    transition: background 0.3s ease, box-shadow 0.3s ease;
}
.btn-login:hover {
    background: #205d5b;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* ===== Links ===== */
.login-links {
    text-align: center;
    margin-top: 1.5rem;
    font-size: 0.9rem;
}
.login-links a {
    color: #2b7a78;
    text-decoration: none;
    font-weight: 500;
}
.login-links a:hover {
    text-decoration: underline;
}

.d-flex { display: flex; }
.justify-content-between { justify-content: space-between; }
.align-items-center { align-items: center; }
.mb-3 { margin-bottom: 1.2rem; }

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
    padding: 0.75rem 1.25rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
}
</style>

<div class="login-container">
    <div class="login-header">
        <h2><?php echo SITENAME ?></h2>
        <p>Sign in to your account to continue.</p>
    </div>

    <?php if (isset($data['error'])): ?>
        <div class="alert alert-danger"><?php echo $data['error']; ?></div>
    <?php endif; ?>
    <?php require APPROOT . '/views/components/auth_message.php'; ?>

    <form method="POST" action="<?php echo URLROOT; ?>/auth/login">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" id="email" name="email" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" required />
                <span class="input-group-text" id="toggle-password">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" name="remember-me">
                <label class="form-check-label" for="remember-me">Remember me</label>
            </div>
            <a href="<?php echo URLROOT; ?>/auth/forgotPassword" class="login-links">Forgot password?</a>
        </div>

        <button class="btn-login" type="submit">Login</button>

        <div class="login-links">
            Don't have an account? 
            <a href="<?php echo URLROOT; ?>/auth/register">Register</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('#toggle-password');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    }
});
</script>
<?php require_once APPROOT . '/views/inc/footer.php' ?>