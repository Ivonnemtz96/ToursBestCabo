<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

if (($UserData['rol'])>2) {
    setcookie("msg","sad",time() + 2, "/");
    header('Location: ');
}

if(isset($_REQUEST['delId']) and $_REQUEST['delId']!=""){
    
    $delHorario = $db->getAllRecords('toursHorarios','*','AND id='.($_REQUEST['delId']).'','LIMIT 1');
    if (empty($delHorario)) { 
        setcookie("msg","ups",time() + 2, "/");
        header('location:/admin');
        exit;
    }
    $delHorario = $delHorario[0];
    
    
    $db->delete('toursHorarios',array('id'=>$_REQUEST['delId']));
    
    $tourSel = $db->getAllRecords('tours','*',' AND id="'.($delHorario['tour']).'"','LIMIT 1');
    $tourSel = $tourSel[0];
    
    //RESTAMOS -1 A SU EXPERIENCIA
    $SumFoto = (($tourSel['horariosCount'])-1);
        
    $InsertData	=	array(
        'horariosCount'=> $SumFoto,
    );
    $update	=	$db->update('tours',$InsertData,array('id'=>($tourSel['id'])));
    
    setcookie("msg","horael",time() + 2, "/");
	header('location:/admin/nuevo/horario-tour?tourId='.($tourSel['id']).'');//exito
	exit;
}
?>