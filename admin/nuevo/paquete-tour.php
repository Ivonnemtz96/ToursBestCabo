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
	
    if ($categoria==""){
        setcookie("msg","basic",time() + 2, "/");
		header('location: ');
		exit;
	}else{ 
        
        if (empty($tour)) {
            $tour=0;
        }
        
		$tourCount	=	$db->getQueryCount('paqTour','id');
		if($tourCount[0]['total']<1000){
			$data	=	array(
							'tour'=>$tour,
							'categoria'=>$categoria,
							'paquete'=>$paqSel['id'],
						);
			$insert	=	$db->insert('paqTour',$data);
            
			if($insert){
                
                    //SUMAMOS +1 A LAS PROPIEDADES DE ESTE USUARIO
                    $Sum = (($paqSel['toursCount'])+1);
            
                    $InsertData	=	array(
                        'toursCount'=> $Sum,
                        );
                    
                    $update	=	$db->update('paquetes',$InsertData,array('id'=>($paqSel['id'])));//SUMAMOS 1 A SU EXPERIENCIA
                
                setcookie("msg","horaok",time() + 2, "/");
				header('location:/admin/nuevo/paquete-tour?paqueteId='.($paqSel['id']).'');//exito
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
            <li class="breadcrumb-item active">Agregar hotel</li>
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
                        
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h4>Agrega hotel para - Paquete - <?php echo ($paqSel['nombre'])?></h4>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Selecciona tipo de tour*</label>
                                            <div class="selectgroup w-100">
                                                <?php
                                            $catData = $db->getAllRecords('toursCate','*',' ORDER BY id ASC');
                                            if (count($catData)>0){
                                                $y	=	'';
                                                    foreach($catData as $categoria){
                                                        $y++;?>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="categoria" value="<?php echo ($categoria['id']);?>" class="selectgroup-input-radio"
                                                                    <?php if ($y==1){ echo "checked"; }?>>
                                                                <span class="selectgroup-button"><?php echo ($categoria['nombre']);?></span>
                                                            </label>
                                                            <?php
                                                    }
                                                }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label>Tour (Si no se selecciona el usuario podrá elegir)</label>
                                        <select name="tour" class="form-control selectric">
                                            <option selected disabled>Selecciona uno para fijar</option>
                                            <?php
                                            $catData = $db->getAllRecords('tours','*',' ORDER BY nombre ASC');
                                            if (count($catData)>0){
                                                $y	=	'';
                                                    foreach($catData as $categoria){
                                                    $y++;?>
                                                        <option value="<?php echo ($categoria['id']);?>"><?php echo ($categoria['nombre']);?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            </select>
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
                      <h4>Todos los hoteles para - Paquete - <?php echo ($paqSel['nombre'])?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>
                                          #
                                        </th>
                                        <th>Categoria</th>
                                        <th>Tour</th>
                                        <th class="text-rigth">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                <?php 
                                if ($paqSel['toursCount']>0) { 
                                $paquetesData = $db->getAllRecords('paqTour','*','AND paquete="'.$paqSel['id'].'" LIMIT '.$paqSel['toursCount'].'');
                                  if (count($paquetesData)>0){
                                      $y	=	'';
                                          foreach($paquetesData as $paquete){
                                              $catSel = $db->getAllRecords('toursCate','*','AND id='.$paquete['categoria'].'','LIMIT 1');
                                              $catSel = $catSel[0]['nombre'];
                                              
                                              $tourSel = $db->getAllRecords('tours','*','AND id='.$paquete['tour'].'','LIMIT 1');
                                              
                                              if (!$tourSel) {
                                                  $tourSel ="El usuario elige";
                                              } else { $tourSel = $tourSel[0]['nombre']; }
                                                                                            
                                              $y++;
                                              ?>
                                              <tr>
                                                    <td><?php echo $y ?></td>
                                                    <td><?php echo $catSel ?></td>
                                                    <td><?php echo $tourSel ?></td>
                                                    <td class="text-rigth">
                                                        <a href="/admin/borrar/paquete-tour?delId=<?php echo $paquete['id']; ?>" onClick="return confirm('¿Estás seguro? Esto no se puede deshacer');" class="btn btn-icon btn-danger"><i class="fa fa-trash"></i></a>
                                                    </td>
                                              </tr>
						                      
                                          <?php     
                                          }
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