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
    
    if (isset($_REQUEST['tourId']) and $_REQUEST['tourId']!=""){
        $tour  =  $db->getAllRecords('tours','*',' AND id="'.$_REQUEST['tourId'].'"LIMIT 1');
    }
    
    if (empty($tour)) { //SI NO EXISTE ES QUE NO HAY UN ID DE VÁLIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
        setcookie("msg","notour",time() + 2, "/");
        header('location:/admin/tours');
        exit;
    }

    $tour  =  $tour [0]; //PASAMOS LOS PRIMEROS 2 FILTROS Y SI TENEMOS UNA UNIDAD VÁLIDA SELECCIONADA 

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
	

        
        $dias=0;
        
        if (empty($_REQUEST['lunes'])) { 
            $lunes = 0;
        } else { $dias++; }
        
        if (empty($_REQUEST['martes'])) { 
            $martes = 0;
        } else { $dias++; }
        
        if (empty($_REQUEST['miercoles'])) { 
            $miercoles = 0;
        } else { $dias++; }
        
        if (empty($_REQUEST['jueves'])) { 
            $jueves = 0;
        } else { $dias++; }
        
        if (empty($_REQUEST['viernes'])) { 
            $viernes = 0;
        } else { $dias++; }
        
        if (empty($_REQUEST['sabado'])) { 
            $sabado = 0;
        } else { $dias++; }
        
        if (empty($_REQUEST['domingo'])) { 
            $domingo = 0;
        } else { $dias++; }
        
        
        
		$tariCount	=	$db->getQueryCount('toursDias','id');
		if($tariCount[0]['total']<1000){
			$data	=	array(
							'lunes'=>$lunes,
							'martes'=>$martes,
							'miercoles'=>$miercoles,
							'jueves'=>$jueves,
							'viernes'=>$viernes,
							'sabado'=>$sabado,
							'domingo'=>$domingo,
							'tour'=>$tour['id'],
						);
			$insert	=	$db->insert('toursDias',$data);
            
			if($insert){
                
                    //SUMAMOS +1 A LAS PROPIEDADES DE ESTE USUARIO
                    $SumFotos = $dias;
            
                    $InsertData	=	array(
                        'diasCount'=> $SumFotos,
                        );
                    
                    $update	=	$db->update('tours',$InsertData,array('id'=>($tour['id'])));//SUMAMOS 1 A SU EXPERIENCIA
                
                setcookie("msg","horaok",time() + 2, "/");
				header('location:/admin/nuevo/dias-tour?tourId='.($tour['id']).'');//exito
				exit;
			}else{
                setcookie("msg","ups",time() + 2, "/");
				header('location:/');//sin cambios
				exit;
			}
		} else{
            setcookie("msg","lim",time() + 2, "/");
			header('location:/'); //limite
			exit;
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
  <link rel="stylesheet" href="/admin/assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="/admin/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/admin/assets/bundles/jquery-selectric/selectric.css">
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
            <li class="breadcrumb-item active">Agregar día</li>
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
                        
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                      <h4>Días de salida - Tour - <?php echo ($tour['nombre'])?></h4>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="custom-switch" style="margin-top: 35px;">
                                            <input type="checkbox" value="1" name="lunes" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Lunes</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="custom-switch" style="margin-top: 35px;">
                                            <input type="checkbox" value="1" name="martes" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Martes</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="custom-switch" style="margin-top: 35px;">
                                            <input type="checkbox" value="1" name="miercoles" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Miércoles</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="custom-switch" style="margin-top: 35px;">
                                            <input type="checkbox" value="1" name="jueves" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Jueves</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="custom-switch" style="margin-top: 35px;">
                                            <input type="checkbox" value="1" name="viernes" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Viernes</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="custom-switch" style="margin-top: 35px;">
                                            <input type="checkbox" value="1" name="sabado" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Sábado</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="custom-switch" style="margin-top: 35px;">
                                            <input type="checkbox" value="1" name="domingo" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Domingo</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <a href="/admin/editar/tour/?editId=<?php echo $tour['id']; ?>" type="button" class="btn btn-icon icon-left btn-success">
                                <i class="fas fa-arrow-alt-circle-left"></i> Volver 
                            </a>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Subir</button>
                        </form> 
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h4>Todos los días disponibles para - Tour - <?php echo ($tour['nombre'])?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>
                                          #
                                        </th>
                                        <th>Lunes</th>
                                        <th>Martes</th>
                                        <th>Miércoles</th>
                                        <th>Jueves</th>
                                        <th>Viernes</th>
                                        <th>Sábado</th>
                                        <th>Domingo</th>
                                        <th class="text-rigth">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $diasData = $db->getAllRecords('toursDias','*','AND tour='.$tour['id'].' LIMIT '.$tour['diasCount'].'');
                                  if (count($diasData)>0){
                                      $y	=	'';
                                          foreach($diasData as $diaSel){
                                              
                                                                                            
                                              $y++;
                                              ?>
                                              <tr>
                                                    <td><?php echo $y ?></td>
                                                    <td><?php if ($diaSel['lunes']==1) { echo "Disponible"; } else { echo "No disponible"; } ?></td>
                                                    <td><?php if ($diaSel['martes']==1) { echo "Disponible"; } else { echo "No disponible"; } ?></td>
                                                    <td><?php if ($diaSel['miercoles']==1) { echo "Disponible"; } else { echo "No disponible"; } ?></td>
                                                    <td><?php if ($diaSel['jueves']==1) { echo "Disponible"; } else { echo "No disponible"; } ?></td>
                                                    <td><?php if ($diaSel['viernes']==1) { echo "Disponible"; } else { echo "No disponible"; } ?></td>
                                                    <td><?php if ($diaSel['sabado']==1) { echo "Disponible"; } else { echo "No disponible"; } ?></td>
                                                    <td><?php if ($diaSel['domingo']==1) { echo "Disponible"; } else { echo "No disponible"; } ?></td>
                                                    <td class="text-rigth">
                                                        <a href="/admin/borrar/dias-tour?delId=<?php echo $diaSel['id']; ?>" onClick="return confirm('¿Estás seguro? Esto no se puede deshacer');" class="btn btn-icon btn-danger"><i class="fa fa-trash"></i></a>
                                                    </td>
                                              </tr>
						                      
                                          <?php     
                                          }
                                      }
                                  ?>
                                    
                                </tbody>
                            </table>
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
  
  <script src="/admin/assets/bundles/datatables/datatables.min.js"></script>
  <script src="/admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  
  <!-- JS Libraies -->
  <script src="/admin/assets/bundles/summernote/summernote-bs4.js"></script>
  <script src="/admin/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
  <script src="/admin/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <!-- Page Specific JS File -->
  
  <script src="/admin/assets/js/page/datatables.js"></script>
  <script src="/admin/assets/js/page/create-post.js"></script>
  <!-- Template JS File -->
  <script src="/admin/assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="/admin/assets/js/custom.js"></script>
  
    
</body>

</html>