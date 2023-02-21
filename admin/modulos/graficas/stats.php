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
$tdia1 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia2.'%" AND status="3"');
$tdia2 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia3.'%" AND status="3"');
$tdia3 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia4.'%" AND status="3"');
$tdia4 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia5.'%" AND status="3"');
$tdia5 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia6.'%" AND status="3"');
$tdia6 = ($reservasCount[0]['total']);

$reservasCount	=	$db->getQueryCount('pedidos','*','AND fr LIKE "%'.$dia7.'%" AND status="3"');
$tdia7 = ($reservasCount[0]['total']);


        $reservasCount = $db->getAllRecords('pedidos','*','AND fr LIKE "%'.$dia1.'%" AND status="3" LIMIT '.$tdia1.'');
        $totalD1=0;
        if (count($reservasCount)>0){ 
            
            foreach ($reservasCount as $reserva) {
                
                $totalD1+= $reserva['total'];
            } 
        }

        $reservasCount = $db->getAllRecords('pedidos','*','AND fr LIKE "%'.$dia2.'%" AND status="3" LIMIT '.$tdia2.'');
        $totalD2=0;
        if (count($reservasCount)>0){ 
            
            foreach ($reservasCount as $reserva) {
                
                $totalD2+= $reserva['total'];
            } 
        }

        $reservasCount = $db->getAllRecords('pedidos','*','AND fr LIKE "%'.$dia3.'%" AND status="3" LIMIT '.$tdia3.'');
        $totalD3=0;
        if (count($reservasCount)>0){ 
            
            foreach ($reservasCount as $reserva) {
                
                $totalD3+= $reserva['total'];
            } 
        }

        $reservasCount = $db->getAllRecords('pedidos','*','AND fr LIKE "%'.$dia4.'%" AND status="3" LIMIT '.$tdia4.'');
        $totalD4=0;
        if (count($reservasCount)>0){ 
            
            foreach ($reservasCount as $reserva) {
                
                $totalD4+= $reserva['total'];
            } 
        }

        $reservasCount = $db->getAllRecords('pedidos','*','AND fr LIKE "%'.$dia5.'%" AND status="3" LIMIT '.$tdia5.'');
        $totalD5=0;
        if (count($reservasCount)>0){ 
            
            foreach ($reservasCount as $reserva) {
                
                $totalD5+= $reserva['total'];
            } 
        }

        $reservasCount = $db->getAllRecords('pedidos','*','AND fr LIKE "%'.$dia6.'%" AND status="3" LIMIT '.$tdia6.'');
        $totalD6=0;
        if (count($reservasCount)>0){ 
            
            foreach ($reservasCount as $reserva) {
                
                $totalD6+= $reserva['total'];
            } 
        }

        $reservasCount = $db->getAllRecords('pedidos','*','AND fr LIKE "%'.$dia7.'%" AND status="3" LIMIT '.$tdia7.'');
        $totalD7=0;
        if (count($reservasCount)>0){ 
            
            foreach ($reservasCount as $reserva) {
                
                $totalD7+= $reserva['total'];
            } 
        }


        //SUMAS PARA RESERVAS 1 DIAS, 2 DIAS Y 7 DIAS
        $res1=$tdia1;
        $res2=$tdia2;
        $res3=$tdia1+$tdia2+$tdia3+$tdia4+$tdia5+$tdia6+$tdia7;


        //CIFRAS DE RESERVAS PAGADAS 1 DIAS, 2 DIAS Y 7 DIAS
        $cifra1=$totalD1;
        $cifra2=$totalD2;
        $cifra3=$totalD1+$totalD2+$totalD3+$totalD4+$totalD5+$totalD6+$totalD7;
        

?>














