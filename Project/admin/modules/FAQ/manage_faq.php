<?php
include("../../../config/config.php");  // Ensure this points to the correct location of config.php

// Start output buffering
ob_start();

// Delete FAQ functionality
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Delete the FAQ based on the ID
    $sql = "DELETE FROM faq WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $message = "FAQ deleted successfully!";
        // Use header to redirect after deletion to prevent re-submitting the form on page refresh
        header("Location: manage_faq.php");
        exit(); // Make sure to exit after the header to stop further code execution
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch all FAQs from the database
$sql = "SELECT * FROM faq";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage FAQs</title>
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
    <h2>Manage FAQs</h2>
    <p>Here you can view, edit, or delete existing FAQs.</p>

    <!-- FAQ Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>Answer</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output each FAQ as a row in the table
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['question'] . "</td>";
                echo "<td>" . $row['answer'] . "</td>";
                echo "<td>
                        <a href='?edit=" . $row['id'] . "'>Edit</a> | 
                        <a href='?delete=" . $row['id'] . "'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No FAQs available</td></tr>";
        }
        ?>
    </table>

    <!-- Edit FAQ Form -->
    <?php
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        // Fetch the FAQ based on the ID
        $sql = "SELECT * FROM faq WHERE id = $id";
        $result_edit = $conn->query($sql);
        if ($result_edit->num_rows > 0) {
            $row_edit = $result_edit->fetch_assoc();
            ?>
            <h3>Edit FAQ</h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $row_edit['id']; ?>" />
                <label for="question">Question:</label><br>
                <textarea name="question" id="question" rows="4" cols="50" required><?php echo $row_edit['question']; ?></textarea><br><br>
                
                <label for="answer">Answer:</label><br>
                <textarea name="answer" id="answer" rows="4" cols="50" required><?php echo $row_edit['answer']; ?></textarea><br><br>
                
                <button type="submit" name="update_faq">Update FAQ</button>
            </form>
            <?php
        }
    }

    // Handle updating FAQ
    if (isset($_POST['update_faq'])) {
        $id = $_POST['id'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        // Update the FAQ in the database
        $sql = "UPDATE faq SET question = '$question', answer = '$answer' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $message = "FAQ updated successfully!";
            // Refresh the page after update
            header("Location: manage_faq.php");
            exit(); // Make sure to exit after the header to stop further code execution
        } else {
            $message = "Error: " . $conn->error;
        }
    }
    ?>

    <!-- Display message for success or error -->
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
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
