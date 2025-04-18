<?php
session_start();

// Check for authenticated user
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Get user details for display
$username = $_SESSION['username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | SCMS Breyer Gombak</title>
  <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
  <div class="sidebar">
    <div class="user-profile">
      <img src="https://via.placeholder.com/40" alt="User Profile">
      <span><?php echo htmlspecialchars($username); ?></span>
    </div>
    <div class="menu">
      <!-- New Dashboard button -->
      <div class="menu-item">
        <p>☰</p> <span>Dashboard</span>
      </div>
      <div class="menu-item">
        <p>⚙</p> <span>Account Settings</span>
      </div>
      <a href="../includes/logout.php"> <!-- Changed from ../index.html -->
      <div class="logout">
        <p>⏻</p> <span>Logout</span>
      </div>
      </a>
    </div>
    <!-- Logo section at the bottom -->
    <div class="logo">
      <img src="../assets/img/logo.png" alt="Logo">
    </div>
  </div>
  
  <div class="content">
    <div class="header">
      <h1>Dashboard</h1>
      <div id="date"></div>
    </div>
    <div class="center-container">
      <div class="cards">
        <div class="card red">Complaints <br> <span id="complaints-count">Loading...</span></div>
        <div class="card green">Not Processed <br> <span id="notProcessed-count">Loading...</span></div>
        <div class="card blue">In Process <br> <span id="inProcess-count">Loading...</span></div>
        <div class="card purple">Closed <br> <span id="closed-count">Loading...</span></div>
      </div>
      <div class="action-buttons">
        <button class="action-button" onclick="lodgeComplaint()">Lodge a Complaint</button>
        <button class="action-button" onclick="viewComplaintStatus()">View Complaint Status</button>
      </div>
    </div>
  </div>
  <script src="assets/script/dashboardscript.js"></script> 
</body>
</html>
