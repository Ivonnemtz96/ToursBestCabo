<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

    if (($UserData['rol'])>2) {
        setcookie("msg","sad",time() + 1, "/");
        header('Location: /');
    }


    //OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0];
    $rol = ($rol['nombre']);

    
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
            <li class="breadcrumb-item active">Tours publicados</li>
        </ul>
         
       
        
        <div class="row">
            <?php
            $toursData = $db->getAllRecords('tours','*',' ORDER BY id DESC');
            if (count($toursData)>0){
                $y	=	'';
                    foreach($toursData as $tour){
                        
                        $catSel = $db->getAllRecords('toursCate','*','AND id='.($tour['categoria']).'','LIMIT 1');
                        $catSel = $catSel[0];
                        
                        $y++;?>
                        <div class="col-12 col-sm-6 col-md-4">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image" data-background="/upload/tours/<?php echo (strftime("%Y/%m", strtotime(($tour['fr']))));?>/<?php echo ($tour['fPortada']) ?>.jpg"></div>
                                    <div class="article-title">
                                        <h2><a target="_blank" href="#"><?php echo ($tour['nombre']) ?></a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p><b>Duración</b>: <?php echo ($tour['duracion']) ?> horas.</p>
                                    <p><b>Grupo</b>: <?php echo ($catSel['nombre']) ?></p>
                                    <div class="article-cta">
                                       
                                        <a href="/admin/editar/tour?editId=<?php echo $tour['id']; ?>" class="btn btn-primary">Editar</a>
                                        
                                        <a href="/admin/editar/galeria-tour?prodId=<?php echo $tour['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                            <i class="fas fa-image"></i> Galería
                                            <span class="badge badge-transparent"><?php echo ($tour['fotosCount']) ?></span>
                                        </a>
                                           
                                        <a href="/admin/nuevo/horario-tour?tourId=<?php echo $tour['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                            <i class="far fa-clock"></i> Horarios
                                            <span class="badge badge-transparent"><?php echo ($tour['horariosCount']) ?></span>
                                        </a>
                                        
                                        <a href="/admin/nuevo/dias-tour?tourId=<?php echo $tour['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                            <i class="far fa-calendar-alt"></i> Días
                                            <span class="badge badge-transparent"><?php echo ($tour['diasCount']) ?></span>
                                        </a>
                                        
                                        <a href="/admin/nuevo/itinerario-tour?tourId=<?php echo $tour['id']; ?>" type="button" class="btn btn-primary btn-icon icon-left">
                                            <i class="far fa-list-alt"></i> Itinerario
                                            <span class="badge badge-transparent"><?php echo ($tour['itinerarioCount']) ?></span>
                                        </a>
                                        
                                        <a href="/admin/borrar/tour?delId=<?php echo $tour['id']; ?>" onClick="return confirm('¿Estás seguro? Esto no se puede deshacer');" class="btn btn-icon btn-danger"><i class="fa fa-trash"></i></a>
                                        
                                    </div>
                                </div>
                            </article>
                        </div>
                        <?php
                    }
                } else { 
                ?>
                
            <div class="col-md-6 col-lg6">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <br>
                        <br>
                        <br>
                        <br>
                        <h5>No hay tours publicados</h5>
                        <div class="article-cta">
                            <a href="/admin/nuevo/tour" class="btn btn-primary">¡Publíca uno ahora!</a>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
            
            <?php
            }
            ?>
            
            
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