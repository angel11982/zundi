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
    $this->fmt->class_modulo->script_form("modulos/productos/productos.adm.php",$this->id_mod,"asc","0","25",true);
    $this->eliminar_mul("0");
    $id_rol = $this->fmt->sesion->get_variable("usu_rol");
    ?>
    <div class="body-modulo">
    <div class="table-responsive">
      <table class="table table-hover" id="table_id">
        <thead>
          <tr>
            <th style="width:10%" >Imagen</th>
            <th>Nombre del producto</th>
            <th>Categoria/s</th>
            <th class="estado">Publicación</th>
            <th class="col-xl-offset-2 acciones">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          	if($id_rol==1)
            	$sql="select mod_prod_id, mod_prod_nombre, mod_prod_imagen,  mod_prod_id_dominio, mod_prod_activar from mod_productos ORDER BY mod_prod_id desc";
            else{
            	$aux="";
            	$or="";
            	$sql="select rol_rel_cat_id from roles_rel where rol_rel_rol_id=".$id_rol." and rol_rel_cat_id not in (0) ORDER BY rol_rel_cat_id asc";
			      $rs =$this->fmt->query->consulta($sql);
				  $num=$this->fmt->query->num_registros($rs);
				  if($num>0){
				  	for($i=0;$i<$num;$i++){
				    	list($fila_id)=$this->fmt->query->obt_fila($rs);
						$aux.=$or."mod_prod_rel_cat_id=".$fila_id;
						$or=" or ";
						if($this->fmt->categoria->tiene_hijos_cat($fila_id)){
							$ids_cat=array();
							$this->fmt->categoria->traer_hijos_array($fila_id,$ids_cat);
							$num_cat=count($ids_cat);
							if ($num_cat>0){
								for($j=0;$j<$num_cat;$j++){
									$aux.=$or."mod_prod_rel_cat_id=".$ids_cat[$j];
								}
							}
						}
					}
			      }
            	$sql="select mod_prod_id, mod_prod_nombre, mod_prod_imagen,  mod_prod_id_dominio, mod_prod_activar from mod_productos, mod_productos_rel where mod_prod_rel_prod_id=mod_prod_id and ($aux) ORDER BY mod_prod_id desc";

            }
            $rs =$this->fmt->query->consulta($sql);
            $num=$this->fmt->query->num_registros($rs);
            if($num>0){
            for($i=0;$i<$num;$i++){
              list($fila_id,$fila_nombre,$fila_imagen,$fila_dominio,$fila_activar)=$this->fmt->query->obt_fila($rs);
							if (empty($fila_dominio)){ $aux=_RUTA_WEB_temp; } else { $aux = $this->fmt->categoria->traer_dominio_cat_id($fila_dominio); }
							$img=$this->fmt->archivos->convertir_url_mini( $fila_imagen );
							$id_cat = $this->fmt->categoria->traer_id_cat_dominio($aux);
							$sit_cat = $this->fmt->categoria->ruta_amigable($id_cat);
							if(!file_exists(_RUTA_SERVER.$sit_cat."/".$img)){
								$img=$this->fmt->archivos->convertir_url_thumb( $fila_imagen );
							}

							$url ="productos.adm.php?tarea=form_editar&id=".$fila_id."&id_mod=".$this->id_mod;
            ?>
            <tr>
              <td><img class="img-responsive" width="60px" src="<?php echo $aux.$img; ?>" alt="" /></td>
              <td><strong><a href="<? echo $url; ?>" ><?php echo $fila_nombre; ?></a></strong></td>
              <td><?php	$this->traer_rel_cat_nombres($fila_id); ?> </td>
              <td><?php $this->fmt->class_modulo->estado_publicacion($fila_activar,"modulos/productos/productos.adm.php", $this->id_mod,$aux, $fila_id ); ?></td>
              <td>

                <a  id="btn-editar-modulo" class="btn btn-accion btn-editar" href="<? echo $url; ?>" title="Editar <? echo $fila_id."-".$fila_url; ?>" ><i class="icn-pencil"></i></a>
                <a  title="eliminar <? echo $fila_id; ?>" type="button" idEliminar="<? echo $fila_id; ?>" nombreEliminar="<? echo $fila_nombre; ?>" tarea="eliminar" class="btn btn-eliminar btn-accion"><i class="icn-trash"></i></a>
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

  }

	function traer_rel_cat_nombres($fila_id){
		$consulta = "SELECT cat_id, cat_nombre FROM categoria, mod_productos_rel WHERE mod_prod_rel_prod_id='".$fila_id."' and cat_id = mod_prod_rel_cat_id";
		$rs = $this->fmt->query->consulta($consulta);
		$num=$this->fmt->query->num_registros($rs);
		if ($num>0){
			for ($i=0;$i<$num;$i++){
				list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
				echo "- ".$fila_nombre." <br/>";
			}
		}
	}

	function rel_id_cat($id_prod){
		$consulta = "SELECT mod_prod_rel_cat_id FROM mod_productos_rel WHERE mod_prod_rel_prod_id='".$id_prod."'";
		$rs = $this->fmt->query->consulta($consulta);
		$num=$this->fmt->query->num_registros($rs);
		if ($num>0){
			for ($i=0;$i<$num;$i++){
				list($fila_id)=$this->fmt->query->obt_fila($rs);
				$valor[$i]=$fila_id;
			}
		}

		return $valor;
	}


	function form_editar(){
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];
		$id_rol = $this->fmt->sesion->get_variable("usu_rol");
		$consulta= "SELECT * FROM mod_productos WHERE mod_prod_id='".$id."'";
		$rs =$this->fmt->query->consulta($consulta);
		$fila=$this->fmt->query->obt_fila($rs);
		$this->fmt->form->head_editar('Editar Producto','productos',$this->id_mod,'','form_editar');
		$this->fmt->form->input_form("<span class='obligatorio'>*</span> Nombre archivo:","inputNombre","",$fila['mod_prod_nombre'],"input-lg","","");

		if (!empty($fila['mod_prod_ruta_amigable'])){
			$valor_ra = $fila['mod_prod_ruta_amigable'];
		}else{
			$valor_ra = $this->fmt->get->convertir_url_amigable($fila['mod_prod_nombre']);
		}

		$this->fmt->form->input_form("Nombre Amigable:","inputNombreAmigable","",$valor_ra,"","","","");
		$this->fmt->form->input_hidden_form("inputId",$id);
		$this->fmt->form->input_form("Tags:","inputTags","",$fila['mod_prod_tags'],"","","");
		//$this->fmt->form->input_hidden_form("inputArchivosEdit",$fila['mod_prod_imagen']);
		?>
		<div class="form-group">
			<label>Imagen (560x400px):</label>
			<div class="panel panel-default" >
				<div class="panel-body">
					<?php
					$this->fmt->form->file_form_nuevo_croppie_thumb('Cargar Archivo (max 8MB)','','form_editar','form-file','','box-file-form','archivos/productos','350x350',$fila['mod_prod_imagen']); //$nom,$ruta,$id_form,$class,$class_div,$id_div,$directorio_p,$sizethumb,$imagen
					?>

				</div>
			</div>
		</div>
		<?php
		//$this->fmt->form->input_form('Url archivo:','inputUrl','',$fila['mod_prod_imagen'],'');
		//$this->fmt->form->input_form('Dominio:','inputDominio','',$this->fmt->categoria->traer_dominio_cat_id($fila['mod_prod_id_dominio']),'');
		$this->fmt->form->input_form("Codigo:","inputCodigo","",$fila['mod_prod_codigo'],"","","");
		$this->fmt->form->input_form("Modelo:","inputModelo","",$fila['mod_prod_modelo'],"","","");
		$this->fmt->form->select_form("Marca:","InputMarca","mod_prod_mar_","mod_productos_marcas",$fila["mod_prod_id_marca"]);
		$this->fmt->form->textarea_form("Resumen:","inputResumen","",$fila['mod_prod_resumen'],"","","5",""); //$label,$id,$placeholder,$valor,$class,$class_div,$rows,$mensaje
		$this->fmt->form->textarea_form("Detalles:","inputDetalles","",$fila['mod_prod_detalles'],"summernote","","5","");
		$this->fmt->form->textarea_form("Especificaciones:","inputEspecificaciones","",$fila['mod_prod_especificaciones'],"summernote","","5","");
		$this->fmt->form->input_form("Disponibilidad:","inputDisponibilidad","Inmediata, a 30 días, a 15 días, definido por pedido",$fila['mod_prod_disponibilidad'],"","","");
		$this->fmt->form->input_form("Precio:","inputPrecio","",$fila['mod_prod_precio'],"","","");
		$this->fmt->form->agregar_documentos("Documentos:","inputDoc",$fila['mod_prod_id'],"","","","mod_productos_rel","mod_prod_rel_prod_id","mod_prod_rel_doc_id"); //$label,$id,$valor,$class,$class_div,$mensaje,$from,$id_item
		$this->fmt->form->agregar_pestana("Pestaña:","inputPestana",$fila['mod_prod_id'],"","","","mod_productos_pestana","mod_pro_pes_pro_id","mod_pro_pes_pes_id"); //$label,$id,$valor,$class,$class_div,$mensaje,$from,$id_item

		$this->fmt->form->multimedia_form("Multimedia:","imagenes","archivos/productos/","100x100","mod_productos_mul","mod_pro_mul_id_prod_mul","mod_pro_mul_id_prod","mod_pro_mul_ruta","mod_pro_mul_dominio",$fila['mod_prod_id']);
		//$this->fmt->form->select_form("Categoría productos:","inputCat","mod_prod_cat_","mod_productos_cat",$this->rel_id_cat($fila['mod_prod_id'])); //$label,$id,$prefijo,$from,$id_s
		//echo $this->rel_id_cat($fila['mod_prod_id']);
		if($id_rol==1)
		$this->fmt->form->categoria_form('Categoria','inputCat',"0",$this->rel_id_cat($fila['mod_prod_id']),"",""); //$$label,$id,$cat_raiz,$cat_valor,$class,$class_div
		else{
			$sql="select rol_rel_cat_id from roles_rel where rol_rel_rol_id=".$id_rol." and rol_rel_cat_id not in (0) ORDER BY rol_rel_cat_id asc";
			      $rs =$this->fmt->query->consulta($sql);
				  $num=$this->fmt->query->num_registros($rs);
				  if($num>0){
				  	for($i=0;$i<$num;$i++){
				    	list($fila_id)=$this->fmt->query->obt_fila($rs);
				    	$nombre_cat=$this->fmt->categoria->nombre_categoria($fila_id);
						$this->fmt->form->categoria_form('Categoria - '.$nombre_cat,'inputCat',$fila_id,$this->rel_id_cat($fila['mod_prod_id']),"","");
					}
			      }
		}
		$label[0]="Mostrar Categoria";
		$nombreinput[0]="inputActCat";
		$valor_in[0]="1";
		$campo_in[0]=$fila['mod_prod_activar_cat'];
		$this->fmt->form->input_check_form($label,$nombreinput,$valor_in,$campo_in);
		$this->fmt->form->radio_activar_form($fila['mod_prod_activar']);
		$this->fmt->form->botones_editar($id,$fila['mod_prod_nombre'],'Producto');//$fila_id,$fila_nombre,$nombre
		?>
		<script>
			$(document).ready(function () {
					var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-ruta-amigable.php";
					$("#inputNombre").keyup(function () {
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
    $this->fmt->class_modulo->script_form("modulos/productos/productos.adm.php",$this->id_mod);

		$this->fmt->form->footer_page();

	}

	function form_nuevo(){
		$id_rol = $this->fmt->sesion->get_variable("usu_rol");
		$botones = $this->fmt->class_pagina->crear_btn("productos.adm.php?tarea=busqueda&id_mod=$this->id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Nuevo Producto", $botones,"");// nombre, botones-left, botones-right
		?>
		<div class="body-modulo col-xs-6 col-xs-offset-3">
			<form class="form form-modulo" action="productos.adm.php?tarea=ingresar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form_nuevo" enctype="multipart/form-data">
				<div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
				<div class="form-group">
					<label>Nombre Producto:</label>
					<input class="form-control input-lg" required  id="inputNombre" name="inputNombre" placeholder=" " type="text" autofocus />
				</div>
				<div class="form-group">
					<label>Nombre amigable:</label>
					<input class="form-control"  id="inputNombreAmigable" name="inputNombreAmigable" placeholder=" " type="text" />
				</div>

				<div class="form-group">
					<label>Tags:</label>
					<input class="form-control" id="inputTags" name="inputTags" placeholder="" />
				</div>
				<div class="form-group">
				<label>Imagen (560x400px):</label>
				<div class="panel panel-default" >
					<div class="panel-body">



				<?php
				$this->fmt->form->file_form_nuevo_croppie_thumb('Cargar Archivo (max 8MB)','','form_nuevo','form-file','','box-file-form','archivos/productos',"350x350");
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
				<?php
					$this->fmt->form->select_form("Marca:","InputMarca","mod_prod_mar_","mod_productos_marcas");
				?>
				<div class="form-group form-descripcion">
					<label>Resumén</label>
					<textarea class="form-control" rows="5" id="inputResumen" name="inputResumen" placeholder=""></textarea>
				</div>
				<div class="form-group form-descripcion">
					<label>Detalles:</label>
					<textarea class="form-control summernote" rows="5" id="inputDetalles" name="inputDetalles" placeholder=""></textarea>
				</div>
				<div class="form-group form-descripcion">
					<label>Especificaciones:</label>
					<textarea class="form-control summernote" rows="5" id="inputEspecificaciones" name="inputEspecificaciones" placeholder=""></textarea>
				</div>
				<div class="form-group">
					<label>Disponilidad:</label>
					<input class="form-control" id="inputDisponilidad" name="inputDisponilidad" placeholder="Inmediata, a 30 días, a 15 días, definido por pedido" />
				</div>


				<div class="form-group">
					<label>Precio:</label>
					<input class="form-control" id="inputPrecio" name="inputPrecio" placeholder="" />
				</div>
				<?php
					$this->fmt->form->agregar_documentos("Documentos:","inputDoc","","","","","",""); //$label,$id,$valor,$class,$class_div,$mensaje,$from,$id_item
					$this->fmt->form->agregar_pestana("Pestaña:","inputPestana","","","","","",""); //$label,$id,$valor,$class,$class_div,$mensaje,$from,$id_item
				?>


				<?php
				$this->fmt->form->multimedia_form("Multimedia:","imagenes","archivos/productos/","100x100","mod_productos_mul","mod_pro_mul_id_prod_mul","mod_pro_mul_id_prod","mod_pro_mul_ruta","mod_pro_mul_dominio"); //$label,$input,$ruta,$thumb,$table,$col_id_extra,$col_id,$col_ruta,$col_dom,$id_mul
				if($id_rol==1)
					$this->fmt->form->categoria_form('Categoria','inputCat',"0","","",""); //$$label,$id,$cat_raiz,$cat_valor,$class,$class_div
				else{
					$sql="select rol_rel_cat_id from roles_rel where rol_rel_rol_id=".$id_rol." and rol_rel_cat_id not in (0) ORDER BY rol_rel_cat_id asc";
				      $rs =$this->fmt->query->consulta($sql);
					  $num=$this->fmt->query->num_registros($rs);
					  if($num>0){
					  	for($i=0;$i<$num;$i++){
					    	list($fila_id)=$this->fmt->query->obt_fila($rs);
					    	$nombre_cat=$this->fmt->categoria->nombre_categoria($fila_id);
							$this->fmt->form->categoria_form('Categoria - '.$nombre_cat,'inputCat',$fila_id,"","","");
						}
				      }
				}
				$label[0]="Mostrar Categoria";
				$nombreinput[0]="inputActCat";
				$valor_in[0]="1";
				$campo_in[0]="1";
				$this->fmt->form->input_check_form($label,$nombreinput,$valor_in,$campo_in);
				?>

				<div class="form-group form-botones">
					 <button type="submit" class="btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save" ></i> Guardar</button>
					 <button type="submit" class="btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open" ></i> Activar</button>
				</div>
			</form>
		</div>
		<script>
			$(document).ready(function () {
					var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-ruta-amigable.php";
					$("#inputNombre").keyup(function () {
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
		$this->fmt->class_modulo->script_form("modulos/productos/productos.adm.php",$this->id_mod);
	}


	function ingresar(){
		if ($_POST["btn-accion"]=="activar"){
			$activar=1;
		}
		if ($_POST["btn-accion"]=="guardar"){
			$activar=0;
		}

		if($_POST['inputActCat']=="1"){
			$activar_cat=1;
		}
		else{
			$activar_cat=0;
		}
		if($_POST["inputNombre"]!=""){
			$ingresar ="mod_prod_nombre, mod_prod_ruta_amigable, mod_prod_tags, mod_prod_codigo, mod_prod_modelo,mod_prod_resumen, mod_prod_detalles, mod_prod_especificaciones, mod_prod_disponibilidad, mod_prod_imagen,mod_prod_precio, mod_prod_id_marca, mod_prod_id_doc, mod_prod_id_mul, mod_prod_id_dominio, mod_prod_activar_cat, mod_prod_activar";
			$valores  ="'".$_POST['inputNombre']."','".
										 $_POST['inputNombreAmigable']."','".
										 $_POST['inputTags']."','".
										 $_POST['inputCodigo']."','".
										 $_POST['inputModelo']."','".
										 $_POST['inputResumen']."','".
										 $_POST['inputDetalles']."','".
										 $_POST['inputEspecificaciones']."','".
										 $_POST['inputDisponibilidad']."','".
										 $_POST['inputUrl']."','".
										 $_POST['inputPrecio']."','".
										 $_POST['InputMarca']."','".
										 $_POST['inputDoc']."','".
										 $_POST['inputMul']."','".
										 $_POST['inputDominio']."','".
										 $activar_cat."','".
										 $activar."'";

			$sql="insert into mod_productos (".$ingresar.") values (".$valores.")";
			$this->fmt->query->consulta($sql);

			$sql="select max(mod_prod_id) as id from mod_productos";
			$rs= $this->fmt->query->consulta($sql);
			$fila = $this->fmt->query->obt_fila($rs);
			$id = $fila ["id"];

		  	$sql_upd="UPDATE mod_productos_mul SET mod_pro_mul_id_prod='$id' where mod_pro_mul_id_prod='0'";
		  	$this->fmt->query->consulta($sql_upd);

			$ingresar1 = "mod_prod_rel_prod_id,mod_prod_rel_cat_id";
			$valor_cat=$_POST['inputCat'];
			$num_cat=count( $valor_cat );
			//var_dump($valor_cat);

			for ($i=0; $i<$num_cat;$i++){
				$valores1 = "'".$id."','".$valor_cat[$i]."'";
				$sql1="insert into mod_productos_rel  (".$ingresar1.") values (".$valores1.")";
				$this->fmt->query->consulta($sql1);
			}

			$ingresar2 ="mod_prod_rel_prod_id,mod_prod_rel_doc_id,mod_prod_rel_orden";
			//var_dump($_POST['inputDoc']);
			$valor_doc= $_POST['inputDoc'];
			$num=count( $valor_doc );
			for ($i=0; $i<$num;$i++){
				$valores2 = "'".$_POST['inputId']."','".$valor_doc[$i]."','".$i."'";
				$sql2="insert into mod_productos_rel (".$ingresar2.") values (".$valores2.")";
				$this->fmt->query->consulta($sql2);
			}

			$ingresar3 = "mod_pro_pes_pro_id,mod_pro_pes_pes_id,mod_pro_pes_contenido,mod_pro_pes_orden";
			$valor_cat=$_POST['inputPestana'];
			$num_cat=count( $valor_cat );
			//var_dump($valor_cat);

			for ($i=0; $i<$num_cat;$i++){
				$id_pes=$valor_cat[$i];
				$valores3 = "'".$id."','".$id_pes."','".$_POST["contenido".$id_pes]."','".$_POST["orden_pest".$id_pes]."'";
				$sql1="insert into mod_productos_pestana
  (".$ingresar3.") values (".$valores3.")";
				$this->fmt->query->consulta($sql1);
			}
		}
		header("location: productos.adm.php?id_mod=".$this->id_mod);
	}

	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if($_POST['inputActCat']=="1"){
			$activar_cat=1;
		}
		else{
			$activar_cat=0;
		}
		if ($_POST["btn-accion"]=="actualizar"){
			if($_POST["inputNombre"]!=""){
				$sql="UPDATE mod_productos SET
							mod_prod_nombre='".$_POST['inputNombre']."',
							mod_prod_ruta_amigable ='".$_POST['inputNombreAmigable']."',
							mod_prod_tags ='".$_POST['inputTags']."',
							mod_prod_codigo='".$_POST['inputCodigo']."',
							mod_prod_modelo='".$_POST['inputModelo']."',
							mod_prod_resumen='".$_POST['inputResumen']."',
							mod_prod_detalles='".$_POST['inputDetalles']."',
							mod_prod_especificaciones='".$_POST['inputEspecificaciones']."',
							mod_prod_disponibilidad='".$_POST['inputDisponibilidad']."',
							mod_prod_imagen='".$_POST['inputUrl']."',
							mod_prod_precio='".$_POST['inputPrecio']."',
							mod_prod_id_marca='".$_POST['InputMarca']."',
							mod_prod_id_dominio='".$_POST['inputDominio']."',
							mod_prod_id_doc='".$_POST['inputDoc']."',
							mod_prod_id_mul='".$_POST['inputMul']."',
							mod_prod_activar_cat='".$activar_cat."',
							mod_prod_activar='".$_POST['inputActivar']."'
							WHERE mod_prod_id='".$_POST['inputId']."'";
				//echo $sql;
				$this->fmt->query->consulta($sql);

				$this->fmt->class_modulo->eliminar_fila($_POST['inputId'],"mod_productos_rel","mod_prod_rel_prod_id");  //$valor,$from,$fila

				$ingresar1 = "mod_prod_rel_prod_id,mod_prod_rel_cat_id";
				$valor_cat=$_POST['inputCat'];
				$num_cat=count( $valor_cat );
				//var_dump($valor_cat);

				for ($i=0; $i<$num_cat;$i++){
					$valores1 = "'".$_POST['inputId']."','".$valor_cat[$i]."'";
					$sql1="insert into mod_productos_rel  (".$ingresar1.") values (".$valores1.")";
					$this->fmt->query->consulta($sql1);
				}

				$ingresar2 ="mod_prod_rel_prod_id,mod_prod_rel_doc_id,mod_prod_rel_orden";
				//var_dump($_POST['inputDoc']);
				$valor_doc= $_POST['inputDoc'];
				$num=count( $valor_doc );
				for ($i=0; $i<$num;$i++){
					$valores2 = "'".$_POST['inputId']."','".$valor_doc[$i]."','".$i."'";
					$sql2="insert into mod_productos_rel (".$ingresar2.") values (".$valores2.")";
					$this->fmt->query->consulta($sql2);
				}

				$this->fmt->class_modulo->eliminar_fila($_POST['inputId'],"mod_productos_pestana","mod_pro_pes_pro_id");

				$ingresar3 = "mod_pro_pes_pro_id,mod_pro_pes_pes_id,mod_pro_pes_contenido,mod_pro_pes_orden";
				$valor_cat=$_POST['inputPestana'];
				$num_cat=count( $valor_cat );
				//var_dump($valor_cat);

				for ($i=0; $i<$num_cat;$i++){
					$id_pes=$valor_cat[$i];
					$valores3 = "'".$_POST['inputId']."','".$id_pes."','".$_POST["contenido".$id_pes]."','".$_POST["orden_pest".$id_pes]."'";
					$sql1="insert into mod_productos_pestana
	  (".$ingresar3.") values (".$valores3.")";
					$this->fmt->query->consulta($sql1);
				}
			}
		}
		header("location: productos.adm.php?id_mod=".$this->id_mod);
	}

	function activar(){
		$this->fmt->class_modulo->activar_get_id("mod_productos","mod_prod_");
		header("location: productos.adm.php?id_mod=".$this->id_mod);
	}

	function eliminar(){
		$this->fmt->get->validar_get( $_GET['id'] );
		$id= $_GET['id'];

		$sql="DELETE FROM mod_productos WHERE mod_prod_id='".$id."'";
		$this->fmt->query->consulta($sql);

		$sql="DELETE FROM mod_productos_rel WHERE mod_prod_rel_prod_id='".$id."'";
		$this->fmt->query->consulta($sql);

		$sql="DELETE FROM mod_productos_pestana WHERE mod_pro_pes_pro_id='".$id."'";
		$this->fmt->query->consulta($sql);

		$this->eliminar_mul($id);

		$up_sqr6 = "ALTER TABLE mod_productos AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);

		$up_sqr7 = "ALTER TABLE mod_productos_rel AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr7);



		header("location: productos.adm.php?id_mod=".$this->id_mod);
	}
	function eliminar_mul($id){
		$sql="DELETE FROM mod_productos_mul WHERE mod_pro_mul_id_prod='".$id."'";
		$this->fmt->query->consulta($sql);
		$up_sqr8 = "ALTER TABLE mod_productos_mul AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr8);
	}
}
