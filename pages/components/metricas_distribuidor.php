
<?php
/*
  $query = $wish->getActiveTaskForUser ( $user_id );

  $row = mysqli_fetch_array ( $query );
  $numero_filas = mysqli_num_rows ( $query );
  $initialDate = $row ['fecha_inicio'];
 */
$conn = new conexion();
// Actividades del mes
$cantSolicitudesVendedor = $conn->getCantSolicitudVendedor($userinfo->user_id);
$cantClientesVendedor = $conn->getCantClientesVendedor($userinfo->user_id);
$cantVendedoresVendedor = $conn->getCantVendedoresVendedor($userinfo->user_id);
$saldoVendedor = $conn->getSaldoActualVendedor($userinfo->user_id);

$saldoVendedor1 = $conn->getSaldoActualVendedor($userinfo->user_id);
$valor_cuenta = $conn->getValorCuenta($id_usuario);

$val_cuenta=$valor_cuenta->fetch_array();
$val=$val_cuenta[0];


//$saldoVendedor = $conn->getSaldoVendedor($userinfo->user_id);

$user_id = $userinfo->user_id;

/*$solicitudes_usuario = $con->conexion->query("select count(a.id_solicitud) from
solicitud a,usuario b where a.id_cliente_usuario=b.id_usuario and
a.id_usuario_resp='$user_id' and a.id_solicitud not in 
(select id_solicitud from respuesta_solicitud) order by a.fecha_requerimiento desc");
$aux = $solicitudes_usuario->fetch_array();

$aux = $aux[0];
*/

//$eventos_cerrados=$wish->numero_eventos_cerrados($userinfo->user_id);
echo $conn->encryption("CCMNS");
?>

<div class="row">       



    <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
         <div class="info-box hover-zoom-effect">
             <div class="icon bg-blue">
                 <i class="fa fa-envelope" aria-hidden="true"></i>
             </div> 
 
             <div class="content">
                 <div class="text">Mis Solicitudes Realizadas</div><br>
                 <div class="number">
                     <a href="#"  >
                         <span class="count"><?php
    $num_solicitudes = $cantSolicitudesVendedor->fetch_array();
    echo $num_solicitudes[0] . "<br/>\n";
    ?></span>
                     </a>
                 </div>
             </div>      
 
         </div>
 
     </div> -->


    <!-- ./col -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-credit-card" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">Cupo Netflix Disponible</div><br>
                <div class="number">
                    <a href="#"  >
                        <span class="count"><?php
                            $saldo = $saldoVendedor->fetch_array();
                            echo "$" . $saldo [0] . "<br/>\n";
                            ?></span>
                    </a>
                </div>
            </div>

        </div>

    </div>
    <!-- ./col -->

    <!-- ./col -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-credit-card" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">N° Cuentas cupo Netflix</div><br>
                <div class="number">
                    <a href="#"  >
                        <span class="count"><?php
                            $saldo1 = $saldoVendedor1->fetch_array();
                            echo (int)($saldo1 [0]/$val) . "<br/>\n";
                            ?></span>
                    </a>
                </div>
            </div>

        </div>

    </div>
    <!-- ./col -->

    <!-- <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-file" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">Mis Solicitudes pendientes</div><br>
                <div class="number">
                    <a href="index.php?page=009"> 
                        <?php
                     //   echo $aux . "<br/>\n";
                        ?></a>
                </div>

            </div>			
        </div>
    </div>
-->







    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div> 

            <div class="content">
                <div class="text">Mis Clientes Creados</div><br>
                <div class="number">
                    <a href="#"  >

                        <a href="#"  >
                            <span class="count"><?php
                                $num_Clientes = $cantClientesVendedor->fetch_array();
                                echo $num_Clientes[0];
                                ?></span>
                        </a>
                    </a>
                </div>
            </div>      

        </div>

    </div>


    <!-- ./col -->
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-red">
                <i class="fa fa-money" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">Mis Vendedores Creados</div><br>
                <div class="number">
                    <a href="#"  >
                        <span class="count"><?php
                            $cant_vendedores = $cantVendedoresVendedor->fetch_array();
                            echo $cant_vendedores [0] . "<br/>\n";
                            ?></span>
                    </a>
                </div>
            </div>

        </div>

    </div>
    <!-- ./col -->



</div>
