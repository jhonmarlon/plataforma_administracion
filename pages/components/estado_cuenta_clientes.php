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
    include 'pages/components/metricas_vendedor_mayorista.php';
} else {
    include 'pages/components/metricas_administrador.php';
}

$conn = new conexion();

$clientes = $conn->getClientes($id_usuario, $id_rol);

if (mysqli_num_rows($clientes) == 0) {
    echo "<script> 
                  alertify.alert('<P align=center><b><font color=red>IMPORTANTE</font>'+
                  '<p>No se ha creado ningún cliente en este perfil.<p>', 
                  function () {

                            window.location = 'index.php';
                        });
            </script>";

    return;
} else {
    ?>

    <div class="row">
        <div class="col-md-6"> 
            <label>Clientes</label>


        </div>
    </div>


    <div id="cliente">
        <ul class="list" style="list-style-image: url('dist/img/user_icono.png')">
            <?php while ($cli = $clientes->fetch_assoc()) { ?>
                <li><a href="" onclick="crea_detalle(<?php echo $cli["id_cliente"] ?>,<?php echo $id_usuario ?>);return false;"><?php echo $cli["nombre"] . " " . $cli["apellido"] ?></a></li>
            <?php } ?>
        </ul>
        <ul class="pagination"></ul>
    </div>
    <?php
}
?>




<script>
    var monkeyList = new List('cliente', {
        valueNames: ['name'],
        page: 5,
        pagination: true
    });

    function crea_detalle(id_cliente,id_usuario) {
        //enviamos los valores por ajax para crear el detalle
        var parametros = {
            "id_cliente": id_cliente,
            "id_usuario": id_usuario,
            //"tipo": tipo
        };
        $.ajax({
            data: parametros,
            url: 'pages/backend/crea_detalle_cuenta_clientes.php',
            type: 'post',

            success: function (response) {
                $("#resultado_detalle").html(response);
            }
        });



    }

</script>

<div id="resultado_detalle"></div>