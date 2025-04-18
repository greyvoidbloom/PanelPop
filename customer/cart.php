<?php
session_start();
require_once '../includes/functions.php';
require_once '../includes/db.php';
redirectIfNotLoggedIn();

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? null;
    $action = $_POST['action'] ?? '';

    if ($product_id && $action === 'add') {
        $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + 1;
    } elseif ($product_id && $action === 'remove') {
        unset($_SESSION['cart'][$product_id]);
    } elseif ($product_id && $action === 'update') {
        $qty = max(1, (int)$_POST['quantity']);
        $_SESSION['cart'][$product_id] = $qty;
    } elseif ($action === 'clear') {
        $_SESSION['cart'] = [];
    } elseif ($action === 'checkout') {
        $ids = array_keys($_SESSION['cart']);
        if ($ids) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $products = $stmt->fetchAll();

            $latestOrder = [];
            foreach ($products as $product) {
                $latestOrder[] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $_SESSION['cart'][$product['id']]
                ];
            }

            $_SESSION['latest_order'] = $latestOrder;
            $_SESSION['cart'] = [];
            header('Location: thankyou.php');
            exit;
        }
    }
}

$ids = array_keys($_SESSION['cart']);
$products = [];
if ($ids) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();
}
?>

<link rel="stylesheet" href="../assets/customer-styling.css">

<div class="cart-container">
    <h2 class="cart-title">🛍️ Your Cart</h2>

    <?php if (empty($products)): ?>
        <p class="empty-msg">Your cart is empty. 🍃</p>
    <?php else: ?>
        <div class="cart-items">
            <?php $total = 0; ?>
            <?php foreach ($products as $product): ?>
                <?php
                    $quantity = $_SESSION['cart'][$product['id']];
                    $subtotal = $product['price'] * $quantity;
                    $total += $subtotal;
                ?>
                <div class="cart-item">
                    <div class="cart-item-info">
                        <strong class="item-name"><?= htmlspecialchars($product['name']) ?></strong>
                        <p class="item-price">₹<?= number_format($product['price'], 2) ?> × <?= $quantity ?> = ₹<?= number_format($subtotal, 2) ?></p>
                    </div>

                    <div class="cart-item-actions">
                        <!-- Update quantity -->
                        <form method="POST" class="inline-form">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="number" name="quantity" min="1" value="<?= $quantity ?>" class="qty-input">
                            <input type="hidden" name="action" value="update">
                            <button type="submit" class="btn-action">Update</button>
                        </form>

                        <!-- Remove item -->
                        <form method="POST" class="inline-form">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="btn-remove">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-total">
            <h3>Total: ₹<?= number_format($total, 2) ?></h3>
        </div>

        <div class="cart-buttons">
            <form method="POST" class="inline-form">
                <input type="hidden" name="action" value="checkout">
                <button type="submit" class="btn-checkout">✅ Checkout</button>
            </form>

            <form method="POST" class="inline-form">
                <input type="hidden" name="action" value="clear">
                <button type="submit" class="btn-clear">🧹 Clear Cart</button>
            </form>
        </div>
    <?php endif; ?>

    <a href="dashboard.php" class="btn-back">⬅ Back to Dashboard</a>
</div>
