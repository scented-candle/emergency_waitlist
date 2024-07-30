<?php
require 'config.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['code'])) {
        $code = $_POST['code'];
        
        // Delete the patient
        $stmt = $pdo->prepare('DELETE FROM patients WHERE code = :code');
        $result = $stmt->execute(['code' => $code]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete patient']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Code is required']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
