<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");
?>
<div class="container-fluid portada">
	<div class="side-bar-m">
		<?php require_once("sidebar.pub.php"); ?>
	</div>
	<div class="body-page-m page-cm body-buscar" id="body-page-m">
		<div class="page">
		<h1>Resultados de Busqueda</h1>
		<p></p>
		<?php
			if(isset($_GET["q"])){
			//if(preg_match("^/[A-Za-z]+/", $_POST['buscar'])){
				$q = $_GET["q"];
				$i=0;
				$cant_q=0;
				$dato = explode(" ", $q);
				$id_dominio = $fmt->categoria->traer_id_cat_dominio(_RUTA_WEB);

				if(count($dato)>1){
					$search= "MATCH (mod_prod_nombre, mod_prod_detalles, mod_prod_tags, mod_prod_especificaciones) AGAINST (\"$q\")";
					$search_cat= "MATCH (cat_nombre) AGAINST (\"$q\")";
					$sql_fin="order by valor desc";
				}
				else{
					$search= "mod_prod_nombre LIKE '%" . $q .  "%' OR mod_prod_detalles LIKE '%" . $q ."%' OR mod_prod_tags LIKE '%" . $q ."%' OR mod_prod_especificaciones LIKE '%" . $q ."%'";
					$search_cat= "cat_nombre LIKE '%" . $q .  "%'";

					$sql_fin="order by pro_nombre desc";


				}
				$ids = array();
				$sql="SELECT mod_prod_id, mod_prod_nombre, mod_prod_ruta_amigable, mod_prod_detalles, mod_prod_resumen FROM mod_productos WHERE mod_prod_id_dominio=$id_dominio and mod_prod_activar=1 and ".$search;
				$rs =$fmt->query->consulta($sql);
				$num_prod=$fmt->query->num_registros($rs);
				if($num_prod>0){
					for($i=0;$i<$num_prod;$i++){
						$fila=$fmt->query->obt_fila($rs);
						$id_cat = $fmt->categoria->traer_id_cat_producto($fila["mod_prod_id"]);
						$ruta1 = $fmt->categoria->traer_ruta_amigable_padre($id_cat, $id_dominio);
						$ids[$i]=$fila["mod_prod_id"];
						$nombre[$i]=$fila["mod_prod_nombre"];
						$ruta[$i]=$ruta1."/".$fila["mod_prod_ruta_amigable"];
						$detalle[$i]=$fila["mod_prod_resumen"]."<br>".$fila["mod_prod_detalles"];
						$tipo[$i]="Ver producto";
					}
				}

				$sql="SELECT cat_id FROM categoria WHERE cat_activar=1 and ".$search_cat;

				$rs =$fmt->query->consulta($sql);
				$num_cat=$fmt->query->num_registros($rs);
				if($num_cat>0){
					for($j=0;$j<$num_cat;$j++){
						$fila_cat=$fmt->query->obt_fila($rs);
						$ids_cat=$fila_cat["cat_id"];
						$ruta_cat=$fmt->categoria->traer_ruta_amigable_padre($ids_cat, $id_dominio);
						$sql_aux="SELECT mod_prod_id, mod_prod_nombre, mod_prod_ruta_amigable, mod_prod_detalles, mod_prod_resumen FROM mod_productos, mod_productos_rel WHERE mod_prod_rel_prod_id=mod_prod_id and mod_prod_rel_cat_id=".$ids_cat;
						$rs_aux =$fmt->query->consulta($sql_aux);
						$num_aux=$fmt->query->num_registros($rs_aux);
						if($num_aux>0){
							for($k=0;$k<$num_aux;$k++){
								$fila_aux=$fmt->query->obt_fila($rs_aux);
								if (!in_array($fila_aux["mod_prod_id"], $ids)) {
									$id_padre = $fmt->categoria->categoria_id_padre($ids_cat);
									$ruta2 = $fmt->categoria->ruta_amigable($id_padre);
									$ids[$i]=$fila_aux["mod_prod_id"];
									$nombre[$i]=$fila_aux["mod_prod_nombre"];
									$ruta[$i]=$ruta_cat."/".$fila["mod_prod_ruta_amigable"];
									$detalle[$i]=$fila_aux["mod_prod_resumen"]."<br>".$fila_aux["mod_prod_detalles"];
									$tipo[$i]="Ver producto";
									$i++;
								}
							}
						}
					}
				}

				$num_prod=$i;

				$sql="SELECT cat_id, cat_nombre, cat_ruta_amigable, cat_descripcion FROM categoria WHERE cat_id_padre = $id_dominio and cat_activar=1 and ".$search_cat;

				$rs =$fmt->query->consulta($sql);
				$num_cat=$fmt->query->num_registros($rs);
				if($num_cat>0){
					for($j=0;$j<$num_cat;$j++){
						$fila_cat=$fmt->query->obt_fila($rs);
						$ids[$i]=$fila_cat["cat_id"];
						$nombre[$i]=$fila_cat["cat_nombre"];
						$ruta[$i]=$fila_cat["cat_ruta_amigable"];
						$detalle[$i]=$fila_cat["cat_descripcion"];
						$tipo[$i]="Ver categorias";
						$i++;
					}
				}
				$cant_q=$num_cat+$num_prod;
				if($q=="")
				$cant_q=0;
				if($cant_q>0){
		?>
		<div class="section section-style-a">
	        <div class="container">
	            <div class="region-inner">
	                <div class="block block-size-a search-results-summary block-last">
	                    <h3 class="search-results-count"><span class="highlight"><?php echo $cant_q; ?></span>
	                        Resultados encontrados para  <span class="highlight">'<?php echo $q; ?>'</span></h3>
	                </div>
	            </div>
	        </div>
	    </div>
		<?php
				}
				else{
		?>
		<div class="section section-style-a">
	        <div class="container">
	            <div class="region-inner">
	                <div class="block block-size-a search-results-summary block-last">
	                    <h3 class="search-results-count">No se encontraron resultados para su búsqueda.</h3>
	                </div>
	            </div>
	        </div>
	    </div>
	    <?php
		    	}
	    ?>
	    <div class="container">
        <div class="region region-a">
            <div class="region-inner">
            	<?php
	            	for($i=0;$i<$cant_q;$i++){
            	?>
                    <article class="block block-size-a search-result block-last">
                        <a href="<?php echo _RUTA_WEB.$ruta[$i]; ?>" target="_self" class="search-results-inner">
                            <div class="details">
                                <header>
                                    <h3><?php echo $nombre[$i]; ?></h3>
                                </header>

                                    <p class="detalle"><?php echo $detalle[$i]; ?></p>
                            </div>
                            <div class="more">
                                <button class="btn">
                                   <?php echo $tipo[$i]; ?>
                                </button>
                            </div>
                        </a>
                    </article>
                <?php
	            	}
            	?>


            </div>
        </div>
    </div>
		<?php
			//}

			}
		?>
  		</div>
	<?php require_once("footer.pub.php"); ?>
	</div>
</div>