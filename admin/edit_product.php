<?php
require_once('../includes/db.php');
require_once('../includes/functions.php');

// Ensure the user is logged in and is an admin
redirectIfNotLoggedIn();
if (!isAdmin()) {
    redirect('../index.php');
}

// Check if the 'id' parameter is set and valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$productId = $_GET['id'];

// Fetch product details
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $productId]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}

// Handle form submission for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Check if an image file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imagePath = '../uploads/' . basename($image['name']);
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            die("Failed to upload image.");
        }
    } else {
        $imagePath = $product['image']; // Use the existing image if no new one was uploaded
    }

    // Update the product
    $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price, image = :image WHERE id = :id");
    $stmt->execute([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'image' => basename($imagePath),
        'id' => $productId
    ]);

    // Redirect back to the dashboard after a successful update
    header("Location: dashboard.php");
    exit();
}
?>
<link rel="stylesheet" href="../assets/admindash.css">
<!-- Edit Product Form -->
<div class="container">
    <h1>Edit Product</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= $product['name'] ?>" placeholder="Product Name" required>
        <textarea name="description" placeholder="Product Description" required><?= $product['description'] ?></textarea>
        <input type="text" name="price" value="<?= $product['price'] ?>" placeholder="Product Price" required>
        <input type="file" name="image">
        <button type="submit">Update Product</button>
    </form>
</div>
