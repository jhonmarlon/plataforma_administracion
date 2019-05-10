<?php
require '../modelo/conexion.php';

$conn = new conexion();
//si existe un id de categoria de producto para llenar select de subcategoria

if (isset($_POST["id_categoria_crea_sub"])) {
    $id_categoria_crea_sub = $_POST["id_categoria_crea_sub"];
    $sub_categorias = $conn->ejecutar_consulta_simple("SELECT * FROM sub_categorias_producto WHERE id_categoria='" . $id_categoria_crea_sub . "'");
    ?>
    <option value="0" disabled selected>Seleccione Subcategoría</option>

    <?php
    if (mysqli_num_rows($sub_categorias) != 0) {
        while ($sub = $sub_categorias->fetch_assoc()) {
            ?>
            <option value="<?php echo $sub["id"] ?>"><?php echo $sub["nombre"] ?></option>
            <?php
        }
    } else {
        echo "Sin Subcategorías";
    }
}


//CREACION DE PRODUCTOS
//FILTROS

if (isset($_POST["tipo"])) {

    if ($_POST["tipo"] == "producto") {

        if (isset($_POST["id_categoria"])) {
            //tomamos el id de la categoria
            $id_categoria = $_POST["id_categoria"];
            //tomamos las subcategorias rrlacionadas a la categoria
            $subcategorias = $conn->getSubCategorias($id_categoria);

            if (mysqli_num_rows($subcategorias) == 0) {
                return false;
                ?>
            <?php } else if (isset($_POST["tipo_select"])) {
                ?>
                <option selected disabled>Seleccione una subcategoría</option>
                <?php while ($subCat = $subcategorias->fetch_assoc()) {
                    ?>
                    <option class="select_subcategoria_mdl" id="subCategoria_<?php echo $subCat["id"] ?>"><?php echo $subCat["nombre"] ?></option>
                    <?php
                }
            } else {
                $aux;
                while ($subCat = $subcategorias->fetch_assoc()) {
                    ?>
                    <li class="filtros" id="subCategoria_<?php echo $subCat["id"] ?>"><a href="#" class="sub_categoria_producto" id="<?php echo $subCat["id"] ?>"><?php echo $subCat["nombre"] ?></a></li>

                    <?php
                }
            }
        }

        if (isset($_POST["id_subcategoria"])) {
            //tomamos el id de la subcategoria
            $id_subcategoria = $_POST["id_subcategoria"];
            //tomamos los elementos relacionados a la subcategoria
            $elementos = $conn->getElementoSubCategoria($id_subcategoria);

            if (mysqli_num_rows($elementos) == 0) {
                return false;
                ?>
                <?php
            } else {
                while ($ele = $elementos->fetch_assoc()) {
                    ?>


                    <li class="filtros" id="elemento_<?php echo $ele["id"] ?>"><a href="#" class="elemento_sub_categoria" id="<?php echo $ele["id"] ?>"><?php echo $ele["nombre"] ?></a></li>

                    <?php
                }
            }
        }

        if (isset($_POST["array_filtros"])) {
            //enviamos elemento a la tabla temporal
        }
    }
}

if (isset($_POST["tipo_creado"])) {
    if ($_POST["tipo_creado"] == "subcategoria") {

        $id_categoria = $_POST["id_categoria"];
        $nombre_subcategoria = $_POST["nombre_subcategoria"];
        $descripcion = $_POST["descripcion"];

        //guardamos la nueva subcategoria en la bd
        $conn->ejecutar_consulta_simple("INSERT INTO sub_categorias_producto (nombre, descripcion,id_categoria,estado) VALUES "
                . "('$nombre_subcategoria','$descripcion','$id_categoria','A')");
    }
}
?>

