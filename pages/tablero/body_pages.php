<?php

if ($rol == 1) { //Gerente
    include "pages/components/metricas_gerente.php";
} elseif ($rol == 2) { //Socio Administrador
    include "pages/components/metricas_gerente.php";
} elseif ($rol == 3) { //Coordinador
    include "pages/components/metricas_coordinador.php";
} else {
    include "pages/components/metricas_asesor.php";
}
?>