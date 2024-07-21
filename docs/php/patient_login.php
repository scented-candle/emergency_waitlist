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

    $fname = $_POST['fname']; //Getting fname from login
    $lname = $_POST['lname']; //Getting lname from login
    $code = $_POST['code']; //Getting code from login

    $query = $pdo->prepare('SELECT * FROM patients WHERE fname = :fname AND lname = :lname'); // Creating the query to see if the patient is in the db
    $query->bindParam(':fname', $fname);
    $query->bindParam(':lname', $lname);
    $query->execute();

    $patient = $query->fetch(PDO::FETCH_ASSOC);

    if ($patient && password_verify($code, $patient['code'])) {
        // Set session variables
        $_SESSION['patient_fname'] = $patient['f_name'];
        $_SESSION['patient_lname'] = $patient['l_name'];
        $_SESSION['patient_checkin'] = $patient['check_in'];

        header('Location: patient_dashboard.php'); //Redirect to the patient page
        exit();
    } else {
        echo "Invalid admin username or password.";// Invalid credentials
    }

} catch (PDOException $e) {
    echo 'Connection Failed: ', $e->getMessage();
}
    
?>

