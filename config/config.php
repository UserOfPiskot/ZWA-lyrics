<?php
$dbHost = $_ENV['DB_HOSTNAME'];
$dbUser = $_ENV['DB_USERNAME'];
$dbPass = $_ENV['DB_PASSWORD'];
$dbName = $_ENV['DB_DATABASE'];

// Now you can use these variables to connect to your database
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "UTF8");