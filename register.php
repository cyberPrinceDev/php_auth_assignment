<?php 
session_start();
require 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation Logic 
    if (empty($username) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }
    if (strlen($username) < MIN_USERNAME_LENGTH) {
    $errors[] = "Username must be at least " . MIN_USERNAME_LENGTH . " characters long.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < MIN_PASSWORD_LENGTH) {
    $errors[] = "Password must be at least " . MIN_PASSWORD_LENGTH . " characters long.";
    }

    // Database Logic 
    if (empty($errors)) {
        try {
            // Check for duplicates
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
            $checkStmt->execute([':username' => $username, ':email' => $email]);

            if ($checkStmt->fetchColumn() > 0) {
                $errors[] = "Username or email already exists.";
            }                

            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $insertStmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
                
                $result = $insertStmt->execute([
                    ':username' => $username,
                    ':email'    => $email,
                    ':password' => $hashedPassword
                ]);

                if ($result) {
                    header("Location: login.php");
                    exit(); 
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Registration failed: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <div class="register-container">
        <h1>Create Account</h1>

        <?php if (!empty($errors)): ?>
            <div class="error-box" style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
                <ul style="margin: 0;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"placeholder="Username">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password">
            </div>
           <br>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="login.php">Log in here</a>
        </div>
    </div>
</body>
</html>