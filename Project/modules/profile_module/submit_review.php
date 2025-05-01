<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['id'])) {
    die("You must be logged in to submit a review.");
}

// Fetch user `id` and `username` from session
$user_id = intval($_SESSION['user']['id']); // Convert session ID to an integer
$username = $_SESSION['user']['username'] ?? 'Unknown'; // Default username if not set

// Connect to the database
$host = 'localhost'; // Your database host
$user = 'root';      // Your database username
$pass = '';          // Your database password
$db = 'polumpong';   // Your database name

$conn = new mysqli($host, $user, $pass, $db);

// Check database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reviewText = trim($_POST['review'] ?? ''); // Use null coalescing operator for safety
    $rating = intval($_POST['rating'] ?? 0);

    // Validate inputs
    if (empty($reviewText)) {
        die("Review text cannot be empty.");
    }
    if ($rating < 1 || $rating > 5) {
        die("Rating must be between 1 and 5.");
    }

    // Insert review into the database
    $stmt = $conn->prepare("INSERT INTO reviews (user_id, username, review_text, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $user_id, $username, $reviewText, $rating);

    if ($stmt->execute()) {
        echo "Review submitted successfully!";
    } else {
        echo "Failed to submit review: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method. Please submit the form.";
}

// Close the database connection
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
