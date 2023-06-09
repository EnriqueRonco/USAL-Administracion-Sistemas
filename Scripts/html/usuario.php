<?php
$conexion = new mysqli("localhost", "admin", "admin", "eladminDB") or die("Problemas en la conexion con la base de datos.");

// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

session_start();

if(!$_SESSION){
	Header("location: index.html");
}

$user=$_SESSION['user'];
Header("location: usuario.html");





?>
