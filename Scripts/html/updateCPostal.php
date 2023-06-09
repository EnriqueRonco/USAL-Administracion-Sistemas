<?php

session_start();

$cPostal = $_POST['cPostal'];

$password = $_SESSION['password'];
$user = $_SESSION['user'];

// Create connection
$conexion = new mysqli("localhost", "admin", "admin", "eladminDB") or die("Problemas en la conexion con la base de datos.");

// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

session_destroy();

$sql = "UPDATE users SET cPostal = '$cPostal'  WHERE user = '$user'";
$result = $conexion->query($sql);

if (mysqli_query($conexion, $sql)) {
    echo "Record update successfully";
	Header("Location: updateExito.html");
} else {
    echo "Error updating record: " . mysqli_error($conexion);
	Header("Location: updateError.html");
}

$conexion->close();