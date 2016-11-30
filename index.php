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
            <div class="modal fade" id="myModalRecycle" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Reciclado de datos</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5">
                                    Contacto
                                    <select class="form-control" id="contacto">
                                        <option value='1'>Si</option>
                                        <option value='2'>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    Resultado
                                    <select class="form-control" id="resulContacto">
                                        <option value='NULL'>Seleccionar..</option>
                                        <option value='conforme actual'>Conforme con lo actual</option>
                                        <option value='no conforme serv. ofrec.'>No conforme serv. ofrec.</option>
                                        <option value='linea pymes'>Linea PyMes</option>
                                        <option value='agenda gral.'>Agenda grupal/gral.</option>
                                        <option value='cliente personal'>Ya es cliente Personal</option>
                                        <option value='acepta'>Acepta</option>
                                        <option value='pendiente'>Pendiente</option>
                                        <option value='no mas ofertas'>No mas ofertas</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="reciclar" class="btn btn-primary" data-dismiss="modal">Reciclar</button>
                        </div>
                    </div>
                </div>
            </div>
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
