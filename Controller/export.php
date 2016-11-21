<?php
session_name('elastixSession');
session_start();

if (!isset($_SESSION['elastix_user'])) {
    header('Location: ../../index.php');
}

$zonahoraria = date_default_timezone_get();
date_default_timezone_set($zonahoraria);
include_once '../Model/m_authperson.php';
include_once '../Model/m_timecondition.php';
include_once '../Model/m_audit.php';
$submit = isset($_POST['submitExport']) ? $_POST['submitExport'] : NULL;
$horaini = isset($_POST['hora1']) ? strip_tags($_POST['hora1']) : NULL;
$horafin = $_POST['hora2'] ? strip_tags($_POST['hora2']) : NULL;
$fechaini = $_POST['txtFecha1'] ? strip_tags(trim($_POST['txtFecha1'])) : NULL;
$fechafin = $_POST['txtFecha2'] ? strip_tags(trim($_POST['txtFecha2'])) : NULL;

$fechaini = str_replace("/", "-", $fechaini);
$fechafin = str_replace("/", "-", $fechafin);

//echo $fechaini . "---" . $fechafin . "--|--" . $horaini . "+++" . $horafin;
$fechaini=implode('-',array_reverse(explode('-',$fechaini)));
$fechafin=implode('-',array_reverse(explode('-',$fechafin)));

if ($submit) {
    $nombre_fichero = '';
    $result = '';
    $i = 0;
    $salida_cvs = '';
    $values = '';
    if (isset($_POST['timecondition'])) {
        $m_tc = new m_timecondition();
        $nombre_fichero = '-tc.csv';
        $result = $m_tc->traerColumnas();
        $values = $m_tc->listar();
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                $salida_cvs .= $row['Field'] . ",";
                $i++;
            }
        }
        $salida_cvs .= "\n";
        while ($rowr = mysql_fetch_row($values)) {
            for ($j = 0; $j < $i; $j++) {
                if ($j == $i - 1) {
                    $salida_cvs .= '"' . $rowr[$j] . '"';
                } else {
                    $salida_cvs .= '"' . $rowr[$j] . '";';
                }
            }
            $salida_cvs .= "\n";
        }
    } elseif (isset($_POST['authperson'])) {
        $m_authperson = new m_authperson();
        $nombre_fichero = '-ap.csv';
        $result = $m_authperson->traerColumnas();
        $values = $m_authperson->listar();
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                $salida_cvs .= $row['Field'] . ",";
                $i++;
            }
        }
        $salida_cvs .= "\n";
        while ($rowr = mysql_fetch_row($values)) {
            for ($j = 0; $j < $i; $j++) {
                if ($j == $i - 1) {
                    $salida_cvs .= '"' . $rowr[$j] . '"';
                } else {
                    $salida_cvs .= '"' . $rowr[$j] . '";';
                }
            }
            $salida_cvs .= "\n";
        }
    } elseif (isset($_POST['logs'])) {
        $m_audit = new m_audit();
        $nombre_fichero = '-logs.csv';
        $result = $m_audit->traerColumnas();

        if ($horaini && $horafin) {
            $arrhoras = array();
            $arrhoras[0] = $horaini;
            $arrhoras[1] = $horafin;
            if ($fechaini && $fechafin) {
                $arrfechas = array();
                $arrfechas[0] = $fechaini;
                $arrfechas[1] = $fechafin;
                $values = $m_audit->listarPorFechaHora($arrfechas, $arrhoras);
            } else {
                $values = $m_audit->listarPorHora($arrhoras);
            }
        } elseif ($fechaini && $fechafin) {
            $arrfechas = array();
            $arrfechas[0] = $fechaini;
            $arrfechas[1] = $fechafin;
            $values = $m_audit->listarPorFecha($arrfechas);
        } else {
            $values = $m_audit->listar();
        }

        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                $salida_cvs .= $row['Field'] . ",";
                $i++;
            }
        }

        $salida_cvs .= "\n";
        while ($rowr = mysql_fetch_row($values)) {
            for ($j = 0; $j < $i; $j++) {
                if ($j == $i - 1) {
                    $salida_cvs .= '"' . $rowr[$j] . '"';
                } else {
                    $salida_cvs .= '"' . $rowr[$j] . '";';
                }
            }
            $salida_cvs .= "\n";
        }
    }
    header("Content-type: application/vnd.ms-excel");
    header("Content-disposition: csv" . date("Y-m-d") . ".csv");
    header("Content-disposition: filename=" . date("d-m-Y") . $nombre_fichero);
    print $salida_cvs;
    exit;
}
?>
