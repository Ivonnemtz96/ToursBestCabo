<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/sesion.php");

    if (($UserData['rol'])>2) {
        setcookie("msg","sad",time() + 2, "/");
        header('Location: /');
    }

    //Contadores
    $userCount   =  $db->getQueryCount('usuarios','id');
    $tUsuarios   = ($userCount[0]['total']);

    $pedCount	 =	$db->getQueryCount('pedidos','*','AND status="3" ');
    $tPedidos   = ($pedCount[0]['total']);

  
    //OBTENER RANGO POR ID
    $rol = $db->getAllRecords('roles','*',' AND id="'.($UserData['rol']).'"LIMIT 1 ');
    $rol = $rol[0];
    $rol = ($rol['nombre']);

    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/graficas/semanal.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/graficas/anual.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/graficas/stats.php");
    
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/admin/modulos/title.php");?>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="/admin/assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="/admin/assets/css/style.css">
  <link rel="stylesheet" href="/admin/assets/css/components.css">
  <link rel="stylesheet" href="/admin/assets/bundles/jqvmap/dist/jqvmap.min.css">
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
                <h4 class="page-title m-b-0">Panel de control</h4>
              </li>
              <li class="breadcrumb-item">
                <a href="index.html">
                  <i data-feather="home"></i></a>
              </li>
              <li class="breadcrumb-item">Resumen</li>
            </ul>
            
            <div class="section-body">
                <div class="row clearfix">
                    <div class="col-md-3">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="card l-bg-orange">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="text-white">
                                                    <h4 class="mb-0 font-26 text-white">$ <?php echo number_format($cifra1,2);?></h4>
                                                    <p class="mb-2 text-white"><?php echo $res1;?> reservas</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-white">
                                                    <p class="mb-2 text-white text-right">Ingresos hoy</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card l-bg-green">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="text-white">
                                                    <h4 class="mb-0 font-26 text-white">$ <?php echo number_format($cifra2,2);?></h4>
                                                    <p class="mb-2 text-white"><?php echo $res2;?> reservas</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-white">
                                                    <p class="mb-2 text-white text-right">Ingresos ayer</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card l-bg-blue">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="text-white">
                                                    <h4 class="mb-0 font-26 text-white">$ <?php echo number_format($cifra3,2);?></h4>
                                                    <p class="mb-2 text-white"><?php echo $res3;?> reservas</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-white">
                                                    <p class="mb-2 text-white text-right">Ingresos ultimos 7 días</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h4>Reservas los últimos 7 días</h4>
                            </div>
                            <div class="card-body">
                                <div class="recent-report__chart">
                                    <div id="semanal"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                
            </div>
            <div class="section-body">
                <div class="row clearfix">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Reservas los últimos 12 meses</h4>
                            </div>
                            <div class="card-body">
                                <div class="recent-report__chart">
                                    <div id="anual"></div>
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
        <script src="assets/js/app.min.js"></script>
        <!-- JS Libraies -->
        <script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
        <!-- Template JS File -->
        <script src="assets/js/scripts.js"></script>
        <!-- Custom JS File -->
        <script src="assets/js/custom.js"></script>
        
        
        <script>
        "use strict";
            $(function () {
                semanal();
                anual();
            });

            function anual() {
                var options = {
                    chart: {
                        height: 350,
                        type: "bar",
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            endingShape: "rounded",
                            columnWidth: "55%",
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ["transparent"],
                    },
                    series: [
                        {
                            name: "Pagadas",
                            data: [<?php echo $pagTmes1;?>, <?php echo $pagTmes2;?>, <?php echo $pagTmes3;?>, <?php echo $pagTmes4;?>, <?php echo $pagTmes5;?>, <?php echo $pagTmes6;?>, <?php echo $pagTmes7;?>, <?php echo $pagTmes4;?>, <?php echo $pagTmes9;?>, <?php echo $pagTmes9;?>, <?php echo $pagTmes11;?>, <?php echo $pagTmes12;?>],
                        },
                        {
                            name: "Olvidadas",
                            data: [<?php echo $olvTmes1;?>, <?php echo $olvTmes2;?>, <?php echo $olvTmes3;?>, <?php echo $olvTmes4;?>, <?php echo $olvTmes5;?>, <?php echo $olvTmes6;?>, <?php echo $olvTmes7;?>, <?php echo $olvTmes4;?>, <?php echo $olvTmes9;?>, <?php echo $olvTmes9;?>, <?php echo $olvTmes11;?>, <?php echo $olvTmes12;?>],
                        },
                        {
                            name: "Canceladas",
                            data: [<?php echo $canTmes1;?>, <?php echo $canTmes2;?>, <?php echo $canTmes3;?>, <?php echo $canTmes4;?>, <?php echo $canTmes5;?>, <?php echo $canTmes6;?>, <?php echo $canTmes7;?>, <?php echo $canTmes4;?>, <?php echo $canTmes9;?>, <?php echo $canTmes9;?>, <?php echo $canTmes11;?>, <?php echo $canTmes12;?>],
                        },
                    ],
                    xaxis: {
                        categories: [
                            "<?php echo $mes1;?>",
                            "<?php echo $mes2;?>",
                            "<?php echo $mes3;?>",
                            "<?php echo $mes4;?>",
                            "<?php echo $mes5;?>",
                            "<?php echo $mes6;?>",
                            "<?php echo $mes7;?>",
                            "<?php echo $mes8;?>",
                            "<?php echo $mes9;?>",
                            "<?php echo $mes10;?>",
                            "<?php echo $mes11;?>",
                            "<?php echo $mes12;?>",
                        ],
                        labels: {
                            style: {
                                colors: "#8e8da4",
                            },
                        },
                    },
                    yaxis: {
                        title: {
                            text: "No. de reservas",
                        },
                        labels: {
                            style: {
                                color: "#8e8da4",
                            },
                        },
                    },
                    colors: ['#33b2df', '#546E7A', '#d4526e'],
                    fill: {
                        opacity: 1,
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "" + val + " reservas";
                            },
                        },
                    },
                };
                
                var chart = new ApexCharts(document.querySelector("#anual"), options);
                
                chart.render();
            }
            
            function semanal() {
                var options = {
                    series: [{
                        name: 'Pagadas',
                        data: [<?php echo $pagtdia1;?>, <?php echo $pagtdia2;?>, <?php echo $pagtdia3;?>, <?php echo $pagtdia4;?>, <?php echo $pagtdia5;?>, <?php echo $pagtdia6;?>, <?php echo $pagtdia7;?>]
                    }, {
                        name: 'Olvidadas',
                        data: [<?php echo $olvtdia1;?>, <?php echo $olvtdia2;?>, <?php echo $olvtdia3;?>, <?php echo $olvtdia4;?>, <?php echo $olvtdia5;?>, <?php echo $olvtdia6;?>, <?php echo $olvtdia7;?>]
                    }, {
                        name: 'Por pagar',
                        data: [<?php echo $portdia1;?>, <?php echo $portdia2;?>, <?php echo $portdia3;?>, <?php echo $portdia4;?>, <?php echo $portdia5;?>, <?php echo $portdia6;?>, <?php echo $portdia7;?>]
                    }, {
                        name: 'Canceladas',
                        data: [<?php echo $cantdia1;?>, <?php echo $cantdia2;?>, <?php echo $cantdia3;?>, <?php echo $cantdia4;?>, <?php echo $cantdia5;?>, <?php echo $cantdia6;?>, <?php echo $cantdia7;?>]
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        stacked: true,
                        stackType: '100%'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    xaxis: {
                        categories: ['<?php echo $dia1;?>', '<?php echo $dia2;?>', '<?php echo $dia3;?>', '<?php echo $dia4;?>', '<?php echo $dia5;?>', '<?php echo $dia6;?>', '<?php echo $dia7;?>'],
                    },
                    colors: ['#33df7b', '#33b2df', '#546E7A', '#d4526e'],
                    fill: {
                        opacity: 1
                    },
                    
                };
                
                var chart = new ApexCharts(document.querySelector("#semanal"), options);
                chart.render();
            }
            
    
        </script>
     
    
    
</body>

</html>