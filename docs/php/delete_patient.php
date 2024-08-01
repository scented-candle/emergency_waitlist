<?php
require 'config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['code'])) {
    $code = $_POST['code'];

    try {
        // Check if the patient exists and delete if found
        $stmt = $pdo->prepare('DELETE FROM patients WHERE code = :code');
        $stmt->execute(['code' => $code]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Patient removed successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Patient code does not exist']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Code is required or invalid request method']);
}
?>
