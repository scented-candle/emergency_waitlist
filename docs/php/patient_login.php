<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars(trim($_POST['fname']));
    $last_name = htmlspecialchars(trim($_POST['lname']));
    $code = htmlspecialchars(trim($_POST['code']));

    $stmt = $pdo->prepare('SELECT * FROM patients WHERE first_name = :fname AND last_name = :lname AND code = :code');
    $stmt->execute(['fname' => $first_name, 'lname' => $last_name, 'code' => $code]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($patient) {
        $_SESSION['patient_id'] = $patient['code']; // Use 'code' as the session identifier
        header('Location: /docs/html/patient.html');
        exit;
    } else {
        echo 'Invalid credentials';
    }
}
?>
