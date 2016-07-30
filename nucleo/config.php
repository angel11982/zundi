<?php

  /*  VARIABLES PARA LA CONEXION A LA BASE DE DATOS */
    $db="landicorp";
    if ($db=="landicorp"){
      define('_RUTA_DEFAULT','mainter');
      define('_HOST','localhost');
      define('_USUARIO','root');
      define('_PASSWORD','landimysql');
      define('_BASE_DE_DATOS','landicorp');
    }
    define("_RUTA_WEB", _RUTA_WEB_temp."mainter/");
    define("_RUTA_SERVER",str_replace(_RUTA_DEFAULT."/","",_RUTA_HOST));
    define("_RUTA_HT",str_replace(_RUTA_DEFAULT."/mainter/","",_RUTA_HOST));
    
?>