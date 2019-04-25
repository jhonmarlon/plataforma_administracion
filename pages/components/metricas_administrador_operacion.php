
<?php
$con = new conexion();
$id_usuario = $userinfo->user_id;

$num_cuentas = $con->getNumCuentasAct($id_usuario);
//$num_cuentas = $con->getNumCuentas($id_usuario);
//$numeroactividades = $wish->getProductividadColaboradores($userinfo->user_id);
//$contratos = $wish->getContratosByLider($userinfo->user_id);
//$pendientes = $wish->getPendientesByLider($userinfo->user_id);
?>
<div class="row">        

    <!-- ./col -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-credit-card" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">Cuentas cargadas,     mes actual</div><br>
                <div class="number">
                    <a href="#"  >
                        <span class="count"><?php
                            $num = $num_cuentas->fetch_array();
                            echo $num[0];
                            ?></span>
                    </a>
                </div>
            </div>

        </div>

    </div>
    <!-- ./col -->

    <div class="col-md-3 col-sm-6 ">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-line-chart" aria-hidden="true"></i>
            </div>


            <div class="content">
                <div class="text">Productividad mensual</div><br>
                <?php
                ?>
                <div class="number">
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-history" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">Solicitudes pendientes</div><br>
                <div class="number">
                    <a href="index.php?page=014"> 
                        <?php
                        //echo $aux . "<br/>\n";
                        ?></a>
                </div>

            </div>			
        </div>
    </div>


    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-check-square-o" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">Solicitudes tomadas</div><br>
                <div class="number">
                    <a href="index.php?page=009"> 
                        <?php
                        //echo $aux . "<br/>\n";
                        ?></a>
                </div>

            </div>			
        </div>
    </div>

</div>
<!-- /.row -->
