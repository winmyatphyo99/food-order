<?php

class Auth extends Controller
{
    private $db;

    public function __construct()
    {   
        $this->model('UserModel');
        $this->db = new Database();
    }

    public function index()
    {
        // Redirect to login page as default
        redirect('auth/login');
    }


    // ======================
    // REGISTER
    // ======================
public function register()
{
    // var_dump($_POST); exit;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $data = [
            'name' => '', 'email' => '', 'phone_number' => '',
            'password' => '', 'confirm_password' => '',
            'name_err' => '', 'email_err' => '', 'phone_number_err' => '',
            'password_err' => '', 'confirm_password_err' => ''
        ];
        $this->view('pages/register', $data);
        return;
    }

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    // --- RECAPTCHA VERIFICATION ADDED HERE ---
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
    $secret_key = '6Lco-rYrAAAAAI1SsR1ohlCod0jYkaGfLnahk7JP'; // REPLACE WITH YOUR SECRET KEY
    $verification_url = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($verification_url . '?secret=' . $secret_key . '&response=' . $recaptcha_response);
    $result = json_decode($response, true);

    if (!$result['success']) {
        setMessage('error', 'Please verify that you are not a robot.');
        redirect('auth/register');
        return;
    }
    // --- END OF RECAPTCHA VERIFICATION ---

    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone_number' => trim($_POST['phone_number'] ?? ''),
        'password' => trim($_POST['password'] ?? ''),
        'confirm_password' => trim($_POST['confirm_password'] ?? ''),
    ];

    // var_dump($data); 
    // Validate
    $validator = new UserValidator($data);
    $errors = $validator->validateForm();
    // echo "<pre>";
    // var_dump($errors);exit;
    
    // Hash password
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    // echo "<pre>";
    // var_dump($hashedPassword);exit;
    
    // Prepare user
    $user = [
        'name' => $data['name'],
        'email' => $data['email'],
        'phone_number' => $data['phone_number'],
        'password' => $hashedPassword,
        'profile_image' => 'default_profile.jpg',
        'role' => 0,
        'is_login' => 0,
        'is_active' => 1,
        'is_confirmed' => 0,
        'token' => bin2hex(random_bytes(50)),
        'date' => date('Y-m-d H:i:s')
    ];
    // echo "<pre>";
    // var_dump($user);exit;

    if ($this->db->create('users', $user)) {
        // Send verification email
        $mail = new Mail();
        $verifyLink = URLROOT . '/auth/verify/' . $user['token'];
        $mailSent = $mail->verifyMail($user['email'], $user['name'], $verifyLink);

        if ($mailSent) {
            setMessage('success', 'Account registered! Check your email to verify.');
        } else {
            setMessage('error', 'Account created, but email sending failed.');
        }

        redirect('auth/login');
    } else {
        setMessage('error', 'Something went wrong. Try again.');
        redirect('auth/register');
    }
}public function verify($token)
{
    // Check if token is provided
    if (empty($token)) {
        setMessage('error', 'Invalid verification link!');
        redirect('pages/register');
        return;
    }

    // Find user by token
    $user = $this->db->columnFilter('users', 'token', $token);

    if ($user && isset($user['id'])) {
        // Update user status and clear token
        $this->db->update('users', $user['id'], [
            'is_confirmed' => 1,
            'token' => null,
            'date' => date('Y-m-d H:i:s') // optional: track confirmation time
        ]);

        setMessage('success', '✅ Your account has been successfully verified! You can now log in.');
        redirect('pages/login');
    } else {
        // Invalid or expired token
        setMessage('error', '❌ Invalid or expired verification link. Please register again!');
        redirect('pages/register');
    }
}



    // ======================
    // LOGIN
    // ======================
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->db->columnFilter('users', 'email', $email);

            if (!$user) {
                setMessage('error', 'No user found with that email!');
                redirect('auth/login');
                exit;
            }

            if (!password_verify($password, $user['password'])) {
                setMessage('error', 'Incorrect password!');
                redirect('auth/login');
                exit;
            }

            if ($user['is_confirmed'] == 0) {
                setMessage('error', 'Your account has not been verified. Please check your email.');
                redirect('auth/login');
                exit;
            }

            //  Create session
            $this->createUserSession($user);

            // Redirect by role
            if ($user['role'] == 1) {
                setMessage('success', 'Login successful! Welcome to the admin dashboard.');
                redirect('AdminController/dashboard');
                // echo "<pre>";
                // var_dump($user['role']);
                exit;

            } else {
                setMessage('success', 'Login successful! Welcome.');
                redirect('pages/home');
                exit;
            }

        } else {
           
            $this->view('pages/login', []);
        }
    }

    // ======================
    // FORGOT PASSWORD
    // ======================
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            // Find user by email
            $user = $this->db->columnFilter('users', 'email', $email);
            

            if ($user) {
               
                // Generate and store a new password reset token
                $resetToken = bin2hex(random_bytes(50));
                 
                $tokenExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                $this->db->update('users', $user['id'], [
                    'reset_token' => $resetToken,
                    'reset_token_expiry' => $tokenExpiry
                ]);
                 

                // Send password reset email
                $mail = new Mail();
                $resetLink = URLROOT . '/auth/resetPassword/' . $resetToken;
                
                $mailSent = $mail->resetPasswordMail($user['email'], $user['name'], $resetLink);
              


                if ($mailSent) {
                    echo "<pre>";
                    var_dump($mailSent);
                    setMessage('success', 'A password reset link has been sent to your email.');
                } else {
                    setMessage('error', 'Could not send the password reset email. Please try again later.');
                }
            } else {
                setMessage('error', 'No user found with that email address.');
            }

            redirect('auth/forgotPassword');
        } else {
            $this->view('pages/forgot_password');
        }
    }

    // ======================
    // RESET PASSWORD
    // ======================
    public function resetPassword($token)
    
    {
        // Check if a token is provided
        if (empty($token)) {
            setMessage('error', 'Invalid password reset link!');
            redirect('auth/login');
            return;
        }

        // Find user by reset token and check expiry
        $user = $this->db->columnFilter('users', 'reset_token', $token);
        
       

        if (!$user || strtotime($user['reset_token_expiry']) < time()) {
            setMessage('error', 'Invalid or expired password reset link. Please try again.');
            redirect('auth/forgotPassword');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = trim($_POST['password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');

            // Validate new password
            if (empty($newPassword) || strlen($newPassword) < 6) {
                setMessage('error', 'Password must be at least 6 characters.');
                redirect('auth/resetPassword/' . $token);
                return;
            }
            if ($newPassword !== $confirmPassword) {
                setMessage('error', 'Passwords do not match.');
                redirect('auth/resetPassword/' . $token);
                return;
            }

            // Hash the new password and update the user
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->db->update('users', $user['id'], [
                'password' => $hashedPassword,
                'is_confirmed' => 1,
                'reset_token' => null,
                'reset_token_expiry' => null
            ]);

            setMessage('success', 'Your password has been successfully reset. You can now log in with your new password.');
            redirect('auth/login');
        } else {
            // Show the reset password form
            $data = ['token' => $token];
            $this->view('pages/reset_password', $data);
        }
    }


    // ======================
    // Helper: create user session
    // ======================
    private function createUserSession($user)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role']  = $user['role'];
        
    }





    

    // ======================
    // LOGOUT
    // ======================
    public function logout()
    {
        session_unset();
        session_destroy();
        setMessage('success', 'You have been logged out.');
        redirect('auth/login');
        exit;
    }
}
