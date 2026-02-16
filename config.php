<?php

$host = "localhost";
$dbname = "php_auth_db";
$db_user = "root";
$db_pass = ""; 

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try{
    $pdo = new PDO($dsn, $db_user, $db_pass); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}







