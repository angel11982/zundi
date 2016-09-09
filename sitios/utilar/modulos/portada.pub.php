<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;

require_once("header.pub.php");

$consulta ="SELECT mul_id,mul_url,mul_descripcion, mul_leyenda, mul_texto_alternativo, mul_orden FROM multimedia, multimedia_rel WHERE mul_rel_cat_id='4' and mul_id=mul_rel_mul_id and mul_activar='1' ORDER BY `multimedia`.`mul_orden` asc";
$rs =$this->fmt->query->consulta($consulta);
$num=$this->fmt->query->num_registros($rs);
if($num>0){
?>
<div id="<? echo $nom;?>" class="Publicacion">

<div id="carousel-m1" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators container">
    <?php
      for($i=0;$i<$num;$i++){
        if ($i==0){$aux ='active'; } else { $aux =""; }
    ?>
    <li data-target="#carousel-m1" data-slide-to="<?php echo $i; ?>" class="<?php echo $aux; ?>" >
      <div class="tab-<?php echo $i+1; ?>"></div>
      <div class="bg"></div>
    </li>
    <?php
      }
    ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php
      for($i=0;$i<$num;$i++){
        if ($i==0){$aux ='active'; } else { $aux =""; }
        list($fila_id,$fila_url,$fila_descripcion,$fila_leyenda, $fila_texto,$fila_orden)=$this->fmt->query->obt_fila($rs);
    ?>
    <div class="item <?php echo $aux; ?> item_<?php echo $i; ?>">
      <div class="caption">
        <h1><?php echo $fila_leyenda; ?></h1>
        <p><?php echo $fila_texto; ?></p>
        <?php echo $fila_descripcion; ?>
      </div>
      <div class="shadow-item"></div>
      <div class="imagen" style="background-image:url('<?php echo _RUTA_WEB.$fila_url; ?>')" ></div>
    </div>
    <?php
      }
    ?>



  </div>

  <!-- Controls -->
  <a class="left carousel-control"  href="#carousel-m1" role="button" data-slide="prev">
    <span class="icn-chevron-left" aria-hidden="true"></span>
  </a>
  <a class="right carousel-control" href="#carousel-m1" role="button" data-slide="next">
    <span class="icn-chevron-right" aria-hidden="true"></span>
  </a>
</div>

<?php
}
?>
<script>
	$('.carousel').carousel({
    	pause: "false"
	});
</script>

<?php
require_once("footer.pub.php");
?>
