<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<!-- inicio css y script -->
<script type='text/javascript' src='<? echo _RUTA_WEB; ?>sitios/landicorp/js/scripts.js'></script>
<!-- pre-loader-->
<div class='pre-load-web'>
  <div class='box-siteloader'>
    <div class='logo-loading' title='Loading'></div>
    <div class='siteloader'>
      <div class='siteloader-extra'></div>
    </div>
  </div>
</div>
<!-- inicio menu-top -->
<div class="container-fluid menu-top">
	<div class="datos pull-right">
    <i class="icon-phone"></i> Telf.: (+591 3) 338-8100</a>
  </div>
</div>

<!-- inicio box-logo -->
<div class="container box-logo">
  <div class="brand pull-left">
    <a href="<? echo _RUTA_WEB; ?>landicorp">
      <img class="img-responsive" src="<? echo _RUTA_WEB; ?>sitios/landicorp/images/Logo-Landicorp-2016.png" alt="Grupo Landicorp">
    </a>
  </div>
  <div class="rs pull-right">
    <a class="btn-fb" href="#"><i class="icon-facebook"></i></a>
    <a class="btn-tw" href="#"><i class="icon-twitter"></i></a>
    <a class="btn-in" href="#"><i class="icon-linkedin"></i></a>
  </div>
</div>


<!-- inicio menu-general -->

<nav class="navbar menu-general">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <i class="icn-reorder"></i>
      </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<? echo _RUTA_WEB; ?>">Portada</a></li>
        <? echo $fmt->nav->traer_cat_hijos_menu("2"); ?>
      </ul>
      <!--<ul class="nav navbar-nav navbar-right">
        <li><a href="#"><i class="icon-search"></i></a></li>
      </ul>-->
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
