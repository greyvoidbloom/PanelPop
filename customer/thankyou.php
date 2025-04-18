<?php
session_start();
require_once '../includes/functions.php';
redirectIfNotLoggedIn();

$latestOrder = $_SESSION['latest_order'] ?? [];

if (!$latestOrder) {
    header('Location: dashboard.php');
    exit;
}
?>

<link rel="stylesheet" href="../assets/customer-styling.css">

<div class="receipt-container">
    <h2>🧾 Thank You for Your Purchase!</h2>
    <p>Your order has been confirmed. Here’s your receipt:</p>

    <div class="receipt">
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($latestOrder as $item): ?>
                    <?php $subtotal = $item['price'] * $item['quantity']; ?>
                    <?php $total += $subtotal; ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>₹<?= number_format($item['price'], 2) ?></td>
                        <td>₹<?= number_format($subtotal, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
                    <td><strong>₹<?= number_format($total, 2) ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="thankyou-msg">
        <p>✨ We hope to see you again soon!</p>
    </div>

    <a href="dashboard.php" class="btn">⬅ Return to Dashboard</a>
</div>
