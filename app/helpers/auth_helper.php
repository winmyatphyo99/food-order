<?php

// Check if a user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1);
}

function adminOnly()
{
    if (!isLoggedIn()) {
       
        header("Location: " . URLROOT . "/auth/login");
        exit;
    }

    if (!isAdmin()) {
        
        header("Location: " . URLROOT . "/pages/home");
        exit;
    }
}
