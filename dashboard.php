<?php
session_start();
require_once 'User.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$currentUser = User::findById($_SESSION['user_id']);

if (!$currentUser) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($currentUser->username); ?>!</h1>
        
        <p><strong>Profile Details:</strong></p>
        <ul>
            <li>Email: <?php echo htmlspecialchars($currentUser->email); ?></li>
            <li>User ID: <?php echo htmlspecialchars($currentUser->id); ?></li>
        </ul>

        <hr>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>