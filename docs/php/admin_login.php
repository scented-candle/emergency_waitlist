<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['user'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        session_start();
        $_SESSION['admin'] = $admin['id'];
        header('Location: admin.html');
    } else {
        echo 'Invalid credentials';
    }
}
?>


