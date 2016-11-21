<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="bootstrap/css/micss.css">
        <title>EyesWideOpenCRM</title>
    </head>
    <body>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/miJavascript.js"></script>
        <div class="container">
            <br>
            <div class="row">
                <div class="col-lg-1 col-lg-offset-10">
                    <img src="bootstrap/img/corphone.png" height="80" width="190"/>
                </div>
                <div class="col-lg-12">
                    <?php echo "<a href='#'>Home</a>&nbsp;/"; ?>
                    <fieldset>
                        <legend style="color: #48722c">Importacion de Datos</legend>
                        <form style="position: absolute" class="form-inline col-lg-12" enctype="multipart/form-data" action="View/import.php" method="POST">
                            <div class="row">
                                <span class="label label-default col-lg-offset-1">Nombre de base*</span>
                                <input name="nomBase" type="text" class="form-control" placeholder="Nombre.." required="required">
                                <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                                <input name="file" type="file" id="file" class="form-control">
                                <input class="btn btn-warning form-control" id="load" type="submit" value="Cargar" name="Cargar">
                                <span class="col-lg-offset-1">
                                    <a href="Controller/download.php?file=csvEj.csv&task=Ej" style="padding-left: 3%">
                                        archivo csv de ejemplo
                                    </a>
                                </span>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <br>
                <br>
                <br>
            </div>
            <div class="row">
                <fieldset>
                    <div class="col-lg-12">
                        <h4 style="color: #48722c">Campañas</h4>
                        <div id="CampaignsList">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </body>
</html>
