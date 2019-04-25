
<?php
$oe = new conexion();
$id_rol = $userinfo->id_rol;
?>
<input type="hidden" id="resultado" >
<div id="resultado1"></div>

<div class="box box-success">
    <div class="box-header with-border">
        <!-- Barra de progreso -->
        <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
            </div>

        </div>
        <!--<div class="row">
            <ul class="buttons">
                <li><input required id="corriente" class="radiobtn"  name="rbtnTipoVendedor" type="radio" value="corriente" tabindex="1" onclick="cerrar()" > <span></span>
                    <label for="corriente" id="r1">Mayorista</label>
                    <input required id="privilegiado" class="radiobtn" name="rbtnTipoVendedor" type="radio" value="privilegiado" tabindex="2" onclick="cerrar()" > 
                    <span></span> <label for="privilegiado" id="r2">Privilegiado</label><br>


            </ul>

        </div>-->
        <div class="col-md-6">

            <div class="form-group">


                <!-- CEDULA DEL USUARIO -->
                <input type="hidden" id="cedula" name="id_usuario" value="<?php echo $userinfo->user_id ?>">

                <label>Nombre<font color='red'> *</font></label>
                <input id="nombre_usuario" name="nombre_usuario" class="form-control" style="width: 100%;"  required>

                <label>Apellido<font color='red'> *</font></label>
                <input id="apellido_usuario" name="apellido_usuario" class="form-control"  style="width: 100%;"  required>

                <label>Cédula<font color='red'> *</font></label>
                <input type="number" id="cedula_usuario" name="cedula_usuario" class="form-control"  style="width: 100%;"  required>

                <label>Correo<font color='red'> *</font></label><br>
                <input type="email" id="correo_usuario" name="correo_usuario" class="form-control"  style="width: 100%;" >

                <label>Teléfono</label>
                <input type="number" id="telefono_usuario" name="telefono_usuario" class="form-control"  style="width: 100%;"  required>

            </div>

        </div>

        <div class="col-md-6">
            <div class="form-group" >



                <label>Celular</label>
                <input type="number" id="celular_usuario" name="celular_usuario" class="form-control"  style="width: 100%;"  required>

                <label>Valor por cuenta<font color='red'> *</font></label>
                <input type="number" id="valor_cuenta_usuario" name="valor_cuenta_usuario" class="form-control"  style="width: 100%;"  required>

                <label>Saldo inicial<font color='red'> *</font></label>
                <input type="number" min="0" id="saldo_inicial" name="num_max_cuentas" class="form-control"  style="width: 100%;"  required>

                <label>Saldo Máximo permitido (Crédito)<font color='red'> *</font></label>
                <input disabled type="number" id="saldo_max_permitido"  class="form-control"  style="width: 100%;"  required>

                <label>Lapso de tiempo para ventas en dias<font color='red'> *</font></label>
                <input disabled type="number" id="lapso_ventas"  class="form-control"  style="width: 100%;"  required>

                <label>Días de plazo para realizar pagos<font color='red'> *</font></label>
                <input disabled type="number" id="dias_plazo"  class="form-control"  style="width: 100%;"  required>


                <br><br>
                <label><font color='red'>Importante:</font> El valor por cuenta inicial hace referencia al monto asignado a pagar 
                    por cuenta de cada vendedor creado.</label>



            </div>

        </div>
        <div class="row" >
            <div class="col-md-6">
                <button type="button" class="btn btn-success" onclick="captura_valores()">Crear Asesor</button>
                <a href="index.php"><button type="button" class="btn btn-danger">Cancelar</button></a>
            </div>
        </div>
    </div>

</div>
<div id="tabla"></div>

<script>

    function captura_valores() {

        if ($(".radiobtn").is(':checked')) {
            var tipo_vendedor = ($('input:radio[name=rbtnTipoVendedor]:checked').val());
            var nombre_usuario = document.getElementById('nombre_usuario').value;
            var apellido_usuario = document.getElementById('apellido_usuario').value;
            var cedula_usuario = document.getElementById('cedula_usuario').value;
            var correo_usuario = document.getElementById('correo_usuario').value;
            var telefono_usuario = document.getElementById('telefono_usuario').value;
            var celular_usuario = document.getElementById('celular_usuario').value;
            var valor_cuenta_usuario = document.getElementById('valor_cuenta_usuario').value;
            var saldo_inicial = document.getElementById('saldo_inicial').value;
            var saldo_max_permitido = document.getElementById('saldo_max_permitido').value;
            var lapso_venta = document.getElementById('lapso_ventas').value;
            var dias_plazo = document.getElementById('dias_plazo').value;
            var id_usuario = document.getElementById("cedula").value;

            if (tipo_vendedor == 'privilegiado') {

                if (saldo_max_permitido == 0
                        || dias_plazo == 0 || lapso_venta == 0) {

                    alertify.alert('<b>Los campos que están marcados con </b><font color="red">*</font><b> son de caracter <font color="red">OBLIGATORIO</font></b>', function () {
                        alertify.success('Ok')
                    });
                    return;
                }
            }
            if (nombre_usuario == "" || apellido_usuario == "" || cedula_usuario == "" || correo_usuario == ""
                    || valor_cuenta_usuario == 0 || saldo_inicial == "") {


                alertify.alert('<b>Los campos que están marcados con </b><font color="red">*</font><b> son de caracter <font color="red">OBLIGATORIO</font></b>', function () {
                    alertify.success('Ok')
                });
            } else {

                aux = 1;
                //VALIDANDO CORREO
                $.ajax({

                    type: 'POST',
                    url: 'pages/backend/validadores.php',
                    data: {correo: correo_usuario,
                        aux: aux},
                    success: function (data)
                    {
                        $("#resultado").val(data);
                        var res = document.getElementById('resultado').value;
                        if (res != 1) {
                            alertify.alert('<b><P align=center>Antes de guardar ,debe estar seguro de que  <font color="red"><b>Todos los campos</b></font> estén completos y correctamente diligenciados<b>');
                            return;
                        } else {

                            alertify.confirm('Desea crear al usuario con los datos diligenciados?', function (e) {
                                if (e) {
                                    crea_usuario_vendedor(tipo_vendedor, nombre_usuario, apellido_usuario, cedula_usuario, correo_usuario,
                                            telefono_usuario, celular_usuario, valor_cuenta_usuario, saldo_inicial, id_usuario,
                                            saldo_max_permitido, dias_plazo, lapso_venta);
                                } else {
                                    alertify.error('Cancelado');
                                }
                            });
                        }
                    }
                });
            }
        } else {
            alertify.alert('<b><P align=center>Debe elegir el tipo de vendedor a crear! <b>');
            return;
        }
    }

    function crea_usuario_vendedor(tipo_vendedor, nombre_usuario, apellido_usuario, cedula_usuario, correo_usuario,
            telefono_usuario, celular_usuario, valor_cuenta_usuario, saldo_inicial, id_usuario, saldo_max_permitido,
            dias_plazo, lapso_venta) {

        //SE PASAN LOS PARAMETROS AL AJAX PARA HACER EL UPDATE

        var parametros = {
            "tipo_vendedor": tipo_vendedor,
            "nombre_usuario": nombre_usuario,
            "apellido_usuario": apellido_usuario,
            "cedula_usuario": cedula_usuario,
            "correo_usuario": correo_usuario,
            "telefono_usuario": telefono_usuario,
            "celular_usuario": celular_usuario,
            "valor_cuenta_usuario": valor_cuenta_usuario,
            "saldo_inicial": saldo_inicial,
            "id_usuario": id_usuario,
            "saldo_max_permitido": saldo_max_permitido,
            "dias_plazo": dias_plazo,
            "lapso_venta": lapso_venta
        };
        $.ajax({
            data: parametros,
            url: 'pages/backend/includes/crea_usuario_vendedor.php',
            type: 'post',
            success: function (response) {

                alertify.alert("<P align=center><b>Vendedor creado correctamente!", function () {

                    window.setTimeout('location.reload()');
                });
                $("#resultado1").html(response);
                //window.setTimeout('location.reload()');
                // location.reload();

                //setTimeout('document.location.reload()', 5000);


            }
        });
    }



    $("#corriente").on("click", function () {

        $('#saldo_max_permitido').attr('disabled', 'disabled');
        $('#saldo_max_permitido').val('');
        $('#dias_plazo').attr('disabled', 'disabled');
        $('#dias_plazo').val('');
        $('#lapso_ventas').attr('disabled', 'disabled');
        $('#lapso_ventas').val('');
    });
    $("#privilegiado").on("click", function () {
        $('#saldo_max_permitido').removeAttr('disabled');
        $('#dias_plazo').removeAttr('disabled');
        $('#lapso_ventas').removeAttr('disabled');
        $('#saldo_max_permitido').val('0');
        $('#dias_plazo').val('0');
        $('#lapso_ventas').val('0');
    }
    );

</script>

