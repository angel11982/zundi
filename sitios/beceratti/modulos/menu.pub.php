<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<i class="icn-reorder menu-toggle-o mb"></i>
<i class="icn-close menu-toggle-o mb"></i>
<div class="sidebar-m-d m-d">
  <div class="box-m-sidebar">
    <div class="brand-mini"><img src="<?php echo _RUTA_WEB; ?>sitios/beceratti/images/mini-logo.svg" ></div>
    <div class="box-m-menu">
      <ul>
        <li><a href="<?php echo _RUTA_WEB; ?>">INICIO</a></li>
        <li><a href="<?php echo _RUTA_WEB; ?>#el-artista">El ARTISTA</a></li>
        <li><a  class="active" href="<?php echo _RUTA_WEB; ?>#piezas">PIEZAS</a></li>
        <li><a href="<?php echo _RUTA_WEB; ?>#la-carpinteria">LA CARPINTERIA</a></li>
        <li><a href="<?php echo _RUTA_WEB; ?>responsabilidad-social">RESPONSABILIDAD SOCIAL</a></li>
        <li><a href="<?php echo _RUTA_WEB; ?>sala-de-prensa">SALA DE PRENSA</a></li>
        <li><a href="<?php echo _RUTA_WEB; ?>contacto">CONTACTO</a></li>
      </ul>
    </div>
    <div class="box-m-direccion">
      <span> Dirección :  Av. la Salle #434<br/>
Telft. 23423434534<br/>
ventas :  ventas@beceratty.com<br/>
      </span>
      <div>
      <a href="#"><i class="fa fa-facebook"></i> </a>
      <a href="#"><i class="fa fa-instagram"></i> </a>
      <a href="#">EN</a>
      </div>
    </div>
  </div>
  <div class="bg-sidebar-d"></div>
</div>
<script>
$(document).ready(function () {
   $(".menu-toggle").addClass('off');
  $('.menu-toggle-o').click(function(e){
     $(".sidebar-m-d").toggleClass('on');
     $('.icn-close.mb').toggleClass('on');
     $('.icn-reorder.mb').toggleClass('on');
  });
});

</script>
