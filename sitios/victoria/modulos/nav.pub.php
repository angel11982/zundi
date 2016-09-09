<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<div class="box-n-nav container-fluid">
	<div class="brand"><img src="<?php echo _RUTA_WEB; ?>sitios/victoria/images/victoria.svg"></div>
		<!--
<a href="#" target="_blank"> INICIO </a>
		<a href="#" target="_blank"> NOSOTROS  </a>
		<a href="#" target="_blank"> PRODUCTOS </a>
		<a href="#" target="_blank"> SUCURSALES </a>
		<a href="#" target="_blank"> SOCIAL </a>
		<a href="#" target="_blank"> CONTACTO </a>
-->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
			    <? echo $fmt->nav->traer_cat_hijos_menu("0"); ?>
			</ul>
			<!--<ul class="nav navbar-nav navbar-right">
			    <li><a href="#"><i class="icon-search"></i></a></li>
			</ul>-->
			<div class="box-social box-social-top">
				<?php require_once("social.pub.php"); ?>
			</div>
		</div><!-- /.navbar-collapse -->
</div>

