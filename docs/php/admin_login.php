<?php
session_start();

$host = 'localhost';
$dbname = 'emergency_waitlist';
$user = 'postgres';
$password = 'sailor1';

try {
    $db = pg_connect("host=localhost dbname=emergency_waitlist user=postgres password=sailor1"); 
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname",$user,$password);//Creates a connection to the database

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    $user = $_POST['user']; //Getting name from login
    $password = $_POST['password']; //Getting code/password from login

    $query = $pdo->prepare('SELECT * FROM admin WHERE user_name = :user');
    $query->bindParam(':user', $user);
    $query->execute();

    $admin = $query->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['passw'])) {
        // Set session variables
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        
        header('Location: admin_dashboard.php'); //Redirect to the admin page
        exit();
    } else {
        
        echo "Invalid admin username or password.";// Invalid credentials
    }

} catch (PDOException $e) {
    echo 'Connection Failed: ', $e->getMessage();
}
    
?>

