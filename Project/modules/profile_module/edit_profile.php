<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    die("Session not set. Please log in again.");
}

// Retrieve the logged-in user's ID
$userId = $_SESSION['user']['id'];

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'polumpong';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Validate inputs
    if (empty($phone) || empty($password)) {
        die("Phone number and password cannot be empty.");
    }

    // Update the user's phone and password
    $sql = "UPDATE users 
            SET phone = '$phone', 
                password = '$hashedPassword', 
                updated_at = NOW() 
            WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>

<!-- Back to Home Button -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
    <style>
        .back-home {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-home:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <a href="profile.php" class="back-home">Back to Home</a>
    </div>
</body>
</html>

