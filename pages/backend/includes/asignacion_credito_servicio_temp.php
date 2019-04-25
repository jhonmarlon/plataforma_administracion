<?php
session_start();
if ($_SESSION ['authenticated'] == 1) {

    include '../../../modelo/conexion.php';

    $conn = new conexion();

    $id_temp = $_POST["id_temp"];
    $id_usuario = $_POST["id_usuario"];
    $id_distribuidor = $_POST["id_distribuidor"];

    $conn->ejecutar_consulta_simple("DELETE FROM usuario_tarifa_servicio_temp WHERE "
            . "id='$id_temp'");

    $registro_temporal = $conn->getCreditoServicioTemp($id_usuario, $id_distribuidor);
}
?>
<?php if (mysqli_num_rows($registro_temporal) != 0) { ?>

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
<?php } ?>