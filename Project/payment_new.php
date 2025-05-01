<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Redirect admin to the admin dashboard
if (!empty($user['is_admin']) && $user['is_admin']) {
    header("Location: admin_dashboard.php");
    exit;
}
?>

// Retrieve the selected services and total price from the POST request
$selectedServices = isset($_POST['selected_services']) ? $_POST['selected_services'] : '';
$totalPrice = isset($_POST['total_price']) ? $_POST['total_price'] : '0.00';

// Parse the selected services into an array
$servicesArray = !empty($selectedServices) ? explode(',', $selectedServices) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment Processing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/newstyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <style>
        /* Navbar styling*/
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            background-color: rgba(0, 0, 0, 0.6);
            position: fixed; /* Ensures the navbar stays fixed at the top */
            width: 100%; /* Full width for consistency */
            top: 0; /* Aligns the navbar to the top */
            z-index: 1000; /* Ensures it stays above other elements */
            height: 60px; /* Fixed height for proper spacing */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional: subtle shadow for better visibility */
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            color: white;
        }

        .navbar .nav-links {
            display: flex;
            gap: 15px;
            flex: 1;
            justify-content: center;
        }

        .navbar .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #00d9ff;
        }

        .navbar .logout {
            font-size: 16px;
            font-weight: 400;
            color: #ff4c4c;
            margin-left: 15px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .navbar .logout:hover {
            color: #ff1f1f;
        }

.order-summary {
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            width: 80%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .order-summary h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .order-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .order-summary ul li {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .total-price {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="navbar">
        <div class="logo">Explore</div>
        <div class="nav-links">
            <a href="mainpage.php">Home</a>
            <a href="modules/services/serviceListing.php">Services</a>
            <a href="modules/faq/faq.php">FAQ</a>
           
        </div>
        <a href="login.php" class="login-icon">&#128100;</a>
    </div>

    <!-- Payment Processing Module -->
        <div class="container">
    <div class="box left-box"> <!-- Left box -->
        <form action="paymentForm.php" method="post" name="paymentForm">
        <h2>Payment Information</h2>
            <div class="input-box">
                <input type="text" placeholder="Name" name="name" id="name" required>
                <i class='bx bxs-user-circle'></i>
            </div>
            
            <div class="input-box">
                <input type="date" name="orderDate" id="orderDate" required>
            </div>
            
            <div class="input-box">
                <input type="text" placeholder="Company Name (Optional)" name="companyName" id="companyName">
                <i class='bx bx-buildings'></i>
            </div>
            
            <div class="input-box">
                <input type="text" placeholder="Address" name="address" id="address" required>
                <i class='bx bx-current-location'></i>
            </div>
            
            <div class="input-box">
                <input type="text" placeholder="Postal Code" name="postalCode" id="postalCode" required>
            </div>
            
            <div class="input-box">
                <input type="email" placeholder="Email" name="email" id="email" required>
                <i class='bx bx-envelope'></i>
            </div>
            
            <p>Citizenship:
            <div class="input-box">
                <select name="branch" required>
                    <option value="">- Please Select -</option>
                    <option value="Malaysian">Malaysian</option>
                    <option value="Non-Malaysian">Non-Malaysian</option>
                </select>
                <i class='bx bxs-flag-alt'></i>
            </div>
            </p>
            
            <p>
                <label for="payment-proof">Please attach your payment proof:</label>
                <input type="file" id="payment-proof" name="payment-proof" accept="image/*,application/pdf" required>
            </p>
            
            <button type="submit" class="btn">Process Payment</button>
            <button type="reset" class="btn">Reset</button>
            
        </form>
    </div>

    <div class="box right-box"> <!-- Right box -->
        <h3>Your Order</h3>
    </div>
<div class="order-summary">
        <h3>Your Order Summary</h3>
        <ul>
            <?php if (!empty($servicesArray)): ?>
                <?php foreach ($servicesArray as $service): ?>
                    <li><?php echo htmlspecialchars($service); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No services selected.</li>
            <?php endif; ?>
        </ul>
        <p class="total-price">Total Price: $<?php echo htmlspecialchars($totalPrice); ?></p>
    </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
       document.forms["paymentForm"].onsubmit = function (event) {
      event.preventDefault(); // Prevent default form submission
      let isValid = true;
      
      const name = document.getElementById("name").value;
      const orderDate = document.getElementById("orderDate").value;
      const companyName = document.getElementsByName("companyName");
      const address = document.getElementById("address").value;
      const postalCode = document.getElementById("postalCode").value;
      const email = document.getElementById("email").value;
      const branch = document.forms["reviewForm"].branch.value;
    
    // Display form values in the output paragraph if valid
      if (isValid) {
        document.getElementById("output").innerText =
          `INVOICE!
           Name: ${name}
           Order Date: ${orderDate}
           Company Name: ${companyName}
           Address: ${address}
           Postal Code: ${postalCode}
           Email: ${email}
           Citizenship: ${branch}`;
</script>
    <footer>
        <p class="footer" align="center"><small>&copy; Polumpung Sabah. All rights reserved</small></p>
    </footer>

</body>
</html>
