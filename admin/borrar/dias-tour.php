<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

if (($UserData['rol'])>2) {
    setcookie("msg","sad",time() + 2, "/");
    header('Location: ');
}

if(isset($_REQUEST['delId']) and $_REQUEST['delId']!=""){
    
    $delSel = $db->getAllRecords('toursDias','*','AND id='.($_REQUEST['delId']).'','LIMIT 1');
    if (empty($delSel)) { 
        setcookie("msg","ups",time() + 2, "/");
        header('location:/admin');
        exit;
    }
    $delSel = $delSel[0];
    
    $db->delete('toursDias',array('id'=>$_REQUEST['delId']));
    
    $tourSel = $db->getAllRecords('tours','*',' AND id="'.($delSel['tour']).'"','LIMIT 1');
    $tourSel = $tourSel[0];
    
    //RESTAMOS -1 A SU EXPERIENCIA
    $SumFoto = (($tourSel['diasCount'])-1);
        
    $InsertData	=	array(
        'diasCount'=> 0,
    );
    $update	=	$db->update('tours',$InsertData,array('id'=>($tourSel['id'])));
    
    setcookie("msg","horael",time() + 2, "/");
	header('location:/admin/nuevo/dias-tour?tourId='.($tourSel['id']).'');//exito
	exit;
}
?>