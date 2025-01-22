<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h1>Ki</h1>
            <nav>
                <ul>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Account Settings</a>
                        <ul>
                            <li><a href="#">Change Password</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Complaint</a>
                        <ul>
                            <li><a href="#">Lodge Complaint</a></li>
                            <li><a href="#">Complaint History</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </nav>
            <div class="logo">
                <img src="logo.png" alt="Breyer Logo">
                <p>Your Premier TVET College</p>
            </div>
        </div>
        <div class="content">
            <div class="header">
                <h2>Dashboard</h2>
                <p>Tuesday, January 18th</p>
            </div>
            <div class="cards">
                <div class="card red">Complaints <br> <span>1</span></div>
                <div class="card green">Not Processed <br> <span>0</span></div>
                <div class="card blue">In Process <br> <span>1</span></div>
                <div class="card purple">Closed <br> <span>0</span></div>
            </div>
        </div>
    </div>
</body>
</html>
