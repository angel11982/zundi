<?php
header('Content-Type: text/html; charset=utf-8');

class FOOTER{

  var $fmt;

  function __construct($fmt) {
    $this->fmt = $fmt;
  }

  function footer_html(){

    $aux .= $this->js();
    $aux .= '</body>'."\n";
    $aux .= '</html>'."\n";

    return $aux;
  }

  function footer_modulo(){
    $aux  = '<div class="footer-pag" class="container-fluid">'."\n";
    $aux .= '2016 <i class="icn-cc"></i> Wappcom &nbsp;| &nbsp;  power  <i class="icn-zundi-o"></i>'._VZ."\n";
    $aux .= '</div>'."\n";
    $aux .= $this->js();
    $aux .= '</body>'."\n";
    $aux .= '</html>'."\n";

    return $aux;
  }

  function js(){
   //$aux  = '       <script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/jquery.js"></script>'."\n";
    //$aux .= '       <script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/bootstrap.js"></script>'."\n";
    //$aux .= '       <script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/jquery.dataTables.min.js"></script>'."\n";
	//$aux .= '       <script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/dataTables.bootstrap.js"></script>'."\n";
    $aux .= '       <script type="text/javascript" language="javascript" src="'._RUTA_WEB.'js/core.js"></script>'."\n";

    return $aux;
  }

}

?>
