<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $code = $_POST['code'];

    $stmt = $pdo->prepare('SELECT * FROM patients WHERE first_name = :fname AND last_name = :lname AND code = :code');
    $stmt->execute(['fname' => $first_name, 'lname' => $last_name, 'code' => $code]);
    $patient = $stmt->fetch();

    if ($patient) {
        session_start();
        $_SESSION['patient'] = $patient['id'];
        header('Location: /docs/html/patient.html');
    } else {
        echo 'Invalid credentials';
    }
}
?>

