<?php
require 'config.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

try {
    $stmt = $pdo->query('SELECT SUM(wait_time) as total_wait_time FROM patients');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
