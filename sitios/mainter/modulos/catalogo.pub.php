<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");



function CargarProductos($cat,$fmt,$fila_ncat,$cat_amig,$url_todos,$filtro){
	$sql3="select DISTINCT mod_prod_id,mod_prod_nombre, mod_prod_ruta_amigable, mod_prod_imagen, mod_prod_id_dominio, mod_prod_tags, mod_prod_id_marca FROM mod_productos_rel, mod_productos where mod_prod_id=mod_prod_rel_prod_id and mod_prod_rel_cat_id='".$cat."'";
	$rs3=$fmt->query->consulta($sql3);
	$num_lim = $fmt->query->num_registros($rs3);
    if($num_lim>0){
    	for($i=0;$i<$num_lim;$i++){
        	list($fila_id,$fila_nombre,$fila_ra,$fila_imagen, $fila_dominio,$fila_tags, $fila_id_marca)=$fmt->query->obt_fila($rs3);
			$ruta="";
			if($cat_amig!="")
				$ruta="/".$cat_amig;
			$url = $url_todos.$ruta."/".$fila_ra;
            if (empty($fila_dominio)){ $aux=_RUTA_WEB_temp; } else { $aux = $fmt->categoria->traer_dominio_cat_id($fila_dominio); }
			$marca = TraerMarca($fila_id_marca, $fmt);
            $img_1= $aux.$fmt->class_modulo->cambiar_tumb($fila_imagen);
            $img_1=$fmt->archivos->convertir_url_extension($img_1,"png");
            echo "<div class='mix $filtro $marca' data-myorder='$fila_nombre'>";
            echo "<div class='item' style='background:url($img_1) center center'>";
            $color = $fmt->class_modulo->fila_modulo($cat,"cat_color","categoria","cat_"); //$id,$fila,$from,$prefijo
            if (!empty($color)){
	            $fila_color_cat = $color;
            }
            echo "<div class='cat $fila_ncat' style='background-color:".$fila_color_cat." !important'>".$fila_ncat."</div>";
            echo "<div class='tags' style='display: none;'>".$fila_tags."</div>";
            echo "<a href='".$url."'><span class='title'>".$fila_nombre."</span><div class='bg'></div></a>";
            echo "</div>";
            echo "</div>";
         }
    }
    CargarCategoriaHijos($cat,$fmt,$url_todos);

}


function CargarCategoriaHijos($cat,$fmt,$url_todos){
	$sql2="select cat_id, cat_nombre, cat_ruta_amigable FROM categoria where cat_id_padre='".$cat."' order by cat_id asc";

	$rs2=$fmt->query->consulta($sql2);
	$num_cat = $fmt->query->num_registros($rs2);
    if($num_cat>0){
	    for($j=0;$j<$num_cat;$j++){
        	list($id_cat, $nombre_cat, $ruta_amig)=$fmt->query->obt_fila($rs2);

        	CargarProductos($id_cat,$fmt,$nombre_cat,$ruta_amig,$url_todos,$ruta_amig);
        }
    }
}
function TraerMarca($id_marca, $fmt){
	$sql4="select mod_prod_mar_ruta_amigable FROM mod_productos_marcas where mod_prod_mar_id=$id_marca";
	$rs4=$fmt->query->consulta($sql4);
	/*$num_marc = $fmt->query->num_registros($rs4);
	$fila_nombre="";
	if ($num_marc>0)*/
		list($fila_nombre)=$fmt->query->obt_fila($rs4);
	return $fila_nombre;
}
function CargarMarca($fmt,$id_cat,$num,$marca){
	$sql4="select mod_prod_mar_id, mod_prod_mar_ruta_amigable, mod_prod_mar_imagen, mod_prod_mar_id_dominio FROM mod_productos_marcas
, mod_productos_rel where mod_prod_rel_cat_id=$id_cat and mod_prod_rel_mar_id=mod_prod_mar_id";

	$rs4=$fmt->query->consulta($sql4);
	$num_marc = $fmt->query->num_registros($rs4);

    if($num_marc>0){
    	for($i=0;$i<$num_marc;$i++){
	    	list($fila_id,$fila_nombre,$fila_imagen, $fila_dominio)=$fmt->query->obt_fila($rs4);
	    	if(!in_multiarray($fila_id, $marca, "id")){
		    	$marca[$num]["id"]=$fila_id;
		    	$marca[$num]["nombre"]=$fila_nombre;
		    	$marca[$num]["imagen"]=$fila_imagen;
		    	$marca[$num]["dominio"]=$fila_dominio;
		    	$num++;
	    	}
    	}
    }
    $marca=HijosMarca($fmt,$id_cat,$num,$marca);
	return $marca;
}
function HijosMarca($fmt,$id_cat,$num,$marca){
	$sql5="select cat_id FROM categoria where cat_id_padre='".$id_cat."'";
	$rs5=$fmt->query->consulta($sql5);
	$num_cat = $fmt->query->num_registros($rs5);
    if($num_cat>0){
    	for($i=0;$i<$num_cat;$i++){
        	list($fila_id)=$fmt->query->obt_fila($rs5);
			$marca=CargarMarca($fmt,$fila_id,$num,$marca);
         }
    }
    return $marca;
}
function in_multiarray($elem, $array,$field)
{
    $top = sizeof($array) - 1;
    $bottom = 0;
    while($bottom <= $top)
    {
        if($array[$bottom][$field] == $elem)
            return true;
        else
            if(is_array($array[$bottom][$field]))
                if(in_multiarray($elem, ($array[$bottom][$field])))
                    return true;

        $bottom++;
    }
    return false;
}
?>
<div class="container-fluid catalogo">
  <div class="side-bar-m">
   <?php
   require_once("sidebar.pub.php");
   $nombre_cat=$fmt->categoria->nombre_categoria($cat);
	 $ds =  $fmt->categoria->descripcion($cat,"categoria","cat_");
	 if (!empty($ds)){
		 $ds = "<span>".$ds."</span>";
	 }else{
		 $ds="";
	 }
	 ?>
  </div>
  <div class="body-page-m" id="body-page-m">
    <div class="page container">
      <div class="title-page">
	      <h2><?php echo $nombre_cat; ?></h2>
				<?php echo $ds; ?>
      </div>
      <div class="box-marcas">
      	<?php
	      	$marca=CargarMarca($fmt,$cat,0);

	      	echo "<ul>";
	      	$num = count($marca);
	      	for($i=0;$i<$num;$i++){
	      		if (empty($marca[$i]["dominio"])){ $aux=_RUTA_WEB_temp; } else { $aux = $this->fmt->categoria->traer_dominio_cat_id($marca[$i]["dominio"]); }

	      		$img=$this->fmt->archivos->convertir_url_thumb( $marca[$i]["imagen"] );
	      		$imagen=$aux.$img;
	      		echo '<li class="box-marca"><img title="'.$marca[$i]["nombre"].'" src="'.$imagen.'" class="filter" data-filter=".'.$marca[$i]["nombre"].'" /></li>';
	      	}
	      	echo "</ul>";
      	?>
      </div>
    </div>
    <div class="categorias">
	      <div class="container">
		      <div class="title-cat">CATEGORIAS</div>
		      <div class="box-cat">
			      <?php
			      /*$sql="select cat_id from categoria order by cat_id asc";
				  $rs=$fmt->query->consulta($sql);
				  $num = $fmt->query->num_registros($rs);
				  for($i=0;$i<$num;$i++){
					  list($fila_id)=$fmt->query->obt_fila($rs);
					  $ins="insert into publicacion_rel (pubrel_cat_id, pubrel_pla_id, pubrel_cont_id, pubrel_pub_id, pubrel_activar, pubrel_orden) value ('$fila_id', '2', '1', '12', '1', '1')";
					  $fmt->query->consulta($ins);
				  }*/
				  $sql="select cat_id, cat_nombre, cat_ruta_amigable from categoria where cat_id_padre='".$cat."' and cat_activar='1'";
					$rs=$fmt->query->consulta($sql);
          $num = $fmt->query->num_registros($rs);
          if (empty($_GET['cp'])){
            $aux="active";
          }else{
            $aux="";
            $cat_prod=$_GET['cp'];
          }
          $url_todos = _RUTA_WEB.$fmt->categoria->ruta_amigable($cat);
            echo "<li><a class='filter btn btn-prod-cat' data-filter='all'><span> Todos </span></a></li>";
            $filtro_z='<div class="filter btn btn-prod-cat" data-filter="all">Todos</div>';
				  	if($num>0){
				  		for($i=0;$i<$num;$i++){
				  			list($fila_id,$fila_nombre,$fila_ruta)=$fmt->query->obt_fila($rs);
				  			$cx[$i]= $fila_id;
                $url = $url_todos."/".$fila_ruta;
                if ($cat_prod==$fila_id){ $aux1="active"; }else { $aux1=""; }
				  			echo "<li class='".$aux1."'><a class='filter btn btn-prod-cat' data-filter='.".$fila_ruta."' ><span>".$fila_nombre."</span></a></li>";
				  			$filtro_z .= '<div class="filter btn btn-prod-cat" data-filter=".'.$fila_ruta.'">'.$fila_nombre.'</div>';
				  		}
				  	}
				  	//echo $filtro_z;


				  ?>
		      </div>
          <div class="box-buscar">
            <div class="title-cat">BUSCAR</div>
            <div class="buscador">
              <form id="form_id" class="" action="index.html" method="post">
                <input autocomplete="off" class="autocomplete-input clear-input clear-input-text ui-autocomplete-input autocomplete-input" data-field-type="product_auto" id="inputBuscar" name="inputBuscar" placeholder="Escribe el nombre de un producto, un cultivo, un problema fitosanitariio o un ingrediente activo" value="" type="text">
              </form>
            </div>
						<div class="ordenar">
			        <label>   ORDENAR POR: </label>
			        <!-- Div para Ordenar -->
			        <div class="sort" data-sort="default">Default</div>
							<div class="sort" data-sort="myorder:asc">(A-Z)</div>
							<div class="sort" data-sort="myorder:desc">(Z-A)</div>
					<!-- Fin Ordenar -->
			      </div>
          </div>
	      </div>
    </div>
    <div class="box-productos container">
      <div id="container-item" class="box-items">
      <?php

	      //echo $cat_prod;
	      //echo  "pag:".$_GET['pag'];

	      	$cantidad_pag ='1200';
	      	$pag_inicio='0';
		   	  $pag_fin=$cantidad_pag;

		   	  if (!empty($_GET['pag']) && $_GET['pag']!=1 ){
			      for ($i=1; $i<$_GET['pag'];$i++){
			      	$pag_inicio .= $pag_inicio + $cantidad_pag;
			      	$pag_fin .= $pag_fin + $cantidad_pag;
			      }
			      $npag = $_GET['pag'];
		      }else{
			      $npag =1;
		      }

		      //echo "pi:".$pag_inicio." pf:".$pag_fin;

			  CargarProductos($cat,$fmt,$nombre_cat,"",$url_todos);


      ?>
      </div>
    </div>
    <div class="pager-list">

	</div>
     <?php
	    if ($num>$cantidad_pag){
		    $urlp= $url_todos;

		    echo "<div class='box-paginacion'><div class='container'>";

			$num_ini='1';
			$num_fin= ceil($num/$cantidad_pag);

	        echo "<div class='list-paginacion'>Página: <span>$num_ini</span> de <span>".$num_fin."</span>  cp: $num </div>";

	        echo "<div class='list-paginacion-nav'>";
	        if ($pag_inicio==0){
		        $ps =$num_ini + 1;
		        $aux_s = "<a href='".$urlp."/pag=$ps' class='btn btn-siguiente'>siguiente</a>";
		        $aux_a = "";
		    }else{
			    $ps = $npag + 1 ;
			    $pa =$npag - 1 ;
			    if ($npag!=$num_fin){
			    	$aux_s = "<a href='".$urlp."/pag=$ps' class='btn btn-siguiente'>siguiente</a>";
			    }
			    $aux_a = "<a href='".$urlp."/pag=$pa' class='btn btn-siguiente'>anterior</a>";
		    }

		    for ($j=$num_ini;$j<=$num_fin;$j++){
			    if ($npag==$j){  $ab='active'; }else{  $ab=''; }
			    $aux_n .=" <a href='".$urlp."/pag=$j' class='btn btn-num btn-n-$j  $ab'> $j </a> ";
		    }
		    echo $aux_a." ".$aux_n." ".$aux_s;
	        echo "</div>";

	        echo "</div></div>";
        }
	  ?>
	  <script>
	  $(document).ready(function(){
		  $('#container-item').mixItUp({
			  load: {
				  page: 1
			  },
			  pagination: {
					limit: 1200
				}
		  });
		  var inputText;
		  var $matching = $();


		  var delay = (function(){
		    var timer = 0;
		    return function(callback, ms){
		      clearTimeout (timer);
		      timer = setTimeout(callback, ms);
		    };
		  })();

		  $("#inputBuscar").keyup(function(){
		    delay(function(){
		      inputText = $("#inputBuscar").val().toLowerCase();

		      if ((inputText.length) > 0) {
		        $( '.mix').each(function() {
		          $this = $("this");

		          var item = $(this).children(".item");

		          if($(this).attr('data-myorder').toLowerCase().match(inputText)) {
		            $matching = $matching.add(this);
		          }
		          else if(item.children(".cat").html().toLowerCase().match(inputText)) {
		            $matching = $matching.add(this);
		          }
		          else if(item.children(".tags").html().toLowerCase().match(inputText)) {
		            $matching = $matching.add(this);
		          }
		          else{
		            $matching = $matching.not(this);
		          }




		        });
		        $("#container-item").mixItUp('filter', $matching);
		      }

		      else {
		        $("#container-item").mixItUp('filter', 'all');
		      }
		    }, 200 );
		  });
	  });
	  </script>
	  <style>
	  #container-item .mix{
			display: none;
		}
	  </style>
    <?php require_once("footer.pub.php"); ?>
  </div>
</div>
