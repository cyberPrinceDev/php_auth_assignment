<?php

$host = "localhost";
$dbname = "php_auth_db";
$db_user = "root";
$db_pass = ""; 

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname,username=$db_user,
    password=$db_pass"); $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}







