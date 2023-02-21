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


//OBTENER RANGO POR ID
$rol = $db->getAllRecords('roles', 'nombre', ' AND id="' . ($UserData['rol']) . '"LIMIT 1 ')[0]['nombre'];

date_default_timezone_set('America/Mexico_City');
$fecha = date("Y-m-d H:i:s");

setlocale(LC_ALL, 'es_MX');
$mesr = strftime("%m");
$anor = strftime("%Y");

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

    if (($nombre == "") or ($descripcion == "") or ($capacidad == "") or ($precio == "") or ($categoria == "")) {
        setcookie("msg", "basic", time() + 2, "/");
        header('location:/admin/tour');
        exit;
    } else if (($_FILES['thumb']['tmp_name']) == "") {
        setcookie("msg", "foto", time() + 2, "/");
        header('location:/admin/tour');
        exit;
    } else {


        if (!empty($_FILES['thumb']['tmp_name'])) {

            $thumb = $_FILES['thumb']['tmp_name']; //DEFINIMOS LA VARIABLE THUMB YA SABEMOS QUE SI SE CARGÓ UNA FOTO

            if ($_FILES['thumb']['type'] !== 'image/jpeg') {
                setcookie("msg", "fnv", time() + 2, "/");
                header('location:/admin/nuevo/tour');
                exit;
            }

            if (($_FILES['thumb']['size']) > 1500000) {
                setcookie("msg", "fnvz", time() + 2, "/");
                header('location:/admin/nuevo/tour');
                exit;
            }

            $codigo = GeraHash(10); //LO USAMOS PARA EL NOMBRE DE LA FOTO

            $ruta = '../../upload/tours/' . $anor . '/' . $mesr . '';


            //SI LA CARPETA NO EXISTE LA CREAMOS
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true);
            }

            //SUBIMOS LA FOTO EN LA CARPETA EXISTENTE O LA CREADA
            $archivo_subido = '' . $ruta . '/' . $codigo . '.jpg';
            move_uploaded_file($thumb, $archivo_subido);
        }



        $casasCount    =    $db->getQueryCount('tours', 'id');
        if ($casasCount[0]['total'] < 1000) {
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
                'fr' => $fecha,
                'incluyeCount' => $numIncluye,
                'restCount' => $numRest,
                'recoCount' => $numReco,
            );
            $insert    =    $db->insert('tours', $data);
            $lastId =   $pdo->lastInsertId(); //OBTENEMOS EL ID DEL TOUR INCERTADO AL MOMENTO


            if (isset($_REQUEST['incluye'])) {
                if (is_array($_REQUEST['incluye'])) {

                    $conteo = 0;
                    foreach ($_REQUEST['incluye'] as $check) {

                        if ($conteo < $numIncluye)

                            $data    =    array(
                                'tour' => $lastId,
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
                                'tour' => $lastId,
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
                                'tour' => $lastId,
                                'reco' => $check,
                            );
                        $insert    =    $db->insert('umRecoentour', $data);

                        $conteo++;
                    }
                }
            }


            if ($insert) {
                setcookie("msg", "tourok", time() + 2, "/");
                header('location:/admin/tours');
                exit;
            } else {
                setcookie("msg", "ups", time() + 2, "/");
                header('location:/'); //sin cambios
                exit;
            }
        } else {
            setcookie("msg", "prodlim", time() + 2, "/");
            header('location:/'); //limite
            exit;
        }
    }
}
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
    <link rel="stylesheet" href="/admin/assets/bundles/jquery-selectric/selectric.css">
    <link rel="stylesheet" href="/admin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="/admin/assets/css/style.css">
    <link rel="stylesheet" href="/admin/assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="/admin/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='/admin/assets/img/favicon.ico' />
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
                            <i data-feather="layers"></i>
                        </li>
                        <li class="breadcrumb-item active">Agregar nuevo tour</li>
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
                                    <h4>Redactar nuevo tour</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nombre*</label>
                                                    <input name="nombre" class="form-control" type="text" required>
                                                    <div class="invalid-feedback">
                                                        Por favor ingresa nombre del tour.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Info Inglés -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nombre en inglés*</label>
                                                    <input name="nombre_ingles" class="form-control" type="text" required>
                                                    <div class="invalid-feedback">
                                                        Por favor ingresa nombre del tour.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Categoria*</label>
                                                    <select name="categoria" class="form-control selectric" required>
                                                        <option selected disabled>Selecciona una categoría</option>
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
                                                    <input name="capacidad" class="form-control" type="number" required>
                                                    <div class="invalid-feedback">
                                                        Ingresa la capacidad.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Duración (En horas)</label>
                                                    <input name="duracion" class="form-control" type="number" required>
                                                    <div class="invalid-feedback">
                                                        Ingresa la duracion.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Precio adulto</label>
                                                    <input name="precio" class="form-control" type="number" step="any" required>
                                                    <div class="invalid-feedback">
                                                        Ingresa precio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Precio adulto promo</label>
                                                    <input name="precioPromo" class="form-control" type="number" step="any" required>
                                                    <div class="invalid-feedback">
                                                        Ingresa precio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Precio niño</label>
                                                    <input name="precioNi" class="form-control" type="number" step="any" required>
                                                    <div class="invalid-feedback">
                                                        Ingresa precio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Precio niño promo</label>
                                                    <input name="precioNiPromo" class="form-control" type="number" step="any" required>
                                                    <div class="invalid-feedback">
                                                        Ingresa precio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-9 col-md-6">
                                                <div class="form-group">
                                                    <label>Descripción*</label>
                                                    <textarea id="mytextarea" name="descripcion" class="form-control" cols="5" rows="2" required></textarea>
                                                    <div class="invalid-feedback">
                                                        Por favor ingresa la descripción.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Descripción en Inglés -->
                                            <div class="col-lg-9 col-md-6">
                                                <div class="form-group">
                                                    <label>Descripción en Inglés*</label>
                                                    <textarea id="mytextarea2" name="descripcion_ingles" class="form-control" cols="5" rows="2" required></textarea>
                                                    <div class="invalid-feedback">
                                                        Por favor ingresa la descripción.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group">
                                                    <label>Imagen de portada*</label>
                                                    <div class="col-sm-12 col-md-7">
                                                        <div id="image-preview" class="image-preview">
                                                            <label for="image-upload" id="image-label">Cargar imágen</label>
                                                            <input required type="file" name="thumb" id="image-upload">
                                                            <div class="invalid-feedback">
                                                                Esto es obligatorio
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="section-title mt-0">Incluye</div>
                                                    <div class="custom-control custom-checkbox">
                                                        <?php
                                                        $incluyeData = $db->getAllRecords('toursIncluye', '*', ' ORDER BY descripcion ASC');
                                                        if (count($incluyeData) > 0) {
                                                            $y    =    '';
                                                            foreach ($incluyeData as $incluye) {
                                                                $y++; ?>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input value="<?php echo ($incluye['id']); ?>" name="incluye[]" type="checkbox" class="custom-control-input" id="incl-<?php echo ($incluye['id']); ?>">
                                                                    <label class="custom-control-label" for="incl-<?php echo ($incluye['id']); ?>"><?php echo ($incluye['descripcion']); ?></label>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="section-title mt-0">Recomendaciones</div>
                                                    <div class="custom-control custom-checkbox">
                                                        <?php
                                                        $recoData = $db->getAllRecords('toursReco', '*', ' ORDER BY descripcion ASC');
                                                        if (count($recoData) > 0) {
                                                            $y    =    '';
                                                            foreach ($recoData as $reco) {
                                                                $y++; ?>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input value="<?php echo ($reco['id']); ?>" name="reco[]" type="checkbox" class="custom-control-input" id="reco-<?php echo ($reco['id']); ?>">
                                                                    <label class="custom-control-label" for="reco-<?php echo ($reco['id']); ?>"><?php echo ($reco['descripcion']); ?></label>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="section-title mt-0">Restricciones</div>
                                                    <div class="custom-control custom-checkbox">
                                                        <?php
                                                        $restData = $db->getAllRecords('toursRest', '*', ' ORDER BY descripcion ASC');
                                                        if (count($restData) > 0) {
                                                            $y    =    '';
                                                            foreach ($restData as $rest) {
                                                                $y++; ?>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input value="<?php echo ($rest['id']); ?>" name="rest[]" type="checkbox" class="custom-control-input" id="rest-<?php echo ($rest['id']); ?>">
                                                                    <label class="custom-control-label" for="rest-<?php echo ($rest['id']); ?>"><?php echo ($rest['descripcion']); ?></label>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-lg" value="submit" name="submit" type="submit">Enviar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                    </div>

                </section>
            </div>

            <footer class="main-footer">
                <div class="footer-left">Copyright &copy; 2020 <div class="bullet"></div> Creado por <a target="_blank" href="http://bananagroup.mx">Banana Group</a></div>
                <div class="footer-right"></div>
            </footer>

        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="/admin/assets/js/app.min.js"></script>
    <!-- JS Libraies -->
    <script src="/admin/assets/bundles/summernote/summernote-bs4.js"></script>
    <script src="/admin/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
    <script src="/admin/assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
    <script src="/admin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="/admin/assets/js/page/create-post.js"></script>
    <!-- Template JS File -->
    <script src="/admin/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="/admin/assets/js/custom.js"></script>

    <script src="https://cdn.tiny.cloud/1/m5ug66f7s0shi1wbuoq6bdea4aeasit12v3eohxa2w823qzg/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#mytextarea',
        });
        tinymce.init({
            selector: '#mytextarea2',
        });
    </script>


</div>

</body>

</html>