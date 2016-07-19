<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;

require_once("header.pub.php");

?>

<div id="map" ></div>

<div class="container form-contacto">
  <div class="col-xs-12 col-md-8 col-md-offset-0 box-form">
    <h3 class="">CONTÁCTENOS</h3>
    <div class="ref"><p>Queremos escucharte</p></div>
    <span class="hr-inner"></span>
    <form onsubmit="return action_form(this)" method="POST" id="form-contactenos" class="form" data-avia-form-id="1">
      <fieldset>
        <h3 class="title">Ingresa los siguientes datos:</h3>
        <div class="form-group" >
          <div class="col-md-5">
            <label>Nombre <span class="required" title="required" alt="Requerido" >*</span></label>
            <input required name="inputNombre" class="form-control input-lg" type="text" id="inputNombre" value="">
          </div>
          <div class="col-md-5" >
            <label>E-Mail <span class="required" title="required" alt="Requerido" >*</span></label>
            <input required name="inputEmail" class="form-control input-lg" type="email" id="inputEmail" value="">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-5">
            <label>Teléfono celular o fijo </label>
            <input name="inputTelf" class="form-control input-lg" type="text" id="input" value="">
          </div>
          <div class="col-md-5">
            <label>Motivo mensaje </label>
            <select name="inputMotivo" class="form-control input-lg" id="inputMotivo">
              <option value="Acerca de Nuestros Productos">Acerca de Nuestros Productos</option>
              <option value="Comprar Productos">Comprar Productos</option>
              <option value="Vender Productos">Vender Productos</option>
              <option value="Comentarios y Sugerencias">Comentarios y Sugerencias</option>
            </select>
          </div>
      </div>
      <div class="form-group">
      	<div class="col-md-12">
			<label>Consulta <span class="required" title="required" alt="Requerido" >*</span></label>
			<textarea required name="inputConsulta" class="form-control input-lg" cols="39" rows="7" id="inputConsulta"></textarea>
			</br><span class="required" title="required">*</span> Datos Requeridos
		</div>
      </div>
      <div class="control-group">
	      <div class="col-md-12">
	      	<div id="mensaje-mail"></div>
	      </div>
      </div> <!--    Mensaje login ajax  -->
      <div class="form-group">
      	<div class="col-md-12">
          <input type="submit" class="btn btn-primary" value="Enviar" id="Enviar_form" class="button" data-sending-label="Enviando">
      	</div>
      </div>
      </fieldset>
    </form>
  </div>
  <div class="col-ms-4 col-ms-offset-8">
    <div class="flex_column av_one_third  av-animated-generic bottom-to-top  flex_column_div av-zero-column-padding   avia-builder-el-5  el_after_av_two_third  avia-builder-el-last   avia_start_animation avia_start_delayed_animation" style="border-radius:0px; "><div style="padding-bottom:0px;" class="av-special-heading av-special-heading-h3  blockquote modern-quote  avia-builder-el-6  el_before_av_hr  avia-builder-el-first  "><h3 class="av-special-heading-tag" itemprop="headline">Otras formas de contactarse con nosotros</h3><div class="special-heading-border"><div class="special-heading-inner-border"></div></div></div>
<div style=" margin-top:10px; margin-bottom:10px;" class="hr hr-custom hr-left hr-icon-no  avia-builder-el-7  el_after_av_heading  el_before_av_textblock "><span class="hr-inner   inner-border-av-border-fat" style=" width:50px; border-color:#efbb20;"><span class="hr-inner-style"></span></span></div>
<section class="av_textblock_section" itemscope="itemscope" itemtype="https://schema.org/CreativeWork"><div class="avia_textblock " itemprop="text"><p>Vía telefónica o mediante la siguiente dirección, podrás&nbsp; conocer más acerca del Grupo Landicorp.</p>
</div></section>
<div style=" margin-top:10px; margin-bottom:10px;" class="hr hr-custom hr-left hr-icon-no  avia-builder-el-9  el_after_av_textblock  el_before_av_textblock "><span class="hr-inner   inner-border-av-border-fat" style=" width:50px; border-color:#efbb20;"><span class="hr-inner-style"></span></span></div>
<section class="av_textblock_section" itemscope="itemscope" itemtype="https://schema.org/CreativeWork"><div class="avia_textblock " itemprop="text"><p><strong>Dirección</strong><br>
Av. Noel Kempff Mercado, Esq. Canal Isuto<br>
Santa Cruz, BOLIVIA</p>
<p><strong>Contáctenos </strong><br>
(+591 3) 338-8100</p>
<p><strong>Abierto:</strong><br>
Lun – Vie: 8:00-12:00 y 14:30-18:30<br>
Sáb: 9:00-12:00</p>
</div></section></div>
  </div>
</div>

<script type="text/javascript" >
function initMap() {
  var myLatLng = {lat: -17.761810, lng: -63.190900};
  // Specify features and elements to define styles.
    var styleArray = [
      {
        featureType: "all",
        stylers: [
         { saturation: -80 }
        ]
      },{
        featureType: "road.arterial",
        elementType: "geometry",
        stylers: [
          { hue: "#00ffee" },
          { saturation: 50 }
        ]
      },{
        featureType: "poi.business",
        elementType: "labels",
        stylers: [
          { visibility: "off" }
        ]
      }
    ];
  // Create a map object and specify the DOM element for display.
  var map = new google.maps.Map(document.getElementById('map'), {
    center: myLatLng,
    scrollwheel: false,
    styles: styleArray,
    mark: marker,
    zoom: 17
  });

  // Create a marker and set its position.
  var marker = new google.maps.Marker({
    map: map,
    position: myLatLng,
    title: 'Landicorp'
  });


}
function action_form(){
		//alert("entre a acción");
		$("#Enviar_form").val("Enviando...");
		var datos = $("#form-contactenos").serialize()
		$.ajax({
			url:"<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-mail.php",
			type:"post",
			data:datos,
			success: function(msg){
			$("#Enviar_form").val("Enviar");
        if (msg!="false") {
          $("#mensaje-mail").html("<?php echo $fmt->mensaje->mail_ok(); ?>");
		  //toggleIdCerrar("success_mail", 6000);
        }
        else{
          $("#mensaje-mail").html("<?php echo $fmt->error->error_mail(); ?>");
          toggleIdCerrar("error_mail", 6000);  // core.js
        }

			}
		});
		/*elemento = document.getElementById("btn-ingresar");
 		elemento.blur();*/
		return false;
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?callback=initMap"
       async defer></script>

<?
require_once("footer.pub.php");
?>
