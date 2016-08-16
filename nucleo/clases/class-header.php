<?php
header('Content-Type: text/html; charset=utf-8');

class HEADER{

  var $fmt;

  function __construct($fmt) {
    $this->fmt = $fmt;
  }

  function header_html($cat){
    $aux  = '<!DOCTYPE HTML>'."\n";
    $aux .= '<html id="pagIndex" lang="ES">'."\n";
    $aux .= '<head>'."\n";
    $aux .= '	<title> '.$this->nombre_sitio($cat).'</title>'."\n"; //Trabajar
    $aux .= '	<link rel="shortcut icon" href="'._RUTA_WEB.$this->get_favicon($cat).'" />'."\n";  //Trabajar
    $aux .= '        <!--  Este sitio esta desarrollado en zundi cms -> http://github.com/zundi -->'."\n";
    $aux .= '	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">'."\n";
    $aux .= '	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">'."\n";
    $aux .= '	<meta http-equiv="X-UA-Compatible" content="IE=10" />'."\n";
    $aux .= '	<meta http-equiv="X-UA-Compatible" content="IE=9" />'."\n";
    $aux .= '	<meta http-equiv="X-UA-Compatible" content="IE=8" />'."\n";
    $aux .= '	<meta http-equiv="X-UA-Compatible" content="IE=7" />'."\n";

    $aux .= '          <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
          <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
          <script src="js/respond.min.js"></script>
          <![endif]-->'."\n";
    $aux .= $this->ruta_analitica()." \n";
    $aux .= $this->css()." \n";
    $aux .= $this->js()." \n";

    return $aux;
  }

  function nombre_sitio($cat){
	$cat_tipo =  $this->fmt->categoria->categoria_id_tipo($cat);
	$cat_padre= $this->fmt->categoria->categoria_id_padre($cat);
	$cat_nombre= $this->fmt->categoria->nombre_categoria($cat);
	$consulta = "SELECT conf_nombre_sitio FROM configuracion";
	$rs = $this->fmt->query->consulta($consulta);
	$fila = $this->fmt->query->obt_fila($rs);
	$nombre=$fila["conf_nombre_sitio"];

	if ( ($cat_padre=='0')&&($cat_tipo=='2')||($cat=='1')) {
		if ($cat==1){
			$nombre = $nombre;
		}else{
			$nombre = $cat_nombre;
		}
	}else{
		$cat_padre_sitio =  $this->fmt->categoria->categoria_padre_sitio($cat);
		if (!empty($cat_padre_sitio)){
			$nombre= $this->fmt->categoria->nombre_categoria($cat_padre_sitio)." - ".$cat_nombre;
		}else{
	    	
			if (empty($nombre)){ $nombre = _VZ; }
	    }
    }
    return $nombre;
  }

  function get_favicon($cat){


	$cat_tipo = $this->fmt->categoria->categoria_id_tipo($cat);
	$cat_padre= $this->fmt->categoria->categoria_id_padre($cat);
	
	$consulta = "SELECT conf_favicon FROM configuracion";
	$rs = $this->fmt->query->consulta($consulta);
	$fila = $this->fmt->query->obt_fila($rs);
	$fav=$fila["conf_favicon"];
	

	if ( ($cat_padre=='0')&&($cat_tipo=='2')||($cat=='1')) {
		$cat_favicon= $this->fmt->categoria->favicon_categoria($cat);
		if (!empty($cat_favicon)){
			return $cat_favicon;
		} else {
			if (empty($fav)){
			return "images/favicon.ico";
			}else{
			return $fav;	
			}
		}
	}else{
		$cat_padre_sitio =  $this->fmt->categoria->categoria_padre_sitio($cat);
		if (!empty($cat_padre_sitio)){
			return $this->fmt->categoria->favicon_categoria($cat_padre_sitio);
		}else{
	    	if (empty($fav)){
			return "images/favicon.ico";
			}else{
			return $fav;	
			}
	    }
    }
  }

  function padre_cat($cat){
    if(isset($_GET["cat"])){
      if (!is_numeric($_GET["cat"])){
        $id_cat_padre=$this->traer_padre($_GET["cat"]);
      }
    }else{
        $id_cat_padre=1;
    }
  }

  function ruta_analitica(){
    //echo "ruta analitica";
      $consulta = "SELECT conf_ruta_analitica FROM configuracion";
      $rs = $this->fmt->query->consulta($consulta);
      $fila = $this->fmt->query->obt_fila($rs);
      $ruta=$fila["conf_ruta_analitica"];
      return "        <meta ".$ruta." ej:analitica />"."\n";

  }

  function css(){
    $aux  = '       <link rel="stylesheet" href="'._RUTA_WEB.'css/bootstrap.min.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/font-awesome.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/animate.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/color.adm.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/icon-font.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/lato-font.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/sf-ui-font.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/summernote.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/estilos.adm.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/theme.adm.css" rel="stylesheet" type="text/css">'."\n";
    $aux .= '       <link rel="stylesheet" href="'._RUTA_WEB.'css/fileinput.min.css" rel="stylesheet" type="text/css">'."\n";

    return $aux;
  }

  function js(){
    $aux  = '       <script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/jquery.js"></script>'."\n";
    $aux .= '       <script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/bootstrap.js"></script>'."\n";
    $aux .= '<script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/jquery.dataTables.min.js"></script>'."\n";
	//$aux .= '       <script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/dataTables.bootstrap.js"></script>'."\n";

	$aux .= '		<script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/summernote.js"></script>'."\n";
	$aux .= '		<script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/summernote-es-ES.min.js"></script>'."\n";
	$aux .= '		<script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/jquery.mixitup.js"></script>'."\n";
	$aux .= '		<script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/jquery.mixitup-pagination.min.js"></script>'."\n";
	$aux .= '		<script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/fileinput.min.js"></script>'."\n";
	$aux .= '		<script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/fileinput.es.js"></script>'."\n";

    return $aux;
  }

  function header_modulo(){
    $aux  = '<!DOCTYPE HTML>'."\n";
    $aux .= '<html id="pagina-modulo" lang="ES">'."\n";
    $aux .= '<head>'."\n";
    $aux .= '	<title> '.$this->nombre_sitio().'</title>'."\n"; //Trabajar
    $aux .= '	<link rel="shortcut icon" href="'._RUTA_WEB.$this->get_favicon($cat).'" />'."\n";  //Trabajar
    $aux .= '        <!--  Este sitio esta desarrollado en zundi cms -> http://github.com/zundi -->'."\n";
    $aux .= '	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">'."\n";
    $aux .= '	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">'."\n";
    $aux .= '	<meta http-equiv="X-UA-Compatible" content="IE=10" />'."\n";
    $aux .= '	<meta http-equiv="X-UA-Compatible" content="IE=9" />'."\n";
    $aux .= '	<meta http-equiv="X-UA-Compatible" content="IE=8" />'."\n";
    $aux .= '	<meta http-equiv="X-UA-Compatible" content="IE=7" />'."\n";

    $aux .= '          <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
          <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
          <script src="js/respond.min.js"></script>
          <![endif]-->'."\n";
    $aux .= $this->css()." \n";

    $aux .= '	<link rel="stylesheet" href="'._RUTA_WEB.'css/croppie.css">';
    $aux .= '	<link rel="stylesheet" href="'._RUTA_WEB.'css/bootstrap-datetimepicker.min.css">';
    $aux .= $this->js()." \n";
    $aux .= '		<script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/croppie.js"></script>'."\n";
    $aux .= "</head>";
    $aux .= "<body class='body-page container-fluid animated fadeIn'>";

    return $aux;
  }

}

?>
