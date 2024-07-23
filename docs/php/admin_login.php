<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['user'];
    $password = $_POST['password'];

    // Prepare and execute the query to fetch admin details
    $stmt = $pdo->prepare('SELECT * FROM administrator WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    // Verify the password (plain text comparison) and start session if valid
    if ($admin && $password === $admin['password']) {
        session_start();
        $_SESSION['admin'] = $admin['username'];
        header('Location: ../html/admin.html');
        exit(); // Always good practice to exit after a header redirect
    } else {
        echo 'Invalid credentials';
    }
}
?>


