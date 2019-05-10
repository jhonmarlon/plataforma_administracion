<?php
//include 'pages/tablero/body_pages.php';
$conn = new conexion();
$id_usuario = $userinfo->id_usuario;
$id_empresa = $userinfo->id_empresa;
//tomamos los servicios creados
$servicios = $conn->getServicios($id_usuario);



$clientes = $conn->getUsuarios("cliente", $id_empresa, "0");
$distribuidores = $conn->getUsuarios("usuario", $id_empresa, "3");


$perfiles_tarifa = $conn->getPerfilTarifaEmpresa($id_usuario, $id_empresa);
?>


<div class="box box-success">
    <div class="box-header with-border">
        <!-- Barra de progreso -->
        <div class="progress progress-sm active">
            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
            </div>
        </div>
        <h3>Asignar Perfiles de Tarifa</h3>

        <div class="form-group" >
            <div class="row" >
                <div class="col-md-6">
                    <div class="search">
                        <input type="text" id="txt_buscar_vendedores" class="form-control input-sm" maxlength="64" placeholder="Buscar..." />
                        <button type="submit" id="btn_search" class="btn btn-primary pull-left">Buscar</button>
                    </div>   </div><br><br><br><br>
                <div class="col-md-12">
                    <div class="datagrid">
                        <div style=" width: 101.5%; height:280px; overflow-y: scroll;">
                            <table id="mis_servicios">
                                <thead>
                                    <tr>
                                        <th>Tarifa N°</th>
                                        <th>Nombre de Perfil</th>
                                        <th>Código de Perfil</th>
                                        <th>Ver Detalles</th>
                                        <th>Asignar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cont = 1;
                                    while ($perfiles_tarifa_activos = $perfiles_tarifa->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><label><?php echo $cont; ?></label></td>
                                            <td><label id="nombre_servicio<?php echo $cont ?>"><?php echo $perfiles_tarifa_activos["nombre"] ?></label></td>
                                            <td><label id="nombre_servicio<?php echo $cont ?>"><?php echo $conn->decryption($perfiles_tarifa_activos["codigo"]) ?></label></td>
                                            <td><button  id="detalle_tarifa" title="Ver Detalles" type="submit" class="btn btn-default" 
                                                         onclick="detalle_tarifa('<?php echo $perfiles_tarifa_activos["id"] ?>', '<?php echo $perfiles_tarifa_activos["nombre"] ?>')">Detalles</button></td>

                                            <td><button onclick="asigna_perfil_tarifa('<?php echo $perfiles_tarifa_activos["id"] ?>', '<?php echo $perfiles_tarifa_activos["nombre"] ?>', '<?php echo $id_empresa ?>')" id="editar_servicio" title='Editar Servicio' type="submit" class="btn btn-default" 
                                                        data-target="" data-toggle="modal">Asignar</button></td>
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

<!--MODAL DE DETALLE DE PERFIL-->
<div id="detalle_perfil" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <h3 class="modal-title">Detalles de Perfil</h3>
            </div>
            <div class="modal-body">
                <div id="resultado"></div>
            </div>
            <div class="modal-footer">
                <button type="button"   class="btn btn-success" data-dismiss="modal" aria-label="Close" class="btn btn-danger">Aceptar</button>
            </div>  
        </div>
    </div>
</div>


<!--MODAL ASIGNACION DE PERFIL-->
<div id="asignar_perfil" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <h3 class="modal-title">Asignar Perfil</h3>
            </div>
            <div class="modal-body">
                <label style="color: blue"><strong>NOMBRE DE PERFIL: </strong></label><br><label id="nombre_perfil"></label><br><br>
                <label>Tipo de usuario a asignar perfil:</label><br>
                <ul class="buttons">
                    <li><input required id="cliente" class="radiobtn"  name="rbtnTipoVendedor" type="radio" value="cliente" tabindex="1" onclick="cerrar()" > <span></span>
                        <label for="cliente" id="r1">Cliente</label>
                        <input required id="distribuidor" class="radiobtn" name="rbtnTipoVendedor" type="radio" value="distribuidor" tabindex="2" onclick="cerrar()" > 
                        <span></span> <label for="distribuidor" id="r2">Distribuidor</label><br>
                </ul>
 
                <div id="select_clientes" style="display: none">
                    <label>Clientes</label><br>
                    <select class="form-control multi-select-dd"  id="clientes" style="display: none" multiple="multiple">
                        <?php while ($cliente = $clientes->fetch_assoc()) { ?>
                            <option value="<?php echo $cliente["id"] ?>"><?php echo $cliente["nombre"] . " " . $cliente["apellido"] ?></option>
                        <?php } ?>
                    </select>                
                </div>
                <div id="select_distribuidores" style="display: none">
                    <label>Distribuidores</label><br>
                    <select class="form-control multi-select-dd"   id="clientes" style="display: none" multiple="multiple">
                        <?php while ($cliente = $clientes->fetch_assoc()) { ?>
                            <option value="<?php echo $cliente["id"] ?>"><?php echo $cliente["nombre"] . " " . $cliente["apellido"] ?></option>
                        <?php } ?>
                    </select>
                </div>


                <div id="resultado_asignacion"></div>

            </div>
            <div class="modal-footer">
                <button type="button"   class="btn btn-success" data-dismiss="modal" aria-label="Close" class="btn btn-danger">Aceptar</button>
            </div>  
        </div>
    </div>
</div>
<script>
    function detalle_tarifa(id_perfil_tarifa, nombre_perfil) {


        $.ajax({

            type: 'POST',

            url: 'pages/backend/muestra_detalle_tarifa.php',

            data: {
                id_perfil_tarifa: id_perfil_tarifa,
                nombre_perfil: nombre_perfil
            },

            success: function (data)
            {
                $("#resultado").html(data);
                //mostramos modal
                $("#detalle_perfil").modal("show");

            }
        });

    }


    function asigna_perfil_tarifa(id_perfil_tarifa, nombre_perfil, id_empresa) {
    $("#nombre_perfil").text(nombre_perfil);

        $.ajax({

            type: 'POST',

            url: 'pages/backend/asigna_perfil_tarifa.php',

            data: {
                id_perfil_tarifa: id_perfil_tarifa,
                nombre_perfil: nombre_perfil,
                id_empresa: id_empresa,
            },

            success: function (data)
            {
                $("#resultado_asignacion").html(data);
                //mostramos modal
                $("#asignar_perfil").modal("show");

            }
        });
    }

    $("#cliente").on("click", function () {
        $('#select_clientes').css("display", "block");
        $('#select_distribuidores').css("display", "none");

    });
    $("#distribuidor").on("click", function () {
        $('#select_distribuidores').css("display", "block");
        $('#select_clientes').css("display", "none");
    }
    );

</script>

