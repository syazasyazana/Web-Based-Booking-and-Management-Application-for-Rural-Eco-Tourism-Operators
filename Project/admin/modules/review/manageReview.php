<?php
// Correct the include path to the proper location of config.php
include("../../config/config.php"); // Adjust the path as needed

// Handle review deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM reviews WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Review deleted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to delete review.');</script>";
    }
}

// Fetch reviews
$query = "SELECT id, user_id, username, review_text, rating, created_at FROM reviews ORDER BY created_at DESC";
$result = $conn->query($query);

// Check if query execution is successful
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/../css/admin.css">
</head>
<body>
  <!-- Top navigation -->
  <div class="topNav">
    <img src="<?php echo ADMIN_BASE_URL; ?>/img/icon.png" alt="Logo">
     <a href="../../../../mainpage.php">
      <i class="fa fa-sign-out" style="font-size: 12px;"></i> Logout
    </a>
  </div>

  <!-- Sidebar Navigation -->
  <?php
    include '../../includes/sideNav.php';
  ?>

  <!-- Main content -->
  <div class="main">
    <!-- Review Management Table -->
    <h1>Manage Reviews</h1>
    <?php if ($result->num_rows > 0): ?>
      <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; font-family: 'Raleway', sans-serif; border-collapse: collapse;">
        <thead>
          <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Username</th>
            <th>Review Text</th>
            <th>Rating</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']); ?></td>
              <td><?php echo htmlspecialchars($row['user_id']); ?></td>
              <td><?php echo htmlspecialchars($row['username']); ?></td>
              <td><?php echo htmlspecialchars($row['review_text']); ?></td>
              <td><?php echo htmlspecialchars($row['rating']); ?></td>
              <td><?php echo htmlspecialchars($row['created_at']); ?></td>
              <td>
                <a href="?delete_id=<?php echo $row['id']; ?>" class="delete-button" style="color: red; text-decoration: underline;" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No reviews found.</p>
    <?php endif; ?>
  </div>

  <!-- Dropdown functionality for the sidebar -->
  <script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    for (var i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });
    }
  </script>
</body>
</html>
