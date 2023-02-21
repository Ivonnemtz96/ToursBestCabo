<?php
    include('indexcontroller.php');
    require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



date_default_timezone_set('America/Mazatlan');
setlocale(LC_ALL, 'es_MX');

//SI NO HAY ID EN EL GET MANDA ERROR
if (!isset($_REQUEST['id'])) {

    echo "ERROR 10";
    exit();
}


$tour =    $db->getAllRecords('tours', '*', ' AND id="' . $_REQUEST['id'] . '"LIMIT 1 ');

//SI NO HAY ID EN EL GET MANDA ERROR
if (!($tour)) {
    echo "ERROR 20";
    exit();
}

$tour = $tour[0];
//SACAMOS LA CATEGORIA DE ESTE TOUR
$catSel = $db->getAllRecords('toursCate', '*', 'AND id=' . $tour['categoria'] . '', 'LIMIT 1')[0];


//SUMAMOS +1 A LAS IMPRECIONES DEL ANUNCIO
$SumImpreciones = (($tour['vistas']) + 1);

$InsertData    =    array(
    'vistas' => $SumImpreciones,
);
$update     =  $db->update('tours', $InsertData, array('id' => ($tour['id']))); //ACTUALIZAMOS LAS IMPRECIONES

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cabo Cheap Tours</title>

    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/modulos/css.php"); ?>

</head>

<body>

    <div id="preloader">
        <div id="status"></div>
    </div>


    <header class="main_header_area">
        <?php require_once($lenguaje . "/top.php"); ?>
        <?php require_once($lenguaje. "/menu.php"); ?>
    </header>


    <?php include($lenguaje.'/tour-individual.php'); ?>
    


    <?php require_once($lenguaje . "/footer.php"); ?>


    <div id="back-to-top">
        <a href="#"></a>
    </div>

    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/modulos/js.php"); ?>

</body>


</html>