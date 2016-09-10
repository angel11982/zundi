<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;

require_once("nav.pub.php");
?>
 <div class="container-fluid pag-producto">
  <div class="side-bar-m">
   <?php require_once("sidebar.pub.php"); ?>
  </div>
  <div class="body-page-m body-enviar" id="body-page-m">
    <div class="page container">
	    <h1>Enviar a un amigo</h1>
	    <form onsubmit="return action_form_contacto(this)" method="post" name="FormCorreo" id="FormCorreo" class="box-md-8">
	    <?
		    $fmt->get->validar_get ( $_GET['prod'] );
			$id = $_GET['prod'];
			$sql="SELECT mod_prod_nombre FROM mod_productos WHERE mod_prod_id='$id'";
			$rs =$fmt->query->consulta($sql);
			$fila=$fmt->query->obt_fila($rs);

		    $fmt->form->input_form('','inputNombre','* Tu Nombre','','obligatorio','','','required');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		    $fmt->form->input_mail('','inputEmail','* Tu e-mail','','','','','required');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		    $fmt->form->input_mail('','inputEmailAmigo','* El e-mail de tus amigos ','','','','Ej: correo@dominio.com, correo_1@dominio.com','required');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		    $fmt->form->input_form('Asunto:','inputAsunto','','Dale un vistazo al producto: '.$fila['mod_prod_nombre'],'','','(*) Es obligatorio');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje

		    $fmt->get->validar_get ( $_GET['ruta'] );
			$ruta = _RUTA_WEB_temp.str_replace(" ","/",$_GET['ruta']);
		    $valor_cuerpo .= "<div class='box-mensaje'>";
		    $valor_cuerpo .= "Link del producto:</br>";
		    $valor_cuerpo .= "<a href='".$ruta."' target='_blanck'>".$ruta."</a>";
		    $valor_cuerpo .= "</div>";
		    $fmt->form->input_hidden_form('InputMensaje',$valor_cuerpo);//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
			echo $valor_cuerpo;

		?>
		<div id="MsgCorreo"></div>
		 <div class="form-group form-botones">
       <button type="submit" class="btn-accion-form btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="enviar"><i class="fa fa-envelope-o" ></i> Enviar Correo</button>
    </div>
	</form>
	<script>
	function action_form_contacto(){
		//alert("entre a acción");
		$("#MsgCorreo").html("Enviando...");
		var datos = $("#FormCorreo").serialize()
		$.ajax({
			url:"<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-mail-enviar.php",
			type:"post",
			data:datos,
			success: function(msg){
			$("#Enviar_form").val("Enviar");
		        if (msg!="false") {
		          $("#MsgCorreo").html("<?php echo $fmt->mensaje->mail_compartir_ok(); ?>");
				  //toggleIdCerrar("success_mail", 6000);
		        }
		        else{
		          $("#MsgCorreo").html("<?php echo $fmt->error->error_mail(); ?>");
		          toggleIdCerrar("error_mail", 6000);  // core.js
		        }

			}
		});

		return false;
	}
	</script>
	</div>
	<?php require_once("footer.pub.php"); ?>
  </div>
</div>