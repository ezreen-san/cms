<?php
require '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);
        $success_message = "User Registered Successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
    <div class="container">
        <img src="assets/img/logo.png" alt="Logo" class="logo">
        <div class="registration-box">
            <h2>Student Registration</h2>
            <form action="" method="POST" class="registration-form">
            <?php if (!empty($success_message)): ?>
                    <p class="succmsg"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
                <input type="text" placeholder="Username" name="username" class="firstinput" required>
                <input type="email" placeholder="Email Address" name="email" required>
                <input type="password" placeholder="Password" name="password" required>
                <input type="password" placeholder="Confirm Password" name="confirm_password" required>
                <button type="submit">Register</button>
            </form>
            <hr>
            <p class="existing">Already Registered?</p>
            <a href="index.php">Sign in</a>
        </div>
    </div>

</body>
</html>
