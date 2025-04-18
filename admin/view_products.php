<?php
require_once('../includes/db.php');
require_once('../includes/functions.php');

// Ensure the user is logged in and is an admin
redirectIfNotLoggedIn();
if (!isAdmin()) {
    redirect('../index.php'); // Non-admin users should not access the admin panel
}

$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();
?>

    <table border="1" cellspacing="0" cellpadding="10">
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['description']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td><img src="../uploads/<?php echo $product['image']; ?>" alt="Product Image" width="50"></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="edit-btn">Edit</a> | 
                    <a href="delete_product.php?id=<?php echo $product['id']; ?>"class="delete-btn red-btn">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

