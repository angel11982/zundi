<?php
header("Content-Type: text/html;charset=utf-8");

class PROD_CAT{

	var $fmt;
	var $id_mod;

	function PROD_CAT($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

	function busqueda(){
    $this->fmt->class_pagina->crear_head( $this->id_mod, ""); // id modulo, botones
    ?>
    <div class="body-modulo">
      <?php
      $id_rol = $this->fmt->sesion->get_variable("usu_rol");
      if($id_rol==1)
      	$sql="select categoria_cat_id from modulos_categoria where modulos_mod_id=".$this->id_mod." ORDER BY categoria_cat_id asc";
      else
      	$sql="select rol_rel_cat_id from roles_rel where rol_rel_rol_id=".$id_rol." and rol_rel_cat_id not in (0) ORDER BY rol_rel_cat_id asc";
      $rs =$this->fmt->query->consulta($sql);
	  $num=$this->fmt->query->num_registros($rs);
	  if($num>0){
	  	for($i=0;$i<$num;$i++){
	    	list($fila_id)=$this->fmt->query->obt_fila($rs);
			$this->fmt->categoria->arbol_editable_nodo('categoria','cat_',$fila_id);
		}
      }
	  ?>
    </div>

    <style>
      .btn-contenedores{ display:none; }
    </style>
    <script>
      $(".btn-activar-i").click(function(e){
        var cat = $( this ).attr("cat");
        var estado = $( this ).attr("estado");
        url="prod-cat.adm.php?tarea=activar&id="+cat+"&estado="+estado+"&id_mod=<?php echo $this->id_mod; ?>";
        //alert(url);
        window.location=(url);
      });
      $(".btn-editar-i").click(function(e){
        var cat = $( this ).attr("cat");
        url="prod-cat.adm.php?tarea=form_editar&id="+cat+"&id_mod=<?php echo $this->id_mod; ?>";
        //alert(url);
        window.location=(url);
      });
      $(".btn-nuevo-i").click(function(e){
        var cat = $( this ).attr("cat");

        url="prod-cat.adm.php?tarea=form_nuevo&id_padre="+cat+"&id_mod=<?php echo $this->id_mod; ?>";
        //alert(url);
        window.location=(url);
      });
    </script>
    <style>
      .btn-contenedores{ display:none; }
    </style>
    <?php
    $this->fmt->class_modulo->script_form("modulos/productos/prod-cat.adm.php",$this->id_mod);
  }

  function form_editar(){
    $botones = $this->fmt->class_pagina->crear_btn("prod-cat.adm.php?id_mod=$this->id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
    $this->fmt->class_pagina->crear_head_form("Editar Categoria Productos", $botones,"");// nombre, botones-left, botones-right
    $this->fmt->get->validar_get ( $_GET['id'] );
    $id = $_GET['id'];

    $sql="select * from categoria	where cat_id='".$id."'";
    $rs=$this->fmt->query->consulta($sql);
    $fila=$this->fmt->query->obt_fila($rs);
    ?>
    <div class="body-modulo col-xs-12  col-md-6 col-xs-offset-0 col-md-offset-3">
			<form class="form form-modulo" action="prod-cat.adm.php?tarea=modificar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-nuevo">
				<div class="form-group" id="mensaje-form"></div>
        <div class="form-group">
					<label>Nombre Categoria</label>
					<input class="form-control input-lg required"  id="inputNombre" name="inputNombre" value="<?php echo $fila["cat_nombre"]; ?>" placeholder=" " type="text" autofocus />
					<input type="hidden" id="inputId" name="inputId" value="<?php echo $fila["cat_id"]; ?>" />
				</div>

        <div class="form-group">
          <label>Descripción</label>
          <textarea class="form-control" rows="2" id="inputDescripcion" name="inputDescripcion" placeholder=""><?php echo $fila["cat_descripcion"]; ?></textarea>
        </div>

        <div class="form-group">
          <label>Ruta amigable:</label>
          <input class="form-control" id="inputRutaamigable" name="inputRutaamigable" placeholder="" value="<?php echo $fila["cat_ruta_amigable"]; ?>" />

        </div>

        <div class="form-group">
          <label class="radio-inline">
            <input type="radio" name="inputActivar" id="inputActivar" value="0" <?php if ($fila['cat_activar']==0){ echo "checked"; } ?> > Desactivar
          </label>
          <label class="radio-inline">
            <input type="radio" name="inputActivar" id="inputActivar" value="1" <?php if ($fila['cat_activar']==1){ echo "checked"; $aux="Activo"; } else { $aux="Activar"; } ?> > <? echo $aux; ?>
          </label>
        </div>
        <div class="form-group form-botones">

           <button type="submit" class="btn btn-info  btn-actualizar hvr-fade btn-lg color-bg-celecte-c btn-lg" name="btn-accion" id="btn-activar" value="actualizar"><i class="icn-sync" ></i> Actualizar</button>
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
										$("#inputRutaamigable").val(datos);
									}
							});
					});

			});
		</script>
    <?php
    $this->fmt->class_modulo->script_form($this->fmt->query,"modulos/categorias/categorias.adm.php",$this->id_mod);
  }

  function form_nuevo(){
    $botones = $this->fmt->class_pagina->crear_btn("prod-cat.adm.php?id_mod=$this->id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Nuevo Categoria Producto", $botones,"");// nombre, botones-left, botones-right
		$this->fmt->get->validar_get ( $_GET['id_padre'] );
		$id_padre = $_GET['id_padre'];

		if (empty($id_padre)){
			$id_padre='0';
		}

		$sql="select cat_theme, cat_id_plantilla from categoria where cat_id=".$id_padre;
		$rs =$this->fmt->query->consulta($sql);
		list($fila_theme, $fila_plant)=$this->fmt->query->obt_fila($rs);


		?>
		<div class="body-modulo col-xs-12  col-md-6 col-xs-offset-0 col-md-offset-3">
			<form class="form form-modulo" action="prod-cat.adm.php?tarea=ingresar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-nuevo">
				<div class="form-group" id="mensaje-form"></div>
        <div class="form-group">
					<label>Nombre Categoria</label>
					<input class="form-control input-lg required"  id="inputNombre" name="inputNombre" value="" placeholder=" " type="text" autofocus />
				</div>

        <div class="form-group">
          <label>Descripción</label>
          <textarea class="form-control" rows="2" id="inputDescripcion" name="inputDescripcion" placeholder=""></textarea>
        </div>

        <div class="form-group">
          <label>Ruta amigable:</label>
          <input class="form-control" id="inputRutaamigable" name="inputRutaamigable" placeholder="" value="" />
          <input type="hidden" id="inputTheme" name="inputTheme" value="<?php echo $fila_theme; ?>" />
          <input type="hidden" id="inputPadre" name="inputPadre" value="<?echo $id_padre; ?>">
          <input type="hidden" id="inputPlantilla" name="inputPlantilla" value="<?echo $fila_plant; ?>">
        </div>

        <div class="form-group form-botones">
          <button type="submit" class="btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save" ></i> Guardar</button>
          <button type="submit" class="btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open" ></i> Activar</button>
				</div>

      </form>
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
										$("#inputRutaamigable").val(datos);
									}
							});
					});

			});
		</script>
    </div>
    <?php
    $this->fmt->class_modulo->script_form($this->fmt->query,"modulos/productos/prod-cat.adm.php",$this->id_mod);
  }

  function nombre_categoria($cat){
    if ($cat==0){
      return 'no definido (0)';
    }
    $this->fmt->get->validar_get($cat);
    $consulta = "SELECT mod_prod_cat_nombre FROM mod_productos_cat WHERE mod_prod_cat_id='$cat' ";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    $nombre=$fila["mod_prod_cat_nombre"];
    return $nombre;

  }

  function ingresar(){
    if ($_POST["btn-accion"]=="activar"){
      $activar=1;
    }
    if ($_POST["btn-accion"]=="guardar"){
      $activar=0;
    }
    $ingresar ="cat_nombre, cat_descripcion, cat_ruta_amigable, cat_theme, cat_id_padre, cat_id_plantilla, cat_activar";
	$valores  ="'".$_POST['inputNombre']."','".
				   $_POST['inputDescripcion']."','".
                   $_POST['inputRutaamigable']."','".
                   $_POST['inputTheme']."','".
                   $_POST['inputPadre']."','".
                   $_POST['inputPlantilla']."','".
                   $activar."'";

	$sql="insert into categoria (".$ingresar.") values (".$valores.")";

	$this->fmt->query->consulta($sql);

	header("location: prod-cat.adm.php?id_mod=".$this->id_mod);
  }

  function modificar(){
    if ($_POST["btn-accion"]=="eliminar"){}
    if ($_POST["btn-accion"]=="actualizar"){
      $sql="UPDATE categoria SET
            cat_nombre='".$_POST['inputNombre']."',
            cat_descripcion='".$_POST['inputDescripcion']."',
            cat_ruta_amigable='".$_POST['inputRutaamigable']."',
            cat_activar='".$_POST['inputActivar']."'
            WHERE cat_id='".$_POST['inputId']."'";
      $this->fmt->query->consulta($sql);
    }
    header("location: prod-cat.adm.php?id_mod=".$this->id_mod);
  }

  function activar(){
    $this->fmt->get->validar_get ( $_GET['estado'] );
    $this->fmt->get->validar_get ( $_GET['id'] );
    $estado = $_GET['estado'];
    if ($estado=='1'){ $estado=0; }else{ $estado=1; }
    $sql="update categoria set cat_activar='".$estado."' where cat_id='".$_GET['id']."'";
    $this->fmt->query->consulta($sql);
    header("location: prod-cat.adm.php?id_mod=".$this->id_mod);
  }

  function eliminar(){
    $this->fmt->get->validar_get ( $_GET['id'] );
    $id= $_GET['id'];
    $sql="DELETE FROM categoria WHERE cat_id='".$id."'";
    $this->fmt->query->consulta($sql);
    $up_sqr6 = "ALTER TABLE categoria AUTO_INCREMENT=1";
    $this->fmt->query->consulta($up_sqr6);
    header("location: prod-cat.adm.php?id_mod=".$this->id_mod);
  }

}
