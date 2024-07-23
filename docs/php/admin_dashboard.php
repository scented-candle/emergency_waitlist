<?php
require 'config.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

$stmt = $pdo->query('SELECT * FROM patients');
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($patients);
?>
