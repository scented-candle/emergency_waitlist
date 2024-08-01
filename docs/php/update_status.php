<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare('UPDATE patients SET status = :status WHERE code = :code');
    $stmt->execute(['status' => $status, 'code' => $code]);

    if ($stmt->rowCount()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
