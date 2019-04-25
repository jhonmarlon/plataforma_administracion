<!DOCTYPE html>
<?php
header("Content-Type: text/html;charset=utf-8");

//include_once './seguridad/salida.php';

session_start();
if ($_SESSION ['authenticated'] == 1) {

    include_once 'modelo/conexion.php';
    $con = new conexion;

    include_once 'seguridad/userinfo.class.php';

    $id_usuario = $_SESSION['id_usuario'];
    $id_rol = $_SESSION['id_rol'];
    $cedula = $_SESSION['cedula'];
    $nombre = ucwords(strtolower($_SESSION['nombre']));
    $apellido = ucwords(strtolower($_SESSION['apellido']));
    $correo = $_SESSION['correo'];
    $telefono = $_SESSION['telefono'];
    $celular = $_SESSION['celular'];
    $codigo = $_SESSION["codigo"];
    $id_empresa = $_SESSION["id_empresa"];
    $nombre_empresa = $_SESSION["nombre_empresa"];
    $codigo_empresa = $_SESSION["codigo_empresa"];
    $saldo_empresa = $_SESSION['saldo_empresa'];

    $userinfo = new UserInfo;
    $userinfo->id_usuario = $id_usuario;
    $userinfo->id_rol = $id_rol;
    $userinfo->cedula = $cedula;
    $userinfo->nombre = $nombre;
    $userinfo->apellido = $apellido;
    $userinfo->correo = $correo;
    $userinfo->telefono = $telefono;
    $userinfo->celular = $celular;
    $userinfo->codigo = $codigo;
    $userinfo->id_empresa = $id_empresa;
    $userinfo->nombre_empresa = $nombre_empresa;
    $userinfo->codigo_empresa = $codigo_empresa;
    $userinfo->saldo_empresa = $saldo_empresa;

    include_once 'plantilla/vista.class.php';
    include_once 'pages.config.php';

    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = "000";
    }

    $vista = new Vista($page, $_PAGE_CONFIG, $_PAGE_PERMISSIONS);
    ?>
    <html>
        <?php
        include 'plantilla/header.php';
        ?>
        <body class="hold-transition skin-blue sidebar-mini">
            <div id="loading"></div>
            <div id="page">
                <div class="wrapper">
                    <?php
                    include 'plantilla/main_header.php';
                    include 'plantilla/menu_lateral.php';
                    ?>
                    <!-- Content Wrapper. Contains page content -->
                    <div class="content-wrapper">
                        <!-- Content Header (Page header) -->

                        <?php
                        echo $vista->breadcrumb;
                        ?>

                        <!-- Main content -->
                        <section class="content">
                            

                            <?php
                            try {
                                include 'pages/tablero/body_pages.php';

                                include 'controlador.php';
                            } catch (Exception $e) {
                                ?>
                                <script type="text/javascript">
                                    window.location = "index.php?page=500";
                                </script>
                                <?php
                            }
                            ?>

                        </section>
                        <!-- /.content -->
                    </div>
                    <?php
                    include 'plantilla/footer.php';
                    ?>
                </div>
            </div>
        </body>
    </html>
    <?php
} else {
    header("Location: login.php");
}
?>

<script>
// Jquery Dependency

    $("input[data-type='currency']").on({
        keyup: function () {
            formatCurrency($(this));
        },
        blur: function () {
            formatCurrency($(this), "blur");
        }
    });




    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") {
            return;
        }

        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            if (blur === "blur") {
                input_val += ".00";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }




 $(document).ready(function () {
    function close_accordion_section() {
    $('.accordion .accordion-section-title').removeClass('active');
            $('.accordion .accordion-section-content').slideUp(300).removeClass('open');
    }
    $('.accordion-section-title').click(function (e) {
    // Grab current anchor value
    var currentAttrValue = $(this).attr('href');
            if ($(e.target).is('.active')) {
    close_accordion_section();
    } else {
    close_accordion_section();
            // Add active class to section title
            $(this).addClass('active');
            // Open up the hidden content panel
            $('.accordion ' + currentAttrValue).slideDown(300).addClass('open');
    }
    e.preventDefault();
    });
    });

</script>

<script>
(function($) {
 
    $(function() {
 
        $('.multi-select-dd').fSelect();
 
    });
 
})(jQuery);
 
</script>