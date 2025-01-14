<?php
$host = 'localhost'; // Database host
$db = 'attendance_tracker'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password (replace with your own)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
