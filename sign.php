<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'demo';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve phone and password from POST request
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query to check user credentials (using phone and password)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password); // Hash passwords for security in real applications
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            // User found, store user ID in session
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['id'];
            header("Location: login.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
