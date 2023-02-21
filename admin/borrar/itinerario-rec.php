<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

if (($UserData['rol'])>2) {
    setcookie("msg","sad",time() + 2, "/");
    header('Location: ');
}

if(isset($_REQUEST['delId']) and $_REQUEST['delId']!=""){
    
    $delItinerario = $db->getAllRecords('itinerarioRec','*','AND id='.($_REQUEST['delId']).'','LIMIT 1');
    if (empty($delItinerario)) { 
        setcookie("msg","ups",time() + 2, "/");
        header('location:/admin');
        exit;
    }
    $delItinerario = $delItinerario[0];
    
    
    $db->delete('itinerarioRec',array('id'=>$_REQUEST['delId']));
    
    $padre = $db->getAllRecords('itinerarios','*',' AND id="'.($delItinerario['itinerario']).'"','LIMIT 1');
    $padre = $padre[0];
    
    //RESTAMOS -1 A SU EXPERIENCIA
    $Sum = (($padre['recCount'])-1);
        
    $InsertData	=	array(
        'recCount'=> $Sum,
    );
    $update	=	$db->update('itinerarios',$InsertData,array('id'=>($padre['id'])));
    
    setcookie("msg","horael",time() + 2, "/");
	header('location:/admin/nuevo/itinerario-rec?tourId='.($padre['id']).'');//exito
	exit;
}
?>