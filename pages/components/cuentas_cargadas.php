<link rel="stylesheet" href="dist/css/data_tables.css">


    <?php

    include "pages/components/metricas_administrador.php";
    
function printCuentasCreadas($conn, $id_usuario) {

    $consulta = "select a.*,b.id_cuenta_netflix,b.fecha_creacion as 'f_creacion_net',b.csv,b.user_netflix,
b.pass_netflix,b.id_usuario,b.id_cliente,b.estado as 'estado_net' from cuenta_gmail a,cuenta_netflix b 
        where a.id_cuenta_gmail=b.id_cuenta_gmail order by b.id_cuenta_gmail desc";

    if ($consulta = $conn->conexion->query($consulta)) {
        $i = 1;
        while ($obj = $consulta->fetch_object()) {
            ?>
            <tr>
                <td><label id="fecha_gmail<?php echo $i ?>" title="<?php echo $i ?>"><?php printf($obj->fecha_creacion); ?></label></td>
                <td><label id="nombre_gmail<?php echo $i ?>"><?php printf($obj->nombre); ?></label></td>
                <td><label id="apellido_gmail<?php echo $i ?>"><?php printf($obj->apellido); ?></label></td>
                <td><label id="correo_gmail<?php echo $i ?>"><?php printf($obj->correo); ?></label></td>
                <td><label id="clave_gmail<?php echo $i ?>"><?php printf($obj->clave); ?></label></td>
                <td><label id="linea_gmail<?php echo $i ?>"><?php printf($obj->linea); ?></label></td>
                <td><label id="num_ecard_gmail<?php echo $i ?>"><?php printf($obj->num_ecard); ?></label></td>
                <td><label id="id_cunta_net<?php echo $i ?>"><?php printf($obj->id_cuenta_netflix); ?></label></td>
                <td><label id="fecha_net<?php echo $i ?>"><?php printf($obj->f_creacion_net); ?></label></td>
                <td><label id="csv_net<?php echo $i ?>"><?php printf($obj->csv); ?></label></td>
                <td><label id="user_net<?php echo $i ?>"><?php printf($obj->user_netflix); ?></label></td>
                <td><label id="pass_net<?php echo $i ?>"><?php printf($obj->pass_netflix); ?></label></td>
                <td><label id="id_usu_net<?php echo $i ?>"><?php
                        if (($obj->id_usuario) == '0') {
                            echo "<font color='red'><b>No tomada</b></font>";
                        } else {
                            
                        }
                        ?></label></td>
                <td><label id="id_cli_net<?php echo $i ?>"><?php
                        if (($obj->id_cliente) == '0') {
                            echo "<font color='red'><b>No vendida</b></font>";
                        } else {
                            
                        }
                        ?></label></td>
                <td><label id="estado_net<?php echo $i ?>"><?php
                        if (($obj->estado_net) != '0') {
                            echo "<font color='black'><b>Activa</b></font>";
                        } else {
                            echo "<font color='red'><b>Inactiva</b></font>";
                        }
                        ?></label></td>
                <td>
                    <a href="#" data-target="#editar_cuenta" data-toggle="modal" onclick="upd('<?php printf($obj->fecha_creacion); ?>', '<?php printf($obj->nombre); ?>',
                                                '<?php printf($obj->apellido); ?>', '<?php printf($obj->correo); ?>', '<?php printf($obj->clave); ?>', '<?php printf($obj->linea); ?>',
                                                '<?php printf($obj->num_ecard); ?>', '<?php printf($obj->id_cuenta_netflix); ?>', '<?php printf($obj->f_creacion_net); ?>',
                                                '<?php printf($obj->csv); ?>', '<?php printf($obj->user_netflix); ?>', '<?php printf($obj->pass_netflix); ?>')"
   <td> <button onclick="datos_modal_editar(<?php echo $resultado["id"] ?>)" class="btn btn-default" 
                                                     data-target="#edita_analisis" data-toggle="modal" title="Editar cuenta" ><img src="dist/img/refresh-icon.png" /></button></td>
                    <!--<button onclick="editar_cuenta()">Editar</button></td>-->



            </tr>
            <?php
            $i++;
            //printColaboradores($obj->cedula,$conn);
        }
        $consulta->close();
    }
}
?>


<!-- Map will be created here -->
<div class="datagrid">
    <div style=" width: 101.5%; height:100%; overflow-y: scroll;">

        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr >
                    <td class="info_table" colspan="8" ><h3>Información cuenta Gmail</h3></td>
                    <td class="info_table" colspan="9"><h3>Información cuenta Netflix</h3></td>
                <tr>

                <tr>
                    <!-- info cuenta gmail-->

                    <th><strong>Creación</strong></th>
                    <th><strong>Nombre</strong></th>
                    <th><strong>Apellido</strong></th>
                    <th><strong>Correo</strong></th>
                    <th><strong>Clave</strong></th>
                    <th><strong>Linea</strong></th>
                    <th><strong>Num ECard</strong></th>
                    <!-- info cuenta netflix-->
                    <th><b>Cuenta</b></th>
                    <th><strong>Creación</strong></th>
                    <th><strong>CSV</strong></th>
                    <th><strong>User</strong></th>
                    <th><strong>Pass</strong></th>
                    <th><strong>Tomada</strong></th>
                    <th><strong>Vendida</strong></th>
                    <th><strong>Estado</strong></th>
                    <th><strong>Editar</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new conexion();
                $id_usuario = $userinfo->user_id;

                printCuentasCreadas($conn, $id_usuario);
                ?>
            </tbody>
        </table>
    </div>

</div>