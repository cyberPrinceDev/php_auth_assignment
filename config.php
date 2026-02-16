<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'php_auth_system');
define('DB_USER', 'root');
define('DB_PASS', '');

define('MIN_USERNAME_LENGTH', 3);
define('MIN_PASSWORD_LENGTH', 8);

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>