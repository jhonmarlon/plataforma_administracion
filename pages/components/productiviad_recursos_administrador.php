
<link rel="stylesheet" href="dist/css/data_tables.css">

<?php

function printColaboradores($conn, $id_user) {

    $consulta = "select u.id_usuario,u.nombre,u.apellido,r.descripcion,u.cedula,u.correo,u.telefono,u.celular,"
            . "u.valor_cuenta, COUNT(cu.id_cuenta_usuario) as num_cuentas from usuario u LEFT JOIN "
            . "cuenta_usuario cu on cu.id_cuenta_usuario=u.id_usuario INNER JOIN rol r on r.id_rol=u.id_rol "
            . "where u.id_usuario <> '$id_user' GROUP by u.id_usuario order by u.nombre,u.apellido asc";
  
    //$num = $num_cuentas->fetch_array();
    if ($consulta = $conn->conexion->query($consulta)) {
        while ($obj = $consulta->fetch_object()) {
            ?>
            <tr>
                <td><a href="" title="Ver detalle de usuario" class="glyphicon glyphicon-user"></a></td>
                <td><?php printf($obj->nombre); ?></td>
                <td><?php printf($obj->apellido); ?></td>
                <td><?php printf($obj->cedula); ?></td>
                <td><?php printf($obj->descripcion); ?></td>
                <td><?php printf($obj->correo); ?></td>
                <td><?php printf($obj->telefono); ?></td>
                <td><?php printf($obj->celular); ?></td>
               <!-- <td><?php
                echo "$";
                printf($obj->valor_cuenta);
                ?></td>-->
                <td><?php
                    echo "$";
                    printf($obj->valor_cuenta);
                    ?></td>              
                <td><?php printf($obj->num_cuentas) ?></td>


            </tr>
            <?php
            //printColaboradores($obj->cedula,$conn);
        }
        $consulta->close();
    }
}
?>


<!-- /.row -->

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <div class="col-md-12">
        <!-- MAP & BOX PANE -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 style="font-family: -webkit-pictograph;" class="box-title">Mis Colaboradores</h3>

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
                      <!--  <section class="webdesigntuts-workshop">
                            <form action="" method="">		    
                                <input type="search" placeholder="What are you looking for?">		    	
                                <button>Search</button>
                            </form>


                        </section> -->                        <div class="pad">


                            <!-- Map will be created here -->
                            <div class="datagrid">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th> 
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Cédula</th>
                                            <th>Perfil</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Celular</th>
                                            <!--<th>Saldo actual</th>-->
                                            <th>Valor cuenta</th>
                                            <th>N° cuentas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $conn = new conexion();
                                        $id_user = $userinfo->id_usuario;

                                        printColaboradores($conn, $id_user);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.TABLA DE DATA TABLE -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>