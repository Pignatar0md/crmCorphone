<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
include '../Controller/CtlSave.php';
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
                    <?php echo "<a href='../index.php'>Home</a>&nbsp;/&nbsp;Carga de Csv"; ?>
                    <fieldset>
                        <legend style="color: #48722c">Resultado de Carga de Csv para Campaña</legend>
                    </fieldset>
                </div>
            </div>
            <br>
            <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">
                        <?php echo $Msg ?>
                    </div>
            </div>
        </div>
    </body>
</html>
