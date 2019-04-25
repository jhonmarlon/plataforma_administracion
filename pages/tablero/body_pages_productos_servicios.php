<?php

session_start();
if ($_SESSION ['authenticated'] == 1) {

//recibimos los valores de la categoria y la subcategoria
    if (isset($_POST["tipo"]) && isset($_POST["id_categoria"]) && isset($_POST["id_subcategoria"])) {
        echo "ya estoy aca";

        $tipo = $_POST["tipo"];
        $id_categoria = $_POST["id_categoria"];
        $id_subcategoria = $_POST["id_subcategoria"];


        //validamos si es un producto o un servicio
        if ($tipo == "producto") {

            //validamos la categoria
            //1=tecnologia ,2=alimentos, 3=ropa
            if ($id_categoria == 1) {

                //validamos la subcategoria
                //1=computadores,2=celulares
                //COMPUTADORES
                if ($id_subcategoria == 1) {
                    echo "computadores";
                }//FIN COMPUTADORES
                
                //CELULARES
                elseif ($id_subcategoria == 2) {
                    echo"pages/components/vistas_productos/categoria_tecnologia/celulares.php";
                }//FIN CELULARES
            } elseif ($id_categoria == 2) {
                
            }
        }// si es servicio
        else {
            
        }
    }
}