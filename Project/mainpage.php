<?php
include 'config/config.php'; // Includes database connection

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch reviews from the `reviews` table
$query = "SELECT * FROM reviews ORDER BY created_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Polumpong</title>
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
            padding: 2px 30px;
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
            gap: 10px;
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

        .navbar .login-icon {
            font-size: 32px;
            color: white;
            transition: color 0.3s ease;
        }

        .navbar .login-icon:hover {
            color: #00d9ff;
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

        .reviews {
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
        }

        .review {
            margin-bottom: 20px;
            padding: 15px;
            border-bottom: 1px solid #fff;
        }

        .review h3 {
            font-size: 1.2rem;
            color: #00d9ff;
        }

        .review p {
            font-size: 1rem;
            line-height: 1.5;
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
</head>
<body>
    <div class="navbar">
        <div class="logo">Explore</div>
        <div class="nav-links">
            <a href="mainpage.php">Home</a>
            <a href="modules/services/serviceListing.php">Services</a>
            <a href="modules/faq/faq.php">FAQ</a>
        </div>
        <a href="login.php" class="login-icon">&#128100;</a>
    </div>

    <div class="container">
        <h1>Explore Dream Destination</h1>
        <h2>Polumpong Melangkap View Campsite</h2>
        <p>Polumpung Melangkap View Campsite, located in Kota Belud, Sabah, is a family-friendly campsite with a spectacular view of the majestic Mount Kinabalu. Set against a New Zealand-ish backdrop, it features an elegant river and an exquisite landscape. Here, campers can also enjoy the breathtaking view of a million stars at night.</p>
        <button class="cta-button" onclick="location.href='modules/services/serviceListing.php';">View More</button>
    </div>

    <!-- Reviews Section -->
    <div class="reviews">
    <h2 style="text-align: center; font-size: 2rem; margin-bottom: 20px; color: #00d9ff;">User Reviews</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='review'>";
            echo "<div class='review-header'>";
            echo "<h3>" . htmlspecialchars($row['username']) . "</h3>"; // Display username
            echo "<p class='review-date'><em>Posted on: " . htmlspecialchars(date("F j, Y", strtotime($row['created_at']))) . "</em></p>"; // Display formatted created_at
            echo "</div>";
            echo "<p class='review-text'>" . htmlspecialchars($row['review_text']) . "</p>"; // Display review text
            echo "<p class='review-rating'><strong>Rating:</strong> " . str_repeat("⭐", (int)$row['rating']) . " (" . htmlspecialchars($row['rating']) . "/5)</p>"; // Display star rating
            echo "</div>";
        }
    } else {
        echo "<p style='text-align: center; font-size: 1.2rem;'>No reviews yet. Be the first to leave a review!</p>";
    }
    ?>
</div>
<footer>
        <p class="footer" align="center"><small>&copy; Polumpung Sabah. All rights reserved</small></p>
    </footer>
</body>
</html>