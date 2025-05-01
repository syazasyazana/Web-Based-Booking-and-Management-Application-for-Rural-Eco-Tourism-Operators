<?php
include("../../../config/config.php");  // Include database connection

$message = "";  // Message to display feedback

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $imagePath = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../images/";  // Path to the images directory
        $imageName = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;

        // Ensure uploads directory exists
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile; // Store the relative path
        } else {
            $message = "Failed to upload the image.";
        }
    }

    // Insert into the database
    $sql = "INSERT INTO services (name, price, description, image) VALUES ('$name', '$price', '$description', '$imagePath')";
    if (mysqli_query($conn, $sql)) {
        $message = "Listing added successfully!";
    } else {
        $message = "Database error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Listing</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
  <style>
    /* Additional styling for the form */
    form {
      max-width: 600px;
      margin: 20px auto;
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    form label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }
    form input, form textarea, form button {
      width: 100%;
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    form button {
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
    }
    form button:hover {
      background-color: #0056b3;
    }
    .message {
      text-align: center;
      margin-top: 10px;
      color: green;
    }
    .error {
      color: red;
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
    <h2>Add New Listing</h2>
    <p>Fill in the form below to add a new service listing.</p>

    <!-- Add Listing Form -->
    <form action="" method="POST" enctype="multipart/form-data">
      <label for="name">Service Name:</label>
      <input type="text" id="name" name="name" placeholder="Enter service name" required>

      <label for="price">Price:</label>
      <input type="number" id="price" name="price" placeholder="Enter price" step="0.01" required>

      <label for="description">Description:</label>
      <textarea id="description" name="description" rows="4" placeholder="Enter service description" required></textarea>

      <label for="image">Upload Image:</label>
      <input type="file" id="image" name="image" accept="image/*">

      <button type="submit">Add Listing</button>
    </form>

    <div class="message <?php echo $message ? ($message === "Listing added successfully!" ? '' : 'error') : ''; ?>">
      <?php echo htmlspecialchars($message); ?>
    </div>
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
