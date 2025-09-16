<?php
require_once APPROOT . '/repositories/CartRepository.php';

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

    // In AuthController.php
    public function home()
    {
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
                'name' => '',
                'email' => '',
                'phone_number' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'phone_number_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
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
    }
    public function verify($token)
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

            $this->mergeGuestCart($user);
            $redirectUrl = $_SESSION['redirect_to'] ?? null;
            unset($_SESSION['redirect_to']); // clear after use


            if ($redirectUrl) {
                redirect($redirectUrl);
                exit;
            }


            // Redirect by role
            if ($user['role'] == 1) {
                setMessage('success', 'Login successful! Welcome to the admin dashboard.');
                redirect('AdminController/dashboard');
                // echo "<pre>";
                // var_dump($user['role']);
                exit;
            } else {
                setMessage('success', 'Login successful! Welcome.');
                redirect('CustomerController/dashboard');
                exit;
            }
        } else {

            $this->view('pages/login', []);
        }
    }



    private function mergeGuestCart($user)
    {
        if (!isset($_SESSION['guest_cart'])) return;

        $cartRepo = new CartRepository($this->db);
        $existingItems = $cartRepo->getUserCart($user['id']);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        foreach ($_SESSION['guest_cart'] as $productId => $item) {
            $found = false;

            // Merge into database
            foreach ($existingItems as $cartItem) {
                if ($cartItem['product_id'] == $productId) {
                    $newQty = $cartItem['quantity'] + $item['quantity'];
                    $cartRepo->updateCartItem($user['id'], $productId, $newQty);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $cartRepo->addCartItem($user['id'], $productId, $item['quantity'], $item['price']);
            }

            // Merge into session
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] += $item['quantity'];
            } else {
                $_SESSION['cart'][$productId] = $item;
            }
        }

        unset($_SESSION['guest_cart']); // remove guest cart
    }




    private function createUserSession($user)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_phone_number'] = $user['phone_number'];
        $_SESSION['user_role']  = $user['role'];
        $_SESSION['profile_image'] = $user['profile_image'] ?? null;
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
    // LOGOUT
    // ======================
    public function logout()
    {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        setMessage('success', 'You have been logged out.');
        redirect('auth/login');
        exit;
    }
}
