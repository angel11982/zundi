<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;

require_once("header.pub.php");
?>
<div class="container-fluid productos" >
  <div class="container">
      <span class="titulo">
       <h1>NUESTROS PRODUCTOS</h1>
      </span>
      <div class="box-productos row">
          <div class="imagen col-md-4">
            <a href="http://tramontinastore.com/" target="_blank">
              <img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/utilar/images/bg-pr-tramontina.png" alt="bg-pr-tramontina" />
            </a>
          </div>
          <div class="texto col-md-7">
            <p>El Grupo Industrial <strong ><a href="http://tramontinastore.com/" target="_blank">TRAMONTINA</a></strong> posee actualmente 10 unidades industriales, la mayoría situadas en el estado de Río Grande do Sul, Brasil, cada una dedicada a la fabricación de un segmento especifico de productos. Con un continuo historial de crecimiento desde su fundación en el año 1.911, es una compañía que participa de los segmentos de utilidades domesticas de mesa y cocina, herramientas manuales para la construcción civil y profesional, herramientas agrícolas y para el jardín, lavaplatos, encimeras, campanas extractoras, hornos, porta mesetas y basureros en acero inox, muebles de madera o plástico, materiales eléctricos domiciliarios y de transmisión y distribución de alta tensión. <a class="btn-distribuidor" href="mailto:mvargas@utilar.com.bo?Subject=Quiero%20ser%20distribuidor%20Tramontina">Quiero ser distribuidor</a> </p>
          </div>
      </div>
      <div class="box-productos row">
        <div class="item col-md-10 col-md-offset-1">
          <div class="imagen col-md-4">
            <a href="http://www.invictaonline.com.br/" target="_blank"><img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/utilar/images/bg-pr-invicta.png" alt="bg-pr-tramontina" /></a>
          </div>
          <div class="texto col-md-7">
            <p><strong ><a href="http://www.invictaonline.com.br/" target="_blank">Invicta</a></strong> es fundada en el año 1952, actualmente esta instalada en la localidad de Pouso Alegre, Minas Gerais, Brasil. Ofrece una amplia gama de productos térmicos con excelente desempeño tanto en frío como en calor. Sus líneas incluyen termos con ampollas de vidrio o de acero inoxidable, de pico, rosca o presión; los isotérmicos con las conservadoras y botellones, y la línea de jarras y potes de vidrio. <a class="btn-distribuidor" href="mailto:mvargas@utilar.com.bo?Subject=Quiero%20ser%20distribuidor%20Invicta">Quiero ser distribuidor</a></p>
          </div>
        </div>
      </div>
      <div class="box-productos row">
        <div class="item col-md-10 col-md-offset-1">
          <div class="imagen col-md-4">
            <a href="http://www.plasutil.com.br/plasutil/pt/index.php" target="_blank"><img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/utilar/images/bg-pr-plasutil.png" alt="bg-pr-tramontina" />
          </div>
          <div class="texto col-md-7">
            <p><strong ><a href="http://www.plasutil.com.br/plasutil/pt/index.php" target="_blank">Plasutil</a></strong> es una empresa brasileña fundada en 1986 y ubicada en el Distrito Industrial de Baurú Sao Paulo. Se especializa en la inyección de utilidades en polipropileno virgen libres de BPA para diversos usos divididos en sus líneas de potes, cocina, mesa, infantil, fiesta, limpieza, baño, organizadores, mascotas y licenciados. <a class="btn-distribuidor" href="mailto:mvargas@utilar.com.bo?Subject=Quiero%20ser%20distribuidor%20Plasútil">Quiero ser distribuidor</a></p>
          </div>
        </div>
      </div>
      <div class="box-productos row">
        <div class="item col-md-10 col-md-offset-1">
          <div class="imagen col-md-4">
            <a href="http://www.porcelanaschmidt.com.br/schmidt/site/index.php" target="_blank"><img class="img-responsive" src="<?php echo _RUTA_WEB; ?>sitios/utilar/images/bg-pr-i.png" alt="bg-pr-tramontina" /></a>
          </div>
          <div class="texto col-md-7">
            <p>Empresa brasileña fundada en 1945 en Santa Catarina, <strong><a href="http://www.porcelanaschmidt.com.br/schmidt/site/index.php" target="_blank">SCHMIDT</a></strong> se especializa en la fabricación de vajilla de porcelana para uso domiciliario e institucional. <a class="btn-distribuidor" href="mailto:mvargas@utilar.com.bo?Subject=Quiero%20ser%20distribuidor%20SCHMIDT">Quiero ser distribuidor</a> </p>
          </div>
        </div>
      </div>
  </div>
</div>


<?php
require_once("footer.pub.php");
?>
