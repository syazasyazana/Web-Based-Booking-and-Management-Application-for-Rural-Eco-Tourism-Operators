<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Retrieve user information from the session
$username = $_SESSION['user']['username'] ?? 'Guest';
$email = $_SESSION['user']['email'] ?? 'guest@example.com';
$user_id = $_SESSION['user']['id'] ?? 0; // Use 0 as fallback for safety

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "polumpong";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Error: Failed to connect to the database.");
}

// Fetch review history for the logged-in user
$sql_reviews = "SELECT id, user_id, username, review_text, rating, created_at FROM reviews WHERE user_id = ? ORDER BY created_at DESC";
$stmt_reviews = $conn->prepare($sql_reviews);
$stmt_reviews->bind_param("i", $user_id);
$stmt_reviews->execute();
$result_reviews = $stmt_reviews->get_result();

// Store reviews in an array
$reviews = [];
if ($result_reviews->num_rows > 0) {
    while ($row = $result_reviews->fetch_assoc()) {
        $reviews[] = $row;
    }
}
$stmt_reviews->close();

// Fetch booking history for the logged-in user
$sql_bookings = "SELECT id, name, orderDate, companyName, address, postalCode, email, branch, payment_proof, created_at 
                 FROM payments WHERE email = ? ORDER BY created_at DESC";
$stmt_bookings = $conn->prepare($sql_bookings);
$stmt_bookings->bind_param("s", $email); // Bind the email from the session
$stmt_bookings->execute();
$result_bookings = $stmt_bookings->get_result();

// Store booking history in an array
$bookings = [];
if ($result_bookings->num_rows > 0) {
    while ($row = $result_bookings->fetch_assoc()) {
        $bookings[] = $row;
    }
}
$stmt_bookings->close();


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="../../css/styless.css">
</head>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
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
            margin: 0 10px;
            font-weight: 500;
        }

        .navbar a:hover {
            color: #00d9ff;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        /* Main Content */
        .service-category {
            margin: 80px 20px;
            text-align: center;
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
            padding: 15px;
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

      
    </style>
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
        <a href="../services/serviceListing.php">Services</a>
        <a href="../faq/faq.php">FAQ</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="profile.php">My Profile</a>
            <?php endif; ?>
		</div>
		
		<?php if (isset($_SESSION['user'])): ?>
            <a href="../../logout.php" class="logout" onclick="confirmLogout(event)">Logout</a>
        <?php endif; ?>
    </div>
</div>
    <div class="nav">
        <a href="#" onclick="showTab('user-profile')">Profile</a>
        <a href="#" onclick="showTab('booking-history')">Booking History</a>
        <a href="#" onclick="showTab('reviews')">Reviews</a>
    </div>

    <div class="container">
        <!-- User Profile -->
        <div id="user-profile" class="tab-content active">
            <h2>Profile Information</h2>
            <p><strong>Username:</strong> <span id="user-name"><?php echo htmlspecialchars($username); ?></span></p>
            <p><strong>Email:</strong> <span id="user-email"><?php echo htmlspecialchars($email); ?></span></p>
            <button onclick="showTab('edit-profile')">Edit Profile</button>
        </div>

        <!-- Edit Profile -->
        <div id="edit-profile" class="tab-content">
            <h2>Edit Profile</h2>
            <form action="edit_profile.php" method="POST">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your new password" required>

                <button type="submit">Save Changes</button>
            </form>
        </div>

        <!-- Booking History -->
        <div id="booking-history" class="tab-content">
    <h2>Booking History</h2>
    <div class="booking-list">
        <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card">
                    <p><strong>Order ID:</strong> <?php echo htmlspecialchars($booking['id']); ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['name']); ?></p>
                    <p><strong>Order Date:</strong> <?php echo htmlspecialchars($booking['orderDate']); ?></p>
                    <p><strong>Company Name:</strong> <?php echo htmlspecialchars($booking['companyName']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($booking['address']); ?></p>
                    <p><strong>Postal Code:</strong> <?php echo htmlspecialchars($booking['postalCode']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></p>
                    <p><strong>Branch:</strong> <?php echo htmlspecialchars($booking['branch']); ?></p>
                    <p><strong>Payment Proof:</strong></p>
                    <a href="modules/bookingH/vview_payment_proof.php?url=<?php echo urlencode($booking['payment_proof']); ?>" target="_blank">
                        <img src="<?php echo htmlspecialchars($booking['payment_proof']); ?>" alt="Payment Proof" style="max-width: 100%; height: auto;">
                    </a>
                    <p><strong>Created At:</strong> <?php echo htmlspecialchars($booking['created_at']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No booking history found.</p>
        <?php endif; ?>
    </div>
</div>





        <!-- Reviews -->
        <div id="reviews" class="tab-content">
            <h2>Reviews</h2>
            <div class="review-form">
                <form action="submit_review.php" method="POST">
                    <label for="review">Write a Review</label>
                    <textarea id="review" name="review" rows="5" placeholder="Share your experience..." required></textarea>
                    <label for="rating">Rating (1 to 5)</label>
                    <input type="range" id="rating" name="rating" min="1" max="5" step="1" oninput="updateRatingValue(this.value)">
                    <p class="rating-value">Selected Rating: <span id="rating-value">3</span></p>
                    <button type="submit">Submit Review</button>
                </form>
            </div>

            <div class="review-history">
                <h3>Your Review History</h3>
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <p><strong>Review ID:</strong> <?php echo htmlspecialchars($review['id']); ?></p>
                            <p><strong>Username:</strong> <?php echo htmlspecialchars($review['username']); ?></p>
                            <p><strong>Review:</strong> <?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                            <p><strong>Rating:</strong> <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                            <p><strong>Posted On:</strong> <?php echo htmlspecialchars($review['created_at']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Function to show the selected tab
        function showTab(tabId) {
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
        }

        // Update the displayed rating value when the slider moves
        function updateRatingValue(value) {
            document.getElementById('rating-value').textContent = value;
        }
    </script>

</body>
</html>
