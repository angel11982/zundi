<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");
require_once("menu.pub.php");
$id_cat=1;
if(isset($_GET["cat"]))
$id_cat=$_GET["cat"];
$nombre_cat=$fmt->categoria->nombre_categoria($id_cat);
$des_cat = $fmt->categoria->descripcion($id_cat,"categoria","cat_");
$ruta_cat= $fmt->categoria->ruta_amigable($id_cat);
?>
<div class="container-fluid body-m" id="lista-productos">
  <div class="box-m-titulo">
    <label><?php echo $nombre_cat; ?></label>
    <span>
      <?php echo $des_cat; ?>
    </span>
  </div>
  <div class="lista-productos">
  <?php
	 $consulta = "SELECT mod_prod_nombre, mod_prod_ruta_amigable, mod_prod_imagen FROM mod_productos, mod_productos_rel WHERE mod_prod_rel_cat_id='$id_cat' and mod_prod_rel_prod_id=mod_prod_id and mod_prod_activar=1 ORDER BY mod_prod_id desc";

	 $rs = $fmt->query->consulta($consulta);
	 $num= $fmt->query->num_registros($rs);

	 if($num>0){
     	for($i=0;$i<$num;$i++){
        	list($fila_nombre,$fila_rut_amigable, $fila_imagen)=$this->fmt->query->obt_fila($rs);
  ?>
    <div class="lista p<?php echo ($i+1);?>"><a style="background: url('<?php echo _RUTA_WEB.$fila_imagen; ?>') #fff no-repeat center center;" href="<?php echo $ruta_cat."/".$fila_rut_amigable.".html"; ?>"><label><?php echo $fila_nombre; ?></label></a></div>

    <?php
	    }
	  }
    ?>
  </div>
</div>
