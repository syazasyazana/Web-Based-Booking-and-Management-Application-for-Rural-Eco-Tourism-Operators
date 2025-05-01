<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Get the payment proof URL from the query parameter
$payment_proof_url = isset($_GET['url']) ? $_GET['url'] : '';

// Debug output to check the raw query parameter
echo "Raw Query Parameter: " . htmlspecialchars($payment_proof_url) . "<br>";

// Validate the URL (allow both absolute and relative URLs)
if (empty($payment_proof_url) || (!filter_var($payment_proof_url, FILTER_VALIDATE_URL) && !file_exists($payment_proof_url))) {
    die("Invalid URL.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Proof</title>
</head>
<body>
    <h2>Payment Proof</h2>
    <img src="<?php echo htmlspecialchars($payment_proof_url); ?>" alt="Payment Proof" style="max-width: 100%; height: auto;">
    <br>
    <a href="user_profile.php">Back to Profile</a> <!-- Adjust the link to your profile page -->
</body>
</html>
