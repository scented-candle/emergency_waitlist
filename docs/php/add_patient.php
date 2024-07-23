<?php
require 'config.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $check_in = $_POST['check_in'];
    $severity = $_POST['severity'];

    $stmt = $pdo->prepare('INSERT INTO patients (code, first_name, last_name, check_in, severity) VALUES (:code, :first_name, :last_name, :check_in, :severity)');
    $result = $stmt->execute([
        'code' => $code,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'check_in' => $check_in,
        'severity' => $severity
    ]);

    echo json_encode(['success' => $result]);
}
?>