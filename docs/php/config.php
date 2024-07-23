<?php
require 'vendor/autoload.php';  

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$db = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];

try {
    $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$db;", $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>