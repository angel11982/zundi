<?php
header("Content-Type: text/html;charset=utf-8");

class CATEGORIAS{

	var $fmt;
	var $id_mod;

	function CATEGORIAS($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

	function busqueda(){
    $this->fmt->class_pagina->crear_head( $this->id_mod,""); // id modulo, botones
    ?>
    <div class="body-modulo">
      <?php $this->fmt->categoria->arbol_editable('categoria','cat_','modulos/categorias/categorias.adm.php?id_mod='.$this->id_mod.'&tarea=form_nuevo'); //$select,$from,$where,$orderby,$ruta_modulo,$prefijo
			?>
    </div>
    <script>
      $(".btn-activar-i").click(function(e){
        var cat = $( this ).attr("cat");
        var estado = $( this ).attr("estado");
        url="categorias.adm.php?tarea=activar&id="+cat+"&estado="+estado+"&id_mod=<?php echo $this->id_mod; ?>";
        //alert(url);
        window.location=(url);
      });
      $(".btn-editar-i").click(function(e){
        var cat = $( this ).attr("cat");
        url="categorias.adm.php?tarea=form_editar&id="+cat+"&id_mod=<?php echo $this->id_mod; ?>";
        //alert(url);
        window.location=(url);
      });
      $(".btn-nuevo-i").click(function(e){
        var cat = $( this ).attr("cat");
        url="categorias.adm.php?tarea=form_nuevo&id_padre="+cat+"&id_mod=<?php echo $this->id_mod; ?>";
        //alert(url);
        window.location=(url);
      });
			$(".btn-contenedores").click(function(e){
				var cat = $( this ).attr("cat");
				url="contenedores.adm.php?tarea=editar_contenidos&cat="+cat;
				//alert(url);
				window.location=(url);
			});
    </script>
    <?php
      $this->fmt->class_modulo->script_form("modulos/categorias/categorias.adm.php",$this->id_mod);
  }

  function form_editar(){
    $botones = $this->fmt->class_pagina->crear_btn("categorias.adm.php?id_mod=$this->id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Editar Categoria", $botones,"");// nombre, botones-left, botones-right
    $this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];

		$sql="select * from categoria	where cat_id='".$id."'";
		$rs=$this->fmt->query->consulta($sql);
		$fila=$this->fmt->query->obt_fila($rs);
		?>
		<div class="body-modulo col-xs-12  col-md-6 col-xs-offset-0 col-md-offset-3">
			<form class="form form-modulo" action="categorias.adm.php?tarea=modificar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-editar">
				<div class="form-group" id="mensaje-form"></div>
        <div class="form-group">
					<label>Nombre Categoria</label>
					<input class="form-control input-lg"  id="inputNombre" name="inputNombre" value="<? echo $fila["cat_nombre"]; ?>" placeholder=" " type="text" autofocus />
					<input type="hidden" id="inputId" name="inputId" value="<?php echo $fila["cat_id"]; ?>" />
				</div>

        <div class="form-group">
          <label>Descripción</label>
          <textarea class="form-control" rows="2" id="inputDescripcion" name="inputDescripcion" placeholder=""><? echo $fila["cat_descripcion"]; ?></textarea>
        </div>

        <div class="form-group">
          <label>Ruta amigable:</label>
          <input class="form-control" id="inputRutaamigable" name="inputRutaamigable" placeholder="" value="<? echo $fila["cat_ruta_amigable"]; ?>" />
        </div>

        <div class="form-group">
          <label>Css Theme:</label>
          <input class="form-control" id="inputTheme" name="inputTheme" placeholder="" value="<? echo $fila["cat_theme"]; ?>" />
        </div>

        <div class="form-group">
          <label>Categoria padre:</label>
          <select class="form-control" id="inputPadre" name="inputPadre">
            <?php $this->fmt->categoria->traer_opciones_cat($fila['cat_id']); ?>
          </select>
        </div>

        <div class="form-group">
          <label>Plantilla principal:</label>
          <select class="form-control" id="inputPlantilla" name="inputPlantilla">
          <?php $this->fmt->plantilla->traer_opciones_plantilla($fila['cat_id_plantilla']); ?>
          </select>
        </div>

        <div class="form-group">
          <a class="btn btn-link" role="button" data-toggle="collapse" href="#collapseAvanzado" aria-expanded="false" aria-controls="collapseAvanzado">
            Avanzado
          </a>
          <div class="collapse" id="collapseAvanzado">
            <div class="well">
              <div class="form-group">
                <label>Imagen:</label>
                <input class="form-control" id="inputImagen" name="inputImagen" placeholder="" value="<? echo $fila["cat_imagen"]; ?>" />
              </div>

              <div class="form-group">
                <label>Icono:</label>
                <input class="form-control" id="inputIcono" name="inputIcono" value="<? echo $fila["cat_icono"]; ?>" />
              </div>

              <div class="form-group">
                <label>Color:</label>
                <input class="form-control" id="inputColor" name="inputColor" value="<? echo $fila["cat_color"]; ?>" />
              </div>

              <div class="form-group">
                <label>Codigos Scripts:</label>
                <textarea class="form-control" rows="4" id="inputCodigos" name="inputCodigos" placeholder=""><? echo $fila["cat_codigos"]; ?></textarea>
              </div>

              <div class="form-group">
                <label>Ruta Css:</label>
                <input class="form-control" rows="4" id="inputCss" name="inputCss" placeholder="" value="<? echo $fila["cat_css"]; ?>" />
              </div>

              <div class="form-group">
                <label>Clase Css:</label>
                <input class="form-control" rows="4" id="inputClase" name="inputClase" placeholder="" value="<? echo $fila["cat_clase"]; ?>" />
              </div>

              <div class="form-group">
                <label>Meta:</label>
                <textarea class="form-control" rows="4" id="inputMeta" name="inputMeta" placeholder=""><? echo $fila["cat_meta"]; ?></textarea>
              </div>

              <div class="form-group">
                <label>Tipo Categoria:</label>
                <select class="form-control" id="inputTipo" name="inputTipo">
                  <?php $this->fmt->categoria->opciones_tipo_cat($fila['cat_id']); ?>
                </select>
              </div>

              <div class="form-group">
                <label>Url:</label>
                <input class="form-control" id="inputUrl" name="inputUrl" placeholder="" value="<? echo $fila["cat_url"]; ?>" />
              </div>

              <div class="form-group">
                <label>Destino:</label>
                <select class="form-control" id="inputDestino" name="inputDestino">
                  <?php $this->fmt->categoria->opciones_destino($fila['cat_destino']); ?>
                </select>
              </div>

              <div class="form-group">
                <label>Favicon:</label>
                <input class="form-control" id="inputFavicon" name="inputFavicon" placeholder="" value="<? echo $fila["cat_favicon"]; ?>" />
              </div>
              <div class="form-group">
                <label>Analitica:</label>
                <input class="form-control" id="inputAnalitica" name="inputAnalitica" placeholder="" value="<? echo $fila["cat_analitica"]; ?>" />
              </div>

              <div class="form-group">
                <label>Ruta Sitio:</label>
                <input class="form-control" id="inputRutasitio" name="inputRutasitio" placeholder="" value="<? echo $fila["cat_ruta_sitio"]; ?>" />
              </div>
							<div class="form-group">
                <label>Id Orden:</label>
                <input class="form-control" id="inputOrden" name="inputOrden" placeholder="" value="<? echo $fila["cat_orden"]; ?>" />
              </div>
            </div>
          </div>
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
					 <button  type="button" class="btn btn-danger btn-eliminar color-bg-rojo-a" idEliminar="<? echo $fila["cat_id"];  ?>" nombreEliminar="<? echo $fila_nombre; ?>" name="btn-accion" id="btn-eliminar" value="eliminar"><i class="icn-trash" ></i> Eliminar Categoria</button>

					 <button type="submit" class="btn btn-info  btn-actualizar hvr-fade btn-lg color-bg-celecte-c btn-lg" name="btn-accion" id="btn-activar" value="actualizar"><i class="icn-sync" ></i> Actualizar</button>
				</div>

      </form>
    </div>
    <?php
    $this->fmt->class_modulo->script_form($this->fmt->query,"modulos/categorias/categorias.adm.php",$this->id_mod);
  }

  function form_nuevo(){
    $botones = $this->fmt->class_pagina->crear_btn("categorias.adm.php?id_mod=$this->id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Nuevo Categoria", $botones,"");// nombre, botones-left, botones-right
    $this->fmt->get->validar_get ( $_GET['id_padre'] );
		$id_padre = $_GET['id_padre'];
		if (empty($id_padre)){
			$id_padre='0';
		}
		?>
		<div class="body-modulo col-xs-12  col-md-6 col-xs-offset-0 col-md-offset-3">
			<form class="form form-modulo" action="categorias.adm.php?tarea=ingresar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-nuevo">
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
        </div>

        <div class="form-group">
          <label>Css Theme:</label>
          <input class="form-control" id="inputTheme" name="inputTheme" placeholder="" value="" />
        </div>

        <div class="form-group">
          <label>Categoria padre:</label>
          <input class="form-control" disabled  placeholder="<?php echo $this->fmt->categoria->nombre_categoria($id_padre); ?>" />
          <input type="hidden" id="inputPadre" name="inputPadre" value="<?echo $id_padre; ?>">
        </div>

        <div class="form-group">
          <label>Plantilla principal:</label>
          <select class="form-control" id="inputPlantilla" name="inputPlantilla">
          <?php $this->fmt->plantilla->traer_opciones_plantilla(""); ?>
          </select>
        </div>

        <div class="form-group">
          <a class="btn btn-link" role="button" data-toggle="collapse" href="#collapseAvanzado" aria-expanded="false" aria-controls="collapseAvanzado">
            Avanzado
          </a>
          <div class="collapse" id="collapseAvanzado">
            <div class="well">
              <div class="form-group">
                <label>Imagen:</label>
                <input class="form-control" id="inputImagen" name="inputImagen" placeholder="" value="" />
              </div>

              <div class="form-group">
                <label>Icono:</label>
                <input class="form-control" id="inputIcono" name="inputIcono" value="" />
              </div>

              <div class="form-group">
                <label>Color:</label>
                <input class="form-control" id="inputColor" name="inputColor" value="" />
              </div>

              <div class="form-group">
                <label>Codigos Scripts:</label>
                <textarea class="form-control" rows="4" id="inputCodigos" name="inputCodigos" placeholder=""></textarea>
              </div>

              <div class="form-group">
                <label>Ruta Css:</label>
                <input class="form-control" rows="4" id="inputCss" name="inputCss" placeholder="" value="" />
              </div>

              <div class="form-group">
                <label>Clase Css:</label>
                <input class="form-control" rows="4" id="inputClase" name="inputClase" placeholder="" value="" />
              </div>

              <div class="form-group">
                <label>Meta:</label>
                <textarea class="form-control" rows="4" id="inputMeta" name="inputMeta" placeholder=""></textarea>
              </div>

              <div class="form-group">
                <label>Tipo Categoria:</label>
                <select class="form-control" id="inputTipo" name="inputTipo">
                  <?php $this->fmt->categoria->opciones_tipo_cat(); ?>
                </select>
              </div>

              <div class="form-group">
                <label>Url:</label>
                <input class="form-control" id="inputUrl" name="inputUrl" placeholder="" value="" />
              </div>

              <div class="form-group">
                <label>Destino:</label>
                <select class="form-control" id="inputDestino" name="inputDestino">
                  <?php $this->fmt->categoria->opciones_destino(""); ?>
                </select>
              </div>

              <div class="form-group">
                <label>Favicon:</label>
                <input class="form-control" id="inputFavicon" name="inputFavicon" placeholder="" value="" />
              </div>
              <div class="form-group">
                <label>Analitica:</label>
                <input class="form-control" id="inputAnalitica" name="inputAnalitica" placeholder="" value="" />
              </div>

              <div class="form-group">
                <label>Ruta Sitio:</label>
                <input class="form-control" id="inputRutasitio" name="inputRutasitio" placeholder="" value="" />
              </div>

            </div>
          </div>
        </div>
        <div class="form-group form-botones">
          <button type="submit" class="btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save" ></i> Guardar</button>
          <button type="submit" class="btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open" ></i> Activar</button>
				</div>

      </form>
    </div>
    <?php
    $this->fmt->class_modulo->script_form($this->fmt->query,"modulos/categorias/categorias.adm.php",$this->id_mod);
  }

  function modificar(){
    if ($_POST["btn-accion"]=="eliminar"){}
    if ($_POST["btn-accion"]=="actualizar"){
      $sql="UPDATE categoria SET
            cat_nombre='".$_POST['inputNombre']."',
            cat_descripcion='".$_POST['inputDescripcion']."',
            cat_ruta_amigable='".$_POST['inputRutaamigable']."',
            cat_imagen ='".$_POST['inputImagen']."',
            cat_icono='".$_POST['inputIcono']."',
            cat_color='".$_POST['inputColor']."',
            cat_codigos='".$_POST['inputCodigos']."',
            cat_css='".$_POST['inputCss']."',
            cat_clase='".$_POST['inputClase']."',
            cat_meta='".$_POST['inputMeta']."',
            cat_theme='".$_POST['inputTheme']."',
            cat_id_padre='".$_POST['inputPadre']."',
            cat_id_plantilla='".$_POST['inputPlantilla']."',
            cat_tipo='".$_POST['inputTipo']."',
            cat_url ='".$_POST['inputUrl']."',
            cat_destino='".$_POST['inputDestino']."',
            cat_favicon='".$_POST['inputFavicon']."',
            cat_analitica='".$_POST['inputAnalitica']."',
            cat_ruta_sitio='".$_POST['inputRutasitio']."',
						cat_orden='".$_POST['inputOrden']."',
            cat_activar='".$_POST['inputActivar']."'
            WHERE cat_id='".$_POST['inputId']."'";
      $this->fmt->query->consulta($sql);
    }
    header("location: categorias.adm.php?id_mod=".$this->id_mod);
  }

  function ingresar(){
    if ($_POST["btn-accion"]=="activar"){
      $activar=1;
    }
    if ($_POST["btn-accion"]=="guardar"){
      $activar=0;
    }
    $ingresar ="cat_nombre, cat_descripcion, cat_ruta_amigable, cat_imagen, cat_icono, cat_color, cat_codigos, cat_css, cat_clase, cat_meta, cat_theme, cat_id_padre, cat_id_plantilla, cat_tipo, cat_url, cat_destino, cat_favicon, cat_analitica, cat_ruta_sitio, cat_activar";
		$valores  ="'".$_POST['inputNombre']."','".
									 $_POST['inputDescripcion']."','".
                   $_POST['inputRutaamigable']."','".
                   $_POST['inputImagen']."','".
                   $_POST['inputIcono']."','".
                   $_POST['inputColor']."','".
                   $_POST['inputCodigos']."','".
                   $_POST['inputCss']."','".
                   $_POST['inputClase']."','".
                   $_POST['inputMeta']."','".
                   $_POST['inputTheme']."','".
                   $_POST['inputPadre']."','".
                   $_POST['inputPlantilla']."','".
                   $_POST['inputTipo']."','".
									 $_POST['inputUrl']."','".
									 $_POST['inputDestino']."','".
									 $_POST['inputFavicon']."','".
									 $_POST['inputAnalitica']."','".
									 $_POST['inputRutasitio']."','".
									 $activar."'";

		echo $sql="insert into categoria (".$ingresar.") values (".$valores.")";

		$this->fmt->query->consulta($sql);

		header("location: categorias.adm.php?id_mod=".$this->id_mod);
  }

  function activar(){
    $this->fmt->get->validar_get ( $_GET['estado'] );
    $this->fmt->get->validar_get ( $_GET['id'] );
    $estado = $_GET['estado'];
    if ($estado=='1'){ $estado=0; }else{ $estado=1; }
      $sql="update categoria set
        cat_activar='".$estado."' where cat_id='".$_GET['id']."'";
    $this->fmt->query->consulta($sql);
    header("location: categorias.adm.php?id_mod=".$this->id_mod);
  }

  function eliminar(){
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id= $_GET['id'];
		$sql="DELETE FROM categoria WHERE cat_id='".$id."'";
		$this->fmt->query->consulta($sql);
		$up_sqr6 = "ALTER TABLE categoria AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);
		header("location: categorias.adm.php?id_mod=".$this->id_mod);
	}
}

?>
