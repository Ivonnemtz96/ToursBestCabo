<?php session_start();
    include_once('config.php');
    $UserData =	$db->getAllRecords('usuarios','*',' AND id="'.($_SESSION["UserId"]).'"LIMIT 1 ');
    $UserData = $UserData[0];
    //($UserData['nombre'])
session_destroy();
setcookie("msg","bye",time() + 2, "/");
header('location: /');