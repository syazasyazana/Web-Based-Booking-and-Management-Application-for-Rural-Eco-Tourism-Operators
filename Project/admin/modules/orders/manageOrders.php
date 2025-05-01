<?php  
include("../../../config/config.php");  // Ensure this points to the correct location of config.php

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM payments WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Payment deleted successfully'); window.location.href = 'payments.php';</script>";
    } else {
        echo "<script>alert('Error deleting payment');</script>";
    }
}

// Fetch all payments from the database
$sql = "SELECT * FROM payments";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Payments</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
  
  <style>
    /* Table Styling */
    table.payment-table {
        width: 100%;
        border-collapse: collapse; /* Ensures borders don't double */
        margin-top: 20px;
    }

    table.payment-table th, table.payment-table td {
        border: 1px solid #ddd; /* Adds borders to table cells */
        padding: 8px 12px;
        text-align: left;
    }

    table.payment-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    table.payment-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table.payment-table tr:hover {
        background-color: #f1f1f1;
    }

    table.payment-table a {
        color: #007bff;
        text-decoration: none;
    }

    table.payment-table a:hover {
        text-decoration: underline;
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
    <h2>Payments Management</h2>
    <p>Here you can view and delete payments.</p>

    <table class="payment-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Order Date</th>
          <th>Company Name</th>
          <th>Address</th>
          <th>Postal Code</th>
          <th>Email</th>
          <th>Branch</th>
          <th>Payment Proof</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        // Check if there are any records
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['orderDate'] . "</td>";
                echo "<td>" . $row['companyName'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['postalCode'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['branch'] . "</td>";
                echo "<td><a href='" . $row['payment_proof'] . "' target='_blank'>View Proof</a></td>";
                echo "<td><a href='?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this payment?\")'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No payments found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
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

<?php
// Close the database connection
mysqli_close($conn);
?>
