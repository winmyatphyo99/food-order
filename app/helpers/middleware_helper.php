<?php
function redirect($path) {
    header("Location: " . URLROOT . '/' . $path);
    exit;
}

function setMessage($key, $message) {
    $_SESSION[$key] = $message;
}
