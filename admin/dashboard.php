<?php
require_once('../includes/db.php');
require_once('../includes/functions.php');

// Ensure the user is logged in and is an admin
redirectIfNotLoggedIn();
if (!isAdmin()) {
    redirect('../index.php');
}

// Fetch existing products from the database
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();
?>
<link rel="stylesheet" href="../assets/admindash.css">

<div class="container">
    <h1 class="main-heading">Admin Dashboard</h1>
    <!-- Status Message for Add/Edit/Delete actions -->
    <div id="statusMessage"></div>

    <!-- Add Product Form -->
    <h2 class="sub-heading">Add Product</h2>
    <form id="addProductForm" enctype="multipart/form-data">
        <input type="text" name="name" id="name" placeholder="Product Name" required>
        <textarea name="description" id="description" placeholder="Product Description" required></textarea>
        <input type="text" name="price" id="price" placeholder="Product Price" required>
        <input type="file" name="image" id="image" required>
        <button type="submit">Add Product</button>
    </form>

    <!-- View and Edit Products -->
    <h2>View & Edit Products</h2>
<table id="productList">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr data-id="<?= $product['id'] ?>">
                <td><?= $product['id'] ?></td>
                <td class="product-name"><?= htmlspecialchars($product['name']) ?></td>
                <td class="product-description"><?= htmlspecialchars($product['description']) ?></td>
                <td class="product-price"><?= htmlspecialchars($product['price']) ?></td>
                <td><img src="../uploads/<?= htmlspecialchars($product['image']) ?>" width="50"></td>
                <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn red-btn">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Styled logout button -->
<a href="../logout.php" class="logout-btn red-btn">Logout</a>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../assets/admin-dash.js"></script>
