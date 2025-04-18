<?php
session_start();
require_once '../includes/functions.php';
require_once '../includes/db.php';
redirectIfNotLoggedIn();

$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: dashboard.php');
    exit;
}
?>

<link rel="stylesheet" href="../assets/customer-styling.css">
<div class="product-detail-container">
    <div class="product-image-section">
        <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="detail-image">
    </div>

    <div class="product-info-section">
        <h2 class="detail-name"><?= htmlspecialchars($product['name']) ?></h2>
        <p class="detail-price">Price: ₹<?= number_format($product['price'], 2) ?></p>

        <div class="product-actions">
            <!-- Add to Cart -->
            <form method="POST" action="cart.php" class="action-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="action" value="add">
                <button type="submit" class="btn-action">Add to Cart</button>
            </form>

            <!-- Buy Now -->
            <form method="POST" action="checkout.php" class="action-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit" class="btn-action">Buy Now</button>
            </form>
        </div>

        <a href="dashboard.php" class="btn-back">⬅ Back to Products</a>
    </div>
</div>
