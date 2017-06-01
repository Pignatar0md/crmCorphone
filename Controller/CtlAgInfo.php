<?php

include_once '../Model/m_cmp.php';
include_once 'Utils.php';
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++clic2dial
session_name('elastixSession');
session_start();

$lAgent = str_replace('Agent/', '', $_SESSION['callcenter']['agente']);

$pausa = isset($_POST['pausa']) ? $_POST['pausa'] : '';
$record = isset($_GET['grabacion']) ? $_GET['grabacion'] : '';
$campaign = isset($_GET['campaign']) ? $_GET['campaign'] : '';
if ($pausa) {
    /*try {
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
    }*/
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$idLista = isset($_GET['id_lista']) ? $_GET['id_lista'] : '';
$teL = isset($_GET['tel']) ? $_GET['tel'] : '';
//$record = isset($_GET['grabacion']) ? $_GET['grabacion'] : '';
//$campaign = isset($_GET['campaign']) ? $_GET['campaign'] : '';
//$agente = $_SESSION['callcenter']['agente'];
$nombre = $apell = $dni = $direcc = $codpostal = $tel = $telalt = $email = $idcontacto = '';
if ($idLista && $teL) {
    $arrIds[0] = "lista_" . $idLista;
    $arrIds[1] = $teL;
    $m_cmp = new m_cmp("infoBases");
    $result = $m_cmp->traerDatosClientes($arrIds);
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $nombre = $row['nombre'];
        $apell = $row['apellido'];
        $dni = $row['dni'];
        $direcc = $row['direccion'];
        $codpostal = $row['codpostal'];
        $tel = $row['tel'];
        $telalt = $row['tel_alt'];
        $email = $row['email'];
        $idcontacto = $row['id'];
    }
    $m_cmp = NULL;
}
$guardar = isset($_POST['guardar']) ? $_POST['guardar'] : '';
if ($guardar) {
    $VecDatos = array();
    $m_cmp = new m_cmp("infoBases");
    $venta = isset($_POST['checkVta']) ? $_POST['checkVta'] : '';
    $boolcontacto = isset($_POST['Contacto']) ? $_POST['Contacto'] : '';
    $resulcontacto = isset($_POST['resulContacto']) ? $_POST['resulContacto'] : '';
    $fecha = isset($_POST['txtFecha2']) ? trim($_POST['txtFecha2']) : '';
    $hora = isset($_POST['txtHora2']) ? trim($_POST['txtHora2']) : '';
    $coment = isset($_POST['coment']) ? trim($_POST['coment']) : '';
    $idLista = isset($_POST['list_id']) ? $_POST['list_id'] : '';
    $idcontac = isset($_POST['idc']) ? $_POST['idc'] : '';
    $record = isset($_POST['grabacion']) ? $_POST['grabacion'] : '';
    $campaign = isset($_POST['campaign']) ? $_POST['campaign'] : '';
    $record = substr($record, 38);
    $record = substr($record, 0, -4);
    $dateForDb = date('Y-m-d');
    $fecha = invertirFecha($fecha);
    if ($idcontac && $idLista && $campaign) {
        $VecDatos[0] = $idcontac;
        $VecDatos[1] = $idLista;
        $VecDatos[2] = $coment;
        $VecDatos[3] = $venta;
        $VecDatos[4] = $boolcontacto;
        $VecDatos[5] = $resulcontacto;
        $VecDatos[6] = $fecha;
        $VecDatos[7] = $hora;
        $VecDatos[8] = $campaign;
	$VecDatos[9] = 'grabaciones/'.$dateForDb.$record;
//	$VecDatos[9] = 'grabaciones/'.$record;
	$VecDatos[10] = $lAgent;
	if ($boolcontacto && $resulcontacto == 'acepta') {
            $vta = 1;
        }
      	$resu=  $m_cmp->insertTLogContact($VecDatos);
	if ($vta == 1) {
            $res = $m_cmp->insertVenta($VecDatos,0);
        }
	echo $resu;
    }
}
$actualizar = isset($_POST['actualizar']) ? $_POST['actualizar'] : '';
if ($actualizar) {
    $m_cmp = new m_cmp("infoBases");
    $idLista = isset($_POST['list_id']) ? $_POST['list_id'] : '';
    $idcontac = isset($_POST['idc']) ? $_POST['idc'] : '';
    $VecDatos[0] = $idLista;
    $VecDatos[1] = isset($_POST['tel']) ? $_POST['tel'] : '';
    $VecDatos[2] = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $VecDatos[3] = isset($_POST['apell']) ? $_POST['apell'] : '';
    $VecDatos[4] = isset($_POST['dni']) ? $_POST['dni'] : '';
    $VecDatos[5] = isset($_POST['direc']) ? $_POST['direc'] : '';
    $VecDatos[6] = isset($_POST['codpostal']) ? $_POST['codpostal'] : '';
    $VecDatos[7] = isset($_POST['telalt']) ? $_POST['telalt'] : '';
    $VecDatos[8] = isset($_POST['email']) ? $_POST['email'] : '';
    $VecDatos[9] = $idcontac;
    $result = $m_cmp->actualizarContacto($VecDatos);
}
$contacto = isset($_POST['contacto']) ? $_POST['contacto'] : '';
if ($contacto) {
    $opciones = '';
    if ($contacto == 1) {
        $opciones .= "<option value='NULL'>Seleccionar..</option>"
                . "<option value='conforme actual'>Conforme con lo actual</option>"
                . "<option value='no conforme serv. ofrec.'>No conforme serv. ofrec.</option>"
                . "<option value='linea pymes'>Linea PyMes</option>"
                . "<option value='agenda gral.'>Agenda grupal/gral.</option>"
                . "<option value='cliente personal'>Ya es cliente Personal</option>"
                . "<option value='acepta'>Acepta</option>"
                . "<option value='pendiente'>Pendiente</option>"
                . "<option value='no mas ofertas'>No mas ofertas</option>";
    } elseif ($contacto == 2) {
        $opciones .= "<option value='NULL'>Seleccionar..</option>"
                . "<option value='contestadorfax'>Contestador/Fax</option>"
                . "<option value='nocontesta'>No contesta</option>"
                . "<option value='ocupado'>Ocupado</option>"
                . "<option value='notitular'>No titular</option>";
    }
    echo $opciones;
}
