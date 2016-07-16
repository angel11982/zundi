<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<div class="btn-sidebar"><a href="<?php echo _RUTA_WEB;?>"><img class="brand-m" src="<?php echo _RUTA_WEB;?>sitios/mainter/images/icon-mainter-w.svg"></a></div>
<ul>
  <? echo $fmt->nav->traer_cat_hijos_menu("3"); ?>
</ul>
