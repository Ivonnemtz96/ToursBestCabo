<?php  session_start();

if (!($_SESSION["UserId"])) {
    
    setcookie("msg","log",time() + 1, "/");
    header('Location: /admin/login');
    exit();
} else { 
    require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
    $UserData =	$db->getAllRecords('usuarios','*',' AND id="'.($_SESSION["UserId"]).'"LIMIT 1 ');
    $UserData = $UserData[0];
    
    if ($UserData['fPerfil']){
    $fPerfil = '/upload/usuarios/'.(strftime("%Y/%m", strtotime(($UserData['fr'])))).'/'.($UserData['fPerfil']).'.jpg';
    } else {$fPerfil = '/upload/usuarios/default.jpg';}
    //($UserData['nombre'])
}
?>