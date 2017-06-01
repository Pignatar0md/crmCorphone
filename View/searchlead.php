<?php
include_once '../Controller/CtlLeadSearch.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css">
        <title>EyesOpenCRM</title>
    </head>
    <body>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../bootstrap/moment-develop/min/moment.min.js"></script>
        <script type="text/javascript" src="../bootstrap/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/jsLeadSearch.js"></script>
        <div class="container">
            <div class="row">
                <br>
                <div class="col-lg-1 col-lg-offset-10">
                    <img src="../bootstrap/img/corphone.png" height="80" width="190"/>
                </div>
            </div>
            <form>
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo "<a href='agform.php'>Volver</a>&nbsp;/&nbsp;Busqueda De Contacto"; ?>
                        <fieldset>
                            <legend style="color: #48722c">Datos de Cliente</legend>
                        </fieldset>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="cuit">Campaña</label>
                                <select name='lstcamp' id='lstcamp' class='form-control'>
                                    <?php getCamps() ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="cuit">Nombre</label>
                                <input type="text" name="nom" class="form-control input-sm" placeholder="Nombre" id="nom">
                                <input type="hidden" value="<?php echo $lAgent ?>">
                            </div>
                            <div class="col-md-2">
                                <label for="cuit">Apellido</label>
                                <input type="text" name="apel" class="form-control input-sm" placeholder="Apellido" id="apel">
                            </div>
                            <div class="col-md-2">
                                <label for="cuit"><em style="color: red">*</em> Telefono</label>
                                <input type="text" name="tel" class="form-control input-sm" placeholder="Telefono" id="tel" required="required">
                            </div>
                            <div class="col-md-2">
                                <label for="cuit">Resultado de Nota</label>
                                <select name='resulContacto' id='resulContacto' class='form-control'>
                                    <option value='null'>Seleccionar..</option>
                                    <option value='conforme actual'>Conforme con lo actual</option>
                                    <option value='no conforme serv. ofrec.'>No conforme serv. ofrec.</option>
                                    <option value='linea pymes'>Linea PyMes</option>
                                    <option value='agenda gral.'>Agenda grupal/gral.</option>
                                    <option value='cliente personal'>Ya es cliente Personal</option>
                                    <option value='acepta'>Acepta</option>
                                    <option value='pendiente'>Pendiente</option>
                                    <option value='no mas ofertas'>No mas ofertas</option>
                                    <option value='contestadorfax'>Contestador/Fax</option>
                                    <option value='nocontesta'>No contesta</option>
                                    <option value='ocupado'>Ocupado</option>
                                    <option value='notitular'>No titular</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="cuit">Fecha de Nota</label>
                                <!--<div class="controls">-->
                                <div class='input-group date' id='fecha2' data-date-format="DD/MM/YYYY">
                                    <input type='text' id="fechanota" class="form-control"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                                <!--</div>-->
                            </div>
                            <div class="col-lg-1 col-lg-offset-11">
                                <br>
                                <button type="button" id="search" class="btn btn-warning" name="buscar" value="Buscar">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <br>
                    <fieldset>
                        <div class="col-lg-12" id="edit">
                            <h4 style="color: #48722c">Contactos</h4>
                            <table class='table table-stripped' id='manualcall'>
                                <div id="modalCallm" class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Llamada Manual</h4>
                                            </div>
                                            <input type="hidden" id="agent" name="agent" value="<?php echo $lAgent; ?>" />
                                            <p>
                                                <br>
                                                &nbsp;&nbsp;&nbsp;<input class="input-sm" type="text" id="number" name="number" />
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-sm btn-success" id="Call">Discar</button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="modalFormEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Editar Contacto</h4>
                                            </div>
                                            <div class="modal-body" id='modaledit'>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' id='save' class='btn btn-warning' name='guardar' value='Guardar'>Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id='modalSave' class='modal fade bs-modal-sm' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog modal-sm'>
                                        <div class='modal-content'>
                                            <h5 style='text-align: center; color: #337ab7'>Contacto Guardado Existosamente</h5>
                                        </div>
                                    </div>
                                </div>
                            </table>
                            <hr>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>
    </body>
</html>
