<?php

require('../config.php');
session_name('elastixSession');
session_start();

require(AMI);
require(ECCP);

$oAGIAsteriskManager = new AGI_AsteriskManager();
$oECCP = new ECCP();

$oConexion = mysql_connect(MySQL_HOST, MySQL_USER, MySQL_PASS) or die('DB Connection Error');

mysql_select_db('call_center', $oConexion) or die(mysqlerror() . ' - Error: Cannot open database');
$sSQL = sprintf('SELECT name FROM agent WHERE number = %d', $_GET['agent']);
$oResultados = mysql_query($sSQL, $oResultados);
$aRegistro = mysql_fetch_array($oResultados, MYSQL_ASSOC);
mysql_free_result($oResultados);
$sAgentName = $aRegistro['name'];
mysql_close($oResultados);
$oResultado = $oAGIAsteriskManager->connect(AMI_IP, AMI_USER, AMI_PASS);
if ($oResultado == FALSE)
    echo "Connection failed.\n";
elseif ($oResultado == TRUE) {
    $aResponse = $oAGIAsteriskManager->Originate(
            'Local/9' . $_GET['agent'] . '@ext-queues', $_GET['number'], 'from-internal', '1', NULL, NULL, '25000', $_GET['number'], NULL, NULL, NULL, 'false', NULL
    );
    if ($aResponse['Response'] == 'Success') {
        try {
            print "Connect...\n";
            $oConexion = $oECCP->connect('localhost', 'agentconsole', 'agentconsole');
            if (isset($oConexion->failure))
                die('Failed to connect to ECCP - ' . $oConexion->failure->message . "\n");
            $oECCP->setAgentNumber('Agent/' . $_GET['agent']);
            $oECCP->setAgentPass($_GET['agent']);
            print_r($oECCP->getAgentStatus());
            print "Saliendo de pausa...\n";
            $oResultado = $oECCP->unpauseagent();
            print_r($oResultado);
            sleep(3);
            $oResultado = $oECCP->pauseagent(3);
            print "Disconnect...\n";
            $oECCP->disconnect();
        } catch (Exception $e) {
            print_r($e);
            print_r($oECCP->getParseError());
        }
    }
}
