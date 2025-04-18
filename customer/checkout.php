<?php
session_start();
require_once '../includes/functions.php';
require_once '../includes/db.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? null;
    if ($product_id) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if ($product) {
            $_SESSION['latest_order'] = [[
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ]];

            // DO NOT clear the entire cart
            // Only remove if you want to — optional
            // unset($_SESSION['cart'][$product_id]);

            header('Location: thankyou.php');
            exit;
        }
    }
}

header('Location: dashboard.php');
exit;
