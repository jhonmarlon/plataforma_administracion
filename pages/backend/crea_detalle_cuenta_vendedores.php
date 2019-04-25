
<link rel="stylesheet" href="plugins/alertify/alertify.default.css">
<link rel="stylesheet" href="../../plugins/alertify/alertify.core.css">
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../../plugins/alertify/alertify.min.js"></script>
<?php
session_start();

if ($_SESSION["authenticated"] == 1) {

    include '../../modelo/conexion.php';

    $conn = new conexion();

    $id_vendedor = $_POST["id_vendedor"];
    $id_usuario = $_POST["id_usuario"];
    $tipo_vendedor = $_POST["tipo"];
//generamos el detalle
    $nombre = $conn->conexion->query("SELECT nombre, apellido from usuario where id_usuario='$id_vendedor'");
    $nombre_usuario_sel = $nombre->fetch_assoc();

//toma los abonos realizados
    $registro_abono = $conn->getRegistroAbono($id_vendedor);
    ?>
    <input type="hidden" value="<?php echo $id_usuario ?>" id="id_usuario">
    <input type="hidden" value="<?php echo $id_vendedor ?>" id="id_vendedor">
    <input type="hidden" value="<?php echo $tipo_vendedor ?>" id="tipo_vendedor">

    <?php
    $grupo_detalle = $conn->conexion->query("SELECT fecha_limite_pago,"
            . "sum(total_pagar) as 'total' FROM `detalle_cuenta_usuario_pri_act` "
            . "where id_usuario_compra='$id_vendedor' and estado='P' GROUP by fecha_limite_pago");


    $detalle_ved_pri = $conn->getContDetalleCuentaVendedor($id_vendedor, $tipo_vendedor);
    $num_detalle = $detalle_ved_pri->fetch_array();

    if ($num_detalle[0] == 0) {
        echo "<script>
                                alertify.alert('<b>El Usuario elegido , no tiene ningún detalle pendiente</b>');
                            </script>";
        return;
    }
    ?>
    <div class="row" style="    margin-left: 0px;">

        <table>
            <tr> 
                <td><h4><font color='red'>Usuario seleccionado: </h4></label></td>
                <td><h4><?php echo $nombre_usuario_sel["nombre"] . " " . $nombre_usuario_sel["apellido"] ?></h4></td>
            </tr>
        </table>
    </div><p>

    <h3>Detalles pendientes a pagar <font color='red'>(Por Fechas límites)</h3></label><br>
    <div class="datagrid">
        <table>
            <thead>
            <th><label>Fecha limite de pago</label></th>
            <th><label>Monto pendiente a pagar</label></th>
            <th><label>Abonar</label></th>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($grupo = $grupo_detalle->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><label id="fecha_limite<?php echo $i ?>"><?php echo $grupo["fecha_limite_pago"]; ?></label></td>
                        <td><label><?php echo "$" . $grupo["total"] ?></label></td>
                        <td><button onclick="detalle_por_fecha(<?php echo $i ?>);" ><img id="icono_netflix" src="dist/img/abono_icono.jpg" /></button></td>
                    </tr>
     <?php
        $i++;
    }?>

                </tbody>
            </table>
        </div>
   
<?php } ?>



<!-- MODAL REALIZAR ABONO A DETALLE -->
<div class="modal fade" style="overflow-y: scroll; overflow-x: scroll; " id="realizar_abono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Realizar Abono</b></h4>

            </div>
            <div class="modal-header" style="    background: -webkit-linear-gradient(top, #333333 0%,#0B0B0B 100%);">

                <div class="container">
                </div>

            </div>
            <div class="modal-body" style="padding: 5%;">

                <div class="col-md-13">
                    <div id="resultado_detalle_vendedor">ss</div>

                <br><br>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN DE MODAL -->

<script>

    function detalle_por_fecha(aux) {
        var fecha_limite = document.getElementById("fecha_limite" + aux).innerHTML;
        var id_usuario = document.getElementById("id_usuario").value;
        var tipo_vendedor = document.getElementById("tipo_vendedor").value;
        var id_vendedor = document.getElementById("id_vendedor").value;

        $.ajax({
            type: 'POST',
            url: "pages/backend/muestra_detalle_cuenta_vendedores.php",
            data: {fecha_limite: fecha_limite,
                id_usuario:id_usuario,
                tipo_vendedor: tipo_vendedor,
                id_vendedor: id_vendedor},

            success: function (response) {
                $("#resultado_detalle_vendedor").html(response);
                //muestra modal
                $("#realizar_abono").modal('show');

            }
        });


    }


</script>