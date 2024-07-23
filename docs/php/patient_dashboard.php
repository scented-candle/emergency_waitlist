<?php
require 'config.php';

session_start();
if (!isset($_SESSION['patient'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit;
}

$patientId = $_SESSION['patient'];
$stmt = $pdo->prepare('SELECT * FROM patients WHERE id = :id');
$stmt->execute(['id' => $patientId]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($patient);
?>
