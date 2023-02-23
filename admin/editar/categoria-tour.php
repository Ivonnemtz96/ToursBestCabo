<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

    if (($UserData['rol'])>2) {
        setcookie("msg","sad",time() + 2, "/");
        header('Location: /');
    }

    //Contadores
    $userCount   =  $db->getQueryCount('usuarios','id');
    $tUsuarios   = ($userCount[0]['total']);



    //OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0];
    $rol = ($rol['nombre']);


    if (isset($_REQUEST['editId']) and $_REQUEST['editId']!=""){
    
        $cateSel  =  $db->getAllRecords('toursCate','*',' AND id="'.$_REQUEST['editId'].'"','LIMIT 1');
        
            if (empty($cateSel)) { //SI NO EXISTE ES QUE NO HAY UN ID VALIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
            setcookie("msg","catnoen",time() + 2, "/");
                header('location:/admin/nuevo/categoria-tour');
                exit;
            } else {$cateSel  =  $cateSel [0];}
        
        }else{
            setcookie("msg","catnoen",time() + 2, "/");
            header('location:/admin/nuevo/categoria-tour');
            exit;
        }


if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
	extract($_REQUEST);
    
	if($descripcion=="" && $descripcion_ingles=""){
        setcookie("msg","all",time() + 2, "/");
		header('location:/admin/nuevo/categoria-tour');
		exit;
	}else{


        $codigo = ($cateSel['imagen']); //SI NO SE SUBE LA FOTO LE DAMOS EL VALOR EXISTENTE QUE YA ESTÁ EN NUESTRA BASE DE DATOS

        if (!empty($_FILES['thumb']['tmp_name'])) {
    
            
    
            $thumb = $_FILES['thumb']['tmp_name']; //DEFINIMOS LA VARIABLE THUMB YA SABEMOS QUE SI SE CARGÓ UNA FOTO
    
            if ($_FILES['thumb']['type'] !== 'image/png') {
                setcookie("msg", "fnv", time() + 2, "/");
                header('location:/admin/editar/categoria-tour?editId=' . $_REQUEST['editId'] . '');
                exit;
            }
    
            if (($_FILES['thumb']['size']) > 1000000) {
                setcookie("msg", "fnvz", time() + 2, "/");
                header('location:/admin/editar/categoria-tour?editId=' . $_REQUEST['editId'] . '');
                exit;
            }

            //A ESTE PUNTO SABEMOS QUE SI SUBIÓ UNA FOTO NUEVA, ENTONCES DEBEMOS BORRAR LA EXISTENTE
            if (isset($cateSel['imagen'])) {
                $archivo = '../../upload/categorias/' . (strftime("%Y/%m", strtotime(($cateSel['fr'])))) . '/' . ($cateSel['imagen']) . '.png';
                unlink($archivo); //BORRAMOS LA FOTO ANTIGUA SACANDO EL NOMBRE DE LA BASE DE DATOS
            }
    
            $codigo =  GeraHash(10); //LO USAMOS PARA EL NOMBRE DE LA FOTO
    
            $ruta = '../../upload/categorias/' . (strftime("%Y/%m", strtotime(($cateSel['fr'])))) . '';
    
    
            //SI LA CARPETA NO EXISTE LA CREAMOS
            if (!file_exists($ruta)) {
                mkdir($ruta, 0777, true);
            }
    
            //SUBIMOS LA FOTO EN LA CARPETA EXISTENTE O LA CREADA
            $archivo_subido = '' . $ruta . '/' . $codigo . '.png';
            move_uploaded_file($thumb, $archivo_subido);
        }


        if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
            extract($_REQUEST);
			$data	=	array(
							'nombre'=>$descripcion,
							'nombreIn'=>$descripcion_ingles,
                            'imagen' => $thumb,
						);
	       $update	=	$db->update('toursCate',$data,array('id'=>($_REQUEST['editId'])));
    
            if($update){
                setcookie("msg","carup",time() + 2, "/");
                header('location:/admin/nuevo/categoria-tour'); //Exito en el cmabio
                exit;}
                else{
                    setcookie("msg","sincam",time() + 2, "/");
                    header('location:/admin/nuevo/categoria-tour'); //sin cambios
                    exit;
                }
            }
		// 	$data	=	array(
		// 					'nombre'=>$descripcion,
		// 					'nombreIn'=>$descripcion_ingles,
        //                     'imagen' => $codigo,
		// 				);
	    //    $update	=	$db->update('toursCate',$data,array('id'=>($cateSel['id'])));
    
        //     if($update){
        //         setcookie("msg","carup",time() + 2, "/");
        //         header('location:/admin/nuevo/categoria-tour'); //Exito en el cmabio
        //         exit;}
        //         else{
        //             setcookie("msg","sincam",time() + 2, "/");
        //             header('location:/admin/nuevo/categoria-tour'); //sin cambios
        //             exit;
        //         }
            }
        }

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/title.php");?>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="/admin/assets/css/app.min.css">
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

</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>


            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/navUser.php"); ?>
            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/menu-principal.php"); ?>


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
                            <i data-feather="settings"></i>
                        </li>
                        <li class="breadcrumb-item active">Editar una característica</li>
                    </ul>

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <?php
                    //MENSAJES DE ESTATUS
                    if(isset($_COOKIE['msg'])) {
                        require_once($_SERVER["DOCUMENT_ROOT"]."/include/msg.php");
                        } ?>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <form method="post">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Editar una característica (Recomendaciones en tour)</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Descripción</label>
                                                    <input name="descripcion"
                                                        value="<?php echo ($recoSel['descripcion']);?>" type="text"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Descripción</label>
                                                    <input name="descripcion_ingles"
                                                        value="<?php echo ($recoSel['descripcion_ingles']);?>"
                                                        type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Imagen de ícono</label>
                                                    <div class="col-sm-12 col-md-7">
                                                        <img class="responsive"
                                                            src="/upload/categorias/<?php echo (strftime("%Y/%m", strtotime(($cateSel['fr'])))); ?>/<?php echo ($cateSel['imagen']) ?>.png"
                                                            alt="">
                                                        <div>
                                                            <label for="image-upload" id="image-label">Para reemplazar
                                                                el ícono actual sube una nueva foto</label>
                                                            <input type="file" name="thumb" id="image-upload" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <a class="btn btn-primary" href="/admin/msg-estado"><i
                                                    class="fas fa-angle-double-left"></i> Volver</a>
                                            <button type="submit" name="submit" value="submit"
                                                class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>




                    </div>

                </section>
            </div>

            <footer class="main-footer">
                <div class="footer-left">Copyright &copy; 2020 <div class="bullet"></div> Creado por <a target="_blank"
                        href="http://bananagroup.mx">Banana Group</a></div>
                <div class="footer-right"></div>
            </footer>

        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="/admin/assets/js/app.min.js"></script>
    <!-- JS Libraies -->
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
    <script src="/admin/assets/js/page/forms-advanced-forms.js"></script>
    <!-- Template JS File -->
    <script src="/admin/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="/admin/assets/js/custom.js"></script>

</body>

</html>