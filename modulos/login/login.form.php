<?php
$fmt = new CONSTRUCTOR();
?>
<div class="login color-gradient-blanco color-shadow-negro" >
  <div class="btn btn-cerrar color-text-gris-b"  onclick="toggleId('block-login');"  >
  <i class="icn-close"></i>
  </div>
  <form class="form" onsubmit="return action_form(this)" method="POST" id="form-ingreso">
    <div class="brand-login">
    <?php  echo $fmt->brand->brand_login();?>
    </div>
    <div class="control-group" id="mensaje-login"></div> <!--    Mensaje login ajax  -->
    <div class="control-group">
      <div class="input-group email controls">
        <span class="input-group-addon color-border-gris-a  color-text-gris"><i class="icn-email"></i></span>
        <input class="form-control input-lg color-border-gris-a color-text-gris" onClick="seleccionar(this);" onBlur="deseleccionarBuscar(this);" id="inputEmail" name="inputEmail" placeholder="Email" type="text">
        </div>
        <div class="input-group password controls">
        <span class="input-group-addon color-border-gris-a  color-text-gris"><i class="icn-lock"></i></span>
        <input type="password" class="form-control input-lg color-border-gris-a  color-text-gris" id="password" name="password" placeholder="Password"  >
      </div>
      <p class="help-block"><a href="#" class="color-text-gris"><i class="icon-danger"></i>¿ Olvidaste tu contraseña ?</a></p>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-success btn-lg btn-ingresar color-bg-azul hvr-fade" id="btn-ingresar">Ingresar</button>
    </div>

  </form>
</div>
<?php
  //echo "cat:".$cat."pla:".$pla."usu_id:".$sesion->get_variable('usu_id');
  //echo "sec:".$sesion->existe_variable("usu_id");
?>
<script type="text/javascript" >
	function action_form(){
		//alert("entre a acción");
		var ie = $("#inputEmail").val( );
		var ip = $("#password").val( );
		$.ajax({
			url:"<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-login.php",
			type:"post",
			data:{ inputEmail:ie , password:ip },
			success: function(msg){
        //alert(msg);
	        
if ((msg!="false")&&(msg!="sin-rol")&&(msg!="rol-desactivado")) {
	          $("#mensaje-login").html("<?php echo $this->fmt->mensaje->login_ok(); ?>");
	          redireccionar_tiempo(msg,800); // core.js
	        }
	        
	        if(msg=="sin-rol"){
	          $("#mensaje-login").html("<?php echo $this->fmt->error->error_rol(); ?>");
	          toggleIdCerrar("error_login", 6000);  // core.js
	        }
	        
	        if(msg=="rol-desactivado"){
	          $("#mensaje-login").html("<?php echo $this->fmt->error->error_rol_desactivado(); ?>");
	          toggleIdCerrar("error_login", 6000);  // core.js
	        }
	        
	        if (msg=="false") {
	          $("#mensaje-login").html("<?php echo $this->fmt->error->error_login(); ?>");
	          toggleIdCerrar("error_login", 3000); // core.js
	        }
			//$("#mensaje-login").html(msg);
		  }
		});
		elemento = document.getElementById("btn-ingresar");
 		elemento.blur();
		return false;
	}
</script>
