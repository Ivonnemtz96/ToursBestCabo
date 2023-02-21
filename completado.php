<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/funciones.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$fecha = date("Y-m-d H:i:s");



if (isset($_REQUEST['tokenPed']) and $_REQUEST['tokenPed'] != "") {
    extract($_REQUEST);

    $pedidoAbierto = $db->getAllRecords('pedidos', '*', 'AND codigo="' . ($_REQUEST['tokenPed']) . '" AND status=1 LIMIT 1');

    if (!empty($pedidoAbierto)) {

        //SI EXISTE, TOMAMOS TODA SU INFORMACIÓN
        $pedidoAbierto = $pedidoAbierto[0];

        $tourSel = $db->getAllRecords('tours', '*', 'AND id=' . $pedidoAbierto['tour'] . '', 'LIMIT 1');
        $tourSel = $tourSel[0];

        $data    =    array(
            'namePaypal' => $name,
            'emailPaypal' => $email,
            'idTransPaypal' => $idTran,
            'idChekOutPaypal' => $idChekOut,
            'timePaypal' => $time,
            'amountPaypal' => $amount,
            'currencyPaypal' => $currency,
            'status' => 3,

        );
        $update    =    $db->update('pedidos', $data, array('id' => ($pedidoAbierto['id'])));
        if ($update) {

            require_once($_SERVER["DOCUMENT_ROOT"]."/include/mailCompletado.php");
            //require_once($_SERVER["DOCUMENT_ROOT"]."/include/mailCompletadoAmin.php");

            header('location:/completado/?tokenPed=' . $pedidoAbierto['codigo'] . ''); //Exito en el cmabio
            exit;
        } else {
            setcookie("msg", "errgra", time() + 2, "/");
            header('location:/');
            exit;
        }
    } else {

        $pedidoSel = $db->getAllRecords('pedidos', '*', 'AND codigo="' . ($_REQUEST['tokenPed']) . '" AND status=3 LIMIT 1');
        $pedidoSel = $pedidoSel[0];

        $tourSel = $db->getAllRecords('tours', '*', 'AND id="' . $pedidoSel['tour'] . '"', 'LIMIT 1');

        //SI NO HAY ID EN EL GET MANDA ERROR
        if (!($tourSel)) {
            setcookie("msg", "toursel", time() + 2, "/");
            header('location:/tours');
            exit;
        }

        $tourSel = $tourSel[0];

        //Calculamos total a pagar segun numero de adultos y menores
        $total = ($tourSel['precioPromo']) * ($pedidoSel['adultos']);
        $total += ($tourSel['precioNiPromo']) * ($pedidoSel['menores']);

        $personas = ($pedidoSel['adultos']) + ($pedidoSel['menores']);
    }
} else {
    setcookie("msg", "ups", time() + 2, "/");
    header('location:/');
    exit;
}
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
        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/modulos/top.php"); ?>
        <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/modulos/menu.php"); ?>
    </header>



    <section class="trending pt-6 pb-0 bg-lgrey">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-5 mb-4 ps-ld-4">
                    <div class="sidebar-sticky">
                        <div class="sidebar-item bg-white rounded box-shadow overflow-hidden p-3 mb-4">

                            <div class="trend-full border-b pb-2 mb-2">
                                <div class="row">
                                    <div class="col-md-12 mb-4 blog-single">
                                        <div class="blog-quote  rounded">
                                            <p class="white">¡Pedido pagado! </p>
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div style="height: 250px;" class="trend-item2 rounded">
                                            <a href="" style="background-image: url(/upload/tours/<?php echo (strftime("%Y/%m", strtotime(($tourSel['fr'])))); ?>/<?php echo ($tourSel['fPortada']) ?>.jpg);"></a>
                                            <div class="color-overlay"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-8 mt-4">
                                        <div class="trend-content position-relative">

                                            <h5 class="mb-1"><a href="#"><?php echo ($tourSel['nombre']) ?></a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="trend-check border-b pb-2 mb-2">
                                <p class="mb-0">Su selección:</p>
                                <h6 class="mb-0">Personas <span class="float-end fw-normal"><?php echo $pedidoSel['adultos']; ?> adultos, <?php echo $pedidoSel['menores']; ?> niños</span> </h6>

                                <h6 class="mb-0">Fecha: <span class="float-end fw-normal"><?php echo (strftime("%d de %B del %G", strtotime($pedidoSel['fv']))); ?></span> </h6>

                            </div>
                            <div class="trend-check border-b pb-2 mb-2">
                                <p class="mb-0">Sus datos:</p>
                                <h6 class="mb-0">Nombre <span class="float-end fw-normal"><?php echo $pedidoSel['nombre']; ?></h6>
                                <h6 class="mb-0">Correo electrónico: <span class="float-end fw-normal"><?php echo $pedidoSel['email']; ?></span> </h6>
                                <h6 class="mb-0">Teléfono: <span class="float-end fw-normal"><?php echo $pedidoSel['telefono']; ?></span> </h6>
                            </div>
                        </div>
                        <div class="sidebar-item bg-white rounded box-shadow overflow-hidden p-3 mb-4">
                            <h4>Costos</h4>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Total</td>
                                        <td class="theme2">$<?php echo number_format($total, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Personas</td>
                                        <td class="theme2"><?php echo $personas; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Impuestos</td>
                                        <td class="theme2">$<?php echo number_format(($total * 0.04), 2); ?></td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-title">
                                    <tr>
                                        <th class="font-weight-bold white">Total</th>
                                        <th class="font-weight-bold white">$<?php echo number_format(($total * 1.04), 2); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-4" id="paypal-button-container"></div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/modulos/footer.php"); ?>


    <div id="back-to-top">
        <a href="#"></a>
    </div>

    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/modulos/js.php"); ?>



</body>


</html>