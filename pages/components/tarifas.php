<?php if ($_SESSION["authenticated"] == 1) { ?>

    <div class="row">

        <?php
        $tipo_usuario = "";
        $id_usuario;
        $codigo_empresa = "";
        $codigo_usuario = "";
        $su = 0;

        if (isset($_SESSION["id_su"])) {
            $tipo_usuario = "super_usuario";
            $id_usuario = $super_userinfo->id_su;
            $codigo_usuario = $super_userinfo->codigo_su;
            $codigo_empresa = $super_userinfo->codigo_empresa_su;
            $su = 1;

            include 'pages/components/metricas_super_usuario.php';
        } else {

            $tipo_usuario = "usuario";
            $id_usuario = $userinfo->user_id;
            $codigo_usuario = $userinfo->codigo;
            $codigo_empresa = $userinfo->codigo_empresa_usr;

            if ($userinfo->id_rol == "1") {
                include 'pages/components/metricas_administrador.php';
            } else {

                include 'pages/components/metricas_distribuidor.php';
            }
        }

        $conn = new conexion();


        //traemos las tarifas personalizadas segun el usuario
        $tarifas_personalizadas = $conn->getTarifasPersonalizadas($tipo_usuario, $id_usuario);
        ?>
        <div class="col-md-6" >

            <h3>Tarifas Personalizadas - Usuario</h3>

            <label>Código</label>
            <div class="input-group">
                <span class="input-group-addon"><input type="button" onclick="genera_codigo_tarifa('personalizada')" style="margin-right: -7px;margin-left: -7px;" value="Generar código"></span>
                <input type="text" id="codigo_tarifa_personalizada" class="form-control" readonly >
            </div>
            <label>Valor</label>
            <div class="input-group"> 
                <span class="input-group-addon">$</span>
                <input min="0" type="number" id="valor_tarifa_personalizada"  class="form-control"  style="width: 100%;"  required>
            </div><br>

            <button type="button"  class="btn btn-success" onclick="genera_tarifa('personalizada', '<?php echo $tipo_usuario ?>', '<?php echo $id_usuario ?>', '')">Crear Tarifa</button>    <br><br>

            <div class="datagrid">

                <table>
                    <thead>
                    <th>Código</th>
                    <th>Valor</th>
                    <th>Códigos de acceso</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <?php while ($tarifa_per = $tarifas_personalizadas->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $conn->decryption($tarifa_per["codigo"]) ?></td>
                                <td><?php echo "$ " . $tarifa_per["valor"] ?></td>
                                <td><?php echo $codigo_empresa . "-" . $codigo_usuario . "-" . $conn->decryption($tarifa_per["codigo"]) ?></td>
                                <td><button onclick="editar_tarifa()" id="editar_tarifa" title='Editar Tarifa' type="submit" class="btn btn-default" 
                                            data-target="#edita_tarifa" data-toggle="modal"><img src="dist/img/refresh-icon.png" /></button></td>
                                <td><button onclick="eliminar_tarifa('personalizada', '<?php echo $tarifa_per["id_tarifa_usuario"] ?>')" id="eliminar_tarifa" title='Eliminar Tarifa' type="submit" class="btn btn-default">
                                        <img src="dist/img/delete-icon.png" /></button></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6" >
            <?php
            include 'pages/components/tarifas_estandar.php';
            ?>
        </div>
    </div>
    <div id="resultado"></div>







    <?php
} else {
    session_destroy();
    echo "<script>location.href ='../../login.php'</script>";
}
?>

<script>
    function genera_codigo_tarifa(tipo_tarifa) {
        var codigo = "";
        if (tipo_tarifa == "personalizada") {
            //generamos el codigo
            codigo = generaCodigo();
            $('#codigo_tarifa_personalizada').val(codigo);
        } else {
            codigo = generaCodigo();
            $('#codigo_tarifa_estandar').val(codigo);
        }

    }

    function genera_tarifa(tipo_tarifa, tipo_usuario, id_usuario, id_empresa) {
        //tomamos los valores de los campos de la tarifa 

        if (tipo_tarifa == "personalizada") {
            var codigo = $('#codigo_tarifa_personalizada').val();
            var valor = $('#valor_tarifa_personalizada').val();
        } else {
            var codigo = $('#codigo_tarifa_estandar').val();
            var valor = $('#valor_tarifa_estandar').val();
        }

        if (codigo == "" || valor == "") {
            alertify.alert('<b>Para crear una tarifa ' + tipo_tarifa + ' es necesario que diligencie ambos campos.</b>');
            return;
        }
        //enviamos los datos por ajax
        alertify.confirm('Desea crear la tarifa ' + tipo_tarifa + ' con los datos diligenciados?', function (e) {
            if (e) {

                var parametros = {
                    "codigo": codigo,
                    "valor": valor,
                    "tipo_tarifa": tipo_tarifa,
                    "tipo_usuario": tipo_usuario,
                    "id_usuario": id_usuario,
                    "id_empresa": id_empresa
                };
                $.ajax({
                    data: parametros,
                    url: 'pages/backend/includes/crea_tarifa.php',
                    type: 'post',
                    success: function (response) {
                        $("#resultado").html(response);

                        alertify.alert("<P align=center><b>Tarifa " + tipo_tarifa + " creada correctamente!", function () {

                            window.setTimeout('location.reload()');
                        });
                    }
                });
            } else {
                alertify.error('Cancelado');
            }
        });


    }

    function generaCodigo() {
        var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHJKMNPQRTUVWXYZ2346789";
        var contrasena = "";
        for (i = 0; i <= 4; i++)
            contrasena += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        contrasena = contrasena.toUpperCase();
        return(contrasena)
    }

    function eliminar_tarifa(tipo_tarifa, id_tarifa) {

        //enviamos los datos por ajax
        alertify.confirm('Desea eliminar la tarifa ' + tipo_tarifa + ' seleccionada?', function (e) {
            if (e) {

                var parametros = {
                    "id_tarifa": id_tarifa,
                    "tipo_tarifa": tipo_tarifa
                };
                $.ajax({
                    data: parametros,
                    url: 'pages/backend/includes/elimina_tarifa.php',
                    type: 'post',
                    success: function (response) {
                        //$("#resultado").html(response);

                        alertify.alert("<P align=center><b>Tarifa " + tipo_tarifa + " eliminada correctamente!", function () {

                            window.setTimeout('location.reload()');
                        });
                    }
                });
            } else {
                alertify.error('Cancelado');
            }
        });
    }
</script>