<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

if (($UserData['rol'])>2) {
    setcookie("msg","sad",time() + 2, "/");
    header('Location: /');
}


if(isset($_REQUEST['delId']) and $_REQUEST['delId']!=""){
    
    $caracSel = $db->getAllRecords('umIncluyeentour','*',' AND id="'.($_REQUEST['delId']).'"','LIMIT 1');
    
    if (empty($caracSel)) { //SI NO EXISTE ES QUE NO HAY UN ID VALIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
        setcookie("msg","ups",time() + 2, "/");
        header('location:/admin/tours');
        exit;
}
    $caracSel = $caracSel[0];
    
    
	$db->delete('umIncluyeentour',array('id'=>$_REQUEST['delId']));
    
    
    //RESTAMOS -1 A SU LAS CARACTERISTICAS DE ESTA PROPIEDAD
        $tourSel = $db->getAllRecords('tours','*',' AND id="'.($caracSel['tour']).'"','LIMIT 1');
        $tourSel = $tourSel[0];
    
        $SumCar = (($tourSel['incluyeCount'])-1);
        
        $InsertData	=	array(
            'incluyeCount'=> $SumCar,
        );
	       $update	=	$db->update('tours',$InsertData,array('id'=>($tourSel['id'])));
           setcookie("msg","cardel",time() + 2, "/"); 
	       header('location: /admin/editar/tour/?editId='.($tourSel['id']).'');
	exit;
}
?>