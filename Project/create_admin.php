<?php
$conn = new mysqli("localhost", "root", "", "polumpong");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = "admin@email.com";
$password = password_hash("admin123", PASSWORD_BCRYPT);

$query = $conn->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
$query->bind_param("ss", $email, $password);

if ($query->execute()) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . $conn->error;
}
$query->close();
$conn->close();
?>
