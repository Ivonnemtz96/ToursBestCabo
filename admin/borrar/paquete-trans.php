<?php 
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

if (($UserData['rol'])>2) {
    setcookie("msg","sad",time() + 2, "/");
    header('Location: ');
}

if(isset($_REQUEST['delId']) and $_REQUEST['delId']!=""){
    
    $delTour = $db->getAllRecords('paqTransporte','*','AND id='.($_REQUEST['delId']).'','LIMIT 1');
    if (empty($delTour)) { 
        setcookie("msg","ups",time() + 2, "/");
        header('location:/admin');
        exit;
    }
    $delTour = $delTour[0];
    
    
    $db->delete('paqTransporte',array('id'=>$_REQUEST['delId']));
    
    $paqueteSel = $db->getAllRecords('paquetes','*',' AND id="'.($delTour['paquete']).'"','LIMIT 1');
    $paqueteSel = $paqueteSel[0];
    
    //RESTAMOS -1 A SU EXPERIENCIA
    $SumFoto = (($paqueteSel['transCount'])-1);
        
    $InsertData	=	array(
        'transCount'=> $SumFoto,
    );
    $update	=	$db->update('paquetes',$InsertData,array('id'=>($paqueteSel['id'])));
    
    setcookie("msg","horael",time() + 2, "/");
	header('location:/admin/nuevo/paquete-trans?paqueteId='.($paqueteSel['id']).'');//exito
	exit;
}
?>