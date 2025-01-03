<?php
$username = $_POST['username'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$bloodgroup = $_POST['bloodgroup'];
$password = $_POST['password'];

$conn = new mysqli('localhost','root','','demo');
if($conn->connect_error){
    die('connection failed : '.$conn->connect_error);
}
else{
    $stmt = $conn->prepare("insert into users (username,email,gender,bloodgroup,password) values(?,?,?,?,?)");
    $stmt->bind_param("sssss",$username,$email,$gender,$bloodgroup,$password);
    $stmt->execute();
    echo "Sign up is completed!, Go to sign-in";
    $stmt->close();
    $conn->close();
}
?>
