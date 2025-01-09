<?php
session_start();
include 'db.php'; // Include database connection

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complaint_id = $_POST['complaint_id'];

    $stmt = $conn->prepare("UPDATE complaints SET status = 'resolved' WHERE id = ?");
    $stmt->bind_param("i", $complaint_id);
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error resolving complaint: " . $stmt->error;
    }
}
?>