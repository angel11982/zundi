<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");
require_once("menu.pub.php");
$nota=$_GET["nota"];

$sql="SELECT * FROM mod_productos WHERE mod_prod_ruta_amigable='$nota'";
$rs =$fmt->query->consulta($sql);
$fila=$fmt->query->obt_fila($rs);
if (empty($fila["mod_prod_id_dominio"])){ $aux_prod=_RUTA_WEB_temp; } else { $aux_prod = $fmt->categoria->traer_dominio_cat_id($fila["mod_prod_id_dominio"]); }
?>
<div class="container-fluid body-m" id="producto">
	<div class="producto-nombre"><h1><?php echo $fila['mod_prod_nombre'];?></h1></div>
	<?php
	if(!empty($fila['mod_prod_resumen']))
	echo '<div class="producto-resumen">'.$fila['mod_prod_resumen'].'</div>';
	?>
	<div class="img-producto">
		<img src="<?php echo $aux_prod.$fila['mod_prod_imagen']; ?>" class="img-responsive">
	</div>

	<div class="descripcion-producto">
	<?php
		if (!empty($fila['mod_prod_detalles'])){
	?>
	<h2>Descripción</h2>
		<span>
			<?php echo $fila['mod_prod_detalles']; ?>
		<span>
		<br/>
	<?php
		}
		if (!empty($fila['mod_prod_especificaciones'])){
			echo '<h2>Especificaciones</h2>';
			echo $fila['mod_prod_especificaciones'];
		}
	?>
	</div>

	<div class="box-compartir no-print">
	<label>Compartir</label>
		<i class="fa fa-share-alt"></i>
	</div>
	<div class="compartir no-print" style="display:none;">
		<i class="fa fa-caret-down indicador-abajo"></i>
		<a href="#"><i class="fa fa-envelope"></i></a>
		<a href="#"><i class="fa fa-facebook"></i></a>
		<a href="#"><i class="fa fa-linkedin"></i></a>
		<a href="#"><i class="fa fa-whatsapp"></i></a>
	</div>
	<a  class="box-imprimir no-print" id="btn_print">
		<label>Imprimir</label>
		<i class="fa fa-print"></i>
	</a>
	<?php
		if (!empty($fila['mod_prod_codigo'])){
			echo '<div class="box-info codigo-producto">';
			echo '<label> Código</label>';
			echo '<span>'.$fila['mod_prod_codigo'].'</span>';
			echo '</div>';
		}
		if (!empty($fila['mod_prod_modelo'])){
			echo '<div class="box-info modelo-producto">';
			echo '<label> Modelo</label>';
			echo '<span>'.$fila['mod_prod_modelo'].'</span>';
			echo '</div>';
		}
	?>
</div>
