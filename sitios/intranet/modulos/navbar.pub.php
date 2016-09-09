<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
$dir_ruta= explode("/", $_SERVER["REDIRECT_URL"]);
$id_usu = $this->fmt->sesion->get_variable("usu_id");
if(empty($id_usu)){
  	if(in_array("intranet", $dir_ruta)){
  		echo '<script>
				window.location.replace("'._RUTA_WEB.'intranet");
			  </script>';
  	}
}

?>
<div class="navbar menu-intranet">
	<div class="container-fluid">
		<div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <i class="icn-reorder"></i>
	      </button>
	    </div>
	     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active"><a href="<?php echo _RUTA_WEB; ?>intranet/portada"><i class="fa fa-home"></i></a></li>
				<? echo $fmt->nav->traer_cat_hijos_menu("25"); ?>
			</ul>
	     </div>
	</div>
</div>
