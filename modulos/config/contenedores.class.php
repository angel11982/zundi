<?php
header("Content-Type: text/html;charset=utf-8");

class CONTENEDORES{

	var $fmt;
	var $id_mod;
	var $ruta_modulo;
	var $nombre_modulo;
	var $nombre_tabla;
	var $prefijo_tabla;

	function CONTENEDORES($fmt){
		$this->fmt = $fmt;
		$this->ruta_modulo="modulos/config/contenedores.adm.php";
		$this->nombre_modulo="contenedores.adm.php";
		$this->nombre_tabla="contenedor";
		$this->prefijo_tabla="cont_";
	}
	
	function busqueda(){
		$botones = $this->fmt->class_pagina->crear_btn("config.adm.php?id_mod=6","btn btn-link","icn-conf","Configuración Site");
		
	    $this->fmt->class_pagina->crear_head_mod("icn-block-page","Contenedores",$botones ); // $icon, $nom,$botones
	    ?>
	    <div class="body-modulo">
			<?php
				$this->fmt->categoria->arbol_editable_mod('contenedor','cont_','cont_id_padre=0','modulos/config/contenedores.adm.php?tarea=form_nuevo','box-contenedores'); //$from,$prefijo,$where,$url_modulo,$class_div
			?>
		</div>
		<script>
			$(".btn-activar-i").click(function(e){
				var cat = $( this ).attr("cat");
				var estado = $( this ).attr("estado");
				url="contenedores.adm.php?tarea=activar&id="+cat+"&estado="+estado;
				//alert(url);
				window.location=(url);
			});
			$(".btn-editar-i").click(function(e){
				var cat = $( this ).attr("cat");
				url="contenedores.adm.php?tarea=form_editar&id="+cat;
				//alert(url);
				window.location=(url);
			});
			$(".btn-nuevo-i").click(function(e){
				var cat = $( this ).attr("cat");
				url="contenedores.adm.php?tarea=form_nuevo&id_padre="+cat;
				//alert(url);
				window.location=(url);
			});
			
    	</script>

		<?php
		$this->fmt->class_modulo->script_form($this->ruta_modulo,"");
	    echo $this->fmt->form->footer_page();
	}
	
	function form_nuevo(){
		$this->fmt->get->validar_get ( $_GET['id_padre'] );
		$id_padre=$_GET['id_padre'];
		
		$botones .= $this->fmt->class_pagina->crear_btn($this->nombre_modulo."?tarea=busqueda","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_mod( "", "Nuevo Contenedor",'',$botones,'col-xs-6 col-xs-offset-4');
		?>
	    <div class="body-modulo col-xs-6 col-xs-offset-3">
	      <form class="form form-modulo" action="<?php echo $this->nombre_modulo; ?>?tarea=ingresar"  enctype="multipart/form-data" method="POST" id="form_nuevo">
	        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
	        <?php
	        $this->fmt->form->input_form('Nombre del contenedor:','inputNombre','','','requerido requerido-texto input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje

	        //$this->fmt->form->textarea_form('Descripción:','inputDescripcion','','','','','3','','');
	        $this->fmt->form->input_form('Clase:','inputClase','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
	        $this->fmt->form->input_form('Css:','inputCss','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
	        
	        $this->fmt->form->textarea_form('Codigos:','inputCodigos','','','','','3','','');
	        $this->fmt->form->input_form('Orden:','inputOrden','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
	        if (!empty($id_padre)){
		        $a=$id_padre;
	        }else{
		        $a="";
	        }
	        $this->fmt->form->select_form('Contenedor padre:','inputPadre','cont_','contenedor',$a,'',''); //$label,$id,$prefijo,$from,$id_select,$id_disabled,$class_div

			
	       	$this->fmt->form->botones_nuevo();
	        ?>
	      </form>
		    </div>
		<?php
	    $this->fmt->class_modulo->script_form($this->ruta_modulo,"");
	    $this->fmt->form->footer_page();

	}
	
	function form_editar(){
		$botones .= $this->fmt->class_pagina->crear_btn($this->nombre_modulo."?tarea=busqueda","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_mod( "", "Editar Contenedor",'',$botones,'col-xs-6 col-xs-offset-4');
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];
		
		$sql="SELECT * FROM ".$this->nombre_tabla." where ".$this->prefijo_tabla."id='".$id."'";
		$rs=$this->fmt->query->consulta($sql);
		$num=$this->fmt->query->num_registros($rs);
		if($num>0){
			for($i=0;$i<$num;$i++){
				list($fila_id,$fila_nombre,$fila_clase,$fila_css,$fila_codigos,$fila_id_padre,$fila_orden,$fila_activar)=$this->fmt->query->obt_fila($rs);
			}
		}
		?>
	    <div class="body-modulo col-xs-6 col-xs-offset-3">
	      <form class="form form-modulo" action="<?php echo $this->nombre_modulo; ?>?tarea=modificar"  enctype="multipart/form-data" method="POST" id="form_editar">
	        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
	        <?php
	        $this->fmt->form->input_form('Nombre del contenedor:','inputNombre','',$fila_nombre,'requerido requerido-texto input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
			$this->fmt->form->input_hidden_form("inputId",$fila_id);	  	       
			
			$this->fmt->form->input_form('Clase:','inputClase','',$fila_clase,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
	        $this->fmt->form->input_form('Css:','inputCss','',$fila_css,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
	        
	        $this->fmt->form->textarea_form('Codigos:','inputCodigos','',$fila_codigos,'','','3','','');
	        $this->fmt->form->input_form('Orden:','inputOrden','',$fila_orden,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
	        
	        $this->fmt->form->select_form('Contenedor padre:','inputPadre','cont_','contenedor',$fila_id_padre,'',''); //$label,$id,$prefijo,$from,$id_select,$id_disabled,$class_div

	        
			$this->fmt->form->radio_activar_form($fila_activar);
	       	$this->fmt->form->botones_editar($fila_id,$fila_nombre,'contenedor','eliminar'); //$fila_id,$fila_nombre,$nombre,$tarea_eliminar
	        ?>
	      </form>
		    </div>
		<?php
	    $this->fmt->class_modulo->script_form($this->ruta_modulo,"");
	    $this->fmt->form->footer_page();

	}
	
	function ingresar(){
	    if ($_POST["btn-accion"]=="activar"){
	      $activar=1;
	    }
	    if ($_POST["btn-accion"]=="guardar"){
	      $activar=0;
	    }
	    $ingresar ="cont_nombre,
					cont_clase,
					cont_css,
					cont_codigos,
					cont_id_padre,
					cont_orden,
					cont_activar";
					
	    $valores_post  ="inputNombre,
						inputClase,
						inputCss,
						inputCodigos,
						inputPadre,
						inputOrden,
						inputActivar=".$activar;
	
	    $this->fmt->class_modulo->ingresar_tabla('contenedor',$ingresar,$valores_post);
			//$from,$filas,$valores_post
			
		header("location: ".$this->nombre_modulo."?tarea=busqueda");
	}
	
	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){

			$filas='cont_id,
					cont_nombre,
					cont_clase,
					cont_css,
					cont_codigos,
					cont_id_padre,
					cont_orden,
					cont_activar';
					
			$valores_post='inputId,inputNombre,
						inputClase,
						inputCss,
						inputCodigos,
						inputPadre,
						inputOrden,
						inputActivar';
						
			$this->fmt->class_modulo->actualizar_tabla($this->nombre_tabla,$filas,$valores_post); //$from,$filas,$valores_post
			header("location: ".$this->nombre_modulo."?tarea=busqueda");
		}
	}

	
	function activar(){
$this->fmt->class_modulo->activar_get_id($this->nombre_tabla,$this->prefijo_tabla);
		header("location: ".$this->nombre_modulo."?tarea=busqueda");
	}
	
	function eliminar(){
		$this->fmt->class_modulo->eliminar_get_id($this->nombre_tabla,$this->prefijo_tabla);
		
		header("location: ".$this->nombre_modulo."?tarea=busqueda");
    }

	
}