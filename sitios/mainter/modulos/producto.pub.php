<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");

$fmt->get->validar_get ( $_GET['prod'] );
$id = $_GET['prod'];
$sql="SELECT * FROM mod_productos WHERE mod_prod_id='$id'";
$rs =$fmt->query->consulta($sql);
$fila=$fmt->query->obt_fila($rs);
if (empty($fila["mod_prod_id_dominio"])){ $aux=_RUTA_WEB_temp; } else { $aux = $fmt->categoria->traer_dominio_cat_id($fila["mod_prod_id_dominio"]); }
?>
<div class="container-fluid pag-producto">
  <div class="side-bar-m">
   <?php require_once("sidebar.pub.php"); ?>
  </div>
  <div class="body-page-m" id="body-page-m">
    <div class="page container">
		<div class="producto-nombre"><h1><?php echo $fila['mod_prod_nombre'];?></h1></div>
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-6">
					<div class="img-producto">
						
						<img src="<?php echo $aux.$fila['mod_prod_imagen'];?>" class="img-responsive">
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
				</div>
				<div class="col-md-3">
					<div class="box-compartir no-print">
						<label>Compartir</label>
						<i class="fa fa-share-alt"></i>
					</div>
					<a href="javascript:$.print('#body-page-m');" class="box-imprimir no-print">
						<label>Imprimir</label>
						<i class="fa fa-print"></i>
					</a>
					<div class="compartir" style="display:none;">
						<i class="fa fa-caret-down indicador-abajo"></i>
						<a href="#"><i class="fa fa-envelope"></i></a>
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-linkedin"></i></a>
						<a href="#"><i class="fa fa-whatsapp"></i></a>
					</div>
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
			</div>
		</div>
    </div>
    <script>
	    $(function(){
		    $('.box-compartir').click(function(){
			    $('.compartir').toggle();
			    $('.box-compartir').toggleClass('on');
		    });
		    
		});
	</script>
    <?php require_once("footer.pub.php"); ?>
  </div>
</div>
