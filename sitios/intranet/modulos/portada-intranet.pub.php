<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("navbar.pub.php");

$id_usu = $this->fmt->sesion->get_variable("usu_id");
$id_rol = $this->fmt->sesion->get_variable("usu_rol");

$usu_nombre    = $this->fmt->usuario->nombre_usuario($id_usu);
$usu_imagen    = _RUTA_WEB.$this->fmt->usuario->imagen_usuario($id_usu);

?>
<div class='body-page-intranet container'>
	<div class="box-m-sl">
		<div class="box-m-user">
			<img class="img-user" alt="" src="<? echo $usu_imagen; ?>">
			<div class="name-user"><? echo $usu_nombre; ?></div>
		</div>
		<div class="box-m-news">
			<label>GENERAL</label>
			<ul class="box-m-navs">
				<? echo $fmt->nav->traer_cat_hijos_menu("32"); ?>
			</ul>
		</div>
	</div>
	<div class="box-m-c">
		<? require_once("noticias.pub.php"); ?>
	</div>
	<div class="box-m-sr">
		<div class="box-m-herramientas">
			<div class="box-m-utilitarios box-md-8">
				<div class="box-buscador">
					<input type="input" placeholder="Busca personas"  /><i class="icn-search"></i> 
				</div>
			</div>
			<div class="box-m-atajos box-md-4" >

			</div>
		</div>
	</div>
</div>
<?php
require_once("footer.pub.php");
?>
