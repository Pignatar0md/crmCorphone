<?php
include_once '../Model/m_cmp.php';
include 'Utils.php';
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++clic2dial
session_name('elastixSession');
session_start();
require(ECCP);
$lAgent = str_replace('Agent/', '', $_SESSION['callcenter']['agente']);
$oECCP = new ECCP();
$pausa = isset($_POST['pausa']) ? $_POST['pausa'] : '';
$record = isset($_GET['grabacion']) ? $_GET['grabacion'] : '';
$campaign = isset($_GET['campaign']) ? $_GET['campaign'] : '';
if ($pausa) {
    try {
        $oConexion = $oECCP->connect('localhost', 'agentconsole', 'agentconsole');
        if (isset($oConexion->failure))
            die('Failed to connect to ECCP - ' . $oConexion->failure->message . "\n");
        $oECCP->setAgentNumber('Agent/' . $lAgent);
        $oECCP->setAgentPass($lAgent);
        $oResultado = $oECCP->pauseagent(3);
        $oECCP->disconnect();
    } catch (Exception $e) {
        print_r($e);
        print_r($oECCP->getParseError());
    }
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$editar = isset($_POST['editar']) ? $_POST['editar'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : 0;
$camp = isset($_POST['lstcamp']) ? $_POST['lstcamp'] : 0;
$tel = $nom = $apell = $dni = $direc = $cp = $telalt = $email = '';
$resulcontacto = $fechanota = $horanota = $coment = $contacto = '';
if ($editar) {
    $m_cmp = new m_cmp('infoBases');
    $arrConClaves [0] = $camp;
    $arrConClaves [1] = $id;
    $resultado = $m_cmp->getLeadEdit($arrConClaves);
    $content = '';
    while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) {
        $content .= "<legend style='color: #48722c'>Datos de Cliente</legend>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label for='cuit'>Nombre</label>
                                                        <input type='text' id='nomm' class='form-control input-sm' value='" . $row['nombre'] . "'>
                                                        <input type='hidden' value='".$row['id_lista']."' id='idl'>
                                                        <input type='hidden' value='".$row['id_reg_lista']."' id='idc'>
                                                    </div>
                                                    <div class='col-md-3'>    
                                                        <label for='cuit'>Apellido</label>
                                                        <input type='text' id='apell' class='form-control input-sm' value='" . $row['apellido'] . "'>
                                                    </div>
                                                    <div class='col-md-2'>
                                                        <label for='cuit'>Dni</label>
                                                        <input type='text' id='dni' class='form-control input-sm' value='" . $row['dni'] . "'>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <label for='cuit'>Direccion</label>
                                                        <input type='text' id='direc' class='form-control input-sm' value='" . $row['direccion'] . "'>
                                                    </div>
                                                    <div class='col-md-2'>
                                                        <label for='cuit'>C.P.</label>
                                                        <input type='text' id='codpostal' class='form-control input-sm' value='" . $row['codpostal'] . "'>
                                                    </div>
                                                    <div class='col-md-2'>
                                                        <label for='cuit'>Tel</label>
                                                        <input type='text' id='tell' class='form-control input-sm' value='" . $row['tel'] . "'>
                                                    </div>
                                                    <div class='col-md-2'>
                                                        <label for='cuit'>Tel.Alt.</label>
                                                        <input type='text' id='telalt' class='form-control input-sm' value='" . $row['tel_alt'] . "'>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <label for='cuit'>E-mail</label>
                                                        <input type='text' id='email' class='form-control input-sm' value='" . $row['email'] . "'>
                                                    </div>
                                                </div>
                                                <br>
                                                <legend style='color: #48722c'>Notas de la Llamada</legend>
                                                <div class='row'>
                                                <div class='col-lg-2'>
                                <label for='cuit'>Contacto</label>
                                <select name='Contacto' class='form-control' id='contacto'>";
        $opcionQuitar = '';
        switch ($row['contacto']) {
            case 1:
                $content .= "<option value='1'>Si</option>";
                $opcionQuitar = 1;
                break;
            case 0:
                $content .= "<option value='2'>No</option>";
                $opcionQuitar = 0;
                break;
        }
        $Opciones[0] = "<option value='2'>No</option>";
        $Opciones[1] = "<option value='1'>Si</option>";
        $mostrarOpcs = quitarOpc($opcionQuitar, $Opciones);
        foreach ($mostrarOpcs as $op) {
            $content .= $op;
        }
        $content .= "</select>
                            </div>
                                                    <div class='col-lg-3'>
                                                        <label for='cuit'>Resultado Contacto</label>
                                                        <select name='resulContacto' id='resulcontacto' class='form-control'>";
        switch ($row['resul_contacto']) {
            case 'conforme actual':
                $content .= "<option value='conforme actual'>Conforme con lo actual</option>";
                $opcionQuitar = 0;
                break;
            case 'no conforme serv. ofrec.':
                $content .= "<option value='no conforme serv. ofrec.'>No conforme serv. ofrec.</option>";
                $opcionQuitar = 1;
                break;
            case 'linea pymes':
                $content .= "<option value='linea pymes'>Linea PyMes</option>";
                $opcionQuitar = 2;
                break;
            case 'agenda gral.':
                $content .= "<option value='agenda gral.'>Agenda grupal/gral.</option>";
                $opcionQuitar = 3;
                break;
            case 'cliente personal':
                $content .= "<option value='cliente personal'>Ya es cliente Personal</option>";
                $opcionQuitar = 4;
                break;
            case 'acepta':
                $content .= "<option value='acepta'>Acepta</option>";
                $opcionQuitar = 5;
                break;
            case 'pendiente':
                $content .= "<option value='pendiente'>Pendiente</option>";
                $opcionQuitar = 6;
                break;
            case 'no mas ofertas':
                $content .= "<option value='no mas ofertas'>No mas ofertas</option>";
                $opcionQuitar = 7;
                break;
            case 'contestadorfax':
                $content .= "<option value='contestadorfax'>Contestador/Fax</option>";
                $opcionQuitar = 8;
                break;
            case 'nocontesta':
                $content .= "<option value='nocontesta'>No contesta</option>";
                $opcionQuitar = 9;
                break;
            case 'ocupado':
                $content .= "<option value='ocupado'>Ocupado</option>";
                $opcionQuitar = 10;
                break;
            case 'notitular':
                $content .= "<option value='notitular'>No titular</option>";
                $opcionQuitar = 11;
                break;
        }
        if ($row['contacto'] == 1) {
            $Opciones[0] = "<option value='conforme actual'>Conforme con lo actual</option>";
            $Opciones[1] = "<option value='no conforme serv. ofrec.'>No conforme serv. ofrec.</option>";
            $Opciones[2] = "<option value='linea pymes'>Linea PyMes</option>";
            $Opciones[3] = "<option value='agenda gral.'>Agenda grupal/gral.</option>";
            $Opciones[4] = "<option value='cliente personal'>Ya es cliente Personal</option>";
            $Opciones[5] = "<option value='acepta'>Acepta</option>";
            $Opciones[6] = "<option value='pendiente'>Pendiente</option>";
            $Opciones[7] = "<option value='no mas ofertas'>No mas ofertas</option>";
            $mostrarOpcs = quitarOpc($opcionQuitar, $Opciones);
        } else {
            $Opciones[8] = "<option value='contestadorfax'>Contestador/Fax</option>";
            $Opciones[9] = "<option value='nocontesta'>No contesta</option>";
            $Opciones[10] = "<option value='ocupado'>Ocupado</option>";
            $Opciones[11] = "<option value='notitular'>No titular</option>";
            $mostrarOpcs = quitarOpc($opcionQuitar, $Opciones);
        }
        foreach ($mostrarOpcs as $op) {
            $content .= $op;
        }
        $content .= "<script type='text/javascript'>
                     $(function(){
                        $('#hora3').datetimepicker({
                            pickDate: false,
                            format: 'HH:mm'
                        });
                        $('#fecha3').datetimepicker({
                            pickTime: false
                        });
                     });
                     </script>
                                            </select>
                                                    </div>
                                                    <div class='col-lg-3'>
                                                        <label for='cuit'>Fecha</label>
                                                        <div class='input-group date' id='fecha3' data-date-format='DD/MM/YYYY'>
                                                            <input type='text' id='ctlfecha3' class='form-control' value='" . $row['fecha'] . "'/>
                                                            <span class='input-group-addon'><span class='glyphicon glyphicon-time'></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class='col-lg-2'>
                                                        <label for='cuit'>Hora</label>
                                                        <div class='input-group date'>
                                                            <input type='text' id='hora3' class='form-control' value='" . $row['hora'] . "'/>
                                                            <span class='input-group-addon'><span class='glyphicon glyphicon-time'></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <br>
                                                    <div class='col-lg-11'>
                                                        <textarea id='coment' class='form-control' rows='5' cols='10'>" . $row['comentario'] . "</textarea>
                                                    </div>
                                                </div>";
    }
    echo $content;
}
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : '';
if ($buscar) {
    $tel = trim($_POST['tel']);
    $nom = trim($_POST['nom']);
    $apel = trim($_POST['apel']);
    $resulnota = trim($_POST['resulnota']);
    $fechanota = trim($_POST['fechanota']);
    $fechanota = invertirFecha($fechanota);
    $ncamp = $_POST['nrocamp'];
    $m_cmp = new m_cmp('infoBases');
    $DatosBusq[0] = $tel;
    $DatosBusq[1] = $nom;
    $DatosBusq[2] = $apel;
    $DatosBusq[3] = $fechanota;
    $DatosBusq[4] = $resulnota;
    $DatosBusq[5] = $ncamp;
    $DatosBusq[6] = $lAgent;
//    $DatosBusq[6] = '912';
    if ($DatosBusq[4] == 'null') {
        $resultado = $m_cmp->getLeadNoProc($DatosBusq);
        $data = "<thead>
                                    <tr class='success'>
                                        <td>
                                            Nombre
                                        </td>
                                        <td>
                                            Apellido
                                        </td>
                                        <td>
                                            DNI
                                        </td>
                                        <td>
                                            Tel
                                        </td>
                                        <td>
                                            Tel.Alt
                                        </td>
                                        <td>
                                            Domicilio
                                        </td>
                                        <td>
                                            Cod. Postal
                                        </td>
                                        <td>
                                            E-Mail
                                        </td>
                                        <td>
                                        <b>Acciones</b>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody id='LeadsList'>";
        $h = 0;
        while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) {
            $rta = "";
            if ($h % 2 == 0) {
                $data .= "<tr>";
            } else {
                $data .= "<tr class='active'>";
            }
            $data .= "<td>" .
                    $row['nombre'] .
                    "</td><td>" .
                    $row['apellido'] .
                    "</td><td>" .
                    $row['dni'] .
                    "</td><td>" .
                    $row['tel'] .
                    "</td><td>" .
                    $row['tel_alt'] .
                    "</td><td>" .
                    $row['direccion'] .
                    "</td><td>" .
                    $row['codpostal'] .
                    "</td><td>" .
                    $row['email'] .
                    "</td><td>" .
                    "&nbsp;&nbsp;<button title='Llamada Manual' type='button' class='btn btn-warning btn-xs'><img src='../bootstrap/img/DialPhone2.png' class='llammanual' height='32' width='30'/>" .
                    "</td>" .
                    "</tr>";
        }
    } else {
        $resultado = $m_cmp->getLead($DatosBusq);
        $data = "<thead>
                                    <tr class='success'>
                                        <td>
                                            <b>Nombre
                                        </td>
                                        <td>
                                            <b>Apellido
                                        </td>
                                        <td>
                                            <b>DNI
                                        </td>
                                        <td>
                                            <b>Tel
                                        </td>
                                        <td>
                                            <b>Tel.Alt
                                        </td>
                                        <td>
                                            <b>E-Mail
                                        </td>
                                        <td>
                                            <b>Contacto
                                        </td>
                                        <td>
                                            <b>Resultado/
                                        </td>
                                        <td>
                                            <b>Fecha/
                                        </td>
                                        <td>
                                            <b>Hora De Nota
                                        </td>
                                        <td>
                                            <b>Acciones</b>
                                        </td>
                                    </tr>
                                </thead><tbody id='LeadsList'>";
        $h = 0;
        while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) {
            $rta = '';
            if ($row['contacto'] == 1) {
                $rta = 'Si';
            } else {
                $rta = 'No';
            }
            if ($h % 2 == 0) {
                $data .= "<tr>";
            } else {
                $data .= "<tr class='active'>";
            }
            $data .= "<td>" .
                    $row['nombre'] .
                    "</td><td>" .
                    $row['apellido'] .
                    "</td><td>" .
                    $row['dni'] .
                    "</td><td>" .
                    $row['tel'] .
                    "</td><td>" .
                    $row['tel_alt'] .
                    "</td><td>" .
                    $row['email'] .
                    "</td><td>" .
                    $rta .
                    "</td><td>" .
                    $row['resul_contacto'] .
                    "</td><td>" .
                    fechaPataArriba($row['fecha']) .
                    "</td><td>" .
                    $row['hora'] .
                    "</td>" .
                    "<td>" .
                    "<button title='Editar' type='button' class='btn btn-success btn-xs'><img src='../bootstrap/img/edit3.gif' class='editar' alt='edit' width='30' height='32'/>" .
                    "<input type='hidden' id='valorRegistroLista' value='" . $row['id_reg_lista'] . "'/>" .
                    "<input type='hidden' id='valorLista' value='" . $row['id_lista'] . "'/></button>" .
                    "&nbsp;&nbsp;<button title='Llamada Manual' type='button' class='btn btn-warning btn-xs'><img src='../bootstrap/img/DialPhone2.png' class='llammanual' height='32' width='30'/>" .
                    "</td>" .
                    "</tr>";
            $h++;
        }
    }
    $data .= "</tbody>";
    echo $data;
}
$updinfoC = isset($_POST['updateinfocontact']) ? $_POST['updateinfocontact'] : '';
if ($updinfoC) {
    $VecDatos = array();
    $m_cmp = new m_cmp("infoBases");
    $idcontac = isset($_POST['idc']) ? $_POST['idc'] : '';
    $venta = isset($_POST['checkVta']) ? $_POST['checkVta'] : '';
    $boolcontacto = isset($_POST['Contacto']) ? $_POST['Contacto'] : '';
    $resulcontacto = isset($_POST['resulContacto']) ? $_POST['resulContacto'] : '';
    $fecha = isset($_POST['txtFecha2']) ? trim($_POST['txtFecha2']) : '';
    $hora = isset($_POST['txtHora2']) ? trim($_POST['txtHora2']) : '';
    $coment = isset($_POST['coment']) ? trim($_POST['coment']) : '';
    $fecha = invertirFecha($fecha);
    if ($idcontac) {
        $VecDatos[6] = $idcontac;
        $VecDatos[1] = $venta;
        $VecDatos[2] = $boolcontacto;
        $VecDatos[3] = $resulcontacto;
        $VecDatos[4] = $fecha;
        $VecDatos[5] = $hora;
        $VecDatos[0] = $coment;
        $res = $m_cmp->updateTLogContact($VecDatos);
    }
    return $res;
}
function getCamps() {
    $m_cmp = new m_cmp('infoBases');
    $resultado = $m_cmp->getTables();
  //  $i = 1;
    while ($row = mysql_fetch_array($resultado, MYSQL_NUM)) {
        echo "<option value='$row[0]'>" . $row[0] . "</option>";
//        $i++;
    }
}

function quitarOpc($opc, $opcs) {
    unset($opcs[$opc]);
    return $opcs;
}
