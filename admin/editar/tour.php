<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/admin/modulos/sesion.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/include/funciones.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (($UserData['rol']) > 2) {
    setcookie("msg", "sad", time() + 2, "/");
    header('Location: /');
}

if (isset($_REQUEST['editId']) and $_REQUEST['editId'] != "") {
    $tour  =  $db->getAllRecords('tours', '*', ' AND id="' . $_REQUEST['editId'] . '"LIMIT 1');
}

if (empty($tour)) { //SI NO EXISTE ES QUE NO HAY UN ID DE VÁLIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
    setcookie("msg", "notour", time() + 2, "/");
    header('location:/admin/tours');
    exit;
}

$tour  =  $tour[0]; //PASAMOS LOS PRIMEROS 2 FILTROS Y SI TENEMOS UNA UNIDAD VÁLIDA SELECCIONADA 

//OBTENER RANGO POR ID
$rol = $db->getAllRecords('roles', '*', ' AND id="' . ($UserData['rol']) . '"LIMIT 1 ');
$rol = $rol[0]['nombre'];

date_default_timezone_set('America/Tijuana');
$fecha = date("Y-m-d H:i:s");

setlocale(LC_ALL, 'es_MX');

$numIncluye = 0;
$numRest = 0;
$numReco = 0;

if (isset($_REQUEST['incluye'])) {
    $numIncluye = count($_REQUEST['incluye']);
}

if (isset($_REQUEST['rest'])) {
    $numRest = count($_REQUEST['rest']);
}

if (isset($_REQUEST['reco'])) {
    $numReco = count($_REQUEST['reco']);
}


if (isset($_REQUEST['submit']) and $_REQUEST['submit'] != "") {
    extract($_REQUEST);

    if (($nombre == "") or ($descripcion == "") or ($capacidad == "") or ($duracion == "")) {
        setcookie("msg", "basic", time() + 2, "/");
        header('location: ');
        exit;
    } else {



        $codigo = ($tour['fPortada']); //SI NO SE SUBE LA FOTO LE DAMOS EL VALOR EXISTENTE QUE YA ESTÁ EN NUESTRA BASE DE DATOS

        if (!empty($_FILES['thumb']['tmp_name'])) {

            //A ESTE PUNTO SABEMOS QUE SI SUBIÓ UNA FOTO NUEVA, ENTONCES DEBEMOS BORRAR LA EXISTENTE
            if (isset($tour['fPortada'])) {
                $archivo = '../../upload/tours/' . (strftime("%Y/%m", strtotime(($tour['fr'])))) . '/' . ($tour['fPortada']) . '.jpg';
                unlink($archivo); //BORRAMOS LA FOTO ANTIGUA SACANDO EL NOMBRE DE LA BASE DE DATOS
            }

            $thumb = $_FILES['thumb']['tmp_name']; //DEFINIMOS LA VARIABLE THUMB YA SABEMOS QUE SI SE CARGÓ UNA FOTO

            if ($_FILES['thumb']['type'] !== 'image/jpeg') {
                setcookie("msg", "fnv", time() + 2, "/");
                header('location:/admin/editar/tour?editId=' . $_REQUEST['editId'] . '');
                exit;
            }

            if (($_FILES['thumb']['size']) > 1000000) {
                setcookie("msg", "fnvz", time() + 2, "/");
                header('location:/admin/editar/tour?editId=' . $_REQUEST['editId'] . '');
                exit;
            }

            $codigo = GeraHash(10); //LO USAMOS PARA EL NOMBRE DE LA FOTO

            $ruta = '../../upload/tours/' . (strftime("%Y/%m", strtotime(($tour['fr'])))) . '';


            //SI LA CARPETA NO EXISTE LA CREAMOS
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true);
            }

            //SUBIMOS LA FOTO EN LA CARPETA EXISTENTE O LA CREADA
            $archivo_subido = '' . $ruta . '/' . $codigo . '.jpg';
            move_uploaded_file($thumb, $archivo_subido);
        }


        if (isset($_REQUEST['submit']) and $_REQUEST['submit'] != "") {
            extract($_REQUEST);
            $data    =    array(
                'nombre' => $nombre,
                'nombre_ingles' => $nombre_ingles,
                'descripcion' => $descripcion,
                'descripcion_ingles' => $descripcion_ingles,
                'capacidad' => $capacidad,
                'categoria' => $categoria,
                'duracion' => $duracion,
                'precio' => $precio,
                'precioPromo' => $precioPromo,
                'precioNi' => $precioNi,
                'precioNiPromo' => $precioNiPromo,
                'fPortada' => $codigo,
                'fa' => $fecha,
                'incluyeCount' => ($tour['incluyeCount']) + ($numIncluye),
                'restCount' => ($tour['restCount']) + ($numRest),
                'recoCount' => ($tour['recoCount']) + ($numReco),
            );
            $update    =    $db->update('tours', $data, array('id' => ($_REQUEST['editId'])));



            if (isset($_REQUEST['incluye'])) {
                if (is_array($_REQUEST['incluye'])) {

                    $conteo = 0;
                    foreach ($_REQUEST['incluye'] as $check) {

                        if ($conteo < $numIncluye)

                            $data    =    array(
                                'tour' => $tour['id'],
                                'incluye' => $check,
                            );
                        $insert    =    $db->insert('umIncluyeentour', $data);

                        $conteo++;
                    }
                }
            }

            if (isset($_REQUEST['rest'])) {
                if (is_array($_REQUEST['rest'])) {

                    $conteo = 0;
                    foreach ($_REQUEST['rest'] as $check) {

                        if ($conteo < $numRest)

                            $data    =    array(
                                'tour' => $tour['id'],
                                'rest' => $check,
                            );
                        $insert    =    $db->insert('umRestentour', $data);

                        $conteo++;
                    }
                }
            }

            if (isset($_REQUEST['reco'])) {
                if (is_array($_REQUEST['reco'])) {

                    $conteo = 0;
                    foreach ($_REQUEST['reco'] as $check) {

                        if ($conteo < $numReco)

                            $data    =    array(
                                'tour' => $tour['id'],
                                'reco' => $check,
                            );
                        $insert    =    $db->insert('umRecoentour', $data);

                        $conteo++;
                    }
                }
            }

            if ($update) {
                setcookie("msg", "produp", time() + 2, "/");
                header('location:/admin/editar/tour?editId=' . $_REQUEST['editId'] . ''); //Exito en el cmabio
                exit;
            } else {
                setcookie("msg", "ups", time() + 2, "/");
                header('location:/admin/editar/tour?editId=' . $_REQUEST['editId'] . ''); //sin cambios
                exit;
            }
        }
    }
}

//OBTENER EL CATEGORIA POR ID
$catSel = $db->getAllRecords('toursCate', '*', 'AND id="' . ($tour['categoria']) . '"LIMIT 1 ');
$catSel = $catSel[0];

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/admin/modulos/title.php"); ?>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="/admin/assets/css/app.min.css">
    <link rel="stylesheet" href="/admin/assets/bundles/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/admin/assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="/admin/assets/bundles/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/admin/assets/bundles/jquery-selectric/selectric.css">
    <link rel="stylesheet" href="/admin/assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="/admin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="/admin/assets/css/style.css">
    <link rel="stylesheet" href="/admin/assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="/admin/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='/admin/assets/img/favicon.ico' />

    <style>
        .responsive {
            width: 100%;
            height: auto;
        }
    </style>


</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>


            <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/admin/modulos/navUser.php"); ?>
            <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/admin/modulos/menu-principal.php"); ?>


            <!-- Main Content -->
            <div class="main-content">
                <section class="section">

                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <a href="/admin">
                                <h4 class="page-title m-b-0">Panel de control</h4>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i data-feather="edit"></i>
                        </li>
                        <li class="breadcrumb-item active">Editar tour</li>
                    </ul>

                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <?php
                            //MENSAJES DE ESTATUS
                            if (isset($_COOKIE["msg"])) {
                                require_once($_SERVER["DOCUMENT_ROOT"] . "/include/msg.php");
                            } ?>
                        </div>
                    </div>



                    <div class="row">



                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Información básica - Tour - <?php echo ($tour['nombre']) ?></h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nombre*</label>
                                                    <input name="nombre" class="form-control" type="text" value="<?php echo ($tour['nombre'])?>" required>
                                                    <div class="invalid-feedback">
                                                        Por favor ingresa nombre del tour.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nombre en inglés*</label>
                                                    <input name="nombre_ingles" class="form-control" type="text" value="<?php echo ($tour['nombre_ingles'])?>" required>
                                                    <div class="invalid-feedback">
                                                        Por favor ingresa nombre del tour.
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Categoria*</label>
                                                    <select name="categoria" class="form-control selectric" required>
                                                        <option value="<?php echo ($catSel['id']); ?>"><?php echo ($catSel['nombre']); ?></option>
                                                        <?php
                                                        $catData = $db->getAllRecords('toursCate', '*', ' ORDER BY nombre ASC');
                                                        if (count($catData) > 0) {
                                                            $y    =    '';
                                                            foreach ($catData as $categoria) {
                                                                $y++; ?>
                                                                <option value="<?php echo ($categoria['id']); ?>"><?php echo ($categoria['nombre']); ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Capacidad (Personas)</label>
                                                    <input name="capacidad" class="form-control" type="number" value="<?php echo ($tour['capacidad'])?>"  required>
                                                    <div class="invalid-feedback">
                                                        Ingresa la capacidad.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Duración (En horas)</label>
                                                    <input name="duracion" class="form-control" type="number" value="<?php echo ($tour['duracion'])?>"  required>
                                                    <div class="invalid-feedback">
                                                        Ingresa la duracion.
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Precio adulto</label>
                                                    <input name="precio" class="form-control" type="text" value="<?php echo ($tour['precio'])?>"  required>
                                                    <div class="invalid-feedback">
                                                        Ingresa precio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Precio adulto promo</label>
                                                    <input name="precioPromo" class="form-control" type="text" value="<?php echo ($tour['precioPromo'])?>"  required>
                                                    <div class="invalid-feedback">
                                                        Ingresa precio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Precio niño</label>
                                                    <input name="precioNi" class="form-control" type="text" value="<?php echo ($tour['precioNi'])?>"  required>
                                                    <div class="invalid-feedback">
                                                        Ingresa precio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Precio niño promo</label>
                                                    <input name="precioNiPromo" class="form-control" type="text" value="<?php echo ($tour['precioNiPromo'])?>"  required>
                                                    <div class="invalid-feedback">
                                                        Ingresa precio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-6">
                                                <div class="form-group">
                                                    <label>Descripción*</label>
                                                    <textarea name="descripcion" class="form-control mytextarea" cols="5" rows="2" required><?php echo ($tour['descripcion']) ?></textarea>
                                                    <div class="invalid-feedback">
                                                        Por favor ingresa la descripción.
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- Descripción inglés -->
                                            <div class="col-lg-9 col-md-6">
                                                <div class="form-group">
                                                    <label>Descripción en inglés*</label>
                                                    <textarea name="descripcion_ingles" class="form-control mytextarea" cols="5" rows="2" required><?php echo ($tour['descripcion_ingles']) ?></textarea>
                                                    <div class="invalid-feedback">
                                                        Por favor ingresa la descripción.
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group">
                                                    <label>Imagen de portada actual</label>
                                                    <div class="col-sm-12 col-md-7">
                                                        <img class="responsive" src="/upload/tours/<?php echo (strftime("%Y/%m", strtotime(($tour['fr'])))); ?>/<?php echo ($tour['fPortada']) ?>.jpg" alt="">
                                                        <div>
                                                            <label for="image-upload" id="image-label">Para reemplazar la portada actual sube una nueva foto</label>
                                                            <input type="file" name="thumb" id="image-upload" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="section-title mt-0">¿Qué Incluye? seleccionados (<?php echo ($tour['incluyeCount']); ?>)</div>
                                                    <div class="custom-control custom-checkbox">
                                                        <ul>
                                                            <?php
                                                            $carSelData = $db->getAllRecords('umIncluyeentour', '*', ' AND tour="' . $tour['id'] . '"', 'LIMIT ' . ($tour['incluyeCount']) . '');
                                                            if (count($carSelData) > 0) {
                                                                $y    =    '';
                                                                foreach ($carSelData as $carSel) {
                                                                    $y++;
                                                                    $carInd = $db->getAllRecords('toursIncluye', '*', ' AND id="' . ($carSel['incluye']) . '"', 'LIMIT 1');
                                                                    $carInd = $carInd[0];
                                                            ?>


                                                                    <li><?php echo ($carInd['descripcion']); ?>
                                                                        <a href="/admin/borrar/car-incluye-tour?delId=<?php echo ($carSel['id']); ?>"><i class="fa fa-remove"></i> Borrar</a>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="section-title mt-0">Agregar más ¿Qué Incluye? (Opcional)</div>
                                                    <div class="custom-control custom-checkbox">
                                                        <?php $carData = $db->getAllRecords('toursIncluye', '*', 'ORDER BY descripcion ASC');
                                                        if (count($carData) > 0) {
                                                            $y = '';
                                                            foreach ($carData as $carac) {
                                                                $y++;

                                                                //VERIFICAMOS LAS CARACTERISTICA QUE VAMOS A EXCLUIR
                                                                $caracExData = $db->getAllRecords('umIncluyeentour', '*', 'AND tour=' . $tour['id'] . '', 'AND incluye=' . ($carac['id']) . '', 'LIMIT 1');

                                                                if (!($caracExData)) {
                                                        ?>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input value="<?php echo ($carac['id']); ?>" name="incluye[]" type="checkbox" class="custom-control-input" id="incluye-<?php echo ($carac['id']); ?>">
                                                                        <label class="custom-control-label" for="incluye-<?php echo ($carac['id']); ?>"><?php echo ($carac['descripcion']); ?></label>
                                                                    </div>

                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="section-title mt-0">Recomendaciones seleccionadas (<?php echo ($tour['recoCount']); ?>)</div>
                                                    <div class="custom-control custom-checkbox">
                                                        <ul>
                                                            <?php
                                                            $carSelData = $db->getAllRecords('umRecoentour', '*', ' AND tour="' . $tour['id'] . '"', 'LIMIT ' . ($tour['recoCount']) . '');
                                                            if (count($carSelData) > 0) {
                                                                $y    =    '';
                                                                foreach ($carSelData as $carSel) {
                                                                    $y++;
                                                                    $carInd = $db->getAllRecords('toursReco', '*', ' AND id="' . ($carSel['reco']) . '"', 'LIMIT 1');
                                                                    $carInd = $carInd[0];
                                                            ?>


                                                                    <li><?php echo ($carInd['descripcion']); ?>
                                                                        <a href="/admin/borrar/car-reco-tour?delId=<?php echo ($carSel['id']); ?>"><i class="fa fa-remove"></i> Borrar</a>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="section-title mt-0">Agregar más Recomendaciones (Opcional)</div>
                                                    <div class="custom-control custom-checkbox">
                                                        <?php $carData = $db->getAllRecords('toursReco', '*', 'ORDER BY descripcion ASC');
                                                        if (count($carData) > 0) {
                                                            $y = '';
                                                            foreach ($carData as $carac) {
                                                                $y++;

                                                                //VERIFICAMOS LAS CARACTERISTICA QUE VAMOS A EXCLUIR
                                                                $caracExData = $db->getAllRecords('umRecoentour', '*', 'AND tour=' . $tour['id'] . '', 'AND reco=' . ($carac['id']) . '', 'LIMIT 1');

                                                                if (!($caracExData)) {
                                                        ?>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input value="<?php echo ($carac['id']); ?>" name="reco[]" type="checkbox" class="custom-control-input" id="reco-<?php echo ($carac['id']); ?>">
                                                                        <label class="custom-control-label" for="reco-<?php echo ($carac['id']); ?>"><?php echo ($carac['descripcion']); ?></label>
                                                                    </div>

                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="section-title mt-0">Restricciones seleccionadas (<?php echo ($tour['restCount']); ?>)</div>
                                                    <div class="custom-control custom-checkbox">
                                                        <ul>
                                                            <?php
                                                            $carSelData = $db->getAllRecords('umRestentour', '*', ' AND tour="' . $tour['id'] . '"', 'LIMIT ' . ($tour['restCount']) . '');
                                                            if (count($carSelData) > 0) {
                                                                $y    =    '';
                                                                foreach ($carSelData as $carSel) {
                                                                    $y++;
                                                                    $carInd = $db->getAllRecords('toursRest', '*', ' AND id="' . ($carSel['rest']) . '"', 'LIMIT 1');
                                                                    $carInd = $carInd[0];
                                                            ?>


                                                                    <li><?php echo ($carInd['descripcion']); ?>
                                                                        <a href="/admin/borrar/car-rest-tour?delId=<?php echo ($carSel['id']); ?>"><i class="fa fa-remove"></i> Borrar</a>
                                                                    </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="section-title mt-0">Agregar más Restricciones (Opcional)</div>
                                                    <div class="custom-control custom-checkbox">
                                                        <?php $carData = $db->getAllRecords('toursRest', '*', 'ORDER BY descripcion ASC');
                                                        if (count($carData) > 0) {
                                                            $y = '';
                                                            foreach ($carData as $carac) {
                                                                $y++;

                                                                //VERIFICAMOS LAS CARACTERISTICA QUE VAMOS A EXCLUIR
                                                                $caracExData = $db->getAllRecords('umRestentour', '*', 'AND tour=' . $tour['id'] . '', 'AND rest=' . ($carac['id']) . '', 'LIMIT 1');

                                                                if (!($caracExData)) {
                                                        ?>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input value="<?php echo ($carac['id']); ?>" name="rest[]" type="checkbox" class="custom-control-input" id="rest-<?php echo ($carac['id']); ?>">
                                                                        <label class="custom-control-label" for="rest-<?php echo ($carac['id']); ?>"><?php echo ($carac['descripcion']); ?></label>
                                                                    </div>

                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Guardar</button>
                                        <a href="/admin/tours" type="button" class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-arrow-alt-circle-left"></i> Volver
                                        </a>
                                        <a href="/admin/nuevo/horario-tour?tourId=<?php echo $tour['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                            <i class="far fa-clock"></i> Horarios
                                            <span class="badge badge-transparent"><?php echo ($tour['horariosCount']) ?></span>
                                        </a>
                                        <a href="/admin/nuevo/dias-tour?tourId=<?php echo $tour['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                            <i class="far fa-calendar-alt"></i> Días
                                            <span class="badge badge-transparent"><?php echo ($tour['diasCount']) ?></span>
                                        </a>
                                        <a href="/admin/nuevo/itinerario-tour?tourId=<?php echo $tour['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                            <i class="far fa-list-alt"></i> Itinerario
                                            <span class="badge badge-transparent"><?php echo ($tour['itinerarioCount']) ?></span>
                                        </a>

                                        <a target="_blank" href="/tour/<?php echo $tour['id']; ?>" class="btn btn-icon btn-info"><i class="fas fa-eye"></i></a>

                                    </form>
                                </div>
                            </div>
                        </div>





                    </div>

                </section>
                <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/admin/modulos/settings.php"); ?>
            </div>

            <footer class="main-footer">
                <div class="footer-left">Copyright &copy; 2020 <div class="bullet"></div> Creado por <a target="_blank" href="http://bananagroup.mx">Banana Group</a></div>
                <div class="footer-right"></div>
            </footer>

        </div>
    </div>


    <script src="https://cdn.tiny.cloud/1/m5ug66f7s0shi1wbuoq6bdea4aeasit12v3eohxa2w823qzg/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '.mytextarea'
        });
    </script>

    <!-- General JS Scripts -->
    <script src="/admin/assets/js/app.min.js"></script>
    <!-- JS Libraies -->
    <script src="/admin/assets/bundles/summernote/summernote-bs4.js"></script>
    <script src="/admin/assets/bundles/cleave-js/dist/cleave.min.js"></script>
    <script src="/admin/assets/bundles/cleave-js/dist/addons/cleave-phone.us.js"></script>
    <script src="/admin/assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
    <script src="/admin/assets/bundles/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/admin/assets/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="/admin/assets/bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="/admin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="/admin/assets/bundles/select2/dist/js/select2.full.min.js"></script>
    <script src="/admin/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="/admin/assets/js/page/create-post.js"></script>
    <!-- Template JS File -->
    <script src="/admin/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="/admin/assets/js/custom.js"></script>

    <script>
        function closeAlert() {
            document.getElementById("alert").style.display = "none";
        }
    </script>

    



</body>

</html>