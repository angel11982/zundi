<?php
header('Content-Type: text/html; charset=utf-8');

class GET{

  var $fmt;

  function __construct($fmt){
    $this->fmt = $fmt;
  }

  function get_categoria_index(){
    //echo "Ingreso get categoria</br>";
    if ( (isset($_GET["cat"]) && !empty($_GET["cat"])) ) {
	  $this->validar_get($_GET["cat"]);
      $id_categoria =   $_GET["cat"];
    }else{
      $id_categoria = 1;
    }
    return $id_categoria;
  }

  function get_plantilla_index($query,$id_categoria){
    //echo "Ingreso get plantilla</br>";
    if ( (isset($_GET["pla"]) && !empty($_GET["pla"])) ) {
	  $this->validar_get($_GET["pla"]);
      $id_plantilla =  $_GET["pla"];
    }else{
      $id_plantilla = $this->obtener_plantilla($query,$id_categoria);
    }
    //echo "id_pla:".$id_plantilla;
    return $id_plantilla;
  }

  function obtener_plantilla($query,$cat){
    //echo "Entre a obtener_plantilla</br>";
    $sql = "SELECT cat_id_plantilla
           FROM categoria
           WHERE cat_id='$cat'";
    $res  = $this->fmt->query->consulta($sql);
    $fila = $this->fmt->query->obt_fila($res);
    //echo "fila:".	$fila["cat_id_plantilla"]."</br>";
    return 	$fila["0"];
  }

  function validar_get($get){
    if ($get!=""){
      if (!is_numeric($get)){
        $this->fmt->error->error_modulo_no_encontrado();
      }
    }
  }

  function convertir_url_amigable($cadena){
  	$cadena= utf8_decode($cadena);
  	$cadena = strtolower($cadena);
    $cadena = str_replace(' ', '-', $cadena);
  	$cadena = str_replace('?', '', $cadena);
  	$cadena = str_replace('+', '', $cadena);
  	$cadena = str_replace(':', '', $cadena);
  	$cadena = str_replace('??', '', $cadena);
  	$cadena = str_replace('`', '', $cadena);
  	$cadena = str_replace('!', '', $cadena);
  	$cadena = str_replace('¿', '', $cadena);
    $cadena = str_replace(',', '-', $cadena);
  	$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ??';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);

    return $cadena;
  }


}

?>
