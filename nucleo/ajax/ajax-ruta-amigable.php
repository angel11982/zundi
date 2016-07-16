<?php
  require_once("../clases/class-constructor.php");
  $fmt = new CONSTRUCTOR();
  echo $fmt->get->convertir_url_amigable( $_POST["inputRuta"]);
?>
