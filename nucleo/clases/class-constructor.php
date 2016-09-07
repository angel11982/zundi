<?php
header('Content-Type: text/html; charset=utf-8');

class CONSTRUCTOR{

  var $query;
  var $autentificacion;
  var $get;
  var $sesion;
  var $plantilla;
  var $brand;
  var $mensaje;
  var $error;
  var $usuario;
  var $redireccion;
  var $header;
  var $footer;
  var $nav;
  var $categoria;
  var $class_pagina;
  var $class_modulo;
  var $class_sistema;
  var $mail;
  var $archivos;
  var $form;

  function __construct() {



    header('Content-Type: text/html; charset=utf8');
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
    ini_set('display_errors','On');

    /* VARIABLES DEL SITIO */
    define('_RUTA_HOST',str_replace("/nucleo/clases","",str_replace("\\", "/", dirname(__FILE__)))."/");


    define('_RUTA_WEB_temp',"http://".str_replace("\\", "/", $_SERVER['SERVER_NAME'])."/");


	array_walk($_POST, 'limpiar_cadena');
	array_walk($_GET, 'limpiar_cadena');

    if(isset($_GET["mod_id"])){
      if (!is_numeric($_GET["mod_id"])){
        define('_ID_MODULO', $_GET["mod_id"]);
      }
    }

    if(isset($_GET["id"])){
    	if (!is_numeric($_GET["id"])){
    		header("Location:../index.php?s="._RUTA_DEFAULT."&cat=".$cat."&pla=".$pla."&tarea=error-id");
    	}
    }

    define('_VZ', "Zundi 2.0.1");

    require_once(_RUTA_HOST."nucleo/config.php");


    // echo "host:"._HOST."</br>";
    // echo "us:"._USUARIO."</br>";
    // echo "pw:"._PASSWORD."</br>";
    // echo "bd:"._BASE_DE_DATOS."</br>";
    //echo "ruta-host:"._RUTA_HOST."</br>";
    //echo "ruta-web:"._RUTA_WEB."</br>";
    // echo "version:"._VZ."</br>";
    // echo "ruta-default:"._RUTA_DEFAULT."</br>";
    //echo "ruta-server:"._RUTA_SERVER."</br>";

    require_once(_RUTA_HOST."nucleo/clases/class-sesion.php");
    require_once(_RUTA_HOST."nucleo/clases/class-mysql.php");

    $sesion = new SESION($this);
    $sesion->iniciar_sesion();

    $query = new MYSQL();
    $query->conectar(_BASE_DE_DATOS,_HOST,_USUARIO,_PASSWORD);

    require_once(_RUTA_HOST."nucleo/clases/class-get.php");
    require_once(_RUTA_HOST."nucleo/clases/class-plantilla.php");
    require_once(_RUTA_HOST."nucleo/clases/class-errores.php");
    require_once(_RUTA_HOST."nucleo/clases/class-redireccion.php");
    require_once(_RUTA_HOST."nucleo/clases/class-mensajes.php");
    require_once(_RUTA_HOST."nucleo/clases/class-autentificacion.php");
    require_once(_RUTA_HOST."nucleo/clases/class-brand.php");
    require_once(_RUTA_HOST."nucleo/clases/class-usuarios.php");
    require_once(_RUTA_HOST."nucleo/clases/class-header.php");
    require_once(_RUTA_HOST."nucleo/clases/class-footer.php");
    require_once(_RUTA_HOST."nucleo/clases/class-sistemas.php");
    require_once(_RUTA_HOST."nucleo/clases/class-modulos.php");
    require_once(_RUTA_HOST."nucleo/clases/class-paginas.php");
    require_once(_RUTA_HOST."nucleo/clases/class-nav.php");
    require_once(_RUTA_HOST."nucleo/clases/class-categorias.php");
    require_once(_RUTA_HOST."nucleo/clases/class-mail.php");
    require_once(_RUTA_HOST."nucleo/clases/class-archivos.php");
    require_once(_RUTA_HOST."nucleo/clases/class-form.php");


    // $get = new GET($this);
    // $autentificacion = new AUTENTIFICACION($this);
    // $plantilla = new PLANTILLA($this);
    // $brand = new BRAND($this);
    // $error = new ERROR($this);
    // $redireccion = new REDIRECCION($this);
    // $mensaje = new MENSAJE($this);
    // $usuario = new USUARIO($this);
    // $header = new HEADER($this);
    // $class_pagina = new CLASSPAGINA($this);
    // $class_modulo = new CLASSMODULO($this);

    $this->query = $query;
    $this->sesion = $sesion;
    $this->get = new GET($this);
    $this->autentificacion = new AUTENTIFICACION($this);
    $this->plantilla = new PLANTILLA($this);
    $this->brand = new BRAND($this);
    $this->mensaje = new MENSAJE($this);
    $this->error = new ERROR($this);
    $this->usuario = new USUARIO($this);
    $this->redireccion =  new REDIRECCION($this);
    $this->header = new HEADER($this);
    $this->footer = new FOOTER($this);
    $this->class_pagina = new CLASSPAGINAS($this);
    $this->class_modulo = new CLASSMODULOS($this);
    $this->class_sistema = new CLASSSISTEMAS($this);
    $this->nav = new NAV($this);
    $this->categoria = new CATEGORIA($this);
    $this->mail = new MAIL($this);
    $this->archivos = new ARCHIVOS($this);
    $this->form = new FORM($this);


  }

	function limpiar_cadena($valor){
		$valor = str_ireplace("SELECT","",$valor);
		$valor = str_ireplace("COPY","",$valor);
		$valor = str_ireplace("DELETE","",$valor);
		$valor = str_ireplace("DROP","",$valor);
		$valor = str_ireplace("DUMP","",$valor);
		$valor = str_ireplace(" OR ","",$valor);
		$valor = str_ireplace("%","",$valor);
		$valor = str_ireplace("LIKE","",$valor);
		$valor = str_ireplace("--","",$valor);
		$valor = str_ireplace("^","",$valor);
		$valor = str_ireplace("[","",$valor);
		$valor = str_ireplace("]","",$valor);
		$valor = str_ireplace("\'","",$valor);
		$valor = str_ireplace("!","",$valor);
		$valor = str_ireplace("¡","",$valor);
		$valor = str_ireplace("?","",$valor);
		$valor = str_ireplace("=","",$valor);
		$valor = str_ireplace("&","",$valor);
		//$valor = addslashes($valor);
		return $valor;
	}


}


?>
