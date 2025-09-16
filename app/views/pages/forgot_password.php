<?php require_once APPROOT . '/views/inc/header.php' ?>
<style>/* General Body & Container Styling */
body {
    background-color: #1b1c21; /* Dark background color */
    color: #f0f2f5; /* Light text color for contrast */
    font-family: 'Poppins', sans-serif; /* A modern, elegant font */
}

/* Card Styling */
.card {
    background-color: #23242c; /* Slightly lighter dark shade for the card */
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.card-body {
    padding: 2.5rem;
}

/* Form Headings */
h1 {
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #f0f2f5;
}

p {
    font-size: 0.95rem;
    color: #aeb4c0;
    line-height: 1.5;
}

/* Form Input Styling */
.form-label {
    font-size: 0.9rem;
    font-weight: 500;
    color: #f0f2f5;
    margin-bottom: 0.25rem;
}

.form-control {
    background-color: #1b1c21;
    border: 1px solid #45474e;
    color: #f0f2f5;
    border-radius: 8px;
    padding: 0.75rem 1.25rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    background-color: #23242c;
    border-color: #7794ff; /* Accent color on focus */
    box-shadow: 0 0 0 4px rgba(119, 148, 255, 0.3);
}

/* Custom Button Styling */
.btn-custom {
    background-color: #7794ff; /* Accent color for the button */
    border: none;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    color: #fff;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(119, 148, 255, 0.3);
}

.btn-custom:hover {
    background-color: #637edc;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(119, 148, 255, 0.4);
}

/* Link Styling */
.text-center a {
    color: #7794ff; /* Accent color for links */
    font-weight: 600;
    transition: color 0.3s ease;
}

.text-center a:hover {
    text-decoration: underline;
    color: #92aeff;
}</style>
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