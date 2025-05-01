<?php   
include("../../../config/config.php");  // Ensure this points to the correct location of config.php  

// Fetch the services from the database
$query = "SELECT * FROM additional_services";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update the availability of the services based on the form submission
    foreach ($_POST['availability'] as $service_id => $availability) {
        $update_query = "UPDATE additional_services SET availability = '$availability' WHERE service_id = $service_id";
        mysqli_query($conn, $update_query);
    }
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
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
  <style>
    /* Add some basic styling for the table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table th, table td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    table th {
      background-color: #f2f2f2;
    }

    table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    /* Add some basic styling for the buttons */
    .status-button {
      padding: 5px 10px;
      border: none;
      cursor: pointer;
      font-size: 14px;
      border-radius: 5px;
      margin: 5px;
    }

    .available {
      background-color: green;
      color: white;
    }

    .sold-out {
      background-color: red;
      color: white;
    }

    /* Highlight the active button with a different border */
    .status-button.selected {
      border: 2px solid #000; /* Dark border to highlight the selected button */
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); /* Add a small shadow for emphasis */
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
    <h2>Admin Panel Dashboard</h2>
    <p>Welcome to the Admin Panel. You can manage the listings, reviews, availability, orders, and FAQs here.</p>

    <!-- Service Availability Table -->
    <h3>Manage Service Availability</h3>
    <form method="POST" action="">
      <table>
        <thead>
          <tr>
            <th>Service Name</th>
            <th>Price</th>
            <th>Availability</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo htmlspecialchars($row['service_name']); ?></td>
              <td><?php echo htmlspecialchars($row['service_price']); ?></td>
              <td>
                <!-- Include hidden input to preserve availability value for submission -->
                <input type="hidden" name="availability[<?php echo $row['service_id']; ?>]" value="<?php echo $row['availability']; ?>" />
                <button type="submit" name="availability[<?php echo $row['service_id']; ?>]" value="available" class="status-button available <?php if ($row['availability'] == 'available') echo 'selected'; ?>">Available</button>
                <button type="submit" name="availability[<?php echo $row['service_id']; ?>]" value="sold out" class="status-button sold-out <?php if ($row['availability'] == 'sold out') echo 'selected'; ?>">Sold Out</button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
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
