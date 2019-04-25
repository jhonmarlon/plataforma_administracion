<?php
session_start();

if ($_SESSION ['authenticated'] == 1) {
    include '../../modelo/conexion.php';
    $conn = new conexion();

    $id_usuario = $_POST["id_usuario"];

    $estado_cuenta = $conn->conexion->query("select count(b.id_respuesta_solicitud) from solicitud a,
    respuesta_solicitud b where a.id_solicitud=b.id_solicitud and a.id_cliente_usuario='$id_usuario'");

    $estado = $estado_cuenta->fetch_array();
    //echo $estado[0];

    if ($estado[0] == 0) {
        ?>


        <label id="lbl_historial" style="font-size: 20px;color: darkred;">El usuario no tiene ningun historial crediticio.</label>

        <?php
    } else {

        $estado_cuenta_pendiente = $conn->conexion->query("select a.* from detalle_cuenta_usuario a, solicitud b,respuesta_solicitud c 
where b.id_cliente_usuario='$id_usuario' and b.id_solicitud=c.id_solicitud 
and c.id_respuesta_solicitud=a.id_respuesta_solicitud and a.estado='P';");
        ?>
        <div class="datagrid">
            <table>
                <thead>

                    <tr>
                        <th>Fecha de compra</th>
                        <th>N° Cuentas</th>
                        <th>Valor Unitario</th>
                        <th>Total a pagar</th>
                        <th>Tipo de pago</th>
                        <th>Ganancia</th>
                        <th>Monto Pagado</th>
                        <th>Monto Restado</th>
                        <th>Estado</th>

                    </tr>

                </thead>
                <tbody>
                    <?php $total=0; while ($cuentas_pendientes = $estado_cuenta_pendiente->fetch_assoc()) {
                        ?>
                        <tr>

                            <td><label><?php echo $cuentas_pendientes["fecha_compra"] ?></label></td>
                            <td><label><?php echo $cuentas_pendientes["cant_cuentas_solicitadas"] ?></label></td>
                            <td><label><?php echo "$".$cuentas_pendientes["valor_unitario"] ?></label></td>
                            <td><label><?php echo "$".$cuentas_pendientes["total_pagar"] ?></label></td>
                            <td><label style="color: green"><?php echo $cuentas_pendientes["tipo_pago"] ?></label></td>
                            <td><label><?php echo "$".$cuentas_pendientes["ganancia"] ?></label></td>
                            <td><label><?php echo "$".$cuentas_pendientes["monto_pagado"] ?></label></td>
                            <td><label><?php echo "$".$cuentas_pendientes["monto_restado"] ?></label></td>
                            <td><label style="color: red">Pendiente</label></td>

                        </tr>

                    <?php $total+=$cuentas_pendientes["monto_restado"];}
                    
                    ?>
                        
                </tbody>
                
            </table>
        </div><br>
        <b><label style="margin-left: 20px">Total restado: <?php echo "$ ".$total?></label></b>

        <?php
    }
}
?>
        


