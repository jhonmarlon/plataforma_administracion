<style type="text/css">
    .btn-success{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #3e6b2f), color-stop(1, #09bb58) );
        color: white;
        width: 150px;
        height: 32px;    }

    .btn-success:hover{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #408163), color-stop(1, #18a11f) );
    }

    .btn-danger{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #841b1b), color-stop(1, #ff2020) );
        color: white;
        width: 150px;
        height: 32px;
        border-color: #d73925;
    }
    .btn-danger:hover{
        background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8f0b0b), color-stop(1, #8f5151) );
        border-color: #861709;
    }

input[type=text], input[type=email], input[type=search], input[type=password],textArea {
    -webkit-appearance: none;
    padding: 5px;
    font-size: 15px;
    text-shadow: 0px 1px 0px white;
    outline: none;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    border: 1px solid white;
    box-shadow: 0 -3px 4px 0px #858585, inset 0 10px 10px 1px #CFCFCF;
    border-bottom: solid 1px #AAA;
    border-left: solid 1px #AAA;
    border-right: solid 1px #AAA;
    margin: 5px;
    /* max-width: 100%; */
    width: 100%;
    -moz-appearance: none;
}


</style>

<?php
$conn = new conexion();
$query = "SELECT correo FROM usuario where id_usuario='$userinfo->user_id'";
$mail = $conn->conexion->query($query);
?>
<div class="row">
    <!-- /.col -->
    <div class="col-md-12 col-md-offset-0">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Crear una sugerencia</h3>
            </div>
            <!-- /.box-header -->
            <form  method="post" action="pages/backend/enviarsugerencia.php">
                <div class="box-body">
                    <div class="form-group">

                        <!--  Elementos ocualtos  -->
                        <input  class="form-control" name="correo" id="correo" type="hidden" value="<?php
                        while ($row = $mail->fetch_array(MYSQLI_NUM)) {
                            echo $row [0];
                        }
                        ?>" >
                        <input  class="form-control" name="nombre" type="hidden" id="nombre" value="<?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="encabezado" type="text" name="encabezado" required placeholder="Encabezado:">
                    </div>
                    <div class="form-group">
                        <textarea id="compose-textarea" id="mensaje" name="mensaje" required class="form-control"  style="height: 300px">

                        </textarea>
                    </div>
                </div>


                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">

                    </div>
                    <button type="submit" class="btn btn-success"><i class="fa fa-envelope-o"></i> Enviar</button>

                    <a href="index.php"><button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</button></a>
                </div>
                <!-- /.box-footer -->

            </form>

        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>

<script src="plugins/iCheck/icheck.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Page Script -->
<script>
    $(function () {
        //Add text editor
        $("#compose-textarea").wysihtml5();
    });
</script>
