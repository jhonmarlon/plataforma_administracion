<?php
session_start();

if ($_SESSION["authenticated"] == 1) {

    include "../../modelo/conexion.php";

    $conn = new conexion();

    $fecha_limite = $_POST["fecha_limite"];
    $id_usuario = $_POST["id_usuario"];
    $id_vendedor = $_POST["id_vendedor"];
    $tipo_vendedor = $_POST["tipo_vendedor"];

    $detalle_vendedor_por_fecha = $conn->getDetalleCuentaVendedorFecha
            ($id_vendedor, $tipo_vendedor, $fecha_limite);
}
?>
<input type="hidden" value="<?php echo $id_usuario ?>" id="id_usuario">
<input type="hidden" value="<?php echo $id_vendedor ?>" id="id_vendedor">
<input type="hidden" value="<?php echo $tipo_vendedor ?>" id="tipo_vendedor">


<div class="row">
    <div class="row">
        <?php
        if ($tipo_vendedor == "1") {
            ?>

            <div class='datagrid'>
                <div style=' width: 101.5%; height:280px; overflow-y: scroll;'> 
                    <table>
                        <thead>
                            <tr>
                                <th>N° Cuentas</th>
                                <th>Valor Unitario</th>
                                <th>Total</th>
                                <th>Fecha Compra</th>
                                <th>Fecha Límite</th>
                                <th>Estado</th>

                            </tr>
                        </thead>
                        <body>
                            <?php
                            $aux = 0;
                            $i = 1;
                            while ($detalle = $detalle_vendedor_por_fecha->fetch_assoc()) {
                                $fecha = $detalle["fecha_limite_pago"];
                                ?>
                            <tr>
                                <td><label><?php echo $detalle["cant_cuentas_compradas"] ?></label></td>
                                <td><label><?php echo "$" . $detalle["valor_unitario"] ?></label></td>
                                <td><label><?php echo "$" . $detalle["total_pagar"] ?></label></td>
                                <td><label><?php echo $detalle["fecha_compra"] ?></label></td>
                                <td><label><?php echo $detalle["fecha_limite_pago"] ?></label></td>
                                <td><label><font color='red'>Pendiente</font></label></td>

                            </tr>
                            <?php
                            $aux += $detalle["total_pagar"];
                            $i++;
                        }
                        ?>
                        </body>
                    </table>
                    <?php ?>
                    <div class="row">
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
                                            <input type="number" min="0" id="monto_abono" name="monto_abono" class="form-control"  style="width: 100%;" >
                                        </div></td>
                                </tr>
                                <tr>
                                    <td><button type="button" class="btn btn-success" onclick="abona()">Realizar Abono</button></td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>
            </div>

        <?php } else {
            ?>

            <div class="row" style="    margin-left: 0px;">
                <table>
                    <tr> 
                        <td><label><font color='red'>Usuario seleccionado: </font></label></td>
                        <td><label><?php echo $nombre_usuario_sel["nombre"] . " " . $nombre_usuario_sel["apellido"] ?></label></td>
                    </tr>
                </table>
            </div><p>
            <div class='datagrid'>
                <div style=' width: 101.5%; height:280px; overflow-y: scroll;'> 
                    <table>
                        <thead>
                            <tr>
                                <th>N° Cuentas</th>
                                <th>Valor Unitario</th>
                                <th>Total</th>
                                <th>Fecha Compra</th>
                                <th>Estado</th>

                            </tr>
                        </thead>
                        <body>
                            <?php
                            $aux = 0;
                            while ($detalle = $detalle_vend_no_pri->fetch_assoc()) {
                                ?>
                            <tr>
                                <td><label><?php echo $detalle["cant_cuentas_compradas"] ?></label></td>
                                <td><label><?php echo "$" . $detalle["valor_unitario"] ?></label></td>
                                <td><label><?php echo "$" . $detalle["total_pagado"] ?></label></td>
                                <td><label><?php echo $detalle["fecha_compra"] ?></label></td>
                                <td><label><?php
                                        if ($detalle["estado"] == 'C') {
                                            echo "<font color='green'>Cancelado</font>";
                                        } else {
                                            echo "<font color='red'>Pendiente</font>";
                                        }
                                        ?></label></td>

                            </tr>
                            <?php
                            $aux += $detalle["total_pagado"];
                        }
                        ?>
                        </body>
                    </table>


                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>



<script>

    function abona() {
        var fecha_limite = '<?= $fecha ?>';
        var id_usuario = document.getElementById("id_usuario").value;
        var id_vendedor = document.getElementById("id_vendedor").value;
        var tipo_vendedor = document.getElementById("tipo_vendedor").value;
        var monto_abonado = document.getElementById("monto_abono").value;
        var monto_debe = document.getElementById("total").value;

        if (monto_abonado == 0 || monto_abonado == "") {
            alertify.alert('<b>Debe especificar el monto a abonar.</b>');
            return;
        }

        if (monto_abonado < 0) {
            alertify.alert('<b>Debe especificar el monto a abonar correctamente.</b>');
            return;
        }

        if (parseInt(monto_abonado) > monto_debe) {

            alertify.alert('<b>El monto que desea abonar sobrepasa el monto que el usuario está debiendo.<p>' +
                    'Inténtalo nuevamente</b>');
            return;
        }

        alertify.confirm('<b>Desea realizar el abono diligenciado?</b>', function (e) {
            if (e) {
                $.ajax({
                    type: 'POST',
                    url: 'pages/backend/includes/realiza_abono_vendedor.php',
                    data: {
                        fecha_limite: fecha_limite,
                        id_usuario: id_usuario,
                        id_vendedor: id_vendedor,
                        tipo_vendedor: tipo_vendedor,
                        monto_abonado: monto_abonado,
                        monto_debe: monto_debe
                    },

                    success: function (data) {

                      alertify.alert("<b>Abono efectuado correctamente!</b>",function (){
                          window.location.reload();
                      });
                    }

                });
            } else {
                alertify.error('Cancelado');
            }
        });
    }
</script>