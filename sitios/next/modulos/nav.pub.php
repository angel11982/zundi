<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;

?>

<div class="box-n-nav container-fluid">
	<div class="brand"><img src="<?php echo _RUTA_WEB; ?>sitios/next/images/logo-next-o.svg"></div>
	<div class="menu-e">
		<a href="#" target="_blank"> Pre - orden </a>
		<a href="#" target="_blank"> FAQ </a>
		<a href="#" target="_blank"> Sobre Nosotros </a>
		<a href="#" target="_blank"> Casos de uso </a>
		<a href="#" target="_blank"> Contacto de ventas</a>  
		<a href="#" class="btn-inicia-s" target="_blank"> Inicia sesión </a>
		<a href="#" class="btn-registrate" target="_blank"> Registrate </a>
	</div>
</div>