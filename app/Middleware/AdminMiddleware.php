<?php
require_once APPROOT . '/libraries/Middleware.php';

class AdminMiddleware extends Middleware {
    public function handle() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            setMessage('error', 'Please login first!');
            redirect('auth/login');
            exit;
        }

        if ($_SESSION['user_role'] != 1) { // 1 = admin
            setMessage('error', 'Access denied! Admins only.');
            redirect('pages/home');
            exit;
        }
    }
}
