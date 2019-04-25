<?php
$conn = new conexion();
//tomamos los servicios creados
$servicios = $conn->getServicios();

$id_usuario = $userinfo->id_usuario;
$id_empresa = $userinfo->id_empresa;

//validamos si el cliente tiene en temporal algun perfil
$perfil_temporal = $conn->getPerfilTarifaTemporal($id_usuario, 'lista');

$codigo = "";

$codigo_estandar_distribuidor = $conn->encryption("STDDI");
$codigo_estandar_cliente = $conn->encryption("STDCL");

//verificamos si hay creado alguno de los perfiles que son obligatorios
//validamos el perfil de distribuidor
$perfil_tarifa_dis = $conn->getNumPerfilTarifaCreado($id_usuario, $codigo_estandar_distribuidor);
//validamos el perfil del cliente
$perfil_tarifa_cli = $conn->getNumPerfilTarifaCreado($id_usuario, $codigo_estandar_cliente);



//$perfil_tarifa = $conn->getNumPerfilTarifaCreado($id_usuario);
//si es la primera vez , obligamos al usuario a crear el perfil estandar d cliente y distribuidor
//$nombre_inicail="";



$nombre_tarifa = "";
?>



<div class="box box-success">
    <div class="box-header with-border">
        <!-- Barra de progreso -->
        <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
            </div>
        </div>
        <h3>Crear Nuevo Perfil de Tarifa</h3>
        <div class="row">
            <div class="col-md-6">
                <label>Nombre de Perfil<font color='red'> *</font></label>
                <?php
                //$existe_estandar_cli = 0;
                //$existe_estandar_dis = 0;
                //validamos si el gerente ya ha creado previamente los perfiles para distribuidores y clientes finales
                if (mysqli_num_rows($perfil_tarifa_dis) == 0 && mysqli_num_rows($perfil_tarifa_cli) == 0 && mysqli_num_rows($perfil_temporal) == 0) {
                    echo "<script> 
                  alertify.alert('<b>Antes de crear cualquier perfil , es necesario que cree inicialmente los perfiles estandar para los Distribuidores y los Clientes</b>');
                  </script>";
                    $nombre_tarifa = "TARIFA ESTANDAR - DISTRIBUIDOR/PROPIETARIO ";
                    $codigo = $codigo_estandar_distribuidor;
                    ?>
                    <input readonly disabled value="<?php echo $nombre_tarifa ?>" onKeyUp="this.value = this.value.toUpperCase();" id="nombre_perfil_tarifa" name="nombre_perfil_tarifa" class="form-control" style="width: 100%;"  required>

                    <?php
                } else {

                    if (mysqli_num_rows($perfil_temporal) != 0) {
                        $nombre_tarifa = $conn->ejecutar_consulta_simple("SELECT nombre_perfil "
                                . "FROM perfil_tarifa_temporal WHERE id_usuario='$id_usuario' AND "
                                . "id_empresa='$id_empresa'");
                        $nombre_tarifa = $nombre_tarifa->fetch_assoc();
                        $nombre_tarifa = $nombre_tarifa["nombre_perfil"];
                    }

                    if (mysqli_num_rows($perfil_tarifa_dis) == 0) {
                        $nombre_tarifa = "TARIFA ESTANDAR - DISTRIBUIDOR/PROPIETARIO";
                        $codigo = $codigo_estandar_distribuidor;
                        ?>
                        <input readonly disabled value="<?php echo $nombre_tarifa ?>" onKeyUp="this.value = this.value.toUpperCase();" id="nombre_perfil_tarifa" name="nombre_perfil_tarifa" class="form-control" style="width: 100%;"  required>

                        <?php
                    } elseif (mysqli_num_rows($perfil_tarifa_cli) == 0) {
                        $nombre_tarifa = "TARIFA ESTANDAR - CLIENTE FINAL ";
                        $codigo = $codigo_estandar_cliente;
                        ?>
                        <input readonly disabled value="<?php echo $nombre_tarifa ?>" onKeyUp="this.value = this.value.toUpperCase();" id="nombre_perfil_tarifa" name="nombre_perfil_tarifa" class="form-control" style="width: 100%;"  required>

                        <?php
                    } else {


                        if (mysqli_num_rows($perfil_temporal) != 0) {
                            $nombre_tarifa = $conn->ejecutar_consulta_simple("SELECT nombre_perfil "
                                    . "FROM perfil_tarifa_temporal WHERE id_usuario='$id_usuario' AND "
                                    . "id_empresa='$id_empresa'");
                            $nombre_tarifa = $nombre_tarifa->fetch_assoc();
                            $nombre_tarifa = $nombre_tarifa["nombre_perfil"];
                        }

                        $codigo = $conn->generarCodigoTarifa();
                        $codigo = $conn->encryption($codigo);
                        ?>
                        <input   onKeyUp="this.value = this.value.toUpperCase();" id="nombre_perfil_tarifa" value="<?php echo $nombre_tarifa ?>" name="nombre_perfil_tarifa" class="form-control" style="width: 100%;"  required>

                        <?php
                    }
                }
                ?>


                <div class="form-group">
                    <label>Servicio<font color='red'> *</font></label>
                    <select id="servicio" class="form-control">
                        <option selected disabled="" value="0">Seleccione Servicio</option>
                        <?php while ($servicio = $servicios->fetch_assoc()) { ?>
                            <option  value="<?php echo $servicio["id"] ?>"><?php echo $servicio["nombre"] ?></option>
                        <?php } ?>
                    </select>       
                </div>
                <label>Tarifa</label>
                <div class="input-group"> 
                    <span class="input-group-addon">$</span>
                    <input type="text"  class="form-control" id="tarifa" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  data-type="currency" >
                </div><br>                       <button type="button" class="btn btn-success" onclick="captura_valores('<?php echo $id_usuario ?>', '<?php echo $id_empresa ?>', 'lista')">Añadir</button>

                <div class="row" >
                    <!--  <a href="pages/components/asignar_perfil_tarifa.php"><button type="button" class="btn btn-danger">Asignar Perfiles</button></a>-->

                
                </div>

            </div>


          
            <?php if (mysqli_num_rows($perfil_temporal) != 0) { ?>
                <div class="col-md-6" >
                    <div class="datagrid">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre de Tarifa</th>
                                    <th>Servicio</th>
                                    <th>Tafifa</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($perfil_tarifa_temp = $perfil_temporal->fetch_assoc()) { ?>
                                    <tr>
                                        <td><label><?php echo $perfil_tarifa_temp["nombre_perfil"] ?></label></td>
                                        <td><label id="nombre_servicio<?php echo $perfil_tarifa_temp["id"] ?>"><?php echo $perfil_tarifa_temp["nombre"] ?></label></td>
                                        <td><label id="tarifa<?php echo $perfil_tarifa_temp["id"] ?>"><?php echo "$" . $perfil_tarifa_temp["tarifa"] ?></label></td>
                                        <td><button onclick="toma_datos_editar('<?php echo $perfil_tarifa_temp["id"] ?>')" id="editar_servicio" title='Editar Servicio' type="submit" class="btn btn-default" 
                                                    data-target="#modal_editar_servicio_temp" data-toggle="modal"><img src="dist/img/refresh-icon.png" /></button></td>

                                                  

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table><br>
                        <div class="row">
                            <button type="button" class="btn btn-success" onclick="crear_perfil('<?php echo $id_usuario ?>', '<?php echo $codigo ?>')">Crear Perfil</button>
                            <a href="index.php"><button type="button" class="btn btn-danger">Cancelar</button></a>            </div>
                    </div>
                </div> 
            <?php } ?>
        </div>
    </div>
</div>


<div id="modal_editar_servicio_temp" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <h3 class="modal-title">Actualizar Servicio</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="id_servicio_actualizar">
                    <input type="hidden" id="tipo_tarifa_modal" value="temporal">

                    <label>Nombre de Servicio<font color='red'> *</font></label>
                    <input readonly onKeyUp="this.value = this.value.toUpperCase();" type="text" class="form-control" id="nombre_servicio_modal">
                    <label>Tarifa<font color='red'> *</font></label>
                    <div class="input-group"> 
                        <span class="input-group-addon">$</span>
                        <input type="text"  class="form-control" id="tarifa_modal" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  data-type="currency" >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="editar_servicio()">Actualizar Servicio</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger">Cancelar</button>
            </div>  
        </div>
    </div>
</div>

<script>

    function captura_valores(id_usuario, id_empresa, accion) {

        var nombre_perfil = $("#nombre_perfil_tarifa").val();
        var id_servicio = $("#servicio").val();
        var tarifa = $("#tarifa").val();

        if (nombre_perfil == "" || id_servicio == null || tarifa == "") {
            alertify.alert('<b>Todos los campos son de caracter obligatorio!</b>');
            return;
        }

        //enviamos los datos por ajax

        $.ajax({
            type: "POST",
            url: "pages/backend/includes/crea_perfil_tarifa_temporal.php",
            data: {
                nombre_perfil: nombre_perfil,
                id_usuario: id_usuario,
                id_empresa: id_empresa,
                id_servicio: id_servicio,
                tarifa: tarifa,
                accion: accion,
            },

            success: function (data) {
                $("#resultado").html(data);
                window.setTimeout('location.reload()');
            }
        });

    }

    function crear_perfil(id_usuario, codigo) {
        alertify.confirm('Desea crear el perfil diligenciado?', function (e) {
            if (e) {

                //vamos al ajax para poder tomar los datos del tmeporal
                $.ajax({
                    type: "POST",
                    url: "pages/backend/includes/crea_perfil_tarifa.php",
                    data: {
                        id_usuario: id_usuario,
                        codigo: codigo,
                    },
                    success: function (data) {
                        alertify.alert("<P align=center><b>Perfil de tarifa creado correctamente!", function () {

                            window.setTimeout('location.reload()');
                        });
                        //$("#respuesta").html(data);
                        //window.setTimeout("location.reload()");
                    }
                });

            } else {
                alertify.error('Cancelado');
            }
        });

    }

    function eliminar_servicio(id_eliminar, tipo_tarifa) {
        //enviamos datos por ajax
        $.ajax({
            type: "POST",
            url: "pages/backend/includes/elimina_tarifa.php",
            data: {
                id_eliminar: id_eliminar,
                tipo_tarifa: tipo_tarifa,
            },
            success: function (data) {
                window.setTimeout("location.reload()");
            }
        });
    }

    function toma_datos_editar(id_servicio) {
        var servicio_actualizar = $("#nombre_servicio" + id_servicio).html();
        var tarifa_actualizar = $("#tarifa" + id_servicio).html();
        //quitamos el simbolo de pesos del label
        tarifa_actualizar = tarifa_actualizar.replace("$", "");

        $("#id_servicio_actualizar").val(id_servicio);
        $("#nombre_servicio_modal").val(servicio_actualizar);
        $("#tarifa_modal").val(tarifa_actualizar);
    }

    function editar_servicio() {
        //tomamos los dato del modal
        var id_actualizar = $("#id_servicio_actualizar").val();
        var tarifa = $("#tarifa_modal").val();
        var tipo_tarifa = $("#tipo_tarifa_modal").val();

        if (tarifa == "") {
            alertify.alert("<P align=center><b>Para actualizar los datos es necesario diligenciar los campos requeridos");
            return;
        }

        //enviamos datos por ajax
        $.ajax({
            type: "POST",
            url: "pages/backend/includes/actualiza_tarifa.php",
            data: {
                id_actualizar: id_actualizar,
                tarifa: tarifa,
                tipo_tarifa: tipo_tarifa,
            },
            success: function (data) {
                alertify.alert("<P align=center><b>Datos actualizados correctamente!", function () {
                    window.setTimeout('location.reload()');
                });
            }
        });

    }
</script>
