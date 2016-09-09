<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");
?>
<div class="box-portada container-fluid">
	<div class="seccion-intro">
		<div class="b-intro">
			<div class="img-intro"><img src="<?php echo _RUTA_WEB; ?>sitios/next/images/img-intro.png" alt="img-intro" width="" height="" /></div>
			<div class="texto-intro">
				<span class="pre-intro"> Next - Sistemas Integrados </span>
				<label>Ingresa a un <strong>nuevo</strong> mundo de posibilidades empresariales</label>
				<span class="resumen-intro"> Nuestro servicio trata de darte multiples sistemas para tu empresa, desde los más basico hasta los más complejos de una forma sencilla pero potente.</span>
				<div class="botones">
					<a class="btn-comprar">Desde $100 el año</a>
					<a class="btn-info-c"><i class="icn-plus"></i>Más información</a>
				</div>
			</div>
		</div>
		<div class="bg-blanco"></div>
	</div> <!-- fin de seccion-intro -->
<div>  <!-- fin de box-portada -->