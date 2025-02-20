<?php
$host = "localhost";
$dbname = "soap_system";
$username = "root";
$password = ""; // Set your MySQL password if needed

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
