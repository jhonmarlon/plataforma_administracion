
<style>
    #search {
        float: right;
        margin-top: 9px;
        width: 250px;
    }

    .search {
        padding: 5px 0;
        width: 230px;
        height: 30px;
        position: relative;
        left: 10px;
        float: left;
        line-height: 22px;
    }

    .search input {
        position: absolute;
        float: Left;


        height: 30px;
        line-height: 18px;
        padding: 0 2px 0 2px;
        border-radius:1px;
    }

    .search:hover input, .search input:focus {
        width: 200px;
        margin-left: 0px;
    }

    #btn_search {
        height: 30px;
        position: absolute;
        right: 0;
        top: 5px;
        background: -webkit-linear-gradient(top, #8a2323 0%,#130101 100%);
        border-radius:1px;
    }
</style>

<?php
$conn = new conexion();

//$cuenta_netflix = $conn->getCuentasNetflixAll();
$solicitudes_error=$conn->getRegistroErrorCuentaNetflix();

?>
<div class="row">
    <div class="search">
        <input type="text" id="txt_buscar_vendedores" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
        <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
    </div>
</div><br><br>
<div class="datagrid">
    <h4><strong>Cuentas Netflix</strong></h4>
    <table>
        <thead>
            <tr>
                <th><label>N° Radicado</label></th>
                <th><label>Fecha de reporte</label></th>
                <th><label>Tomar</label></th>
                <th><label>Ver Detalles</label></th>
            </tr>

        </thead>
        <tbody>
            <?php while ($res = $solicitudes_error->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $res["radicado"] ?></td>
                    <td><?php echo $res["fecha_reporte"] ?></td>
                    <td> <button onclick="datos_modal_editar(<?php echo $res["id_cuenta_netflix_act"] ?>)" id="upda" type="submit" class="btn btn-default" 
                                 data-target="#edita_analisis" data-toggle="modal" title="Cuenta Reactivada" ><img src="dist/img/active.png" /></button></td>
                                 <td> <button disabled="" onclick="setDatos(<?php echo $res["id_cuenta_netflix_act"] ?>, '<?php echo $res["usuario"] ?>',
                                        '<?php echo $res["clave"] ?>')" id="upda"  class="btn btn-default" 
                                 data-target="#sustituir_cuenta" data-toggle="modal" title="Sustituir Cuenta" ><img src="dist/img/refresh-icon.png" /></button></td>


                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>




<!-- MODAL SUSTITUIR CUENTAS -->
<div class="modal fade" style="overflow-y: scroll; overflow-x: scroll; " id="sustituir_cuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="width: 130%; border-radius:10px;" id="modalesc" class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel_conf_1"  style="font-size:20px ;text-align: center"><b>Sustituir Cuenta</b></h4>

            </div>
            <div class="modal-header" style="    background: -webkit-linear-gradient(top, #333333 0%,#0B0B0B 100%);">

                <div class="container">
                </div>

            </div>
            <div class="modal-body" style="padding: 5%;">

                <div class="col-md-13">
                    <div class="row">
                        <div class="col-md-6" >
                            <div class="row">
                                <label><h3>Información Cuenta a Sustituir</h3></label>
                                <input type="hidden" id='id_cuenta_ant'>
                            </div><br>

                            <label>Usuario<font color='red'> *</font></label>
                            <input   type="text" readonly  id="usuario_cuenta_ant" name="usuario_cuenta_ant" class="form-control" style="width: 100%;"  required>


                            <label>Contraseña<font color='red'> *</font></label>
                            <input readonly type="text" id="contrasena_cuenta_ant" name="contrasena_cuenta_ant" class="form-control"  style="width: 100%;"  required>

                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <label><h3>Información Cuenta Sutituyente</h3></label>
                            </div><br>
                            <div class="row">

                                <label>Usuario<font color='red'> *</font></label>
                                <input   type="text" id="usuario_cuenta_nueva" name="usuario_cuenta_nueva" class="form-control"  style="width: 100%;"  required>

                                <label>Contraseña<font color='red'> *</font></label>
                                <input  type="text" id="contrasena_cuenta_nueva" name="contrasena_cuenta_nueva" class="form-control"  style="width: 100%;"  required>
                            </div>
                            <div id="resultado1">s</div>


                        </div>
                        <div id="resultado"></div>
                    </div><br><br>
                    <div class="row">
                        <div class="col-md-3" >
                            <button  class="btn-success" onclick="realizar_sustitucion()">Realizar Sustitución</button>

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

<div id="resultado"></div>
<div id="resultado1"></div>

<script>

    function setDatos(id_cuenta, usuario, clave) {

        $('#usuario_cuenta_ant').val(usuario);
        $('#contrasena_cuenta_ant').val(clave);
        $('#id_cuenta_ant').val(id_cuenta);

    }

    function realizar_sustitucion() {
        var usuario_nueva_cuenta = document.getElementById("usuario_cuenta_nueva").value;
        var clave_nueva_cuenta = document.getElementById("contrasena_cuenta_nueva").value;
        var id_cuenta_ant = document.getElementById("id_cuenta_ant").value;
        alert(usuario_nueva_cuenta);
        alert(clave_nueva_cuenta);

        if (usuario_nueva_cuenta == "" || clave_nueva_cuenta == "") {
            alertify.alert('<b>Los Campos Usuario y Contraseña son Obligatorios!</b>');
            return;
        }
        aux = 1;
        $.ajax({

            type: 'POST',
            url: 'pages/backend/validadores.php',
            data: {correo: usuario_nueva_cuenta,
                aux: aux},
            success: function (data)
            {
                $("#resultado").val(data);
                var res = document.getElementById('resultado').value;
                if (res != 1) {
                    alertify.alert('<b><P align=center>Antes de guardar ,debe estar seguro de que  <font color="red"><b>Todos los campos</b></font> estén completos y correctamente diligenciados<b>');
                    return;
                } else {

                    alertify.confirm('<b>Desea realizar la sustitución con los datos diligenciados?</b>', function (e) {
                        if (e) {

                            var parametros = {
                                "id_cuenta_ant": id_cuenta_ant,
                                "usuario_nueva_cuenta": usuario_nueva_cuenta,
                                "clave_nueva_cuenta": clave_nueva_cuenta,

                            };
                            $.ajax({
                                data: parametros,
                                url: 'pages/backend/sustituir_cuenta.php',
                                type: 'post',

                                success: function (response) {
                                    $("#resultado1").html(response);
                                    //window.setTimeout('location.reload()');
                                }
                            });

                        } else {
                            alertify.error('Cancelado');
                        }
                    });
                }
            }
        });
    }



</script>