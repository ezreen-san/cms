<?php
session_start();
include 'db.php'; // Include database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$status_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reference_id = $_POST['reference_id'];

    $stmt = $conn->prepare("SELECT * FROM complaints WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $reference_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $complaint = $result->fetch_assoc();

    if ($complaint) {
        $status_message = "Status of your complaint (ID: $reference_id): " . $complaint['status'];
    } else {
        $status_message = "No complaint found with that reference ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Complaint Status</title>
</head>
<body>
    <h2>Check Complaint Status</h2>
    <form method="POST">
        <input type="number" name="reference_id" placeholder="Enter Complaint ID" required>
        <button type="submit">Check Status</button>
    </form>
    <?php if ($status_message): ?>
        <p><?php echo $status_message; ?></p>
    <?php endif; ?>
</body>
</html>