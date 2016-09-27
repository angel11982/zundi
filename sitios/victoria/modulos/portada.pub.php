<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");
?>

<div class="box-body container-fluid box-portada">
	 <div class="mensaje">
		 <img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/victoria/images/celebremos.svg">
	 </div>
	 <div style="padding:0; height:97vh;  float:left;  width: 100%; opacity: 1; overflow: hidden;   position:fixed; z-index:0" class="videoBG">
      <video src="<?php echo _RUTA_WEB; ?>sitios/victoria/video/victoria-5.mp4" autoplay="autoplay" poster="<?php echo _RUTA_WEB; ?>sitios/victoria/images/fonto-1.png" style="position:absolute;  min-width:100%; top:50%; left:50%; transform: translateX(-50%) translateY(-50%) " loop></video>
      
    </div>
	<div class="box-shadow"></div>
</div>

<?php
require_once("footer.pub.php");	
?>