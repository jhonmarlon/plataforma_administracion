<?php
include 'pages/components/metricas_distribuidor.php';

$conn = new conexion();

$user_id = $userinfo->user_id;

//verificamos si es un usuario privilegiado
$privilegiado = $conn->esPrivilegiado($id_usuario);
$pri = $privilegiado->fetch_array();

//saldo maximo que puede tener como deuda, 
$saldo_max = $conn->getSaldoMaximoPermitido($user_id);
$saldo_perm = $saldo_max->fetch_array();

$saldo_maximo_permitido = $saldo_perm[0] + ($saldo_perm[0] * 0.1);

$num_detalle=$conn->getContDetalleCuentaVendedor($user_id, $pri[0]);
$cant_detalle=$num_detalle->fetch_array();
$detalle=$conn->getDetalleCuentaVendedor($user_id,$pri[0]);

if ($cant_detalle[0] == 0) {

    echo "<script> alertify.alert('<P align = center><b>No tienes ningún detalle generado actualmente.', function () { location.href='index.php'; }); </script>";

    return;
}
?>
<div class='datagrid'>
    <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
        <table id="estado_cuenta_vendedor">

            <thead style="width: 100%">
                <tr>
                    <th>Fecha de compra</th>
                    <th>N° Cuentas Compradas</th>
                    <th>Valor por Cuenta</th>
                    <th>Total Pagar</th>
                    <th>Fecha Límite de Pago</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $total_acumulado = 0;
                while ($res = $detalle->fetch_assoc()) {
                    $total_acumulado += $res["total_pagar"];
                    ?>

                    <tr>
                        <td><label name="fecha_compra" id="f_compra<?php echo $res["id_detalle_cuenta_usuario_pri_act"]; ?>">
                                <?php echo $res["fecha_compra"]; ?></label></td>
                        <td><label name="num_cuentas" id="num_cuentas<?php echo $res["id_detalle_cuenta_usuario_pri_act"]; ?> ">
                                <?php echo $res["cant_cuentas_compradas"]; ?></label></td>
                        <td><label name="valor_cuenta" id="valor_cuenta<?php echo $res["id_detalle_cuenta_usuario_pri_act"]; ?>">
                                <?php echo "$" . $res["valor_unitario"] ?></label></td>
                        <td><label name="total" id="total<?php echo $res["id_detalle_cuenta_usuario_pri_act"]; ?>">
                                <?php echo "$" . $res["total_pagar"] ?></label></td>
                        <td><label name="f_limite" id="f_limite<?php echo $res["id_detalle_cuenta_usuario_pri_act"]; ?>">
                                <?php echo $res["fecha_limite_pago"] ?></label></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table><p>
        <div class="row">
            <div class="col-md-6">

                <table  id='tbl_detalle'  style="text-align: center">
                    <thead> 
                        <tr>
                            <th colspan="2"><h4>Detalles de cuenta</label></h4></th>
                    </tr>
                    </thead>
                    <tr>
                        <td><strong><h4 style="color: red">Total a pagar: </h4></strong></td>
                        <td><label style="color: black"><?php echo "$" . $total_acumulado ?></label></td>
                    </tr>
                    <tr>
                        <td><strong><h4 style="color: red">Saldo Máximo de Crédito: </h4></strong></td>
                        <td><label style="color: black"><?php echo "$" . $saldo_maximo_permitido ?></label></td>
                    </tr>

                </table>
            </div>
            <div class="col-md-6" style="text-align: center">
                <label><h3><font color="red">Importante!</font></h3><p>Recuerde que si el saldo máximo de Credito <font color="red">es superado</font> por el "Total a Pagar", no podrá
                        adelantar saldo ni realizar compra de cuentas hasta que realice un abono o se ponga a paz y salvo.</label>

            </div>
        </div>
    </div>

</div>






