<?php
session_start();

function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user'])) {
        header("Location: /shopping_fing/login.php");
        exit();
    }
}

function redirectIfNotAdmin() {
    if ($_SESSION['user']['role'] !== 'admin') {
        header("Location: /shopping_fing/customer/dashboard.php");
        exit();
    }
}
