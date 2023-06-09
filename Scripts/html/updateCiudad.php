<?php

session_start();

$ciudad = $_POST['ciudad'];

$password = $_SESSION['password'];
$user = $_SESSION['user'];

// Create connection
$conexion = new mysqli("localhost", "admin", "admin", "eladminDB") or die("Problemas en la conexion con la base de datos.");

// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE users SET ciudad = '$ciudad'  WHERE user = '$user'";
$result = $conexion->query($sql);

if (mysqli_query($conexion, $sql)) {
    echo "Record update successfully";
	Header("Location: updateExito.html");
} else {
    echo "Error updating record: " . mysqli_error($conexion);
	Header("Location: updateError.html");
}

$conexion->close();