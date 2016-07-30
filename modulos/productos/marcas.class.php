<?php
header("Content-Type: text/html;charset=utf-8");

class MARCAS{

	var $fmt;
	var $id_mod;

	function MARCAS($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

	function busqueda(){
		$botones .= $this->fmt->class_pagina->crear_btn("marcas.adm.php?tarea=form_nuevo&id_mod=$this->id_mod","btn btn-primary","icn-plus","Nueva Marca");

		$this->fmt->class_pagina->crear_head( $this->id_mod,$botones); // bd, id modulo, botones
		$this->fmt->class_modulo->script_form("modulos/productos/marcas.adm.php",$this->id_mod);
		?>
    <div class="body-modulo">
    <div class="table-responsive">
      <table class="table table-hover" id="table_id">
        <thead>
          <tr>
            <th style="width:10%" >Imagen</th>
            <th>Nombre de la marca</th>
            <th>Categoria/s</th>
            <th class="estado">Publicación</th>
            <th class="col-xl-offset-2 acciones">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql="select mod_prod_mar_id, mod_prod_mar_nombre, mod_prod_mar_imagen,  mod_prod_mar_id_dominio, mod_prod_mar_activar from mod_productos_marcas ORDER BY mod_prod_mar_id desc";
            $rs =$this->fmt->query->consulta($sql);
            $num=$this->fmt->query->num_registros($rs);
            if($num>0){
            for($i=0;$i<$num;$i++){
              list($fila_id,$fila_nombre,$fila_imagen,$fila_dominio,$fila_activar)=$this->fmt->query->obt_fila($rs);
							if (empty($fila_dominio)){ $aux=_RUTA_WEB_temp; } else { $aux = $this->fmt->categoria->traer_dominio_cat_id($fila_dominio); }

							$img=$this->fmt->archivos->convertir_url_thumb( $fila_imagen );
							$url ="marcas.adm.php?tarea=form_editar&id=".$fila_id."&id_mod=".$this->id_mod;
            ?>
            <tr>
              <td><img class="img-responsive" width="60px" src="<?php echo $aux.$img; ?>" alt="" /></td>
              <td><strong><a href="<? echo $url; ?>" ><?php echo $fila_nombre; ?></a></strong></td>
              <td><?php	$this->traer_rel_cat_nombres($fila_id); ?> </td>
              <td><?php $this->fmt->class_modulo->estado_publicacion($fila_activar,"modulos/modulos/modulos.adm.php", $this->id_mod,$aux, $fila_id ); ?></td>
              <td>

                <a  id="btn-editar-modulo" class="btn btn-accion btn-editar" href="<? echo $url; ?>" title="Editar <? echo $fila_id."-".$fila_url; ?>" ><i class="icn-pencil"></i></a>
                <a  title="eliminar <? echo $fila_id; ?>" type="button" idEliminar="<? echo $fila_id; ?>" nombreEliminar="<? echo $fila_nombre; ?>" class="btn btn-eliminar btn-accion"><i class="icn-trash"></i></a>
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
	  $consulta = "SELECT cat_id, cat_nombre FROM categoria, mod_productos_rel WHERE mod_prod_rel_mar_id='".$fila_id."' and cat_id = mod_prod_rel_cat_id";
		$rs = $this->fmt->query->consulta($consulta);
		$num=$this->fmt->query->num_registros($rs);
		if ($num>0){
			for ($i=0;$i<$num;$i++){
				list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
				echo "- ".$fila_nombre." <br/>";
			}
		}
  }
  function form_nuevo(){
    $this->fmt->form->head_nuevo('Nueva Marca','marcas',$this->id_mod,'','form_nuevo','form_marca',''); //$nom,$archivo,$id_mod,$botones,$id_form,$class,$modo
    $this->fmt->form->input_form('Nombre de la marca:','inputNombre','','','requerido requerido-texto input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
    $this->fmt->form->textarea_form('Detalles:','inputDetalles','','','','','3','','');
    $this->fmt->form->input_form('Ruta amigable:','inputRutaAmigable','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
    ?>
    <div class="form-group">
			<label>Imagen:</label>
			<div class="panel panel-default" >
				<div class="panel-body">
        <?php
        $this->fmt->form->file_form_seleccion('Cargar Archivo (max 8MB) 250x160px','','form_nuevo','form-file','','box-file-form','archivos/marca','130x60');  //$nom,$ruta,$id_form,$class,$class_div,$id_div
        ?>
        </div>
      </div>
    </div>

    <?php
    	$usuario = $this->fmt->sesion->get_variable('usu_id');
		$usuario_n = $this->fmt->sesion->get_variable('usu_nombre');
		$this->fmt->form->categoria_form('Categoria','inputCat',"0","","",""); //$label,$id,$cat_raiz,$cat_valor,$class,$class_div
    	$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');
	    $this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$this->fmt->form->input_form('Orden:','inputOrden','','0','','','');

    ?>
    <div class="form-group form-botones">
       <button type="button" class="btn-accion-form btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save"></i> Guardar</button>
       <button type="button" class="btn-accion-form btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open"></i> Activar</button>
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
										$("#inputRutaAmigable").val(datos);
									}
							});
					});

            $(".form-file").on("change", function(){
            var formData = new FormData($("#form_nuevo")[0]);
            var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload-mul.php";
            $("#respuesta").toggleClass('respuesta-form');
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                  var xhr = $.ajaxSettings.xhr();
                  xhr.upload.onprogress = function(e) {
                    var dat = Math.floor(e.loaded / e.total *100);
                    //console.log(Math.floor(e.loaded / e.total *100) + '%');
                    $("#prog").html('<div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'+ dat +'" aria-valuemin="0" aria-valuemax="100" style="width: '+ dat +'%;">'+ dat +'%</div></div>');
                  };
                  return xhr;
                },
                success: function(datos){
                  $("#respuesta").html(datos);
                }
              });
            });

            $("#btn-guardar").click(function(){
	           if($("#inputArchivos").val()!="")
	           	guardar_thumb();
	           else
	           	sumitform();
            });
			$("#btn-activar").click(function(){
	           if($("#inputArchivos").val()!="")
	           	guardar_thumb();
	           else
	           	sumitform();
            });

			});
			function guardar_thumb(){
				size = 'viewport';
				$('.demo').croppie('result', {
				type: 'canvas',
				size: size
				}).then(function (resp) {

					var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-save-thumb-mul.php";
					var ruta_url = $("#inputUrl").val();
					var nombre = $("#inputNombreArchivo").val();
					var ext = $("#inputTipo").val();

					datos = [{name: "imagen", value: resp},{name: "dir", value: ruta_url},{name: "nombre", value: nombre},{name: "ext", value: ext}];
					$.ajax({
						url: ruta,
						type: 'post',
						data: datos,
						success: function(data) {
							$("#form_nuevo").submit();
						}
					});
				});
			}
			function sumitform(){
				$("#form_nuevo").submit();

			}
		</script>
    <?php
    $this->fmt->class_modulo->script_form("modulos/productos/marcas.adm.php",$this->id_mod);
    $this->fmt->form->footer_page();
  }

  function ingresar($modo){
  	if ($_POST["btn-accion"]=="activar"){
		$activar=1;
	}
	if ($_POST["btn-accion"]=="guardar"){
		$activar=0;
	}
	$ingresar ="mod_prod_mar_nombre,
                mod_prod_mar_ruta_amigable,
                mod_prod_mar_imagen,
                mod_prod_mar_usuario,
                mod_prod_mar_detalle,
                mod_prod_mar_id_dominio,
                mod_prod_mar_activar";
	$valores  ="'".$_POST['inputNombre']."','".
				$_POST['inputRutaAmigable']."','".
				$_POST['inputUrl']."','".
				$_POST['inputUsuario']."','".
				$_POST['inputDetalles']."','".
				$_POST['inputDominio']."','".
				$activar."'";
	$sql="insert into mod_productos_marcas (".$ingresar.") values (".$valores.")";
	$this->fmt->query->consulta($sql);

	$sql="select max(mod_prod_mar_id) as id from mod_productos_marcas";
	$rs= $this->fmt->query->consulta($sql);
	$fila = $this->fmt->query->obt_fila($rs);
	$id = $fila ["id"];
	$ingresar1 ="mod_prod_rel_mar_id, mod_prod_rel_cat_id, mod_prod_rel_orden";
	$valor_cat= $_POST['inputCat'];
	$num=count( $valor_cat );
	for ($i=0; $i<$num;$i++){
		$valores1 = "'".$id."','".$valor_cat[$i]."','".$_POST["inputOrden"]."'";
		$sql1="insert into mod_productos_rel (".$ingresar1.") values (".$valores1.")";
		$this->fmt->query->consulta($sql1);
	}
	if (empty($modo)){
		header("location: marcas.adm.php?id_mod=".$this->id_mod);
	}else if ($modo=="modal"){
		echo $this->fmt->mensaje->documento_subido();
		echo "<div class='otro-nuevo'><i class='icn-plus'></i> <a href='marcas.adm.php?tarea=form_nuevo' > Agregar otra nueva marca. </a></div>";
	}

  }
  function form_editar(){
	  $this->fmt->get->validar_get ( $_GET['id'] );
	  $id = $_GET['id'];
	  $consulta= "SELECT * FROM mod_productos_marcas WHERE mod_prod_mar_id='".$id."'";
	  $rs =$this->fmt->query->consulta($consulta);
	  $fila=$this->fmt->query->obt_fila($rs);
	  $this->fmt->form->head_editar('Editar marca','marcas',$this->id_mod,'','form_editar'); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
	  $this->fmt->form->input_hidden_form("inputId",$id);

	  $this->fmt->form->input_form('Nombre de la marca:','inputNombre','',$fila['mod_prod_mar_nombre'],'requerido requerido-texto input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
    $this->fmt->form->textarea_form('Detalles:','inputDetalles','',$fila['mod_prod_mar_detalle'],'','','3','','');
    $this->fmt->form->input_form('Ruta amigable:','inputRutaAmigable','',$fila['mod_prod_mar_ruta_amigable'],'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
    ?>
    <div class="form-group">
			<label>Imagen:</label>
			<div class="panel panel-default" >
				<div class="panel-body">
        <?php


        $this->fmt->form->file_form_seleccion('Cargar Archivo (max 8MB) 250x160px','','form_nuevo','form-file','','box-file-form','archivos/marca','130x60');  //$nom,$ruta,$id_form,$class,$class_div,$id_div
        ?>
        </div>
      </div>
    </div>

    <?php
    	$usuario = $this->fmt->sesion->get_variable('usu_id');
		$usuario_n = $this->fmt->sesion->get_variable('usu_nombre');
		$cats_id = $this->fmt->categoria->traer_rel_cat_id($id,'mod_productos_rel','mod_prod_rel_cat_id','mod_prod_rel_mar_id'); //$fila_id,$from,$prefijo_cat,$prefijo_rel

		$this->fmt->form->categoria_form('Categoria','inputCat',"0",$cats_id,"",""); //$label,$id,$cat_raiz,$cat_valor,$class,$class_div
    	$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');
	    $this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$this->fmt->form->input_form('Orden:','inputOrden','','0','','','');
		?>
    <div class="form-group form-botones">
       <button type="button" class="btn-accion-form btn btn-info  btn-actualizar hvr-fade btn-lg color-bg-celecte-c btn-lg " name="btn-accion" id="btn-activar" value="actualizar"><i class="icn-sync"></i> Actualizar</button>
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
										$("#inputRutaAmigable").val(datos);
									}
							});
					});

            $(".form-file").on("change", function(){
            var formData = new FormData($("#form_editar")[0]);
            var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload-mul.php";
            $("#respuesta").toggleClass('respuesta-form');
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                  var xhr = $.ajaxSettings.xhr();
                  xhr.upload.onprogress = function(e) {
                    var dat = Math.floor(e.loaded / e.total *100);
                    //console.log(Math.floor(e.loaded / e.total *100) + '%');
                    $("#prog").html('<div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'+ dat +'" aria-valuemin="0" aria-valuemax="100" style="width: '+ dat +'%;">'+ dat +'%</div></div>');
                  };
                  return xhr;
                },
                success: function(datos){
                  $("#respuesta").html(datos);
                }
              });
            });


			$("#btn-activar").click(function(){
	           if($("#inputArchivos").val()!="")
	           	guardar_thumb();
	           else
	           	sumitform();
            });

			});
			function guardar_thumb(){
				size = 'viewport';
				$('.demo').croppie('result', {
				type: 'canvas',
				size: size
				}).then(function (resp) {

					var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-save-thumb-mul.php";
					var ruta_url = $("#inputUrl").val();
					var nombre = $("#inputNombreArchivo").val();
					var ext = $("#inputTipo").val();

					datos = [{name: "imagen", value: resp},{name: "dir", value: ruta_url},{name: "nombre", value: nombre},{name: "ext", value: ext}];
					$.ajax({
						url: ruta,
						type: 'post',
						data: datos,
						success: function(data) {
							$("#form_editar").submit();
						}
					});
				});
			}
			function sumitform(){
				$("#form_editar").submit();

			}
		</script>
    <?php
	$this->fmt->class_modulo->script_form("modulos/productos/marcas.adm.php",$this->id_mod);
    $this->fmt->form->footer_page();
  }
  function modificar(){

	   	$imagen="";
	  	if($_FILES["inputArchivos"]["name"]!=""){
		  	$imagen = "mod_prod_mar_imagen ='".$_POST['inputUrl']."',mod_prod_mar_id_dominio='".$_POST['inputDominio']."',";
	  	}

			$sql="UPDATE mod_productos_marcas SET
						mod_prod_mar_nombre='".$_POST['inputNombre']."',
						mod_prod_mar_ruta_amigable ='".$_POST['inputRutaAmigable']."',
						".$imagen."
						mod_prod_mar_usuario='".$_POST['inputUsuario']."',
						mod_prod_mar_detalle='".$_POST['inputDetalles']."'


						WHERE mod_prod_mar_id='".$_POST['inputId']."'";
			echo $sql;
			$this->fmt->query->consulta($sql);

			$this->fmt->class_modulo->eliminar_fila($_POST['inputId'],"mod_productos_rel","mod_prod_rel_mar_id");  //$valor,$from,$fila

			$ingresar1 ="mod_prod_rel_mar_id, mod_prod_rel_cat_id, mod_prod_rel_orden";
			$valor_cat= $_POST['inputCat'];
			$num=count( $valor_cat );
			for ($i=0; $i<$num;$i++){
				$valores1 = "'".$_POST['inputId']."','".$valor_cat[$i]."','".$_POST["inputOrden"]."'";
				$sql1="insert into mod_productos_rel (".$ingresar1.") values (".$valores1.")";
				$this->fmt->query->consulta($sql1);
			}


		header("location: marcas.adm.php?id_mod=".$this->id_mod);
  }
  function activar(){
	  $this->fmt->class_modulo->activar_get_id("mod_productos_marcas","mod_prod_mar_");
	  header("location: marcas.adm.php?id_mod=".$this->id_mod);
  }

  function eliminar(){
  		$this->fmt->class_modulo->eliminar_get_id("mod_productos_rel","mod_prod_rel_mar_");
  		$this->fmt->class_modulo->eliminar_get_id("mod_productos_marcas","mod_prod_mar_");
  		header("location: marcas.adm.php?id_mod=".$this->id_mod);
  }
}
