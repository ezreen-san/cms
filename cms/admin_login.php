<?php
session_start();
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Assuming admin username is 'admin' and password is 'admin123'
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php");
    } else {
        echo "Invalid admin credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Admin Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>