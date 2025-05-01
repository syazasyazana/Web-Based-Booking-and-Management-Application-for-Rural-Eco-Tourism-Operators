<?php
include("../../../config/config.php");  // Ensure this points to the correct location of config.php

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM services WHERE service_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Service deleted successfully!'); window.location.href='manageListings.php';</script>";
    } else {
        echo "<script>alert('Failed to delete service.'); window.location.href='manageListings.php';</script>";
    }
    $stmt->close();
}

// Handle editing
$editing_service = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $edit_query = "SELECT * FROM services WHERE service_id = ?";
    $stmt = $conn->prepare($edit_query);
    $stmt->bind_param('i', $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editing_service = $result->fetch_assoc();
    $stmt->close();
}

if (isset($_POST['edit_service'])) {
    $service_id = intval($_POST['service_id']);
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $update_query = "UPDATE services SET name = ?, price = ?, description = ?, image = ? WHERE service_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('sdssi', $name, $price, $description, $image, $service_id);

    if ($stmt->execute()) {
        echo "<script>alert('Service updated successfully!'); window.location.href='manageListings.php';</script>";
    } else {
        echo "<script>alert('Failed to update service.');</script>";
    }
    $stmt->close();
}

// Fetch services
$services_query = "SELECT * FROM services";
$result = $conn->query($services_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Services</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
  <style>
    .edit-form {
      display: flex;
      flex-direction: column;
      max-width: 600px;
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #f9f9f9;
    }
    .edit-form label {
      font-weight: bold;
      margin-bottom: 5px;
    }
    .edit-form input, .edit-form textarea {
      width: 100%;
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .edit-form button {
      padding: 10px 15px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .edit-form button:hover {
      background-color: #45a049;
    }
  </style>
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
  <?php include '../../includes/sideNav.php'; ?>

  <!-- Main content -->
  <div class="main">
    <h2>Manage Services</h2>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Description</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['service_id']; ?></td>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo number_format($row['price'], 2); ?></td>
              <td><?php echo htmlspecialchars($row['description']); ?></td>
              <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Service Image" style="width: 100px; height: auto;"></td>
              <td>
                <a href="?edit_id=<?php echo $row['service_id']; ?>" style="margin-right: 10px; color: blue; text-decoration: underline;">Edit</a>
                <a href="?delete_id=<?php echo $row['service_id']; ?>" onclick="return confirm('Are you sure you want to delete this service?');" style="color: red; text-decoration: underline;">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align: center;">No services found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <?php if ($editing_service): ?>
      <h3>Edit Service</h3>
      <form method="POST" action="" class="edit-form">
        <input type="hidden" name="service_id" value="<?php echo $editing_service['service_id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($editing_service['name']); ?>" required>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo number_format($editing_service['price'], 2); ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($editing_service['description']); ?></textarea>

        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($editing_service['image']); ?>" required>

        <button type="submit" name="edit_service">Save Changes</button>
      </form>
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
