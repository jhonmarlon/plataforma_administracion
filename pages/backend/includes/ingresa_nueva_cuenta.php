<?php

session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();
    
    $f_creacion_net=$_POST['f_creacion_net'];
    $user_net=$_POST['user_net'];
    $pass_net=$_POST['pass_net'];
    $crea_cuenta_net=$_POST['crea_cuenta_net'];
    $periodo_uso=$_POST['periodo_uso'];
    
    //para obtener la fecha de vencimiento , sumamos a la fecha de creacion los dias 
    //del periodo de uso
    $fecha_vecimiento= strtotime('+'.$periodo_uso." day", strtotime($f_creacion_net));
    $fecha_vecimiento = date('Y-m-j' , $fecha_vecimiento);
    
    

    //insertamos los datos de la cuenta en la base de datos
    $conn->insertCuentaNetflixAct($f_creacion_net, $user_net, $pass_net,$crea_cuenta_net,$periodo_uso,$fecha_vecimiento);
    
    //$conn->cerrar();
   // <---------------PARAMETROS DEL METODO ANTERIOR ---------------------------------->
    
     //crea cuenta
     /*   $crea_cuenta = $_POST["crea_cuenta"];
    //gmail
    $fecha_gmail = $_POST["fecha_gmail"];
    $nombre_gmail = $_POST["nombre_gmail"];
    $apellido_gmail = $_POST["apellido_gmail"];
    $correo_gmail = $_POST["correo_gmail"];
    $clave_gmail = $_POST["clave_gmail"];
    $linea_gmail = $_POST["linea_gmail"];
    $ecard_gmail = $_POST["ecard_gmail"];
    //netflix
    $f_creacion_net = $_POST["f_creacion_net"];
    $csv_net = $_POST["csv_net"];
    $user_net = $_POST["user_net"];
    $pass_net = $_POST["pass_net"];

    //insertamos los datos de la cuenta de gmail
    $conn->insertCuentaGmail($fecha_gmail, $nombre_gmail, $apellido_gmail, $correo_gmail, $clave_gmail, $linea_gmail, $ecard_gmail);
    //toma la cuenta de gmail asociada y crea netflix.
    $id_gmail = $conn->conexion->query("SELECT id_cuenta_gmail FROM cuenta_gmail
             order by id_cuenta_gmail desc limit 1");
    $id = $id_gmail->fetch_array();

    $id_cuenta_gmail = $id[0];
    //insertamos los datos de la cuenta de netflix con su respectivo id de gmail
    $conn->insertCuentaNetflix($id_cuenta_gmail, $f_creacion_net, $csv_net, $user_net, $pass_net, $crea_cuenta);
*/
    //<--------------------------------------------------------------------->

    
    
    
    
    $conn->cerrar();
}