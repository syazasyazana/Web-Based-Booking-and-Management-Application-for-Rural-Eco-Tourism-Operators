<?php
session_start();
$error_message = $_SESSION['error_message'] ?? [];
unset($_SESSION['error_message']);  // Clear errors after they're displayed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Register</title>
    <style>
        .error-message {
            color: red;
            font-size: 12px;
            margin: 5px 0 0 0;
        }
        .form-container input {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Register</h2>
            <?php if (!empty($error_message['general'])): ?>
                <p class="error-message"><?= htmlspecialchars($error_message['general']) ?></p>
            <?php endif; ?>
            <form action="register_process.php" method="POST">
                <input type="text" name="username" placeholder="Enter your username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                <input type="email" name="email" placeholder="Enter your email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                <?php if (!empty($error_message['email'])): ?>
                    <p class="error-message"><?= htmlspecialchars($error_message['email']) ?></p>
                <?php endif; ?>
                <input type="password" name="password" placeholder="Enter your password" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>" required>
                <?php if (!empty($error_message['password'])): ?>
                    <p class="error-message"><?= htmlspecialchars($error_message['password']) ?></p>
                <?php endif; ?>
                <button type="submit">Register</button>
            </form>
            <a href="login.php" class="link">Already have an account? Login here</a>
        </div>
    </div>
</body>
</html>
