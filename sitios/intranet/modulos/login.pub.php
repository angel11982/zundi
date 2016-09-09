<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");

	$fmt = new CONSTRUCTOR();
$id_us = $this->fmt->sesion->get_variable("usu_id");
if(is_numeric($id_us)){
 ?>
 <script>
 	window.location.href="intranet/portada";
 </script>
 <?php
}else{
	require_once(_RUTA_HOST."modulos/login/login.form.php");
}
?>
<style>
#block-login{
	display: block !important;
}
</style>

