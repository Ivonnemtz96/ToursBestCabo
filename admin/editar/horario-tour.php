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
        $horario  =  $db->getAllRecords('toursHorarios','*',' AND id="'.$_REQUEST['editId'].'"LIMIT 1');
    }
    
    if (empty($horario)) { //SI NO EXISTE ES QUE NO HAY UN ID DE VÁLIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
        setcookie("msg","notour",time() + 2, "/");
        header('location:/admin/tours');
        exit;
    }

    $horario  =  $horario [0]; //PASAMOS LOS PRIMEROS 2 FILTROS Y SI TENEMOS UNA UNIDAD VÁLIDA SELECCIONADA 

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
	
    if ($horario==""){
        setcookie("msg","basic",time() + 2, "/");
		header('location: ');
		exit;
	}else{ 
        
        
        if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
            extract($_REQUEST);
			$data	=	array(
                            'horario'=>$horarion,
						);
                $update	=	$db->update('toursHorarios',$data,array('id'=>($_REQUEST['editId'])));
            
			if($update){
                setcookie("msg","tariup",time() + 2, "/");
                header('location:/admin/nuevo/horario-tour?tourId='.($horario['tour']).'');//exito
                exit;}
            else{
                setcookie("msg","ups",time() + 2, "/");
               header('location:/admin/nuevo/horario-tour?tourId='.($horario['tour']).''); //sin cambios
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
                <i data-feather="edit"></i>
            </li>
            <li class="breadcrumb-item active">Editar horario</li>
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
                      <h4>Editar horario</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ingresa un horario disponible, formato 24 hrs.</label>
                                        <input name="horarion" class="form-control" type="time" value="<?php echo $horario['horario']; ?>" required>
                                        <div class="invalid-feedback">
                                          Por favor ingresa el horario.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="/admin/nuevo/horario-tour?tourId=<?php echo $horario['tour']; ?>" type="button" class="btn btn-icon icon-left btn-success">
                                <i class="fas fa-arrow-alt-circle-left"></i> Volver 
                            </a>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Guardar</button>
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
  <script src="/admin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <!-- Page Specific JS File -->
  
  <script src="/admin/assets/js/page/create-post.js"></script>
  <!-- Template JS File -->
  <script src="/admin/assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="/admin/assets/js/custom.js"></script>
  
    
</body>

</html>