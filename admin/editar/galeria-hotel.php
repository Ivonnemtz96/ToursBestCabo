<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/include/funciones.php");

    if (($UserData['rol'])>2) {
        setcookie("msg","sad",time() + 2, "/");
        header('Location: /');
    }

//OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0];
    $rol = ($rol['nombre']);

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    date_default_timezone_set('America/Denver');   
    $fecha = date("Y-m-d H:i:s");
    
    
    if (isset($_REQUEST['prodId']) and $_REQUEST['prodId']!=""){
        $hotel  =  $db->getAllRecords('hoteles','*',' AND id="'.$_REQUEST['prodId'].'"LIMIT 1');
    }
    
    if (empty($hotel)) { //SI NO EXISTE ES QUE NO HAY UN ID VÁLIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
        setcookie("msg","ups",time() + 2, "/");
        header('location:/admin/hoteles');
        exit;
    }
    
    $hotel  =  $hotel [0]; //PASAMOS LOS PRIMEROS 2 FILTROS Y SI TENEMOS UNA PROPIEDAD VÁLIDA SELECCIONADA 





if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
	extract($_REQUEST);
    
	if(($_FILES['thumb']['tmp_name'])==""){
        setcookie("msg","foto",time() + 2, "/");
		header('location:/admin/editar/galeria-hotel?prodId='.($hotel['id']).'');
		exit;
	}else{
         
        
            if($_FILES['thumb']['type'] !== 'image/jpeg'){ 
                setcookie("msg","fnv",time() + 2, "/");
                header('location:/admin/editar/galeria-hotel?prodId='.($hotel['id']).'');
                exit;
            }
            
            if(($_FILES['thumb']['size']) > 1500000){ 
                setcookie("msg","fnvz",time() + 2, "/");
                header('location:/admin/editar/galeria-hotel?prodId='.($hotel['id']).'');
                exit;
            }
        
                $thumb = $_FILES['thumb']['tmp_name']; //DEFINIMOS LA VARIABLE THUMB YA SABEMOS QUE SI SE CARGÓ Y PASÓ LOS FILTROS
            
                $codigo = GeraHash(10); //LO USAMOS PARA EL NOMBRE DE LA FOTO
            
                $ruta = '../../upload/hoteles/'.(strftime("%Y/%m", strtotime(($hotel['fr'])))).'';
            
        
                //SI LA CARPETA NO EXISTE LA CREAMOS
                if(!file_exists($ruta)) {
                    mkdir($ruta, 0777, true);
                }
	            
                //SUBIMOS LA FOTO EN LA CARPETA EXISTENTE O LA CREADA
	            $archivo_subido = ''.$ruta.'/' . $codigo . '.jpg';
	            move_uploaded_file($thumb, $archivo_subido);
        
        
        
		$FotosCount	=	$db->getQueryCount('fotosHotel','id');
		if($FotosCount[0]['total']<10000){
			$data	=	array(
							'codigo'=>$codigo,
							'hotel'=>($hotel['id']),
                            
						);
			$insert	=	$db->insert('fotosHotel',$data);
            
			if($insert){
                
                    //SUMAMOS +1 A LAS PROPIEDADES DE ESTE USUARIO
                    $SumFotos = (($hotel['fotosCount'])+1);
            
                    $InsertData	=	array(
                        'fotosCount'=> $SumFotos,
                        );
                    
                    $update	=	$db->update('hoteles',$InsertData,array('id'=>($hotel['id'])));//SUMAMOS 1 A SU EXPERIENCIA
                
                setcookie("msg","fok",time() + 2, "/");
				header('location:/admin/editar/galeria-hotel?prodId='.($hotel['id']).'');//exito
				exit;
			}else{
                setcookie("msg","ups",time() + 2, "/");
				header('location:/admin/editar/galeria-hotel?prodId='.($hotel['id']).'');//sin cambios
				exit;
			}
		} else{
            setcookie("msg","lim",time() + 2, "/");
			header('location:/admin/editar/galeria-hotel?prodId='.($hotel['id']).''); //limite
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
  <link href="/admin/assets/bundles/lightgallery/dist/css/lightgallery.css" rel="stylesheet">
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
                <i data-feather="image"></i>
            </li>
            <li class="breadcrumb-item active">Agregar una foto a la galería</li>
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
            <div class="col-md-12 col-lg-12 col-xl-8">
                <form method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h4>Cargar una foto nueva</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input name="thumb" type="file" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Subir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
            
        <div class="section-body">
            <div class="row clearfix">
                <div class="col-md-12 col-lg-12 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Galería de: <?php echo ($hotel['nombre']) ?> (<?php echo ($hotel['fotosCount']) ?>)</h4>
                        </div>
                        <div class="card-body">
                         
                            <div class="list-unstyled row clearfix">
                               
                                <?php $fotosData = $db->getAllRecords('fotosHotel','*','AND hotel='.($hotel['id']).'','ORDER BY id DESC LIMIT '.($hotel['fotosCount']).'');
                                    if (count($fotosData)>0){
                                        $y	=	'';
                                            foreach($fotosData as $foto){
                                                $y++;                   
                                                ?>
									            	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        
                                                        <img class="responsive" src="/upload/hoteles/<?php echo (strftime("%Y/%m", strtotime(($hotel['fr']))));?>/<?php echo ($foto['codigo']) ?>.jpg" alt="">
                                                        
                                                        <a href="/admin/borrar/foto-hotel?delId=<?php echo $foto['id']; ?>" onClick="return confirm('¿Estás seguro? Esto no se puede deshacer');" class="mt-2 btn btn-icon btn-danger"><i class="fa fa-trash"></i> Borrar foto</a>
                                                    </div> 
                                                <?php  
                                            }
                                        } else { echo"<p><i>Aún no hay fotos en esta galería</i></p>"; }
                                    ?>
                                    
                                
                            </div>
                            
                            
                            
                        </div>
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
  <script src="/admin/assets/bundles/lightgallery/dist/js/lightgallery-all.js"></script>
  <!-- Page Specific JS File -->
  <script src="/admin/assets/js/page/light-gallery.js"></script>
  <!-- Template JS File -->
  <script src="/admin/assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="/admin/assets/js/custom.js"></script>
  
    
</body>

</html>