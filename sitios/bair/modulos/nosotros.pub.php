<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require("header.pub.php");
?>
<div class="box-body">
  <div class="innerbanner">
          <img src="http://b-air.com/wp-content/uploads/2016/05/BANNERS_11.jpg" alt="">
  </div>
  <div class="container">
    <div class="col-md-7 box-contenido">
      <header class="entry-header">
        <h1 class="entry-title">SOBRE NOSOTROS</h1>
      </header>
      <h2><strong>Sobre B-Air®</strong> |<strong> Diseñado y fabricado en California</strong></h2>
      <p>Durante casi dos décadas, B-Air® ha desarrollado y fabricado moteres de aire, secadores, ventiladores, deshumidificadores y ventiladores para uso comercial y minorista. B-Air® se enorgullece de crear productos de alta calidad para satisfacer las necesidades de las industrias siempre cambiantes y en evolución  a las que sirve. los productos B-air están diseñados y fabricados en California garantizar la atención al detalle y el más alto nivel de calidad. Líder en la industria cuando se trata de las industrias inflables y mascotas, B-air está posicionada para convertirse en un líder del mercado en la industria de la restauración del daño por agua y de limpieza que ya ha convertido en el go-to de empresa para motores de aire de calidad, deshumidificadores, depuradores, daños por agua equipos de restauración y mucho más. Con elogios por parte de organizaciones de buena reputación, B-Air® continúa manteniendo sus objetivos principales: desarrollar productos de calidad superior con el servicio al cliente excepcional.</p>
      <h3><strong>División Mascotas &amp; Animales </strong></h3>
      <p>B-Air® a estado respondiendo a las necesidades de las industrias animales y la agricultura, ofreciendo seguros y duraderos, secadores, ventiladores, y deshumidificadores. B-Air® ofrece productos de alta calidad para los salones de aseo de mascotas, instalaciones veterinarias, perreras, uso en el hogar, y de secado grandes animales.</p>
      <h3><strong>División profesional</strong></h3>
      <p>B-Air® y su línea de productos satisface las necesidades de la restauración por daño con agua, secado de alfombras, y las industrias de servicios de limpieza, ofreciendo seguros y duraderos motores de aire, ventiladores y deshumidificadores. B-Air® ofrece productos de alta calidad para su uso en proyectos de restauración de daños de agua y empleos caseros y edificios comerciales.</p>
      <h3><strong>División Inflables </strong></h3>
      <p>B-Air® ha estado respondiendo a las necesidades de los inflables, publicidad, y las industrias de alquiler, ofreciendo sopladores seguros y duraderos. B-Air® ofrece productos de alta calidad para los saltarines, inflables y toboganes,  lobos publicitarios y muñecos, para empresas de alquiler y eventos.</p>

    </div>
    <div class="box-form col-md-5">
      <div id="sidebar">
        <h3 class="widget-title">Contact Form</h3>
        <?php
        require("form-contact.pub.php");
        ?>
      </div>
    </div>
  </div><!-- container-->
</div> <!-- box-body -->
<?php
require("footer.pub.php");
?>
