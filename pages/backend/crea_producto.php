<?php
require '../../modelo/conexion.php';

$nombre_producto=$_POST["nombre_producto"];
$categoria_producto=$_POST["categoria_producto"];
$sub_categoria_producto=$_POST["sub_categoria_producto"];
$imagen1=$_FILES["imagen1"];
$imagen2=$_FILES["imagen2"];
$imagen3=$_FILES["imagen3"];

$precio=$_POST["precio"];
$descripcion=$_POST["descripcion"];
$palabra_clave=$_POST["palabra_clave"];
$id_usuario=$_POST["id_usuario"];


print_r($imagen1);
print_r($imagen2);

print_r($imagen3);

echo $nombre_producto."<br>";
echo $categoria_producto."<br>";
echo $sub_categoria_producto."<br>";
echo $precio."<br>";
echo $descripcion."<br>";
echo $palabra_clave."<br>";
echo $id_usuario."<br>";



      /*   formData.append('nombre_producto', nombre_producto);
                formData.append('categoria_producto', categoria_producto);
                formData.append('sub_categoria_producto', sub_categoria_producto);
                formData.append('imagen1', imagen1);
                formData.append('imagen2', imagen2);
                formData.append('imagen3', imagen3);
                formData.append('precio', precio);
                formData.append('descripcion', descripcion);
                formData.append('palabra_clave', palabra_clave);
                formData.append('id_usuario', id_usuario);*/
