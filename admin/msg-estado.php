<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

    if (($UserData['rol'])!=1) {
        setcookie("msg","super",time() + 2, "/");
        header('Location: /admin');
        exit;
    }


    //OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0];
    $rol = ($rol['nombre']);

    
if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
	extract($_REQUEST);
	if($msg==""){
        setcookie("msg","all",time() + 2, "/");
		header('location:/admin/msg-estado');
		exit;
	}else{
        
		$caractCount	=	$db->getQueryCount('msgStatus','id');
		if($caractCount[0]['total']<10000){
			$data	=	array(
							'msg'=>($msg),
							'estilo'=>($estilo),
							'descripcion'=>($descripcion),
							'mensaje'=>($mensaje),
                            
						);
			$insert	=	$db->insert('msgStatus',$data);
			if($insert){
                setcookie("msg","mnsok",time() + 2, "/");
				header('location:/admin/msg-estado');//exito
				exit;
			}else{
                setcookie("msg","sincam",time() + 2, "/");
				header('location:/admin/msg-estado');//sin cambios
				exit;
			}
		} else{
            setcookie("msg","lim",time() + 2, "/");
			header('location:/admin/msg-estado'); //limite
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
        
      
        <?php
        require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/navUser.php");
        require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/menu-principal.php");
                
        if(isset($_COOKIE['msg'])) {
            require_once($_SERVER["DOCUMENT_ROOT"]."/include/msg.php");
            } ?>
     
     
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
         
        <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">
                <a href="/admin"><h4 class="page-title m-b-0">Panel de control</h4></a>
            </li>
            <li class="breadcrumb-item">
                <i data-feather="settings"></i>
            </li>
            <li class="breadcrumb-item active">Mensajes de status</li>
        </ul>
         
                 
        
        
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <form method="post">
                <div class="card">
                    <div class="card-header">
                        <h4>Agregar un mensaje de status nuevo</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Clave</label>
                                    <input name="msg" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Estilo</label>
                                    <select name="estilo" class="form-control selectric">
                                        <option value="success">Correcto</option>
                                        <option value="danger">Error</option>
                                        <option value="warning">Advertencia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Descripción (En que casos se aplica)</label>
                                    <input name="descripcion" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Mensaje que verá el usuario</label>
                                    <input name="mensaje" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" name="submit" value="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h4>Todos los mensajes actuales</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                          #
                                        </th>
                                        <th>Clave</th>
                                        <th>Estilo</th>
                                        <th>Descripción (En que casos se aplica)</th>
                                        <th>Mensaje que verá el usuario</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $msgData = $db->getAllRecords('msgStatus','*','ORDER BY id DESC');
                                  if (count($msgData)>0){
                                      $y	=	'';
                                          foreach($msgData as $mensaje){
                                              $y++;
                                              ?>
                                              <tr>
                                                  <td><?php echo $y ?></td>
                                                  <td><?php echo $mensaje['msg']; ?></td>
                                                  <td>
                                                    <div class="badge badge-<?php echo $mensaje['estilo']; ?> badge-shadow"><?php echo $mensaje['estilo']; ?></div>
                                                  </td>
                                                  <td><?php echo $mensaje['descripcion']; ?></td>
                                                  <td><?php echo $mensaje['mensaje']; ?></td>
                                                  <td>
                                                      <a href="/admin/editar/msg-estado?editId=<?php echo $mensaje['id']; ?>" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                                                      <a href="/admin/borrar/msg-estado?delId=<?php echo $mensaje['id']; ?>" onClick="return confirm('Estás seguro? Esto no se puede deshacer');" class="btn btn-icon btn-danger"><i class="fa fa-trash"></i></a>
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
  <script src="/admin/assets/bundles/datatables/datatables.min.js"></script>
  <script src="/admin/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="/admin/assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="/admin/assets/js/page/datatables.js"></script>
  <!-- Template JS File -->
  <script src="/admin/assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="/admin/assets/js/custom.js"></script>
  <script src="/admin/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
  
    
</body>

</html>