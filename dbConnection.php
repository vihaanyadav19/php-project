<?php
$host = 'database-1.c5u0eaksq7xf.us-east-2.rds.amazonaws.com'; // RDS endpoint
$user = 'admin';                 // Master username
$password = 'ChdqF0d2x33smBA3YkmS';  // Master password
$database = 'php';      // Database name

// Open a new connection to the MySQL server
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>

