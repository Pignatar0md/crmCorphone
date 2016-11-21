<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
ini_set('max_execution_time', '180');
ini_set('max_input_time', '240');
ini_set('memory_limit', '256M');
session_name('elastixSession');
session_start();
if (!isset($_SESSION['elastix_user'])) {
    //   header('Location: ../index.php');
}
include_once '../Model/m_cmp.php';
$submit = isset($_POST['Cargar']) ? $_POST['Cargar'] : NULL;
$getCmp = isset($_POST['getCmp']) ? $_POST['getCmp'] : '';
$nomBase = isset($_POST['nomBase']) ? $_POST['nomBase'] : '';
$explode_valores = $cdadColum = $gestor = $linea_texto = '';
$separador_campos = ",";
$cdadFilas = '';
if ($getCmp) {
    $m_cmp = new m_cmp('infoBases');
    $i = 1;
    $data = "<table class='table table-stripped'>"
            . "<tr><td>"
            . "<em><b>Fecha Creacion</b></em>"
            . "</td>"
            . "<td>"
            . "<em><b>Nombre</b></em>"
            . "</td>"
            . "<td style='text-align: center'>"
            . "<em><b>Cdad Registros</b></em>"
            . "</td>"
            . "<td style='text-align: center'>"
            . "<em><b>Acciones</b></em>"
            . "</td>"
            . "</tr>";
    $resultado = $m_cmp->traerTotalManualCalls();
    if ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) {
        $data .= "<tr><td>
                  <b style='color: #48722c'>Llamadas Manuales</b>
                  </td>
                  <td>
                  <b style='color: #48722c'>Llamadas Manuales</b>
                  </td>
                  <td style='text-align: center'>&nbsp;
                  <b style='color: #48722c'>" . $row['total'] . "</b>
                  </td>
                  <td style='text-align: center'> 
                  &nbsp;
                  <a href='Controller/download.php?file=processedCsvFile&task=MC' title='Descargar'><img alt='descarga' src='bootstrap/img/downloadmc.png' width='20' height='20'/></a>
                  &nbsp;
                  <!--<a title='Descargar' href='Controller/CtlImport.php?action=del&listid=" . $row['id'] . "'><img alt='eliminar' src='bootstrap/img/deleteGreen.jpg' width='20' height='20'/></a>-->
                  </td></tr>";
    }
    $resultado = $m_cmp->traerCmp();
    while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) {
        $data .= "<tr><td>
                  " . $row['fecha'] . "
                  </td>
                  <td>
                  " . $row['nombre'] . "
                  </td>
                  <td style='text-align: center'>&nbsp;
                  " . $row['cdadregistros'] . "
                  </td>
                  <td style='text-align: center'>
                  <a title='Exportar' href='Controller/download.php?file=exportCsvFilelista_" . $row['id'] . ".csv&task=export'><img alt='exportacion' src='bootstrap/img/export.jpg' width='20' height='20'/></a>
                  &nbsp;
                  <a title='Descargar' href='Controller/download.php?file=processedCsvFile&listid=" . $row['id'] . "&task=processed'><img alt='descarga' src='bootstrap/img/download.png' width='20' height='20'/></a>
                      &nbsp;
		  <a href='#' onclick='return false;' title='Eliminar'><img id='delete' alt='eliminar' src='bootstrap/img/delete.jpg' width='20' height='20' value='" . $row['id'] . "'/></a>
                  </td></tr>";
        $i++;
    }
    $data .= "</table><hr>";
    echo $data;
}
if ($submit) {
    $n = 0;
    $location = "noImport.php";
    $file = $_FILES['file']['tmp_name'];
    $gestor = fopen($file, "r");// or die("Couldn't get handle");
    if ($gestor !== FALSE) {
        $linea_texto = fgets($gestor);
        $explode_valores = explode($separador_campos, $linea_texto);
        $cdadColum = count($explode_valores);
        $location = "import.php";
    }
    $cdadFilas = getNumRows($gestor, $separador_campos, $cdadColum);
}

function getNumRows($manager, $campsep, $c) {
    $n = $a = 0;
    //$fileTmp = fopen('/tmp/tmpCsvFile'.$_SESSION['elastix_user'].'.csv', 'w');
    $fileTmp = fopen('/tmp/tmpCsvFile.csv', 'w');
    if ($manager) {
        while (($datos = fgetcsv($manager, 1000, $campsep)) !== FALSE) {//crea archivo temporal
            $n++;
            $cad = '';
            while ($a < $c) {
                if ($datos[$a]) {
                    $cad .= $datos[$a] . ',';
                }
                $a++;
            }
            $cad = substr($cad, 0, -1);
            //$cad = substr($cad,0,-1);
            $cad .= PHP_EOL;
            fwrite($fileTmp, $cad);
            $a = 0;
        }
    }
    fclose($fileTmp);
    return $n;
}

$delete = isset($_POST['eliminar']) ? $_POST['eliminar'] : '';
$ID = isset($_POST['id']) ? $_POST['id'] : '';
if ($delete) {
    $m_cmp = new m_cmp('infoBases');
    if ($ID) {
        $resultado = $m_cmp->deleteListTrans($ID);
    }
    $m_cmp = NULL;
    return $ID;
}

function showHeaders($a, $b) {
    $show = "<table class='table table-condensed'>";
    $i = 0;
    $a = explode(',', $a);
    foreach ($a as $col) {
        $i++;
        $show .= "<td><div><!--<div class='radio form-inline'>
                 <label>
                 <input type='radio' name='campoTel' id='opciones_$i' value='" . $col . "'>
                 </label>--><b>" . $col .
                "</b>
                    <input type='hidden' name='nomcol" . $i . "' value='" . $col . "'/>
                 <!--</div>-->
                 </div>
                 <select name='tipoDato$i' class='form-control'>
                    <option value='varchar(50)'>Generico</option>
                    <option value='date'>Fecha</option>
                    <option value='time'>Hora</option>
                 </select></td>";
    }
    $show .= "</table><hr>";
    echo $show;
}
