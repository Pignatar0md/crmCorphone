<?php

include_once '../config.php';
include_once '../Model/m_cmp.php';
if (isset($_GET['file'])) {
    $enlace = $_GET['file'] ? $_GET['file'] : '';
    $content_type = '';
    if ($_GET['task'] == 'Ej') {
        $content_type = 'text/csv';
        download_file('/var/www/html/cargadebases/' . $enlace, 'csvEj.csv', $content_type);
    } elseif ($_GET['task'] == 'export') {
        $content_type = 'text/csv';
        download_file('/tmp/' . $enlace, $enlace, $content_type);
    } elseif ($_GET['task'] == 'processed') {
        $m_cmp = new m_cmp('infoBases');
        $listid = isset($_GET['listid']) ? $_GET['listid'] : '';
        $result = $m_cmp->traerCampTerminada($listid);
        BDToCsvCampFinished($result, $listid);
        $content_type = 'text/csv';
        download_file('/tmp/' . $enlace . $listid . '.csv', $enlace . $listid . '.csv', $content_type);
    } elseif ($_GET['task'] == 'MC') {
        $m_cmp = new m_cmp('infoBases');
        $result = $m_cmp->traerManualCalls();
        $content_type = 'text/csv';
        BDToCsvCampFinished($result, '');
        download_file('/tmp/processedCsvFileManualCalls.csv', 'processedCsvFileManualCalls.csv', $content_type);
    } else {
        $content_type = 'application/octet-stream';
        $id = $enlace . '-all.mp3';
        download_file(DIR . $id, $id, $content_type);
    }
}

function BDToCsvCampFinished($resultado, $listid = NULL) {
    if ($listid) {
        $archivo = fopen("/tmp/processedCsvFile" . $listid . ".csv", "w");
        $encab = 'id,id_lista,nombre,apellido,dni,tel,tel_alt,direccion,codpostal,email,comentario,venta,contacto,resul_contacto,fecha,hora,grabac,agente,' . PHP_EOL;
        fwrite($archivo, $encab);
        foreach ($resultado as $row) {
            $cad = $row['id_reg_lista'] . ',' .
                    $row['id_lista'] . ',' .
                    $row['nombre'] . ',' .
                    $row['apellido'] . ',' .
                    $row['dni'] . ',' .
                    $row['tel'] . ',' .
                    $row['tel_alt'] . ',' .
                    $row['direccion'] . ',' .
                    $row['codpostal'] . ',' .
                    $row['email'] . ',' .
                    $row['comentario'] . ',' .
                    $row['venta'] . ',' .
                    $row['contacto'] . ',' .
                    $row['resul_contacto'] . ',' .
                    $row['fecha'] . ',' .
                    $row['hora'] . ',' .
                    $row['grabac'] . ',' .
                    $row['agente'] . ',' . PHP_EOL;
            fwrite($archivo, $cad);
            $cad = '';
        }
    } else {
        $archivo = fopen("/tmp/processedCsvFileManualCalls.csv", "w");
        $encab = 'nombre,apellido,dni,tel,tel_alt,direccion,email,codpostal,fechanacim,contacto,resulContacto,venta,fecha,hora,coment,agente,grabac,' . PHP_EOL;
        fwrite($archivo, $encab);
        while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) {
            $cad = $row['nombre'] . ',' .
                    $row['apellido'] . ',' .
                    $row['dni'] . ',' .
                    $row['tel'] . ',' .
                    $row['tel_alt'] . ',' .
                    $row['direccion'] . ',' .
                    $row['email'] . ',' .
                    $row['codpostal'] . ',' .
                    $row['fechanacim'] . ',' .
                    $row['contacto'] . ',' .
                    $row['resulContacto'] . ',' .
                    $row['venta'] . ',' .
                    $row['fecha'] . ',' .
                    $row['hora'] . ',' .
                    $row['coment'] . ',' .
                    $row['agente'] . ',' .
                    $row['grabac'] . ',' . PHP_EOL;
            fwrite($archivo, $cad);
            $cad = '';
        }
    }
}

function download_file($archivo, $downloadfilename = null, $ctype) {
    if (file_exists($archivo)) {
        $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
        header('Content-Description: File Transfer');
        header("Content-Type: $ctype");
        header('Content-Disposition: attachment; filename=' . $downloadfilename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($archivo));
        ob_clean();
        flush();
        readfile($archivo);
        exit;
    } else {
        echo $archivo;
    }
}

?>
