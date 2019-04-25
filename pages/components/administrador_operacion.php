


<style>
    .scrollbar
    {
        margin-left: 30px;
        float: left;
        height: 300px;
        width: 65px;
        background: #F5F5F5;
        overflow-y: scroll;
        margin-bottom: 25px;
    }
    .select2-container--default .select2-selection--single
    {
        border-radius: 0;
        border-color: #d2d6de;
        width: 100%;
        height: 34px;
    }

    #ver{

        left: 0px;
        margin-left: 10px;


    }

    a{

        text-decoration: none;
        padding: 8px;

    }

</style>
<style>
    .btn-success{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #3e6b2f), color-stop(1, #09bb58) );
        color: white;
        width: 150px;
        height: 32px;  
        border-radius: 3px}

    .btn-success:hover{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #408163), color-stop(1, #18a11f) );
    }

    .btn-danger{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #841b1b), color-stop(1, #ff2020) );
        color: white;
        width: 150px;
        height: 32px;
        border-color: #d73925;
        border-radius: 3px
    }

    .select2-container--default .select2-selection--single
    {
        border-radius: 0;
        border-color: #d2d6de;
        width: 100%;
        height: 34px;
    }


</style>
<?php $id_usuario_crea = $userinfo->user_id; ?>

<script>
    window.onload = function () {
        var fecha = new Date(); //Fecha actual
        var mes = fecha.getMonth() + 1; //obteniendo mes
        var dia = fecha.getDate(); //obteniendo dia
        var ano = fecha.getFullYear(); //obteniendo año
        if (dia < 10)
            dia = '0' + dia; //agrega cero si el menor de 10
        if (mes < 10)
            mes = '0' + mes //agrega cero si el menor de 10
        document.getElementById('f_creacion_net').value = ano + "-" + mes + "-" + dia;
    }
</script>

<input type="hidden" id="crea_cuenta_net" value="<?php echo $id_usuario; ?>">

<?php

function printCuentasCreadas($conn, $id_usuario) {
    //lista de usuarios
    $consulta = "select * from cuenta_netflix_act where id_usuario_crea='$id_usuario' and estado='1' order by id_cuenta_netflix_act desc";

    if ($consulta = $conn->conexion->query($consulta)) {
        $i = 1;
        while ($obj = $consulta->fetch_object()) {
            ?>
            <tr>
                <!--<td><input id="check<?php echo $i ?>" type="checkbox" name="check" required></td>-->
                <td><label id="id_cuenta_net<?php echo $i ?>"><?php printf($obj->id_cuenta_netflix_act); ?></label></td>
                <td><label id="fecha_net<?php echo $i ?>"><?php printf($obj->fecha_creacion); ?></label></td>
                <td><label id="dias_servicio_dispo<?php echo $i ?>"><?php printf($obj->dias_servicio_disponibles) ?></label></td>
                <td><label id="fecha_vecimiento<?php echo $i ?>"><?php printf($obj->fecha_vencimiento) ?></label></td>
                <td><label id="user_net<?php echo $i ?>"><?php printf($obj->usuario); ?></label></td>
                <td><label title="<?php echo $i ?>" id="pass_net<?php echo $i ?>"><?php printf($obj->clave); ?></label></td>

                <td><label id="estado_net<?php echo $i ?>"><?php
                        if (($obj->estado) != '0') {
                            echo "<font color='green'><b>Activa</b></font>";
                        } else {
                            echo "<font color='red'><b>Inactiva</b></font>";
                        }
                        ?></label></td>
                <td>
                    <button onclick="editar_cuenta(<?php printf($obj->id_cuenta_netflix_act) ?>)" id="upda" type="submit" class="btn btn-default" 
                            data-target="#edita_analisis" data-toggle="modal" title="Editar Vendedor" ><img src="dist/img/refresh-icon.png" /></button>
                    <!--<button onclick="editar_cuenta()">Editar</button></td>-->

                </td>


            </tr>

            <?php
            $i++;
            //printColaboradores($obj->cedula,$conn);
        }
        $consulta->close();
    }
}

//tabla gmail modal
function tabla_editar_netflix_modal() {
    ?>


    <label>Usuario:</label></td>
    <input id="nuevo_usuario_netflix" class="form-control" type="email" placeholder="CORREO">

    <label>Clave:</label>
    <input id="nueva_clave_netflix" class="form-control" type="password" placeholder="CLAVE">




    <?php
}

function tabla_creacion_netflix() {
    ?>


    <label>Fecha de creación de la cuenta:</label>
    <input id="f_creacion_net" type="date" value="<?php echo $fecha_actual ?>" name="f_creacion_net" placeholder="Fecha de creación" class="form-control" style="width: 100%;"  required>

    <label>Periodo de uso:</label>
    <select id="periodo_uso" name="periodo_uso" class="form-control" style="width: 100%;"  required>
        <option selected disabled value="0">Seleccione periodo</option>
        <option value="30">Un Mes</option>
        <option value="60">Dos Meses</option>
        <option value="90">Tres Meses</option>
    </select>

    <label>User:</label>
    <input id="user_net" type="text"name="user_net" placeholder="USER" class="form-control" style="width: 100%;"  required>

    <label>Pass:</label>
    <input id="pass_net" type="text"name="pass_net" placeholder="PASS" class="form-control" style="width: 100%;"  required>


    <br><br>

<?php }
?>



<!-- /.row -->

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        <!-- MAP & BOX PANE -->
        <div class="box box-success">
            <div class="box-header with-border">
                <div class="row">


                    <div class="col-md-6" >
                        <div class="row" class="form-control"><h2 style="padding: 15px;">Nueva cuenta</h2></div><br>

                        <h3 style="font-family: -webkit-pictograph;" class="box-title">Información cuenta Netflix</h3><br><br>

                        <?php tabla_creacion_netflix() ?>

                        <button  class="btn-success" onclick="crear_cuenta()">Crear cuenta</button>
                    </div>

                </div>

                <br><br><h3 style="font-family: -webkit-pictograph;" class="box-title">Información detallada cuentas Netflix</h3>

                <br><br><div class="search">
                    <input type="text" id="txt_buscar_cuentas_netflix" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                    <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
                </div>

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


                            <!-- Map will be created here -->
                            <div class="datagrid">
                                <div style=" width: 101.5%; height:280px; overflow-y: scroll;">

                                    <table id="tbl_cuentas_netflix" class="table table-striped table-bordered">
                                        <thead>

                                            <tr>                                            <!-- info cuenta gmail-->
                                                <!--<th></th>-->
                                                <!-- info cuenta netflix-->
                                                <th><b>ID cuenta</b></th>
                                                <th><strong>Fecha de creación</strong></th>
                                                <th><strong>Dias Servicio Dispo</strong></th>
                                                <th><strong>Fecha Vencimiento</strong></th>
                                                <th><strong>User</strong></th>
                                                <th><strong>Pass</strong></th>                                         
                                                <th><strong>Estado</strong></th>
                                                <th><strong>Editar</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $conn = new conexion();
                                            $id_usuario = $userinfo->user_id;

                                            printCuentasCreadas($conn, $id_usuario);
                                            ?>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.TABLA DE DATA TABLE -->
                </div>
                <!-- /.row -->
            </div>
            <div id="resultado"></div>
            <input type="hidden" id="resultado_asignacion">
            <div id="resultado_1"></div>

            <!-- /.box-body -->
        </div>
    </div>
</div>




<script>



    function crear_cuenta() {

        var f_creacion_net = document.getElementById("f_creacion_net").value;
        var user_net = document.getElementById("user_net").value;
        var pass_net = document.getElementById("pass_net").value;
        var crea_cuenta_net = document.getElementById("crea_cuenta_net").value;
        var periodo_uso = document.getElementById("periodo_uso").value;


        if (f_creacion_net == '' || user_net == '' || pass_net == "" || periodo_uso == "0") {

            alertify.alert('<P align=center>Antes de guardar ,debe estar seguro de que  <font color="red"><b>Todos los campos</b></font> estén completos y correctamente diligenciados');
            return;
        }


        alertify.confirm('Desea crear una cuenta con datos diligenciados?', function (e) {
            if (e) {

                var parametros = {
                    "f_creacion_net": f_creacion_net,
                    "user_net": user_net,
                    "pass_net": pass_net,
                    "crea_cuenta_net": crea_cuenta_net,
                    "periodo_uso": periodo_uso,

                };
                $.ajax({
                    data: parametros,
                    url: 'pages/backend/includes/ingresa_nueva_cuenta.php',
                    type: 'post',
                    success: function (response) {
                        alertify.alert("<P align=center><b>Cuenta creada correctamente!", function () {

                            window.setTimeout('location.reload()');
                        });
                        $("#resultado_1").html(response);

                    }
                });
            } else {
                alertify.error('Cancelado');
            }
        });



    }


    function editar_cuenta(id_cuenta) {
        $("#cuenta_modificar").val(id_cuenta);
        $('#mdl_modificar_cuenta').modal({show: 'false', backdrop: 'static', keyboard: false});

    }



    function actualiza_datos_cuenta() {
        //datos gmail
        var nuevo_usuario_netflix = $("#nuevo_usuario_netflix").val();
        var nueva_clave_netflix = $("#nueva_clave_netflix").val();
        var cuenta_modificar = $("#cuenta_modificar").val();


        alertify.confirm('Desea guardar los datos diligenciados para la cuenta?', function (e) {
            if (e) {
                var parametros = {
                    "nuevo_usuario_netflix": nuevo_usuario_netflix,
                    "nueva_clave_netflix": nueva_clave_netflix,
                    "cuenta_modificar": cuenta_modificar
                };
                $.ajax({
                    data: parametros,
                    url: 'pages/backend/includes/actualiza_cuenta.php',
                    type: 'post',
                    success: function (response) {
                        alertify.alert("<P align=center><b>Cambios realizados correctamente!", function () {

                            window.setTimeout('location.reload()');
                        });
                        $("#resultado_1").html(response);

                    }
                });
            } else {
                alertify.error('Cancelado');
            }
        });


    }

//filtro de busqueda para clientes 
    $(document).ready(function () {
        $("#txt_buscar_cuentas_netflix").keyup(function () {
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#tbl_cuentas_netflix tbody tr"), function () {
                if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                    $(this).hide();
                else
                    $(this).show();
            });
        });
    });

</script>




<!--Modal detalles-->
<!-- INICIO DE MODAL CONFIGURAR CUENTA- modificar -->
<div id="mdl_modificar_cuenta" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;" >
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Operación Netflix - Editar</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="cuenta_modificar">
                <?php tabla_editar_netflix_modal(); ?>


            </div><br>
            <div class="modal-footer">
                <button type="submit" onclick="actualiza_datos_cuenta()" class="btn btn-success"><i class="fa fa-pencil"></i>Editar</button>
                <button type="reset" data-dismiss="modal" aria-hidden="true" class="btn btn-danger"><i class="fa fa-times"></i>Cancelar</button>

            </div>
        </div>

    </div>
</div>



<link rel="stylesheet" href="plugins/select2/select2.css">

