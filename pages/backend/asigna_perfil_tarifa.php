<?php
session_start();


if ($_SESSION ['authenticated'] == 1) {
    include '../../modelo/conexion.php';
    $conn = new conexion();

    $id_usuario = $_POST["id_perfil_tarifa"];
    $nombre_perfil = $_POST["nombre_perfil"];
    $id_empresa=$_POST["id_empresa"];
    
    // parametros - 1="usuario o cliente final" 2="id_empresa", 3="id_rol"
    $distribuidores=$conn->getUsuarios("usuario",$id_empresa,"3");
    $clientes=$conn->getUsuarios("cliente",$id_empresa,"0");
    
    //tomamos a todos los usuarios
   // $conn->getInformacionUsuariosEmpresa()
      ?>

    
         
    





<?php    
}?>

        

