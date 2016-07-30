<?php
header("Content-Type: text/html;charset=utf-8");

class NOTICIAS{

	var $fmt;
	var $id_mod;

	function NOTICIAS($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

	function busqueda(){
		$this->fmt->form->head_busqueda_simple('Nueva Noticia','noticias',$this->id_mod,''); //$nom,$archivo,$id_mod,$botones
		$this->fmt->form->head_table('table_id');
		$this->fmt->form->thead_table('Titulo:Autor:Categorías:Etiquetas:Fecha:Estado:Acciones');
		$this->fmt->form->tbody_table_open();
		$sql="SELECT * FROM noticia ORDER BY not_id asc";
		$rs =$this->fmt->query->consulta($sql);
		$num=$this->fmt->query->num_registros($rs);
		if($num>0){
			for($i=0;$i<$num;$i++){
				$fila=$this->fmt->query->obt_fila($rs);
				echo "<tr>";
				echo '<td class=""><strong>'.$fila["not_titulo"].'</strong></td>';
				echo '<td class="">'.$this->fmt->usuario->nombre_usuario( $fila["not_usuario"]).'</td>';
				echo '<td class="">';
					$this->fmt->categoria->traer_rel_cat_nombres($fila["not_id"],'noticia_rel','not_rel_cat_id','not_rel_not_id'); //$fila_id,$from,$prefijo_cat,$prefijo_rel

				echo '</td>';
				echo '<td class="">'.$fila["not_tags"].'</td>';
				echo '<td class="">'.$fila["not_fecha"].'</td>';
				echo '<td class="">';
					$this->fmt->class_modulo->estado_publicacion($fila["not_activar"],"modulos/noticias/noticias.adm.php", $this->id_mod,$aux,$fila["not_id"] );
				echo '</td>';

				echo '<td class="td-user col-xl-offset-2 acciones">';
				$url_editar= "noticias.adm.php?tarea=form_editar&id=".$fila["not_id"]."&id_mod=".$this->id_mod;
				$this->fmt->form->botones_acciones("btn-editar-modulo","btn btn-accion btn-editar",$url_editar,"Editar","icn-pencil","editar",'editar',$fila["not_id"]); //$id,$class,$href,$title,$icono,$tarea,$nom,$ide

				$this->fmt->form->botones_acciones("btn-eliminar","btn btn-eliminar btn-accion","","Eliminar -".$fila["not_id"],"icn-trash","eliminar",$fila["not_titulo"],$fila["not_id"]); //$id,$class,$href,$title,$icono,$tarea,$nom,$ide

				echo '</td>';
				echo "</tr>";
			}
		}
		$this->fmt->form->tbody_table_close();
		$this->fmt->form->footer_table();
		$this->fmt->class_modulo->script_form("modulos/noticias/noticias.adm.php",$this->id_mod);
		$this->fmt->form->footer_page();
	}

	function form_nuevo(){
		$this->fmt->form->head_nuevo('
		Nueva Noticia','noticias',$this->id_mod,'','form_nuevo','col-xs-offset-2 head-noticias'); //$nom,$archivo,$id_mod,$botones,$id_form,$class
		$this->fmt->form->input_form("<span class='obligatorio'>*</span> Titulo:","inputTitulo","","","input-lg","","");
		$this->fmt->form->textarea_form('Resumen:','inputResumen','','','','','3','','');
		$this->fmt->form->textarea_form('Cuerpo:','inputCuerpo','','','summernote','textarea-cuerpo','',''); //label,$id,$placeholder,$valor,$class,$class_div,$rows,$mensaje
		$this->fmt->form->input_form('Tags:','inputTags','',"",'');
		$this->fmt->form->input_form('Imagen:','inputImagen','',"",'');
		$this->fmt->form->categoria_form('Categoria','inputCat',"0","","",""); //$label,$id,$cat_raiz,$cat_valor,$class,$class_div
		$fecha=$this->fmt->class_modulo->fecha_hoy('America/La_Paz');
		$this->fmt->form->input_form('Fecha:','inputFecha','',$fecha,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$usuario = $this->fmt->sesion->get_variable('usu_id');
		$usuario_n =  $this->fmt->usuario->nombre_usuario( $usuario );
		$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$this->fmt->form->input_form('Orden:','inputOrden','','0','','','');
		$this->fmt->form->botones_nuevo();
		$this->fmt->class_modulo->script_form("modulos/noticias/noticias.adm.php",$this->id_mod);
		$this->fmt->form->footer_page();
	}

	function form_editar(){
		$fila= $this->fmt->form->form_head_form_editar('Editar Noticia','noticia','not_', $this->id_mod,'col-xs-offset-2 head-noticias','noticias');//$nom,$from,$prefijo,$id_mod,$class,$archivo

		$this->fmt->form->input_form("<span class='obligatorio'>*</span> Titulo:","inputTitulo","",$fila['not_titulo'],"input-lg","",""); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_hidden_form("inputId",$fila['not_id']);
		$this->fmt->form->textarea_form('Resumen:','inputResumen','',$fila['not_resumen'],'','','3','','');
		$this->fmt->form->textarea_form('Cuerpo:','inputCuerpo','',$fila['not_cuerpo'],'summernote','textarea-cuerpo','',''); //label,$id,$placeholder,$valor,$class,$class_div,$rows,$mensaje
		$this->fmt->form->input_hidden_form("inputRutaamigable",$fila['not_ruta_amigable']);
		$this->fmt->form->input_form('Tags:','inputTags','',$fila['not_tags'],'');
		$this->fmt->form->input_form('Imagen:','inputImagen','',$fila['not_imagen'],'');

		$cats_id = $this->fmt->categoria->traer_rel_cat_id($fila["not_id"],'noticia_rel','not_rel_cat_id','not_rel_not_id'); //$fila_id,$from,$prefijo_cat,$prefijo_rel
		$this->fmt->form->categoria_form('Categoria','inputCat',"0",$cats_id,"","");

		$fecha=$this->fmt->class_modulo->fecha_hoy('America/La_Paz');
		$this->fmt->form->input_form('Fecha:','inputFecha','',$fecha,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$usuario = $this->fmt->sesion->get_variable('usu_id');
		$usuario_n =  $this->fmt->usuario->nombre_usuario( $usuario );
		$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$this->fmt->form->input_form('Orden:','inputOrden','','0','','','');
		$this->fmt->form->radio_activar_form($fila['not_activar']);
		$this->fmt->form->botones_editar($fila['not_id'],$fila['not_nombre'],'Noticia');//$fila_id,$fila_nombre,$nombre
		$this->fmt->class_modulo->script_form("modulos/noticias/noticias.adm.php",$this->id_mod);
		$this->fmt->form->footer_page();
	}

	function ingresar(){
		if ($_POST["btn-accion"]=="activar"){
			$activar=1;
		}
		if ($_POST["btn-accion"]=="guardar"){
			$activar=0;
		}

		$ingresar ="not_titulo,
                not_ruta_amigable,
                not_resumen,
                not_cuerpo,
                not_imagen,
                not_tags,
                not_fecha,
                not_usuario,
                not_activar";
		$valores  ="'".$_POST['inputTitulo']."','".
					$this->fmt->get->convertir_url_amigable($_POST['inputTitulo'])."','".
					$_POST['inputResumen']."','".
					$_POST['inputCuerpo']."','".
					$_POST['inputImagen']."','".
					$_POST['inputTags']."','".
					$_POST['inputFecha']."','".
					$_POST['inputUsuario']."','".
					$activar."'";

		$sql="insert into noticia (".$ingresar.") values (".$valores.")";
		$this->fmt->query->consulta($sql);

		$sql="select max(not_id) as id from noticia";
		$rs= $this->fmt->query->consulta($sql);
		$fila = $this->fmt->query->obt_fila($rs);
	  	$id = $fila ["id"];
		$ingresar1 ="not_rel_not_id, not_rel_cat_id,not_rel_orden";
		$valor_cat= $_POST['inputCat'];
		$num=count( $valor_cat );
		for ($i=0; $i<$num;$i++){
			$valores1 = "'".$id."','".$valor_cat[$i]."','".$_POST['inputOrden']."'";
			$sql1="insert into noticia_rel (".$ingresar1.") values (".$valores1.")";
			$this->fmt->query->consulta($sql1);
		}

		header("location: noticias.adm.php?id_mod=".$this->id_mod);
	}

	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){

			$sql="UPDATE noticia SET
						not_titulo='".$_POST['inputTitulo']."',
						not_ruta_amigable ='".$_POST['inputRutaamigable']."',
						not_tags ='".$_POST['inputTags']."',
						not_resumen ='".$_POST['inputResumen']."',
						not_cuerpo ='".$_POST['inputCuerpo']."',
						not_imagen ='".$_POST['inputImagen']."',
						not_fecha='".$_POST['inputFecha']."',
						not_usuario='".$_POST['inputUsuario']."',
						not_activar='".$_POST['inputActivar']."'
						WHERE not_id='".$_POST['inputId']."'";

			$this->fmt->query->consulta($sql);

			$this->fmt->class_modulo->eliminar_fila($_POST['inputId'],"noticia_rel","not_rel_not_id");  //$valor,$from,$fila

			$ingresar1 ="not_rel_not_id,not_rel_cat_id,not_rel_orden";
			$valor_cat= $_POST['inputCat'];
			$num=count( $valor_cat );
			for ($i=0; $i<$num;$i++){
				$valores1 = "'".$_POST['inputId']."','".$valor_cat[$i]."','".$_POST['inputOrden']."'";
				echo $sql1="insert into noticia_rel (".$ingresar1.") values (".$valores1.")";
				$this->fmt->query->consulta($sql1);
			}


		}
			header("location: noticias.adm.php?id_mod=".$this->id_mod);
	}


	function eliminar(){
  		$this->fmt->class_modulo->eliminar_get_id("noticia","not_");
  		$this->fmt->class_modulo->eliminar_get_id("noticia_rel","not_rel_not_");
  		header("location: noticias.adm.php?id_mod=".$this->id_mod);
  	}

  	function activar(){
	    $this->fmt->class_modulo->activar_get_id("noticia","not_");
	    header("location: noticias.adm.php?id_mod=".$this->id_mod);
  	}


}
?>
