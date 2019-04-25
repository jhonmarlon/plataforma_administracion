<?php
include '../../modelo/conexion.php';

$id_cliente = $_POST["id_cliente"];
$id_usuario = $_POST["id_usuario"];

$conn = new conexion();

$detalle_cliente = $conn->getDetalleCuentaCliente($id_cliente);

$nombre = $conn->conexion->query("SELECT nombre, apellido from cliente where id_cliente='$id_cliente'");
$nombre_cliente_sel = $nombre->fetch_assoc();

$registro_abono_cliente = $conn->getRegistroAbonoCliente($id_cliente);

if (mysqli_num_rows($detalle_cliente) == 0) {

    echo "<script> 
                  alertify.alert('<b>El Cliente elegido , no tiene ningún detalle pendiente</b>');
            </script>";
    return;
}
?>

<input type="hidden" value="<?php echo $id_usuario ?>" id="id_usuario">
<input type="hidden" value="<?php echo $id_cliente ?>" id="id_cliente">



<div class="row" style="    margin-left: 0px;">

    <table>
        <tr> 
            <td><label><font color='red'>Cliente seleccionado: </font></label></td>
            <td><label><?php echo $nombre_cliente_sel["nombre"] . " " . $nombre_cliente_sel["apellido"] ?></label></td>
        </tr>
    </table>
    <br><div class="datagrid">
        <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
            <table>
                <thead>
                <th>Fecha Venta</th>
                <th>N° Cuentas</th>
                <th>Valor Unitario</th>
                <th>Total</th>
                <th>Ganancia</th>
                <!--<th>Monto Pagado</th>
                <th>Monto Restado</th> -->
                <th>Estado</th>
                </thead>
                <tbody>
                    <?php
                    $aux = 0;
                    while ($detalle = $detalle_cliente->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><label><?php echo $detalle["fecha_venta"] ?></label></td>
                            <td><label><?php echo $detalle["cantidad_cuentas"] ?></label></td>
                            <td><label><?php echo "$" . $detalle["valor_unitario"] ?></label></td>
                            <td><label><?php echo "$" . $detalle["total"] ?></label></td>
                            <td><label><?php echo "$" . $detalle["ganancia"] ?></label></td>
                            <!--<td><label><?php echo "$" . $detalle["monto_pagado"] ?></label></td>
                            <td><label><?php echo "$" . $detalle["monto_restado"] ?></label></td> -->
                            <td><label><font color='red'>Pendiente</font></label></td>

                        </tr>
                        <?php
                        $aux += $detalle["monto_restado"];
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<br><div class="row">
    <div class="col-md-6">
        <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
            
            <table>
                <tr>
                    <td><label><font color='red'>Total a pagar: </font></label></td>
                    <td><div class="input-group"> 
                            <span class="input-group-addon">$</span>
                            <input type="number" readonly value="<?php echo $aux ?>" id="total" name="total" class="form-control"  style="width: 100%;" >
                        </div></td>                    
                </tr>

                <tr>
                    <td><label><font color='red'>Monto a Abonar: </font></label></td>
                    <td><div class="input-group"> 
                            <span class="input-group-addon">$</span>
                            <input type="number"  id="monto_abono" name="monto_abono" class="form-control"  style="width: 100%;" >
                        </div></td>
                </tr>
                <tr>
                    <td><button type="button" class="btn btn-success" onclick="abona()">Realizar Abono</button></td>

                </tr>

            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="datagrid">
            <table>
                <label>Historial Abonos <font color='red'>Mes Actual</font></label>
                <thead>
                    <tr>
                        <th>Abona</th>
                        <th>Registra</th>
                        <th>Debía</th>
                        <th>Abonó</th>
                        <th>Resta</th>
                        <th>Fecha Abono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($res = $registro_abono_cliente->fetch_assoc()) { ?>
                        <tr>
                            <td><label><?php echo $res["nombre_abona"] . " " . $res["apellido_abona"] ?></label></td>
                            <td><label><?php echo $res["nombre_registra_abono"] . " " . $res["apellido_registra_abono"] ?></label></td>
                            <td><label><?php echo "$" . $res["monto_debe"] ?></label></td>
                            <td><label><?php echo "$" . $res["monto_abono"] ?></label></td>
                            <td><label><?php echo "$" . $res["monto_resta"] ?></label></td>
                            <td><label><?php echo $res["fecha_abono"] ?></label></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>   




<script>

    function abona() {
        var id_usuario = document.getElementById("id_usuario").value;
        var id_cliente = document.getElementById("id_cliente").value;
        var monto_abonado = parseInt(document.getElementById("monto_abono").value);
        var total = parseInt(document.getElementById("total").value);

        if (monto_abonado == "") {
            alertify.alert('<b>Debe especificar el monto a abonar. <p> Inténtalo nuevamente!</b>');
            return;
        }
        if (monto_abonado > total) {
            alertify.alert('<b>El monto a abonar <font color="red">es mayor</font> al monto total a pagar.<p> Inténtalo nuevamente!</b>');
            return;
        }

        alertify.confirm('<b>Esta a punto de realizar un abono de <font color="red">$' + monto_abonado + ' </font>Desea continuar? ', function (e) {
            if (e) {
                var parametros = {
                    "id_usuario": id_usuario,
                    "id_cliente": id_cliente,
                    "total": total,
                    "monto_abonado": monto_abonado

                };
                $.ajax({
                    data: parametros,
                    url: 'pages/backend/includes/realiza_abono_cliente.php',
                    type: 'post',
                    success: function (response) {

                        $("#resultado1").html(response);
                        alertify.alert("<P align=center><b>Abono efectuado correctamente!", function () {

                            window.setTimeout('location.reload()');
                        });
                    }

                });
            } else {
                alertify.error('Cancelado');
            }
        });
    }
</script>

<div id="resultado1"></div>