

<?php
//categorias de productos
$conn = new conexion();

$categorias = $conn->getCategoriasProducto();
?>

<ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#filtro">¿Que producto crearás?</a></li>
    <li class="disabled"><a data-toggle="pill" class="disabled" href="#datos_generales">Datos generales del producto</a></li>
    <li class="disabled"><a data-toggle="pill" class="disabled" href="#datos_especificos">Datos específicos del producto</a></li>
    <li class="disabled"><a disabled="disabled" data-toggle="pill"  class="disabled" href="#confirmacion">Confirmar publicación</a></li>
</ul>

<div class="tab-content">

    <!--MENU FILTRO-->
    <div id="filtro" class="tab-pane fade in active justify-content-center" >

        <br><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Productos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tecnología</li>
                    <li class="breadcrumb-item active" aria-current="page">Celulares</li>
                    <li class="breadcrumb-item active" aria-current="page">Auriculares</li>
                </ol>
            </nav>
        </div>

        <style>
            .cardmarlon{box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); padding: 10px; margin: 5px;}
        </style>  

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="row cardmarlon">
                        <div class="col-md-6 col-sm-12">
                            <img class="img-responsive center-block" src="dist/img/vender.png">                            
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h4 class="text-center">Categorias</h4>
                            <ul>
                                <?php while ($cat = $categorias->fetch_assoc()) { ?>
                                    <li class="breadcrumb-item" ><a href="#" class="categoria_producto" id="<?php echo $cat["id"] ?>"><?php echo $cat["nombre"] ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div> 

                <div class="col-md-4 col-sm-12">
                    <div class="row cardmarlon">
                        <div class="col-md-6 col-sm-12">
                            <img class="img-responsive center-block" src="dist/img/vender.png">                            
                        </div>
                        <div class="col-md-6 col-sm-12" class="subcategorias">
                            <h4 class="text-center">Subcategorías</h4>
                            <ul id="resultado_subcategoria">
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="row cardmarlon">
                        <div class="col-md-6 col-sm-12">
                            <img class="img-responsive center-block" src="dist/img/vender.png">                            
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h4 class="text-center">Elelemntos Específicos</h4>
                            <ul id="resultado_elementos_especificos">
                        </div>
                    </div>
                </div> 
            </div>
        </div>



    </div>
    <!--FIN MENU FILTRO-->



    <div id="datos_generales" class="tab-pane fade">
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="datos_especificos" class="tab-pane fade">
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="confirmacion" class="tab-pane fade">
        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
</div>

<style>
    .card{
        width: 100%;
        margin-top: 30px;
        padding: 10px;
        padding-right: 0px;
        height: 285px;

    }

    .scrollable{
        overflow-y: auto;
        overflow-x: hidden;
        max-height: 250px; 
        width: 100%;
        height: 100%;
    }



</style>

<script>
    $(document).ready(function () {
        $(".nav li.disabled a").click(function () {
            return false;
        });



        $(".categoria_producto").click(function () {

            //tomamos el id de la categortia
            var id_categoria_producto = $(this).attr("id");
            $.ajax({
                data: {
                    id_categoria: id_categoria_producto,
                    tipo: 'producto',
                },
                url: 'modelo/ajax_generales.php',
                type: 'post',
                success: function (response) {
                    // alertify.alert("<P align=center><b>Solicitud aprobada correctamente!", function () {

                    //window.setTimeout('location.reload()');
                    //});
                    $('#resultado_subcategoria').html(response);
                }
            });
        });

        $(document).on('click', '.sub_categoria_producto', function () { //E
            var id_subcategoria = $(this).attr("id");

            $.ajax({
                data: {
                    id_subcategoria: id_subcategoria,
                    tipo: 'producto',
                },
                type: 'POST',
                url: "modelo/ajax_generales.php",
                success: function (data) {
                    $("#resultado_elementos_especificos").html(data);
                }
            });
        });



    });



</script>