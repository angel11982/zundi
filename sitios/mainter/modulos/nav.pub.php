<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
$id_dominio = $fmt->categoria->traer_id_cat_dominio(_RUTA_WEB);
?>
<div class="nav-bar-m fixed">
 <div class="btn-menu-m" id="btn-menu-m">
   <i class="fa fa-reorder icon-reorder"></i>
   <i class="fa fa-remove icon-remove"></i>
 </div>
 <div class="brand"><a href="<?php echo _RUTA_WEB; ?>"><img src="<?php echo _RUTA_WEB; ?>sitios/mainter/images/logo-mainter.svg" ></a></div>
 <div class="social">
  <i class="fa fa-facebook"></i>
  <i class="fa fa-linkedin"></i>
  <!--<i class="fa fa-comments-alt"></i>-->
 </div>
<div class="social-fa">
<i class="fa fa-caret-up indicador-arriba"></i>
<a target="_blank" href="https://www.facebook.com/Mainter.Srl/?fref=ts"><i class="fa fa-facebook"></i> Mainter </a>
<a target="_blank" href="https://www.facebook.com/mainterlineaeco/?fref=ts"><i class="fa fa-facebook"></i> Mainter Línea Eco</a>
<a target="_blank" href="https://www.facebook.com/mainterconstruccion/?fref=ts"><i class="fa fa-facebook"></i> Mainter Construcción</a>
</div>

<div class="buscar"> <span>Buscar</span> <i class="fa fa-search"></i><i class="fa fa-close"></i></div>
</div>
<div class="box-buscar-m">

		<i class="fa fa-search"></i>

		<input type="search" id="q" name="q" placeholder="Buscar">

		<input type="button" id="buscar" class="btn-buscar btn" value="Buscar"/>

</div>

<script>
  $( document ).ready(function() {
    //console.log( "document loaded" );
    $(".btn-menu-m").click(function() {
      //console.log('click buscar');
      $( "#body-page-m" ).toggleClass( "on" );
      $( "#btn-menu-m" ).toggleClass( "on" );
    });

    $(".social .fa-linkedin").click(function() {
	    window.open( 'http://www.linkedin.com/mainter', '_blank');
	});

	$(".social .fa-facebook").click(function() {
		$(".social-fa").toggleClass( "on" );
	});

	$(".buscar").click(function() {
		$(".box-buscar-m").toggleClass( "on" );
		$(".buscar").toggleClass( "on" );
	});

	$("#buscar").click(function(){
		buscar();
	});

	$("#q").keypress(function(e){
		if(e.which == 13) {
	        buscar();
		}
	});

  });
  function buscar(){
	  var q = $("#q").val();

	  window.location = "<?php echo _RUTA_WEB; ?>buscar/"+q;
  }
</script>
