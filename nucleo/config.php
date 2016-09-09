<?php

  /*  VARIABLES PARA LA CONEXION A LA BASE DE DATOS */
    $db="victoria";
    
    if ($db=="next"){
      define('_RUTA_DEFAULT','next');
      define('_HOST','localhost');
      define('_USUARIO','root');
      define('_PASSWORD','asdf123A');
      define('_BASE_DE_DATOS','next');
    }
    
    if ($db=="victoria"){
      define('_RUTA_DEFAULT','victoria');
      define('_HOST','localhost');
      define('_USUARIO','root');
      define('_PASSWORD','asdf123A');
      define('_BASE_DE_DATOS','victoria');
    }
    
    define("_MULTIPLE_SITE", "off");// on - off
    define("_RUTA_WEB", _RUTA_WEB_temp."zundi/");
    define("_RUTA_SERVER",str_replace(_RUTA_DEFAULT."/","",_RUTA_HOST));
    define("_RUTA_HT",str_replace(_RUTA_DEFAULT."/zundi/","",_RUTA_HOST));
    //echo  _RUTA_WEB;
?>
