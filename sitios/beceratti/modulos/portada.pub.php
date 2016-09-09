<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

<div class="container-fluid portada body-m" id="portada">
  <div class="side-bar-m">
   <?php require_once("sidebar.pub.php"); ?>
  </div>
  <div class="bg-gradient"></div>
  <div class="body-page-m" id="body-page-m">
    <div style="padding:0; height:100vh;  float:left;  width: 100%; opacity: 1; overflow: hidden;   position:relative" class="videoBG">
      <video src="<?php echo _RUTA_WEB; ?>sitios/beceratti/video/prueba-beceratti.mp4" autoplay="autoplay" poster="<?php echo _RUTA_WEB; ?>sitios/beceratti/images/fonto-1.png" style="position:absolute;min-height:120%; min-width:100%; top:50%; left:50%; transform: translateX(-50%) translateY(-50%)" loop></video>
    </div>
  </div>
</div>

<div class="container-fluid portada body-m" id="piezas">
  <div class="menu-productos">
    <label>PIEZAS</label>
    <span>
      Banjo tote bag bicycle rights, High Life sartorial cray craft beer whatever street art fap. Hashtag typewriter banh mi, squid keffiyeh High Life Brooklyn twee craft beer tousled chillwave.
    </span>
    <ul>
      <li class="lista-piezas"><a href="<?php echo _RUTA_WEB; ?>piezas/sillas" target="_self">SILLAS</a></li>
      <li class="lista-piezas"><a href="<?php echo _RUTA_WEB; ?>piezas/mesas">MESAS</a></li>
      <li class="lista-piezas"><a href="<?php echo _RUTA_WEB; ?>piezas/iconicos">ICONICOS</a></li>
      <li class="lista-piezas"><a href="<?php echo _RUTA_WEB; ?>piezas/elementos">ELEMENTOS</a></li>
    </ul>
  </div>
  <div class="lista-productos">
    <div class="lista-sillas p1"><a href="<?php echo _RUTA_WEB; ?>piezas/sillas"><label>SILLAS</label></a></div>
    <div class="lista-sillas p2"><a href="<?php echo _RUTA_WEB; ?>piezas/mesas"><label>MESAS</label></a></div>
    <div class="lista-sillas p3"><a href="<?php echo _RUTA_WEB; ?>piezas/iconicos"><label>ICONICOS</label></a></div>
    <div class="lista-sillas p4"><a href="<?php echo _RUTA_WEB; ?>piezas/elementos"><label>ELEMENTOS</label></a></div>
  </div>
</div>

<div class="container-fluid portada body-m" id="el-artista">
  <div class="box-m-resena">
    <label>EL ARTISTA</label>
    <span>
      <img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/beceratti/images/el-artista.png" >
      <strong>Reseña</strong>
      <p>that is, the person who pulled the
      bow-oar in his boat (the second one from forward), it was my
      cheerful duty to attend upon him while taking that hard-scrabble
      scramble upon the dead whale's back. </p>

      <a href="<?php echo _RUTA_WEB; ?>el-artista" target="_blank">Leer más</a>
    </span>
  </div>
  <div class="box-m-itos">
    <?php require_once("hitos.pub.php");  ?>
  </div>
</div>

<div class="container-fluid portada body-m" id="la-carpinteria">
  <div class="box-m-tc">
    <label>LA CARPINTERIA</label>
    <span>
      <p>that is, the person who pulled the
      bow-oar in his boat (the second one from forward), it was my
      cheerful duty to attend upon him while taking that hard-scrabble
      scramble upon the dead whale's back. </p>
      <p>that is, the person who pulled the
      bow-oar in his boat (the second one from forward), it was my
      cheerful duty to attend upon him while taking that hard-scrabble
      scramble upon the dead whale's back. </p>
      <p>that is, the person who pulled the
      bow-oar in his boat (the second one from forward), it was my
      cheerful duty to attend upon him while taking that hard-scrabble
      scramble upon the dead whale's back. </p>
      <a href="#" target="_blank">Leer más</a>
    </span>
  </div>
  <div class="foto">
    <img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/beceratti/images/la-carpinteria.png" >
    <div class="ref">
      Lorem Ipsum Dolor Sit Amet Consectetur Adipisicing Elit Se
    </div>
  </div>
</div>



 <?php require_once("footer.pub.php"); ?>
