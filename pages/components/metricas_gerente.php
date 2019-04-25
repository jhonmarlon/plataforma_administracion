
<?php

$conn=new conexion();
$id_empresa= $userinfo->id_empresa;
$num_distribuidores=$conn->ejecutar_consulta_simple("SELECT COUNT(id) FROM usuarios WHERE "
        . "id_empresa='$id_empresa' AND id_rol='3' AND estado='A'");
?>


<div class="row">        
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-blue">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <div class="content">
                <div class="text">N° Distribuidores</div><br>
                <div class="number">
                    <?php
                      $num_distribuidores = $num_distribuidores->fetch_array();
                      echo $num_distribuidores[0] . "<br/>\n";
                    ?></div>
            </div>
        </div>
    </div>	


    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-blue">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <div class="content">
                    <div class="text">N° Clientes</div><br>
                    <div class="number">
                        <?php
                       // $num_clientes=$num_clientes->fetch_array();
                       // echo $num_clientes[0]. "<br/>\n";
                        ?>
                    </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-blue">
                <i class="fa fa-file" aria-hidden="true"></i>
            </div>

            <div class="content">
                <div class="text">Solicitudes pendientes</div><br>
                <div class="number">
                        <?php
                       // $num_solicituesSu=$num_solicituesSu->fetch_array();
                       // echo $num_solicituesSu[0] . "<br/>\n";
                        ?></div>

            </div>			
        </div>
    </div>	

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-blue">
                <i class="fa fa-line-chart" aria-hidden="true"></i>
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
