<script src="plugins/list/list.min.js"></script>

<style>
    a:hover, a:active, a:focus {
        outline: none;
        text-decoration: none;
        color: #db2828;
    }

    .pagination li {
        display:inline-block;
        padding:5px;
    }

</style>
<?php
$id_usuario = $userinfo->user_id;
//tomamos el rol del usuario para saber si es administrador o vendedor
//si es administrador , mostraremos todos los vendedores
$id_rol = $userinfo->id_rol;

if ($id_rol != 1) {
    include 'pages/components/metricas_distribuidor.php';
} else {
    include 'pages/components/metricas_administrador.php';
}

$conn = new conexion();

$vendedores_privilegiados = $conn->getVendedoresPrivilegiados($id_usuario, $id_rol);
$vendedores_no_privilegiados = $conn->getVendedoresNoPrivilegiados($id_usuario, $id_rol);

$pri = mysqli_num_rows($vendedores_privilegiados);
$no_pri = mysqli_num_rows($vendedores_no_privilegiados);


if (($pri == 0) && ($no_pri == 0)) {

    echo "<script> 
                  alertify.alert('<P align=center><b><font color=red>IMPORTANTE</font>'+
                  '<p>No se ha creado ningún vendedor en este perfil.<p>', 
                  function () {

                            window.location = 'index.php';
                        });
            </script>";

    return;
} else {
    ?>

    <div class="row">
        <div class="col-md-6">

            <label>Vendedores sin Privilegios</label>
            <ul>
                <?php usuariosNoPrivilegiados($conn, $id_usuario, $id_rol) ?>
            </ul>

        </div>

        <div class="col-md-6">
            <label>Vendedores con Privilegios</label>
            <ul>
                <?php usuariosPrivilegiados($conn, $id_usuario, $id_rol) ?>
            </ul>
        </div>
    </div>
    <div id="resultado_detalle"></div>


<?php } ?>


<script>

    function crea_detalle(id_vendedor, id_usuario, tipo) {

        //enviamos los valores por ajax para crear el detalle
        var parametros = {
            "id_vendedor": id_vendedor,
            "id_usuario": id_usuario,
            "tipo": tipo
        };
        $.ajax({
            data: parametros,
            url: 'pages/backend/crea_detalle_cuenta_vendedores.php',
            type: 'post',

            success: function (response) {
                $("#resultado_detalle").html(response);
            }
        });



    }

</script>



<?php

function usuariosPrivilegiados($conn, $id_usuario, $id_rol) {

    $vendedores_privilegiados = $conn->getVendedoresPrivilegiados($id_usuario, $id_rol);
    ?>

    <div id="usuario_pri">
        <ul class="list" style="list-style-image: url('dist/img/user_icono.png')">
            <?php while ($vende_pri = $vendedores_privilegiados->fetch_assoc()) { ?>
                <li><a href="" onclick="crea_detalle(<?php echo $vende_pri["id_vendedor"] ?>,<?php echo $id_usuario ?>, '1');return false;"><?php echo $vende_pri["nombre"] . " " . $vende_pri["apellido"] ?></a></li>
            <?php } ?>
        </ul>
        <ul class="pagination"></ul>
    </div>
    <?php
}

function usuariosNoPrivilegiados($conn, $id_usuario, $id_rol) {

    $vendedores_no_privilegiados = $conn->getVendedoresNoPrivilegiados($id_usuario, $id_rol);
    ?>

    <div id="usuario_no_pri">
        <ul class="list" style="list-style-image: url('dist/img/user_icono.png')">
            <?php while ($vende_no_pri = $vendedores_no_privilegiados->fetch_assoc()) { ?>
                <li><a href=""  onclick="crea_detalle(<?php echo $vende_no_pri["id_vendedor"] ?>,<?php echo $id_usuario ?>, '0');return false;"><?php echo $vende_no_pri["nombre"] . " " . $vende_no_pri["apellido"] ?></a></li>
            <?php } ?>
        </ul>
        <ul class="pagination"></ul>
    </div>

    <?php }
?>




<script>
    var monkeyList = new List('usuario_pri', {
        valueNames: ['name'],
        page: 5,
        pagination: true
    });

    var monkeyList = new List('usuario_no_pri', {
        valueNames: ['name'],
        page: 5,
        pagination: true
    });
</script>