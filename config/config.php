<?php
/*foreach ($lines as $line){

}

$dbHost = $_ENV['DB_HOST'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];
$dbName = $_ENV['DB_NAME'];

// Now you can use these variables to connect to your database
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");*/
$conn = mysqli_connect("localhost", "vps", "Vf-9^9$TrKsqm^V", "lyrical_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");
