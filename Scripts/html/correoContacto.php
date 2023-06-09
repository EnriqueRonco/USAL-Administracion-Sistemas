<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nombre = $_POST["Nombre"];
    $correo = $_POST["correo"];
    $Mensaje =  $_POST["Mensaje"];
    
    // Ruta al ejecutable de Perl y el script a ejecutar
    $perlBin = "/usr/bin/perl";
    $perlScript = "correoContacto.pl";
    
    // Escapar los parámetros para evitar problemas con caracteres especiales
    $NombreEscapado = escapeshellarg($Nombre);
    $correoEscapado = escapeshellarg($correo);
    $MensajeEscapado = escapeshellarg($Mensaje);
    
    // Construir el comando con los parámetros escapados
    $command = "$perlBin $perlScript $NombreEscapado $correoEscapado $MensajeEscapado";
    
    // Ejecutar el comando y capturar la salida
    $output = shell_exec($command);
    
    echo "<pre>$output</pre>";
    
    // Redirigir al usuario a una página de confirmación
    header("Location: confirmacion.html");
    exit;
}
?>
