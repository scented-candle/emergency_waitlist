<?php
require 'config.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

try {
    $stmt = $pdo->query('SELECT * FROM patients ORDER BY severity DESC, check_in ASC');
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($patients);
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
