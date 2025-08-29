<?php require_once APPROOT . '/views/inc/header.php' ?>
<section class="vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm-10">
        <div class="card">
          <div class="card-body p-4 p-lg-5">
            <form method="POST" action="<?php echo URLROOT; ?>/auth/login">
              <?php require APPROOT . '/views/components/auth_message.php'; ?>
              <div class="text-center mb-4">
                <?php echo SITENAME; ?></p>
                
              </div>

              <?php if (isset($data['error'])): ?>
                <div class="alert alert-danger"><?php echo $data['error']; ?></div>
              <?php endif; ?>

              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg" required />
              </div>

             

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <input type="password" id="password" name="password"
                    class="form-control form-control-lg" required />
                  <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                    <i class="bi bi-eye"></i>
                  </span>
                </div>
              </div>


              <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" name="remember-me">
                  <label class="form-check-label" for="remember-me">Remember me</label>
                </div>
                <a href="<?php echo URLROOT; ?>/auth/forgotPassword" class="small text-primary-color">Forgot password?</a>
              </div>

              <button class="btn btn-custom btn-lg w-100 mb-3" type="submit">Login</button>

              <p class="text-center">
                Don't have an account?
                <a href="<?php echo URLROOT; ?>/auth/register" class="text-primary-color">Register</a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  // document.addEventListener('DOMContentLoaded', function() {
  //   const togglePassword = document.querySelector('#toggle-password');
  //   if (togglePassword) {
  //     togglePassword.addEventListener('click', function() {
  //       const passwordInput = document.getElementById('password');
  //       const icon = this.querySelector('i');

  //       if (passwordInput.type === 'password') {
  //         passwordInput.type = 'text';
  //         icon.classList.replace('bi-eye', 'bi-eye-slash');
  //       } else {
  //         passwordInput.type = 'password';
  //         icon.classList.replace('bi-eye-slash', 'bi-eye');
  //       }
  //     });
  //   }
  // });
</script>



<?php require_once APPROOT . '/views/inc/footer.php' ?>