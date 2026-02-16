 <?php
    session_start();

    require 'config.php';

    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        if(empty($email) || empty($password)){
            $errors[] = "Both fields are required.";
        }else{
            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute([':email' => $email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $errors[] = "Invalid credentials.";
                }
            } catch (PDOException $e) {
                $errors[] = "Login failed: " . $e->getMessage();
            }
        }
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>

        <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <?php echo htmlspecialchars($errors[0]); ?>
        </div>
    <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

        
</body>
</html>