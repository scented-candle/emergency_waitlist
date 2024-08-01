<?php
require 'config.php';
session_start();

if (!isset($_SESSION['patient_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

$patient_code = $_SESSION['patient_id'];

try {
    $stmt = $pdo->prepare('SELECT first_name, last_name, wait_time FROM patients WHERE code = :code');
    $stmt->execute(['code' => $patient_code]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($patient) {
        header('Content-Type: application/json');
        echo json_encode($patient);
    } else {
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['message' => 'Patient not found']);
    }
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
