<?php
$conn = new conexion();
//tomamos el id de la empresa
$id_empresa = $userinfo->id_empresa;
$id_usuario = $userinfo->id_usuario;
$solicitud_distribuidor = $conn->getSolicitudIngresoDistribuidor($id_empresa);
$servicios = $conn->getServicios($id_usuario);
$id_nuevo_usuario;
?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Solicitudes DIstribuidores</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Solicitudes Clientes Finales</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Solicitudes Proveedores</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Cédula Reponsable </th>
                    <th>Nombre Responsable </th>
                    <th>Cédula Distribuidor </th>
                    <th>Nombre Distribuidor </th>
                    <th>Correo </th>
                    <th>Teléfono </th>                
                    <th>Celular </th>
                    <th>Fecha Registro </th>
                    <th>Valor Crédito </th>
                    <th>Aprobar </th>
                    <th>Negar </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($solicitud_distri = $solicitud_distribuidor->fetch_assoc()) { ?>
                    <tr>
                        <td><label><?php echo $solicitud_distri["cedula_usu_responsable"] ?></label></td>
                        <td><label><?php echo $solicitud_distri["usuario_responsable"] ?></label></td>
                        <td><label><?php echo $solicitud_distri["cedula_distribuidor"] ?></label></td>
                        <td><label><?php echo $solicitud_distri["nombre_distribuidor"] ?></label></td>
                        <td><label><?php echo $solicitud_distri["correo"] ?></label></td>
                        <td><label><?php echo $solicitud_distri["telefono"] ?></label></td>
                        <td><label><?php echo $solicitud_distri["celular"] ?></label></td>
                        <td><label><?php echo $solicitud_distri["fecha_registro"] ?></label></td>
                        <td><label id="valor_credito<?php echo $solicitud_distri["id_credito"] ?>"><?php
                                if ($solicitud_distri["valor_credito"] == "") {
                                    echo "<font color='red'><b>No solicitado</b></font>";
                                } else {
                                    echo "$ " . $solicitud_distri["valor_credito"];
                                }
                                ?>
                            </label></td>
                        <td><button onclick="solicitud_distribuidor('<?php echo $solicitud_distri["id_credito"] ?>', '<?php echo $solicitud_distri["id_usuario_responsable"] ?>', '<?php echo $solicitud_distri["id_distribuidor"] ?>')"><span class="glyphicon glyphicon-ok"></span></button></td>
                        <td><button><span class="glyphicon glyphicon-remove"></span></button></td>
                    </tr>   
                <?php } ?>
            </tbody>
        </table>



    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">



    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
</div>



<div id="modal_ingreso_distribuidor" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <h3 class="modal-title">Aprobar Solicitud de Ingreso - Nuevo Distribuidor</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="id_credito_modal">
                    <input type="hidden" id="id_distribuidor_modal" >
                    <input type="hidden" id="id_usuario_modal" value="<?php echo $id_usuario ?>">
                    <b><label>Configuración de datos para crédito:</label></b><br><br>
                    <label>Valor del crédito:<font color='red'> </font></label>
                    <div class="input-group"> 
                        <span class="input-group-addon">$</span>
                        <input readonly type="text"  class="form-control" id="valor_credito_modal" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  data-type="currency" >
                    </div>
                    <label>Lapso de tiempo para ventas en días<font color='red'> *</font></label>
                    <input class="form-control" type="number" min="8" id="num_dias_credito_modal">

                    <label>Lapso de tiempo para realizar pagos en días<font color='red'> *</font></label>
                    <input class="form-control"  type="number" min="8" id="num_dias_pago_modal">

                    <br><p><b><label>Distribuir monto entre servicios</label></b></p>
                    <label>Servicio<font color='red'> *</font></label>
                    <select class="form-control" id="servicio_credito_modal">
                        <option value="0" disabled selected>Seleccione servicio</option>
                        <?php while ($ser = $servicios->fetch_assoc()) { ?>
                            <option value="<?php echo $ser["id"] ?>"><?php echo $ser["nombre"] ?></option>

                        <?php } ?>
                    </select>
                    <label>Monto a Asignar<font color='red'> *</font></label>
                    <div class="input-group"> 
                        <span class="input-group-addon">$</span>
                        <input  type="text"  class="form-control" id="valor_asignar_modal" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  data-type="currency" >
                    </div><br>
                    <button class="btn btn-success" onclick="asigna_servicio_usuario()">Agregar</button>               
                    <div id="resultado"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="aprueba_solicitud_distribuidor()">Aprobar Solicitud</button>
                <button type="button" data-dismiss="modal"  aria-label="Close" class="btn btn-danger">Cancelar</button>
            </div>  
        </div>
    </div>
</div>





<div id="modal_aprobar_distribuidor" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <h3 class="modal-title">Nuevo Distribuidor Aprobado</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="id_credito_modal">
                    <p>Los siguientes son los datos de acceso correspondientes al nuevo usuario distribuidor</p>
                    <p>Se harán llegar al usuario via correo electrónico, Whatsapp o mensaje de texto.</p><br>
                    <b><label>Usuario aprobado:</label></b><br><br>
                                     <br>
                    <div id="resultado_aprobado"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="solicitud_aprobada()">Aceptar</button>
            </div>  
        </div>
    </div>
</div>


<script>
    function solicitud_distribuidor(id_credito, id_usuario_responsable, id_distribuidor) {
        //tomamos los datos de la tabla
        if (id_credito == undefined || id_credito == "") {
            //mostramos alerta de aprobar solicitud
            alert("sin credito");
        } else {


            //variables para generar la tabla
            var id_usuario = id_usuario_responsable;
            var id_distribuidor = id_distribuidor;
            //abrimos modal para configurar los dias
            var valor_credito = $("#valor_credito" + id_credito).html();
            //quitamos el signo de pesos al valor del string
            valor_credito = valor_credito.replace("$", "");
            //seteamos el valor en el modal
            $("#valor_credito_modal").val(valor_credito);
            $("#id_credito_modal").val(id_credito);
            $("#id_distribuidor_modal").val(id_distribuidor);

            //enviamos datos para crear tabla en modalcuando abra
            $.ajax({
                type: "POST",
                url: "pages/backend/tabla_asignacion_credito_servicio_temp.php",
                data: {
                    id_usuario: id_usuario,
                    id_distribuidor: id_distribuidor,
                },
                success: function (data) {
                    $("#resultado").html(data);
                    //$("#respuesta").html(data);
                    //window.setTimeout("location.reload()");
                }
            });

            //mostramos el modal
            $("#modal_ingreso_distribuidor").modal("show");


        }
    }


    function aprueba_solicitud_distribuidor() {
        //tomamos los valores del modal
        var num_dias_credito = $("#num_dias_credito_modal").val();
        var num_dias_pago = $("#num_dias_pago_modal").val();

        var id_credito = $("#id_credito_modal").val();
        var id_distribuidor = $("#id_distribuidor_modal").val();
        var id_usuario = $("#id_usuario_modal").val();



        if (num_dias_credito == "" || num_dias_pago == "") {
            alertify.alert('<b>Los campos que están marcados con </b><font color="red">*</font><b> son de caracter <font color="red">OBLIGATORIO</font></b>', function () {
                alertify.success('Ok')
            });
            return;
        }



        //tomamos el valor del div donde se pinta la tabla

        var tabla = $("#resultado").html();
        if (tabla == "") {
            alertify.alert('<b>No se han asignado los servicios al nuevo distribuidor!', function () {
                alertify.success('Ok')
            });
            return;
        }

        alertify.confirm('Desea aprobar la solicitud actual?', function (e) {
            if (e) {

                //vamos al ajax para poder tomar los datos del tmeporal
                $.ajax({
                    type: "POST",
                    url: "pages/backend/aprueba_solicitud_nuevo_distribuidor.php",
                    data: {
                        id_usuario: id_usuario,
                        id_distribuidor: id_distribuidor,
                    },
                    success: function (data) {
                        $("#resultado_aprobado").html(data);
                        //ocultamos el modal de configuracion
                        $("#modal_ingreso_distribuidor").modal("hide");
                        //mostgramos el modal de aprobacion
                         $("#modal_aprobar_distribuidor").modal("show");
                        //mostreamos el modal con los datos del usuario aprobado
                        /*alertify.alert("<P align=center><b>Perfil de tarifa creado correctamente!", function () {
                         
                         window.setTimeout('location.reload()');
                         });*/
                        //$("#respuesta").html(data);
                        //window.setTimeout("location.reload()");
                    }
                });

            } else {
                alertify.error('Cancelado');
            }
        });



    }


   function solicitud_aprobada(){
              alertify.alert("<P align=center><b>Solicitud aprobada correctamente!", function () {

                    window.setTimeout('location.reload()');
                });
   }

    function asigna_servicio_usuario() {
        //tomamos los valores para llevarlos a la tabla temporal 
        var monto_solicitado = $("#valor_credito_modal").val();
        var id_distribuidor = $("#id_distribuidor_modal").val();
        var id_usuario = $("#id_usuario_modal").val();
        var id_servicio = $("#servicio_credito_modal").val();

        var monto_permitido_venta = $("#valor_asignar_modal").val();

        monto_solicitado = Number(monto_solicitado.replace(/[^0-9\.]+/g, ""));
        monto_permitido_venta = Number(monto_permitido_venta.replace(/[^0-9\.]+/g, ""));

        if (id_servicio == "" || monto_permitido_venta == "") {
            alertify.alert('<b>Para agregar un servicio es necesario diligenciar los campos correspondientes!', function () {
                alertify.success('Ok')
            });
            return;
        }


        //VERIFICAR ESTA VALIDACION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        if (monto_permitido_venta > monto_solicitado) {
            alertify.alert('<b>El monto a asignar supera el monto solicitado!', function () {
                alertify.success('Ok')
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: "pages/backend/tabla_asignacion_credito_servicio_temp.php",
            data: {
                id_usuario: id_usuario,
                id_distribuidor: id_distribuidor,
                id_servicio: id_servicio,
                monto_permitido_venta: monto_permitido_venta
            },
            success: function (data) {
                $("#resultado").html(data);
                //$("#respuesta").html(data);
                //window.setTimeout("location.reload()");
            }
        });

    }

    function recarga_pagina() {
        location.reload();
    }
</script>
