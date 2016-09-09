<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>
<div id="carousel-example-generic" class="carousel carousel-m slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="bar-item"></div>
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <div class="box-m-item">
        <div class="foto">
          <img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/beceratti/images/ito-1.png" >
        </div>
        <i class="fa fa-circle"></i>
        <strong>Año o HITO</strong>
        <p>that is, the person who pulled the
        bow-oar in his boat (the second one from forward), it was my
        cheerful duty to attend upon him while taking that hard-scrabble
        scramble upon the dead whale's back. </p>

        <a href="<?php echo _RUTA_WEB; ?>el-artista" target="_blank">Leer más</a>
      </div>
      <div class="box-m-item">
        <div class="foto">
          <img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/beceratti/images/ito-2.png" >
        </div>
        <i class="fa fa-circle"></i>
        <strong>Año o HITO</strong>
        <p>that is, the person who pulled the
        bow-oar in his boat (the second one from forward), it was my
        cheerful duty to attend upon him while taking that hard-scrabble
        scramble upon the dead whale's back. </p>

        <a href="<?php echo _RUTA_WEB; ?>el-artista" target="_blank">Leer más</a>
      </div>
    </div>
    <div class="item">
      <div class="box-m-item">
        <div class="foto">
          <img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/beceratti/images/ito-1.png" >
        </div>
        <i class="fa fa-circle"></i>
        <strong>Año o HITO</strong>
        <p>that is, the person who pulled the
        bow-oar in his boat (the second one from forward), it was my
        cheerful duty to attend upon him while taking that hard-scrabble
        scramble upon the dead whale's back. </p>

        <a href="<?php echo _RUTA_WEB; ?>el-artista" target="_blank">Leer más</a>
      </div>
      <div class="box-m-item">
        <div class="foto">
          <img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/beceratti/images/ito-2.png" >
        </div>
        <i class="fa fa-circle"></i>
        <strong>Año o HITO</strong>
        <p>that is, the person who pulled the
        bow-oar in his boat (the second one from forward), it was my
        cheerful duty to attend upon him while taking that hard-scrabble
        scramble upon the dead whale's back. </p>

        <a href="<?php echo _RUTA_WEB; ?>el-artista" target="_blank">Leer más</a>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="icn-chevron-left" aria-hidden="true"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="icn-chevron-right" aria-hidden="true"></span>
  </a>
</div>
