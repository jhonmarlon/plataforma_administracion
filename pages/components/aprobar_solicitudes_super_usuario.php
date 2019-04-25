<?php
include 'pages/components/metricas_super_usuario.php';

$conn = new conexion();

if (isset($_SESSION["id_su"])) {
    $nombre_empresa = $super_userinfo->nombre_empresa_su;
    $id_empresa = $super_userinfo->id_empresa_su;
} else {
    $nombre_empresa = $userinfo->nombre_empresa_usr;
    $id_empresa = $userinfo->id_empresa_usr;
}

$solicitudCliente = $conn->getSolicitudCliente($id_empresa);
?>


<div class="datagrid">
    <h3>Solicitudes - Nuevos Clientes <?php echo $nombre_empresa ?></h3>

    <div class="search">
        <input type="text" id="txt_buscar" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
        <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
    </div><br><br><br>
    <div style=" width: 101.5%; height:280px; overflow-y: scroll;">

        <table id="tbl_clientes_usuarios">
            <thead>
            <th>Cédula Usuario</th>
            <th>Nombre Usuario</th>
            <th>Cédula Cliente</th>
            <th>Nombre Cliente</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Celular</th>
            <th>Correo</th>
            <th>Valor Cuenta</th>
            <th>Fecha Solicitud</th>
            <th>Aprobar</th>
            <th>Negar</th>
            </thead>

            <tbody>
                <?php while ($solicitud = $solicitudCliente->fetch_assoc()) { ?>
                    <tr>
                        <td><label><?php echo $solicitud["cedula_usuario"] ?></label></td>
                        <td><label><?php echo $solicitud["nombre_usuario"] ?></label></td>
                        <td><label><?php echo $solicitud["cedula_cliente"] ?></label></td>
                        <td><label><?php echo $solicitud["nombre_cliente"] ?></label></td>
                        <td><label><?php echo $solicitud["direccion_cliente"] ?></label></td>
                        <td><label><?php echo $solicitud["telefono_cliente"] ?></label></td>
                        <td><label><?php echo $solicitud["celular_cliente"] ?></label></td>
                        <td><label><?php echo $solicitud["correo_cliente"] ?></label></td>
                        <td><label><?php echo "$ " . $solicitud["valor_cuenta_cliente"] ?></label></td>
                        <td><label><?php echo $solicitud["fecha_registro"] ?></label></td>
                        <td><button onclick="aprueba_solicitud()" id="aprueba_solicitud" title='Aprobar Solicitud' type="submit" class="btn btn-default">
                                <img src="dist/img/active.png" /></button></td>
                        <td><button onclick="negar_solicitud()" id="negar_solicitud" title='Negar Solicitud' type="submit" class="btn btn-default">
                                <img src="dist/img/delete-icon.png" /></button></td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
</div>

<div class="datagrid">
    <h3>Solicitudes - Nuevos Vendedores <?php echo $nombre_empresa ?></h3>
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

            </tbody>

        </table>
    </div>
</div>