<?php

include_once '/var/www/html/cargadebases/Model/m_cmp.php';
include_once 'Utils.php';
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++clic2dial
session_name('elastixSession');
session_start();
require(ECCP);
$lAgent = str_replace('Agent/', '', $_SESSION['callcenter']['agente']);
$oECCP = new ECCP();
$pausa = isset($_POST['pausa']) ? $_POST['pausa'] : ''; 
if($pausa) {
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
$agente = isset($_SESSION['callcenter']['agente']) ? $_SESSION['callcenter']['agente'] : 'agenteX';
$nombre = $apell = $dni = $direcc = $codpostal = $tel = $telalt = $email = $idcontacto = '';
$guardar = isset($_POST['guardar']) ? $_POST['guardar'] : '';
$grab = '16';
if ($guardar) {
    $m_cmp = new m_cmp("infoBases");
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apell = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
    $dni = isset($_POST['dni']) ? trim($_POST['dni']) : '';
    $direcc = isset($_POST['direc']) ? trim($_POST['direc']) : '';
    $codpostal = isset($_POST['codpostal']) ? trim($_POST['codpostal']) : '';
    $tel = isset($_POST['tel']) ? trim($_POST['tel']) : '';
    $telalt = isset($_POST['telalt']) ? trim($_POST['telalt']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $fechanac = isset($_POST['fecnac']) ? trim($_POST['fecnac']) : '';
    $hora = isset($_POST['hora']) ? trim($_POST['hora']) : '';
    $resulcontacto = isset($_POST['resulcontacto']) ? $_POST['resulcontacto'] : '';
    $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';
    $boolcontacto = isset($_POST['contac']) ? $_POST['contac'] : 0;
    $coment = isset($_POST['coment']) ? trim($_POST['coment']) : '';
    $vta = 0;
    $fecha = invertirFecha($fecha);
    if ($boolcontacto && $resulcontacto == 'acepta') {
        $vta = 1;
    }
    $VecDatos[0] = $nombre;
    $VecDatos[1] = $apell;
    $VecDatos[2] = $dni;
    $VecDatos[3] = $tel;
    $VecDatos[4] = $telalt;
    $VecDatos[5] = $direcc;
    $VecDatos[6] = $email;
    $VecDatos[7] = $codpostal;
    $VecDatos[8] = $fechanac;
    $VecDatos[9] = $boolcontacto;
    $VecDatos[10] = $resulcontacto;
    $VecDatos[11] = $vta;
    $VecDatos[12] = $fecha;
    $VecDatos[13] = $hora;
    $VecDatos[14] = $coment;
    $VecDatos[15] = $agente;
    $VecDatos[16] = $grab;
    $res = $m_cmp->insertManualCall($VecDatos);
    if($vta == 1) {
        $res = $m_cmp->insertVenta($VecDatos, 1);
    }
}
