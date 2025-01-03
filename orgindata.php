<?php
// Get data from the POST request
$username = $_POST['username'];
$contact = $_POST['contact'];
$location = $_POST['location'];
$t1 = $_POST['t1'];
$u1 = $_POST['u1'];
$t2 = $_POST['t2'];
$u2 = $_POST['u2'];
$t3 = $_POST['t3'];
$u3 = $_POST['u3'];
$t4 = $_POST['t4'];
$u4 = $_POST['u4'];
$t5 = $_POST['t5'];
$u5 = $_POST['u5'];
$t6 = $_POST['t6'];
$u6 = $_POST['u6'];
$t7 = $_POST['t7'];
$u7 = $_POST['u7'];
$t8 = $_POST['t8'];
$u8 = $_POST['u8'];

// Create a database connection
$conn = new mysqli('localhost', 'root', '', 'demo');

// Check if the connection was successful
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO orgindata 
                            (username, contact,location, t1, u1, t2, u2, t3, u3, t4, u4, t5, u5, t6, u6, t7, u7, t8, u8)
                            VALUES (?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters to the prepared statement
    $stmt->bind_param("sssssssssssssssssss", 
        $username, $contact, $location,
        $t1, $u1, $t2, $u2, 
        $t3, $u3, $t4, $u4, 
        $t5, $u5, $t6, $u6, 
        $t7, $u7, $t8, $u8
    );

    // Execute the query
    if ($stmt->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>
