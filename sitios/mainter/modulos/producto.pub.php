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
				<div class="col-md-3 panel-atributos">
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
					
					$sql="SELECT DISTINCT doc_id,doc_url,doc_nombre,doc_tipo_archivo,doc_tamano,doc_id_dominio FROM mod_productos_rel, documento WHERE mod_prod_rel_doc_id=doc_id and mod_prod_rel_prod_id=".$fila['mod_prod_id']; 
					$rs=$this->fmt->query->consulta($sql);
					$num =$this->fmt->query->num_registros($rs);
					
					if ($num>0){
						echo "<div class='box-info box-descargas no-print'><label>Descargas</label>";
						for($i=0;$i<$num;$i++){
							list($fila_id,$fila_url,$fila_nombre,$fila_tipo,$fila_tamano,$fila_dominio)=$this->fmt->query->obt_fila($rs);
							if (empty($fila_dominio)){ $aux=_RUTA_WEB; } else { $aux = $this->fmt->categoria->traer_dominio_cat_id($fila_dominio); }
							echo "<a class='doc-descarga' href='".$aux.$fila_url."' target='_blank'>";
							echo "<label>".$fila_nombre."</label>";
							echo "<i class='fa fa-cloud-download' aria-hidden='true'></i>";
							echo "<div class='doc-datos'>";
							echo "<span class='doc-tipo'>".strtoupper($fila_tipo)."</span>";
							echo "<span class='doc-tamano'>".strtoupper($fila_tamano)."</span>";
							echo "</div>";
							echo "</a>";
						}
						echo "</div>";
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
		    
		    $("#btn_print").click(function() {
                //Print ele2 with default options
                $.print("#body-page-m");
            });
		    
		});
	</script>
    <?php require_once("footer.pub.php"); ?>
  </div>
</div>
