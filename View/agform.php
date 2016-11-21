<?php
include_once '../Controller/CtlAgInfo.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css">
        <title>OpenEyesCRM</title>
    </head>
    <body>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../bootstrap/moment-develop/min/moment.min.js"></script>
        <script type="text/javascript" src="../bootstrap/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="../bootstrap/js/jsAgentForm.js"></script>
        <div class="container">
            <div class="row">
                <br>
                <div class="col-md-1 col-md-offset-9">
                    <img src="../bootstrap/img/corphone.png" height="80" width="190"/>
                </div>
            </div>
            <form>
                <div class="row">
                    <div class="col-lg-12">
                        <fieldset>
                            <legend style="color: #48722c">Datos de Cliente</legend>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div id="modalSave" class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <h5 style="text-align: center; color: #337ab7">Contacto Guardado Existosamente</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-md-2">
                                <input type="hidden" value="<?php echo $idcontacto ?>" id="idc" name="id">
                                <input type="hidden" value="<?php echo $idLista ?>" id="idlista" name="idlista">
				<input type="hidden" value="<?php echo $record ?>" id="grabac" name="grabac">
                                <input type="hidden" value="<?php echo $campaign ?>" id="camp" name="camp">
                                <label for="cuit">Nombre</label>
                                <input type="text" id="nom" name="nom" class="form-control input-sm" value="<?php echo $nombre ?>" placeholder="Nombre">
                            </div>
                            <div class="col-md-3">
                                <label for="cuit">Apellido</label>
                                <input type="text" name="apell" class="form-control input-sm" value="<?php echo $apell ?>" placeholder="Apellido" id="apell">
                            </div>
                            <div class="col-md-2">
                                <label for="cuit">Dni</label>
                                <input type="text" name="dni" class="form-control input-sm" value="<?php echo $dni ?>" placeholder="D.N.I." id="dni">
                            </div>
                            <div class="col-md-3">
                                <label for="cuit">Direccion</label>
                                <input type="text" name="direc" class="form-control input-sm" value="<?php echo $direcc ?>" placeholder="direccion" id="direc">
                            </div>
                            <div class="col-md-2">
                                <br>
                                <a href="searchlead.php">Buscar Contacto..</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-md-1">
                                <label for="cuit">Cod.Postal</label>
                                <input type="text" name="codpostal" class="form-control input-sm" value="<?php echo $codpostal ?>" placeholder="cp" id="codpostal">
                            </div>
                            <div class="col-md-2">
                                <label for="cuit">Telefono</label>
                                <input type="text" name="tel" class="form-control input-sm" value="<?php echo $tel ?>" placeholder="Telefono" id="tel">
                            </div>
                            <div class="col-md-2">
                                <label for="cuit">Tel. Alternativo</label>
                                <input type="text" name="telalt" class="form-control input-sm" value="<?php echo $telalt ?>" placeholder="tel. alternativo" id="telalt">
                            </div>
                            <div class="col-md-3">
                                <label for="cuit">E-mail</label>
                                <input type="text" name="email" class="form-control input-sm" value="<?php echo $email ?>" placeholder="johndoe@gmail.com" id="email">
                            </div>
		 	    <div class="col-md-1">
                                <br>
                                <label for="cuit">Lista: <em style="color: red"><?php if($idLista=='{id_lista}') { echo 'manual'; } else { echo $idLista; } ?></em></label>
                            </div> 
                            <div class="col-lg-1 col-lg-offset-1">
                                <br>
                                <button type="button" class="btn btn-warning btn-xs"><img id="manualcall" src="../bootstrap/img/DialPhone2.png" height="32" width="30"/></button>
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
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <fieldset>
                            <legend style="color: #48722c">Notas de la Llamada</legend>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="cuit">Contacto</label>
                                <select name='Contacto' class='form-control' id="contacto">
                                    <option value='1'>Si</option>
                                    <option value='2'>No</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cuit">Resultado Contacto</label>
                                <select name='resulContacto' id='resulContacto' class='form-control'>
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
                            <div class="col-md-2">
                                <label for="cuit">Fecha</label>
                                <!--<div class="controls">-->
                                <div class='input-group date' id='fecha2' data-date-format='DD/MM/YYYY'>
                                    <input type='text' id='ctlfecha2' class='form-control' name='txtFecha2'/>
                                    <span class='input-group-addon'><span class='glyphicon glyphicon-time'></span>
                                    </span>
                                </div>
                                <!--</div>-->
                            </div>
                            <div class="col-md-2">
                                <label for="cuit">Hora</label>
                                <!--<div class="controls">-->
                                <div class='input-group date'>
                                    <input type='text' id='hora2' class="form-control" name="txtHora2" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                                <!--</div>-->
                            </div>
                            <div class="col-md-1">
                                <br>
                                <button type="button" id="save" class="btn btn-warning" name="guardar" value="Guardar">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-md-10">
                                <textarea name="coment" id="coment" class="form-control" rows="5" cols="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
