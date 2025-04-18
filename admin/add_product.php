<?php
require_once('../includes/db.php');
require_once('../includes/functions.php');

// Ensure the user is logged in and is an admin
redirectIfNotLoggedIn();
if (!isAdmin()) {
    redirect('../index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    // Check if the image is uploaded correctly
    if ($image['error'] !== UPLOAD_ERR_OK) {
        echo "Failed to upload image.";
        exit;
    }

    // Define the target upload directory
    $targetDir = '../uploads/';
    // Define the target file path
    $targetFile = $targetDir . basename($image['name']);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        // Prepare the SQL query to insert the product
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $image['name']]);
        echo "Product added successfully!";
    } else {
        echo "Failed to upload image.";
    }
}
?>

<form action="add_product.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required>
    <textarea name="description" placeholder="Product Description" required></textarea>
    <input type="text" name="price" placeholder="Product Price" required>
    <input type="file" name="image" required>
    <button type="submit">Add Product</button>
</form>

<a href="dashboard.php">Back to Dashboard</a>
