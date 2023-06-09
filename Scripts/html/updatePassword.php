<?php

session_start();

$password = $_POST['password'];

$user = $_SESSION['user'];

// Create connection
$conexion = new mysqli("localhost", "vega", "siguiente12", "adsys2019") or die("Problemas en la conexion.");

// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$pass1=base64_encode($password);
$sql = "UPDATE users SET password = '$pass1' WHERE user = '$user'";
$result = $conexion->query($sql);

if (mysqli_query($conexion, $sql)) {
    echo "Record update successfully";
	Header("Location: updateExito.html");
} else {
    echo "Error updating record: " . mysqli_error($conexion);
	Header("Location: updateError.html");
}

$conexion->close();
