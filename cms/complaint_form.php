<?php
session_start();
include 'db.php'; // Include database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $complaint_text = $_POST['complaint_text'];

    $stmt = $conn->prepare("INSERT INTO complaints (user_id, complaint_text) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $complaint_text);
    if ($stmt->execute()) {
        echo "Complaint submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complaint Form</title>
</head>
<body>
    <h2>Submit a Complaint</h2>
    <form method="POST">
        <textarea name="complaint_text" placeholder="Describe your complaint" required></textarea>
        <button type="submit">Submit Complaint</button>
    </form>
</body>
</html>