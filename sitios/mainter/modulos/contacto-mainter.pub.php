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
      <div class="title-page"><h2>Contactenos</h2></div>
      <div class="row">
        <div class="col-md-7  text-left">
        	<div class="ref"><p>Envíenos sus consultas, comentarios, pedido de información. Al finalizar, oprima "Enviar".</p></br></div>
			<span class="hr-inner"></span>
<form onsubmit="return action_form_contacto(this)" method="POST" id="form-contactenos" class="form" data-avia-form-id="1">
      <fieldset>
        <h3 class="title">Ingresa los siguientes datos:</h3>
        <div class="form-group" >
          <div class="col-md-12">
            <label>Nombre <span class="required" title="required" alt="Requerido" >*</span></label>
            <input required name="inputNombre" class="form-control input-lg" type="text" id="inputNombre" value="">
          </div>
          <div class="clearfix"></div>
          <div class="col-md-12" >
            <label>E-Mail <span class="required" title="required" alt="Requerido" >*</span></label>
            <input required name="inputEmail" class="form-control input-lg" type="email" id="inputEmail" value="">
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label>Teléfono celular o fijo </label>
            <input name="inputTelf" class="form-control input-lg" type="text" id="input" value="">
          </div>
          <div class="clearfix"></div>
          <div class="col-md-12">
            <label>Motivo mensaje </label>
            <select name="inputMotivo" class="form-control input-lg" id="inputMotivo">
              <option value="Acerca de Nuestros Productos">Acerca de Nuestros Productos</option>
              <option value="Comprar Productos">Comprar Productos</option>
              <option value="Vender Productos">Vender Productos</option>
              <option value="Comentarios y Sugerencias">Comentarios y Sugerencias</option>
            </select>
          </div>
      </div>
      <div class="clearfix"></div>
        <div class="form-group">
        	<div class="col-md-12">
				<label>Consulta <span class="required" title="required" alt="Requerido" >*</span></label>
				<textarea required name="inputConsulta" class="form-control input-lg" cols="39" rows="7" id="inputConsulta"></textarea>
      </br><span class="required" title="required obligatorio">*</span> Datos Requeridos
			</div>
      <div class="clearfix"></div>
		</div>
        <div class="control-group">
	        <div class="col-md-12">
		        <div id="mensaje-mail"></div>
	        </div>
        </div> <!--    Mensaje login ajax  -->
        <div class="form-group">
        	<div class="col-md-12">
				    <input type="submit" class="btn btn-primary btn-lg" value="Enviar" id="Enviar_form" class="button" data-sending-label="Enviando">
        	</div>
        </div>
        <div class="clearfix"></div>
      </fieldset>
    </form>
        </div>
        <div class="col-md-5">
          <div class="box-c-texto color-amarillo-a">
            <label>Asesores comerciales técnicos</label></br>
            <?
	             $sql ="SELECT conte_id,conte_cuerpo FROM contenidos, contenidos_categoria WHERE conte_cat_cat_id=$cat and conte_cat_conte_id=conte_id ORDER BY conte_id asc";
	             $rs = $fmt->query->consulta($sql);
	             $num = $fmt->query->num_registros($rs);

		if($num>0){
			for($i=0;$i<$num;$i++){
				list($fila_id, $fila_cuerpo)=$this->fmt->query->obt_fila($rs);
				echo $fila_cuerpo;
				}
			}

	            
            ?>
 </br>
			<p>
              <strong>Horarios de atención:</strong>
              </br>
              Lunes a Viernes 08:00  - 12:00

14:30  - 18:30 </br>
              Sábado 09:00 – 12:00
            </p>
            <!--<p>
              <strong>División Maquinaria</strong>
              </br>
              Carlos Mendez</br>
              Tef. 591 3 338-8100 int. 338-119</br>
              maquinaria@mainter.com.bo
            </p>
            <p>
              <strong>División Construcción</strong>
              </br>
              Pablo Sánchez</br>
              Tef. 591 3 338-8100 int. 177</br>
              construccion@mainter.com.bo
            </p>
            <p>
              <strong>División Línea Eco:</strong>
              </br>
              Gabriela Raldes</br>
              Tef. 591 3 338-8100 int. 140</br>
              lineaeco@mainter.com.bo
            </p>
            <p>
              <strong>División Pecuaria:</strong>
              </br>
              Gabriela Raldes</br>
              Tef. 591 3 338-8100 int.  140</br>
              pecuaria@mainter.com.bo
            </p>
-->
          </div>
        </div>
      </div>
    </div>
    <script>
    function action_form_contacto(){
		//alert("entre a acción");
		$("#Enviar_form").val("Enviando...");
		var datos = $("#form-contactenos").serialize()
		$.ajax({
			url:"<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-mail-mainter.php",
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
    <?php require_once("footer.pub.php"); ?>
  </div>
</div>
