<?php
include("../modelo/conexion.php");
$correo = $_POST['correo'];
$password = $_POST['password']; 
$wish = new conexion; 
$wish->login($correo, $password);
$wish->cerrar(); 
?>