<?php
session_start();
include 'db.php'; // Include database connection

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$result = $conn->query("SELECT * FROM complaints");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Complaint Manager</h2>
    <table>
        <tr>
            <th>Complaint ID</th>
            <th>User ID</th>
            <th>Complaint Text</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['complaint_text']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <form method="POST" action="resolve_complaint.php">
                    <input type="hidden" name="complaint_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Resolve</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>