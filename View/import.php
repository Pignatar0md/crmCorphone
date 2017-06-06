<?php
include '../Controller/CtlImport.php';
//header('Content-Length: ' . strlen($gestor));
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <title>Carga de BD</title>
    </head>
    <body>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

        <div class="container">
            <br>
            <div class="row">
                <div class="col-lg-1 col-lg-offset-10">
                    <img src="../bootstrap/img/LogoFTS.png" height="80" width="190"/>
                </div>
                <div class="col-lg-12">
                    <?php echo "<a href='../index.php'>Home</a>&nbsp;/&nbsp;Configuracion de datos"; ?>
                    <fieldset>
                        <legend style="color: #48722c">Definir columna a discar de "<?php echo $nomBase ?>"</legend>
                    </fieldset>
                </div>
            </div>
            <br>
            <form method="POST" action="SuccessFail.php">
                <input type="hidden" name="nomBase" value="<?php echo $nomBase ?>"/>
                <input type="hidden" name="cdadFilas" value="<?php echo $cdadFilas ?>"/>
                <input type="hidden" name="cdadColum" value="<?php echo $cdadColum ?>"/>
                <div class="row">
                    <div class="col-lg-12">
                        <h4 style="color: #48722c">Encabezados de columnas de .csv</h4>
                        <?php
                        showHeaders($linea_texto, $explode_valores);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1 col-lg-offset-11">
                        <button type="submit" class="btn btn-warning" name="guardar" value="Guardar">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
