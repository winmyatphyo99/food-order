
//    Login Form
   
//    const togglePassword = document.getElementById('toggle-password');
//     const passwordInput = document.getElementById('pass');

//     togglePassword.addEventListener('click', () => {
//         if (passwordInput.type === "password") {
//             passwordInput.type = "text";
//             togglePassword.style.color = '#007bff';
//         } else {
//             passwordInput.type = "password";
//             togglePassword.style.color = '#888';
//         }
//     });

//    Login Form
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





   
