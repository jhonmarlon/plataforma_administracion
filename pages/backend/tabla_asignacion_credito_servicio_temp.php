<?php
session_start();

if ($_SESSION ['authenticated'] == 1) {

    include '../../modelo/conexion.php';

    $conn = new conexion();

    $id_usuario = $_POST["id_usuario"];
    $id_distribuidor = $_POST["id_distribuidor"];

//si existen es porque van a ingresar un nuevo servicio temporal
    if (isset($_POST["id_servicio"]) && isset($_POST["monto_permitido_venta"])) {

        $id_servicio = $_POST["id_servicio"];
        $monto_permitido_venta = $_POST["monto_permitido_venta"];

        //validamos que el servicio no exista en la tabla temporal
        $servicio_existe = $conn->ejecutar_consulta_simple("SELECT id FROM usuario_tarifa_servicio_temp  WHERE "
                . "id_usuario_resp='$id_usuario' AND id_usuario_aprobar='$id_distribuidor' AND "
                . "id_servicio='$id_servicio'");

        if (mysqli_num_rows($servicio_existe) != 0) {
            echo "<script> 
                  alertify.alert('<b>El servicio que intenta agregar ya se encuentra en la lista.</b>');
            </script>";
        } else {
//Creamos el registro en la tabla de credito temporal
            $conn->asignaCreditoServicioTemp($id_usuario, $id_distribuidor, $id_servicio, $monto_permitido_venta);
        }
    }
    //tomamos los valores del temportal quen hayan hasta el momento
    $registro_temporal = $conn->getCreditoServicioTemp($id_usuario, $id_distribuidor);
    ?>
    <?php if(mysqli_num_rows($registro_temporal) != 0) { ?>
        <div class="datagrid">
            <table>
                <thead>
                    <tr>
                        <th>Nombre Servicio</th>
                        <th>Monto Asignado</th>
                        <th>Eliminar</th>
                    </tr> 

                </thead>
                <tbody>

                    <?php while ($registro = $registro_temporal->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $registro["nombre"] ?></td>
                            <td> <?php echo "$ " . $registro["monto_permitido_venta"] ?></td>
                            <td><button onclick="elimina_servicio_temp('<?php echo $registro["id"] ?>', '<?php echo $id_usuario ?>',
                                                '<?php echo $id_distribuidor ?>')"><span class="glyphicon glyphicon-remove"></span></button></td>

                        </tr>  

                    <?php }
                    ?>


                </tbody>

            </table>
        </div>



    <?php }
} ?>


<script>
    function elimina_servicio_temp(id_temp, id_usuario, id_distribuidor) {

        $.ajax({
            type: "POST",
            url: "pages/backend/includes/asignacion_credito_servicio_temp.php",
            data: {
                id_temp: id_temp,
                id_usuario: id_usuario,
                id_distribuidor: id_distribuidor

            },
            success: function (data) {
                       //limpiamos la tabla y la volvemos a llenar
                       $("#resultado").html("");
                       $("#resultado").html(data);
                    }

        });
    }
</script>

