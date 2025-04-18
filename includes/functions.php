<?php
// Start the session
session_start();

function redirect($url) {
    header("Location: $url");
    exit();
}

function setFlashMessage($message, $type = 'success') {
    $_SESSION['flash_message'] = ['message' => $message, 'type' => $type];
}

function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flash;
    }
    return null;
}

function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user'])) {
        redirect('login.php');
    }
}

function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin';
}
?>
