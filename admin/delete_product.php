<?php
require_once('../includes/db.php');
require_once('../includes/functions.php');

// Ensure the user is logged in and is an admin
redirectIfNotLoggedIn();
if (!isAdmin()) {
    redirect('../index.php');
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    // Delete the product from the database
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute(['id' => $productId]);

    // Optionally, reset the AUTO_INCREMENT after deletion (if you want)
    // $pdo->exec("ALTER TABLE products AUTO_INCREMENT = 1");

    // Redirect back to the dashboard after deletion
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid product ID.";
}
?>
