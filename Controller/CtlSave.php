<?php
session_name('elastixSession');
session_start();
if (!isset($_SESSION['elastix_user'])) {
    //   header('Location: ../index.php');
}
include_once '../Model/m_cmp.php';
$nomTabla = isset($_POST['nomBase']) ? $_POST['nomBase'] : '';
$save = isset($_POST['Guardar']) ? $_POST['Guardar'] : '';
$cdadCamposBD = (count($_POST) - 6) / 2;
$a = 1;
$Suc0fail = FALSE;
$Msg = '';
$TipoDatoParaBase = $CampoParaBase = array();
do {
    $CampoParaBase[] = $_POST["nomcol$a"];
    $TipoDatoParaBase[] = $_POST["tipoDato$a"];
    $a++;
}while ($a <= $cdadCamposBD+1);
$cdadFilas = isset($_POST['cdadFilas']) ? $_POST['cdadFilas'] : '';
$campoTel = isset($_POST['campoTel']) ? $_POST['campoTel'] : '';
$m_cmp = new m_cmp('infoBases');
$metadatos[0] = $nomTabla;
$metadatos[1] = $cdadFilas;
//inserta metadatos de csv en tabla Bases
$Suc0fail = $m_cmp->insertMDataFromCsv($metadatos);
if($Suc0fail == FALSE) {
    $Msg .= "<h4><img src='../bootstrap/img/error.png' alt='error'/>&nbsp;&nbsp;Almacenamiento de metadatos.</h4>";
} else {
    $Msg .= "<h4><img src='../bootstrap/img/success.png' alt='success'/>Almacenamiento de metadatos.</h4>";
}
//trae el listId
$arrinfo[0] = $nomTabla;
$listid = $m_cmp->traerListId($arrinfo);
//crea tabla
$Suc0fail = $m_cmp->createCsvTable($listid, $CampoParaBase, $TipoDatoParaBase);
if($Suc0fail == FALSE) {
    $Msg .= "<h4><img src='../bootstrap/img/error.png' alt='error'/>&nbsp;&nbsp;Creacion de tabla.</h4>";
} else {
    $Msg .= "<h4><img src='../bootstrap/img/success.png' alt='success'/>Creacion de tabla.</h4>";
}
//inserta filas de csv a tabla
$cdadColum = isset($_POST['cdadColum']) ? $_POST['cdadColum'] : '';
//$gestor = fopen('/tmp/tmpCsvFile'.$_SESSION['elastix_user'].'.csv', 'r');
$gestor = fopen('/tmp/tmpCsvFile.csv', 'r');
$arrDataToBd = array();
$Suc0fail = CsvToBD($gestor, $cdadColum, $m_cmp, $nomTabla, $CampoParaBase, $listid);
if($Suc0fail == FALSE) {
    $Msg .= "<h4><img src='../bootstrap/img/error.png' alt='error'/>&nbsp;&nbsp;Almacenamiento de datos.</h4>"
            . "<h5 style='color: red'>*Contacte al administrador de sistemas por errores.</h5>";
} else {
    if(strpos($Msg, 'error')) {
        $Msg .= "<h4><img src='../bootstrap/img/success.png' alt='success'/>Almacenamiento de datos.</h4>"
            . "<h5 style='color: red'>*Contacte al administrador de sistemas por errores.</h5>";
    } else {
        $Msg = "<h4><img src='../bootstrap/img/success.png' alt='success'/>Carga de datos exitosa.</h4>";
    }
}

//crea exportCsvFile
$fileTmp2 = fopen('/tmp/exportCsvFilelista_'.$listid.'.csv', 'w');
BDToExportCsv($fileTmp2, $m_cmp,$listid);

function BDToExportCsv($manager,$m_c,$listId) {
    $result = $m_c->traerTelIdIdLista($listId);
    $colums = ",id_lista,id".PHP_EOL;
    fwrite($manager, $colums);
    $cad = '';
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $cad = $row['tel'].','.$row['id_lista'].','.$row['id'].PHP_EOL;
        fwrite($manager, $cad);
        $cad = '';
    }
}

function CsvToBD($manager, $c, $m_c, $nt, $nomCampos, $lstid) {
    $a = 0;
    $cade = '';
    $arrae = array();
    if ($manager) {
        while (($datos = fgetcsv($manager, 1000, ',')) !== FALSE) {
            while ($a < $c) {
                if ($datos[$a]) {
                    $arrae[$a] = $datos[$a];
                }
                $a++;
            }
            $cade = $m_c->insertDataFromCsv($arrae, $nomCampos, $lstid);
            $arrae = NULL;
            $a = 0;
        }
    }
    return $cade;
}
