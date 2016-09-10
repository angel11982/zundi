<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");
?>
<div class="container-fluid portada">
  <div class="side-bar-m">
   <?php require_once("sidebar.pub.php"); ?>
  </div>
  <div class="body-page-m page-cm" id="body-page-m">
    <div class="page container">
      <div class="title-page"><h2>Conozca Mainter</h2></div>
      <div class="row">
        <div class="col-md-6 text-left box-texto">
          <strong>NUESTRA VISIÓN</strong><br/>

<p>Nuestra Historia es el mejor indicador de que Mainter es una empresa que mira permanentemente al futuro sin dejar de avanzar. Es por ello que nos anticipamos a las nuevas exigencias del mercado, mediante la innovación y permanente transferencia de tecnología a nuestros clientes para que adopten nuevas formas competitivas de trabajar, producir y tener éxito en su actividad agrícola empresarial.</p><br/>

  <strong>NUESTRA MISION</strong><br/>

<p>Brindamos soluciones innovadoras que aportan al desarrollo de la actividad agrícola de nuestros clientes mediante altos estándares de calidad en servicio y diversidad de Productos Agroquímicos y Maquinaria Agrícola, sustentado por personal calificado y comprometido con el éxito del cliente.</p>

<br/>

  <strong>NUESTRA POLITICA DE LA CALIDAD</strong><br/>

<p>Somos una organización que brinda servicio técnico integral especializado que comercializa insumos - agroquímicos y maquinaria para la agroindustria y segmentos de mercado especializados.</p>
  <p>Con este propósito asumimos el compromiso de:</p>

<ul><li>Satisfacer plenamente las necesidades y expectativas de nuestros clientes internos y externos.</li>

<li>Mejorar continuamente el desempeño y la calidad de nuestros procesos y servicios.</li>

<li>Desarrollar nuestras marcas y posicionarlas en los mercados objetivos como productos de calidad.</li>

<li>Fortalecer las competencias de nuestro personal y desarrollar un ambiente de trabajo favorable para la creatividad e innovación.</li>
<li>Cumplir los requisitos legales y reglamentarios vigentes aplicables a nuestras actividades, así como los requisitos de nuestro Sistema de Gestión de la Calidad.</li>
</ul>
<br/>
<br/>
  <strong>
VALORES</strong><br/>
<ul>
<li>Compromiso con el servicio al cliente</li>

<li>Búsqueda permanente de la excelencia</li>

<li>Responsabilidad social y empresarial</li>

<li>Trabajo en Equipo</li>
  </ul>
        </div>
        <div class="col-md-6 img-right">
          <div class="box-d-mc">
          <?php require_once("compartir.pub.php"); ?>
          </div>
          <span class="frase">
            “La agricultura es compleja y está llena de desafíos”
          </span>
          <?php
            $im=$fmt->class_modulo->fila_modulo("10","mul_url","multimedia","mul_"); //$id,$fila,$from,$prefijo
            //echo $im;
          ?>
          <img class="img-responsive" src="<?php echo _RUTA_WEB.$im; ?>" alt=""  />
          <span class="frase color-celeste-a">
            “La agricultura es compleja y está llena de desafíos”
          </span>
          <?php
            $im2=$fmt->class_modulo->fila_modulo("11","mul_url","multimedia","mul_"); //$id,$fila,$from,$prefijo
            //echo $im;
          ?>
          <img class="img-responsive" src="<?php echo _RUTA_WEB.$im2; ?>" alt=""  />
        </div>
      </div>
    </div>
    <?php require_once("footer.pub.php"); ?>
  </div>
</div>
