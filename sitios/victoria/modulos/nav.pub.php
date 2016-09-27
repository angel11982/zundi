<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<div id="preloader">
    <div id="loader" class="parpadea">&nbsp;</div>
</div>

<div class="box-n-nav container-fluid" >
	<div class="brand"><a href="<?php echo _RUTA_WEB; ?>"><img src="<?php echo _RUTA_WEB; ?>sitios/victoria/images/victoria.svg"></a></div>
		<!--
<a href="#" target="_blank"> INICIO </a>
		<a href="#" target="_blank"> NOSOTROS  </a>
		<a href="#" target="_blank"> PRODUCTOS </a>
		<a href="#" target="_blank"> SUCURSALES </a>
		<a href="#" target="_blank"> SOCIAL </a>
		<a href="#" target="_blank"> CONTACTO </a>
-->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
			    <? echo $fmt->nav->traer_cat_hijos_menu("0","0","2"); ?>
			</ul>
			<!--<ul class="nav navbar-nav navbar-right">
			    <li><a href="#"><i class="icon-search"></i></a></li>
			</ul>-->
			<div class="box-social box-social-top">
				<?php require_once("social.pub.php"); ?>
			</div>
		</div><!-- /.navbar-collapse -->
</div>
<script>

$(document).ready(function () {
	$(window).scroll(function(){
	    window_y = $(window).scrollTop();
	    scroll_critical = "150";
	    scroll_menu ="340";
	    s1 = parseInt($(".box-body").height());
	    if (window_y > scroll_critical){
	      $(".box-n-nav").addClass('on');
	    }
	    if (window_y < scroll_critical){
		  $(".box-n-nav").removeClass('on'); 
	    }
	});	
});


$(window).load(function() {
    $('#preloader').fadeOut('slow');
    $('body').css({'display':'block'});
});
</script>


