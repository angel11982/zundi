<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<div class="footer">
	<i class="flecha-up fa fa-caret-up"></i>
	<div class="box-menu-bottom">
		<?php echo $fmt->categoria->hijos_cat_a("0","0"); ?>
	</div>
	<div class="box-social-footer">
		<?php require("social.pub.php"); ?>
	</div>
	<div class="brand"><img src="<?php echo _RUTA_WEB; ?>sitios/victoria/images/victoria.svg"></div>
	<div class="pie-pagina">® 2016  Panaderia Victoria  |   politica de privacidad   | terminos y condiciones </div>
</div>