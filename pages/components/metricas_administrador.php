
<?php
$user_id = $userinfo->id_usuario;

$num_vendedores = $con->getNumVendedores();
//$numeroactividades = $wish->getProductividadColaboradores($userinfo->user_id);
//$contratos = $wish->getContratosByLider($userinfo->user_id);
//$num_colaboradores = $con->getNumColaboradores($user_id);
//$num_cuentas_cargadas = $con->getNumCuentasCargadas();
//$num_solicitues = $con->getNumSolicitudes($user_id);

/*$solicitudes_usuario = $con->conexion->query("select count(a.id_solicitud) from
solicitud a,usuario b where a.id_cliente_usuario=b.id_usuario and
a.id_usuario_resp='$user_id' and a.id_solicitud not in 
(select id_solicitud from respuesta_solicitud) order by a.fecha_requerimiento desc");
$aux = $solicitudes_usuario->fetch_array();*/

//$aux = $aux[0];
?>


<div class="row">        
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-aqua">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">N° Colaboradores</div><br>
                <div class="number">
                    <?php
                    //$num_colab = $num_colaboradores->fetch_array();
                    //echo $num_colab[0] . "<br/>\n";
                    ?></div>
            </div>
        </div>
    </div>	


    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-line-chart" aria-hidden="true"></i>
            </div>
            <div class="content">
                <a href="index.php?page=006"  >
                    <div class="text">Cuentas cargadas</div><br>
                    <div class="number">
                        <?php
                        ?>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-green">
                <i class="fa fa-file" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">Mis Solicitudes pendientes</div><br>
                <div class="number">
                    <a href="index.php?page=008"> 
                        <?php
                       // echo $aux . "<br/>\n";
                        ?></a></div>

            </div>			
        </div>
    </div>	

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-yellow">
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">Productividad mensual</div><br>
                <div class="number">
                    <a href="index.php?page=010"> 
                        <?php /*
                          while ( $row = $pendientes->fetch_array ( MYSQLI_NUM ) ) {
                          echo $row [0] . "<br/>\n";
                          }
                         */ ?></a></div>
            </div>
        </div>
    </div>	


</div>
<!-- /.row -->
