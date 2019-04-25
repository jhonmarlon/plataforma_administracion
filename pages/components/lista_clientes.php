<?php
include 'pages/tablero/body_pages.php';

$conn = new conexion();

$id_usuario=$userinfo->id_usuario;

/*if (isset($_SESSION["id_su"])) {
    $id_empresa = $super_userinfo->id_empresa_su;
    $nombre_empresa = $super_userinfo->nombre_empresa_su;
} else {
    $id_empresa = $userinfo->id_empresa_usr;
    $nombre_empresa = $userinfo->nombre_empresa_usr;
}*/

//Traemos los clientes registrados de los usuarios
//$datos_clientes_usuario = $conn->getClientes($id_empresa, "usuario");
//$datos_clientes_superUsr = $conn->getClientes($id_empresa, "super_usuario");

//tomamos la lista de clientes
//$clientes=$conn->getClientes($id_empresa, $tipo_usuario);
$clientes=$conn->getClientes($id_usuario);

?>


<div class="datagrid">
    <div class="search">
        <input type="text" id="txt_buscar" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
        <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
    </div><br><br><br>
    <div style=" width: 101.5%; height:280px; overflow-y: scroll;">

        <table id="tbl_clientes_usuarios">
            <thead>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Celular</th>
            <th>Perfil de Tarifa Asignado</th>
            <th>Fecha Registro</th>
            <th>Editar</th>
            <th>Eliminar</th>
            </thead>

            <tbody>
                <?php while ($datos_clientes = $clientes->fetch_assoc()) { ?>
                    <tr>
                        <td><label><?php echo $datos_clientes["cedula"] ?></label></td>
                        <td><label><?php echo $datos_clientes["nombre"]  ?></label></td>
                        <td><label><?php echo $datos_clientes["usuario"] ?></label></td>
                        <td><label><?php echo $datos_clientes["correo"]  ?></label></td>
                        <td><label><?php echo $datos_clientes["direccion"] ?></label></td>
                        <td><label><?php echo $datos_clientes["telefono"] ?></label></td>
                        <td><label><?php echo $datos_clientes["celular"] ?></label></td>
                        <td><label><?php echo $datos_clientes["nombre_tarifa"] ?></label></td>
                        <td><label><?php echo $datos_clientes["fecha_registro"] ?></label></td>
                        <td><button onclick="editar_tarifa()" id="editar_tarifa" title='Editar Tarifa' type="submit" class="btn btn-default" 
                                    data-target="#edita_tarifa" data-toggle="modal"><img src="dist/img/refresh-icon.png" /></button></td>
                        <td><button onclick="eliminar_tarifa('personalizada', '<?php echo $tarifa_per["id_tarifa_usuario"] ?>')" id="eliminar_tarifa" title='Eliminar Tarifa' type="submit" class="btn btn-default">
                                <img src="dist/img/delete-icon.png" /></button></td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
</div>

<div class="datagrid">
    <h3>Clientes Provenientes de Propietarios <?php echo $nombre_empresa ?></h3>
    <div class="search">
        <input type="text" id="txt_buscar" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
        <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
    </div><br><br><br>
    <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
        <table id="tbl_clientes_usuarios">
            <thead>
            <th>Nombre Propietario</th>
            <th>Correo Propietario</th>
            <th>Cedula Cliente</th>
            <th>Nombre Cliente</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Celular</th>
            <th>Correo</th>
            <th>Valor Cuenta</th>
            <th>Editar</th>
            <th>Eliminar</th>
            </thead>

            <tbody>
                <?php while ($datos_clientes = $datos_clientes_superUsr->fetch_assoc()) { ?>
                    <tr>
                        <td><label><?php echo $datos_clientes["nombre_usuario"] ?></label></td>
                        <td><label><?php echo $datos_clientes["correo_usuario"] ?></label></td>
                        <td><label><?php echo $datos_clientes["cedula_cliente"] ?></label></td>
                        <td><label><?php echo $datos_clientes["nombre_cliente"] . " " . $datos_clientes["apellido_cliente"] ?></label></td>
                        <td><label><?php echo $datos_clientes["direccion_cliente"] ?></label></td>
                        <td><label><?php echo $datos_clientes["telefono_cliente"] ?></label></td>
                        <td><label><?php echo $datos_clientes["celular_cliente"] ?></label></td>
                        <td><label><?php echo $datos_clientes["correo_cliente"] ?></label></td>
                        <td><label><?php echo "$ " . $datos_clientes["valor_cuenta_cliente"] ?></label></td>
                        <td><button onclick="editar_tarifa()" id="editar_tarifa" title='Editar Tarifa' type="submit" class="btn btn-default" 
                                    data-target="#edita_tarifa" data-toggle="modal"><img src="dist/img/refresh-icon.png" /></button></td>
                        <td><button onclick="eliminar_tarifa('personalizada', '<?php echo $tarifa_per["id_tarifa_usuario"] ?>')" id="eliminar_tarifa" title='Eliminar Tarifa' type="submit" class="btn btn-default">
                                <img src="dist/img/delete-icon.png" /></button></td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
</div>