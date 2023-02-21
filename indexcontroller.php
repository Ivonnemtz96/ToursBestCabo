<?php 

    if (isset($_SERVER['HTTP_REFERER'])) {
        $url = $_SERVER['HTTP_REFERER'];
    } else {
        $url = "/";
    }
    


    if(!isset ($_COOKIE["lang"])){
    setcookie("lang","en", time() + (365 * 24 * 60 * 60));
    header('location:' . $url . '');

    }
    else{
        $lenguaje = $_COOKIE["lang"];
    }
    

    //isset verifica que la variable exista, sin dar error
    //regresa true or false
    //Verificar si existe ?lang=en 贸 ?lang=es en la url
    if (isset($_REQUEST["lang"])) {
    //Si existe, creamos una cookie con ese valor,
    //para que la siguiente vez que el cliente entre,
    //ya tengamos una cookie con el 煤ltimo idioma que eligi贸
    $lenguaje = $_REQUEST["lang"];
    setcookie("lang", $lenguaje, time() + (365 * 24 * 60 * 60));
    header('location:' . $url . '');


    }

    
    