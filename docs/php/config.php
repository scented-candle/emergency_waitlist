<?php

$host = 'localhost';
$db = 'emergency_waitlist';
$user = 'postgres';
$password = 'sailor1';

try {
    $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$db;", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
