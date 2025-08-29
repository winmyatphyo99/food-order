<?php
require_once APPROOT . '/libraries/Middleware.php';

class GuestMiddleware extends Middleware {
    public function handle() {
        // Only redirect if user is logged in
        if (isset($_SESSION['user_id'])) {
            redirect('pages/home'); // safer than header()
            exit;
        }
    }
}

