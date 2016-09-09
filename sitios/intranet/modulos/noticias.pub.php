<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;

$fmt->class_modulo->fecha_zona('America/La_Paz');
function traer_cat_hijos($fmt,$cat_padre,$id_not){
	$cat_hi=0;
	if($fmt->categoria->tiene_hijos($cat_padre,"categoria","cat_")){
		$consulta ="SELECT cat_id FROM categoria WHERE cat_id_padre='$cat_padre' and cat_activar='1' ORDER BY cat_id asc";
		$rs =$fmt->query->consulta($consulta);
		$num_cat=$fmt->query->num_registros($rs);
		if($num_cat>0){
			for($j=0;$j<$num_cat;$j++){
				$row=$fmt->query->obt_fila($rs);
				$cat_hijos[$j]=$row["cat_id"];
			}
		}
		$sql="select not_rel_cat_id from noticia_rel where not_rel_not_id=$id_not and not_rel_cat_id not in ($cat_padre)";
		$rs =$fmt->query->consulta($sql);
		$num_cat=$fmt->query->num_registros($rs);
		if($num_cat>0){
			for($j=0;$j<$num_cat;$j++){
				$row=$fmt->query->obt_fila($rs);
				if(in_array($row["not_rel_cat_id"], $cat_hijos))
					$cat_hi=$row["not_rel_cat_id"];
			}
		}

	}
	return $cat_hi;
}
if(isset($_GET["cn"])){
	$cn=$_GET["cn"];
}
else{
	$cn=32;
	$nombre_cat="Portada";
}

$consulta ="SELECT not_id, not_titulo, not_ruta_amigable, not_resumen, not_imagen, not_fecha
            FROM noticia, noticia_rel
            WHERE not_rel_cat_id='$cn' and not_id=not_rel_not_id and not_activar='1'
            ORDER BY not_fecha desc";

$rs =$this->fmt->query->consulta($consulta);
$num=$this->fmt->query->num_registros($rs);

if($num>0){
	for($i=0;$i<$num;$i++){
		$fila=$this->fmt->query->obt_fila($rs);
		$id_cat_hijo=traer_cat_hijos($fmt,$cn,$fila["not_id"]);
		$nombre_cat=$fmt->categoria->nombre_categoria($id_cat_hijo);
		$imagen_cat=$fmt->categoria->cat_imagen($id_cat_hijo);
		if ($id_cat_hijo!=0){
			$ruta_cat = $fmt->categoria->traer_ruta_amigable_padre($id_cat_hijo);
			$ruta_noticia = _RUTA_WEB_temp.$ruta_cat."/".$fila["not_ruta_amigable"].".html";
			$fecha=$fila["not_fecha"];
			$hoy=date("Y-m-d H:i:s");
			$restante=$fmt->class_modulo->tiempo_restante($fecha,$hoy);

			$fecha_literal=$fmt->class_modulo->traer_fecha_literal($fecha);
			$imagen=_RUTA_WEB.$fila['not_imagen'];

			$nombre_archivo = $fmt->archivos->convertir_nombre_thumb($imagen);

			$file_headers = @get_headers($nombre_archivo);
			if($file_headers[0] != 'HTTP/1.1 404 Not Found')
				$imagen=$nombre_archivo;


?>
<div class="box-m-noticias">
  <div class="box-m-nota">
    <div class="header">
      <div class="box-cat">
        <img class="img-cat" alt="<?php echo $nombre_cat; ?>" src="<?php echo _RUTA_WEB.$imagen_cat; ?>">
      </div>
      <label><?php echo $nombre_cat; ?></label>
      <span>compartió una noticia</span>
      <div class="box-m-fecha">
       <?php echo $restante; ?>
      </div>
    </div>
    <div class="box-m-cn">
    	<a href="<?php echo $ruta_noticia; ?>">
	      <img class="img-cat img-responsive" alt="" src="<?php echo $imagen; ?>">
    	</a>
      <div class="box-m-n">
        <label><a href="<?php echo $ruta_noticia; ?>"><?php echo $fila["not_titulo"]; ?></a></label>
        <span class="box-m-f"><?php echo $fecha_literal; ?></span>
        <span class="box-m-rs">
          <?php echo $fila["not_resumen"]; ?>
        </span>
        <a href="<?php echo $ruta_noticia; ?>">Leer más</a>
      </div>
    </div>
  </div>
	<div class="box-m-valor">
		<?php
			require_once(_RUTA_HOST."modulos/noticias/valor.pub.php");
		?>
	</div>
	<div class="box-m-comentarios" id="cm-<?php echo $fila["not_id"]; $not_id=$fila["not_id"]; ?>">
		<div class="box-m-cm">
			<?php
				require_once(_RUTA_HOST."modulos/noticias/comentarios.pub.php");
			?>
		</div>
		<div class="box-m-user-cm">
			<div class="box-m-user">
				<img class="img-user" alt="" src="<? echo $usu_imagen; ?>">
			</div>
			<textarea class="input-cm"   placeholder="Escribe un comentario..." ></textarea>
			<i class="icn-bubble"></i>
			<div class="prog"></div>
		</div>
	</div>
</div>
<script>
$('#cm-<?php echo  $fila["not_id"]; ?> .input-cm').keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			var cm = $(this).val();
			var id = <?php echo  $fila["not_id"]; ?>;
			var id_usu = <?php echo $id_usu; ?>;
			var pd= '0';
		 if(keycode == '13'){
				//alert('Se ha presionado Enter!' + id );
				$(this).val('');
				$("#cm-<?php echo  $fila["not_id"]; ?> .box-m-cm").addClass('on');

				$.ajax({
					url:"<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-comentarios.php",
					type:"post",
					data:{ inputId:id , inputUsuario:id_usu, inputComentario:cm, inputPadre:pd },
					success: function(msg){
						$("#cm-<?php echo  $fila["not_id"]; ?> .box-m-cm").append(msg);
					}
				});

		 }
		 if (keycode == '13') {
			 return false;
		 }
});
</script>
<?php
		}
	}
}
?>
<script>
setTextareaHeight($('textarea'));
function setTextareaHeight(textareas) {
	textareas.each(function () {
			var textarea = $(this);

			if ( !textarea.hasClass('autoHeightDone') ) {
					textarea.addClass('autoHeightDone');

					var extraHeight = parseInt(textarea.css('padding-top')) + parseInt(textarea.css('padding-bottom')), // to set total height - padding size
							h = textarea[0].scrollHeight - extraHeight;

					// init height
					textarea.height('auto').height(h);

					textarea.bind('keyup', function() {

							textarea.removeAttr('style'); // no funciona el height auto

							h = textarea.get(0).scrollHeight - extraHeight;

							textarea.height(h+'px'); // set new height
					});
			}
	})
}
</script>
