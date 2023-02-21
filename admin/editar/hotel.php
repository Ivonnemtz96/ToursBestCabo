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
        $hotel  =  $db->getAllRecords('hoteles','*',' AND id="'.$_REQUEST['editId'].'"LIMIT 1');
    }
    
    if (empty($hotel)) { //SI NO EXISTE ES QUE NO HAY UN ID DE VÁLIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
        setcookie("msg","nohotel",time() + 2, "/");
        header('location:/admin/nuevo/hotel');
        exit;
    }

    $hotel  =  $hotel [0]; //PASAMOS LOS PRIMEROS 2 FILTROS Y SI TENEMOS UNA UNIDAD VÁLIDA SELECCIONADA 

    

    //OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0];
    $rol = ($rol['nombre']);

    date_default_timezone_set('America/Tijuana');   
    $fecha = date("Y-m-d H:i:s");
    
    setlocale(LC_ALL, 'es_MX'); 
    $mesr = strftime("%m");
    $anor = strftime("%Y");





if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
	extract($_REQUEST);
	
    if(($precio=="")or($nombre=="")or($zona=="")){
        setcookie("msg","basic",time() + 2, "/");
		header('location:/admin/nuevo/hotel');
		exit;
	}else{ 
        
        
        
        $codigo = ($hotel['fPortada']); //SI NO SE SUBE LA FOTO LE DAMOS EL VALOR EXISTENTE QUE YA ESTÁ EN NUESTRA BASE DE DATOS
        
        if (!empty($_FILES['thumb']['tmp_name'])) {
            
            
            
            $thumb = $_FILES['thumb']['tmp_name']; //DEFINIMOS LA VARIABLE THUMB YA SABEMOS QUE SI SE CARGÓ UNA FOTO
            
            if($_FILES['thumb']['type'] !== 'image/jpeg'){
                setcookie("msg","fnv",time() + 2, "/");
                header('location:/admin/editar/hotel?editId='.$_REQUEST['editId'].'');
                exit;
            }
            
            if(($_FILES['thumb']['size']) > 1500000){
                setcookie("msg","fnvz",time() + 2, "/");
                header('location:/admin/editar/hotel?editId='.$_REQUEST['editId'].'');
		      exit;
            }
            
            //A ESTE PUNTO SABEMOS QUE SI SUBIÓ UNA FOTO NUEVA, ENTONCES DEBEMOS BORRAR LA EXISTENTE
            if (isset($hotel['fPortada'])){
                $archivo = '../../upload/hoteles/'.(strftime("%Y/%m", strtotime(($hotel['fr'])))).'/'.($hotel['fPortada']).'.jpg';
                unlink($archivo); //BORRAMOS LA FOTO ANTIGUA SACANDO EL NOMBRE DE LA BASE DE DATOS
            }
            
                $codigo = GeraHash(10); //LO USAMOS PARA EL NOMBRE DE LA FOTO
            
                $ruta = '../../upload/hoteles/'.(strftime("%Y/%m", strtotime(($hotel['fr'])))).'';
            
        
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
                            'precio'=>$precio,
							'nombre'=>$nombre,
                            'fa'=>$fecha,
                            'fPortada'=>$codigo,
                            'zona'=>$zona,
						);
                $update	=	$db->update('hoteles',$data,array('id'=>($_REQUEST['editId'])));
            
			if($update){
                setcookie("msg","tariup",time() + 2, "/");
                header('location:/admin/nuevo/hotel'); //Exito en el cmabio
                exit;}
            else{
                setcookie("msg","ups",time() + 2, "/");
                header('location:/admin/editar/hotel?editId='.$_REQUEST['editId'].''); //sin cambios
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
            <li class="breadcrumb-item active">Editar hotel</li>
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
                      <h4>Estás editando: <?php echo ($hotel['nombre'])?></h4>
                    </div>
                    <div class="card-body">
                        
                        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate="">
                            <div class="row">
                                <div class="col-lg-9 col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input name="nombre" class="form-control" type="text" value="<?php echo ($hotel['nombre'])?>" required>
                                                <div class="invalid-feedback">
                                                  Por favor ingresa el nombre de el Hotel
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Costo</label>
                                                <input name="precio" class="form-control" type="text" value="<?php echo ($hotel['precio'])?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Selecciona la zona</label>
                                            <div class="selectgroup w-100">
                                                <?php
                                            $zonaData = $db->getAllRecords('zonas','*',' ORDER BY id ASC');
                                            if (count($zonaData)>0){
                                                $y	=	'';
                                                    foreach($zonaData as $zona){
                                                        $y++;?>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="zona" value="<?php echo ($zona['id']);?>" class="selectgroup-input-radio"
                                                                    <?php if (($zona['id'])==($hotel['zona'])){ echo "checked"; }?>>
                                                                <span class="selectgroup-button"><?php echo ($zona['nombre']);?></span>
                                                            </label>
                                                            <?php
                                                    }
                                                }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                      <label>Imagen de portada actual</label>
                                        <div class="col-sm-12 col-md-7">
                                            <img class="responsive" src="/upload/hoteles/<?php echo (strftime("%Y/%m", strtotime(($hotel['fr']))));?>/<?php echo ($hotel['fPortada']) ?>.jpg" alt="">
                                            <div>
                                                <label for="image-upload" id="image-label">Para reemplazar la portada actual sube una nueva foto</label>
                                                <input type="file" name="thumb" id="image-upload" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                
                                                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                         <button class="btn btn-primary btn-lg" value="submit" name="submit" type="submit">Guardar</button> 
                                    </div>
                                </div>
                            </div>
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