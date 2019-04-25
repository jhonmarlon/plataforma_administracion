<script src="plugins/jQuery/jquery-3.3.1.js"></script>
<script>

    $(document).ready(function () {

        $("#cantidad").attr("disabled", true);


        $(".tipo_cel").click(function () {
            if (($(this).val()) == "con_serial") {
                //mostramolslas opciones del imei
                $("#info_imei").css("display", "block");
                //deshabilitamos la cantidad
                $("#cantidad").val("");
                $("#cantidad").attr("disabled", true);
            } else {
                //habilitamos la cantidad
                $("#cantidad").attr("disabled", false);
                //ocultamos opciones del imei
                $("#info_imei").css("display", "none");

            }
        });

        $(".vista_imei").click(function () {
            if (($(this).val()) == "imei_vista_individual") {
                //mostramos text input para el imei individual
                $("#imei_individual").css("display", "block");
                //ocultamos el masivo
                $("#imei_masivo").css("display", "none");
                //ponemos el valor de 1 en la cantidad
                $("#cantidad").val("1");
                //limpiamos campo de imei
                $("#txt_imei_individual").val("");


            } else {
                //habilitamos el text input masivo para el imei
                $("#imei_masivo").css("display", "block");
                //ocultamos opciones del imei
                $("#imei_individual").css("display", "none");
                //limpiamos el campo cantidad
                $("#cantidad").val("");
                //limpiamos el campo de imei masivo
                $("#txt_imei_masivo").val("");



            }
        });


    });

    $("#form_nuevo_producto").submit(function (e) {

        e.preventDefault();
        //tomamos el valor para saber si es un cel con serial o sin serial
        var tipo_cel = $('input:radio[class=tipo_cel]:checked').val();
        if (tipo_cel == undefined) {
            alertify.alert('<b><P align=center>Debe especificar si el celular o celulares a crear tienen serial o no tienen serial! <b>');
            return;
        }

        //creamos el formData para poder enviar los datos
        var formData = new FormData($(this));


        var condicion = $('input:radio[class=condicion]:checked').val();
        var garantia = $('input:radio[class=garantia]:checked').val();


        var nombre_producto = $("#product_tittle").val();
        var descripcion_producto = $("#descripcion_producto").val();
        var imagen1 = $("#product_img1")[0].files[0];
        var imagen2 = $("#product_img2")[0].files[0];
        var imagen3 = $("#product_img3")[0].files[0];
        var imagen4 = $("#product_img4")[0].files[0];
        
        var categoria_producto = $("#product_cat").val();
        var subcategoria_producto = $("#product_sub_cat").val();


        var cantidad = $("#cantidad").val();
        var precio_unitario = $("#precio_unitario").val();

        if (nombre_producto == "" || descripcion_producto == "" || precio_unitario == ""
                || condicion == undefined || garantia == undefined) {
            alertify.alert('<b><P align=center>Todos los campos marcados con <font color="red">*</font> son de caracter obligatorio<b>');
            return;
        }

        if (imagen1 == undefined && imagen2 == undefined && imagen3 == undefined && imagen4 == undefined) {
            alertify.alert('<b><P align=center>Tu producto debe tener almenos 1 foto para ser publicado<b>');
            return;
        }

        // si el celular tiene serial
        if (tipo_cel == "con_serial") {

            //tomamos los campos del imei
            var imei_vista = $('input:radio[class=vista_imei]:checked').val();
            if (imei_vista == undefined) {
                alertify.alert('<b><P align=center>Es necesario que especifiques como deseas diligenciar el IMEI o serial de tus teléfonos o teléfono a publicar<b>');
                return;
            }

            if (imei_vista == "imei_vista_masiva") {
                if (cantidad == "") {
                    alertify.alert('<b><P align=center>El campo cantidad es necesario, sin embargo éste ira incrementando una vez vayas ingresando los IMEI correspondientes a tus equipos \n\
                    en el área de texto correspondiente.<b>');
                    return;
                }
            }

            if (imei_vista == "imei_vista_individual" && ($("#txt_imei_individual").val()) == "") {
                alertify.alert('<b><P align=center>Es necesario que especifiques y diligencies correctamente la sesión de IMEI de tu teléfono a publicar<b>');
                return;
            } else {
                //validamos el imei ingresado
                var imei_individual = $("#txt_imei_individual").val();
                if (!validaIMEI(imei_individual)) {
                    alertify.alert('<b><P align=center>El IMEI ingresado es incorrecto , por favor inténtelo nuevamente<b>');
                    return;
                } else {
                    //enviamos datos a la bd y creamos el celular 
                    alert("creamos el cel con imei individual");
                    //enviamos el formulario serializado

                }

            }

            if (imei_vista == "imei_vista_masiva" && ($("#txt_imei_masivo").val()) == "") {
                alertify.alert('<b><P align=center>Es necesario que especifiques y diligencies correctamente la sesión de IMEI de tus teléfonos o teléfono<b>');
                return;
            } else {

            }

        } else {
            //si no tiene serial
            formData.append('nombre_producto', nombre_producto);
            formData.append('descripcion_producto', descripcion_producto);


        }

    });



    function validaIMEI(s) {
        var etal = /^[0-9]{15}$/;
        if (!etal.test(s))
            return false;
        sum = 0;
        mul = 2;
        l = 14;
        for (i = 0;
                i < l;
                i++) {
            digit = s.substring(l - i - 1, l - i);
            tp = parseInt(digit, 10) * mul;
            if (tp >= 10)
                sum += (tp % 10) + 1;
            else
                sum += tp;
            if (mul == 1)
                mul++;
            else
                mul--;
        }
        chk = ((10 - (sum % 10)) % 10);
        if (chk != parseInt(s.substring(14, 15), 10))
            return false;
        return true;
    }

</script>
<div class="col-lg-12"><!--col-lg-12-->            
    <div class="panel panel-default"><!--panel default-->
        <div class="panel-heading text-center">
            <h3>Crear nuevo teléfono movil o celular.</h3>
        </div>
    </div><!--fin panel default-->

    <form method="post" id="form_nuevo_producto" class="form-horizontal" enctype="multipart/form-data">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <label class="radio-inline">
                <input  id="con_serial" class="tipo_cel" name="radioTipo" type="radio" value="con_serial">Con serial            
            </label>
            <label class="radio-inline">
                <input  id="sin_serial" class="tipo_cel" name="radioTipo" type="radio" value="sin_serial">Sin serial 
            </label>
            <!--            <ul class="buttons">
                            <li><input required id="con_serial" class="radiobtn tipo_cel" name="radioTipo"   type="radio" value="con_serial"  > <span></span>
                                <label for="con_serial" id="r1">Con Serial</label>
                                <input required id="sin_serial" class="radiobtn tipo_cel" name="radioTipo" type="radio" value="sin_serial"   > 
                                <span></span> <label for="sin_serial" id="r2">Sin Serial</label><br>
                            </li>
                        </ul>-->
        </div><br><br><br>

        <div class="row">
            <div class="col-lg-12"><h4>Datos Generales del producto: </h4></div><br><br>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><!---col 6->
                <div class="form-group"><!--form group-->
                <label class="control-label">Nombre de Producto <font color="red">*</font></label>
                <input name="product_tittle" id="product_tittle" type="text" class="form-control" >

                <h4>Imagenes o fotos del producto: <font color="red">*</font> (Almenos 1 imagen de tu producto)</h4>
                <p>Múestralo en detalle, con fondo blaco y buena iluminación para una mejor visualización.</p>
                <input name="product_img1" id="product_img1" type="file" class="form-control" ><br>

                <input name="product_img2" id="product_img2" type="file" class="form-control" ><br>

                <input name="product_img3" id="product_img3" type="file" class="form-control" ><br>

                <input name="product_img4" id="product_img4" type="file" class="form-control" ><br><br>

            </div><!--fin col 6-->

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><!---col 6-->
                <label>Descripción del producto <font color='red'>*</font> (Características de tu producto)</label>
                <textarea placeholder="Ejemplo: Color, tamaño y/o especificaciones técnicas" class="form-control text_area_celulares" id="descripcion_producto"></textarea><br>

                <label>Cantidad a crear <font color="red">*</font></label>
                <input type="number" min="1" class="form-control" id="cantidad"><br>

                <label>Precio Unitario <font color="red">*</font></label>
                <input type="currency"  class="form-control" id="precio_unitario"><br>

            </div><!--fin col 6-->
        </div><!--fin row-->
        <hr>

        <div class="row"><!--row-->
            <div class="col-lg-12"><h4>Datos Complementarios del producto: </h4></div><br><br>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Condición del producto o productos <font color='red'>*</font></label><br>
                <label class="radio-inline">
                    <input  id="producto_nuevo" class="condicion" name="rbtnCondicion" type="radio" value="producto_nuevo" tabindex="1"  >Nuevo                
                </label>
                <label class="radio-inline">
                    <input  id="producto_usado" class="condicion" name="rbtnCondicion" type="radio" value="producto_usado" tabindex="2" >Usado
                </label>
                <!--                <ul class="buttons">
                                    <li><input required id="producto_nuevo" class="radiobtn"  name="rbtnCondicion" type="radio" value="producto_nuevo" tabindex="1" onclick="cerrar()" > <span></span>
                                        <label for="producto_nuevo" id="r1">Nuevo</label>
                                        <input required id="producto_usado" class="radiobtn" name="rbtnCondicion" type="radio" value="producto_usado" tabindex="2" onclick="cerrar()" > 
                                        <span></span> <label for="producto_usado" id="r2">Usado</label><br>
                                    </li>
                
                                </ul>-->
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                <label>Tipo de garantía <font color='red'>*</font></label><br>
                <label class="radio-inline">
                    <input id="garantia_fabrica" class="garantia"  name="rbtnGarantia" type="radio" value="garantia_fabrica" tabindex="1" > Garantía de fabrica 
                </label>
                <label class="radio-inline">
                    <input id="garantia_vendedor" class="garantia" name="rbtnGarantia" type="radio" value="garantia_vendedor" tabindex="2"> Garantía del vendedor                
                </label>
                <label class="radio-inline">
                    <input id="sin_garantia" class="garantia" name="rbtnGarantia" type="radio" value="sin_garantia" tabindex="2" >Sin garantía                
                </label>

                <!--                <label>Tipo de Garantía</label>-->
                <!--                <ul class="buttons">
                                    <li><input required id="garantia_fabrica"   name="rbtnGarantia" type="radio" value="garantia_fabrica" tabindex="1" onclick="cerrar()" > <span></span>
                                        <label for="garantia_fabrica" id="r1">Garantía de fábrica</label>
                                        <input required id="garantia_vendedor"  name="rbtnGarantia" type="radio" value="garantia_vendedor" tabindex="2" onclick="cerrar()" > 
                                        <span></span> <label for="garantia_vendedor" id="r2">Garantía del vendedor</label><br>
                                        <input required id="sin_garantia"  name="rbtnGarantia" type="radio" value="sin_garantia" tabindex="2" onclick="cerrar()" > 
                                        <span></span> <label for="sin_garantia" id="r2">Sin garantía</label><br>
                
                                    </li>
                
                                </ul>-->
            </div>
        </div><!--fin row-->

        <div class="row" id="info_imei" style="display: none">
            <hr>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 float-lt container-fluid form-group">
                <div class="col-lg-6  col-md-6 col-sm-12 col-xs-12">
                    <label>Ingresar IMEI ó Serial</label><br>
                    <label class="radio-inline">
                        <input  id="imei_vista_individual" class="vista_imei"  name="rbtnImei" type="radio" value="imei_vista_individual" tabindex="1" >Individual                     </label>
                    <label class="radio-inline">
                        <input  id="imei_vista_masiva" class="vista_imei" name="rbtnImei" type="radio" value="imei_vista_masiva" tabindex="2" >Masivo
                    </label>

                    <!--                    <ul class="buttons">
                                            <li><input required id="imei_vista_individual" class="radiobtn vista_imei"  name="rbtnImei" type="radio" value="imei_vista_individual" tabindex="1" onclick="cerrar()" > <span></span>
                                                <label for="imei_vista_individual" id="r1">Individual</label>
                                                <input required id="imei_vista_masiva" class="radiobtn vista_imei" name="rbtnImei" type="radio" value="imei_vista_masiva" tabindex="2" onclick="cerrar()" > 
                                                <span></span> <label for="imei_vista_masiva" id="r2">Masivo</label><br>
                                        </ul>-->
                </div>
                <div class="col-lg-6  col-md-6 col-sm-12 col-xs-12 float-rt">
                    <!--                    <button class="btn btn-info" onclick="probar()">Importar seriales</button>-->
                </div>
            </div>

            <div id="imei_individual" style="display: none" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>IMEI(Serial)</label>
                <input type="text" class="form-control" id="txt_imei_individual">
            </div>
            <div id="imei_masivo" style="display: none" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Listado de IMEI(Serial)</label>
                <textarea type="text" class="form-control" id="txt_imei_masivo"></textarea>
            </div>
            <!--            <div id="imei_importado" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <textarea type="text" class="form-control" id="txt_imei_importado"></textarea>
                        </div>-->
        </div><br><br>

        <div class="row ">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 justify-content-center">
                <input type="submit" class="btn btn-info" value="Crear Producto(s)">
            </div>
        </div>

    </form>

</div><!--fin col 12-->


<!--<input name="product_img1" id="product_img1" type="file" class="form-control" >-->

<!--<div class="panel-body">
    <input type="hidden" id="id_usuario" value="<?php echo $userinfo->id_usuario ?>">
    <div class="form-group">form group
        <label class="col-md-3 control-label">Nombre de Producto</label>
        <div class="col-md-6">
            <input name="product_tittle" id="product_tittle" type="text" class="form-control" >
        </div>
    </div>fin form group

    <div class="form-group">form group
        <label class="col-md-3 control-label">Categoría</label>
        <div class="col-md-6">
            <select name="product_cat" id="product_cat" class="form-control">select categoria
                <option selected disabled>Seleccione Categoría</option>
<?php while ($cat = $categorias->fetch_assoc()) { ?>
                                                                                                                                                                                                                                                                                                                        <option value="<?php echo $cat["id"] ?>"><?php echo $cat["nombre"] ?></option>
<?php }
?>
            </select>fin select categoria
        </div>
    </div>fin form group

    <div class="form-group">form group
        <label class="col-md-3 control-label">Sub Categoría</label>
        <div class="col-md-6">
            <select name="product_sub_cat" id="product_sub_cat" class="form-control">select categoria
                <option>Seleccione Subcategoría</option>
            </select>fin select categoria
        </div>
    </div>fin form group

    <div class="form-group">form group
        <label class="col-md-3 control-label">Imagen de Producto N°1</label>
        <div class="col-md-6">
            <input name="product_img1" id="product_img1" type="file" class="form-control" >
        </div>
    </div>fin form group
    <div class="form-group">form group
        <label class="col-md-3 control-label">Imagen de Producto N°2</label>
        <div class="col-md-6">
            <input name="product_img2" id="product_img2" type="file" class="form-control" >
        </div>
    </div>fin form group
    <div class="form-group">form group
        <label class="col-md-3 control-label">Imagen de Producto N°3</label>
        <div class="col-md-6">
            <input name="product_img3" id="product_img3" type="file" class="form-control" >
        </div>
    </div>fin form group

    <div class="form-group">form group
        <label class="col-md-3 control-label">Precio</label>
        <div class="col-md-6">
            <input name="product_price" id="product_price" type="text" class="form-control" >
        </div>
    </div>fin form group


    <div class="form-group">form group
        <label class="col-md-3 control-label">Palabra Clave</label>
        <div class="col-md-6">
            <input name="product_keyword" id="product_keyword" type="text" class="form-control" >
        </div>
    </div>fin form group

    <div class="form-group">form group
        <label class="col-md-3 control-label">Descripción</label>
        <div class="col-md-6">
            <textarea name="product_desc" id="product_desc" cols="19" rows="6" class="form-control" id="mytextarea"></textarea>
        </div>
    </div>fin form group

    <div class="form-group">form group
        <label class="col-md-3 control-label"></label>
        <div class="col-md-6">
            <input name="submit" value="Crear Producto" type="submit" class="btn btn-primary form-control">
        </div>
    </div>fin form group

    <div id="resultado">1</div>
</div>

</div>fin col lg 12-->



