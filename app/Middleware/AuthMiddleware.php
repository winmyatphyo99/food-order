<?php
require_once APPROOT . '/libraries/Middleware.php';

class AuthMiddleware extends Middleware
{
    public function handle()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            setMessage('error', 'Please login first!');
            redirect('auth/login');
            exit;
        }
    }
}
