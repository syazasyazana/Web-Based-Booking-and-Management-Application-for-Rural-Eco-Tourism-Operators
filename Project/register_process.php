<?php
session_start();
$conn = new mysqli("localhost", "root", "", "polumpong");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $admin_email = "admin@email.com"; // Reserved admin email
    $errors = [
        'email' => '',
        'password' => ''
    ];

    // Validate password contains at least one number
    if (!preg_match('/\d/', $password)) {
        $errors['password'] = "Password must contain at least one number.";
    }

    // Prevent registration with the admin email
    if ($email === $admin_email) {
        $errors['email'] = "This email is reserved for admin use.";
    }

    // Check if the email already exists in the database
    $query = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $errors['email'] = "User with this email already exists.";
    }

    // If there are errors, redirect back with specific error messages
    if (!empty($errors['email']) || !empty($errors['password'])) {
        $_SESSION['error_message'] = $errors;
        header("Location: register.php");
        exit;
    }

    // Hash the password and save the user
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $query->bind_param("sss", $username, $email, $hashed_password);

    if ($query->execute()) {
        header("Location: login.php");
    } else {
        $_SESSION['error_message']['general'] = "Error: " . $conn->error;
        header("Location: register.php");
    }
    exit;
}
?>
