<?php
header("Content-Type: text/html;charset=utf-8");

class CONTENIDOS{
	var $fmt;
	var $id_mod;
	function CONTENIDOS($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}
/************** Busqueda ***************/

	function busqueda(){
		$this->fmt->form->head_busqueda_simple('Nuevo Contenido','contenidos',$this->id_mod,''); //$nom,$archivo,$id_mod,$botones
		$this->fmt->form->head_table('table_id');
		$this->fmt->form->thead_table('#:Titulo:Modificado:Creado por:Categorías:Estado:Acciones');
		$this->fmt->form->tbody_table_open();

	    $sql="select conte_id, conte_titulo, conte_fecha, conte_activar, conte_id_usuario from contenidos ORDER BY conte_id desc";
		$rs =$this->fmt->query->consulta($sql);
		$num=$this->fmt->query->num_registros($rs);
		if($num>0){
			for($i=0;$i<$num;$i++){
				$fila=$this->fmt->query->obt_fila($rs);

				?>
			  	<tr>
			  		<th class=""><?php echo $fila["conte_id"]; ?></th>
			  		<td class=""><strong><?php echo $fila["conte_titulo"];?></strong></td>
			  		<td class=""><?php echo $fila["conte_fecha"]; ?></td>
			     	<td class=""><?php echo $this->fmt->usuario->nombre_usuario($fila["conte_id_usuario"]);?></td>
			     	<td class=""><?php echo $this->fmt->categoria->traer_rel_cat_nombres($fila["conte_id"],'contenidos_categoria','conte_cat_cat_id','conte_cat_conte_id'); ?></td>
			     	<td class="">
			      	<?php
			      	echo $this->fmt->class_modulo->estado_publicacion($fila["conte_activar"],"modulos/contenidos/contenidos.adm.php", $this->id_mod,$aux,$fila["conte_id"] );
			      	?>
			      <td class="td-user col-xl-offset-2 acciones">
				     <?php
					 $url_editar= "contenidos.adm.php?tarea=form_editar&id=".$fila["conte_id"]."&id_mod=".$this->id_mod;
				$this->fmt->form->botones_acciones("btn-editar-modulo","btn btn-accion btn-editar",$url_editar,"Editar","icn-pencil","editar",'editar',$fila["conte_id"]); //$id,$class,$href,$title,$icono,$tarea,$nom,$ide

				$this->fmt->form->botones_acciones("btn-eliminar","btn btn-eliminar btn-accion","","Eliminar -".$fila["conte_id"],"icn-trash","eliminar",$fila["conte_titulo"],$fila["conte_id"]);
				     ?>
			      </td>
			  	</tr>
			  	<?php
			  		}
			  	}
		$this->fmt->form->tbody_table_close();
		$this->fmt->form->footer_table();
		$this->fmt->class_modulo->script_form("modulos/contenidos/contenidos.adm.php",$this->id_mod,"desc");
		$this->fmt->form->footer_page();

	} // Fin busqueda

/************** Formulario form_nuevo ***************/

	function form_nuevo(){
		$this->fmt->form->head_nuevo('
		Nuevo Contenido','contenidos',$this->id_mod,'','form_nuevo','col-xs-offset-2 head-contenidos'); //$nom,$archivo,$id_mod,$botones,$id_form,$class
		$this->fmt->form->input_form("<span class='obligatorio'>*</span> Titulo:","inputTitulo","","","input-lg","","");
		$this->fmt->form->input_form("Nombre Amigable:","inputNombreAmigable","","","","","","");
		$this->fmt->form->input_form("Subtitulo:","inputSubtitulo","","","input-lg","","");

		$this->fmt->form->textarea_form('Cuerpo:','inputCuerpo','','','summernote','textarea-cuerpo','',''); //label,$id,$placeholder,$valor,$class,$class_div,$rows,$mensaje
		$this->fmt->form->input_form('Tags:','inputTags','',"",'');
		$this->fmt->form->input_form('Imagen:','inputImagen','',"",'');
		?>
		<div class="form-group">
			<label>Imagen:</label>
			<div class="panel panel-default" >
				<div class="panel-body">
        <?php
        $this->fmt->form->file_form_nuevo_save_thumb('Cargar Archivo (max 8MB)','','form_nuevo','form-file','','box-file-form','archivos/contenidos','476x268');  //$nom,$ruta,$id_form,$class,$class_div,$id_div
        ?>
        </div>
      </div>
    </div>
	<?php
		$this->fmt->form->agregar_documentos("Documentos:","inputDoc","","","","","",""); //$label,$id,$valor,$class,$class_div,$mensaje,$from,$id_item
		$this->fmt->form->categoria_form('Categoria','inputCat',"0","","",""); //$label,$id,$cat_raiz,$cat_valor,$class,$class_div
		$fecha=$this->fmt->class_modulo->fecha_hoy('America/La_Paz');
		$this->fmt->form->input_form('Fecha:','inputFecha','',$fecha,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$usuario = $this->fmt->sesion->get_variable('usu_id');

		$usuario_n =  $this->fmt->usuario->nombre_usuario( $usuario );
		$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$this->fmt->form->botones_nuevo();
		?>
		<script>
			$(document).ready(function () {
					var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-ruta-amigable.php";
					$("#inputTitulo").keyup(function () {
							var value = $(this).val();
							//$("#inputNombreAmigable").val();
							$.ajax({
									url: ruta,
									type: "POST",
									data: { inputRuta:value },
									success: function(datos){
										$("#inputNombreAmigable").val(datos);
									}
							});
					});
			});
		</script>
		<?php
		$this->fmt->class_modulo->script_form("modulos/contenidos/contenidos.adm.php",$this->id_mod);
		$this->fmt->form->footer_page();
	} //Fin function form modificar


	function ingresar(){
		if ($_POST["btn-accion"]=="activar"){
			$activar=1;
		}
		if ($_POST["btn-accion"]=="guardar"){
			$activar=0;
		}
		if($_POST["inputTitulo"]!=""){
			if(isset($_POST["inputUrl"]))
				$imagen=$_POST["inputUrl"];
			else
				$imagen=$_POST['inputImagen'];

			$ingresar ="conte_titulo, conte_ruta_amigable, conte_subtitulo, conte_cuerpo, conte_foto, conte_fecha, conte_id_usuario, conte_tag, conte_id_dominio, conte_activar";
			$valores  ="'".$_POST['inputTitulo']."','".
						$_POST['inputNombreAmigable']."','".
						$_POST['inputSubtitulo']."','".
						$_POST['inputCuerpo']."','".
						$imagen."','".
						$_POST['inputFecha']."','".
						$_POST['inputUsuario']."','".
						$_POST['inputTags']."','".
						$_POST['inputDominio']."','".
						$activar."'";
			$sql="insert into contenidos (".$ingresar.") values (".$valores.")";
			$this->fmt->query->consulta($sql);

			$sql="select max(conte_id) as id from contenidos";
			$rs= $this->fmt->query->consulta($sql);
			$fila = $this->fmt->query->obt_fila($rs);
			$id = $fila ["id"];

			$ingresar1 = "conte_cat_conte_id,conte_cat_cat_id";
			$valor_cat=$_POST['inputCat'];
			$num_cat=count( $valor_cat );

			for ($i=0; $i<$num_cat;$i++){
				$valores1 = "'".$id."','".$valor_cat[$i]."'";
				$sql1="insert into contenidos_categoria  (".$ingresar1.") values (".$valores1.")";
				$this->fmt->query->consulta($sql1);
			}

			$ingresar1 = "conte_doc_conte_id,conte_doc_doc_id";
			$valor_doc= $_POST['inputDoc'];
			$num=count( $valor_doc );
			for ($i=0; $i<$num;$i++){
				$valores1 = "'".$id."','".$valor_doc[$i]."'";
				$sql1="insert into contenidos_documento  (".$ingresar1.") values (".$valores1.")";
				$this->fmt->query->consulta($sql1);
			}

		}
		header("location: contenidos.adm.php?id_mod=".$this->id_mod);

	}
	function form_editar(){
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];
		$consulta= "SELECT * FROM contenidos WHERE conte_id='".$id."'";
		$rs =$this->fmt->query->consulta($consulta);
		$fila=$this->fmt->query->obt_fila($rs);
		$this->fmt->form->head_editar('Editar Contenido','contenidos',$this->id_mod,'','form_editar');
		$this->fmt->form->input_form("<span class='obligatorio'>*</span> Titulo:","inputTitulo","",$fila["conte_titulo"],"input-lg","","");
		if (!empty($fila['conte_ruta_amigable'])){
			$valor_ra = $fila['conte_ruta_amigable'];
		}else{
			$valor_ra = $this->fmt->get->convertir_url_amigable($fila['conte_titulo']);
		}
		$this->fmt->form->input_form("Nombre Amigable:","inputNombreAmigable","",$valor_ra,"","","","");
		$this->fmt->form->input_hidden_form("inputId",$id);
		$this->fmt->form->input_form("Subtitulo:","inputSubtitulo","",$fila["conte_subtitulo"],"input-lg","","");

		$this->fmt->form->textarea_form('Cuerpo:','inputCuerpo','',$fila["conte_cuerpo"],'summernote','textarea-cuerpo','',''); //label,$id,$placeholder,$valor,$class,$class_div,$rows,$mensaje
		$this->fmt->form->input_form('Tags:','inputTags',"",$fila["conte_tag"],'');
		if($fila['conte_foto']!=""){
			$imagen=_RUTA_WEB.$fila['conte_foto'];
			$nombre_archivo = $this->fmt->archivos->convertir_nombre_thumb($imagen);
			if(file_exists($nombre_archivo))
				$imagen=$nombre_archivo;


			echo "<img width='200px' src='".$imagen."'>";
		}
		$this->fmt->form->input_form('Imagen:','inputImagen',"",$imagen,'');
		?>
		<div class="form-group">
			<label>Imagen:</label>
			<div class="panel panel-default" >
				<div class="panel-body">
        <?php
        $this->fmt->form->file_form_nuevo_save_thumb('Cargar Archivo (max 8MB)','','form_nuevo','form-file','','box-file-form','archivos/contenidos','476x268');  //$nom,$ruta,$id_form,$class,$class_div,$id_div
        ?>
        </div>
      </div>
    </div>
	<?php
		$this->fmt->form->agregar_documentos("Documentos:","inputDoc",$fila["conte_id"],"","","","contenidos_documento","conte_doc_conte_id","conte_doc_doc_id"); //$label,$id,$valor,$class,$class_div,$mensaje,$from,$id_item
		$cats_id = $this->fmt->categoria->traer_rel_cat_id($fila["conte_id"],'contenidos_categoria','conte_cat_cat_id','conte_cat_conte_id');
		$this->fmt->form->categoria_form('Categoria','inputCat',"0",$cats_id,"",""); //$label,$id,$cat_raiz,$cat_valor,$class,$class_div
		$fecha=$this->fmt->class_modulo->fecha_hoy('America/La_Paz');
		$this->fmt->form->input_form('Fecha:','inputFecha','',$fila["conte_fecha"],'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$usuario = $this->fmt->sesion->get_variable('usu_id');

		$usuario_n =  $this->fmt->usuario->nombre_usuario( $usuario );
		$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$this->fmt->form->radio_activar_form($fila['conte_activar']);
		$this->fmt->form->botones_editar($id,$fila['inputTitulo'],'Contenido');
		?>
		<script>
			$(document).ready(function () {
					var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-ruta-amigable.php";
					$("#inputTitulo").keyup(function () {
							var value = $(this).val();
							//$("#inputNombreAmigable").val();
							$.ajax({
									url: ruta,
									type: "POST",
									data: { inputRuta:value },
									success: function(datos){
										$("#inputNombreAmigable").val(datos);
									}
							});
					});
			});
		</script>
		<?php
		$this->fmt->class_modulo->script_form("modulos/contenidos/contenidos.adm.php",$this->id_mod);
		$this->fmt->form->footer_page();
	}
	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){
			if($_POST["inputTitulo"]!=""){
				if(isset($_POST["inputUrl"]))
					$imagen=$_POST["inputUrl"];
				else
					$imagen=$_POST['inputImagen'];

				$sql="UPDATE contenidos SET
							conte_titulo='".$_POST['inputTitulo']."',
							conte_ruta_amigable ='".$_POST['inputNombreAmigable']."',
							conte_subtitulo ='".$_POST['inputSubtitulo']."',
							conte_cuerpo='".$_POST['inputCuerpo']."',
							conte_foto='".$imagen."',
							conte_fecha='".$_POST['inputFecha']."',
							conte_id_usuario='".$_POST['inputUsuario']."',
							conte_tag='".$_POST['inputTags']."',
							conte_id_dominio='".$_POST['inputDominio']."',
							conte_activar='".$_POST['inputActivar']."'
							WHERE conte_id='".$_POST['inputId']."'";

				$this->fmt->query->consulta($sql);

				$this->fmt->class_modulo->eliminar_fila($_POST['inputId'],"contenidos_categoria","conte_cat_conte_id");  //$valor,$from,$fila

				$ingresar1 = "conte_cat_conte_id,conte_cat_cat_id";
				$valor_cat=$_POST['inputCat'];
				$num_cat=count( $valor_cat );

				for ($i=0; $i<$num_cat;$i++){
					$valores1 = "'".$_POST['inputId']."','".$valor_cat[$i]."'";
					$sql1="insert into contenidos_categoria  (".$ingresar1.") values (".$valores1.")";
					$this->fmt->query->consulta($sql1);
				}

				$this->fmt->class_modulo->eliminar_fila($_POST['inputId'],"contenidos_documento","conte_doc_conte_id");

				$ingresar1 = "conte_doc_conte_id,conte_doc_doc_id";
				$valor_doc= $_POST['inputDoc'];
				$num=count( $valor_doc );
				for ($i=0; $i<$num;$i++){
					$valores1 = "'".$_POST['inputId']."','".$valor_doc[$i]."'";
					$sql1="insert into contenidos_documento  (".$ingresar1.") values (".$valores1.")";
					$this->fmt->query->consulta($sql1);
				}
			}
		}
		header("location: contenidos.adm.php?id_mod=".$this->id_mod);
	}
	function eliminar(){
  		$this->fmt->class_modulo->eliminar_get_id("contenidos","conte_");
  		$this->fmt->class_modulo->eliminar_get_id("contenidos_categoria","conte_cat_conte_");
  		$this->fmt->class_modulo->eliminar_get_id("contenidos_documento","conte_doc_conte_");
  		header("location: contenidos.adm.php?id_mod=".$this->id_mod);
  	}

  	function activar(){
	    $this->fmt->class_modulo->activar_get_id("contenidos","conte_");
	    header("location: contenidos.adm.php?id_mod=".$this->id_mod);
  	}
}

?>