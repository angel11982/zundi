<?php
header("Content-Type: text/html;charset=utf-8");

class PRODUCTOS{

	var $fmt;
	var $id_mod;

	function PRODUCTOS($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

	function busqueda(){
    $botones = $this->fmt->class_pagina->crear_btn("productos.adm.php?tarea=form_nuevo&id_mod=$this->id_mod","btn btn-primary","icn-plus","Nuevo Producto");  // link, tarea, clase, icono, nombre
    $this->fmt->class_pagina->crear_head( $this->id_mod, $botones); // bd, id modulo, botones
    ?>
    <div class="body-modulo">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Imagen</th>
            <th>Nombre del producto</th>
            <th>Categoria/s</th>
            <th>Publicación</th>
            <th class="col-xl-offset-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql="select mod_prod_id, mod_prod_nombre, mod_prod_imagen, mod_prod_activar from mod_productos	ORDER BY mod_prod_id desc";
            $rs =$this->fmt->query->consulta($sql);
            $num=$this->fmt->query->num_registros($rs);
            if($num>0){
            for($i=0;$i<$num;$i++){
              list($fila_id,$fila_nombre,$fila_imagen,$fila_activar)=$this->fmt->query->obt_fila($rs);
            ?>
            <tr>
              <td class="" style="width:20%" ><img class="img-responsive" src="<?php echo _RUTA_WEB.$fila_imagen; ?>" alt="" /></td>
              <td class=""><?php echo $fila_nombre; ?></td>
              <td class="">
								<?php
									$this->traer_rel_cat_nombres($fila_id); //$fila_id,$from,$prefijo_cat,$prefijo_rel
								?>
							</td>
              <td class="estado">
                <?php
                  $this->fmt->class_modulo->estado_publicacion($fila_activar,"modulos/modulos/modulos.adm.php", $this->id_mod,$aux, $fila_id ); // query, id item, ruta, id modulo, aux disabled
                ?>
              </td>
              <td class="col-xl-offset-2 acciones">

                <a  id="btn-editar-modulo" class="btn btn-accion btn-editar <?php echo $aux; ?>" href="productos.adm.php?tarea=form_editar&id=<? echo $fila_id; ?>&id_mod=<? echo $this->id_mod; ?>" title="Editar <? echo $fila_id."-".$fila_url; ?>" ><i class="icn-pencil"></i></a>
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
      $this->fmt->class_modulo->script_form("modulos/productos/productos.adm.php",$this->id_mod);
  }

	function traer_rel_cat_nombres($fila_id){
		$consulta = "SELECT mod_prod_rel_cat_id, mod_prod_cat_nombre FROM mod_productos_cat, mod_productos_rel WHERE mod_prod_rel_prod_id='".$fila_id."' and mod_prod_cat_id = mod_prod_rel_cat_id";
		$rs = $this->fmt->query->consulta($consulta);
		$num=$this->fmt->query->num_registros($rs);
		if ($num>0){
			for ($i=0;$i<$num;$i++){
				list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
				echo "- ".$fila_nombre."<br/>";
			}
		}
	}

	function form_editar(){
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];
		$consulta= "SELECT * FROM mod_productos WHERE mod_prod_id='".$id."'";
		$rs =$this->fmt->query->consulta($consulta);
		$fila=$this->fmt->query->obt_fila($rs);
		$this->fmt->form->head_editar('Producto','productos',$this->id_mod,'','form_editar');
		$this->fmt->form->input_form("<span class='obligatorio'>*</span> Nombre archivo:","inputNombre","",$fila['mod_prod_nombre'],"input-lg","","");
		$this->fmt->form->input_form("Tags:","inputTags","",$fila['mod_prod_tags'],"","","");
		?>
		<div class="form-group">
			<label>Imagen (560x400px):</label>
			<div class="panel panel-default" >
				<div class="panel-body">
		<?php
		$this->fmt->form->file_form_editar('Cargar Archivo (max 8MB)','sitios','form_editar','form-file','','box-file-form','productos');
		?>
					<div class="url-imagen"><img src="<?php echo _RUTA_WEB.$fila['mod_prod_imagen']; ?>" class="img-responsive"></div>
				</div>
			</div>
		</div>
		<?php
		$this->fmt->form->input_form("Codigo:","inputCodigo","",$fila['mod_prod_codigo'],"","","");
		$this->fmt->form->input_form("Modelo:","inputModelo","",$fila['mod_prod_modelo'],"","","");
		$this->fmt->form->textarea_form("Resumen:","inputResumen","",$fila['mod_prod_resumen'],"","","5",""); //$label,$id,$placeholder,$valor,$class,$class_div,$rows,$mensaje
		$this->fmt->form->textarea_form("Detalles:","inputDetalles","",$fila['mod_prod_detalles'],"","","5","");
		$this->fmt->form->textarea_form("Especificaciones:","inputEspecificaciones","",$fila['mod_prod_especificaciones'],"","","5","");
		$this->fmt->form->input_form("Disponibilidad:","inputDisponibilidad","Inmediata, a 30 días, a 15 días, definido por pedido",$fila['mod_prod_disponibilidad'],"","","");
		$this->fmt->form->input_form("Precio:","inputPrecio","",$fila['mod_prod_precio'],"","","");
		$this->fmt->form->input_form("Id Doc:","inputDoc","",$fila['mod_prod_id_doc'],"","","");
		$this->fmt->form->input_form("Id Mul:","inputMul","",$fila['mod_prod_id_mul'],"","","");
		$this->fmt->form->radio_activar_form($fila['mod_prod_activar']);
		$this->fmt->form->botones_editar($fila['mod_prod_id'],$fila['mod_prod_nombre'],'Producto');//$fila_id,$fila_nombre,$nombre
    $this->fmt->class_modulo->script_form("modulos/productos/productos.adm.php",$this->id_mod);
		$this->fmt->form->footer_page();
	}

	function form_nuevo(){
		$botones = $this->fmt->class_pagina->crear_btn("productos.adm.php?tarea=busqueda&id_mod=$this->id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Nuevo Producto", $botones,"");// nombre, botones-left, botones-right
		?>
		<div class="body-modulo col-xs-6 col-xs-offset-3">
			<form class="form form-modulo" action="productos.adm.php?tarea=ingresar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form_nuevo">
				<div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
				<div class="form-group">
					<label>Nombre Producto</label>
					<input class="form-control input-lg"  id="inputNombre" name="inputNombre" placeholder=" " type="text" autofocus />
				</div>
				<div class="form-group">
					<label>Tags</label>
					<input class="form-control" id="inputTags" name="inputTags" placeholder="" />
				</div>
				<div class="form-group">
				<label>Imagen (560x400px):</label>
				<div class="panel panel-default" >
					<div class="panel-body">
				<?php
				$this->fmt->form->file_form_nuevo('Cargar Archivo (max 8MB)','sitios','form_nuevo','form-file','','box-file-form','productos');
				?>
					</div>
				</div>
				</div>
				<div class="form-group">
					<label>Codigo:</label>
					<input class="form-control" id="inputCodigo" name="inputCodigo" placeholder="" />
				</div>
				<div class="form-group">
					<label>Modelo:</label>
					<input class="form-control" id="inputModelo" name="inputModelo" placeholder="" />
				</div>
				<div class="form-group form-descripcion">
					<label>Resumén</label>
					<textarea class="form-control" rows="5" id="inputResumen" name="inputResumen" placeholder=""></textarea>
				</div>
				<div class="form-group form-descripcion">
					<label>Detalles:</label>
					<textarea class="form-control" rows="5" id="inputDetalles" name="inputDetalles" placeholder=""></textarea>
				</div>
				<div class="form-group form-descripcion">
					<label>Especificaciones:</label>
					<textarea class="form-control" rows="5" id="inputEspecificaciones" name="inputEspecificaciones" placeholder=""></textarea>
				</div>
				<div class="form-group">
					<label>Disponilidad:</label>
					<input class="form-control" id="inputDisponilidad" name="inputDisponilidad" placeholder="Inmediata, a 30 días, a 15 días, definido por pedido" />
				</div>


				<div class="form-group">
					<label>Precio:</label>
					<input class="form-control" id="inputPrecio" name="inputPrecio" placeholder="" />
				</div>
				<div class="form-group">
					<label>Id Doc:</label>
					<input class="form-control" id="inputDoc" name="inputDoc" placeholder="" />
				</div>
				<div class="form-group">
					<label>Id Mul:</label>
					<input class="form-control" id="inputMul" name="inputMul" placeholder="" />
				</div>
				<div class="form-group">
					<label>Categoria productos:</label>
					<select class="form-control" id="inputCat" name="inputCat">
						<?php $this->fmt->categoria->traer_opciones($fila['mod_prod_cat_id'],'mod_productos_cat','mod_prod_cat_'); ?>
					</select>
				</div>

				<div class="form-group form-botones">
					 <button type="submit" class="btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save" ></i> Guardar</button>
					 <button type="submit" class="btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open" ></i> Activar</button>
				</div>
			</form>
		</div>
		<?php
	}


	function ingresar(){
		if ($_POST["btn-accion"]=="activar"){
			$activar=1;
		}
		if ($_POST["btn-accion"]=="guardar"){
			$activar=0;
		}
		$ingresar ="mod_prod_nombre, mod_prod_tags, mod_prod_codigo, mod_prod_modelo,mod_prod_resumen, mod_prod_detalles, mod_prod_especificaciones, mod_prod_disponibilidad, mod_prod_imagen,mod_prod_precio, mod_prod_id_doc, mod_prod_id_mul, mod_prod_activar";
		$valores  ="'".$_POST['inputNombre']."','".
									 $_POST['inputTags']."','".
									 $_POST['inputCodigo']."','".
									 $_POST['inputModelo']."','".
									 $_POST['inputResumen']."','".
									 $_POST['inputDetalles']."','".
									 $_POST['inputEspecificaciones']."','".
									 $_POST['inputDisponibilidad']."','".
									 $_POST['inputUrlArchivo']."','".
									 $_POST['inputPrecio']."','".
									 $_POST['inputDoc']."','".
									 $_POST['inputMul']."','".
									 $activar."'";

		$sql="insert into mod_productos (".$ingresar.") values (".$valores.")";
		$this->fmt->query->consulta($sql);

		$sql="select max(mod_prod_id) as id from mod_productos";
		$rs= $this->fmt->query->consulta($sql);
		$fila = $this->fmt->query->obt_fila($rs);
	  $id = $fila ["id"];
		$ingresar1 ="mod_prod_rel_prod_id, mod_prod_rel_cat_id";
		$valores1 = "'".$id."','".$_POST['inputCat']."'";
		$sql1="insert into mod_productos_rel (".$ingresar1.") values (".$valores1.")";
		$this->fmt->query->consulta($sql1);

		header("location: productos.adm.php?id_mod=".$this->id_mod);
	}

	function eliminar(){
		$this->fmt->get->validar_get( $_GET['id'] );
		$id= $_GET['id'];

		$sql="DELETE FROM mod_productos WHERE mod_prod_id='".$id."'";
		$this->fmt->query->consulta($sql);

		$sql="DELETE FROM mod_productos_rel WHERE mod_prod_rel_prod_id='".$id."'";
		$this->fmt->query->consulta($sql);

		$up_sqr6 = "ALTER TABLE mod_productos AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);

		$up_sqr7 = "ALTER TABLE mod_productos_rel AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr7);

		header("location: productos.adm.php?id_mod=".$this->id_mod);
	}

}
