                <style>
                    
                   
                    .alert {
                        position: fixed;
                        right: 8px;
                        top: 85%;
                        z-index: 999;
                        padding: 20px;
                        color: white !important;
                    }
                        
                    .danger {
                        background-color: #ff6c6c;
                    }
                    .success {
                        background-color: #39d040;
                    }
                    .warning {
                        background-color: #fbc038;
                    }
                    
                    .closebtn {
                      margin-left: 15px;
                      color: white;
                      font-weight: bold;
                      float: right;
                      font-size: 22px;
                      line-height: 20px;
                      cursor: pointer;
                      transition: 0.3s;
                    }
                    
                    .closebtn:hover {
                      color: black;
                    }
                    
                </style>
                
                <script>
                    function closeAlert() {
                        document.getElementById("alert").style.display = "none";
                    }
                    
                    setTimeout(function() {
                        $('#alert').fadeOut('fast');
                    }, 5000);
                    
                </script>
                
                <?php
                //FUNCION PARA DECIFRAR LOS DATOS
               
                $msg = $db->getAllRecords('msgStatus','*','AND msg="'.$_COOKIE ['msg'].'"','LIMIT 1');

                if (!($msg)) {
                    echo "";
                }  else {
                    
                    $msg = $msg [0];

                
                    echo'<div id="alert" class="mt-50 alert '.$msg['estilo'].'">';
                    echo'<span class="closebtn" onclick="closeAlert()">&times;</span>';
                    echo''.$msg['mensaje'].'';
                    echo'</div>';
                    
                }

                unset ($_COOKIE ['msg']);
                
                ?>
	
                