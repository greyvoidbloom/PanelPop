<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
        $stmt->execute([$username, $password]);
        redirect('login.php');
    } catch (PDOException $e) {
        $error = "Username already taken.";
    }
}
?>
<link rel="stylesheet" href="/shopping_fing/assets/register-style.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PanelPop-Register</title>
    <link rel="stylesheet" href="assets/login-style.css">
</head>
<body>
    <div class="logo-banner">
        <img src="assets/logo.png" alt="Logo" class="logo-img">
        <span class="logo-text">PanelPop</span>
    </div>  
    <div class="login-container">
        <h2>Register</h2>
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message <?php echo $_SESSION['flash']['type']; ?>">
                <?php echo $_SESSION['flash']['message']; ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <form method="post">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
