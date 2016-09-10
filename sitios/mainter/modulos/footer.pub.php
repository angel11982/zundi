<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<div class="footer container-fluid">
  <div class="container">
    <div class="direccion-general">
      <?
      $sql="select conte_id,conte_cuerpo from contenidos where conte_id='1' and conte_activar='1'";
      $rs=$fmt->query->consulta($sql);
      $num = $fmt->query->num_registros($rs);
      $fila = $fmt->query->obt_fila($rs);
      echo $fila['conte_cuerpo'];
      ?>
    </div>
    <?php if ($cat!="19"){ ?>
    <div class="direccion-cat">
      <?
      $sql="select conte_id,conte_cuerpo from contenidos, contenidos_categoria where conte_cat_cat_id='".$cat."' and conte_cat_conte_id=conte_id and conte_activar='1'";
      $rs=$fmt->query->consulta($sql);
      $num = $fmt->query->num_registros($rs);

      if($num>0){
        for($j=0;$j<$num;$j++){
          list($fila_id,$fila_cuerpo) = $fmt->query->obt_fila($rs);
          echo "<div class='box-contenido box-contenido-".$i."'>";
          echo $fila_cuerpo;
          echo "</div>";
        }
      }
      ?>
    </div>
    <?php } ?>

  </div>
</div>
