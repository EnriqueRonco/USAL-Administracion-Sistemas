<?php


$password = $_POST['password'];
$user = $_POST['Usuario'];

// Create connection
$conexion = new mysqli("localhost", "admin", "admin", "eladminDB") or die("Problemas en la conexion con la base de datos.");

// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//sesion_start();
$pass1=base64_encode($password);
$sql = "SELECT * FROM users where user = '$user' and password='$pass1'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

            session_start();
            $_SESSION['Usuario']=$_POST['Usuario'];
            $_SESSION['password']=$_POST['password'];
    		Header("Location: usuario.php");
    }
} 
else {
    Header("Location: loginError.html");
}
$conexion->close();
