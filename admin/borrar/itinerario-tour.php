<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

if (($UserData['rol'])>2) {
    setcookie("msg","sad",time() + 2, "/");
    header('Location: ');
}

if(isset($_REQUEST['delId']) and $_REQUEST['delId']!=""){
    
    $delItinerario = $db->getAllRecords('toursItinerario','*','AND id='.($_REQUEST['delId']).'','LIMIT 1');
    if (empty($delItinerario)) { 
        setcookie("msg","ups",time() + 2, "/");
        header('location:/admin');
        exit;
    }
    $delItinerario = $delItinerario[0];
    
    
    $db->delete('toursItinerario',array('id'=>$_REQUEST['delId']));
    
    $tourSel = $db->getAllRecords('tours','*',' AND id="'.($delItinerario['tour']).'"','LIMIT 1');
    $tourSel = $tourSel[0];
    
    //RESTAMOS -1 A SU EXPERIENCIA
    $Sum = (($tourSel['itinerarioCount'])-1);
        
    $InsertData	=	array(
        'itinerarioCount'=> $Sum,
    );
    $update	=	$db->update('tours',$InsertData,array('id'=>($tourSel['id'])));
    
    setcookie("msg","horael",time() + 2, "/");
	header('location:/admin/nuevo/itinerario-tour?tourId='.($tourSel['id']).'');//exito
	exit;
}
?>