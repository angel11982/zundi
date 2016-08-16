<?php
header("Content-Type: text/html;charset=utf-8");

class MODULOS{

	var $fmt;
	var $id_mod;

	function MODULOS($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

	function busqueda(){
			$botones = $this->fmt->class_pagina->crear_btn("modulos.adm.php?tarea=form_nuevo&id_mod=$this->id_mod","btn btn-primary","icn-plus","Nuevo modulo");  // link, tarea, clase, icono, nombre
			$this->fmt->class_pagina->crear_head( $this->id_mod, $botones); // bd, id modulo, botones
			?>
			<div class="body-modulo">
			<div class="table-responsive">
				<table class="table table-hover">
				  <thead>
				    <tr>
				      <th>Nombre del modulo</th>
				      <th>Tipo Modulo</th>
				      <th>Publicación</th>
				      <th class="col-xl-offset-2">Acciones</th>
				    </tr>
				  </thead>
				  <tbody>
						<?php
							$sql="select mod_id, mod_nombre, mod_descripcion, mod_url, mod_tipo, mod_icono, mod_activar from modulos	ORDER BY mod_id desc";
							$rs =$this->fmt->query->consulta($sql);
							$num=$this->fmt->query->num_registros($rs);
							if($num>0){
						  for($i=0;$i<$num;$i++){
						    list($fila_id,$fila_nombre,$fila_descripcion,$fila_url,$fila_tipo,$fila_icono,$fila_activar)=$this->fmt->query->obt_fila($rs);
						  ?>
						  <tr>
						    <td class="col-nombre"><i class="icn <?php echo $fila_icono; ?>"></i> <?php echo $fila_nombre; ?></td>
								<?php  if($fila_tipo=="2"){ $aux ="disabled"; } ?>
						    <td class="tabla-col col-tipo-modulo"><?php echo $this->tipo_modulo($fila_tipo); ?></td>
						    <td class="estado">
						      <?php
						        $this->fmt->class_modulo->estado_publicacion($fila_activar,"modulos/modulos/modulos.adm.php", $this->id_mod,$aux, $fila_id ); // query, id item, ruta, id modulo, aux disabled
									?>
						    </td>
						    <td class="col-xl-offset-2 acciones">

						      <a  id="btn-editar-modulo" class="btn btn-accion btn-editar <?php echo $aux; ?>" href="modulos.adm.php?tarea=form_editar&id=<? echo $fila_id; ?>&id_mod=<? echo $this->id_mod; ?>" title="Editar <? echo $fila_id."-".$fila_url; ?>" ><i class="icn-pencil"></i></a>
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
				$this->fmt->class_modulo->script_form("modulos/modulos/modulos.adm.php",$this->id_mod);
  }  // fin busqueda

	function form_nuevo(){
		$botones = $this->fmt->class_pagina->crear_btn("modulos.adm.php?tarea=busqueda&id_mod=$this->id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Nuevo Modulo", $botones,"");// nombre, botones-left, botones-right
		echo "<a href='javascript:location.reload()'><i class='icn-sync'></i></a>";
		?>
		<div class="body-modulo col-xs-6 col-xs-offset-3">
			<form class="form form-modulo" action="modulos.adm.php?tarea=ingresar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-nuevo">
				<div class="form-group" id="mensaje-login"></div> <!--Mensaje form -->

				<div class="form-group control-group">
					<label>Nombre Modulo</label>
					<div class="input-group controls">
						<span class=" color-border-gris-a  color-text-gris input-group-addon form-input-icon"><i class="<? echo $this->fmt->class_modulo->icono_modulo($this->id_mod); ?>"></i></span>
						<input class="form-control input-lg color-border-gris-a color-text-gris form-nombre"  id="inputNombre" name="inputNombre" placeholder=" " type="text" autofocus />
					</div>
				</div>

				<div class="form-group form-descripcion">
					<label>Descripción</label>
					<textarea class="form-control" rows="5" id="inputDescripcion" name="inputDescripcion" placeholder=""></textarea>
				</div>
				<div class="form-group">
					<label>Url modulo</label>
					<input class="form-control" id="inputUrl" name="inputUrl" placeholder="" />
				</div>
				<div class="form-group">
					<label>Icono modulo</label>
					<input class="form-control" id="inputIcono" name="inputIcono"  placeholder="" />

				</div>

				<div class="form-group">
					<label>Tipo modulo:  </label>
					<select class="form-control form-select" name="inputTipo" id="inputTipo">
						<?php echo $this->opciones_tipo("");  ?>
					</select>
				</div>
				<?php
					$this->fmt->form->categoria_form('Categoria','inputCat',"0","","","");
				?>
				<div class="form-group form-botones">
					 <button type="submit" class="btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save" ></i> Guardar</button>
					 <button type="submit" class="btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open" ></i> Activar</button>
				</div>
			</form>
		</div>
		<?php
	}

	function form_editar(){
		$botones = $this->fmt->class_pagina->crear_btn("modulos.adm.php?tarea=busqueda&id_mod=$this->id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Editar Modulo", $botones,"");// nombre, botones-left, botones-right
		//echo "<a href='javascript:location.reload()'><i class='icn-sync'></i></a>";
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];

		$sql="select mod_id, mod_nombre, mod_descripcion, mod_url, mod_tipo, mod_icono, mod_activar from modulos	where mod_id='".$id."'";
		$rs=$this->fmt->query->consulta($sql);
		$num=$this->fmt->query->num_registros($rs);
			if($num>0){
				for($i=0;$i<$num;$i++){
					list($fila_id,$fila_nombre,$fila_descripcion,$fila_url,$fila_tipo,$fila_icono,$fila_activar)=$this->fmt->query->obt_fila($rs);
				}
			}
		?>
		<div class="body-modulo col-xs-6 col-xs-offset-3">
			<form class="form form-modulo" action="modulos.adm.php?tarea=modificar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-nuevo">
				<div class="form-group" id="mensaje-login"></div> <!--Mensaje form -->

				<div class="form-group control-group">
					<label>Nombre Modulo</label>
					<div class="input-group controls">
						<span class=" color-border-gris-a  color-text-gris input-group-addon form-input-icon"><i class="<? echo $fila_icono; ?>"></i></span>
						<input class="form-control input-lg color-border-gris-a color-text-gris form-nombre"  id="inputNombre" name="inputNombre" value="<? echo $fila_nombre; ?>" placeholder=" " type="text" autofocus />
						<input type="hidden" id="inputId" name="inputId" value="<?php echo $fila_id; ?>" />
					</div>
				</div>
				<div class="form-group form-descripcion">
					<label>Descripción</label>
					<textarea class="form-control" rows="5" id="inputDescripcion" name="inputDescripcion" placeholder=""><? echo $fila_descripcion; ?></textarea>
				</div>
				<div class="form-group">
					<label>Url modulo</label>
					<input class="form-control" id="inputUrl" name="inputUrl" placeholder="" value="<? echo $fila_url; ?>" />
				</div>
				<div class="form-group">
					<label>Icono modulo</label>
					<input class="form-control" id="inputIcono" name="inputIcono"  placeholder="" value="<? echo $fila_icono; ?>"/>
				</div>
				<div class="form-group">
					<label>Tipo modulo:  </label>
					<select class="form-control form-select" name="inputTipo" id="inputTipo">
						<?  echo $this->opciones_tipo($fila_tipo);  ?>
					</select>
				</div>
				<?php
					$cats_id = $this->fmt->categoria->traer_rel_cat_id($id,'modulos_categoria','categoria_cat_id','	modulos_mod_id'); //$fila_id,$from,$prefijo_cat,$prefijo_rel

					$this->fmt->form->categoria_form('Categoria','inputCat',"0",$cats_id,"","");
				?>
				<div class="form-group">
					<label class="radio-inline">
						<input type="radio" name="inputActivar" id="inputActivar" value="0" <?php if ($fila_activar==0){ echo "checked"; } ?> > Desactivar
					</label>
					<label class="radio-inline">
						<input type="radio" name="inputActivar" id="inputActivar" value="1" <?php if ($fila_activar==1){ echo "checked"; $aux="Activo"; } else { $aux="Activar"; } ?> > <? echo $aux; ?>
					</label>
				</div>
				<div class="form-group form-botones">
					 <button  type="button" class="btn btn-danger btn-eliminar color-bg-rojo-a" id_eliminar="<? echo $fila_id; ?>" nombre_eliminar="<? echo $fila_nombre; ?>" name="btn-accion" id="btn-eliminar" value="eliminar"><i class="icn-trash" ></i> Eliminar Modulo</button>

					 <button type="submit" class="btn btn-info  btn-actualizar hvr-fade btn-lg color-bg-celecte-c btn-lg" name="btn-accion" id="btn-activar" value="actualizar"><i class="icn-sync" ></i> Actualizar</button>
				</div>
			</form>
		</div>
		<?php
		 $this->fmt->class_modulo->script_form("modulos/modulos/modulos.adm.php",$this->id_mod);
	}

	function ingresar(){

		if ($_POST["btn-accion"]=="activar"){
			$activar=1;
		}
		if ($_POST["btn-accion"]=="guardar"){
			$activar=0;
		}

		$ingresar ="mod_nombre, mod_descripcion, mod_url, mod_tipo, mod_icono, mod_activar";
		$valores  ="'".$_POST['inputNombre']."','".
									 $_POST['inputDescripcion']."','".
									 $_POST['inputUrl']."','".
									 $_POST['inputTipo']."','".
									 $_POST['inputIcono']."','".
									 $activar."'";

		$sql="insert into modulos (".$ingresar.") values (".$valores.")";

		$this->fmt->query->consulta($sql);

		$sql="select max(mod_id) as id from modulos";
		$rs= $this->fmt->query->consulta($sql);
		$fila = $this->fmt->query->obt_fila($rs);
		$id = $fila ["id"];
		$ingresar1 ="modulos_mod_id, categoria_cat_id";
		$valor_cat= $_POST['inputCat'];
		$num=count( $valor_cat );
		for ($i=0; $i<$num;$i++){
			$valores1 = "'".$id."','".$valor_cat[$i]."'";
			$sql1="insert into modulos_categoria (".$ingresar1.") values (".$valores1.")";
			$this->fmt->query->consulta($sql1);
		}

		header("location: modulos.adm.php?id_mod=".$this->id_mod);
	} // fin funcion ingresar

	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){
			$id=$_POST['inputId'];
			$sql="UPDATE modulos SET
						mod_nombre='".$_POST['inputNombre']."',
						mod_descripcion='".$_POST['inputDescripcion']."',
						mod_url ='".$_POST['inputUrl']."',
						mod_tipo='".$_POST['inputTipo']."',
						mod_icono='".$_POST['inputIcono']."',
						mod_activar='".$_POST['inputActivar']."'
	          WHERE mod_id='".$id."'";

			$this->fmt->query->consulta($sql);

			$this->fmt->class_modulo->eliminar_fila($_POST['inputId'],"modulos_categoria","modulos_mod_id");

			$ingresar1 ="modulos_mod_id, categoria_cat_id";
			$valor_cat= $_POST['inputCat'];
			$num=count( $valor_cat );
			for ($i=0; $i<$num;$i++){
				$valores1 = "'".$id."','".$valor_cat[$i]."'";
				$sql1="insert into modulos_categoria (".$ingresar1.") values (".$valores1.")";
				$this->fmt->query->consulta($sql1);
			}
		}
			header("location: modulos.adm.php?id_mod=".$this->id_mod);
	}

	function eliminar(){
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id= $_GET['id'];
		$this->fmt->class_modulo->eliminar_fila($id,"modulos_categoria","modulos_mod_id");
		$sql="DELETE FROM modulos WHERE mod_id='".$id."'";
		$this->fmt->query->consulta($sql);
		$up_sqr6 = "ALTER TABLE modulos AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);
		header("location: modulos.adm.php?id_mod=".$this->id_mod);
	}

	function activar(){
		$this->fmt->get->validar_get ( $_GET['estado'] );
		$this->fmt->get->validar_get ( $_GET['id'] );
		$sql="update modulos set
				mod_activar='".$_GET['estado']."' where mod_id='".$_GET['id']."'";
		$this->fmt->query->consulta($sql);
		header("location: modulos.adm.php?id_mod=".$this->id_mod);
	}

	function tipo_modulo($mod_tipo){

		switch ($mod_tipo) {
			case '0':
				$mod_tipo="Datos";
				break;
			case '1':
				$mod_tipo="Configuración";
				break;
			case '2':
				$mod_tipo="Esencial";
				break;
			default:
				$mod_tipo="no definido";
				break;
		}
		return $mod_tipo;
	}

	function opciones_tipo($fila_tipo){
		$tipos = Array();
		for ($i = 0; $i <= 3; $i++) {
			$tipos [$i]= $this->tipo_modulo($i);
		}

		for ($i = 0; $i <= 3; $i++) {
			if (isset($fila_tipo)){
				if ($fila_tipo==$i){ $sel="selected"; } else {$sel="";}
			}else {
			$sel="";
			}
			$aux .='<option value="'.$i.'" '.$sel.'?>'.$tipos[$i].'</option>';
		}
		return $aux;
	}

}
?>
