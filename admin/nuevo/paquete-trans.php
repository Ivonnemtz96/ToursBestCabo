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
    
    if (isset($_REQUEST['paqueteId']) and $_REQUEST['paqueteId']!=""){
        $paqSel  =  $db->getAllRecords('paquetes','*',' AND id="'.$_REQUEST['paqueteId'].'"LIMIT 1');
    }
    
    if (empty($paqSel)) { //SI NO EXISTE ES QUE NO HAY UN ID DE VÁLIDO Y REDIRECCIONAMOS Y LANZAMOS ERROR
        setcookie("msg","nopaq",time() + 2, "/");
        header('location:/admin/tours');
        exit;
    }

    $paqSel  =  $paqSel [0]; //PASAMOS LOS PRIMEROS 2 FILTROS Y SI TENEMOS UNA UNIDAD VÁLIDA SELECCIONADA 

    //OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0]['nombre'];

    date_default_timezone_set('America/Tijuana');   
    $fecha = date("Y-m-d H:i:s");
    


if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
	extract($_REQUEST);
	
    if ($descripcion==""){
        setcookie("msg","basic",time() + 2, "/");
		header('location: ');
		exit;
	}else{ 
        
		$transCount	=	$db->getQueryCount('paqTransporte','id');
		if($transCount[0]['total']<1000){
			$data	=	array(
							'descripcion'=>$descripcion,
							'paquete'=>$paqSel['id'],
						);
			$insert	=	$db->insert('paqTransporte',$data);
            
			if($insert){
                
                    //SUMAMOS +1 A LAS PROPIEDADES DE ESTE USUARIO
                    $Sum = (($paqSel['transCount'])+1);
            
                    $InsertData	=	array(
                        'transCount'=> $Sum,
                        );
                    
                    $update	=	$db->update('paquetes',$InsertData,array('id'=>($paqSel['id'])));//SUMAMOS 1 A SU EXPERIENCIA
                
                setcookie("msg","horaok",time() + 2, "/");
				header('location:/admin/nuevo/paquete-trans?paqueteId='.($paqSel['id']).'');//exito
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
            <li class="breadcrumb-item active">Agregar transporte</li>
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
                      <h4>Agrega transportes para - Tour - <?php echo ($paqSel['nombre'])?></h4>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Descripción de transporte</label>
                                        <input name="descripcion" class="form-control" type="text" required>
                                        <div class="invalid-feedback">
                                          Por favor ingresa este campo.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="/admin/editar/paquete/?editId=<?php echo $paqSel['id']; ?>" type="button" class="btn btn-icon icon-left btn-success">
                                <i class="fas fa-arrow-alt-circle-left"></i> Volver 
                            </a>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Guardar</button>
                        </form> 
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h4>Todos los transportes para - Paquete - <?php echo ($paqSel['nombre'])?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>
                                          #
                                        </th>
                                        <th>Descripción</th>
                                        <th class="text-rigth">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $paquetesData = $db->getAllRecords('paqTransporte','*','AND paquete='.$paqSel['id'].' LIMIT '.$paqSel['transCount'].'');
                                  if (count($paquetesData)>0){
                                      $y	=	'';
                                          foreach($paquetesData as $paquete){
                                              
                                                                                            
                                              $y++;
                                              ?>
                                              <tr>
                                                    <td><?php echo $y ?></td>
                                                    <td><?php echo $paquete['descripcion']; ?></td>
                                                    <td class="text-rigth">
                                                        <a href="/admin/borrar/paquete-trans?delId=<?php echo $paquete['id']; ?>" onClick="return confirm('¿Estás seguro? Esto no se puede deshacer');" class="btn btn-icon btn-danger"><i class="fa fa-trash"></i></a>
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