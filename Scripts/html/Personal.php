<?php

session_start();
$user1 = $_SESSION['usuario'];

header("location: /home/$user1/public_html/index.html");

?>
