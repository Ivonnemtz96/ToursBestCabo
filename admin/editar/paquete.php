<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/include/funciones.php");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (($UserData['rol'])>2) {
        setcookie("msg","sad",time() + 2, "/");
        header('Location: /');
    }
    
    if (isset($_REQUEST['editId']) and $_REQUEST['editId']!=""){
        $paqueteSel  =  $db->getAllRecords('paquetes','*',' AND id="'.$_REQUEST['editId'].'"LIMIT 1');
    }
    
    if (empty($paqueteSel)) { //SI NO EXISTE ES QUE NO HAY UN ID DE VÁLIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
        setcookie("msg","notour",time() + 2, "/");
        header('location:/admin/paquetes');
        exit;
    }

    $paqueteSel  =  $paqueteSel [0]; //PASAMOS LOS PRIMEROS 2 FILTROS Y SI TENEMOS UNA UNIDAD VÁLIDA SELECCIONADA 

    //OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0]['nombre'];

    date_default_timezone_set('America/Tijuana');   
    $fecha = date("Y-m-d H:i:s");
    
    setlocale(LC_ALL, 'es_MX'); 
    $mesr = strftime("%m");
    $anor = strftime("%Y");

    


if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
	extract($_REQUEST);
	
    if(($nombre=="")or($descripcion=="")or($adul=="")or($precio=="")or($inf=="")){
        setcookie("msg","basic",time() + 2, "/");
		header('location: ');
		exit;
	}else{ 
         
        
        
        $codigo = ($paqueteSel['fPortada']); //SI NO SE SUBE LA FOTO LE DAMOS EL VALOR EXISTENTE QUE YA ESTÁ EN NUESTRA BASE DE DATOS
        
        if (!empty($_FILES['thumb']['tmp_name'])) {
            
            //A ESTE PUNTO SABEMOS QUE SI SUBIÓ UNA FOTO NUEVA, ENTONCES DEBEMOS BORRAR LA EXISTENTE
            if (isset($paqueteSel['fPortada'])){
                $archivo = '../../upload/paquetes/'.(strftime("%Y/%m", strtotime(($paqueteSel['fr'])))).'/'.($paqueteSel['fPortada']).'.jpg';
                unlink($archivo); //BORRAMOS LA FOTO ANTIGUA SACANDO EL NOMBRE DE LA BASE DE DATOS
            }
            
            $thumb = $_FILES['thumb']['tmp_name']; //DEFINIMOS LA VARIABLE THUMB YA SABEMOS QUE SI SE CARGÓ UNA FOTO
            
            if($_FILES['thumb']['type'] !== 'image/jpeg'){
                setcookie("msg","fnv",time() + 2, "/");
                header('location:/admin/editar/paquete?editId='.$_REQUEST['editId'].'');
                exit;
            }
            
            if(($_FILES['thumb']['size']) > 1000000){
                setcookie("msg","fnvz",time() + 2, "/");
                header('location:/admin/editar/paquete?editId='.$_REQUEST['editId'].'');
		      exit;
            }
            
                $codigo = GeraHash(10); //LO USAMOS PARA EL NOMBRE DE LA FOTO
            
                $ruta = '../../upload/paquetes/'.(strftime("%Y/%m", strtotime(($paqueteSel['fr'])))).'';
            
        
                //SI LA CARPETA NO EXISTE LA CREAMOS
                if(!file_exists($ruta)) {
                    mkdir($ruta, 0777, true);
                }
	            
                //SUBIMOS LA FOTO EN LA CARPETA EXISTENTE O LA CREADA
	            $archivo_subido = ''.$ruta.'/' . $codigo . '.jpg';
	            move_uploaded_file($thumb, $archivo_subido);
         }
        
        
        if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
            extract($_REQUEST);
			$data	=	array(
                            'nombre'=>$nombre,
							'descripcion'=>$descripcion,
                            'precio'=>$precio,
                            'adul'=>$adul,
                            'inf'=>$inf,
                            'fPortada'=>$codigo,
                            'fa'=>$fecha,
						);
                $update	=	$db->update('paquetes',$data,array('id'=>($_REQUEST['editId'])));
            
            
            
                            
			if($update){
                setcookie("msg","produp",time() + 2, "/");
                header('location:/admin/editar/paquete?editId='.$_REQUEST['editId'].''); //Exito en el cmabio
                exit;}
            else{
                setcookie("msg","ups",time() + 2, "/");
                header('location:/admin/editar/paquete?editId='.$_REQUEST['editId'].''); //sin cambios
                exit;
            }
        }
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
        
      
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/navUser.php"); ?>
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/menu-principal.php"); ?>
     
     
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
         
        <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">
                <a href="/admin"><h4 class="page-title m-b-0">Panel de control</h4></a>
            </li>
            <li class="breadcrumb-item">
                <i data-feather="edit"></i>
            </li>
            <li class="breadcrumb-item active">Editar paquete</li>
        </ul>
         
        <div class="row justify-content-center">
            <div class="col-md-5">
                <?php
                //MENSAJES DE ESTATUS
                if(isset($_COOKIE["msg"])) {
                require_once($_SERVER["DOCUMENT_ROOT"]."/include/msg.php");
                } ?>
            </div>
        </div>
          
        
        
        <div class="row">
                        
            
            
            <div class="col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                      <h4>Información básica - Paquete - <?php echo ($paqueteSel['nombre'])?></h4>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate="">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Nombre*</label>
                                        <input name="nombre" class="form-control" type="text" value="<?php echo ($paqueteSel['nombre'])?>" required>
                                        <div class="invalid-feedback">
                                          Por favor ingresa nombre del tour.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <input name="precio" class="form-control" type="text" value="<?php echo ($paqueteSel['precio'])?>" required>
                                        <div class="invalid-feedback">
                                            Ingresa precio.
                                        </div>
                                    </div>
                                </div>
                                
                                        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Adultos</label>
                                        <input name="adul" class="form-control" type="number" value="<?php echo ($paqueteSel['adul'])?>" required>
                                        <div class="invalid-feedback">
                                            Ingresa la capacidad.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Niños</label>
                                        <input name="inf" class="form-control" type="number" value="<?php echo ($paqueteSel['inf'])?>" required>
                                        <div class="invalid-feedback">
                                            Ingresa la duracion.
                                        </div>
                                    </div>
                                </div>
                                        
                                <div class="col-lg-9 col-md-6">
                                    <div class="form-group">
                                        <label>Descripción*</label>
                                        <textarea name="descripcion" class="form-control" cols="5" rows="2" required><?php echo ($paqueteSel['descripcion'])?></textarea>
                                        <div class="invalid-feedback">
                                          Por favor ingresa la descripción.
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>Imagen de portada actual</label>
                                        <div class="col-sm-12 col-md-7">
                                            <img class="responsive" src="/upload/paquetes/<?php echo (strftime("%Y/%m", strtotime(($paqueteSel['fr']))));?>/<?php echo ($paqueteSel['fPortada']) ?>.jpg" alt="">
                                            <div>
                                                <label for="image-upload" id="image-label">Para reemplazar la portada actual sube una nueva foto</label>
                                                <input type="file" name="thumb" id="image-upload" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Guardar</button>
                            <a href="/admin/paquetes" type="button" class="btn btn-icon icon-left btn-success">
                                <i class="fas fa-arrow-alt-circle-left"></i> Volver 
                            </a>
                            <a href="/admin/nuevo/paquete-hotel?paqueteId=<?php echo $paqueteSel['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                <i class="fas fa-hotel"></i> Hoteles
                                <span class="badge badge-transparent"><?php echo ($paqueteSel['hotelCount']) ?></span>
                            </a>
                            <a href="/admin/nuevo/paquete-trans?paqueteId=<?php echo $paqueteSel['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                <i class="fas fa-car-side"></i> Transporte
                                <span class="badge badge-transparent"><?php echo ($paqueteSel['transCount']) ?></span>
                            </a>
                            <a href="/admin/nuevo/paquete-tour?paqueteId=<?php echo $paqueteSel['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                <i class="fas fa-map"></i> Tours
                                <span class="badge badge-transparent"><?php echo ($paqueteSel['toursCount']) ?></span>
                            </a>
                            
                            <a target="_blank" href="/paquete/<?php echo $paqueteSel['id']; ?>" class="btn btn-icon btn-info"><i class="fas fa-eye"></i></a>
                        </form> 
                    </div>
                </div>
            </div>
            
            
            
            
          
        </div>
            
        </section>
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/settings.php"); ?>
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