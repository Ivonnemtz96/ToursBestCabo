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
        $itinerario  =  $db->getAllRecords('itinerarios','*',' AND id="'.$_REQUEST['editId'].'"LIMIT 1');
    }
    
    if (empty($itinerario)) { //SI NO EXISTE ES QUE NO HAY UN ID DE VÁLIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
        setcookie("msg","noitin",time() + 2, "/");
        header('location:/admin/nuevo/itinerarios');
        exit;
    }

    $itinerario  =  $itinerario [0]; //PASAMOS LOS PRIMEROS 2 FILTROS Y SI TENEMOS UNA UNIDAD VÁLIDA SELECCIONADA 

    

    //OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0];
    $rol = ($rol['nombre']);

    date_default_timezone_set('America/Mazatlan');   
    $fecha = date("Y-m-d H:i:s");
    
    setlocale(LC_ALL, 'es_MX'); 
    $mesr = strftime("%m");
    $anor = strftime("%Y");





if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
	extract($_REQUEST);
	
    if(($cliente=="")or($fv=="")or($dias=="")or($tel=="")){
        setcookie("msg","basic",time() + 2, "/");
		header('location:/admin/nuevo/itinerario/');
		exit;
	}else{ 
        
        
        
        
        
        if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
            extract($_REQUEST);
			$data	=	array(
                            'cliente'=>$cliente,
							'tel'=>$tel,
							'dias'=>$dias,
							'fv'=>$fv,
                            'fa'=>$fecha,
                            'vendedor'=>$vendedor,
                            'venTel'=>$venTel,
                            'venCel'=>$venCel,
						);
                $update	=	$db->update('itinerarios',$data,array('id'=>($_REQUEST['editId'])));
            
			if($update){
                setcookie("msg","tariup",time() + 2, "/");
                header('location:/admin/nuevo/itinerario/'); //Exito en el cmabio
                exit;}
            else{
                setcookie("msg","ups",time() + 2, "/");
                header('location:/admin/nuevo/itinerario/'); //sin cambios
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
            <li class="breadcrumb-item active">Editar Itinerario</li>
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
                        
            
            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      <h4>Estás editando Itinerario de: <?php echo ($itinerario['cliente'])?></h4>
                    </div>
                    <div class="card-body">
                       
                        
                        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Vendedor</label>
                                                <input name="vendedor" class="form-control" type="text" required value="<?php echo ($itinerario['vendedor'])?>">
                                                <div class="invalid-feedback">
                                                  Por favor ingresa este campo.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Teléfono vendedor</label>
                                                <input name="venTel" class="form-control" type="text" value="<?php echo ($itinerario['venTel'])?>" required>
                                                <div class="invalid-feedback">
                                                  Por favor ingresa este campo.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Celular Vendedor</label>
                                                <input name="venCel" class="form-control" type="text" value="<?php echo ($itinerario['venCel'])?>" required>
                                                <div class="invalid-feedback">
                                                  Por favor ingresa este campo.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Nombre de cliente</label>
                                                <input name="cliente" class="form-control" type="text" value="<?php echo ($itinerario['cliente'])?>" required>
                                                <div class="invalid-feedback">
                                                  Por favor ingresa el nombre del cliente.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>Teléfono cliente</label>
                                                <input name="tel" class="form-control" type="phone" value="<?php echo ($itinerario['tel'])?>" required>
                                                <div class="invalid-feedback">
                                                  Por favor ingresa el teléfono del cliente.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>Fecha de viaje</label>
                                                <input name="fv" class="form-control" type="date" required value="<?php echo ($itinerario['fv'])?>">
                                                <div class="invalid-feedback">
                                                  Por favor ingresa fecha de viaje
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label>No. de días</label>
                                                <input name="dias" class="form-control" type="number" value="<?php echo ($itinerario['dias'])?>" required>
                                                <div class="invalid-feedback">
                                                  Por favor ingresa los días del paquete
                                                </div>
                                            </div>
                                        </div>
                                   
                                    </div>
                                </div>                            
                                <div class="col-md-12">
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