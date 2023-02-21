<?php

$hoy = date('Y-m-d');
$dia1 = $hoy;

$dia2 = strtotime ('-1 day',strtotime($hoy));
$dia2 = date('Y-m-d',$dia2);

$dia3 = strtotime ('-2 day',strtotime($hoy));
$dia3 = date('Y-m-d',$dia3);

$dia4 = strtotime ('-3 day',strtotime($hoy));
$dia4 = date('Y-m-d',$dia4);

$dia5 = strtotime ('-4 day',strtotime($hoy));
$dia5 = date('Y-m-d',$dia5);

$dia6 = strtotime ('-5 day',strtotime($hoy));
$dia6 = date('Y-m-d',$dia6);

$dia7 = strtotime ('-6 day',strtotime($hoy));
$dia7 = date('Y-m-d',$dia7);


//CUENTAS POR DIA RESERVAS PAGADOS
$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia1.'%" AND status="3"');
$pagtdia1 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia2.'%" AND status="3"');
$pagtdia2 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia3.'%" AND status="3"');
$pagtdia3 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia4.'%" AND status="3"');
$pagtdia4 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia5.'%" AND status="3"');
$pagtdia5 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia6.'%" AND status="3"');
$pagtdia6 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia7.'%" AND status="3"');
$pagtdia7 = ($reservasCount[0]['total']);

//CUENTAS POR DIA RESERVAS OLVIDADAS
$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia1.'%" AND status="1"');
$olvtdia1 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia2.'%" AND status="1"');
$olvtdia2 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia3.'%" AND status="1"');
$olvtdia3 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia4.'%" AND status="1"');
$olvtdia4 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia5.'%" AND status="1"');
$olvtdia5 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia6.'%" AND status="1"');
$olvtdia6 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia7.'%" AND status="1"');
$olvtdia7 = ($reservasCount[0]['total']);

//CUENTAS POR DIA RESERVAS CANCELADAS
$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia1.'%" AND status="2"');
$cantdia1 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia2.'%" AND status="2"');
$cantdia2 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia3.'%" AND status="2"');
$cantdia3 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia4.'%" AND status="2"');
$cantdia4 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia5.'%" AND status="2"');
$cantdia5 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia6.'%" AND status="2"');
$cantdia6 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia7.'%" AND status="2"');
$cantdia7 = ($reservasCount[0]['total']);




//CUENTAS POR DIA RESERVAS POR PAGAR
$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia1.'%" AND status="4"');
$portdia1 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia2.'%" AND status="4"');
$portdia2 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia3.'%" AND status="4"');
$portdia3 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia4.'%" AND status="4"');
$portdia4 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia5.'%" AND status="4"');
$portdia5 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia6.'%" AND status="4"');
$portdia6 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia7.'%" AND status="4"');
$portdia7 = ($reservasCount[0]['total']);


?>














