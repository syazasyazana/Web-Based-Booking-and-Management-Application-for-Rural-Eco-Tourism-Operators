<?php
include("../config/config.php"); // Ensure this points to the correct location of config.php

// Check if service_id is provided in the URL
if (!isset($_GET['service_id'])) {
    die("Service ID is missing.");
}

$service_id = $_GET['service_id'];

// Fetch the service details from the database
try {
    $pdo = new PDO("mysql:host=localhost;dbname=polumpong", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("SELECT * FROM services WHERE service_id = ?");
    $stmt->execute([$service_id]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$service) {
        die("Service not found.");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Handle form submission for updating the service
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image']; // Handle the image upload if necessary

    try {
        $updateStmt = $pdo->prepare("UPDATE services SET name = ?, price = ?, description = ?, image = ? WHERE service_id = ?");
        $updateStmt->execute([$name, $price, $description, $image, $service_id]);
        echo "Service updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Service</title>
</head>
<body>
    <h2>Edit Service</h2>

    <form method="POST" action="">
        <label for="name">Service Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($service['name']); ?>" required><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($service['price']); ?>" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($service['description']); ?></textarea><br>

        <label for="image">Image:</label>
        <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($service['image']); ?>"><br>

        <input type="submit" value="Update Service">
    </form>
</body>
</html>
