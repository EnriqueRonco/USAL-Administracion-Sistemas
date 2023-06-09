<?php
$id = date("Y-m-d H:i:s");
$usuario = $_POST['Usuario'];
$pass = $_POST['Password'];
$pass1 = base64_encode($pass);

$nombre = $_POST['Nombre'];
$apellidos = $_POST['Apellidos'];

$correo = $_POST['correo'];
$cPostal = $_POST['cPostal'];
$ciudad = $_POST['Ciudad'];
$telefono = $_POST['Telefono'];

$host_db = "localhost";
$user_db = "admin";
$pass_db = "admin";
$db_name = "eladminDB";
$tbl_name = "users";

$conexion = new mysqli("localhost", "admin", "admin", "eladminDB") or die("Problemas en la conexion con la base de datos.");

if ($conexion->connect_error) {
    echo "<br />" . "<h2>" . "ERROR en la conexion" . "</h2>";
    die("Connection failed: " . $conexion->connect_error);
}

$query = "INSERT INTO $tbl_name (id, user, password, nombre, apellidos, correo, cPostal, ciudad, telefono, is_admin)
          VALUES ('$id','$usuario', '$pass1', '$nombre', '$apellidos', '$correo', '$cPostal', '$ciudad', '$telefono', 0)";

if ($conexion->query($query) === TRUE) {
    // Ejecutar el script de Perl para la creación del usuario
    $output = array();
    $returnCode = 0;
    exec("perl crear_usuario.pl $usuario", $output, $returnCode);

    if ($returnCode === 0) {
        Header("Location: userRegistrado.html");
    } else {
        Header("Location: errorRegistro.html");
    }
} else if ($usuario == "") {
    $errores[] = true;
    Header("Location: userVacio.html");
} else {
    Header("Location: errorRegistro.html");
}

mysqli_close($conexion);
?>

