<?php

class conexion {

    public $conexion;
    private $server = "localhost";
    private $usuario = "root";
    private $pass = "";
    private $db = "cel_comunicaciones_db";
    public $pdo_conn;

    public function __construct() {
        $this->conexion = new mysqli($this->server, $this->usuario, $this->pass, $this->db);
        //PRUEBA PULL
        if ($this->conexion->connect_errno) {

            die("Fallo al tratar de conectar con MySQL: (" . $this->conexion->connect_errno . ")");
        }
        $this->conexion->query("SET NAMES 'utf8'");
        $this->pdo_conn = new PDO("mysql:host=$this->server;dbname=$this->db", $this->usuario, $this->pass);
    }

    public function cerrar() {
        $this->conexion->close();
    }

    public function login($correo, $password) {

        //encriptamos el password para realizar la consulta
        $password = $this->encryption($password);

        $query = "SELECT  * FROM usuarios where correo='$correo' and clave='$password' and estado='A'";

        $consulta = $this->conexion->query($query);
        $num = mysqli_num_rows($consulta);

        if ($num == 1) {
            $row = mysqli_fetch_array($consulta);

            $id_usuario = $row ['id'];
            $id_rol = $row ['id_rol'];
            $cedula = $row ['cedula'];
            $nombre = $row ['nombre'];
            $apellido = $row['apellido'];
            $correo = $row ['correo'];
            $telefono = $row ['telefono'];
            $celular = $row['celular'];
            $codigo = $this->decryption($row["codigo"]);
            $id_empresa = $row["id_empresa"];
            //tomamos el nombre de la empresa;
            $datos_empresa = $this->getDatosEmpresa($id_empresa);

            $datos_empresa = $datos_empresa->fetch_assoc();

            $id_empresa = $datos_empresa["id"];
            $nombre_empresa = $datos_empresa["nombre"];
            $codigo_empresa = $this->decryption($datos_em["codigo"]);
            $saldo_empresa = $datos_empresa["saldo"];


            session_start();
            $_SESSION ['authenticated'] = 1;
            $_SESSION ['id_usuario'] = $id_usuario;
            $_SESSION ['id_rol'] = $id_rol;
            $_SESSION ['cedula'] = $cedula;
            $_SESSION ['nombre'] = $nombre;
            $_SESSION ['apellido'] = $apellido;
            $_SESSION ['correo'] = $correo;
            $_SESSION ['telefono'] = $telefono;
            $_SESSION ['celular'] = $celular;
            $_SESSION ['codigo'] = $codigo;
            $_SESSION ['id_empresa'] = $id_empresa;
            $_SESSION ['nombre_empresa'] = $nombre_empresa;
            $_SESSION ['codigo_empresa'] = $codigo_empresa;
            $_SESSION ['saldo_empresa'] = $saldo_empresa;

            echo "<script>location.href ='index.php'</script>";
            //header('Location: ../index.php');
        } else {

            echo "<script>alertify.error('Usuario o contraseña incorrecto/a.');
</script>";
        }
    }

    public function getNumVendedores() {
        $query = "SELECT COUNT(id_usuario) as num_usuario FROM usuario where estado='1' and id_rol='2'";
        $res = $this->conexion->query($query);
        return $res;
    }

    /* public function getClientes($id_empresa, $tipo_usuario) {
      if ($tipo_usuario != "super_usuario") {
      $query = "SELECT usu.cedula as 'cedula_usuario',usu.nombre as "
      . "'nombre_usuario',usu_cli.tipo_usuario,usu.apellido as "
      . "'apellido_usuario',cli.cedula as 'cedula_cliente',"
      . "cli.nombre as 'nombre_cliente',cli.apellido as 'apellido_cliente',"
      . "cli.direccion as 'direccion_cliente',cli.telefono as 'telefono_cliente',"
      . "cli.celular as 'celular_cliente',cli.correo as 'correo_cliente',cli.fecha_registro,cli.valor_cuenta as 'valor_cuenta_cliente' "
      . "FROM cliente cli "
      . "INNER JOIN usuario_cliente usu_cli ON cli.id_cliente=usu_cli.id_cliente "
      . "INNER JOIN usuario usu ON usu_cli.id_usuario=usu.id_usuario "
      . "WHERE usu_cli.id_empresa='" . $id_empresa . "' AND cli.estado=1";
      } else {
      $query = "SELECT su.nombre as 'nombre_usuario',su.correo as "
      . "'correo_usuario',cli.cedula as 'cedula_cliente',"
      . "cli.nombre as 'nombre_cliente',cli.apellido as "
      . "'apellido_cliente' ,cli.direccion as 'direccion_cliente',"
      . "cli.telefono as 'telefono_cliente',cli.celular as "
      . "'celular_cliente',cli.correo as 'correo_cliente',"
      . "cli.valor_cuenta as 'valor_cuenta_cliente' "
      . "FROM cliente cli INNER JOIN usuario_cliente "
      . "usu_cli ON cli.id_cliente=usu_cli.id_cliente "
      . "INNER JOIN super_usuarios su ON usu_cli.id_usuario=su.id "
      . "WHERE usu_cli.id_empresa='" . $id_empresa . "' AND cli.estado=1";
      }
      $res = $this->conexion->query($query);
      return $res;
      } */

    public function getClientes($id_usuario) {
        $query = "SELECT cli.cedula,CONCAT_WS(' ',cli.nombre,cli.apellido) as nombre, 
        cli.usuario,cli.correo,cli.direccion,cli.telefono,cli.celular, cli.fecha_registro,
        perfil_tarifa.nombre as nombre_tarifa  FROM clientes cli 
        INNER JOIN usuario_clientes usu_cli ON usu_cli.id_cliente=cli.id 
        INNER JOIN perfil_tarifa_empresa perfil_tarifa ON perfil_tarifa.id=cli.id_tarifa
        AND usu_cli.id_usuario='$id_usuario' AND cli.estado='A' ORDER BY cli.fecha_registro DESC";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function creaServicio($nombre_servicio) {
        $query = "INSERT INTO servicios (nombre,estado) VALUES ('$nombre_servicio','A')";
        $this->conexion->query($query);
    }

    public function creaPerfilTarifaTemp($nombre_perfil, $id_usuario, $id_empresa, $id_servicio, $tarifa) {

        //validamos que no exista el servicio
        $servicio = "SELECT id FROM perfil_tarifa_temporal WHERE id_servicio='$id_servicio' AND "
                . "id_usuario='$id_usuario'";
        $servicio = $this->conexion->query($servicio);
        if (mysqli_num_rows($servicio) != 0) {
            return false;
        } else {

            $query = "INSERT INTO perfil_tarifa_temporal (nombre_perfil,id_usuario,id_empresa,id_servicio,tarifa) "
                    . "VALUES ('$nombre_perfil','$id_usuario','$id_empresa','$id_servicio','$tarifa')";
            $this->conexion->query($query);
            return true;
        }
    }

    public function ejecutar_consulta_simple($consulta) {
        $res = $this->conexion->query($consulta);
        return $res;
    }

    public function creaPerfilTarifa($nombre_perfil, $id_usuario, $id_empresa, $codigo) {
        $query = "INSERT INTO perfil_tarifa_empresa (nombre,id_usuario_crea,id_empresa,codigo,estado) "
                . "VALUES ('$nombre_perfil','$id_usuario','$id_empresa','$codigo','A')";
        $this->conexion->query($query);
    }

    public function creaRegistroTarifaServicio($id_servicio, $valor, $id_tarifa) {
        $query = "INSERT INTO tarifa_servicio (id_servicio,valor,id_tarifa) "
                . "VALUES ('$id_servicio','$valor','$id_tarifa')";
        $this->conexion->query($query);
    }

    public function insertCuentaGmail($fecha_creacion, $nombre, $apellido, $correo, $clave, $linea, $num_ecard) {
        $query = "INSERT INTO cuenta_gmail (fecha_creacion,nombre,apellido,correo,clave,linea,num_ecard)"
                . "values ('$fecha_creacion','$nombre','$apellido','$correo','$clave','$linea','$num_ecard')";
        $this->conexion->query($query);
    }

    public function insertCuentaNetflix($id_cuenta_gmail, $fecha_creacion, $csv, $user_netflix, $pass_netflix, $crea_cuenta) {
        $query = "INSERT INTO cuenta_netflix (id_cuenta_gmail,fecha_creacion,csv,user_netflix,
        pass_netflix,id_usuario,id_cliente,crea_cuenta,estado)
        values ($id_cuenta_gmail,'$fecha_creacion','$csv','$user_netflix','$pass_netflix',0,0,$crea_cuenta,1)";
        $this->conexion->query($query);
    }

    public function insertTarifa($codigo, $valor, $tipo_tarifa, $tipo_usuario, $id_usuario, $id_empresa) {

        if ($tipo_tarifa == "personalizada") {
            $query = "INSERT INTO tarifa_usuario (id_usuario,tipo_usuario,codigo,valor,estado) "
                    . "VALUES ('$id_usuario','$tipo_usuario','$codigo','$valor','1')";
        } else {
            $query = "INSERT INTO tarifa_estandar (id_usuario,tipo_usuario,codigo,valor,id_empresa,estado) "
                    . "VALUES ('$id_usuario','$tipo_usuario','$codigo','$valor','$id_empresa','1')";
        }

        $this->conexion->query($query);
    }

    public function insertCuentaNetflixAct($fecha_creacion, $user_net, $pass_net, $crea_cuenta, $periodo_uso, $fecha_vencimiento) {
        $query = "INSERT INTO cuenta_netflix_act (fecha_creacion,dias_servicio_disponibles,"
                . "dias_servicio_consumidos,fecha_vencimiento,usuario,clave,"
                . "id_usuario_crea,estado) values ('$fecha_creacion','$periodo_uso','0','$fecha_vencimiento','$user_net',"
                . "'$pass_net','$crea_cuenta','1')";
        $this->conexion->query($query);
    }

    // CANTIDAD DE CUENTAS CARGADAS POR OPERADOR METODO ANTERIOR--------->
    /* public function getNumCuentas($id_usuario) {
      $query = "select count(a.id_cuenta_netflix) as 'num_cuentas' from cuenta_netflix a,
      cuenta_gmail b where a.id_cuenta_gmail=b.id_cuenta_gmail and a.crea_cuenta='$id_usuario'
      and month(a.fecha_creacion)=MONTH (NOW())";
      $res = $this->conexion->query($query);
      return $res;
      } */

    public function getNumCuentasAct($id_usuario) {
        $query = "select count(id_cuenta_netflix_act) from cuenta_netflix_act where 
        id_usuario_crea='$id_usuario'and month(fecha_creacion)=MONTH (NOW())";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getPerfilTarifaEmpresa($id_usuario, $id_empresa) {
        $query = "SELECT id,nombre,codigo FROM perfil_tarifa_empresa WHERE id_usuario_crea='$id_usuario' "
                . "AND id_empresa='$id_empresa' AND estado='A'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getServicios($id_usuario) {
        $query = "SELECT * FROM servicios WHERE id_usuario='$id_usuario' AND estado='A'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getNumCuentasCargadas() {
        $query = "select count(id_cuenta_netflix) from  cuenta_netflix";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getPerfilTarifaTemporal($id_usuario, $accion) {
        if ($accion == "lista") {
            $query = "SELECT tari_temp.id,tari_temp.nombre_perfil,ser.nombre,tari_temp.tarifa "
                    . "FROM perfil_tarifa_temporal tari_temp INNER JOIN servicios ser ON "
                    . "ser.id=tari_temp.id_servicio WHERE tari_temp.id_usuario='$id_usuario' ORDER BY "
                    . "tari_temp.id ASC";
        } else {
            $query = "SELECT * FROM perfil_tarifa_temporal WHERE id_usuario='$id_usuario'";
        }
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getNumSolicitudesSu($id_empresa) {
        $query = "SELECT COUNT(cli.id_cliente) as 'num' FROM cliente cli 
        INNER JOIN usuarios_cliente usu_cli ON usu_cli.id_cliente=cli.id_cliente 
        WHERE cli.estado='P' AND usu_cli.id_empresa='" . $id_empresa . "'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getNumPerfilTarifaCreado($id_usuario, $codigo) {
        $query = "SELECT id,nombre FROM perfil_tarifa_empresa WHERE id_usuario_crea=$id_usuario AND "
                . "codigo='$codigo' AND estado='A'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getNumColaboradoresSu($id_empresa) {
        $query = "SELECT COUNT(id_usuario) FROM usuario WHERE id_empresa='" . $id_empresa . "'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getNumClientesSu($id_empresa) {
        $query = "SELECT COUNT(cli.id_cliente) as 'num' FROM cliente cli
        INNER JOIN usuarios_cliente usu_cli ON cli.id_cliente=usu_cli.id_cliente
        WHERE CLI.estado=1 AND usu_cli.id_empresa='" . $id_empresa . "'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getDatosEmpresa($id_empresa) {
        $query = "SELECT * FROM empresas WHERE id='$id_empresa' AND estado='A'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getTarifasPersonalizadas($tipo_usuario, $id_usuario) {

        $query = "SELECT * from tarifa_usuario WHERE tipo_usuario='$tipo_usuario' "
                . "AND id_usuario='$id_usuario' AND estado='1'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getTarifasEstandar($id_empresa) {
        $query = "SELECT id_tarifa_estandar,codigo,valor FROM tarifa_estandar WHERE "
                . "id_empresa='$id_empresa' AND estado='1'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getSolicitudCliente($id_empresa) {
        $query = "SELECT usu.cedula as 'cedula_usuario',CONCAT_ws(' ',usu.nombre,usu.apellido) "
                . "as 'nombre_usuario',cli.cedula as 'cedula_cliente',"
                . "CONCAT_ws(' ',cli.nombre,cli.apellido) as 'nombre_cliente',"
                . "cli.direccion as 'direccion_cliente',cli.telefono as 'telefono_cliente',"
                . "cli.celular as 'celular_cliente',cli.correo as 'correo_cliente',"
                . "cli.valor_cuenta as 'valor_cuenta_cliente',cli.fecha_registro "
                . "FROM cliente cli INNER JOIN usuarios_cliente usu_cli ON "
                . "cli.id_cliente=usu_cli.id_cliente INNER JOIN usuario usu "
                . "ON usu.id_usuario=usu_cli.id_usuario WHERE cli.estado='P' AND "
                . "usu_cli.id_empresa='" . $id_empresa . "' ORDER BY cli.fecha_registro DESC";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getVendedoresNoPrivilegiados($user_id, $rol) {
        if ($rol != '1') {
            $query = "select a.* from (SELECT id_vendedor,nombre,apellido "
                    . "from usuario a INNER JOIN usuario_vendedor b on "
                    . "b.id_vendedor=a.id_usuario where b.id_usuario='$user_id' "
                    . "and a.estado='1')a where a.id_vendedor not in "
                    . "(SELECT id_usuario FROM usuario_privilegiado where estado='1')";
        } else {
            // tomamos todos los vendedores no privilegiados
            $query = "select a.* from (SELECT id_vendedor,nombre,apellido "
                    . "from usuario a INNER JOIN usuario_vendedor b on "
                    . "b.id_vendedor=a.id_usuario where a.estado='1')a "
                    . "where a.id_vendedor not in (SELECT id_usuario "
                    . "FROM usuario_privilegiado where estado='1' "
                    . "order by a.nombre asc)";
        }
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getVendedoresPrivilegiados($user_id, $rol) {
        if ($rol != '1') {
            $query = "select a.* from (SELECT id_vendedor,nombre,apellido from"
                    . " usuario a INNER JOIN usuario_vendedor b on "
                    . "b.id_vendedor=a.id_usuario where b.id_usuario='$user_id' "
                    . "and a.estado='1')a where a.id_vendedor in "
                    . "(SELECT id_usuario FROM usuario_privilegiado where estado='1' "
                    . "order by a.nombre asc)";
        } else {
            //tomamos todos los vendedores privilegiados
            $query = "select a.* from (SELECT id_vendedor,nombre,apellido from"
                    . " usuario a INNER JOIN usuario_vendedor b on "
                    . "b.id_vendedor=a.id_usuario where "
                    . "a.estado='1')a where a.id_vendedor in "
                    . "(SELECT id_usuario FROM usuario_privilegiado where estado='1' "
                    . "order by a.nombre desc)";
        }
        $res = $this->conexion->query($query);
        return $res;
    }

    public function updateCuentaGmail($fecha_creacion_gmail, $nombre_gmail, $apellido_gmail, $correo_gmail, $clave_gmail, $linea_gmail, $ecard_gmail, $id_cuenta_gmail) {
        $query = "UPDATE cuenta_gmail set fecha_creacion='$fecha_creacion_gmail',nombre='$nombre_gmail',"
                . "apellido='$apellido_gmail',correo='$correo_gmail',clave='$clave_gmail',linea='$linea_gmail',"
                . "num_ecard='$ecard_gmail' where id_cuenta_gmail=$id_cuenta_gmail";
        $this->conexion->query($query);
    }

    public function updateServicio($id_servicio, $nuevo_nombre) {
        $query = "UPDATE servicios SET nombre='$nuevo_nombre' WHERE id='$id_servicio'";
        $this->conexion->query($query);
    }

    public function generarCodigoTarifa() {
        $alpha = "123qwertyuiopa456sdfghjklzxcvbnm789";
        $code = "";
        $longitud = 5;
        for ($i = 0; $i < $longitud; $i++) {
            $code .= $alpha[rand(0, strlen($alpha) - 1)];
        }
        $code = strtoupper($code);
        return $code;
    }

    /* public function updateCuentaNetflix($fecha_creacion_net, $csv_net, $user_net, $pass_net, $id_cuenta_net) {
      $query = "UPDATE cuenta_netflix set fecha_creacion='$fecha_creacion_net',csv='$csv_net',user_netflix='$user_net',"
      . "pass_netflix='$pass_net' where id_cuenta_netflix='$id_cuenta_net'";

      $this->conexion->query($query);
      } */

    public function updateCuentaNetflixAct($cuenta_modificar, $nuevo_usuario_netflix, $nueva_clave_netflix) {
        $query = "UPDATE cuenta_netflix_act set usuario='$nuevo_usuario_netflix', clave='$nueva_clave_netflix' WHERE "
                . "id_cuenta_netflix_act='$cuenta_modificar'";
        $this->conexion->query($query);
    }

    public function getCantSolicitudVendedor($id_usuario) {
        $query = "select count(id_solicitud) as 'num_solicitudes' from solicitud where"
                . " id_cliente_usuario='$id_usuario'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getCantClientesVendedor($id_usuario) {
        $query = "select count(id_usuario_cliente) from usuarios_cliente where id_usuario='$id_usuario' "
                . "and estado=1;";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getUsuarios($tipo_usuario, $id_empresa, $id_rol) {
        if ($tipo_usuario == "usuario") {
            $query = "SELECT * FROM clientes WHERE id_empresa='$id_empresa' AND id_rol='$id_rol' AND estado='A'";
        } elseif ($tipo_usuario == "cliente") {

            $query = "SELECT * FROM clientes cli INNER JOIN usuario_clientes usu_cli ON usu_cli.id_cliente=cli.id "
                    . "INNER JOIN usuarios usu ON usu_cli.id_usuario=usu.id WHERE usu.id_empresa='$id_empresa' AND "
                    . "cli.estado='A'";
        }
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getCantVendedoresVendedor($id_usuario) {
        $query = "select count(id_usuario_vendedor) from usuario_vendedor 
        where id_usuario='$id_usuario' and estado='1'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getSaldoActualVendedor($id_usuario) {
        $query = "select saldo_actual from usuario where id_usuario='$id_usuario' and estado='A'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getRegistroAbono($id_usuario) {
        $query = "select a.id_registro_abono,b.nombre as 'nombre_abona',b.apellido as 'apellido_abona',"
                . "c.nombre as 'nombre_registra_abono',c.apellido as 'apellido_registra_abono', "
                . "a.monto_debe,a.monto_abono,a.monto_resta,a.fecha_abono from registro_abono a,"
                . " usuario b, usuario c where a.id_usuario_abona=b.id_usuario and "
                . "a.id_usuario_registra_abono=c.id_usuario and a.id_usuario_abona='$id_usuario' "
                . "and MONTH(a.fecha_abono)=MONTH(CURRENT_DATE())";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getRegistroAbonoCliente($id_cliente) {
        $query = "select a.id_registro_abono_cliente,b.nombre as 'nombre_abona',b.apellido as 'apellido_abona',
                c.nombre as 'nombre_registra_abono',c.apellido as 'apellido_registra_abono', 
                a.monto_debe,a.monto_abono,a.monto_resta,a.fecha_abono from registro_abono_cliente a,
                usuario b, usuario c where a.id_cliente_abona=b.id_usuario and 
                a.id_usuario_registra_abono=c.id_usuario and a.id_cliente_abona='$id_cliente' 
                and MONTH(a.fecha_abono)=MONTH(CURRENT_DATE())";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getRegistroErrorCuentaNetflix() {
        $query = "SELECT recn.radicado,recn.fecha_reporte FROM reporte_error_cuenta_netflix "
                . "recn WHERE recn.estado='P'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function esPrivilegiado($id_usuario) {
        $query = "SELECT count(id_usuario_privilegiado) from usuario_privilegiado "
                . "where id_usuario='$id_usuario' and estado='1'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function datosPrivilegioVendedor($id_usuario) {
        $query = "SELECT * FROM usuario_privilegiado WHERE "
                . "id_usuario='$id_usuario'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getUltimoDetalleUsuarioPri($id_usuario) {
        $query = "SELECT fecha_lapso_venta,fecha_limite_pago FROM detalle_cuenta_usuario_pri_act WHERE 
            id_usuario_compra='$id_usuario' order by fecha_lapso_venta desc limit 1";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getSaldoVendedor($id_usuario) {
        $query = "select saldo from usuario where id_usuario='$id_usuario'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getContDetalleCuentaVendedor($user_id, $privilegiado) {
        if ($privilegiado != 0) {
            $query = "SELECT count(id_detalle_cuenta_usuario_pri_act)  "
                    . "FROM detalle_cuenta_usuario_pri_act WHERE "
                    . "id_usuario_compra='$user_id' and estado='P' ";
            $res = $this->conexion->query($query);
        } else {
            $query = "SELECT count(id_detalle_cuenta_usuario_act) FROM detalle_cuenta_usuario_act WHERE "
                    . "id_usuario_compra='$user_id'";
            $res = $this->conexion->query($query);
        }
        return $res;
    }

    public function getDetalleCuentaVendedorFecha($user_id, $privilegiado, $fecha_limite) {
        if ($privilegiado != 0) {
            $query = "SELECT * FROM detalle_cuenta_usuario_pri_act WHERE "
                    . "id_usuario_compra='$user_id' and estado='P' and fecha_limite_pago='$fecha_limite' "
                    . "order by fecha_compra desc";
            $res = $this->conexion->query($query);
        } else {
            $query = "SELECT * FROM detalle_cuenta_usuario_act WHERE "
                    . "id_usuario_compra='$user_id' order by fecha_compra desc";
            $res = $this->conexion->query($query);
        }
        return $res;
    }

    public function getDetalleCuentaVendedor($user_id, $privilegiado) {
        if ($privilegiado != 0) {
            $query = "SELECT * FROM detalle_cuenta_usuario_pri_act WHERE "
                    . "id_usuario_compra='$user_id' and estado='P' "
                    . "order by fecha_compra desc";
            $res = $this->conexion->query($query);
        } else {
            $query = "SELECT * FROM detalle_cuenta_usuario_act WHERE "
                    . "id_usuario_compra='$user_id' order by fecha_compra desc";
            $res = $this->conexion->query($query);
        }
        return $res;
    }

    public function getDetalleCuentaCliente($id_cliente) {
        $query = "SELECT a.* FROM detalle_cuenta_cliente a, cuenta_cliente b "
                . "WHERE a.id_detalle_cuenta_cliente=b.id_detalle_cuenta_cliente and "
                . "b.id_cliente='$id_cliente' and a.estado='P'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getCreditoServicioTemp($id_usuario, $id_nuevo_usuario) {
        $query = "SELECT ser_temp.id,ser.nombre,ser_temp.monto_permitido_venta FROM "
                . "usuario_tarifa_servicio_temp ser_temp INNER JOIN servicios ser "
                . "ON ser.id=ser_temp.id_servicio WHERE ser_temp.id_usuario_resp='$id_usuario' "
                . "AND ser_temp.id_usuario_aprobar='$id_nuevo_usuario'";
        $res = $this->conexion->query($query);
        return $res;
    }

    //funcion para encriptar
    public function encryption($string) {
        $output = FALSE;
        $key = hash('sha256', '$CELLCOM@2019');
        $iv = substr(hash('sha256', "101712"), 0, 16);
        $output = openssl_encrypt($string, "AES-256-CBC", $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    //funcion para desencriptar
    public function decryption($string) {
        $key = hash('sha256', '$CELLCOM@2019');
        $iv = substr(hash('sha256', "101712"), 0, 16);
        $output = openssl_decrypt(base64_decode($string), "AES-256-CBC", $key, 0, $iv);
        return $output;
    }

    public function creaUsuarioVendedor($cedula_vendedor, $nombre_vendedor, $apellido_vendedor, $correo_vendedor, $clave_vendedor, $telefono_vendedor, $celular_vendedor, $valor_cuenta_vendedor, $saldo_actual) {
        $query = "INSERT INTO usuario (id_rol,cedula,nombre,apellido,correo,clave,telefono,celular,"
                . "valor_cuenta,saldo_actual,estado) values ('4','$cedula_vendedor','$nombre_vendedor','$apellido_vendedor','$correo_vendedor','$clave_vendedor','$telefono_vendedor',"
                . "'$celular_vendedor','$valor_cuenta_vendedor','$saldo_actual','1')";
        $this->conexion->query($query);
    }

    public function creaUsuarioVendedorPrivilegiado($id_vendedor, $saldo_max_permitido, $dias_plazo, $lapso_venta) {
        $query = "INSERT INTO usuario_privilegiado (id_usuario,saldo_maximo_permitido,dias_lapso_ventas,dias_plazo,estado) "
                . "values ('$id_vendedor','$saldo_max_permitido','$lapso_venta','$dias_plazo','1')";
        $this->conexion->query($query);
    }

    public function creaUsuarioCliente($cedula_cliente, $nombre_cliente, $apellido_cliente, $correo_cliente, $direccion_cliente, $telefono_cliente, $celular_cliente, $valor_cuenta_cliente) {
        $query = "INSERT INTO cliente (cedula,nombre,apellido,correo,direccion,telefono,celular,valor_cuenta) "
                . "values ('$cedula_cliente','$nombre_cliente','$apellido_cliente','$correo_cliente','$direccion_cliente',"
                . "'$telefono_cliente','$celular_cliente','$valor_cuenta_cliente')";
        $this->conexion->query($query);
    }

    /* public function creaSolicitud($id_cliente_usuario, $id_usuario_resp, $fecha_requerimiento, $num_cuentas_solicitadas, $tipo_solicitud, $descripcion) {
      $query = "INSERT INTO solicitud (id_cliente_usuario,id_usuario_resp,fecha_requerimiento,"
      . "num_cuentas_solicitadas,tipo_solicitud,descripcion) values ('$id_cliente_usuario',"
      . "'$id_usuario_resp','$fecha_requerimiento','$num_cuentas_solicitadas','$tipo_solicitud','$descripcion')";
      $this->conexion->query($query);
      } */

    public function creaSolicitudSaldo($id_usuario_vendedor, $saldo_solicitado, $fecha_solicitud) {
        $query = "INSERT INTO registro_solicitud_saldo (id_usuario_vendedor,"
                . "saldo_solicitado,fecha_solicitud) values ('$id_usuario_vendedor','$saldo_solicitado',"
                . "'$fecha_solicitud')";
        $this->conexion->query($query);
    }

    /*  public function creaSolicitudCompra($id_usuario_compra, $num_cuentas, $fecha_solicitud) {
      $query = "INSERT INTO solicitud_cuenta_operacion (id_usuario_compra,"
      . "num_cuentas,fecha_solicitud,estado) values ('$id_usuario_compra',"
      . "'$num_cuentas','$fecha_solicitud','1')";
      $this->conexion->query($query);
      } */

    public function asignaVendedorUsuario($id_usuario, $id_cliente) {
        $query = "INSERT INTO usuario_vendedor (id_usuario,id_vendedor,estado) "
                . "values ('$id_usuario','$id_cliente','1')";
        $this->conexion->query($query);
    }

    public function asignaClienteUsuario($id_usuario, $id_cliente) {
        $query = "INSERT INTO usuario_cliente (id_usuario,id_cliente,estado) "
                . "values ('$id_usuario','$id_cliente','1')";
        $this->conexion->query($query);
    }

    /* public function asignaCuentaUsuario($id_cuenta, $id_usuario, $fecha_asignacion, $tipo_asignacion) {
      $query = "INSERT INTO cuenta_usuario (id_cuenta_netflix_act,id_usuario,fecha_asignacion,tipo_asignacion) "
      . "values ('$id_cuenta','$id_usuario','$fecha_asignacion','$tipo_asignacion')";
      $this->conexion->query($query);
      } */

    public function asignaCuentaClienteFinal($id_cuenta, $id_cliente, $id_detalle) {
        $query = "INSERT INTO cuenta_cliente (id_cuenta_netflix_act,id_cliente,id_detalle_cuenta_cliente) "
                . "values ('$id_cuenta','$id_cliente','$id_detalle')";
        $this->conexion->query($query);
    }

    public function asignaCreditoServicioTemp($id_usuario, $id_nuevo_usuario, $id_sevicio, $monto_permitido_venta) {
        $query = "INSERT INTO usuario_tarifa_servicio_temp (id_usuario_resp,id_usuario_aprobar,"
                . "id_servicio,monto_permitido_venta) VALUES ('$id_usuario','$id_nuevo_usuario',"
                . "'$id_sevicio','$monto_permitido_venta')";
        $this->conexion->query($query);
    }

    /* public function asignaCuentaCliente($id_cuenta, $id_cliente, $fecha_asignacion) {
      $query = "INSERT INTO cuenta_cliente (id_cuenta_netflix_act,id_cliente,fecha_asignacion) "
      . "values ('$id_cuenta','$id_usuario','$fecha_asignacion','$tipo_asignacion')";
      $this->conexion->query($query);
      } */

    public function restaCuentas($id_usuario, $num_cuentas_rest) {
        $query = "UPDATE usuario SET num_cuentas='$num_cuentas_rest' where "
                . "id_usuario='$id_usuario'";
        $this->conexion->query($query);
    }

    public function asignaCuentaNetActUsuario($id_cuenta_netflix_act, $id_usuario, $fecha_asignacion, $tipo_usuario, $id_detalle_cuenta_usuario, $estado) {
        $query = "INSERT INTO cuenta_usuario (id_cuenta_netflix_act,id_usuario,fecha_asignacion,"
                . "tipo_usuario,id_detalle_cuenta_usuario,estado) values ('$id_cuenta_netflix_act',"
                . "'$id_usuario','$fecha_asignacion','$tipo_usuario','$id_detalle_cuenta_usuario',"
                . "'$estado')";
        $this->conexion->query($query);
    }

    public function cambiaEstadoCuentaTomada($id_cuenta) {
        $query = "UPDATE cuenta_netflix_act set estado='2' where id_cuenta_netflix_act='$id_cuenta'";
        $this->conexion->query($query);
    }

    public function cambiaEstadoCuentaAsignadaCliente($id_cuenta) {
        $query = "UPDATE cuenta_usuario set estado='2' where "
                . "id_cuenta_netflix_act='$id_cuenta'";
        $this->conexion->query($query);
    }

    public function cambiaEstadoDetalleVendedor($id_detalle) {
        $query = "UPDATE detalle_cuenta_usuario_pri_act SET estado='C' "
                . "WHERE id_detalle_cuenta_usuario_pri_act='$id_detalle'";
        $this->conexion->query($query);
    }

    public function cambiaEstadoDetalleCliente($id_detalle) {
        $query = "UPDATE detalle_cuenta_cliente SET estado='C' "
                . "WHERE id_detalle_cuenta_cliente='$id_detalle'";
        $this->conexion->query($query);
    }

    /* public function getMaxCuentasPermitidas($id_usuario) {
      $query = "SELECT num_max_cuentas FROM usuario WHERE id_usuario='$id_usuario'";
      $res = $this->conexion->query($query);
      return $res;
      } */

    public function getSaldoActual($id_usuario) {
        $query = "SELECT saldo_actual FROM usuario WHERE id_usuario='$id_usuario'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getSaldoMaximoPermitido($id_usuario) {
        $query = "SELECT saldo_maximo_permitido from usuario_privilegiado "
                . "where id_usuario='$id_usuario'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getSolicitudIngresoDistribuidor($id_empresa) {
        $query = "SELECT a.*,cred_usu.id AS 'id_credito',cred_usu.valor_credito FROM  
        (SELECT  usu.id as 'id_usuario_responsable', usu.cedula AS 'cedula_usu_responsable',CONCAT_WS(' ',usu.nombre,USU.apellido) AS 
        'usuario_responsable' ,usu_distri.id AS 'id_distribuidor',usu_distri.cedula AS 
        'cedula_distribuidor', CONCAT_WS(' ',usu_distri.nombre,usu_distri.apellido) AS 
        'nombre_distribuidor',usu_distri.correo,usu_distri.telefono,
        usu_distri.celular,usu_distri.fecha_registro FROM usuarios usu,usuarios 
        usu_distri,usuario_distribuidores  usuario_distribuidor
	WHERE usuario_distribuidor.id_usuario=usu.id AND 
        usuario_distribuidor.id_distribuidor=usu_distri.id 
        AND usu_distri.estado='P' AND usu_distri.id_empresa='$id_empresa')a 
        LEFT JOIN credito_usuario cred_usu ON cred_usu.id_usuario=a.id_distribuidor";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function restaSaldoActualUsuario($saldo, $id_usuario) {
        $query = "UPDATE usuario set saldo_actual='$saldo' where "
                . "id_usuario='$id_usuario'";
        $this->conexion->query($query);
    }

    public function restaSaldoActualUsuarioPri($user_id_crea, $saldo_solicitado) {
        $query = "UPDATE usuario SET saldo_actual=(saldo_actual - '$saldo_solicitado')"
                . " where id_usuario='$user_id_crea' and estado=1";
        $this->conexion->query($query);
    }

    public function getValorCuenta($id_usuario) {
        $query = "select valor_cuenta from usuario where id_usuario='$id_usuario'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getCuentasNetflixAct() {
        $query = "SELECT id_cuenta_netflix_act from cuenta_netflix_act where 
           fecha_creacion between CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
           AND estado='1'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getCountExisteCuenta($usuario_netflix) {
        $query = "SELECT count(id_cuenta_netflix_act) as existe "
                . "from cuenta_netflix_act WHERE "
                . "usuario='$usuario_netflix'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getCuentasNetflixAll() {
        $query = "SELECT * FROM cuenta_netflix_act WHERE estado = 2";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getIdDetalleCuentaUsuarioPri() {
        $query = "SELECT id_detalle_cuenta_usuario_pri_act FROM 
        detalle_cuenta_usuario_pri_act order by id_detalle_cuenta_usuario_pri_act 
        desc limit 1";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getIdDetalleCuentaUsuario() {
        $query = "SELECT id_detalle_cuenta_usuario_act FROM 
        detalle_cuenta_usuario_act order by id_detalle_cuenta_usuario_act 
        desc limit 1";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function getSumDetalle($id_usuario) {
        $query = "SELECT SUM(total_pagar) FROM detalle_cuenta_usuario_pri_act "
                . "where id_usuario_compra='$id_usuario' and estado='P'";
        $res = $this->conexion->query($query);
        return $res;
    }

    public function actualizaSaldoUsuarioPri($user_id, $nuevo_saldo) {
        $query = "UPDATE usuario set saldo_actual='$nuevo_saldo' where "
                . "id_usuario='$user_id'";
        $this->conexion->query($query);
    }

    public function actualizaDetalleVendedor($id_detalle, $restante) {
        $query = "UPDATE detalle_cuenta_usuario_pri_act SET total_pagar='$restante' "
                . "WHERE id_detalle_cuenta_usuario_pri_act='$id_detalle'";
        $this->conexion->query($query);
    }

    public function actualizaDetalleCliente($id_detalle, $restante) {
        $query = "UPDATE detalle_cuenta_cliente SET total='$restante' "
                . "WHERE id_detalle_cuenta_cliente='$id_detalle'";
        $this->conexion->query($query);
    }

    public function actualizaTarifaTemp($id_actualizar, $tarifa, $tipo_tarifa) {
        $query = "UPDATE perfil_tarifa_temporal SET tarifa='$tarifa' WHERE id='$id_actualizar'";
        $this->conexion->query($query);
    }

    /* public function apruebaSolicitud($id_solicitud) {

      $query = "INSERT INTO respuesta_solicitud (id_solicitud,estado,descripcion)"
      . "values ('$id_solicitud','1','Aprobado por usuario')";
      $this->conexion->query($query);
      }

      public function niegaSolicitud($id_solicitud, $descripcion) {
      $query = "INSERT INTO respuesta_solicitud (id_solicitud,estado,descripcion)"
      . "values ('$id_solicitud','0','$descripcion')";
      $this->conexion->query($query);
      }

      /* public function creaDetalleSolicitudVendedor($id_respuesta_solicitud, $fecha_compra, $cant_cuentas, $valor_uni, $total, $ganancia, $tipo) {

      $query = "INSERT INTO detalle_cuenta_usuario (id_respuesta_solicitud,monto_pagado,"
      . "fecha_compra,cant_cuentas_solicitadas,valor_unitario,total_pagar,ganancia,"
      . "tipo_pago,monto_restado,estado) values ('$id_respuesta_solicitud','0',"
      . "'$fecha_compra','$cant_cuentas','$valor_uni','$total','$ganancia','$tipo',"
      . "'$total','P')";
      $this->conexion->query($query);
      } */

    public function creaDetalleVendedorPrivilegiado($id_usuario_compra, $id_usuario_resp, $cant_cuentas, $valor_unitario, $total_pagar, $fecha_compra, $fecha_lapso_ventas, $fecha_limite_pago) {
        $query = "INSERT INTO detalle_cuenta_usuario_pri_act (id_usuario_compra,"
                . "id_usuario_responsable,cant_cuentas_compradas,valor_unitario,"
                . "total_pagar,fecha_compra,fecha_lapso_venta,fecha_limite_pago,estado) values ('$id_usuario_compra',"
                . "'$id_usuario_resp','$cant_cuentas','$valor_unitario','$total_pagar',"
                . "'$fecha_compra','$fecha_lapso_ventas','$fecha_limite_pago','P')";
        $this->conexion->query($query);
    }

    public function creaDetalleVendedor($id_usuario_compra, $id_usuario_resp, $cant_cuentas, $valor_unitario, $total_pagar, $fecha_compra) {
        $query = "INSERT INTO detalle_cuenta_usuario_act (id_usuario_compra,id_usuario_responsable,"
                . "cant_cuentas_compradas,valor_unitario,total_pagado,fecha_compra,"
                . "estado) VALUES ('$id_usuario_compra','$id_usuario_resp','$cant_cuentas',"
                . "'$valor_unitario','$total_pagar','$fecha_compra','C')";
        $this->conexion->query($query);
    }

    public function creaDetalleCuentaCliente($fecha_venta, $cantidad_cuentas, $valor_unitario, $total, $ganancia, $monto_pagado, $monto_restado, $estado) {
        $query = "INSERT INTO detalle_cuenta_cliente (fecha_venta,cantidad_cuentas,valor_unitario,"
                . "total,ganancia,monto_pagado,monto_restado,estado) values ('$fecha_venta','$cantidad_cuentas','$valor_unitario',"
                . "'$total','$ganancia','$monto_pagado','$monto_restado','$estado')";
        $this->conexion->query($query);
    }

    public function creaRegistroAbono($id_usuario_abona, $id_usuario_registra_abono, $monto_debe, $monto_abono, $monto_resta, $fecha_abono) {
        $query = "INSERT INTO registro_abono (id_usuario_abona,id_usuario_registra_abono,monto_debe,"
                . "monto_abono,monto_resta,fecha_abono) VALUES ('$id_usuario_abona','$id_usuario_registra_abono',"
                . "'$monto_debe','$monto_abono','$monto_resta','$fecha_abono')";
        $this->conexion->query($query);
    }

    public function creaRegistroAbonoCliente($id_cliente_abona, $id_usuario_registra_abono, $monto_debe, $monto_abono, $monto_resta, $fecha_abono) {
        $query = "INSERT INTO registro_abono_cliente (id_cliente_abona,id_usuario_registra_abono,"
                . "monto_debe,monto_abono,monto_resta,fecha_abono) VALUES ('$id_cliente_abona',"
                . "'$id_usuario_registra_abono','$monto_debe','$monto_abono','$monto_resta',"
                . "'$fecha_abono')";
        $this->conexion->query($query);
    }

    public function asignaCantCuentas($id_usuario, $cant_cuentas) {

        $query = "UPDATE usuario set num_cuentas='$cant_cuentas' where id_usuario='$id_usuario'";
        $consulta = $this->conexion->query($query);
    }

    public function eliminaTarifa($id_eliminar, $tipo_tarifa) {

        if ($tipo_tarifa == "temporal") {
            $query = "DELETE FROM perfil_tarifa_temporal WHERE id='$id_eliminar'";
        }
        /* if ($tipo_tarifa == "personalizada") {
          $query = "DELETE FROM tarifa_usuario WHERE id_tarifa_usuario='$id_tarifa'";
          } else {
          $query = "DELETE FROM tarifa_estandar WHERE id_tarifa_estandar='$id_tarifa'";
          } */

        $this->conexion->query($query);
    }

    //PRODUCTOS
    function getCategoriasProducto() {
        $query = "SELECT * FROM categorias_producto WHERE estado='A'";
        $res = $this->conexion->query($query);
        return $res;
    }

    function getSubCategorias($id_categoria) {
        $query = "SELECT * FROM sub_categorias_producto WHERE id_categoria='$id_categoria' AND estado='A'";
        $res = $this->conexion->query($query);
        return $res;
    }

    function getElementoSubCategoria($id_subcategoria) {
        $query = "SELECT * FROM complementos_subcategoria_producto WHERE id_subcategoria='$id_subcategoria' AND estado='A'";
        $res = $this->conexion->query($query);
        return $res;
    }

}
