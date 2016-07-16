<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<div class="nav-bar-m fixed">
 <div class="btn-menu-m" id="btn-menu-m">
   <i class="fa fa-reorder"></i>
   <i class="fa fa-remove"></i>
 </div>
 <div class="brand"><a href="<?php echo _RUTA_WEB; ?>"><img src="<?php echo _RUTA_WEB; ?>sitios/mainter/images/logo-mainter.svg" ></a></div>
 <div class="social">
  <i class="fa fa-facebook"></i>
  <i class="fa fa-linkedin"></i>
  <i class="fa fa-twitter"></i>
  <!--<i class="fa fa-comments-alt"></i>-->
 </div>
 <div class="buscar"> <span>Buscar</span> <i class="fa fa-search"></i></div>
</div>
<script>
  $( document ).ready(function() {
    //console.log( "document loaded" );
    $(".btn-menu-m").click(function() {
      //console.log('click buscar');
      $( "#body-page-m" ).toggleClass( "on" );
      $( "#btn-menu-m" ).toggleClass( "on" );
    });

  });
</script>
