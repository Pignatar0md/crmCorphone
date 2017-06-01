<?php

function invertirFecha($fecha) {
    $fechapataarriba = implode('-', array_reverse(explode('/', $fecha)));
    return $fechapataarriba;
}

function fechaPataArriba($fecha) {
    $fechapataarriba = implode('/', array_reverse(explode('-', $fecha)));
    return $fechapataarriba;
}

function cutAgt($agt) {
    $pos_ini = strpos($agt, '/')+1;
    $pos_fin = strpos($agt, ',');
    $agt = substr($agt, $pos_ini, $pos_fin - $pos_ini);
    return $agt;
}