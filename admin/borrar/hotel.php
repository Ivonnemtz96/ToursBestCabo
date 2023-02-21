<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

    if (($UserData['rol'])>2) {
        setcookie("msg","sad",time() + 2, "/");
        header('Location: /');
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    date_default_timezone_set('America/Tijuana');   
    $fecha = date("Y-m-d H:i:s");
    
    if(isset($_REQUEST['delId']) and $_REQUEST['delId']!=""){
        
        $DelProd = $db->getAllRecords('hoteles','*','AND id='.($_REQUEST['delId']).'','LIMIT 1');
        if (empty($DelProd)) { 
            setcookie("msg","ups",time() + 2, "/");
            header('location:/admin/nuevo/hotel');
            exit;
        }
        $DelProd = $DelProd[0];
    
        
            
            if (isset($DelProd['fPortada'])){
                $archivo = '../../upload/hoteles/'.(strftime("%Y/%m", strtotime(($DelProd['fr'])))).'/'.($DelProd['fPortada']).'.jpg';
                unlink($archivo); //BORRAMOS LA FOTO DE PORTADA
            }
            
            if (($DelProd['fotosCount'])>0){
                
                $Delfotos = $db->getAllRecords('fotosHotel','*','AND hotel='.($_REQUEST['delId']).'','LIMIT '.($DelProd['fotosCount']).'');
                
                if (count($Delfotos)>0){
                    $y	=	'';
                    foreach($Delfotos as $foto){
                        $y++;
                        
                        $archivo = '../../upload/hoteles/'.(strftime("%Y/%m", strtotime(($DelProd['fr'])))).'/'.($foto['codigo']).'.jpg';
                        unlink($archivo); 
                        
                    }
                }
            }
            
            $db->delete('hoteles',array('id'=>$_REQUEST['delId']));
            
            setcookie("msg","proddel",time() + 2, "/");
            header('location: /admin/nuevo/hotel');
            exit;
}
?>