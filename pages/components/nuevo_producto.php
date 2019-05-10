

<?php
//categorias de productos
$conn = new conexion();

$categorias = $conn->getCategoriasProducto();
?>
<style>
    .card_filtro{box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); padding: 10px; margin: 5px;}

    .animated {animation-duration: 1s; animation-fill-mode: both;}
    .fadeInLeft{animation-name: fadeInLeft;}
    @keyframes fadeInLeft{from {opacity: 0; transform: translate3d(20%, 0, 0);}to {opacity: 1; transform: none;}}

</style>  
<ul  class="nav nav-pills">
    <li class="active">
        <a  href="#categorias" data-toggle="tab">¿Que producto crearás?</a>
    </li>
    <li class="pestana_1 disabled"><a id="pestana_1"  href="#2a" >Datos generales del producto</a>
    </li>
    <li><a href="#3a" data-toggle="tab">Datos específicos del producto</a>
    </li>
    <li><a href="#4a" data-toggle="tab">Confirmar publicación</a>
    </li>
</ul>

<div class="tab-content clearfix">
    <!--MENU CATEGORIAS-->

    <div class="tab-pane active" id="categorias">
        <div id="filtro" class="tab-pane fade in active justify-content-center" >

            <!--            <br><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb nav_productos">
                                    <li class="breadcrumb-item"><a href="#">Productos</a></li>
                                    <li class="breadcrumb-item active" id="bread_cat" aria-current="page"></li>
                                    <li class="breadcrumb-item active" id="bread_sub" aria-current="page"></li>
                                    <li class="breadcrumb-item active" id="bread_ele" aria-current="page"></li>
                                </ol>
                            </nav>
                        </div>-->

            <style>
                .card_filtro{box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); padding: 10px; margin: 5px;}
            </style>  

            <br><br><div class="container-fluid ">
                <div class="row">
                    <div class="col-md-4 col-sm-12 animated fadeInLeft">
                        <div class="row card_filtro ">
                            <div class="col-md-6 col-sm-12">
                                <img class="img-responsive center-block" src="dist/img/vender.png">                            
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <h4 class="text-center">Categorias</h4>
                                <ul id="ul_categoria">
                                    <?php while ($cat = $categorias->fetch_assoc()) { ?>
                                        <li class="filtros" id="categoria_<?php echo $cat["id"] ?>"><a href="#" class="categoria_producto" id="<?php echo $cat["id"] ?>"><?php echo $cat["nombre"] ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>

                        </div>
                    </div> 

                    <div class="col-md-4 col-sm-12 animated fadeInLeft" id="card_subcategoria" style="display: none">
                        <div class="row card_filtro">
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

                    <div class="col-md-4 col-sm-12 animated fadeInLeft" id="card_elementos" style="display: none">
                        <div class="row card_filtro">
                            <div class="col-md-6 col-sm-12">
                                <img class="img-responsive center-block" src="dist/img/vender.png">                            
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <h4 class="text-center">Elementos Específicos</h4>
                                <ul id="resultado_elementos_especificos"></ul>
                            </div>

                        </div>
                    </div>
                </div> 
            </div><br>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 5px;">
                        <button title="Nueva Subcategoría" id="btn_nueva_subcategoria" type="button" class="btn btn-labeled btn-primary">
                            <span class="btn-label"><i class="glyphicon glyphicon-plus"></i> Nueva Subcategoría</span></button>            

                        <button title="Nuevo Elemento" id="btn_nuevo_elemento" type="button" class="btn btn-labeled btn-primary">
                            <span class="btn-label"><i class="glyphicon glyphicon-plus"></i> Nuevo Elemento</span> </button><br><br>

                        <button style="display: none" id="siguiente_1" class="btn btn-info animated fadeInLeft ">Siguiente</button>

                    </div>


                </div>
            </div>

        </div>



    </div>
    <!--FIN MENU CATEGORIAS-->
    <div class="tab-pane" id="2a">
        <h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
    </div>
    <div class="tab-pane" id="3a">
        <h3>We applied clearfix to the tab-content to rid of the gap between the tab and the content</h3>
    </div>
    <div class="tab-pane" id="4a">
        <h3>We use css to change the background color of the content to be equal to the tab</h3>
    </div>
</div>





<!--<ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#filtro">¿Que producto crearás?</a></li>
    <li class="disabled"><a data-toggle="pill" class="disabled" href="#datos_generales">Datos generales del producto</a></li>
    <li class="disabled"><a data-toggle="pill" class="disabled" href="#datos_especificos">Datos específicos del producto</a></li>
    <li class="disabled"><a disabled="disabled" data-toggle="pill"  class="disabled" href="#confirmacion">Confirmar publicación</a></li>
</ul>

<div class="tab-content">

    MENU FILTRO
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
    FIN MENU FILTRO



    <div id="datos_generales" class="tab-pane fade">
        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="datos_especificos" class="tab-pane fade">
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="confirmacion" class="tab-pane fade">
        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
</div>-->

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

        var array_filtros = [];
        $("#siguiente_1").click(function () {
            $(".pestana_1").removeClass("disabled");
            $("#pestana_1").attr("data-toggle", "tab");
            $("#pestana_1").trigger("click");
        })


        $("#select_categoria").on("change", function () {

            var categoria = $("#select_categoria option:selected").val();
            //enviamos el valor al ajax para poder cargar las subcategorias
            $.ajax({
                type: 'POST',
                url: "modelo/ajax_generales.php",
                data: {
                    id_categoria: categoria,
                    tipo: 'producto',
                    tipo_select: 'select_modal'
                },
                success: function (data) {

                    if (!data) {
                        alert("no hay");
                        return;
                    }
                    $("#select_subcategoria").removeAttr("disabled");
                    $("#select_subcategoria").html(data);
                }
            });
        })


        $(".categoria_producto").click(function () {
            //tomamos el id de la categortia
            var id_categoria_producto = $(this).attr("id");
            //tomamos el que tiene la clase activa y se la quitamos
            var li_categoria = $("#ul_categoria").children();
            li_categoria.removeClass("active");
            //ponemos activo al elemento elegido
            $("#categoria_" + id_categoria_producto).addClass("active");
            array_filtros[0] = id_categoria_producto;
            //seteamos el breadcrumb
//            $(".nav_productos").append("<li class='breadcrumb-item active' id='bread_cat' aria-current='page'>"+$(this).text()+"</li>");
            console.log(array_filtros);
            $.ajax({
                data: {
                    id_categoria: id_categoria_producto,
                    tipo: 'producto',
                },
                url: 'modelo/ajax_generales.php',
                type: 'post',
                success: function (response) {
                    if (!response) {
                        //ocultamos las dos cartas siguientes y setemaos el valor en null
                        //que corresponde en el array
                        $("#siguiente_1").css("display", "block");
                        $("#card_subcategoria").css("display", "none");
                        $("#card_elementos").css("display", "none");
                        array_filtros[1] = "";
                        array_filtros[2] = "";
                        console.log(array_filtros);
                        return;
                    }
                    $('#resultado_subcategoria').html(response);
                    $("#card_subcategoria").css("display", "block");
                    console.log(array_filtros);
                }
            });
        });
        $(document).on('click', '.sub_categoria_producto', function () {
            var id_subcategoria = $(this).attr("id");
            var li_subcategoria = $("#resultado_subcategoria").children();
            li_subcategoria.removeClass("active");
            $("#subCategoria_" + id_subcategoria).addClass("active");
            array_filtros[1] = id_subcategoria;
            $.ajax({
                data: {
                    id_subcategoria: id_subcategoria,
                    tipo: 'producto',
                },
                type: 'POST',
                url: "modelo/ajax_generales.php",
                success: function (response) {
                    if (!response) {

                        //ocultamos la cartaa siguientea y setemaos el valor en null
                        //que corresponde en el array
                        $("#card_elementos").css("display", "none");
                        array_filtros[2] = "";
                        console.log(array_filtros);
                        $("#siguiente_1").css("display", "block");
                        return;
                    }
                    $("#resultado_elementos_especificos").html(response);
                    $("#card_elementos").css("display", "block");
                    console.log(array_filtros);
                }
            });
        });
        $(document).on('click', '.elemento_sub_categoria', function () {
            var id_elemento_especifico = $(this).attr("id");
            var li_elementos = $("#resultado_elementos_especificos").children();
            li_elementos.removeClass("active");
            $("#elemento_" + id_elemento_especifico).addClass("active");
            array_filtros[2] = id_elemento_especifico;
            $("#siguiente_1").css("display", "block");
            console.log(array_filtros);
//            $.ajax({
//                data: {
//                    id_elemento_especifico: id_elemento_especifico,
//                    tipo: 'producto',
//                },
//                type: 'POST',
//                url: "modelo/ajax_generales.php",
//                success: function (response) {
//                }
//            });
        });
        $("#btn_crea_subcategoria").on("click", function () {
            //tomamos el valor de los datos
            var id_categoria = $("#id_categoria").val();
            var nombre_subcategoria = $("#nombre_nueva_subcategoria").val();
            var descripcion = $("#descripcion_nueva_subcategoria").val();
            if (id_categoria == null || nombre_subcategoria == "") {
                alertify.alert("<P align=center><b>Los campos marcados con <font color='red'>*</font> son de caracter obligatorio.");
                return;
            }

            $.ajax({
                type: 'POST',
                url: "modelo/ajax_generales.php",
                data: {
                    id_categoria: id_categoria,
                    nombre_subcategoria: nombre_subcategoria,
                    descripcion: descripcion,
                    tipo_creado: 'subcategoria'
                },
                success: function (response) {
                    $("#respuesta_nueva_subcategoria").html(response);
                    alertify.alert("<P align=center><b>Subcategoria creada correctamente.");
                }
            })
        });



        $("#btn_crea_elemento").on("click", function () {
            var id_categoria = $("#select_categoria").val();
            var id_subcategoria = $("#select_subcategoria").val();
            var nombre_elemento = $("#nombre_nuevo_elemento").val();
            var descripcion_elemento = $("#descripcion_nuevo_elemento").val();

            if (id_categoria == null || id_subcategoria == null || nombre_elemento == "") {
                alertify.alert("<P align=center><b>Los campos marcados con <font color='red'>*</font> son de caracter obligatorio.");
                return;
            }

            $.ajax({
                type: 'POST',
                url: "modelo/ajax_generales.php",
                data: {
                    id_categoria: id_categoria,
                    id_subcategoria: id_subcategoria,
                    nombre_elemento: nombre_elemento,
                    descripcion_elemento: descripcion_elemento,
                    tipo_creado: 'elemento_especifico'
                },
                success: function (response) {
                    $("#respuesta_nuevo_elemento").html(response);
                    alertify.alert("<P align=center><b>Elemento creado correctamente.");
                }
            })
        });




        $("#btn_nueva_subcategoria").on("click", function () {
            $("#mdl_nueva_subcategoria").modal("show");
        });
        $("#btn_nuevo_elemento").on("click", function () {
            $("#mdl_nuevo_elemento").modal("show");
        });
    });



</script>
<style>
    .filtros.active a{
        background-color: #00c0ef;
        border-color: #00acd6;    
        color: white;

    }
    .filtros :hover{
        color: #4393a6;
    }
</style>
<!--INICIO MODAL NUEVA SUBCATEGORIA-->
<div id="mdl_nueva_subcategoria" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <h3 class="modal-title">Nueva Subcategoría</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">


                    <label>Nombre Subcategoría<font color='red'> *</font></label>
                    <input  type="text" class="form-control" id="nombre_nueva_subcategoria">

                    <label>Categoría a la que pertenece<font color='red'> *</font></label>
                    <select class="form-control" id="id_categoria">
                        <option disabled selected>Seleccione una categoría</option>
                        <?php
                        $categorias_producto = $conn->getCategoriasProducto();
                        while ($categoria = $categorias_producto->fetch_Assoc()) {
                            ?>
                            <option  value="<?php echo $categoria["id"] ?>"><?php echo $categoria["nombre"] ?></option>
                        <?php } ?>
                    </select>

                    <label>Descripción Subcategoría</label>
                    <textarea id="descripcion_nueva_subcategoria" class="form-control" style="resize: none; height: 100px" ></textarea>
                    <div id="respuesta_nueva_subcategoria"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_crea_subcategoria">Crear Subcategoria</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger">Cancelar</button>
            </div>  
        </div>
    </div>
</div>
<!--FIN MODAL NUEVA SUBCATEGORIA-->

<!--INICIO MODAL NUEVO ELEMENTO--->
<div id="mdl_nuevo_elemento" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: url(dist/img/fondo_metal_rojo.jpg);color: white;text-align-last: start;">
                <h3 class="modal-title">Nuevo Elemento</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Categoría<font color='red'> *</font></label>
                    <select class="form-control" id="select_categoria">
                        <option disabled selected>Seleccione una categoría</option>
                        <?php
                        $categorias_producto = $conn->getCategoriasProducto();
                        while ($categoria = $categorias_producto->fetch_Assoc()) {
                            ?>
                            <option  value="<?php echo $categoria["id"] ?>"><?php echo $categoria["nombre"] ?></option>
                        <?php } ?>
                    </select>
                    <label>Subcategoría<font color='red'> *</font></label>
                    <select id="select_subcategoria" class="form-control" disabled>
                    </select>

                    <label>Nombre Elemento<font color='red'> *</font></label>
                    <input  type="text" class="form-control" id="nombre_nuevo_elemento">

                    <label>Descripción del elemento</label>
                    <textarea id="descripcion_nuevo_elemento" class="form-control" style="resize: none; height: 100px" ></textarea>
                    <div id="respuesta_nuevo_subcategoria"></div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_crea_elemento">Crear Elemento</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger">Cancelar</button>
            </div>  
        </div>
    </div>
</div>