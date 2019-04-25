<?php
session_start();
if ($_SESSION ['authenticated'] == 1) {

    include "../../modelo/conexion.php";
    $conn = new conexion();

    $id_perfil_tarifa = $_POST['id_perfil_tarifa'];
    $nombre_perfil=$_POST["nombre_perfil"];

    $detalle_tarifa = $conn->ejecutar_consulta_simple("SELECT te.id,te.nombre,ser.nombre as 'servicio',tar_ser.valor as 'valor' FROM perfil_tarifa_empresa te
                INNER JOIN tarifa_servicio tar_ser ON tar_ser.id_tarifa=te.id 
                INNER JOIN servicios ser ON ser.id=tar_ser.id_servicio WHERE te.estado='A' AND te.id='$id_perfil_tarifa'");
}
?>
<div><label><b><font color='blue'>NOMBRE DE PERFIL: </font><br><?php echo $nombre_perfil ?></b></label></b></div><br>
<div class="datagrid">

    <table>
        <thead>
            <tr>
                <th><label>SERVICIO</label></th>
                <th><label>VALOR</label></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($detalle_perfil_tarifa = $detalle_tarifa->fetch_assoc()) { ?>
            <td><label><?php echo $detalle_perfil_tarifa["servicio"] ?></label></td>
            <td><label><?php echo $detalle_perfil_tarifa["valor"] ?></label></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>