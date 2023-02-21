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
	
    if(($nombre=="")or($descripcion=="")or($adul=="")or($precio=="")or($inf=="")){
        setcookie("msg","basic",time() + 2, "/");
		header('location:/admin/paquete');
		exit;
	}else if(($_FILES['thumb']['tmp_name'])==""){
        setcookie("msg","foto",time() + 2, "/");
		header('location:/admin/paquete');
		exit;
	}else{ 
         
       
        
        if (!empty($_FILES['thumb']['tmp_name'])) {
            
            $thumb = $_FILES['thumb']['tmp_name']; //DEFINIMOS LA VARIABLE THUMB YA SABEMOS QUE SI SE CARGÓ UNA FOTO
            
            if($_FILES['thumb']['type'] !== 'image/jpeg'){ 
		      setcookie("msg","fnv",time() + 2, "/");
		      header('location:/admin/nuevo/paquete');
		      exit;
            }
            
            if(($_FILES['thumb']['size']) > 1000000){ 
              setcookie("msg","fnvz",time() + 2, "/");
		      header('location:/admin/nuevo/paquete');
		      exit;
            }
            
                $codigo = GeraHash(10); //LO USAMOS PARA EL NOMBRE DE LA FOTO
            
                $ruta = '../../upload/paquetes/'.$anor.'/'.$mesr.'';
            
        
                //SI LA CARPETA NO EXISTE LA CREAMOS
                if(!file_exists($ruta)) {
                    mkdir($ruta, 0777, true);
                }
	            
                //SUBIMOS LA FOTO EN LA CARPETA EXISTENTE O LA CREADA
	            $archivo_subido = ''.$ruta.'/' . $codigo . '.jpg';
	            move_uploaded_file($thumb, $archivo_subido);
         }
        
        
        
		$casasCount	=	$db->getQueryCount('paquetes','id');
		if($casasCount[0]['total']<1000){
			$data	=	array(
							'nombre'=>$nombre,
							'descripcion'=>$descripcion,
                            'precio'=>$precio,
                            'adul'=>$adul,
                            'inf'=>$inf,
                            'fPortada'=>$codigo,
                            'fr'=>$fecha,
						);
			$insert	=	$db->insert('paquetes',$data);
            
			if($insert){
                setcookie("msg","paqok",time() + 2, "/");                
				header('location:/admin/paquetes');
				exit;
			}else{
                setcookie("msg","ups",time() + 2, "/");
				header('location:/admin/paquetes');//sin cambios
				exit;
			}
		} else{
            setcookie("msg","prodlim",time() + 2, "/");
			header('location:/admin/paquetes'); //limite
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
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/title.php");?>
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
                <i data-feather="layers"></i>
            </li>
            <li class="breadcrumb-item active">Agregar nuevo paquete</li>
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
                        
            
            
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h4>Redactar nuevo paquete</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate="">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Nombre*</label>
                                        <input name="nombre" class="form-control" type="text" required>
                                        <div class="invalid-feedback">
                                          Por favor ingresa nombre del tour.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <input name="precio" class="form-control" type="text" required>
                                        <div class="invalid-feedback">
                                            Ingresa precio.
                                        </div>
                                    </div>
                                </div>
                                
                                        
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Adultos</label>
                                        <input name="adul" class="form-control" type="number" required>
                                        <div class="invalid-feedback">
                                            Ingresa la capacidad.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Niños</label>
                                        <input name="inf" class="form-control" type="number" required>
                                        <div class="invalid-feedback">
                                            Ingresa la duracion.
                                        </div>
                                    </div>
                                </div>
                                        
                                <div class="col-lg-9 col-md-6">
                                    <div class="form-group">
                                        <label>Descripción*</label>
                                        <textarea name="descripcion" class="form-control" cols="5" rows="2" required></textarea>
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
 
</body>

</html>