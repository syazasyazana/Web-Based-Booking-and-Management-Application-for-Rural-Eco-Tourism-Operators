<?php
// Include the config file
include("../../config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <style>
        /* General Styles */
        html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            background-color: #333;
            color: white;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
			position: relative;
            left: -550px; /* Move it 10px to the left */
        }

        .navbar a:hover {
            color: #00d9ff;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }
		
		.navbar .login-icon {
    font-size: 32px;
    color: white;
    transition: color 0.3s ease;
    position: relative;
    left: -45px; /* Move it 10px to the left */
}



    .navbar .login-icon:hover {
        color: #00d9ff;
    }
	
	
		


        /* Main Content */
        .service-category {
            margin: 80px 20px;
            text-align: center;
			flex:1;
        }

        .service-category h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .service-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .service-card {
            width: 250px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px;
            text-align: center;
        }

        .service-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .service-card h3 {
            margin-top: 10px;
            font-size: 18px;
            color: #333;
        }

        .book-button-container {
            margin-top: 20px;
        }

        .book-button-container a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border-radius: 5px;
        }

        .book-button-container a:hover {
            background-color: #555;
        }
footer {
    background-color: rgba(0, 0, 0, 0.6); /* Match the topnav background color */
    color: #fff;
    padding: 10px 30px;
    text-align: center;
    font-size: 18px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(20px);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    height: 60px;
    position: relative; /* Removed fixed or absolute positioning */
}
    </style>
</head>
<body>
    <?php
// Start the session at the very top of your PHP script
session_start();
?>

<div class="navbar">
    <div class="logo">Explore</div>
    <div>
        <!-- Set Home link dynamically based on session -->
        <a href="<?php echo isset($_SESSION['user']) ? '../../dashboard.php' : '../../mainpage.php'; ?>">Home</a>
        <a href="serviceListing.php">Services</a>
        <a href="../faq/faq.php">FAQ</a>
        <?php if (isset($_SESSION['user'])): ?>
        <a href="../profile_module/profile.php">My Profile</a>
        <?php endif; ?>
		</div>
		
		</div>
        <a href="login.php" class="login-icon">&#128100;</a>
        </div>
		
		<?php if (isset($_SESSION['user'])): ?>
        <a href="../../logout.php" class="logout" onclick="confirmLogout(event)">Logout</a>
        <?php endif; ?>
    </div>
</div>


    <div class="service-category">
        <h2>Our Services</h2>
        <div class="service-container">
            <?php
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=polumpong", "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->prepare("SELECT * FROM services");
                $stmt->execute();
                $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($services as $service): ?>
                    <div class="service-card">
                        <img src="../../images/<?php echo htmlspecialchars($service['image']); ?>" 
                             alt="<?php echo htmlspecialchars($service['name']); ?>">
                        <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                        <p><?php echo htmlspecialchars($service['description']); ?></p>
                        <p><strong>Price: $<?php echo htmlspecialchars($service['price']); ?></strong></p>
                    </div>
                <?php endforeach;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div>
        <div class="book-button-container">
            <a href="../../bookingForm.php">Book Now</a>
        </div>
    </div>

 <footer>
        <p class="footer" align="center"><small>&copy; Polumpung Sabah. All rights reserved</small></p>
    </footer>
</body>
</html>
