<?php
// Include the configuration file for the database connection
include('../../../config/config.php');




// Add FAQ functionality
if (isset($_POST['add_faq'])) {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Insert the new FAQ into the database
    $sql = "INSERT INTO faq (question, answer) VALUES ('$question', '$answer')";
    if ($conn->query($sql) === TRUE) {
        $message = "New FAQ added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add FAQ</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
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
    <h2>Add a New FAQ</h2>
    <form method="POST">
        <label for="question">Question:</label><br>
        <textarea name="question" id="question" rows="4" cols="50" required></textarea><br><br>
        
        <label for="answer">Answer:</label><br>
        <textarea name="answer" id="answer" rows="4" cols="50" required></textarea><br><br>
        
        <button type="submit" name="add_faq">Add FAQ</button>
    </form>

    <?php
    // Display message if FAQ was added
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>
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
$conn->close();
?>
