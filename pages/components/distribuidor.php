<link rel="stylesheet" href="dist/css/check_radio/asCheck.css">
<link rel="stylesheet" href="plugins/alertify/alertify.default.css">
<link rel="stylesheet" href="../../plugins/alertify/alertify.core.css">
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../../plugins/alertify/alertify.min.js"></script>
<script src="plugins/check_radio/jquery-asCheck.js"></script>


    <?php
    $conn = new conexion();

    $vendedores = $conn->conexion->query("select a.*,c.descripcion as 'rol' from usuario a, usuario_vendedor b,rol c where a.id_usuario=b.id_vendedor
    and  b.id_usuario='$id_usuario' and a.id_rol=c.id_rol and b.estado='1' order by a.nombre asc");

    $clientes = $conn->conexion->query("select a.* from cliente a, usuarios_cliente b where a.id_cliente=b.id_cliente
    and  b.id_usuario='$id_usuario' and b.estado='1' AND a.estado='A' order by a.nombre asc ");

    //id usuario que creo al usuario logueado
    $id_usuario_creador = $conn->conexion->query("select id_usuario from usuario_vendedor where id_vendedor='$id_usuario' "
            . "and estado='1'");
    $id_user_crea = $id_usuario_creador->fetch_array();

    //solicitudes realizadas por el vendedor
    $solicitud = $conn->conexion->query("select nombre,apellido,"
            . "id_registro_solicitud_saldo,saldo_solicitado,fecha_solicitud "
            . "FROM registro_solicitud_saldo a inner JOIN usuario_vendedor b "
            . "on a.id_usuario_vendedor=b.id_vendedor INNER join usuario c on "
            . "b.id_usuario=c.id_usuario where b.id_usuario='$id_user_crea[0]' "
            . "and b.id_vendedor='$id_usuario'");
    //solicitudes realizadas por los vendedores del "Vendedor"
    $solicitud_saldo_vendedor = $conn->conexion->query("select id_registro_solicitud_saldo , 
        nombre,apellido, saldo_solicitado,fecha_solicitud from registro_solicitud_saldo a 
        INNER JOIN usuario_vendedor b on a.id_usuario_vendedor=b.id_vendedor 
        INNER join usuario c on b.id_vendedor=c.id_usuario where b.id_usuario='$id_usuario'");

    //$cantCuentasVendedor = $conn->getSaldoActualVendedor($id_usuario);
    //$max_cuentas = $conn->getMaxCuentasPermitidas($id_usuario);
    //Saldo actual
    $saldo_actual = $conn->getSaldoActual($id_usuario);
    $saldo_act = $saldo_actual->fetch_array();

    //saldo maximo permitido
    $saldo_max_perm = $conn->getSaldoMaximoPermitido($id_usuario);
    $saldo_max_permitido = $saldo_max_perm->fetch_array();

    $valor_cuenta = $conn->getValorCuenta($id_usuario);
    $valor_por_cuenta = $valor_cuenta->fetch_array();

    //verificamos si es un usuario provilegiado
    $privilegiado = $conn->esPrivilegiado($id_usuario);
    $priv = $privilegiado->fetch_array();
    ?>


    <div class="row">
        <?php if ($priv[0] != 0) { ?>

        <div class="col-xs-3" >
            <button  data-target="#solicitar_saldo" data-toggle="modal" title="Solicitar Saldo"><img id="icono_netflix" src="dist/img/solicitar_cuentas.jpg" /></button><!-- ./col -->
            <label>Solicitar Saldo</label>
        </div>
    <?php } ?>    
    <div class="col-xs-3" >
        <button  data-target="#comprar_cuenta_solicitada" data-toggle="modal" title="Comprar Cuentas"><img id="icono_netflix" src="dist/img/netflix_ico.png" /></button><!-- ./col -->
        <label>Comprar Cuentas</label>
    </div>
    <div class="col-xs-3" >
        <button  onclick="location.href = 'index.php?page=012'" title="Buzon de Cuentas Compradas"><img id="icono_netflix" src="dist/img/buzon_cuentas.png" /></button><!-- ./col -->
        <label>Buzon de Cuentas</label>
    </div>
    <div class="col-xs-3" >
        <button onclick="location.href = 'index.php?page=014'" title="Estado de Cuenta"><img id="icono_netflix" src="dist/img/money.jpg" /></button><!-- ./col -->
        <label>Estado de Cuenta</label>
    </div>
</div>



<!-- ./col --><br><br><br>

<!--Id usuario vendedor-->
<input type="hidden" id="id_usuario" value="<?php echo $id_usuario ?>">
<!--Id usuario creador-->
<input type="hidden" id="id_usuario_creo" value="<?php echo $id_user_crea[0] ?>">


<script>
    $(document).ready(function(){
    $("#nav > li > a").on("click", function(e){
    if ($(this).parent().has("ul")) {
    e.preventDefault();
    }
</script>



<div class="accordion" style="padding: 5px;">
    <div class="accordion-section">

        <button><a style="margin-bottom: 4px" class="accordion-section-title" href="#accordion-1"><img>Mis Vendedores</a></button>
        <div id="accordion-1" class="accordion-section-content">
            <div class="search">
                <input type="text" id="txt_buscar_vendedores" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
            </div><br><br>
            <div class="row">
                <br><br>
                <div class="datagrid">
                    <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
                        <table id="tbl_vendedores">
                            <thead style="width: 100%">
                                <tr>
                                    <th><label>Nombre</label></th>
                                    <th><label>Apellido</label></th>
                                    <th><label>Cédula</label></th>
                                    <th><label>Rol</label></th>
                                    <th><label>Correo</label></th>
                                    <th><label>Teléfono</label></th>
                                    <th><label>Celular</label></th>
                                    <th><label>Valor cuenta</label></th>
                                    <th><label>Editar</label></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($res_vendedores = $vendedores->fetch_assoc()) { ?>

                                    <tr>
                                        <td><label id="nombre<?php echo $res_vendedores["id_usuario"] ?>"><?php echo $res_vendedores["nombre"] ?></label></td>
                                        <td><label id="apellido<?php echo $res_vendedores["id_usuario"] ?>"><?php echo $res_vendedores["apellido"] ?></label></td>
                                        <td><label id="cedula<?php echo $res_vendedores["id_usuario"] ?>"><?php echo $res_vendedores["cedula"] ?></label></td>
                                        <td><label id="rol<?php echo $res_vendedores["id_usuario"] ?>"><?php echo $res_vendedores["rol"] ?></label></td>
                                        <td><label id="correo<?php echo $res_vendedores["id_usuario"] ?>"><?php echo $res_vendedores["correo"] ?></label></td> 
                                        <td><label id="telefono<?php echo $res_vendedores["id_usuario"] ?>"><?php echo $res_vendedores["telefono"] ?></label></td> 
                                        <td><label id="celular<?php echo $res_vendedores["id_usuario"] ?>"><?php echo $res_vendedores["celular"] ?></label></td>
                                        <td><label id="valor_cuenta<?php echo $res_vendedores["id_usuario"] ?>"><?php echo "$" . $res_vendedores["valor_cuenta"] ?></label></td>
                                        <td><button onclick="editar_vendedor(<?php echo $res_vendedores["id_usuario"] ?>)" id="upda" type="submit" class="btn btn-default" 
                                                    title="Editar Vendedor" ><img src="dist/img/refresh-icon.png" /></button></td>

                                    </tr>

                                <?php } ?>                         
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div><!--end .accordion-section-content-->

        <button><a style="margin-bottom: 4px" class="accordion-section-title" href="#accordion-2">Mis Clientes</a></button>
        <div id="accordion-2" class="accordion-section-content">
            <div class="search">
                <input type="text" id="txt_buscar_clientes" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
            </div><br><br><br>
            <div class="row">
                <div class="datagrid">
                    <div style=" width: 101.5%; height:280px; overflow-y: scroll;">

                        <table id="tbl_clientes">
                            <thead style="width: 100%">
                                <tr>
                                    <th><label>Nombre</label></th>
                                    <th><label>Apellido</label></th>
                                    <th><label>Cédula</label></th>
                                    <th><label>Correo</label></th>
                                    <th><label>Dirección</label></th>
                                    <th><label>Teléfono</label></th>
                                    <th><label>Celular</label></th>
                                    <th><label>Valor cuenta</label></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($res = $clientes->fetch_assoc()) { ?>

                                    <tr>
                                        <td><?php echo $res["nombre"] ?></td>
                                        <td><?php echo $res["apellido"] ?></td>
                                        <td><?php echo $res["cedula"] ?></td>
                                        <td><?php echo $res["correo"] ?></td> 
                                        <td><?php echo $res["direccion"] ?></td> 
                                        <td><?php echo $res["telefono"] ?></td>
                                        <td><?php echo $res["celular"] ?></td>
                                        <td><?php echo "$ " . $res["valor_cuenta"] ?></td>

                                    </tr>

                                <?php } ?>                         
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div><!--end .accordion-section-content-->

        <button><a class="accordion-section-title" href="#accordion-3">Mis Solicitudes de Saldo</a></button>
        <div id="accordion-3" class="accordion-section-content">
            <div class="search">
                <input type="text" id="txt_buscar" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
            </div><br><br>
            <div class="row">
                <br><br>
                <div class="datagrid">
                    <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
                        <table>
                            <thead style="width: 100%">
                                <tr>
                                    <th><label>Fecha Solicitud</label></th>
                                    <th><label>Saldo Solicitado</label></th>
                                    <th><label>Responsable</label></th>
                                    <th><label>Estado</label></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($solicitudes = $solicitud->fetch_assoc()) {
                                    ?>

                                    <tr>
                                        <td><label title="" id="fecha_solicitud<?php echo $solicitudes["id_registro_solicitud_saldo"] ?>"><?php echo $solicitudes["fecha_solicitud"] ?></label></td>
                                        <td><label id="saldo<?php echo $solicitudes["id_registro_solicitud_saldo"] ?>"><?php echo "$ " . $solicitudes["saldo_solicitado"] ?></label></td>
                                        <td><label id="responsable<?php echo $solicitudes["id_registro_solicitud_saldo"] ?>"><?php echo $solicitudes["nombre"] . " " . $solicitudes["apellido"] ?></label></td>
                                        <td><b><label id="estado<?php echo $solicitudes["id_registro_solicitud_saldo"] ?>"><font color="green">Saldo Cargado</font></label></b></td>  

                                    </tr>

                                <?php } ?>                         
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div><!--end .accordion-section-content-->




        <button><a class="accordion-section-title" href="#accordion-4">Solicitudes Saldo Vendedor</a></button>
        <div id="accordion-4" class="accordion-section-content">
            <div class="search">
                <input type="text" id="txt_buscar" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
            </div><br><br>
            <div class="row">
                <br><br>
                <div class="datagrid">
                    <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
                        <table>
                            <thead style="width: 100%">
                                <tr>
                                    <th><label>Fecha Solicitud</label></th>
                                    <th><label>Saldo Solicitado</label></th>
                                    <th><label>Vendedor</label></th>
                                    <th><label>Estado</label></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($solicitud_vendedor = $solicitud_saldo_vendedor->fetch_array()) { ?>

                                    <tr>
                                        <td><label  id="fecha_solicitud<?php echo $solicitud_vendedor["id_registro_solicitud_saldo"] ?>"><?php echo $solicitud_vendedor["fecha_solicitud"] ?></label></td>
                                        <td><label id="saldo_solicitado<?php echo $solicitud_vendedor["id_registro_solicitud_saldo"] ?>"><?php echo "$" . $solicitud_vendedor["saldo_solicitado"] ?></label></td>
                                        <td><label id="vendedor<?php echo $solicitud_vendedor["id_registro_solicitud_saldo"] ?>"><?php echo $solicitud_vendedor["nombre"] . " " . $solicitud_vendedor["apellido"] ?></label></td>
                                        <td><label id="estado<?php $solicitud_vendedor["id_registro_solicitud_saldo"] ?>"><font color="green">Saldo Cargado</font></label></td>
                                    </tr>

                                <?php } ?>              
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div><!--end .accordion-section-content-->




    </div><!--end .accordion-section-->


</div><!--end .accordion-->





<!-- INICIO DE MODAL SOLICITAR SALDO -->
<div class="modal fade" style="overflow-y: scroll; overflow-x: scroll; " id="solicitar_saldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Realizar solicitud de saldo</b></h4>

            </div>
            <div class="modal-header" style="    background: -webkit-linear-gradient(top, #333333 0%,#0B0B0B 100%);">

                <div class="container">

                </div>


            </div>
            <div class="modal-body" style="padding: 5%;">

                <div class="col-md-13">
                    <div class="row">
                        <div class="col-md-6" >

                            <label>Saldo a solicitar<font color='red'> *</font></label>
                            <div class="input-group"> 
                                <span class="input-group-addon">$</span>
                                <input class="form-control" min="0" style="width: 100%;" onkeyup="EnterToTab()" type="number" id="saldo_solicitado" name="num_cuentas" >
                            </div>

                            <label>Valor por cuenta<font color='red'> *</font></label>
                            <div class="input-group"> 
                                <span class="input-group-addon">$</span>
                                <input value="<?php echo $valor_por_cuenta[0] ?>" readonly type="valor_cuenta" id="valor_cuenta" name="cedula_usuario" class="form-control"  style="width: 100%;"  required>
                            </div>


                            <label>Cuentas equivalentes al saldo solicitado<font color='red'> *</font></label>
                            <input type="text"  readonly id="valor_pagar_cuentas" name="valor_pagar_cuentas" class="form-control"  style="width: 100%;"  required>


                            <br><br>
                        </div>

                        <div class="col-md-6">

                            <label>Saldo actual a Favor</label>
                            <div class="input-group"> 
                                <span class="input-group-addon">$</span>
                                <input value="<?php echo $saldo_act[0] ?>" readonly type="number" id="saldo_actual" name="saldo_actual" class="form-control"  style="width: 100%;"  required>
                            </div>

                            <label>Saldo Máximo Permitido</label>
                            <div class="input-group"> 
                                <span class="input-group-addon">$</span>
                                <input value="<?php echo $saldo_max_permitido[0] ?>" readonly type="number" id="saldo_permitido" name="saldo_permitido" class="form-control"  style="width: 100%;"  required>
                            </div> 


                            <label>Saldo restante <p>(En caso de hacer uso de todas las cuentas equivalentes)</label>
                            <div class="input-group"> 
                                <span class="input-group-addon">$</span>
                                <input type="text" readonly id="saldo_restante" class="form-control" style="width: 100%;">
                            </div>

                        </div>
                        <div id="resultado"></div>
                    </div>
                    <button  class="btn-success" onclick="envia_solicitud_saldo()">Realizar solicitud</button>
                    <button  id="cancelar" class="btn-danger" data-dismiss="modal" aria-hidden="true">Cencelar</button>


                </div>

                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>
<!-- FIN DE MODAL -->




<!--Modal detalles-->
<!-- INICIO DE MODAL EDITAR VENDEDOR- modificar -->
<div id="mdl_editar_vendedor" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;" >
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Operación Netflix - Editar Vendedor</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <ul class="buttons">
                        <li><input required id="corriente" class="radiobtn"  name="rbtnTipoVendedor" type="radio" value="corriente" tabindex="1" onclick="cerrar()" > <span></span>
                            <label for="corriente" id="r1">Mayorista</label>
                            <input required id="privilegiado" class="radiobtn" name="rbtnTipoVendedor" type="radio" value="privilegiado" tabindex="2" onclick="cerrar()" > 
                            <span></span> <label for="privilegiado" id="r2">Privilegiado</label><br>


                    </ul>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Nombre</label>
                        <input type="text" id="nombre_usuario_modal" class="form-control">
                        <label>Apellido</label>
                        <input type="text" id="apellido_usuario_modal" class="form-control">
                        <label>Cédula</label>
                        <input type="number" id="cedula_usuario_modal" class="form-control">
                        <label>E-mail</label>
                        <input type="email" id="correo_usuario_modal" class="form-control">
                        <label>Teléfono</label>
                        <input type="number" id="telefono_usuario_modal" class="form-control">
                        <label>Celular</label>
                        <input type="number" id="celular_usuario_modal" class="form-control">
                        <label>Valor por Cuenta</label>
                        <div class="input-group"> 
                            <span class="input-group-addon">$</span>
                            <input type="number" id="valor_cuenta_modal"  class="form-control"  style="width: 100%;"  required>
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div><br>
            <div class="modal-footer">
                <button type="submit" onclick="actualiza_datos_cuenta()" class="btn btn-success"><i class="fa fa-pencil"></i>Editar</button>
                <button type="reset" data-dismiss="modal" aria-hidden="true" class="btn btn-danger"><i class="fa fa-times"></i>Cancelar</button>

            </div>
        </div>

    </div>
</div>



<!-- MODAL COMPRAR CUENTAS -->
<div class="modal fade" style="overflow-y: scroll; overflow-x: scroll; " id="comprar_cuenta_solicitada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Comprar cuentas</b></h4>

            </div>
            <div class="modal-header" style="    background: -webkit-linear-gradient(top, #333333 0%,#0B0B0B 100%);">

                <div class="container">
                </div>

            </div>
            <div class="modal-body" style="padding: 5%;">

                <div class="col-md-13">
                    <div class="row">
                        <div class="col-md-6" >


                            <label>Número de cuentas a comprar<font color='red'> *</font></label>
                            <input  min="0" type="number" onkeyup="EnterToTab2()" id="num_cuentas_compra" name="num_cuentas" class="form-control" style="width: 100%;"  required>


                            <label>Valor por Cuenta<font color='red'> *</font></label>
                            <div class="input-group"> 
                                <span class="input-group-addon">$</span>
                                <input value="<?php echo $valor_por_cuenta[0] ?>" readonly type="number" id="valor_cuenta_compra" name="cedula_usuario" class="form-control"  style="width: 100%;"  required>
                            </div>

                            <label>Valor a pagar por cuentas pedidas<font color='red'> *</font></label>
                            <div class="input-group"> 
                                <span class="input-group-addon">$</span>
                                <input type="number" readonly id="valor_pagar_cuentas_compra" name="valor_pagar_cuentas_compra" class="form-control"  style="width: 100%;"  required>
                            </div>



                        </div>

                        <div class="col-md-6">
                            <div class="row">

                                <label>Saldo actual a favor</label>
                                <div class="input-group"> 
                                    <span class="input-group-addon">$</span>
                                    <input value="<?php echo $saldo_act[0] ?>" readonly type="number" id="saldo_actual" name="num_cuentas_actuales" class="form-control"  style="width: 100%;"  required>
                                </div>

                            </div><br><br>
                            <label style="text-align: center"><strong>Para poder realizar su compra, 
                                    es necesario que tenga saldo a favor, de lo contrario deberá realizar la petición de saldo por medio de la opción <font color='red'>"Solicitar Saldo"</font>. 
                                </strong>
                            </label>


                        </div>
                        <div id="resultado"></div>
                    </div><br><br>
                    <div class="row">
                        <div class="col-md-3" >
                            <button  class="btn-success" onclick="enviar_solicitud_compra()">Realizar Compra</button>

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
<div id="resultado1"></div>


<script>
           
            function envia_solicitud_saldo() {
            //tomamos los valores
            var saldo_solicitado = parseInt(document.getElementById("saldo_solicitado").value);
                    var user_id = document.getElementById("id_usuario").value;
                    //id usuario que creo vendedor
                    var id_usuario_creo = document.getElementById("id_usuario_creo").value;
                    var valor_cuenta = document.getElementById("valor_cuenta_compra").value;
                    if (isNaN(saldo_solicitado)) {
            alertify.alert('<b>Debe especificar el saldo a solicitar!</b>');
                    return;
            }

            if (saldo_solicitado < valor_cuenta){
            alertify.alert('<b>El saldo a solicitar , debe ser mayor o igual que el valor de tus cuentas!</b>');
                    return;
            }

            alertify.confirm('Desea realizar la solicitud diligenciada?', function (e) {
            if (e) {

            var parametros = {
            "user_id": user_id,
                    "id_usuario_creo": id_usuario_creo,
                    "saldo_solicitado":saldo_solicitado
            };
                    $.ajax({
                    data: parametros,
                            url: 'pages/backend/includes/crea_solicitud_saldo.php',
                            type: 'post',
                            success: function (response) {
                            $("#res").html(response);
                                    //alertify.alert("<P align=center><b>Solicitud enviada correctamente!", function () {

                                    //window.setTimeout('location.reload()');
                                    //});
                            }
                    });
            } else {
            alertify.error('Cancelado');
            }
            });
                    /*if (max_cuentas < num_cuentas) {
                     alertify.alert("<P align=center><b>la cantidad de cuentas solicitadas es mayor a lo permitido!");
                     return;
                     }*/
            }


    function editar_vendedor(id_vendedor){


    var nombre = $("#nombre" + id_vendedor).text();
            var apellido = $("#apellido" + id_vendedor).text();
            var cedula = $("#cedula" + id_vendedor).text();
            var correo = $("#correo" + id_vendedor).text();
            var telefono = $("#telefono" + id_vendedor).text();
            var celular = $("#celular" + id_vendedor).text();
            var valor_cuenta = $("#valor_cuenta" + id_vendedor).text();
            alert(valor_cuenta);
            patron = "$";
            nuevo_valor = "";
            var valor_cuenta = valor_cuenta.replace(patron, nuevo_valor);
            alert(valor_cuenta);
            //seteamos los valores a los campos del modal
            $("#nombre_usuario_modal").val(nombre);
            $("#apellido_usuario_modal").val(apellido);
            $("#cedula_usuario_modal").val(cedula);
            $("#correo_usuario_modal").val(correo);
            $("#telefono_usuario_modal").val(telefono);
            $("#celular_usuario_modal").val(celular);
            $("#valor_cuenta_modal").val(valor_cuenta);
            //quitamos el simbolo $ del label


            $("#mdl_editar_vendedor").modal('show');
    }


    function enviar_solicitud_compra(){

    var num_cuentas_compra = parseInt(document.getElementById("num_cuentas_compra").value);
            var valor_cuenta_compra = parseInt(document.getElementById("valor_cuenta_compra").value);
            var valor_pagar_cuentas_compra = parseInt(document.getElementById("valor_pagar_cuentas_compra").value);
            var saldo_actual = parseInt(document.getElementById("saldo_actual").value);
            //usuario que creo al usuario logueado    
            var usuario_respon = document.getElementById('id_usuario_creo').value;
            //usuario logueado
            var user_id = document.getElementById("id_usuario").value;
            if (isNaN(num_cuentas_compra)) {
    alertify.alert('<b>Debe especificar el número de cuentas a comprar!</b>');
            return;
    }

    if (saldo_actual == 0){

    alertify.alert('<b>No cuenta con saldo suficiente para realizar la compra.<p>Debe realizar una petición de saldo , mediante el botón <font color="red">"Solicitar Saldo"</font></b>');
            return;
    }

    if (valor_pagar_cuentas_compra > saldo_actual){
    alertify.alert('<b>El total a pagar por la cuentas solicitadas, <font color="red">es mayor</font> al saldo actual que tienes a favor.<p> Inténtalo nuevamente!</b>');
            return;
    }

    alertify.confirm('Desea realizar la compra diligenciada?', function (e) {
    if (e) {

    var parametros = {
    "user_id": user_id,
            "usuario_respon":usuario_respon,
            "num_cuentas_compra": num_cuentas_compra,
            "valor_cuenta_compra":valor_cuenta_compra,
            "valor_pagar_cuentas_compra":valor_pagar_cuentas_compra


    };
            $.ajax({
            data: parametros,
                    url: 'pages/backend/includes/crea_detalle_compra.php',
                    type: 'post',
                    success: function (response) {

                    $("#resultado1").html(response);
                    }

            });
    } else {
    alertify.error('Cancelado');
    }
    });
    }


    function checkselected(radio) {
    for (i = 0; i < radio.length; i++) {
    if (radio[i].checked) {
    return i;
    }
    }
    return false
    }





    function EnterToTab() {

    var saldo_solicitado = document.getElementById("saldo_solicitado").value;
            var valor = document.getElementById('valor_cuenta').value;
            var cuentas_equivalentes = parseInt(saldo_solicitado / valor);
            $('#valor_pagar_cuentas').val(cuentas_equivalentes);
            var restante = saldo_solicitado - (valor * cuentas_equivalentes);
            $('#saldo_restante').val(restante);
    }

    function EnterToTab2() {
    var num = document.getElementById('num_cuentas_compra').value;
            var valor = document.getElementById('valor_cuenta_compra').value;
            var total_pagar = parseInt(num * valor);
            $('#valor_pagar_cuentas_compra').val(total_pagar);
    }




    //filtro de busqueda para vendedores
    $(document).ready(function(){
    $("#txt_buscar_vendedores").keyup(function(){
    _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#tbl_vendedores tbody tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === - 1)
                    $(this).hide();
                    else
                    $(this).show();
            });
    });
    });
            //filtro de busqueda para clientes 
            $(document).ready(function(){
    $("#txt_buscar_clientes").keyup(function(){
    _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#tbl_clientes tbody tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === - 1)
                    $(this).hide();
                    else
                    $(this).show();
            });
    });
    })
            ;

</script>


<div id="res"></div>