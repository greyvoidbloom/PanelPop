<?php
session_start();
require_once '../includes/functions.php';
require_once '../includes/db.php';
redirectIfNotLoggedIn();

if (isAdmin()) {
    header("Location: ../admin/dashboard.php");
    exit();
}

$products = $pdo->query("SELECT * FROM products")->fetchAll();
?>

<link rel="stylesheet" href="../assets/customer-styling.css">

<div class="dashboard-container">
    <h2 class="welcome-msg">Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</h2>

    <div class="top-bar">
        <h3 class="products-title">Available Products</h3>
        <div class="top-bar-buttons">
            <a href="cart.php" class="btn-cart">🛒 View My Cart</a>
            <a href="../logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <div class="product-grid">
        <?php foreach ($products as $p): ?>
            <div class="product-card">
                <a href="product.php?id=<?= $p['id'] ?>" class="product-link">
                    <img src="../uploads/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="product-image">
                    <p class="product-name"><?= htmlspecialchars($p['name']) ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
