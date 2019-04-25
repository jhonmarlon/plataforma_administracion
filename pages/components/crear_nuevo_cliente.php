

<?php
include 'pages/tablero/body_pages.php';
$oe = new conexion();
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
        <div class="col-md-6">
            <div class="form-group">


                <!-- CEDULA DEL USUARIO -->
                <input type="hidden" id="cedula" name="id_usuario" value="<?php echo $userinfo->user_id ?>">

                <label>Nombre<font color='red'> *</font></label>
                <input id="nombre_cliente" name="nombre_cliente" class="form-control" style="width: 100%;"  required>

                <label>Apellido<font color='red'> *</font></label>
                <input id="apellido_cliente" name="apellido_cliente" class="form-control"  style="width: 100%;"  required>

                <label>Cédula<font color='red'> *</font></label>
                <input type="number" id="cedula_cliente" name="cedula_cliente" class="form-control"  style="width: 100%;"  required>

                <label>Correo<font color='red'> *</font></label><br>
                <input type="email" id="correo_cliente" name="correo_cliente" class="form-control"  style="width: 100%;" >



            </div>

        </div>

        <div class="col-md-6">
            <div class="form-group" >

                <label>Dirección</label>
                <input type="text" id="direccion_cliente" name="direccion_cliente" class="form-control"  style="width: 100%;"  required>

                <label>Teléfono</label>
                <input type="number" id="telefono_cliente" name="telefono_cliente" class="form-control"  style="width: 100%;"  required>

                <label>Celular</label>
                <input type="number" id="celular_cliente" name="celular_cliente" class="form-control"  style="width: 100%;"  required>

                <label>Valor por cuenta<font color='red'> *</font></label><br>
                <input type="number" id="valor_cuenta" name="valor_cuenta" class="form-control"  style="width: 100%;" >


                <?php /* $conn3 = $oe->conexion->query("SELECT id, tipo FROM tipo_dispositivo ");

                  while ($row = $conn3->fetch_assoc()) {
                  echo '<option value="' . $row['id'] . '">' . $row['tipo'] . '</option>';
                  }

                  $oe->cerrar();
                 */ ?>
                </select>

            </div>

        </div>
        <div class="row" >
            <div class="col-md-6">

                <button type="button" class="btn btn-success" onclick="captura_valores()">Crear Cliente</button>
                <a href="index.php"><button type="button" class="btn btn-danger">Cancelar</button></a>
            </div>
        </div>
    </div>

</div>
<div id="tabla"></div>

<script>

    function captura_valores() {

        var nombre_cliente = document.getElementById('nombre_cliente').value;
        var apellido_cliente = document.getElementById('apellido_cliente').value;
        var cedula_cliente = document.getElementById('cedula_cliente').value;
        var correo_cliente = document.getElementById('correo_cliente').value;
        var direccion_cliente = document.getElementById('direccion_cliente').value;
        var telefono_cliente = document.getElementById('telefono_cliente').value;
        var celular_cliente = document.getElementById('celular_cliente').value;
        var valor_cuenta = document.getElementById('valor_cuenta').value;

        var id_usuario = document.getElementById("cedula").value;

        if (nombre_cliente == "" || apellido_cliente == "" || cedula_cliente == "" || correo_cliente == "" || valor_cuenta == "") {


            alertify.alert('<b>Los campos que están marcados con </b><font color="red">*</font><b> son de caracter <font color="red">OBLIGATORIO</font></b>', function () {
                alertify.success('Ok')
            });

        } else {

            aux = 1;
            //VALIDANDO CORREO
            $.ajax({

                type: 'POST',

                url: 'pages/backend/validadores.php',

                data: {correo: correo_cliente,
                    aux: aux},

                success: function (data)
                {
                    $("#resultado").val(data);
                    var res = document.getElementById('resultado').value;
                    alert(res);
                    if (res != 1) {
                        alertify.alert('<b><P align=center>Antes de guardar ,debe estar seguro de que  <font color="red"><b>Todos los campos</b></font> estén completos y correctamente diligenciados<b>');
                        return;
                    } else {

                        alertify.confirm('Desea crear al cliente con los datos diligenciados?', function (e) {
                            if (e) {
                                crea_usuario_cliente(nombre_cliente, apellido_cliente, cedula_cliente, correo_cliente,
                                        direccion_cliente, telefono_cliente, celular_cliente, id_usuario, valor_cuenta);
                            } else {
                                alertify.error('Cancelado');
                            }
                        });


                    }
                }
            });



        }
    }

    function crea_usuario_cliente(nombre_cliente, apellido_cliente, cedula_cliente, correo_cliente,
            direccion_cliente, telefono_cliente, celular_cliente, id_usuario, valor_cuenta) {
        //SE PASAN LOS PARAMETROS AL AJAX PARA HACER EL UPDATE
        alert(id_usuario);

        var parametros = {

            "nombre_cliente": nombre_cliente,
            "apellido_cliente": apellido_cliente,
            "cedula_cliente": cedula_cliente,
            "correo_cliente": correo_cliente,
            "direccion_cliente": direccion_cliente,
            "telefono_cliente": telefono_cliente,
            "celular_cliente": celular_cliente,
            "valor_cuenta": valor_cuenta,
            "id_usuario": id_usuario
        };
        $.ajax({
            data: parametros,
            url: 'pages/backend/includes/crea_usuario_cliente.php',
            type: 'post',
            success: function (response) {

                alertify.alert("<P align=center><b>Cliente creado correctamente!", function () {

                    window.setTimeout('location.reload()');
                });
                $("#resultado1").html(response);

                //window.setTimeout('location.reload()');
                // location.reload();

                //setTimeout('document.location.reload()', 5000);


            }
        });
    }


</script>

