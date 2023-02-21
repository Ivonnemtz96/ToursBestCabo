<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

if (($UserData['rol'])>2) {
    setcookie("msg","sad",time() + 2, "/");
    header('Location: ');
}

if(isset($_REQUEST['delId']) and $_REQUEST['delId']!=""){
    $db->delete('itinerarios',array('id'=>$_REQUEST['delId']));
        
    setcookie("msg","horael",time() + 2, "/");
	header('location:/admin/nuevo/itinerario/');//exito
	exit;
}
?>