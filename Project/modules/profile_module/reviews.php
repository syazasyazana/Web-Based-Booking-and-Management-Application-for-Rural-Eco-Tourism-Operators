<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'polumpung');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all reviews
$sql = "SELECT r.review_id, r.review_text, r.rating, r.created_at, u.username 
        FROM review r
        JOIN user u ON r.user_id = u.user_id
        ORDER BY r.created_at DESC";
$result = $conn->query($sql);

echo "<h2>All Reviews</h2>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>User:</strong> " . htmlspecialchars($row['username']) . "</p>";
        echo "<p><strong>Review:</strong> " . htmlspecialchars($row['review_text']) . "</p>";
        echo "<p><strong>Rating:</strong> " . htmlspecialchars($row['rating']) . "/5</p>";
        echo "<p><em>Submitted on: " . htmlspecialchars($row['created_at']) . "</em></p><hr>";
    }
} else {
    echo "<p>No reviews available yet.</p>";
}

$conn->close();
?>
