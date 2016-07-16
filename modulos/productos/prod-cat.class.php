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
        $this->fmt->categoria->arbol_editable('mod_productos_cat','mod_prod_cat_','modulos/productos/prod-cat.adm.php?id_mod='.$this->id_mod.'&tarea=form_nuevo'); //$select,$from,$where,$orderby,$ul_modulo,$prefijo_activar
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

    $sql="select * from mod_productos_cat where mod_prod_cat_id='".$id."'";
    $rs=$this->fmt->query->consulta($sql);
    $fila=$this->fmt->query->obt_fila($rs);
    ?>
    <div class="body-modulo col-xs-12  col-md-6 col-xs-offset-0 col-md-offset-3">
      <form class="form form-modulo" action="prod-cat.adm.php?tarea=modificar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-editar">
        <div class="form-group" id="mensaje-form"></div>
        <div class="form-group">
          <label>Nombre Categoria</label>
          <input class="form-control input-lg"  id="inputNombre" name="inputNombre" value="<? echo $fila["mod_prod_cat_nombre"]; ?>" placeholder=" " type="text" autofocus />
          <input type="hidden" id="inputId" name="inputId" value="<?php echo $fila["mod_prod_cat_id"]; ?>" />
        </div>
        
        <?php
	        
	    if (!empty($fila['mod_prod_cat_ruta_amigable'])){
			$valor_ra = $fila['mod_prod_cat_ruta_amigable'];
		}else{
			$valor_ra = $this->fmt->get->convertir_url_amigable($fila['mod_prod_cat_nombre']);
		}

		$this->fmt->form->input_form("Nombre Amigable:","inputNombreAmigable","",$valor_ra,"disabled","","","");
	        
	    ?>

        <div class="form-group">
          <label>Descripción</label>
          <textarea class="form-control" rows="2" id="inputDescripcion" name="inputDescripcion" placeholder=""><? echo $fila["mod_prod_cat_descripcion"]; ?></textarea>
        </div>

        <div class="form-group">
          <label>Categoria padre:</label>
          <select class="form-control" id="inputPadre" name="inputPadre">
            <?php $this->fmt->categoria->traer_opciones($fila['mod_prod_cat_id'],'mod_productos_cat','mod_prod_cat_'); ?>
          </select>
        </div>

				<div class="form-group">
          <label>Relación Categoria web:</label>
          <select class="form-control" id="inputCat" name="inputCat">
            <?php $this->fmt->categoria->traer_opciones_cat($fila['mod_prod_cat_idcat']); ?>
          </select>
        </div>

				<div class="form-group">
          <label>Carpeta de archivos:</label>
          <input class="form-control" id="inputArchivos" name="inputArchivos" value="<? echo $fila["mod_prod_cat_archivos"]; ?>" />
        </div>

        <div class="form-group">
          <label>Orden:</label>
          <input class="form-control" id="inputOrden" name="inputOrden" value="<? echo $fila["mod_prod_cat_orden"]; ?>" />
        </div>

        <div class="form-group">
          <label class="radio-inline">
            <input type="radio" name="inputActivar" id="inputActivar" value="0" <?php if ($fila['mod_prod_cat_activar']==0){ echo "checked"; } ?> > Desactivar
          </label>
          <label class="radio-inline">
            <input type="radio" name="inputActivar" id="inputActivar" value="1" <?php if ($fila['mod_prod_cat_activar']==1){ echo "checked"; $aux="Activo"; } else { $aux="Activar"; } ?> > <? echo $aux; ?>
          </label>
        </div>
        <div class="form-group form-botones">
           <button  type="button" class="btn btn-danger btn-eliminar color-bg-rojo-a" idEliminar="<? echo $fila["cat_id"];  ?>" nombreEliminar="<? echo $fila_nombre; ?>" name="btn-accion" id="btn-eliminar" value="eliminar"><i class="icn-trash" ></i> Eliminar Categoria Productos</button>

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
										$("#inputNombreAmigable").val(datos);
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
		?>
		<div class="body-modulo col-xs-12  col-md-6 col-xs-offset-0 col-md-offset-3">
			<form class="form form-modulo" action="prod-cat.adm.php?tarea=ingresar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-nuevo">
				<div class="form-group" id="mensaje-form"></div>
        <div class="form-group">
					<label>Nombre Categoria</label>
					<input class="form-control input-lg required"  id="inputNombre" name="inputNombre" value="" placeholder=" " type="text" autofocus />
				</div>
				
		<?php

		$this->fmt->form->input_form("Nombre Amigable:","inputNombreAmigable","","disabled","","","",""); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
	        
	    ?>

        <div class="form-group">
          <label>Descripción</label>
          <textarea class="form-control" rows="2" id="inputDescripcion" name="inputDescripcion" placeholder=""></textarea>
        </div>

        <div class="form-group">
          <label>Categoria padre:</label>
          <input class="form-control" disabled  placeholder="<?php echo $this->nombre_categoria($id_padre); ?>" />
          <input type="hidden" id="inputPadre" name="inputPadre" value="<?echo $id_padre; ?>">
        </div>

				<div class="form-group">
          <label>Relación Categoria web:</label>
          <select class="form-control" id="inputCat" name="inputCat">
            <?php $this->fmt->categoria->traer_opciones_cat(''); ?>
          </select>
        </div>

				<div class="form-group">
          <label>Carpeta de archivos:</label>
          <input class="form-control" id="inputArchivos" name="inputArchivos" value="" />
        </div>
        <div class="form-group">
          <label>Orden:</label>
          <input class="form-control" id="inputOrden" name="inputOrden" value="0" />
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
										$("#inputNombreAmigable").val(datos);
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
    $ingresar ="mod_prod_cat_nombre, mod_prod_cat_ruta_amigable, mod_prod_cat_descripcion, mod_prod_cat_id_padre, mod_prod_cat_orden,mod_prod_cat_archivos, mod_prod_cat_idcat, mod_prod_cat_activar";
		$valores  ="'".$_POST['inputNombre']."','".
									  $_POST['inputNombreAmigable']."','".
									 $_POST['inputDescripcion']."','".
									 $_POST['inputPadre']."','".
									 $_POST['inputArchivos']."','".
									 $_POST['inputOrden']."','".
									 $_POST['inputCat']."','".
									 $activar."'";

		echo $sql="insert into mod_productos_cat (".$ingresar.") values (".$valores.")";

		$this->fmt->query->consulta($sql);

		header("location: prod-cat.adm.php?id_mod=".$this->id_mod);
  }

  function modificar(){
    if ($_POST["btn-accion"]=="eliminar"){}
    if ($_POST["btn-accion"]=="actualizar"){
      echo $sql="UPDATE mod_productos_cat SET
            mod_prod_cat_nombre='".$_POST['inputNombre']."',
            mod_prod_cat_ruta_amigable='".$_POST['inputNombreAmigable']."',
            mod_prod_cat_descripcion='".$_POST['inputDescripcion']."',
            mod_prod_cat_id_padre='".$_POST['inputPadre']."',
            mod_prod_cat_orden='".$_POST['inputOrden']."',
						mod_prod_cat_archivos='".$_POST['inputArchivos']."',
						mod_prod_cat_idcat='".$_POST['inputCat']."',
            mod_prod_cat_activar='".$_POST['inputActivar']."'
            WHERE mod_prod_cat_id='".$_POST['inputId']."'";
      $this->fmt->query->consulta($sql);
    }
    header("location: prod-cat.adm.php?id_mod=".$this->id_mod);
  }

  function activar(){
    $this->fmt->get->validar_get ( $_GET['estado'] );
    $this->fmt->get->validar_get ( $_GET['id'] );
    $estado = $_GET['estado'];
    if ($estado=='1'){ $estado=0; }else{ $estado=1; }
    $sql="update mod_productos_cat set
        mod_prod_cat_activar='".$estado."' where mod_prod_cat_id='".$_GET['id']."'";
    $this->fmt->query->consulta($sql);
    header("location: prod-cat.adm.php?id_mod=".$this->id_mod);
  }

  function eliminar(){
    $this->fmt->get->validar_get ( $_GET['id'] );
    $id= $_GET['id'];
    $sql="DELETE FROM mod_productos_cat WHERE mod_prod_cat_id='".$id."'";
    $this->fmt->query->consulta($sql);
    $up_sqr6 = "ALTER TABLE mod_productos_cat AUTO_INCREMENT=1";
    $this->fmt->query->consulta($up_sqr6);
    header("location: prod-cat.adm.php?id_mod=".$this->id_mod);
  }

}
