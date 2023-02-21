<style>
    .alert {
        position: fixed;
        right: 25px;
        bottom: 8%;
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
if (isset($_GET)) {
    extract($_GET);
    switch ($msj) {
        case '0':
            echo'<div id="alert" class="mt-50 alert success">';
            echo'<span class="closebtn" onclick="closeAlert()">&times;</span>';
            echo'¡Tu mensaje ha sido enviado!';
            echo'</div>';
            break;
        case '1':
            echo'<div id="alert" class="mt-50 alert warning">';
            echo'<span class="closebtn" onclick="closeAlert()">&times;</span>';
            echo'¡Todos los campos deben de estar llenos!';
            echo'</div>';
            break;
        case '2':
            echo'<div id="alert" class="mt-50 alert danger">';
            echo'<span class="closebtn" onclick="closeAlert()">&times;</span>';
            echo'¡Tu mensaje no se pudo enviar, intenta más tarde!';
            echo'</div>';
            break;
        case '3':
            echo'<div id="alert" class="mt-50 alert warning">';
            echo'<span class="closebtn" onclick="closeAlert()">&times;</span>';
            echo'¡Verifica la casilla de reCaptcha!';
            echo'</div>';
            break;
    }
}
    
?>

