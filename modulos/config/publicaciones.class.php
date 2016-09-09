<?php
header("Content-Type: text/html;charset=utf-8");

class PUBLICACIONES{

	var $fmt;

	function PUBLICACIONES($fmt){
		$this->fmt = $fmt;
	}
  function busqueda(){
    $botones .= $this->fmt->class_pagina->crear_btn("config.adm.php?id_mod=6","btn btn-link","icn-conf","Configuración Sitio");  // link, tarea, clase, icono, nombre
    $botones .= $this->fmt->class_pagina->crear_btn("contendedores.adm.php","btn btn-link","icn-block-page","Contenedores");  // link, tarea, clase, icono, nombre
		$botones .= $this->fmt->class_pagina->crear_btn("plantilla.adm.php","btn
		btn-link","icn-level-page","Plantillas");  // link, tarea, clase, icono, nombre
    $botones .= $this->fmt->class_pagina->crear_btn("publicaciones.adm.php?tarea=form_nuevo","btn btn-primary","icn-plus","Nueva Publicación");  // link, tarea, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_mod( "icn-rocket color-text-naranja-a","Publicaciones", $botones); // bd, id modulo, botones
		?>
		<div class="body-modulo">
			<div class="table-responsive">
				<table class="table table-hover" id="table_id">
				  <thead>
				    <tr>
					  <th class="col-id">ID</th>
				      <th  >Nombre Publicación</th>
				      <th>Ruta</th>
				      <th>Publicación</th>
				      <th class="col-xl-offset-2">Acciones</th>
				    </tr>
				  </thead>
				  <tbody>
						<?php
							$sql="select pub_id, pub_nombre, pub_archivo, pub_activar from publicacion	ORDER BY pub_id desc";
							$rs =$this->fmt->query->consulta($sql);
							$num=$this->fmt->query->num_registros($rs);
							if($num>0){
						  for($i=0;$i<$num;$i++){
						    list($fila_id,$fila_nombre,$fila_url,$fila_activar)=$this->fmt->query->obt_fila($rs);
						  ?>
						  <tr>
							<td ><?php echo $fila_id; ?></td>
						    <td class="col-nombre" ><?php echo $fila_nombre; ?></td>
						    <td class=""><?php echo $fila_url; ?></td>
						    <td >
						      <?php
						        $this->fmt->class_modulo->estado_publicacion($fila_activar,"publicaciones/config/publicaciones.adm.php", $this->id_mod,$aux, $fila_id ); // query, id item, ruta, id modulo, aux disabled
									?>
						    </td>
						    <td class="col-xl-offset-2 acciones">

						      <a  id="btn-editar-modulo" class="btn btn-accion btn-editar <?php echo $aux; ?>" href="publicaciones.adm.php?tarea=form_editar&id=<? echo $fila_id; ?>&id_mod=<? echo $this->id_mod; ?>" title="Editar <? echo $fila_id."-".$fila_url; ?>" ><i class="icn-pencil"></i></a>
									<a  title="eliminar <? echo $fila_id; ?>" type="button" idEliminar="<? echo $fila_id; ?>" nombreEliminar="<? echo $fila_nombre; ?>" class="btn btn-eliminar btn-accion <?php echo $aux; ?>"><i class="icn-trash"></i></a>
						    </td>
						  </tr>
						  <?php
						   } // Fin for query1
						  }// Fin if query1
						?>
				  </tbody>
				</table>
			</div>
		</div>
		<?php
				$this->fmt->class_modulo->script_form("modulos/config/publicaciones.adm.php",$this->id_mod,"desc");
  }

	function form_nuevo(){
		$botones = $this->fmt->class_pagina->crear_btn("publicaciones.adm.php?tarea=busqueda","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Nueva Publicación", $botones,"");
		?>
		<div class="body-modulo col-xs-6 col-xs-offset-3">
			<form class="form form-modulo" action="publicaciones.adm.php?tarea=ingresar"  method="POST" id="form-nuevo">
				<div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->

				<div class="form-group control-group">
					<label>Nombre publicación:</label>
					<input class="form-control input-lg color-border-gris-a color-text-gris"  id="inputNombre" name="inputNombre" placeholder=" " type="text" autofocus />
				</div>
				<div class="form-group form-descripcion">
					<label>Descripción:</label>
					<textarea class="form-control" rows="5" id="inputDescripcion" name="inputDescripcion" placeholder=""></textarea>
				</div>
				<div class="form-group">
					<label>Ruta Archivo:</label>
					<input class="form-control" id="inputArchivo" name="inputArchivo" placeholder="" />
				</div>
				<div class="form-group">
					<label>Imagen:</label>
					<input class="form-control" id="inputImagen" name="inputImagen" placeholder="" />
				</div>
				<div class="form-group">
					<label>Titulo:</label>
					<input class="form-control" id="inputTitulo" name="inputTitulo" placeholder="" />
				</div>
				<div class="form-group">
					<label>Tipo:</label>
					<input class="form-control" id="inputTipo" name="inputTipo" placeholder="" />
				</div>

				<div class="form-group">
					<label>Css:</label>
					<input class="form-control" id="inputUrl" name="inputUrl" placeholder="" />
				</div>
				<div class="form-group">
					<label>Clase:</label>
					<input class="form-control" id="inputClase" name="inputClase"  placeholder="" />
				</div>
				<div class="form-group">
					<label>Id Item:</label>
					<input class="form-control" id="inputItem" name="inputItem"  placeholder="" />
				</div>
				<div class="form-group">
					<label>Número/Items:</label>
					<input class="form-control" id="inputNumero" name="inputNumero"  placeholder="" />
				</div>

				<div class="form-group">
					<label>Id categoria:</label>
					<input class="form-control" id="inputCat" name="inputCat"  placeholder="" />
				</div>

				<div class="form-group form-botones">
					 <button type="submit" class="btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save" ></i> Guardar</button>
					 <button type="submit" class="btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open" ></i> Activar</button>
				</div>
			</form>
		</div>
		<?php
	}

	function form_editar(){
		$botones = $this->fmt->class_pagina->crear_btn("publicaciones.adm.php?tarea=busqueda","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Editar Publicación", $botones,"");
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];

		$sql="select * from publicacion	where pub_id='".$id."'";
		$rs=$this->fmt->query->consulta($sql);
		$num=$this->fmt->query->num_registros($rs);
			if($num>0){
				for($i=0;$i<$num;$i++){
					list($fila_id,$fila_nombre,$fila_descripcion,$fila_imagen,$fila_titulo,$fila_tipo,$fila_archivo,$fila_css,$fila_clase,$fila_item, $fila_numero, $fila_cat, $fila_activar)=$this->fmt->query->obt_fila($rs);
				}
			}

		?>
		<div class="body-modulo col-xs-6 col-xs-offset-3">
			<form class="form form-modulo" action="publicaciones.adm.php?tarea=modificar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-nuevo">
				<div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->

				<div class="form-group control-group">
					<label>Nombre publicación:</label>
					<input class="form-control input-lg color-border-gris-a color-text-gris"  id="inputNombre" name="inputNombre" placeholder=" " value="<?php echo $fila_nombre; ?>" type="text" autofocus />
					<input id="inputId" name="inputId" type="hidden" value="<?php echo $fila_id; ?>" />
				</div>
				<div class="form-group form-descripcion">
					<label>Descripción:</label>
					<textarea class="form-control" rows="5" id="inputDescripcion" name="inputDescripcion" placeholder=""><?php echo $fila_descripcion; ?></textarea>
				</div>
				<div class="form-group">
					<label>Ruta Archivo:</label>
					<input class="form-control" id="inputArchivo" name="inputArchivo" placeholder="" value="<?php echo $fila_archivo; ?>"/>
				</div>
				<div class="form-group">
					<label>Imagen:</label>
					<input class="form-control" id="inputImagen" name="inputImagen" placeholder="" value="<?php echo $fila_imagen; ?>"/>
				</div>
				<div class="form-group">
					<label>Titulo:</label>
					<input class="form-control" id="inputTitulo" name="inputTitulo" placeholder="" value="<?php echo $fila_titulo; ?>"/>
				</div>
				<div class="form-group">
					<label>Tipo:</label>
					<input class="form-control" id="inputTipo" name="inputTipo" placeholder="" value="<?php echo $fila_tipo; ?>" />
				</div>

				<div class="form-group">
					<label>Css:</label>
					<input class="form-control" id="inputUrl" name="inputUrl" placeholder="" value="<?php echo $fila_css; ?>"/>
				</div>
				<div class="form-group">
					<label>Clase:</label>
					<input class="form-control" id="inputClase" name="inputClase"  placeholder="" value="<?php echo $fila_clase; ?>" />
				</div>
				<div class="form-group">
					<label>Id Item:</label>
					<input class="form-control" id="inputItem" name="inputItem"  placeholder="" value="<?php echo $fila_item; ?>"/>
				</div>
				<div class="form-group">
					<label>Número/Items:</label>
					<input class="form-control" id="inputNumero" name="inputNumero"  placeholder="" value="<?php echo $fila_numero; ?>"/>
				</div>

				<div class="form-group">
					<label>Id categoria:</label>
					<input class="form-control" id="inputCat" name="inputCat"  placeholder="" value="<?php echo $fila_cat; ?>"/>
				</div>

				<div class="form-group form-botones">
					 <button  type="button" class="btn btn-danger btn-eliminar color-bg-rojo-a" id_eliminar="<? echo $fila_id; ?>" nombre_eliminar="<? echo $fila_nombre; ?>" name="btn-accion" id="btn-eliminar" value="eliminar"><i class="icn-trash" ></i> Eliminar Modulo</button>

					 <button type="submit" class="btn btn-info  btn-actualizar hvr-fade btn-lg color-bg-celecte-c btn-lg" name="btn-accion" id="btn-activar" value="actualizar"><i class="icn-sync" ></i> Actualizar</button>
				</div>
			</form>
		</div>
		<?php
			$this->fmt->class_modulo->script_form("modulos/config/publicaciones.adm.php",$this->id_mod);
	}

	function activar(){
		$this->fmt->get->validar_get ( $_GET['estado'] );
		$this->fmt->get->validar_get ( $_GET['id'] );
		$sql="update publicacion set
			 pub_activar='".$_GET['estado']."' where pub_id='".$_GET['id']."'";
		$this->fmt->query->consulta($sql);
		header("location: publicaciones.adm.php?id_mod=".$this->id_mod);
	}


	function ingresar(){

		if ($_POST["btn-accion"]=="activar"){
			$activar=1;
		}
		if ($_POST["btn-accion"]=="guardar"){
			$activar=0;
		}

		$ingresar ="pub_nombre, pub_descripcion, pub_imagen, pub_titulo, pub_tipo, pub_archivo, pub_css, pub_clase, pub_id_item, pub_numero, pub_id_cat, pub_activar";
		$valores  ="'".$_POST['inputNombre']."','".
									 $_POST['inputDescripcion']."','".
									 $_POST['inputImagen']."','".
									 $_POST['inputTitulo']."','".
									 $_POST['inputTipo']."','".
									 $_POST['inputArchivo']."','".
									 $_POST['inputCss']."','".
									 $_POST['inputClase']."','".
									 $_POST['inputItem']."','".
									 $_POST['inputNumero']."','".
									 $_POST['inputCat']."','".
									 $activar."'";

		$sql="insert into publicacion (".$ingresar.") values (".$valores.")";

		$this->fmt->query->consulta($sql);

		header("location: publicaciones.adm.php?id_mod=".$this->id_mod);
	} // fin funcion ingresar

	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){

			$sql="UPDATE publicacion SET
						pub_nombre='".$_POST['inputNombre']."',
						pub_descripcion='".$_POST['inputDescripcion']."',
						pub_imagen ='".$_POST['inputImagen']."',
						pub_titulo='".$_POST['inputTitulo']."',
						pub_tipo='".$_POST['inputTico']."',
						pub_archivo='".$_POST['inputArchivo']."',
						pub_css='".$_POST['inputCss']."',
						pub_clase='".$_POST['inputClase']."',
						pub_id_item='".$_POST['inputItem']."',
						pub_numero='".$_POST['inputNumero']."',
						pub_id_cat='".$_POST['inputCat']."',
						pub_activar='".$_POST['inputActivar']."'
	          WHERE pub_id='".$_POST['inputId']."'";

			$this->fmt->query->consulta($sql);
		}
			header("location: publicaciones.adm.php?id_mod=".$this->id_mod);
	}

	function eliminar(){
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id= $_GET['id'];
		$sql="DELETE FROM publicaciones WHERE pub_id='".$id."'";
		$this->fmt->query->consulta($sql);
		$up_sqr6 = "ALTER TABLE publicaciones AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);
		header("location: publicaciones.adm.php?id_mod=".$this->id_mod);
	}


}
?>
