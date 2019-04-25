<link rel="stylesheet" href="plugins/alertify/alertify.default.css">
<link rel="stylesheet" href="../../plugins/alertify/alertify.core.css">
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../../plugins/alertify/alertify.min.js"></script>
<?php
include "pages/components/metricas_administrador.php";
$conn = new conexion();

$solicitudes_pendientes = $conn->conexion->query("select a.id_solicitud,b.valor_cuenta,b.id_usuario,b.cedula,b.nombre,b.apellido,b.correo,a.fecha_requerimiento,
a.num_cuentas_solicitadas,a.tipo_solicitud,a.descripcion from
solicitud a,usuario b where a.id_cliente_usuario=b.id_usuario and
a.id_usuario_resp='$user_id' and a.id_solicitud not in 
(select id_solicitud from respuesta_solicitud) order by a.fecha_requerimiento desc");

$valor_cuenta_usuario = $conn->conexion->query("select valor_cuenta from usuario where id_usuario='$user_id'");
$valor = $valor_cuenta_usuario->fetch_array();

?>

<input type="hidden" id="resultado1">
<input type="hidden" value="<?php echo $valor[0] ?>" id="valor_cuenta_usuario">
<div id="resultado2"></div>


<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        <!-- MAP & BOX PANE -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Solicitudes Pendientes</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool"
                            data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="row">
                    <div class="col-md-12 col-sm-8">
                        <div class="pad">
                            <div class="datagrid">

                                <!-- Map will be created here -->
                                <table class="table table-striped table-bordered table-hover"
                                       id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>N° Solicitud</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Correo</th>
                                            <th>Fecha</th>
                                            <th>N° Cuentas</th>
                                            <th>Valor Cuenta</th>	
                                            <th>Total</th>  
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th>Aprobar</th>
                                            <th>Negar</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $aux = 1;
                                        while ($res = $solicitudes_pendientes->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <th><label id="id_solicitud<?php echo $aux ?>"><?php echo $res["id_solicitud"] ?></label></th>
                                                <th><label id="nombre<?php echo $aux ?>"><?php echo $res["nombre"] ?></label></th>
                                                <th><label id="apellido<?php echo $aux ?>"><?php echo $res["apellido"] ?></label></th>
                                                <th><label id="correo<?php echo $aux ?>"><?php echo $res["correo"] ?></label></th>
                                                <th><label id="fecha_requerimiento<?php echo $aux ?>"><?php echo $res["fecha_requerimiento"] ?></label></th>	
                                                <th><label id="num_cuentas_solicitadas<?php echo $aux ?>"><?php echo $res["num_cuentas_solicitadas"] ?></label></th>
                                                <th><label id="valor_cuenta<?php echo $aux ?>"><?php echo "$ " . $res["valor_cuenta"] ?></label></th>
                                                <th><label id="total<?php echo $aux ?>"><?php echo "$" . ($res["valor_cuenta"] * $res["num_cuentas_solicitadas"]) ?></label></th>
                                                <th><label id="tipo_solicitud<?php echo $aux ?>"><?php echo $res["tipo_solicitud"] ?></label></th>
                                                <th><label id="descripcion<?php echo $aux ?>"><?php echo $res["descripcion"] ?></label></th>
                                                <td><a><input onclick="aprobar('<?php echo $res["id_solicitud"] ?>', '<?php echo $res["id_usuario"] ?>',
                                                                '<?php echo $res["nombre"] ?>', '<?php echo $res["apellido"] ?>',
                                                                '<?php echo $res["cedula"] ?>', '<?php echo $res["correo"] ?>',
                                                                '<?php echo $aux ?>')"
                                                              type="image" src="dist/img/checkmark.svg"></a></td>
                                                <td><a><input onclick="desaprobar(<?php echo $res["id_solicitud"] ?>)"
                                                              type="image" src="dist/img/cross.svg"></a></td>

                                            </tr>
                                            <?php
                                            $aux++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                            </div>
                            <!-- /.TABLA DE DATA TABLE -->


                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>




            <!-- INICIO DE MODAL ESTADO DE CUENTA-  -->
            <div class="modal fade" id="estado_cuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
                        <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                            <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Estado de cuenta</b></h4>

                        </div>
                        <div class="modal-header" style="color: ghostwhite;  background: -webkit-linear-gradient(top, #333333 0%,#0B0B0B 100%);">

                            <div class="container">

                                <h2>Datos del cliente:</h2>
                                <input type="hidden"  id="id_solicitud">
                                <input type="hidden" id="id_usuario">
                                <input type="hidden" id="auxiliar">
                                <ul>
                                    <li>
                                        <label for="f-option">Nombres y apellidos: </label>
                                        <label id="nom_ape"></label>  
                                    </li>

                                    <li>
                                        <label for="s-option">Cédula: </label>
                                        <label id="cedula"></label>  

                                    </li>

                                    <li>
                                        <label for="s-option">Correo: </label>
                                        <label id="correo"></label>  

                                    </li>


                                </ul>
                            </div>


                        </div>
                        <div class="modal-body" style="padding: 5%;">

                            <div class="col-md-13">
                                <div class="row">


                                    <div id="resultado"></div>
                                </div><br><br>
                                <div class="row">
                                    <div class="col-md-3" >
                                        <button  class="btn-success" onclick="aprueba_solicitud()">Aprobar solicitud</button>

                                    </div>
                                    <div class="col-md-3" >
                                        <button  id="cancelar" class="btn-danger" data-dismiss="modal" aria-hidden="true">Cencelar</button>

                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN DE MODAL -->



            <!-- INICIO DE MODAL NEGAR CUENTA-  -->
            <div class="modal fade" id="negar_cuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
                        <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                            <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Negar solicitud</b></h4>

                        </div>
                        <div class="modal-header" style="color: ghostwhite;  background: -webkit-linear-gradient(top, #333333 0%,#0B0B0B 100%);">
                        </div>
                        <div class="modal-body" style="padding: 5%;">
                            <label>Detalles de negación (Opcional)</label><br>
                            <input type="hidden" id="id_solicitud_negada">
                            <textarea id="detalle_negacion" style="margin: 0px;
                                      width: 100%;
                                      height: 100px;
                                      resize: none;    font-family: inherit;"></textarea>

                            <div class="col-md-13">
                                <div class="row">

                                    <div id="resultado3"></div>
                                </div><br><br>
                                <div class="row">
                                    <div class="col-md-3" >
                                        <button  class="btn-success" onclick="niega_solicitud()">Negar solicitud</button>

                                    </div>
                                    <div class="col-md-3" >
                                        <button  id="cancelar" class="btn-danger" data-dismiss="modal" aria-hidden="true">Cencelar</button>

                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>
            </div>







            <!-- /.col -->
        </div>

        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i
                            class="fa fa-home"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i
                            class="fa fa-gears"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane" id="control-sidebar-home-tab"></div>
                <!-- /.tab-pane -->
                <!-- Stats tab content -->
                <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                <!-- /.tab-pane -->
                <!-- Settings tab content -->
                <div class="tab-pane" id="control-sidebar-settings-tab"></div>
                <!-- /.tab-pane -->
            </div>
        </aside>
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
               immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

        <!-- ./wrapper -->
        <script>
            function aprobar(id_solicitud, id_usuario, nombre, apellido, cedula, correo, aux) {

                alertify.confirm('<b>Antes de aprobar la solicitud , es recomendado que verifiques el estado de cuenta del cliente que la realizó.<p>\n\
                Deseas verificar el estado de cuenta del cliente?<b>', function (e) {
                    if (e) {
                        //setea valores en modal
                        $('#id_solicitud').val(id_solicitud);
                        $("#nom_ape").text(nombre + " " + apellido);
                        $("#cedula").text(cedula);
                        $("#correo").text(correo);
                        $("#auxiliar").val(aux);
                        //abre ventana modal
                        $('#estado_cuenta').modal('show');

                        var parametros = {
                            "id_usuario": id_usuario
                        };
                        $.ajax({
                            data: parametros,
                            url: 'pages/backend/consulta_estado_cuenta.php',
                            type: 'post',
                            success: function (response) {
                                /*  alertify.alert("<P align=center><b>Solicitud enviada correctamente!", function () {
                                 
                                 window.setTimeout('location.reload()');
                                 });*/
                                $('#resultado').html(response);

                            }
                        });


                    } else {
                        alertify.error('Cancelado');
                    }
                });

            }



            function desaprobar(id_solicitud) {
                alert(id_solicitud);
                $('#id_solicitud_negada').val(id_solicitud);
                alertify.confirm('<b>Esta seguro de negar la solicitud seleccionada?<b>', function (e) {
                    if (e) {
                        $('#negar_cuenta').modal('show');

                    } else {
                        alertify.error('Cancelado');
                    }
                });
            }

            function niega_solicitud() {
                var id_solicitud_negada = document.getElementById('id_solicitud_negada').value;
                var detalle_negacion = document.getElementById('detalle_negacion').value;
                var parametros = {
                    "id_solicitud_negada": id_solicitud_negada,
                    "detalle_negacion": detalle_negacion
                };
                $.ajax({
                    data: parametros,
                    url: 'pages/backend/includes/niega_solicitud_cuenta.php',
                    type: 'post',
                    success: function (response) {
                        alertify.alert("<P align=center><b>Solicitud negada correctamente!", function () {

                            window.setTimeout('location.reload()');
                        });
                    }
                });
            }




            //aprueba la solicitud enviada
            function aprueba_solicitud() {

                var id_solicitud = document.getElementById('id_solicitud').value;
                //obtiene valor de auxiliar para poder determinar las posiciones de la tabla
                var aux = document.getElementById("auxiliar").value;
                //cant cuentas solicitadas en la solicitud
                var cant_cuentas = document.getElementById('num_cuentas_solicitadas' + aux).innerHTML;
                alert(cant_cuentas);
                var parametros = {
                    "id_solicitud": id_solicitud,
                    "cant_cuentas": cant_cuentas,
                };
                $.ajax({
                    data: parametros,
                    url: 'pages/backend/includes/aprueba_solicitud_cuenta.php',
                    type: 'post',
                    success: function (response) {
                        $("#resultado1").val(response);
                        //ultima respuesta                
                        var res = document.getElementById('resultado1').value;
                        //auxiliar para saber que fila es la que tenemos clickeada
                        var aux = document.getElementById('auxiliar').value;
                        //valor unitario de cuenta para el usuario
                        var valor_uni_usuario = document.getElementById('valor_cuenta_usuario').value;
                        //valor unitario de cuenta para el cliente
                        var valor_uni = document.getElementById('valor_cuenta' + aux).innerHTML;
                        //total que paga el cliente
                        var total = document.getElementById('total' + aux).innerHTML;
                        var tipo = document.getElementById('tipo_solicitud' + aux).innerHTML;
                        alert(valor_uni_usuario);
                        alert(res);
                        alert(cant_cuentas);
                        alert(valor_uni);
                        alert(total);
                        alert(tipo);
                        //creamos el detalle de la solicitud

                        var parametros1 = {
                            "valor_uni_usuario": valor_uni_usuario,
                            "id_respuesta_solicitud": res,
                            "cant_cuentas": cant_cuentas,
                            "valor_uni": valor_uni,
                            "total_pagar": total,
                            "tipo_pago": tipo,
                        };
                        $.ajax({
                            data: parametros1,
                            url: 'pages/backend/includes/detalle_solicitud_cuenta_vendedor.php',
                            type: 'post',
                            success: function (response) {
                                // alertify.alert("<P align=center><b>Solicitud aprobada correctamente!", function () {

                                //window.setTimeout('location.reload()');
                                //});
                                $('#resultado2').html(response);
                            }
                        });
                        alertify.alert("<P align=center><b>Solicitud aprobada correctamente!", function () {

                            window.setTimeout('location.reload()');
                        });
                    }
                });
                //tomamos valores para crear el detalle de la solicitud


                //creamos el detalle de la aprobacion de la solicitud
                /*var parametros1 = {
                 "id_solicitud": id_solicitud
                 };
                 $.ajax({
                 data: parametros,
                 url: 'pages/backend/includes/aprueba_solicitud_cuenta.php',
                 type: 'post',
                 success: function (response) {
                 alertify.alert("<P align=center><b>Solicitud aprobada correctamente!", function () {
                 
                 window.setTimeout('location.reload()');
                 });
                 $('#resultado1').html(response);
                 
                 }
                 });*/





            }
        </script>