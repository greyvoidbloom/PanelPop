<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: customer/dashboard.php");
    }
    exit();
} else {
    header("Location: login.php");
    exit();
}
