<?php
// File: login.php (shared login page for both admin and customer)
require_once('includes/db.php');
require_once('includes/functions.php');
session_start();

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header('Location: admin/dashboard.php');
        exit;
    } else {
        header('Location: customer/dashboard.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;

        if ($user['role'] === 'admin') {
            header('Location: admin/dashboard.php');
            exit;
        } else {
            header('Location: customer/dashboard.php');
            exit;
        }
    } else {
        $_SESSION['flash'] = ['message' => 'Invalid username or password', 'type' => 'error'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PanelPop-Login</title>
    <link rel="stylesheet" href="assets/login-style.css">
</head>
<body>
    <div class="logo-banner">
        <img src="assets/logo.png" alt="Logo" class="logo-img">
        <span class="logo-text">PanelPop</span>
    </div>
    <div class="login-container">
        <h2>Login</h2>
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

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
