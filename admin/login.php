<?php  
 session_start();  
 require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if (isset($_SESSION['UserId'])) {
            
            setcookie("msg","ylog",time() + 1, "/");
            header("location: /admin");
            exit;
        } 

 try
 {   
      $connect = new PDO("mysql:host=".SS_DB_HOST."; dbname=".SS_DB_NAME."", SS_DB_USER, SS_DB_PASSWORD);  
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      if(isset($_POST["submit"]))  
      {  
           if(empty($_POST["email"]) || empty($_POST["password"]))  
           {
               setcookie("msg","all",time() + 1, "/");
               header("location: /admin/login");
           }  
           else  
           {  
                $query = "SELECT * FROM usuarios WHERE email = :email AND pass = :password";  
                $statement = $connect->prepare($query);  
                $statement->execute(  
                     array(  
                          'email'     => $_POST["email"],
                          'password'  => $_POST["password"],
                     ) 
                );  
                $count = $statement->rowCount();
                if($count > 0)  
                {  
                     
                    //ESTABLECEMOS LA HORA IGUAL QUE EN LOS CABOS
                    date_default_timezone_set('America/Denver');   
                    $fecha = date("Y-m-d H:i:s");
                    //OBTENEMOS DATOS DE USUARIO
                    $UserData =	$db->getAllRecords('usuarios','*',' AND email="'.($_POST["email"]).'"LIMIT 1 ');
                    $UserData = $UserData[0];
                    $_SESSION['UserId'] = $UserData['id'];
                    //ACTUALIZAMOS LA FECHA DEL ÚLTIMO LOGIN
                    $InsertData	=	array(
                                    'fl'=> $fecha,
                                 );
                    $update	=	$db->update('usuarios',$InsertData,array('id'=>($UserData['id'])));
                    
                    setcookie("msg","bienvenido",time() + 1, "/");
                    header("location: /admin");
                }  
                else  
                {  
                    setcookie("msg","inv",time() + 1, "/");
                    header("location: /admin/login");
                }
           }
      }  
 }  
 catch(PDOException $error)  
 {  
      $message = $error->getMessage();  
 }  ?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/title.php");?>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="/admin/assets/css/app.min.css">
  <link rel="stylesheet" href="/admin/assets/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="/admin/assets/css/style.css">
  <link rel="stylesheet" href="/admin/assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="/admin/assets/css/custom.css">
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <?php
            //MENSAJES DE ESTATUS
            if(isset($_COOKIE["msg"])) {
            require_once($_SERVER["DOCUMENT_ROOT"]."/include/msg.php");
            } ?>
        </div>
    </div>
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Iniciar Sesión</h4>
              </div>
              <div class="card-body">
                <form method="POST" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Por favor ingresa tu correo electrónico.
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Contraseña</label>
                      
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Por favor ingresa tu contraseña.
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Acceder
                    </button>
                  </div>
                </form>
                  
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="/admin/assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="/admin/assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="/admin/assets/js/custom.js"></script>
</body>

</html>