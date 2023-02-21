<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


date_default_timezone_set('America/Mazatlan');
setlocale(LC_ALL, 'es_MX');



if (isset($_REQUEST['submit'])) {
    extract($_REQUEST);



    if (($fv == "") & ($adultos == "") & ($tour == "")) {
        setcookie("msg", "all", time() + 2, "/");
        header('location:/tour.php?id=' . $tour . '');
        exit;
    } else if ($fv == "") {
        setcookie("msg", "fevnov", time() + 2, "/");
        header('location:/tour.php?id=' . $tour . '');
        exit;
    } else if ($tour == "") {
        setcookie("msg", "toursel", time() + 2, "/");
        header('location:/tour.php?id=' . $tour . '');
        exit;
    } else if (($adultos == "0") or ($adultos == "")) {
        setcookie("msg", "adnov", time() + 2, "/");
        header('location:/tour.php?id=' . $tour . '');
        exit;
    } else {

        $tourSel = $db->getAllRecords('tours', '*', 'AND id=' . $tour . '', 'LIMIT 1');

        //SI NO HAY ID EN EL GET MANDA ERROR
        if (!($tourSel)) {
            setcookie("msg", "toursel", time() + 2, "/");
            header('location:/tours');
            exit;
        }

        $tourSel = $tourSel[0];


        //Calculamos total a pagar segun numero de adultos y menores
        $total = ($tourSel['precioPromo']) * ($adultos);
        $total += ($tourSel['precioNiPromo']) * ($menores);

        $personas = $adultos + $menores;
    }
} else {
    setcookie("msg", "toursel", time() + 2, "/");
    header('location:/tours');
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

                            <div class="trend-check">
                                <p class="mb-0">Su selección:</p>
                                <h6 class="mb-0">Personas <span class="float-end fw-normal"><?php echo $adultos; ?> adultos, <?php echo $menores; ?> niños</span> </h6>

                                <h6 class="mb-0">Fecha: <span class="float-end fw-normal"><?php echo (strftime("%d de %B del %G", strtotime($fv))); ?></span> </h6>

                            </div>
                        </div>
                        <div class="sidebar-item bg-white rounded box-shadow overflow-hidden p-3 mb-4">
                            <h4>Costos</h4>
                            <table>
                                <tbody>
                                    <tr>
                                        <td> Total</td>
                                        <td class="theme2">$<?php echo number_format($total, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Personas</td>
                                        <td class="theme2">$personas</td>
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

                    </div>
                </div>
                <div class="col-lg-5 mb-4">
                    <div class="payment-book">
                        <div class="booking-box">
                            <div class="customer-information mb-4">
                                <h3 class="border-b pb-2 mb-2">Detalles de reserva</h3>
                                <form action="/pago/" method="post">

                                    <input hidden type="text" name="fv" value="<?php echo $fv; ?>">
                                    <input hidden type="text" name="menores" value="<?php echo $menores; ?>">
                                    <input hidden type="text" name="adultos" value="<?php echo $adultos; ?>">
                                    <input hidden type="text" name="tour" value="<?php echo $tour; ?>">

                                    <h5>Completa el formulario</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-2">
                                                <label>Nombre completo</label>
                                                <input name="nombre" type="text" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-2">
                                                <label>Correo electrónico</label>
                                                <input name="email" type="email" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-2">
                                                <label>Teléfono</label>
                                                <input name="telefono" type="text" placeholder="">
                                            </div>

                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-2">
                                                <label>Comentarios</label>
                                                <textarea name="comentarios" id="" cols="30" rows="10"></textarea>
                                            </div>

                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-2">
                                                <button type="submit" name="submit" value="submit" class="nir-btn float-lg-end w-50">Confirmar Reservar</button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
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