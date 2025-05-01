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
    <title>Payment Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/newstyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* Navbar styling*/
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            background-color: rgba(0, 0, 0, 0.6);
            position: fixed; /* Ensures the navbar stays fixed at the top */
            width: 100%; /* Full width for consistency */
            top: 0; /* Aligns the navbar to the top */
            z-index: 1000; /* Ensures it stays above other elements */
            height: 60px; /* Fixed height for proper spacing */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional: subtle shadow for better visibility */
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            color: white;
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
    </style>
</head>

<body class="payment-form-body">
<div class="navbar">
        <div class="logo">Explore</div>
        <div class="nav-links">
            <a href="mainpage.php">Home</a>
            <a href="modules/services/serviceListing.php">Services</a>
            <a href="modules/faq/faq.php">FAQ</a>
           
        </div>
        <a href="login.php" class="login-icon">&#128100;</a>
    </div>
    <div class="form-container">
<?php
    // Include db config
    include("config/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and retrieve inputs
        $name = htmlspecialchars($_POST['name']);
        $orderDate = htmlspecialchars($_POST['orderDate']);
        $companyName = htmlspecialchars($_POST['companyName']);
        $address = htmlspecialchars($_POST['address']);
        $postalCode = htmlspecialchars($_POST['postalCode']);
        $email = htmlspecialchars($_POST['email']);
        $branch = htmlspecialchars($_POST['branch']);
        
        // Insert the payments data into the database
        $sql = "INSERT INTO payments (name, orderDate, companyName, address, postalCode, email, branch) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $orderDate, $companyName, $address, $postalCode, $email, $branch);

            if (mysqli_stmt_execute($stmt)) {
                echo "<h1>INVOICE</h1>";
                echo "<p><strong>Name:</strong> $name</p>";
                echo "<p><strong>Order Date:</strong> $orderDate</p>";
                echo "<p><strong>Company Name:</strong> $companyName</p>";
                echo "<p><strong>Address:</strong> $address</p>";
                echo "<p><strong>Postal Code:</strong> $postalCode</p>";
                echo "<p><strong>Email:</strong> $email</p>";
                echo "<p><strong>Citizenship:</strong> $branch</p>";
                echo "<h3>THANK YOU FOR YOUR PAYMENT, WE HOPE YOU WILL HAVE A PLEASANT STAY IN POLUMPUNG</h3>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    } // Closing the if condition for $_SERVER["REQUEST_METHOD"]
?>
    </div>
</body>
</html>
