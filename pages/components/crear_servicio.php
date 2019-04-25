<?php
include 'pages/tablero/body_pages.php';
$conn = new conexion();
//tomamos los servicios creados
$servicios = $conn->getServicios();
?>

<div class="box box-success">
    <div class="box-header with-border">
        <!-- Barra de progreso -->
        <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
            </div>
        </div>
        <h3>Crear Nuevo Servicio</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre de Servicio<font color='red'> *</font></label>
                    <input onKeyUp="this.value = this.value.toUpperCase();" type="text" class="form-control" id="nombre_servicio">
                </div>
            </div>
        </div>
        <div class="form-group" >
            <div class="row" >
                <div class="col-md-6">
                    <button type="button" class="btn btn-success" onclick="captura_valores()">Crear Servicio</button>
                    <a href="index.php"><button type="button" class="btn btn-danger">Cancelar</button></a>
                </div><br><br><br><br>
                <div class="col-md-12">
                    <div class="datagrid">
                        <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
                            <table id="mis_servicios">
                                <thead>
                                    <tr>
                                        <th>Servicio N°</th>
                                        <th>Nombre de Servicio</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cont = 1;
                                    while ($servicios_activos = $servicios->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><label><?php echo $cont; ?></label></td>
                                            <td><label id="nombre_servicio<?php echo $cont ?>"><?php echo $servicios_activos["nombre"] ?></label></td>
                                            <td><button onclick="editar_servicio('<?php echo $servicios_activos['id'] ?>', '<?php echo $cont ?>')" id="editar_servicio" title='Editar Servicio' type="submit" class="btn btn-default" 
                                                        data-target="#edita_servicio" data-toggle="modal"><img src="dist/img/refresh-icon.png" /></button></td>
                                            <td><button onclick="eliminar_servicio()" id="eliminar_servicio" title='Eliminar Servicio' type="submit" class="btn btn-default">
                                                    <img src="dist/img/delete-icon.png" /></button></td>
                                        </tr>
                                        <?php
                                        $cont++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="modal_editar_servicio" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <h3 class="modal-title">Actualizar Servicio</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="id_servicio_actualizar">
                    <label>Nombre de Servicio<font color='red'> *</font></label>
                    <input onKeyUp="this.value = this.value.toUpperCase();" type="text" class="form-control" id="nombre_servicio_modal">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="actualiza_servicio()">Actualizar Servicio</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger">Cancelar</button>
            </div>  
        </div>
    </div>
</div>


<script>
    function captura_valores() {

        var nombre_servicio = $("#nombre_servicio").val();

        if (nombre_servicio == "") {
            alertify.alert("<P align=center><b>Debe asignar un nombre al servicio antes de crearlo");
            return;
        }
        alertify.confirm('Desea crear el servicio diligenciado?', function (e) {
            if (e) {

                //enviamos dato por ajax
                $.ajax({
                    type: 'POST',
                    url: 'pages/backend/includes/crea_servicio.php',
                    data: {nombre_servicio: nombre_servicio},
                    success: function (data) {
                        //$("#respuesta").html(data);
                        alertify.alert("<P align=center><b>Servicio creado correctamente!", function () {

                            window.setTimeout('location.reload()');
                        });
                    }
                });

            } else {
                alertify.error('Cancelado');
            }
        });
    }

    function editar_servicio(id_servicio, num) {
        //pasamos los valors al modal
        var nombre_servicio = $("#nombre_servicio" + num).html();
        $("#nombre_servicio_modal").val(nombre_servicio);
        $("#id_servicio_actualizar").val(id_servicio);
        $("#modal_editar_servicio").modal("show");

    }

    function actualiza_servicio() {
        var nuevo_nombre = $("#nombre_servicio_modal").val();
        var id_servicio = $("#id_servicio_actualizar").val();

        if (nuevo_nombre == "") {
            alertify.alert("<P align=center><b>Para actualizar el servicio es necesario diligenciar el nuevo nombre");
            return;
        }

        //enviamos dato por ajax
        $.ajax({
            type: 'POST',
            url: 'pages/backend/includes/actualiza_servicio.php',
            data: {
                nuevo_nombre: nuevo_nombre,
                id_servicio: id_servicio
            },
            success: function (data) {
                //$("#respuesta").html(data);
                alertify.alert("<P align=center><b>Servicio actualizado correctamente!", function () {

                    window.setTimeout('location.reload()');
                });
            }
        });
    }

</script>


