<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Redirect admin to the admin dashboard
if (!empty($user['is_admin']) && $user['is_admin']) {
    header("Location: admin_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('images/polumpong.img');
            background-size: cover;
            background-position: center;
            color: white;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            background-color: rgba(0, 0, 0, 0.6);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .navbar .nav-links {
            display: flex;
            gap: 15px;
            flex: 1;
            justify-content: center;
        }

        .navbar .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #00d9ff;
        }

        .navbar .logout {
            font-size: 16px;
            font-weight: 400;
            color: #ff4c4c;
            margin-left: 15px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .navbar .logout:hover {
            color: #ff1f1f;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100vh;
        }

        .container h1 {
            font-size: 4rem;
            font-weight: 700;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .container h2 {
            font-size: 2.5rem;
            font-weight: 400;
            margin-top: 20px;
        }

        .container p {
            font-size: 1.2rem;
            margin: 20px 0;
            max-width: 600px;
            line-height: 1.5;
        }

        .container .cta-button {
            padding: 15px 30px;
            background-color: #00d9ff;
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 30px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .container .cta-button:hover {
            background-color: #0098c9;
        }
		
footer {
	background-color: rgba(0, 0, 0, 0.6); /* Match the topnav background color */
	color: #fff;
	padding: 10px 30px;
	text-align: center;
	font-size: 18px;
	border: 2px solid rgba(255,255,255, .2);
	backdrop-filter: blur(20px);
	box-shadow: 0 0 10px rgba(0,0,0, .2);
	height: 60px; /* Fixed height for proper spacing */
}
    </style>
    <script>
        // Function to confirm logout
        function confirmLogout(event) {
            event.preventDefault();
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
</head>
<body>
    <div class="navbar">
        <div class="logo">Explore</div>
        <div class="nav-links">
            <a href="dashboard.php">Home</a>
			<a href="modules/services/serviceListing.php">Services</a>
            <a href="modules/faq/faq.php">FAQ</a>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="modules/profile_module/profile.php">My Profile</a>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="#" class="logout" onclick="confirmLogout(event)">Logout</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <h1>Welcome, <?= htmlspecialchars($user['username']) ?>!</h1>
        <h2>Your Dashboard</h2>
        <p>Explore the dream destination at Polumpong Melangkap View Campsite. You can manage your bookings and profile here.</p>
        <button class="cta-button" onclick="location.href='modules/services/serviceListing.php';">View More</button>
    </div>
	
	 <footer>
        <p class="footer" align="center"><small>&copy; Polumpung Sabah. All rights reserved</small></p>
    </footer>
</body>
</html>
