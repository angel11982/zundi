<?php
header("Content-Type: text/html;charset=utf-8");

class CONFIG{

	var $fmt;
	var $id_mod;
	var $ruta_modulo;
	var $nombre_modulo;
	var $nombre_tabla;
	var $prefijo_tabla;


	function CONFIG($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
		$this->ruta_modulo="modulos/config/config.adm.php";
		$this->nombre_modulo="config.adm.php";
		$this->nombre_tabla="configuracion";
		$this->prefijo_tabla="conf_";
	}

	function form_editar(){
		$botones .= $this->fmt->class_pagina->crear_btn("contenedores.adm.php","btn btn-link","icn-block-page","Contenedores");  // link, tarea, clase, icono, nombre
		$botones .= $this->fmt->class_pagina->crear_btn("publicaciones.adm.php","btn btn-link","icn-rocket","Publicaciones");  // link, tarea, clase, icono, nombre
		$botones .= $this->fmt->class_pagina->crear_btn("plantillas.adm.php","btn
		btn-link","icn-level-page","Plantillas");  // link, tarea, clase, icono, nombre
		$this->fmt->class_pagina->crear_head( $this->id_mod, $botones); // bd, id modulo, botones
		
		
		$sql="SELECT * FROM ".$this->nombre_tabla;
		$rs=$this->fmt->query->consulta($sql);
		$num=$this->fmt->query->num_registros($rs);
		if($num>0){
			for($i=0;$i<$num;$i++){
				list($fila_nombre_sitio,$fila_imagen,$fila_favicon,$fila_script_head,$fila_script_footer,$fila_ruta_analitica)=$this->fmt->query->obt_fila($rs);
			}
		}
		?>
		<div class="body-modulo  body-config">
			 <form class="form form-modulo" action="<?php echo $this->nombre_modulo; ?>?tarea=modificar"  enctype="multipart/form-data" method="POST" id="form">
				 <div class="col-md-6">
				<?php
					$this->fmt->form->input_form('Nombre del sitio:','inputNombre','',$fila_nombre_sitio,'requerido requerido-texto input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
					$this->fmt->form->input_form('Imagen:','inputImagen','',$fila_imagen,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
					$this->fmt->form->input_form('Favicon:','inputIcono','',$fila_favicon,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
					$this->fmt->form->input_form('Ruta analitica:','inputRutaAnalitica','',$fila_ruta_analitica,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje

				?> 
				</div>
				<div class="col-md-6">
				<?php
					$this->fmt->form->textarea_form('Script head:','inputHead','',$fila_script_head,'','','5','','');
					$this->fmt->form->textarea_form('script footer:','inputFooter','',$fila_script_footer,'','','5','','');	
				?>
					<div class="form-group form-botones clear-both">
						<button type="submit" class="btn-accion-form btn btn-info  btn-actualizar hvr-fade btn-lg color-bg-celecte-c btn-lg " name="btn-accion" id="btn-activar" value="actualizar"><i class="icn-sync" ></i> Actualizar</button>
					</div>	
				</div>
			 </form>
		</div>
		<?php
			
	}
	
	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){

			$filas='conf_nombre_sitio,
					conf_imagen,
					conf_favicon,
					conf_script_head,
					conf_script_footer,
					conf_ruta_analitica';
					
			$valores_post='inputNombre,
							inputImagen,
							inputIcono,
							inputHead,
							inputFooter,
							inputRutaAnalitica';
						
			$this->fmt->class_modulo->actualizar_tabla($this->nombre_tabla,$filas,$valores_post); //$from,$filas,$valores_post
			header("location: ".$this->nombre_modulo."?id_mod=6");
		}
	}

}
?>
