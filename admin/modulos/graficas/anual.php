<?php

$hoy = date('Y-m');
$mes1 = $hoy;

$mes2 = strtotime ('-1 month',strtotime($hoy));
$mes2 = date('Y-m',$mes2);

$mes3 = strtotime ('-2 month',strtotime($hoy));
$mes3 = date('Y-m',$mes3);

$mes4 = strtotime ('-3 month',strtotime($hoy));
$mes4 = date('Y-m',$mes4);

$mes5 = strtotime ('-4 month',strtotime($hoy));
$mes5 = date('Y-m',$mes5);

$mes6 = strtotime ('-5 month',strtotime($hoy));
$mes6 = date('Y-m',$mes6);

$mes7 = strtotime ('-6 month',strtotime($hoy));
$mes7 = date('Y-m',$mes7);

$mes8 = strtotime ('-7 month',strtotime($hoy));
$mes8 = date('Y-m',$mes8);

$mes9 = strtotime ('-8 month',strtotime($hoy));
$mes9 = date('Y-m',$mes9);

$mes10 = strtotime('-9 month',strtotime($hoy));
$mes10 = date('Y-m',$mes10);

$mes11 = strtotime('-10 month',strtotime($hoy));
$mes11 = date('Y-m',$mes11);

$mes12 = strtotime('-11 month',strtotime($hoy));
$mes12 = date('Y-m',$mes12);


//CUENTAS POR MESES PEDIDOS PAGADOS
$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes1.'%" AND status="3"');
$pagTmes1 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes2.'%" AND status="3"');
$pagTmes2 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes3.'%" AND status="3"');
$pagTmes3 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes4.'%" AND status="3"');
$pagTmes4 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes5.'%" AND status="3"');
$pagTmes5 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes6.'%" AND status="3"');
$pagTmes6 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes7.'%" AND status="3"');
$pagTmes7 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes8.'%" AND status="3"');
$pagTmes8 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes9.'%" AND status="3"');
$pagTmes9 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes10.'%" AND status="3"');
$pagTmes10 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes11.'%" AND status="3"');
$pagTmes11 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes12.'%" AND status="3"');
$pagTmes12 = ($reservasCount[0]['total']);

//CUENTAS POR MESES PEDIDOS OLVIDADOS
$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes1.'%" AND status="1"');
$olvTmes1 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes2.'%" AND status="1"');
$olvTmes2 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes3.'%" AND status="1"');
$olvTmes3 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes4.'%" AND status="1"');
$olvTmes4 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes5.'%" AND status="1"');
$olvTmes5 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes6.'%" AND status="1"');
$olvTmes6 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes7.'%" AND status="1"');
$olvTmes7 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes8.'%" AND status="1"');
$olvTmes8 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes9.'%" AND status="1"');
$olvTmes9 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes10.'%" AND status="1"');
$olvTmes10 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes11.'%" AND status="1"');
$olvTmes11 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes12.'%" AND status="1"');
$olvTmes12 = ($reservasCount[0]['total']);

//CUENTAS POR MESES PEDIDOS CANCELADOS
$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes1.'%" AND status="2"');
$canTmes1 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes2.'%" AND status="2"');
$canTmes2 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes3.'%" AND status="2"');
$canTmes3 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes4.'%" AND status="2"');
$canTmes4 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes5.'%" AND status="2"');
$canTmes5 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes6.'%" AND status="2"');
$canTmes6 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes7.'%" AND status="2"');
$canTmes7 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes8.'%" AND status="2"');
$canTmes8 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes9.'%" AND status="2"');
$canTmes9 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes10.'%" AND status="2"');
$canTmes10 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes11.'%" AND status="2"');
$canTmes11 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes12.'%" AND status="2"');
$canTmes12 = ($reservasCount[0]['total']);



//CUENTAS POR MESES PEDIDOS POR PAGAR
$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes1.'%" AND status="4"');
$porTmes1 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes2.'%" AND status="4"');
$porTmes2 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes3.'%" AND status="4"');
$porTmes3 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes4.'%" AND status="4"');
$porTmes4 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes5.'%" AND status="4"');
$porTmes5 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes6.'%" AND status="4"');
$porTmes6 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes7.'%" AND status="4"');
$porTmes7 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes8.'%" AND status="4"');
$porTmes8 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes9.'%" AND status="4"');
$porTmes9 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes10.'%" AND status="4"');
$porTmes10 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes11.'%" AND status="4"');
$porTmes11 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$mes12.'%" AND status="4"');
$porTmes12 = ($reservasCount[0]['total']);


?>