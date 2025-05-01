<?php
session_start();
require_once 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the login is for admin
    $query = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if ($password === $admin['password']) { // Admin password is plaintext
            $_SESSION['user'] = $admin;
            $_SESSION['user']['is_admin'] = true; // Mark session as admin
            header("Location: admin/index.php"); // Redirect to admin/index.php
            exit;
        } else {
            $_SESSION['error_message'] = "Incorrect email or password.";
        }
    } else {
        // Check in users table for customers
        $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['user']['is_admin'] = false; // Mark session as non-admin
                header("Location: dashboard.php");
                exit;
            } else {
                $_SESSION['error_message'] = "Incorrect email or password.";
            }
        } else {
            $_SESSION['error_message'] = "Incorrect email or password.";
        }
    }

    // Redirect back to login with error
    header("Location: login.php");
    exit;
}
