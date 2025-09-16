<?php

class RatingController extends Controller {

    private $ratingRepository;

    public function __construct() {
        $this->ratingRepository = $this->repository('RatingRepository');
    }

    // public function submit() {
    //     // Only process if the request is a POST
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           
            
    //         // Sanitize and trim the POST data
    //         $data = [
    //             'product_id' => filter_var(trim($_POST['product_id']), FILTER_SANITIZE_NUMBER_INT),
    //             'rating' => filter_var(trim($_POST['rating']), FILTER_SANITIZE_NUMBER_INT),
    //             // Get the user ID from the session; assume the user is logged in
    //             'user_id' => $_SESSION['user_id']
    //         ];

            
    //         // Basic validation
    //         if (empty($data['product_id']) || empty($data['rating']) || $data['rating'] < 1 || $data['rating'] > 5) {
    //             flash('rating_error', 'Invalid rating data.', 'alert-danger');
    //             redirect('pages/menu');
    //         }

    //         // Check if the user has already rated this product
    //         if ($this->ratingRepository->hasUserRatedProduct($data['user_id'], $data['product_id'])) {
                
    //             flash('rating_error', 'You have already rated this product.', 'alert-danger');
    //             redirect('pages/menu');
    //         }

    //         // Attempt to add the rating to the database
    //         if ($this->ratingRepository->addRating($data)) {
            

    //             flash('rating_success', 'Thank you for your rating!', 'alert-success');
    //             redirect('pages/menu');
    //         } else {
    //             flash('rating_error', 'Something went wrong. Please try again.', 'alert-danger');
    //             redirect('pages/menu');
    //         }
            
    //     } else {
    //         // Redirect if the request method is not POST
    //         redirect('pages/menu');
    //     }
    // }

    public function submit() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect('pages/menu');
    }

    // ensure session started somewhere in bootstrap; but check here too
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (empty($_SESSION['user_id'])) {
        flash('rating_error', 'Please login to rate this product.', 'alert-danger');
        redirect('auth/login'); 
    }

    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $rating     = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $comment    = trim($_POST['comment'] ?? '');
    // limit comment length
    $comment    = mb_substr($comment, 0, 500);

    $data = [
        'product_id' => $product_id,
        'rating'     => $rating,
        'comment'    => $comment,
        'user_id'    => $_SESSION['user_id']
    ];

    if (!$this->validateRatingData($data)) {
        redirect('pages/menu');
    }

    // If user already rated -> update; otherwise insert
    if ($this->ratingRepository->hasUserRatedProduct($data['user_id'], $data['product_id'])) {
        if ($this->ratingRepository->updateRating($data)) {
            flash('rating_success', 'Your rating has been updated.', 'alert-success');
        } else {
            flash('rating_error', 'Unable to update your rating. Please try again.', 'alert-danger');
        }
    } else {
        if ($this->ratingRepository->addRating($data)) {
            flash('rating_success', 'Thank you for your rating!', 'alert-success');
        } else {
            // If DB duplicate error happens (race condition), you can try update fallback
            flash('rating_error', 'Something went wrong. Please try again.', 'alert-danger');
        }
    }

    redirect('pages/menu');
}

private function validateRatingData($data) {
    if (empty($data['product_id']) || !is_int($data['product_id']) || $data['product_id'] <= 0) {
        flash('rating_error', 'Invalid product.', 'alert-danger');
        return false;
    }

    if (!is_int($data['rating']) || $data['rating'] < 1 || $data['rating'] > 5) {
        flash('rating_error', 'Invalid rating value. Please choose 1-5 stars.', 'alert-danger');
        return false;
    }

    // comment optional, but if present limit length
    if (!empty($data['comment']) && mb_strlen($data['comment']) > 500) {
        flash('rating_error', 'Comment is too long (max 500 characters).', 'alert-danger');
        return false;
    }

    return true;
}

}