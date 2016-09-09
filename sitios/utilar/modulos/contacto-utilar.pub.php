<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;

require_once("header.pub.php");
?>
<div class="container-fluid contacto" >
  <div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-8 col-md-offset-0 box-form">
			<h1 class="">CONTÁCTENOS</h1>
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

		<div class="col-ms-4 col-md-offset-8">
			<div class="contacto-2">
				<h3 class="av-special-heading-tag">Otras formas de contactarse con nosotros</h3>

				<p>Vía telefónica o mediante la siguiente dirección, podrás&nbsp; conocer más acerca del Grupo Landicorp.</p>
				<p><strong>Dirección</strong></br>
					Tercer Anillo esq. Av. La Salle</br>
					Santa Cruz, BOLIVIA</p>
				<p><strong>Contáctenos </strong><br>
					(+591 3) 338-8222</p>
				<p><strong>Abierto:</strong><br>
					Lunes - Viernes: 8:00-12:00 y 14:30-18:30<br>
					Sáb: 9:00-12:00</p>
			</div>
		</div>
	</div>
  </div>
</div>

<div id="map" ></div>

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
			url:"<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-mail-utilar.php",
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
<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>

<?php
require_once("footer.pub.php");
?>
