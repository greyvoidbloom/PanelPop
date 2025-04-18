<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    echo "Hashed: " . $hash;
}
?>

<form method="POST">
    <input type="text" name="password" placeholder="Password">
    <button type="submit">Generate Hash</button>
</form>
