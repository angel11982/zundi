<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");
?>
<div class="box-body container-fluid box-catalogo">
	<div class="header-catalogo">
		<div class="box-title">
			<h2>Sabrosa</h2>
			<?php  require_once("puntos.pub.php"); ?>
			<h1>Panadería</h1>
		</div>
		<i class="flecha-up fa fa-caret-up"></i>		
		<div class="bg-shadow"></div>
	</div>
	
	<div class="container-fluid box-productos">
		<div class="container">
			<ol class="breadcrumb">
				<li><a href="<?php echo _RUTA_WEB; ?>">Portada</a>
				<li><?php
				 echo $fmt->categoria->ruta_amigable($cat);
			  ?>
			  </li>
			</ol>
			<div class="box-buscar">		
				<input type="search" id="q" name="q" placeholder="Buscar">
				<button  type="button" id="buscar" class="btn-buscar btn"  > <i class="fa fa-search"></i></button>
			</div>
			
			<div class="box-productos-cat">
				<?php
					$sql="select cat_id, cat_nombre from categoria where cat_id_padre=$cat order by cat_id asc";
					$rs=$fmt->query->consulta($sql);
					$num = $fmt->query->num_registros($rs);
					if ($num>0){
						for($i=0;$i<$num;$i++){
							list($fila_cat_id, $fila_cat_nombre)=$fmt->query->obt_fila($rs);
							echo "<div class='box-cat'>";
							require("puntos.pub.php"); 
							echo $fila_cat_nombre;
							require("puntos.pub.php"); 
							echo "</div>";
							
							$sql3="select DISTINCT mod_prod_id,mod_prod_nombre, mod_prod_ruta_amigable, mod_prod_imagen, mod_prod_id_dominio, mod_prod_tags, mod_prod_id_marca, mod_prod_resumen FROM mod_productos_rel, mod_productos where mod_prod_id=mod_prod_rel_prod_id and mod_prod_rel_cat_id='".$fila_cat_id."'";
							$rs3=$fmt->query->consulta($sql3);
							$num_lim = $fmt->query->num_registros($rs3);
							echo "<div class='box-prod'>";
							if($num_lim>0){
								for($i=0;$i<$num_lim;$i++){
									list($fila_id,$fila_nombre,$fila_ra,$fila_imagen, $fila_dominio,$fila_tags, $fila_id_marca, $fila_resumen)=$fmt->query->obt_fila($rs3);
									$ruta="";
									echo "<div class='m-producto'>";
									echo "	<div class='img' style='background:url("._RUTA_WEB.$fila_imagen.")'></div>";
									echo "	<div class='texto'>";
									echo "		<h1>".$fila_nombre."</h1>";
									echo "		<span>".$fila_resumen."</span>";
									echo "	</div>";
									echo "</div>";
								}
							}
							echo "</div>"; 
						}	
					}
				?>
			</div>
			
		</div>
	</div>
</div>
<script>
  $( document ).ready(function() {
    //console.log( "document loaded" );
   
	$("#buscar").click(function(){
		buscar();
	});

	$("#q").keypress(function(e){
		if(e.which == 13) {
	        buscar();
		}
	});

  });
  function buscar(){
	  var q = $("#q").val();

	  window.location = "<?php echo _RUTA_WEB; ?>buscar/"+q;
  }
</script>

<?php
	
require_once("footer.pub.php");	
?>