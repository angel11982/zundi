<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");
?>
<div class="container-fluid catalogo">
  <div class="side-bar-m">
   <?php require_once("sidebar.pub.php"); ?>
  </div>
  <div class="body-page-m" id="body-page-m">
    <div class="page container">
      <div class="title-page">
	      <h2><?php echo $fmt->categoria->nombre_categoria($cat); ?></h2>
	      <span><?php echo $fmt->categoria->descripcion($cat,"categoria","cat_"); ?></span>
      </div>
    </div>
    <div class="categorias">
	      <div class="container">
		      <div class="title-cat">CATEGORIAS</div>
		      <div class="box-cat">
			      <?php
				  $sql="select mod_prod_cat_id from mod_productos_cat where mod_prod_cat_idcat='".$cat."' and mod_prod_cat_activar='1'";
					$rs=$fmt->query->consulta($sql);
          $fila = $fmt->query->obt_fila($rs);
          $id_cat =   $fila["mod_prod_cat_id"];
          $sql2="select mod_prod_cat_id,mod_prod_cat_nombre,mod_prod_cat_ruta_amigable from mod_productos_cat where mod_prod_cat_id_padre='".$id_cat."' and mod_prod_cat_activar='1'";
          $rs2=$fmt->query->consulta($sql2);
          $num = $fmt->query->num_registros($rs2);
          if (empty($_GET['cp'])){
            $aux="active";
          }else{
            $aux="";
            $cat_prod=$_GET['cp'];
          }
          $url_todos = _RUTA_WEB.$fmt->categoria->ruta_amigable($cat);
            echo "<li class='".$aux."'><a class='btn btn-prod-cat' href='".$url_todos."'><span> Todos </span></a></li>";
				  	if($num>0){
				  		for($i=0;$i<$num;$i++){
				  			list($fila_id,$fila_nombre,$fila_ruta)=$fmt->query->obt_fila($rs2);
				  			$cx[$i]= $fila_id;
                $url = $url_todos."/".$fila_ruta;
                if ($cat_prod==$fila_id){ $aux1="active"; }else { $aux1=""; }
				  			echo "<li class='".$aux1."'><a class='btn btn-prod-cat' href='".$url."'><span>".$fila_nombre."</span></a></li>";
				  		}
				  	}
				  ?>
		      </div>
          <div class="box-buscar">
            <div class="title-cat">BUSCAR</div>
            <div class="buscador">
              <form id="form_id" class="" action="index.html" method="post">
                <input autocomplete="off" class="autocomplete-input clear-input clear-input-text ui-autocomplete-input autocomplete-input" data-field-type="product_auto" id="inputBuscar" name="inputBuscar" placeholder="Escribe el nombre de un producto, un cultivo, un problema fitosanitariio o un ingrediente activo" value="" type="text">
                <a href="" class="btn btn-prod-buscar">BUSCAR</a>
              </form>
            </div>
          </div>
	      </div>
    </div>
    <div class="box-productos container">
	  
      <div class="ordenar">
        <label>   ORDENAR POR </label>
        <select class="" id="InputOrden">
          <<option class="" value="0">Default</option>
          <<option class="" value="asc">(A-Z)</option>
          <<option class="" value="desc">(Z-A)</option>
        </select> 
      </div>
      <div class="box-items">
      <?php
	     
	      //echo $cat_prod;
	      //echo  "pag:".$_GET['pag'];
	      	  
	      	  $cantidad_pag ='25';
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
		   	  
	      
	      if (!empty($cat_prod)){
	          
	          $sql2="select DISTINCT mod_prod_rel_prod_id from mod_productos_rel, mod_productos_cat where mod_prod_rel_cat_id='".$cat_prod."' and mod_prod_cat_id='$cat_prod' ";
			  $rs2=$fmt->query->consulta($sql2);
			  $num = $fmt->query->num_registros($rs2);

			
			 $sql3="select DISTINCT mod_prod_id,mod_prod_cat_ruta_amigable,mod_prod_nombre, mod_prod_ruta_amigable, mod_prod_imagen,mod_prod_cat_nombre, mod_prod_id_dominio FROM mod_productos_rel, mod_productos_cat,mod_productos where mod_prod_id=mod_prod_rel_prod_id and mod_prod_cat_id=mod_prod_rel_cat_id and mod_prod_rel_cat_id='".$cat_prod."' and mod_prod_cat_id='$cat_prod' LIMIT $pag_inicio,$pag_fin";          
       
			$rs3=$fmt->query->consulta($sql3);
			  $num_lim = $fmt->query->num_registros($rs3);   
          
          }else{
	       $c_cx = count($cx);
	       for ($i=0;$i<$c_cx;$i++){
		       if ($i==0){
			       $aux = " mod_prod_rel_cat_id ='".$cx[$i]."'";
		       }else{
		       	   $aux .= " or mod_prod_rel_cat_id ='".$cx[$i]."'";
		       }
	       } 
	       $sql2 ="SELECT DISTINCT mod_prod_id from mod_productos_rel,mod_productos_cat, mod_productos WHERE mod_prod_id=mod_prod_rel_prod_id and mod_prod_cat_id=mod_prod_rel_cat_id and ($aux) ORDER BY mod_prod_nombre asc";
	       $rs2=$fmt->query->consulta($sql2);
		   $num = $fmt->query->num_registros($rs2);
		   
		   	  $fmt->get->validar_get($_GET['pag']);
		 
		      
		      $sql3 ="SELECT DISTINCT mod_prod_id,mod_prod_cat_ruta_amigable,mod_prod_nombre, mod_prod_ruta_amigable, mod_prod_imagen, mod_prod_cat_nombre, mod_prod_id_dominio FROM mod_productos_rel,mod_productos_cat, mod_productos WHERE mod_prod_id=mod_prod_rel_prod_id and mod_prod_cat_id=mod_prod_rel_cat_id and ($aux) ORDER BY mod_prod_nombre asc LIMIT $pag_inicio,$pag_fin";
		      $rs3=$fmt->query->consulta($sql3);
			  $num_lim = $fmt->query->num_registros($rs3);
		   
          }
          
          
          if($num_lim>0){
            for($i=0;$i<$num_lim;$i++){
              list($fila_id,$fila_cat,$fila_nombre,$fila_ra,$fila_imagen,$fila_ncat, $fila_dominio)=$fmt->query->obt_fila($rs3);
              
              $url = $url_todos."/".$fila_cat."/".$fila_ra;
              if (empty($fila_dominio)){ $aux=_RUTA_WEB_temp; } else { $aux = $fmt->categoria->traer_dominio_cat_id($fila_dominio); }
             
              $img_1= $aux.$fmt->class_modulo->cambiar_tumb($fila_imagen);
              echo "<div class='item' style='background:url($img_1) center center'>";
              echo "<div class='cat $fila_ncat'>".$fila_ncat."</div>";
              echo "<a href='".$url."'><span>".$fila_nombre."</span><div class='bg'></div></a>";
              echo "</div>";
            }
          }
          
      ?>
      </div>
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
    <?php require_once("footer.pub.php"); ?>
  </div>
</div>
