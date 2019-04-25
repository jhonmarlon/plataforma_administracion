<?php
$conn = new conexion();

if (isset($_SESSION["id_su"])) {
    $tarifas_estandar = $conn->getTarifasEstandar($super_userinfo->id_empresa_su);
    $nombre_empresa = $super_userinfo->nombre_empresa_su;
    $codigo_empresa = $super_userinfo->codigo_empresa_su;
    $codigo_usuario = $super_userinfo->codigo_su;
} else {
    $tarifas_estandar = $conn->getTarifasEstandar($userinfo->id_empresa_usr);
    $nombre_empresa = $userinfo->nombre_empresa_usr;
    $codigo_empresa = $userinfo->codigo_empresa_usr;
    $codigo_usuario = $userinfo->codigo;
}
?>
<h3>Tarifas Estandar - <?php echo $nombre_empresa ?></h3>
<?php if ($su == 1) { ?>
    <label>Código</label>
    <div class="input-group">
        <span class="input-group-addon"><input  type="button" onclick="genera_codigo_tarifa('estandar')" style="margin-right: -7px; margin-left: -7px;" value="Generar código"></span>
        <input type="text" id="codigo_tarifa_estandar" class="form-control" readonly >
    </div>
    <label>Valor</label>
    <div class="input-group"> 
        <span class="input-group-addon">$</span>
        <input min="0" type="number" id="valor_tarifa_estandar"  class="form-control"  style="width: 100%;"  required>
    </div><br>

    <button type="button" class="btn btn-success" onclick="genera_tarifa('estandar', '<?php echo $tipo_usuario ?>', '<?php echo $id_usuario ?>', '<?php echo $super_userinfo->id_empresa_su ?>')">Crear Tarifa</button><br><br>

    <?php } ?>

    <div class="datagrid">

        <table>
            <thead>
            <th>Código</th>
            <th>Valor</th>
            <th>Códigos de acceso</th>
            <?php if ($su == 1) { ?>
                <th>Editar</th>
                <th>Eliminar</th>
            <?php } ?>
            </thead>
            <tbody>
                <?php while ($tarifa_est = $tarifas_estandar->fetch_assoc()) { ?>
                    <tr>
                        <td><label id="codigo_est<?php echo $tarifa_est["id_tarifa_estandar"] ?>"><?php echo $conn->decryption($tarifa_est["codigo"]) ?></label></td>
                        <td><label id="valor_est<?php echo $tarifa_est["id_tarifa_estandar"] ?>"><?php echo "$ " . $tarifa_est["valor"] ?></label></td>
                        <td><label id="codigo_acceso<?php echo $tarifa_est["id_tarifa_estandar"] ?>"><?php echo $codigo_empresa . "-" . $codigo_usuario . "-" . $conn->decryption($tarifa_est["codigo"]) ?></label></td>
                        <?php if ($su == 1) { ?>
                            <td><button onclick="editar_tarifa()" id="editar_tarifa" title='Editar Tarifa' type="submit" class="btn btn-default" 
                                        data-target="#edita_tarifa" data-toggle="modal"><img src="dist/img/refresh-icon.png" /></button></td>
                            <td><button onclick="eliminar_tarifa('estandar', '<?php echo $tarifa_est["id_tarifa_estandar"] ?>')" id="eliminar_tarifa" title='Eliminar Tarifa' type="submit" class="btn btn-default">
                                    <img src="dist/img/delete-icon.png" /></button></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
        </tbody>
    </table>
</div>