<?php

$conexion = new conexion();

//permisos para el super usuario o Dueño
/* if (isset($_SESSION["id_su"])) {

  $_PAGE_PERMISSIONS = array(
  "1" => array(
  ),
  );

  $_PAGE_CONFIG = array(
  "000" => array(
  "show" => true,
  "isSubmenu" => false,
  "big" => "Plataforma de control",
  "small" => "Inicio",
  "menu" => "Tablero de Control",
  "menu_css_class" => "fa-dashboard",
  "link" => 'pages/tablero/body.php'
  ),
  "001" => array(
  "show" => true,
  "isSubmenu" => false,
  "big" => "Administración SU",
  "small" => "Permisos",
  "menu" => "Delegar Permisos",
  "menu_css_class" => "fa fa-pencil-square-o",
  "link" => 'pages/components/delegar_permiso_super_usuario.php'
  ),
  "002" => array(
  "show" => true,
  "isSubmenu" => false,
  "big" => "Administración SU",
  "small" => "Aprobar/Negar Solicitud",
  "menu" => "Aprobar/Negar Solicitud",
  "menu_css_class" => "fa fa-check-square-o",
  "link" => 'pages/components/aprobar_solicitudes_super_usuario.php'
  ),
  "003" => array(
  "show" => true,
  "isSubmenu" => false,
  "big" => "Administración SU",
  "small" => "Mis Tarifas",
  "menu" => "Mis Tarifas",
  "menu_css_class" => "fa fa-money",
  "link" => 'pages/components/tarifas.php'
  ),

  "006" => array(
  "show" => true,
  "isSubmenu" => false,
  "big" => "Administración SU",
  "menu_css_class" => "fa-users",
  "small" => "Usuarios Registrados",
  "menu" => "Usuarios Registrados",
  "submenu" => array(
  "0" => "007",
  "1" => "008",
  )
  ),
  "007" => array(
  "show" => true,
  "isSubmenu" => true,
  "big" => "Clientes",
  "small" => "Clientes Registrados",
  "menu" => "Clientes Registrados",
  "link" => 'pages/gestion_usuarios/clientes/body.php',
  "menu_css_class" => "fa fa-user-plus"
  ),
  "008" => array(
  "show" => true,
  "isSubmenu" => true,
  "big" => "Distribuidores y/o Vendedores",
  "small" => "Vendedores Registrados",
  "menu" => "Vendedores Registrados",
  "link" => 'pages/gestion_usuarios/vendedores/body.php',
  "menu_css_class" => "fa fa-user-plus"
  ),
  "004" => array(
  "show" => true,
  "isSubmenu" => false,
  "big" => "Administración SU",
  "menu_css_class" => "fa-bar-chart",
  "small" => "Reportes",
  "menu" => "Reportes",
  "submenu" => array(
  "0" => "005",
  )
  ),
  "005" => array(
  "show" => true,
  "isSubmenu" => true,
  "big" => "Reportes SU",
  "small" => "Cuentas vendidad por mes",
  "menu" => "Cuentas por mes",
  "link" => 'pages/gestion_usuarios/crear_vendedor/body.php',
  "menu_css_class" => "fa fa-credit-card-alt"
  ),
  "500" => array(
  "show" => false,
  "link" => 'pages/error/500.php'
  ),
  "404" => array(
  "show" => false,
  "link" => 'pages/error/404.php'
  )
  );
  } else { */

$_PAGE_PERMISSIONS = array(
    "1" => array(
        "010" => false,
        "011" => false,
    ),
    "2" => array(
        "017" => false,
        "041" => false,
    ),
    "3" => array(
        "010" => false,
        "017" => false,
        "041" => false,
    ),
    "4" => array(
        "010" => false,
        "017" => false,
        "041" => false,
    ),
);


// Pagina Actual : 052

$_PAGE_CONFIG = array(
//000 siempre es la home
    "000" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "Plataforma de control",
        "small" => "Inicio",
        "menu" => "Tablero de Control",
        "menu_css_class" => "fa-dashboard",
        "link" => 'pages/tablero/body.php'
    ),
    "001" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "GTI",
        "menu_css_class" => "fa-users",
        "small" => "Gestión de usuarios",
        "menu" => "Crear Usuarios",
        "submenu" => array(
            "1" => "002",
            "2" => "003",
            "3" => "004",
            "4" => "005",
        )
    ),
    
    //GESTION DE USUARIOS
    "002" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de usuarios",
        "small" => "Nuevo Socio/Propietario",
        "menu" => "Nuevo Socio/Propietario",
        "link" => 'pages/gestion_usuarios/crear_socio_propietario/body.php',
        "menu_css_class" => "fa-male"
    ),
    "003" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de usuarios",
        "small" => "Nuevo Coordinador",
        "menu" => "Nuevo Coordinador",
        "link" => 'pages/gestion_usuarios/crear_coordinador/body.php',
        "menu_css_class" => "fa-male"
    ),
    "004" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de usuarios",
        "small" => "Nuevo Asesor",
        "menu" => "Nuevo Asesor",
        "link" => 'pages/gestion_usuarios/crear_vendedor/body.php',
        "menu_css_class" => "fa-male"
    ),
    "005" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de usuarios",
        "small" => "Nuevo Cliente",
        "menu" => "Nuevo Cliente",
        "link" => 'pages/gestion_usuarios/crear_cliente/body.php',
        "menu_css_class" => "fa-male"
    ),
    
    
    //GESTION DE SERVICIOS Y PRODUCTOS
        "021" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "GTI",
        "menu_css_class" => "fa-shopping-cart",
        "small" => "Gestión de productos y servicios",
        "menu" => "Servicios/Productos",
        "submenu" => array(
            "1" => "022",
         
        )
    ),
    
        "022" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de productos y servicios",
        "small" => "Nuevo Producto",
        "menu" => "Nuevo Producto",
        "link" => 'pages/gestion_producto_servicio/crear_producto/body.php',
        "menu_css_class" => "fa-shopping-basket"
    ),
    
    //MIS USUARIOS
      /*  "010" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "Administración de Usuarios",
        "menu_css_class" => "fa fa-users",
        "small" => "Mis Usuarios",
        "menu" => "Mis Usuarios",
        "submenu" => array(
            "2" => "011",
            "3" => "012",
        )
    ),
    
     "011" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Mis Usuarios",
      "small" => "Mis Usuarios",
      "menu" => "Mis Distribuidores",
      "menu_css_class" => "fa-user",
      "link" => 'pages/components/lista_distribuidores.php'
      ),
    
       "012" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Mis Usuarios",
      "small" => "Mis Usuarios",
      "menu" => "Mis Clientes",
      "menu_css_class" => "fa-user",
      "link" => 'pages/components/lista_clientes.php'
      ),*/
    
    //GESTION DE TARIFAS
    "006" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "GTI",
        "menu_css_class" => "fa-money",
        "small" => "Tarifas",
        "menu" => "Tarifas",
        "submenu" => array(
            "1" => "007",
            "2" => "008",
        )
    ),
    "007" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de Tarifas",
        "small" => "Crear Perfil de Tarifa",
        "menu" => "Crear Perfil de Tarifa",
        "link" => 'pages/components/crear_perfil_tarifa.php',
        "menu_css_class" => "fa fa-object-group"
    ),
    "008" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de Tarifas",
        "small" => "Asignar Perfil de Tarifa",
        "menu" => "Asignar Perfil de Tarifa",
        "link" => 'pages/components/asignar_perfil_tarifa.php',
        "menu_css_class" => "fa fa-sign-in"
    ),
    
           //GESTION DE SOLICITUDES
    
    
        //GESTION DE TARIFAS
    "010" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "Gestión de Solicitudes",
        "menu_css_class" => "fa-money",
        "small" => "Gestion de Solicitudes",
        "menu" => "Gestionar Solicitudes",
        "submenu" => array(
            "1" => "011",
            "2" => "012",
        )
    ),
    
        "011" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de Solicitudes",
        "small" => "Solicitudes",
        "menu" => "Solicitudes Ingreso",
        "menu_css_class" => "fa fa-credit-card",
        "link" => 'pages/components/solicitudes_pendientes_ingreso.php'
    ),
    
         "012" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de Solicitudes",
        "small" => "Solicitudes",
        "menu" => "Solicitudes Compra/Venta",
        "menu_css_class" => "fa fa-credit-card",
        "link" => 'pages/components/solicitudes_pendientes_compra_venta.php'
    ),
    
    //GESTION DE SERVICIOS
    "009" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "Servicios",
        "small" => "Mis Servicios",
        "menu" => "Mis Servicios",
        "menu_css_class" => "fa fa-pencil-square-o",
        "link" => 'pages/components/crear_servicio.php'
    ),
    
    
 
    
// GESTION DE CUENTAS PARA VENDEDOR MAYORISTA 
   /* "011" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "GTI",
        "menu_css_class" => "fa fa-credit-card",
        "small" => "Gestionar Cuentas",
        "menu" => "Gestionar Cuentas",
        "submenu" => array(
            "2" => "012",
            "3" => "013",
            "4" => "014",
            "5" => "015",
            "6" => "016",
        )
    ),*/
    // GESTION DE CUENTAS PARA ADMINISTRADOR
    "017" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "GTI",
        "menu_css_class" => "fa fa-credit-card",
        "small" => "Administrar Cuentas",
        "menu" => "Gestionar Cuentas",
        "submenu" => array(
            "2" => "016",
            "3" => "015",
        )
    ),
    //SUGERENCIAS
    /*  "004" => array(
      "show" => true,
      "isSubmenu" => false,
      "big" => "GTI",
      "small" => "Sugerencias",
      "menu" => "Sugerencias",
      "menu_css_class" => "fa-envelope",
      "link" => 'pages/sugerencias/body.php'
      ),
      "005" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Clientes",
      "small" => "Mis clientes",
      "menu" => "Mis clientes",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => 'pages/components/clientes.php'
      ), */
    /* "006" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Administración",
      "small" => "Cuentas cargadas",
      "menu" => "Cuentas cargadas",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => 'pages/components/cuentas_cargadas.php'
      ),
      "007" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Administración",
      "small" => "Mis solicitudes",
      "menu" => "Solicitudes",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => 'pages/components/solicitudes.php'
      ), */
    /* "008" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Administración",
      "small" => "Mis solicitudes",
      "menu" => "Solicitudes",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => 'pages/components/aprobar_solicitudes_administrador.php'
      ), */
    /*"009" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Administración",
        "small" => "Mis solicitudes",
        "menu" => "Solicitudes",
        "menu_css_class" => "fa-file-pdf-o",
        "link" => 'pages/components/aprobar_solicitudes_vendedor.php'
    ),*/
    //BUZON DE CUENTAS FABRICADAS Y ASIGNADAS
    /*"010" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "GTI",
        "small" => "Buzon cuentas asignadas",
        "menu" => "Historial de Cuentas ",
        "menu_css_class" => "fa fa-credit-card",
        "link" => 'pages/components/historial_cuentas_admin_operacion.php'*/
    //),
   /* "012" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de cuentas",
        "small" => "Cuentas Compradas",
        "menu" => "Cuentas Compradas",
        "menu_css_class" => "fa fa-credit-card",
        "link" => 'pages/components/buzon_cuentas_vendedor_mayorista.php'*/
    //),
    "013" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de cuentas",
        "small" => "Cuentas Asignadas",
        "menu" => "Cuentas Asignadas",
        "menu_css_class" => "fa fa-credit-card",
        "link" => 'pages/components/cuentas_asignadas_vendedor_mayorista.php'
    ),
    "014" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Vendedor Mayorista",
        "small" => "Mi estado de Cuenta",
        "menu" => "Mi estado de Cuenta",
        "menu_css_class" => "fa fa-credit-card",
        "link" => 'pages/components/estado_cuenta_vendedor_mayorista.php'
    ),
    "015" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Vendedor Mayorista",
        "small" => "Estado de Cuenta Cliente",
        "menu" => "Estado de Cuenta Clientes",
        "menu_css_class" => "fa fa-credit-card",
        "link" => 'pages/components/estado_cuenta_clientes.php'
    ),
    "016" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Gestión de Cuentas",
        "small" => "Estados de Cuenta Vendedores",
        "menu" => "Estados de Cuenta Vendedores",
        "menu_css_class" => "fa fa-credit-card",
        "link" => 'pages/components/estado_cuenta_vendedores.php'
    ),
    "019" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Administración",
        "small" => "Estados de Cuenta Clientes",
        "menu" => "Estados de Cuenta Clientes",
        "menu_css_class" => "fa fa-credit-card",
        "link" => 'pages/components/estado_cuenta_clientes_admin.php'
    ),
    "020" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "GTI",
        "menu_css_class" => "fa fa-cogs",
        "small" => "Soporte",
        "menu" => "Soporte",
        "link" => 'pages/components/soporte.php'
    ),
    /* "021" => array(
      "show" => true,
      "isSubmenu" => false,
      "big" => "Administración",
      "small" => "Mis Tarifas",
      "menu" => "Mis Tarifas",
      "menu_css_class" => "fa-money",
      "link" => 'pages/components/tarifas.php'
      ), */
    /* "009" => array(
      "show" => true,
      "isSubmenu" => false,
      "big" => "GTI",
      "menu_css_class" => "fa-clock-o",
      "small" => "Bitácora de Operación",
      "menu" => "Bitácora de Operación",
      "submenu" => array(
      "2" => "006",
      "3" => "010",
      "4" => "011",
      "5" => "014"
      )
      ),
      "006" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Bitácora de operación",
      "small" => "Registro histótico",
      "menu" => "Registro histórico",
      "link" => 'pages/bitacora_operacion/registro_historico_operacion/body.php',
      "menu_css_class" => "fa-list"
      ),
      "010" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Bitácora de operación",
      "small" => "Pendientes Aprobación",
      "menu" => "Pendientes Aprobación",
      "link" => 'pages/bitacora_operacion/actividades_pendientes/body.php',
      "menu_css_class" => "fa-edit"
      ), */
    /* "011" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Bitácora de operación",
      "small" => "Asignacion de Contratos",
      "menu" => "Asignacion de Contratos",
      "link" => 'pages/bitacora_operacion/asignacion_contratos/body.php',
      "menu_css_class" => "fa-edit"
      ),
      "014" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Bitácora de operación",
      "small" => "Registro de Ausentismo",
      "menu" => "Registro de Ausentismo",
      "link" => 'pages/bitacora_operacion/registro_ausentismo/body.php',
      "menu_css_class" => "fa-plane"
      ),

     */

    /*  "017" => array(
      "show" => true,
      "isSubmenu" => false,
      "big" => "GTI",
      "menu_css_class" => "fa-cogs",
      "small" => "Administración",
      "menu" => "Administración",
      "submenu" => array(
      "1" => "018",
      "2" => "054",
      "3" => "070",
      "4" => "007",
      )
      ),
      "018" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Administración",
      "small" => "Actualizar Usuario",
      "menu" => "Actualizar Usuario",
      "link" => 'pages/administracion/actualizar_usuarios/body.php',
      "menu_css_class" => "fa-user-plus"
      ),
      "054" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Administración",
      "small" => "Crear Usuarios",
      "menu" => "Crear Usuarios",
      "link" => 'pages/administracion/crear_usuario/body.php',
      "menu_css_class" => "fa-user-plus"
      ), */

    /* "001" => array(
      "show" => true,
      "isSubmenu" => false,
      "big" => "GTI",
      "menu_css_class" => "fa fa-pie-chart",
      "small" => "Reportes",
      "menu" => "Reportes Bitácora",
      "submenu" => array(
      "page1" => "003",
      "page2" => "008",
      "page3" => "019",
      "page4" => "020",
      "page5" => "021",
      "page6" => "022",
      "page7" => "030",
      "page8" => "045",
      "page9" => "047",
      "page10" => "048",
      "page11" => "049",
      "page12" => "055",
      "page13" => "056",
      )
      ),
      "041" => array(
      "show" => true,
      "isSubmenu" => false,
      "big" => "Reportes",
      "small" => "Gestion de Eventos",
      "menu" => "Reportes Eventos",
      "menu_css_class" => "fa fa-area-chart",
      "submenu" => array(
      "page9" => "044",
      "page10" => "032",
      "page11" => "033",
      "page12" => "034",
      "page13" => "035",
      "page14" => "036",
      "page22" => "064",
      "page15" => "037",
      "page16" => "040",
      "page17" => "038",
      "page18" => "039",
      "page19" => "057",
      "page20" => "062",
      "page21" => "066",
      )
      ),
     */
    /* "007" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "GTI",
      "small" => "Cambiar Contraseña",
      "menu" => "Cambiar Contraseña",
      "link" => 'pages/cambiar_contrasena/body.php',
      "menu_css_class" => "fa-key"
      ),
      "062" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Editar Informes",
      "small" => "Editar Informes",
      "menu" => "Editar Informes",
      "menu_css_class" => "fa-pencil-square-o",
      "link" => 'pages/components/editar_informes.php'
      ),
      /* "064" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Detalles Evento por CI",
      "small" => "Detalles",
      "menu" => "Detalles Evento por CI",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => 'pages/components/detalles_evento_ci.php'
      ),
      "065" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Gestión de eventos",
      "small" => "Mis eventos cerrados",
      "menu" => "Mis eventos cerrados",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => 'pages/components/eventos_cerrados_analista.php'
      ),
      "003" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reportes",
      "small" => "Contratos",
      "menu" => "Contratos",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/contratos/body.php"
      ),
      "008" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reportes",
      "small" => "Productividad",
      "menu" => "Productividad",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/productividad/body.php"
      ),
      "019" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reportes",
      "small" => "Grafico Productividad",
      "menu" => "Grafico Productividad",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/grafico_productividad/body.php"
      ),
      "020" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reportes",
      "small" => "Grafico Productividad Personas",
      "menu" => "Grafico Prod. Personas",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/grafico_productividad_personas/body.php"
      ),
      "021" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reportes",
      "small" => "Historico de Actividades Diarias",
      "menu" => "Grafico Hist. Act.",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/grafico_histo_actividades/body.php"
      ),
      "022" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reportes",
      "small" => "Reporte de Novedades",
      "menu" => "Reporte de Novedades",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/novedades/body.php"
      ),
      "023" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reportes",
      "small" => "Productividad",
      "menu" => "Productividad",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/productividad/body.php"
      ),
      "030" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reportes",
      "small" => "Mensuales",
      "menu" => "Mensuales",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/mensuales/body.php"
      ),
      "043" => array(
      "show" => false,
      "isSubmenu" => false,
      "big" => "Reporte Mantenimiento",
      "small" => "Mantenimiento",
      "menu" => "Reporte Mantenimiento",
      "menu_css_class" => "fa-envelope",
      "link" => 'pages/components/mantenimiento.php',
      ),
      "044" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Eventos Abiertos",
      "small" => "Eventos Abiertos ",
      "menu" => "Eventos Abiertos",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/evento_abierto_contrato/body.php"
      ),
      "045" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reporte Productividad Mensual",
      "small" => "Reporte Productividad Mensual",
      "menu" => "Reporte Productividad Mensual",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/productividad_mensual/body.php"
      ),
      "046" => array(
      "show" => false,
      "isSubmenu" => false,
      "big" => "GTI",
      "small" => "Registro por Demanda",
      "link" => 'pages/bitacora_operacion/registro/registro_demanda.php'
      ),
      "047" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reporte Nocturno",
      "small" => "Reporte Nocturno",
      "menu" => "Reporte Nocturno",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/reporte_nocturno/body.php"
      ),
      "048" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reporte fin de Semana",
      "small" => "Reporte fin de Semana",
      "menu" => "Reporte fin de Semana",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/reporte_fin_semana/body.php"
      ),
      "049" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Reporte Horas Extra",
      "small" => "Reporte Horas Extra",
      "menu" => "Reporte Horas Extra",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/reporte_hora_extra/body.php"
      ),
      "055" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Registro por Contrato",
      "small" => "Registro por Contrato",
      "menu" => "Registro por Contrato",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => "pages/reportes/registro_contrato/body.php"
      ),
      "056" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Registro Detalles por Contrato",
      "small" => "Registro por Contrato",
      "menu" => "Registro Detalles por Contrato",
      "menu_css_class" => "fa-file-pdf-o",
      "link" => 'pages/reportes/registro_detalles_contrato/registro_detalles_contrato.php'
      ),
      "057" => array(
      "show" => true,
      "isSubmenu" => true,
      "big" => "Analisis de Informes",
      "small" => "Analisis de Informes",
      "menu" => "Analisis de Informes",
      "menu_css_class" => "fa-pencil-square-o",
      "link" => 'pages/components/analisis_informes.php'
      ), */
    "032" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Eventos Masivos Abiertos",
        "small" => "Eventos Masivos Abiertos",
        "menu" => "Eventos Masivos Abiertos",
        "menu_css_class" => "fa-file-pdf-o",
        "link" => "pages/reportes/evento_masivo_abierto/body.php"
    ),
    "033" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Eventos por Responsable",
        "small" => "Eventos por Responsable",
        "menu" => "Eventos por Responsable",
        "menu_css_class" => "fa-file-pdf-o",
        "link" => "pages/reportes/evento_responsable/body.php"
    ),
    "034" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Eventos, Reporte General",
        "small" => "Eventos, Reporte General",
        "menu" => "Eventos General",
        "menu_css_class" => "fa-file-pdf-o",
        "link" => "pages/reportes/evento_general/body.php"
    ),
    "035" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Eventos Masivos, Reporte General",
        "small" => "Eventos Masivos, Reporte General",
        "menu" => "Eventos Masivos General",
        "menu_css_class" => "fa-file-pdf-o",
        "link" => "pages/reportes/evento_masivo_general/body.php"
    ),
    "036" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Eventos por CI",
        "small" => "Eventos por CI",
        "menu" => "Eventos por CI",
        "menu_css_class" => "fa-file-pdf-o",
        "link" => "pages/reportes/evento_ci/body.php"
    ),
    "037" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Eventos por Servicio",
        "small" => "Eventos por Servicio",
        "menu" => "Eventos por Servicio",
        "menu_css_class" => "fa-file-pdf-o",
        "link" => "pages/reportes/evento_servicio/body.php"
    ),
    "038" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Eventos por Contrato",
        "small" => "Gráfico Eventos por Contrato",
        "menu" => "Eventos por Contrato",
        "menu_css_class" => "fa fa-area-chart",
        "link" => "pages/reportes/grafico_evento_contrato/body.php"
    ),
    "066" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Eventos Abiertos por Contrato",
        "small" => "Gráfico Eventos Abiertos por Contrato",
        "menu" => "Eventos Abiertos por Contrato",
        "menu_css_class" => "fa fa-area-chart",
        "link" => "pages/reportes/grafico_evento_abierto_contrato/body.php"
    ),
    "039" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Capacidad y Disponibilidad",
        "small" => "Gráfico Eventos",
        "menu" => "Capacidad y Disponibilidad",
        "menu_css_class" => "fa fa-area-chart",
        "link" => "pages/reportes/grafico_dispo_capa/body.php"
    ),
    "040" => array(
        "show" => true,
        "isSubmenu" => true,
        "big" => "Reporte ,CI's por Contrato",
        "small" => "Cantidad de CI's por Contrato",
        "menu" => "Cantidad de CI's por Contrato",
        "menu_css_class" => "fa-file-pdf-o",
        "link" => "pages/reportes/ci_contrato/body.php"
    ),
    "041" => array(
        "show" => true,
        "isSubmenu" => false,
        "big" => "Administración SU",
        "small" => "Permisos",
        "menu" => "Delegar Permisos",
        "menu_css_class" => "fa fa-pencil-square-o",
        "link" => 'pages/components/delegar_permiso_gerente.php'
    ),
    "500" => array(
        "show" => false,
        "link" => 'pages/error/500.php'
    ),
    "404" => array(
        "show" => false,
        "link" => 'pages/error/404.php'
    )
);
//}