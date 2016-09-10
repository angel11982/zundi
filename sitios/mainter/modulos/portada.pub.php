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
  <div class="body-page-m" id="body-page-m">
    <div class="page container page-portada">
      <div class="title-page texto-portada">
	      <? echo $fmt->class_modulo->fila_modulo('7',"conte_cuerpo","contenidos","conte_"); //$id,$fila,$from,$prefijo ?>
      </div>
      <ul>
        <?
	        //echo  $fmt->nav->traer_cat_hijos_menu("3");
	        $sql="SELECT DISTINCT cat_id, cat_nombre, cat_id_padre, cat_icono, cat_url, cat_destino, cat_ruta_amigable FROM categoria WHERE cat_id_padre='3' and cat_activar='1' ORDER BY cat_orden ASC";
		    $rs = $fmt->query->consulta($sql);
		    $num = $fmt->query->num_registros($rs);
		    if ($num>0){
		    	for ($i=0; $i<$num; $i++){
			        list($fila_id, $fila_nombre, $fila_id_padre, $fila_icono, $fila_url, $fila_destino, $fila_ruta_amigable) =  $fmt->query->obt_fila($rs);

			        if (!empty($fila_url)){
			          $url= $fila_url; $destino=$fila_destino;
			        }else{
			          $url= $fila_ruta_amigable; $destino="";
			        }
  			      echo $fmt->nav->fmt_li($fila_id,"","",$fila_nombre, $url, $destino );
        		}
    		}
	    ?>
	    <li id="btn-m00" class="btn-m00 btn-m-clima"><i class=""></i><span>Climas</span>
	    <div class="climas">
		    <?php
		    	$pirai = $fmt->class_modulo->traer_clima("santa cruz de la sierra, bolivia");
		    	$pozo_tigre = $fmt->class_modulo->traer_clima("pozo del tigre, santa cruz, bolivia");
		    	$conchas = $fmt->class_modulo->traer_clima("las conchas, santa cruz, bolivia");
		    	$okinawa = $fmt->class_modulo->traer_clima("okinawa, santa cruz, bolivia");
		    	$pedro = $fmt->class_modulo->traer_clima("san pedro, santa cruz, bolivia");
		    	$julian = $fmt->class_modulo->traer_clima("san julian, santa cruz, bolivia");
		    	$cotoca = $fmt->class_modulo->traer_clima("cotoca, santa cruz, bolivia");
				//https://s.yimg.com/zz/combo?a/i/us/we/52/26.gif
				echo "Nombre: Colonia Pirai<br>";
				echo "Temperatura actual: ".$pirai["actual"]."<br>";
				echo "Temperatura maximo: ".$pirai["max"]."<br>";
				echo "Temeratura minima: ".$pirai["min"]."<br>";
				echo "Humedad: ".$pirai["humedad"]."<br>";
				echo "fecha: ".$pirai["fecha"]."<br>";
				echo "code: ".$pirai["code"]."<br>";
				echo "imagen: https://s.yimg.com/zz/combo?a/i/us/we/52/".$pirai["code"].".gif<br>";
		    ?>
	    </div>
	    </li>
      </ul>
    </div>
    <?php require_once("footer.pub.php"); ?>
  </div>
</div>
<script>
  $( document ).ready(function() {
    $( ".page ul li" ).append( "<div class='bg'></div>" );
    $( ".page ul li a" ).append( "<div class='mas'>MAS</div>" );
  });
</script>
