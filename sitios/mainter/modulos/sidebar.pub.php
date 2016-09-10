<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<div class="btn-sidebar"><a href="<?php echo _RUTA_WEB;?>"><img class="brand-m" src="<?php echo _RUTA_WEB;?>sitios/mainter/images/icon-mainter-w.svg"></a></div>
<ul>
  <?
	        //echo  $fmt->nav->traer_cat_hijos_menu("3");
	      $sql="SELECT cat_id, cat_nombre, cat_id_padre, cat_icono, cat_url, cat_destino, cat_ruta_amigable FROM categoria WHERE cat_id_padre='3' and cat_activar='1' ORDER BY cat_orden ASC";
		    $rs = $fmt->query->consulta($sql);
		    $num = $fmt->query->num_registros($rs);
		    if ($num>0){
		    	for ($i=0; $i<$num; $i++){
			        list($fila_id, $fila_nombre, $fila_id_padre, $fila_icono, $fila_url, $fila_destino, $fila_ruta_amigable) =  $fmt->query->obt_fila($rs);

			        if (!empty($fila_url)){
			          $url= $fila_url; $destino=$fila_destino;
			        }else{
			          $url= _RUTA_WEB.$fila_ruta_amigable; $destino="";
			        }
			        $aux .= $fmt->nav->fmt_li($fila_id,"","",$fila_nombre, $url, $destino );
        		}
    		}
			echo $aux;
	    ?>

</ul>
