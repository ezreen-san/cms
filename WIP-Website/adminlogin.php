<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        echo "Admin login successful!";
        // Redirect to admin dashboard
    } else {
        echo "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
    <div>
<a href="index.html" class="back-link">← Back to Homepage</a>
</div>
    <div class="container">
        
        <div class="logo">
            <img src="logo.png" alt="Breyer Logo">
            <h1>Kolej Breyer Gombak</h1>
            <p>Your Premier TVET College</p>
        </div>
        <div class="login-box">
            <h2>Admin Login</h2>
            <form action="dashboard.php" method="post">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
