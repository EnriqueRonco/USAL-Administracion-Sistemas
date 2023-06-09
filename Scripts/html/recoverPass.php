<?php


$usuario = $_POST['usuario'];

// Create connection
$conexion = new mysqli("localhost", "admin", "admin", "eladminDB") or die("Problemas en la conexion.");

// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//sesion_start();

$sql = "UPDATE users SET password=''  WHERE usuario = '$usuario'";
$result = $conexion->query($sql);

if (mysqli_query($conexion, $sql)) {
    echo "Record update successfully";
    Header("Location: recovExito.html");
} else {
    echo "Error updating record: " . mysqli_error($conexion);
    Header("Location: recovError.html");
}

$conn->close();
