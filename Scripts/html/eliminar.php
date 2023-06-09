<?php

session_start();

$password = $_POST['password'];
$user = $_POST['user'];

// Create connection
$conexion = new mysqli("localhost", "admin", "admin", "eladminDB") or die("Problemas en la conexion con la base de datos.");

// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

session_destroy();

$sql = "DELETE FROM users where user = '$user' and password='$password'";
$result = $conexion->query($sql);

if (mysqli_query($conexion, $sql)) {
    echo "Record deleted successfully";
	Header("Location: deleteExito.html");
} else {
    echo "Error deleting record: " . mysqli_error($conexion);
	Header("Location: deleteError.html");
}

$conexion->close();