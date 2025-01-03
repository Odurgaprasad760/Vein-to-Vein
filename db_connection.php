<?php
// Database credentials
$servername = "localhost";  // Your database server, usually localhost
$username = "root";         // Database username
$password = "";             // Database password (leave empty for localhost)
$dbname = "demo";           // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
