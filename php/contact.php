<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

extract($_REQUEST);

// 0 -> PHP
// 1 -> AJAX
$tipo_de_procesamiento = 0;

/* *
Códigos de error
0 -> Todo correcto
1 -> Un campo vacío
2 -> No se pudo enviar el mensaje, problema ajeno a validaciones
3 -> No se seleccionó Captcha

* */

$captcha_es_valido = validarReCaptcha($_REQUEST['g-recaptcha-response']);
if (!$captcha_es_valido) {
  mandarError("3");
}

if (!validarVariable($nombre)|| !validarVariable($email) || !validarVariable($tel) || !validarVariable($asunto) || !validarVariable($msj)) {
  mandarError("1");
}

$correo_nuevo = new Correo("ivonne.mtz.manzo@gmail.com", $nombre.' ha enviado un nuevo mensaje');
$correo_nuevo->agregarCampos("Nombre: ", $nombre);
$correo_nuevo->agregarCampos("Email: ", $email);
$correo_nuevo->agregarCampos("Teléfono: ", $tel);
$correo_nuevo->agregarCampos("Asunto: ", $asunto);
$correo_nuevo->agregarCampos("Mensaje: ", $msj);
// $correo_nuevo->agregarCampos("Mensaje: ", $msj);
$enviado = $correo_nuevo->enviarEmail();

if ($enviado) {
  mandarError("0");

  //echo json_encode(array('success' => 1));
} else {
  mandarError("2");
   //echo json_encode(array('error' => 1));
}

function mandarError($codigo_de_error)
{
    
  if ($GLOBALS["tipo_de_procesamiento"] == 0) {
      
       //header('location: index.html?err=' .$codigo_de_error);
     
    if($codigo_de_error == "0"){
        header('location: /contacto.php?msj='. $codigo_de_error);
        exit;   
    }
        if($codigo_de_error == "1"){
            header('location: /contacto.php?msj='. $codigo_de_error);
             exit;
    exit;   
    }if($codigo_de_error == "2"){
        header('location: /contacto.php?msj='. $codigo_de_error);
        exit;
      
    exit;   
    }
     if($codigo_de_error == "3"){
        header('location: /contacto.php?msj=' . $codigo_de_error);
        exit;
      
    exit;   
    }
  else {
    echo json_encode(array('error' => $codigo_de_error));
    exit;
  }

  }  
}


function validarVariable($variable_del_formulario)
{

  $es_valida = true;
  $variable_del_formulario = trim($variable_del_formulario);

  if ($variable_del_formulario == "") {
    $es_valida = false;
  }

  return $es_valida;
}

function validarReCaptcha($g_recaptcha)
{

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    "secret=6Lf92OAfAAAAAGGejKGqc94KGRbvBG1S9clILw2m&response=$g_recaptcha"
  );




  // In real life you should use something like:
  // curl_setopt($ch, CURLOPT_POSTFIELDS, 
  //          http_build_query(array('postvar1' => 'value1')));

  // Receive server response ...


   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $server_output = curl_exec($ch);
   $json_response = json_decode($server_output);


  // no $success = $json_response['success'];
  // no var_dump($success);


 $success = $json_response->success;
  curl_close($ch);
  return $success;
}

class Correo
{

  private $datos;
  private $para;
  private $titulo;
  public $cuerpo;
  private $cabeceras = "";


  function __construct($paraEntrada, $tituloEntrada)
  {
    $this->para = $paraEntrada;
    $this->titulo = $tituloEntrada;
  }

  public function agregarCampos($mensaje, $variable)
  {
    $this->datos[$mensaje] = $variable;
  }

  private function primeraParteDelCuerpo()
  {
    $this->cuerpo = '
    <!doctype html>
    <html lang="es">
      <head>
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style>
        @media only screen and (max-width: 620px) {
          table[class=body] h1 {
            font-size: 28px !important;
            margin-bottom: 10px !important;
          }
          table[class=body] p,
                table[class=body] ul,
                table[class=body] ol,
                table[class=body] td,
                table[class=body] span,
                table[class=body] a {
            font-size: 16px !important;
          }
          table[class=body] .wrapper,
                table[class=body] .article {
            padding: 10px !important;
          }
          table[class=body] .content {
            padding: 0 !important;
          }
          table[class=body] .container {
            padding: 0 !important;
            width: 100% !important;
          }
          table[class=body] .main {
            border-left-width: 0 !important;
            border-radius: 0 !important;
            border-right-width: 0 !important;
          }
          table[class=body] .btn table {
            width: 100% !important;
          }
          table[class=body] .btn a {
            width: 100% !important;
          }
          table[class=body] .img-responsive {
            height: auto !important;
            max-width: 100% !important;
            width: auto !important;
          }
        }
        @media all {
          .ExternalClass {
            width: 100%;
          }
          .ExternalClass,
                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass font,
                .ExternalClass td,
                .ExternalClass div {
            line-height: 100%;
          }
          .apple-link a {
            color: inherit !important;
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            text-decoration: none !important;
          }
          .btn-primary table td:hover {
            background-color: #34495e !important;
          }
          .btn-primary a:hover {
            background-color: #34495e !important;
            border-color: #34495e !important;
          }
        }
        </style>
      </head>
      <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
        <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
          <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
            <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
              <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
                  <!-- START MAIN CONTENT AREA -->
                  <tr>
                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                        <tr>
                          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Has recibido un nuevo mensaje</p>
                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Estos son los datos que ha proporcionado:</p>';
  }

  private function construirCabeceras()
  {
    $this->cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $this->cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Cabeceras adicionales
    $this->cabeceras .= 'From: Banana Team<info@bananagroup.mx>' . "\r\n";
  }

  private function construirEmail()
  {
    $this->primeraParteDelCuerpo();

    $temp = '';

    foreach ($this->datos as $mensaje => $variable) {
      $temp = '<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">' . $mensaje . '<strong>' . $variable . '.</strong></p>';
      $this->cuerpo .= $temp;
    }

    $this->cuerpo .= ' </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              <!-- END MAIN CONTENT AREA -->
              </table>
              <!-- START FOOTER -->
              <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                  <tr>
                    <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                      <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">Copyright © 2022 Todos los Derechos Reservados.</span>
                      <br>Los Cabos, B.C.S. México.
                    </td>
                  </tr>
                  <tr>
                    <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                      Powered by <a href="#" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;"><strong>Prueba Captcha</strong>.</a>
                    </td>
                  </tr>
                </table>
              </div>
              <!-- END FOOTER -->
            <!-- END CENTERED WHITE CONTAINER -->
            </div>
          </td>
          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        </tr>
      </table>
        </body>
      </html>';
  }

  public function enviarEmail()
  {
    $this->construirEmail();
    $this->construirCabeceras();
    $enviado = mail($this->para, $this->titulo, $this->cuerpo, $this->cabeceras);
    return $enviado;
  }
}