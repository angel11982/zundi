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
if (empty($fila["mod_prod_id_dominio"])){ $aux_prod=_RUTA_WEB_temp; } else { $aux_prod = $fmt->categoria->traer_dominio_cat_id($fila["mod_prod_id_dominio"]); }


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
					<img src="<?php echo $aux_prod.$fila['mod_prod_imagen']; ?>" class="img-responsive">
					</div>
					<div class="descripcion-producto">
						<?php
							if (!empty($fila['mod_prod_resumen'])){
								echo "<span class='resumen'>";
								echo $fila['mod_prod_resumen'];
								echo "</span>";
							}

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
					<?php
					$sql="SELECT DISTINCT pes_nombre, mod_pro_pes_contenido FROM mod_productos_pestana
, pestana WHERE pes_id=mod_pro_pes_pes_id and mod_pro_pes_pro_id=".$fila['mod_prod_id']." order by mod_pro_pes_orden asc";
					$rs=$this->fmt->query->consulta($sql);
					$num =$this->fmt->query->num_registros($rs);

					if ($num>0){
						echo '<div class="panel-group panel-pestanas" id="accordion">';
						for($i=0;$i<$num;$i++){
							list($fila_nombre,$fila_contenido)=$this->fmt->query->obt_fila($rs);
							?>
							<div class="panel panel-default">
							    <div class="panel-heading">
							        <a class="b-collapse on" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" id="idc-<?php echo $i; ?>" idc="<?php echo $i; ?>">
							        <label><?php echo $fila_nombre; ?></label> <i class="b-abrir fa fa-plus"></i><i class='b-cerrar fa fa-minus'></i></a>
							    </div>
							    <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse">
							      <div class="panel-body"><?php echo $fila_contenido; ?></div>
							    </div>
							  </div>
							<?php
						}
						echo '</div>';
					}
					?>

				</div>
				<script >
					$(document).ready(function(){
						$(".b-collapse").click(function(e){
							var idx = $(this).attr("idc");
							$(".b-collapse").removeClass("on");
							i= $(this).offset().top;
							//alert(i);
							$('html, body').animate({scrollTop: 750 }, 1000);
						});
					});
				</script>
        <div class="col-md-3 panel-atributos">
	        <div class="marcas">
		        <?php
			        $sql_1="SELECT DISTINCT mod_prod_mar_id, mod_prod_mar_imagen  FROM mod_productos, mod_productos_marcas
 WHERE  mod_prod_id=".$id." and mod_prod_id_marca=mod_prod_mar_id" ;
 					$rs_1=$this->fmt->query->consulta($sql_1);
					$num_1 =$this->fmt->query->num_registros($rs_1);

					if ($num_1>0){
						for($i=0;$i<$num_1;$i++){
							list($fila_id_marca,$fila_imagen_marca)=$this->fmt->query->obt_fila($rs_1);
							echo "<img class='img-responsive' src='"._RUTA_WEB.$fila_imagen_marca."'>";
						}
					}
			    ?>
	        </div>
				<?php

        require_once("compartir.pub.php");

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

					require_once(_RUTA_HOST."modulos/multimedia/slide-multimedia-prod.pub.php");

?>

				</div>
			</div>
		</div>
    </div>
    <?php require_once("footer.pub.php"); ?>
  </div>
</div>
