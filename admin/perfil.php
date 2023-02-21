<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/include/funciones.php");


    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    
    date_default_timezone_set('America/Tijuana');   
    $fecha = date("Y-m-d H:i:s");

    if (($UserData['rol'])>2) {
        setcookie("msg","sad",time() + 2, "/");
        header('Location: /');
    }
    //OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0];
    $rol = ($rol['nombre']);
    


if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
	extract($_REQUEST);
	if(($nombre=="")&($email=="")){
		header('location:?msg=vacio');
		exit;
	}else if($nombre==""){
		header('location:?msg=nombre');
		exit;
	}else if($email==""){
		header('location:?msg=email');
		exit;
	} else if(!isEmail($email)) {
		header('location:?msg=noemail');
		exit;
	}else{

        
        $codigo = ($UserData['fPerfil']); //SI NO SE SUBE LA FOTO LE DAMOS EL VALOR EXISTENTE A CODIGO
         
        if (!empty($_FILES['thumb']['tmp_name'])) {
            
            $thumb = $_FILES['thumb']['tmp_name']; //DEFINIMOS LA VARIABLE THUMB YA SABEMOS QUE SI SE CARGÓ UNA FOTO
            
            if($_FILES['thumb']['type'] !== 'image/jpeg'){ 
		      header('location:?msg=fnv');
		      exit;
            }
            
            if(($_FILES['thumb']['size']) > 1000000){ //MÁXIMO 1MB
		      header('location:?msg=fnvz');
		      exit;
            }
            
            if (($UserData['fPerfil'])!==""){
                $archivo = '../upload/usuarios/'.(strftime("%Y", strtotime(($UserData['fr'])))).'/'.(strftime("%m", strtotime(($UserData['fr'])))).'/'.($UserData['fPerfil']).'.jpg';
                unlink($archivo); //BORRAMOS LA FOTO ANTIGUA SACANDO EL NOMBRE DE LA BASE DE DATOS
            }
            
                $codigo = GeraHash(10); //LO USAMOS PARA EL NOMBRE DE LA FOTO
                $ruta = '../upload/usuarios/'.(strftime("%Y", strtotime(($UserData['fr'])))).'/'.(strftime("%m", strtotime(($UserData['fr'])))).'';
            
        
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
							'nombre'=>$nombre,
                            'email'=>$email,
                            'fa'=>$fecha,
                            'fPerfil'=>$codigo,
                            
						);
	       $update	=	$db->update('usuarios',$data,array('id'=>($UserData['id'])));
    
            if($update){
                setcookie("msg","rus",time() + 2, "/");
                header('location: '); //Exito en el cmabio
                exit;}
            else{
                setcookie("msg","ups",time() + 2, "/");
                header('location: '); //sin cambios
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
  <link rel="stylesheet" href="/admin/assets/bundles/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="/admin/assets/bundles/summernote/summernote-bs4.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="/admin/assets/css/style.css">
  <link rel="stylesheet" href="/admin/assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="/admin/assets/css/custom.css">
  
        
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
      
      <div class="main-content">
        <section class="section">
          <ul class="breadcrumb breadcrumb-style ">
            <li class="breadcrumb-item">
              <h4 class="page-title m-b-0">Mi perfil</h4>
            </li>
            <li class="breadcrumb-item">
              <a href="/">
                <i data-feather="home"></i></a>
            </li>
            <li class="breadcrumb-item"><?php echo ($UserData['nombre']); ?></li>
          </ul>
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="card author-box">
                  
                    <form method="post" class="needs-validation">
                        <div class="card-header">
                            <h4>Editar perfil</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Nombre*</label>
                                    <input type="text" name="nombre" class="form-control" value="<?php echo ($UserData['nombre']); ?>">
                                    <div class="invalid-feedback">
                                      Ingresa tu nombre
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Correo electrónico*</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo ($UserData['email']); ?>">
                                    <div class="invalid-feedback">
                                      Ingresa un correo electronico
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7 col-12">
                                    <label>Cambia tu imagen de perfil</label>
                                    <div class="col-sm-12 col-md-7">
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">Cargar imágen</label>
                                            <input type="file" name="thumb" id="image-upload" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Guardar</button>
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
  <script src="/admin/assets/js/scripts.js"></script>
  <script src="/admin/assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
  <!-- Custom JS File -->
  <script src="/admin/assets/js/custom.js"></script>
</body>
</html>