<!-- sidenav.php -->
<div class="sidenav">
  <a href="#dashboard">Dashboard</a>
  
  <button class="dropdown-btn">Users
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="<?php echo ADMIN_BASE_URL; ?>/modules/users/manageUsers.php">Manage Users</a>
  </div>

  <button class="dropdown-btn">Listings
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="<?php echo ADMIN_BASE_URL; ?>/modules/listings/addListings.php">Add Listings</a>
    <a href="<?php echo ADMIN_BASE_URL; ?>/modules/listings/manageListings.php">Manage Listings</a>
  </div>

  <button class="dropdown-btn">Reviews
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="<?php echo ADMIN_BASE_URL; ?>/modules/review/manageReview.php">Manage Reviews</a>
  </div>

  <button class="dropdown-btn">Availability
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="<?php echo ADMIN_BASE_URL; ?>/modules/availability/manageAvailability.php">Manage Availability</a>
  </div>

  <button class="dropdown-btn">Orders
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="<?php echo ADMIN_BASE_URL; ?>/modules/orders/manageOrders.php">Manage Orders</a>
  </div>

  <button class="dropdown-btn">FAQs
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <a href="<?php echo ADMIN_BASE_URL; ?>/modules/FAQ/add_faq.php">Create FAQ</a>
    <a href="<?php echo ADMIN_BASE_URL; ?>/modules/FAQ/manage_faq.php">Manage FAQ</a>
  </div>

  <a href="<?php echo ADMIN_BASE_URL; ?>/modules/analytics/analytics.php">Analytics</a>
  <a href="<?php echo ADMIN_BASE_URL; ?>../mainpage.php">Logout</a>
</div>
