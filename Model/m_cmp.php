<?php

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
//include_once '../config.php';
include_once 'Connection.php';

class m_cmp {

    private $argPdo;

    function __construct($db) {
        $this->argPdo = "mysql:host=" . MySQL_HOST . ";dbname=$db;charset=utf8";
    }
    function createListTrans($listId, $arrDataTable, $arrCampos, $arrCFilas) {
        $sql = "BEGIN";
        for ($i = 0; $i < 4; $i++) {
            switch ($i) {
                case 1:
                    $a = 0;
                    $sql = "create table lista_$listId ("
                            . "id int not null auto_increment,"
                            . "id_lista int not null,";
                    foreach ($arrDataTable as $type) {
                        $sql .= "$arrCampos[$a] $type,";
                        $a++;
                    }
                    $sql .= "primary key (id), foreign key (id_lista) references Bases(id))";
                    $res = $this->Query($sql);
                    break;
                case 2:
                    foreach ($arrCFilas as $clave => $valor) {
                        $sql = "insert into lista_$listId(id_lista,";
                        foreach ($arrCampos as $namec) {
                            $sql .= trim($namec) . ",";
                        }
                        $sql = substr($sql, 0, -1);
                        $sql .= ") values($listId,";
                        foreach ($valor as $c => $v) {
                            if (is_numeric($v)) {
                                $sql .= trim($v) . ",";
                            } else {
                                $sql .= "'" . trim($v) . "',";
                            }
                        }
                        $sql = substr($sql, 0, -1);
                        $sql .= ")";
                        $res = $this->Query($sql);
                    }
                    break;
                case 3:
                    if ($resultado !== false) {
                        $sql = "COMMIT";
                    } else {
                        $sql = "ROLLBACK";
                    }
                    $res = $this->Query($sql);
                    break;
            }
        }
        return $res;
    }
    function Query($sql) {
        $resultado = '';
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            if($query) {
            $resultado = $query->execute();
            }
            $cnn = NULL;
        } catch (PDOException $ex) {
            $ex->getMessage();
        }
        return $resultado;
    }
    function deleteListTrans($idBase) {
        $sql = "BEGIN";
        $result = NULL;
        for ($i = 0; $i < 4; $i++) {
            switch ($i) {
                case 1:
                    $sql = "delete from Bases where id = $idBase";
                    break;
                case 2:
                    $sql = "drop table lista_$idBase";
                    break;
                case 3:
                    if ($result !== false) {
                        $sql = "COMMIT";
                    } else {
                        $sql = "ROLLBACK";
                    }
                    break;
            }
            try {
                $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
                $query = $cnn->prepare($sql);
                $result = $query->execute();
                $cnn = NULL;
            } catch (PDOException $ex) {
                return $ex->getMessage();
            }
        }
        return $result;
    }
    function getLeadEdit($arrData) {
        $sql ="select id_reg_lista,rl.id_lista as id_lista,tel,nombre,apellido,dni,direccion,codpostal,tel_alt,email, contacto, resul_contacto, "
                . "date_format(fecha,'%d/%m/%Y') as fecha,date_format(hora,'%H:%i') as hora, comentario from Registro_Listas rl join ". $arrData[0] . " lst on rl.id_reg_lista = lst.id "
                . "and id_reg_lista = " . $arrData[1];
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
        return $result;
    }
    function actualizarContacto($arrData) {
        $sql = "update lista_$arrData[0] set tel = '$arrData[1]', nombre = '$arrData[2]', apellido = '$arrData[3]', "
                                          . "dni = '$arrData[4]', direccion = '$arrData[5]', codpostal = '$arrData[6]', "
                . "tel_alt = '$arrData[7]', email = '$arrData[8]' where id = $arrData[9] and id_lista = $arrData[0]";
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
    }
    function traerCmp() {
        $sql = "select id, fecha, nombre, cdadregistros from Bases";
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
        return $result;
    }    
    function traerManualCalls() {
        $sql = "select nombre,apellido,dni,tel,tel_alt,direccion,email,codpostal,fechanacim,contacto,resulContacto,"
                . "venta,fecha,hora,coment,agente,grabac "
                . "from lista_llam_manuales";
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
        return $result;
    }    
    function traerTotalManualCalls() {
        $sql = "select count(*) as total from lista_llam_manuales";
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
        return $result;
    }
    function traerListId($arrInfo) {
        $sql = "select id from Bases where nombre like '$arrInfo[0]'";
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
        if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $result = $row['id'];
        }
        return $result;
    }
    function createCsvTable($listId, $arrData, $arrDataType) {
        $i = 0;
        $result = false;
        $sql = "create table lista_$listId ("
                . "id int not null auto_increment,"
                . "id_lista int not null,";
        foreach ($arrDataType as $type) {
            $sql .= "$arrData[$i] $type,";
            $i++;
        }
        $sql .= "primary key (id),"
                . "foreign key (id_lista) references Bases(id))";
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
        return $result;
    }
    function insertMDataFromCsv($arrData) {
        $result = false;
        $sql = "insert into Bases(fecha, nombre, cdadregistros) "
                . "values(now(),'$arrData[0]', $arrData[1])";
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
        return $result;
    }
    function insertDataFromCsv($arrData, $arrNameCol, $listId) {
        $sql = "insert into lista_$listId(id_lista,";
        $result = FALSE;
        foreach ($arrNameCol as $namec) {
            $sql .= trim($namec) . ",";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ") values($listId,";
        foreach ($arrData as $date) {
            if (is_numeric($date)) {
                $sql .= trim($date) . ",";
            } else {
                $sql .= "'" . trim($date) . "',";
            }
        }
        $sql = substr($sql, 0, -1);
        $sql .= ")";
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
        return $result;
    }
    function traerDatosClientes($arrIds) {
        $sql = "select id,tel,nombre,apellido,dni,direccion,codpostal,tel_alt,email from " . $arrIds[0] . " "
                . "where tel = '" . $arrIds[1] . "'";
        try {
            $cnn = new Connection("infoBases");
            $cnn->Connect();
            $lnk = $cnn->GetLink();
            $result = mysql_query($sql, $lnk);
            $cnn->Connect_close($lnk);
        } catch (Exception $e) {
            $result = $e;
        }
        return $result;
    }
    function insertTLogContact($arrDatos) {
        $sql = '';
        if (!$arrDatos[6]) {
	    if (!$arrDatos[7]) {
	        $sql = "insert into Registro_Listas(id_reg_lista,id_lista,comentario,venta,contacto,resul_contacto,fecha,hora, camp, grabac, agente) "
                        . "values( $arrDatos[0], $arrDatos[1], '$arrDatos[2]', $arrDatos[3], '$arrDatos[4]', '$arrDatos[5]', curdate(), curtime(),'$arrDatos[8]','" . Audio_host . "/$arrDatos[9].mp3','$arrDatos[10]')";
            } else {
                $sql = "insert into Registro_Listas(id_reg_lista,id_lista,comentario,venta,contacto,resul_contacto,fecha,hora, camp, grabac, agente) "
                        . "values( $arrDatos[0], $arrDatos[1], '$arrDatos[2]', $arrDatos[3], '$arrDatos[4]', '$arrDatos[5]', curdate(), '$arrDatos[7]','$arrDatos[8]','" . Audio_host . "/$arrDatos[9].mp3','$arrDatos[10]')";
            }
        } else {
            if (!$arrDatos[7]) {
                $sql = "insert into Registro_Listas(id_reg_lista,id_lista,comentario,venta,contacto,resul_contacto,fecha,hora, camp, grabac, agente) "
                        . "values( $arrDatos[0], $arrDatos[1], '$arrDatos[2]', $arrDatos[3], '$arrDatos[4]', '$arrDatos[5]', '$arrDatos[6]', curtime(),'$arrDatos[8]','" . Audio_host . "/$arrDatos[9].mp3','$arrDatos[10]')";
            } else {
                $sql = "insert into Registro_Listas(id_reg_lista,id_lista,comentario,venta,contacto,resul_contacto,fecha,hora, camp, grabac, agente) "
                        . "values( $arrDatos[0], $arrDatos[1], '$arrDatos[2]', $arrDatos[3], '$arrDatos[4]', '$arrDatos[5]', '$arrDatos[6]', '$arrDatos[7]','$arrDatos[8]','" . Audio_host . "/$arrDatos[9].mp3','$arrDatos[10]')";
	    }
	}
        try {
            $cnn = new Connection('infoBases');
            $cnn->Connect();
            $link = $cnn->GetLink();
            $result = mysql_query($sql, $link);
            $cnn->Connect_close($link);
            $cnn = NULL;
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }
//        return $sql;
    }
    function traerTelIdIdLista($listid) {
        $sql = "select tel,id,id_lista from `lista_$listid`";
        try {
            $cnn = new Connection('infoBases');
            $cnn->Connect();
            $link = $cnn->GetLink();
            $result = mysql_query($sql, $link);
            $cnn->Connect_close($link);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
    function traerCampTerminada($listid) {
        $sql = "select id_reg_lista,rl.id_lista as id_lista,nombre,apellido,dni,tel,tel_alt,direccion,codpostal,"
                . "email, comentario, venta,contacto,resul_contacto,fecha,hora,grabac,agente "
                . "from Registro_Listas rl join lista_$listid lst on rl.id_lista = lst.id_lista "
                . "and lst.id = rl.id_reg_lista "
                . "and rl.id_lista = $listid";
        try {
            $cnn = new PDO($this->argPdo, MySQL_USER, MySQL_PASS);
            $query = $cnn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $cnn = NULL;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
        return $result;
    }
/*    private function buildQuery($type_var, $var) {
        $tbl = '';
        switch ($type_var) {
            case 'tabla':
                $tbl = $var;
                break;
        }
        return $tbl;
    }*/
    function getLeadNoProc($arrData) {
        $sql = "select id,id_lista,nombre,apellido,dni,tel,direccion,codpostal,tel_alt,email "
                . "from " . $arrData[5] ." where 1=1 ";
        if ($arrData[0]) {
            $sql .= "and tel like '%$arrData[0]%' ";
        } if ($arrData[1]) {
            $sql .= "and nombre like '%$arrData[1]%' ";
        } if ($arrData[2]) {
            $sql .= " and apellido like '%$arrData[2]%'";
        }
        try {
            $cnn = new Connection('infoBases');
            $cnn->Connect();
            $link = $cnn->GetLink();
            $result = mysql_query($sql, $link);
            $cnn->Connect_close($link);
            $cnn = NULL;
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }
        return $result;
    }
    function getLead($arrData) {
        $sql = "select id_reg_lista,rl.id_lista as id_lista,nombre,apellido,dni,tel,direccion,codpostal,tel_alt,email, contacto, resul_contacto, "
                . "date_format(fecha,'%m-%d') as fecha, date_format(hora,'%H:%i') as hora "
                . "from Registro_Listas rl join " . $arrData[5] . " lst on rl.id_reg_lista = lst.id and rl.agente like '%$arrData[6]%'";
        if ($arrData[0]) {
            $sql .= "and tel like '%$arrData[0]%' ";
        } if ($arrData[1]) {
            $sql .= "and nombre like '%$arrData[1]%'";
        } if ($arrData[2]) {
            $sql .= " and apellido like '%$arrData[2]%'";
        } if ($arrData[3] != NULL) {
            $sql .= " and fecha like '%$arrData[3]%'";
        } if ($arrData[4] != "null") {
            $sql .= " and resul_contacto like '%$arrData[4]%'";
        }
        $sql .= ' order by fecha asc';
        try {
            $cnn = new Connection('infoBases');
            $cnn->Connect();
            $link = $cnn->GetLink();
            $result = mysql_query($sql, $link);
            $cnn->Connect_close($link);
            $cnn = NULL;
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }
//        return $sql;
	return $result; 
    }
    function getTables() {
        $sql = "show tables from infoBases like 'lista_%'";
        try {
            $cnn = new Connection('infoBases');
            $cnn->Connect();
            $link = $cnn->GetLink();
            $result = mysql_query($sql, $link);
            $cnn->Connect_close($link);
            $cnn = NULL;
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }
        return $result;
    }
    function insertManualCall($arrDatos) {
        $sql = "insert into lista_llam_manuales (nombre,apellido,dni,tel,tel_alt,direccion,email,codpostal,"
                . "fechanacim,contacto,resulContacto,venta,fecha,hora,coment,agente,grabac) "
                //           nom             apel             dni          tel            telalt          direc
                . "values ('$arrDatos[0]','$arrDatos[1]','$arrDatos[2]','$arrDatos[3]','$arrDatos[4]','$arrDatos[5]',"
                //     mail          codpost         fechanac     contac        rescontac      venta          fecha
                . "'$arrDatos[6]','$arrDatos[7]','$arrDatos[8]',$arrDatos[9],'$arrDatos[10]',$arrDatos[11],'$arrDatos[12]',"
                //      hora          coment          agt             grabac
                . "'$arrDatos[13]','$arrDatos[14]','$arrDatos[15]','$arrDatos[16]')";
        try {
            $cnn = new Connection('infoBases');
            $cnn->Connect();
            $link = $cnn->GetLink();
            $result = mysql_query($sql, $link);
            $cnn->Connect_close($link);
            $cnn = NULL;
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }
        return $sql;
    }    
    function updateTLogContact($arrData) {
        $sql = "update Registro_Listas set comentario = '$arrData[0]', venta = '$arrData[1]', contacto = '$arrData[2]', "
                                          . "resul_contacto = '$arrData[3]', fecha = '$arrData[4]', hora = '$arrData[5]' "
                . "where id_reg_lista =" . $arrData[6];
        try {
            $cnn = new Connection('infoBases');
            $cnn->Connect();
            $link = $cnn->GetLink();
            $result = mysql_query($sql, $link);
            $cnn->Connect_close($link);
            $cnn = NULL;
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }
        return $sql;
    }
    function insertVenta($arrData, $a) {
        if ($a) {// manual
            $sql .= "insert into Ventas(fecha, hora, agente) values(curdate(),curtime(),'" . $arrData[15] . "')";
        } else {// no manual
            $sql .= "insert into Ventas(fecha, hora, agente) values(curdate(),curtime(),'" . $arrData[10] . "')";
        }
        try {
            $cnn = new Connection('infoBases');
            $cnn->Connect();
            $link = $cnn->GetLink();
            $result = mysql_query($sql, $link);
            $cnn->Connect_close($link);
            $cnn = NULL;
        } catch (Exception $ex) {
            $result = $ex->getMessage();
            return $result;
        }
    }
    function getVentas($agt) {
        $sql = "select count(*) as cdadvta,agente from Ventas where fecha = curdate() and agente like '$agt'";
        try {
            $cnn = new Connection('infoBases');
            $cnn->Connect();
            $link = $cnn->GetLink();
            $result = mysql_query($sql, $link);
            $cnn->Connect_close($link);
            $cnn = NULL;
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }
        return $result;
    }
}
