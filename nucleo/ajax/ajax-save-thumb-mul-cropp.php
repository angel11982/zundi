<?php
  require_once("../clases/class-constructor.php");
  $fmt = new CONSTRUCTOR();

  $blob = $_FILES["croppedImage"];
 $dir = $_POST["dir"];
 $nombre = $_POST["nombre"];
 $ext = $_POST["ext"];
 $ruta="";
 $dato = explode("/", $dir);
 $num = count($dato);
 for($i=0;$i<($num-1);$i++){
	$ruta.= $dato[$i]."/";
 }


$nombre_archivo = _RUTA_HT.$ruta.$nombre."_thumb.png";

move_uploaded_file($blob['tmp_name'], $nombre_archivo);

//echo $dir.$nombre."_thumb.".$ext;

?>
