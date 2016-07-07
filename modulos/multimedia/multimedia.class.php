<?php
header("Content-Type: text/html;charset=utf-8");

class MULTIMEDIA{

	var $fmt;
	var $id_mod;

	function MULTIMEDIA($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

  function busqueda(){
    $this->fmt->form->head_busqueda_simple('Archivo','multimedia',$this->id_mod,''); //$nom,$archivo,$id_mod,$botones
    $this->fmt->form->head_table();
    $this->fmt->form->thead_table('Previo:Archivo:Autor:Categoria:Fecha:Estado:Acciones');
    $this->fmt->form->tbody_table_open();
		$consulta = "SELECT mul_id,mul_nombre,mul_url,mul_tipo_archivo,mul_id_dominio,mul_usuario,mul_fecha, mul_orden, mul_activar FROM multimedia ORDER BY mul_id desc";
		$rs =$this->fmt->query->consulta($consulta);
		$num=$this->fmt->query->num_registros($rs);
		if($num>0){
		  for($i=0;$i<$num;$i++){
		    list($fila_id,$fila_nombre,$fila_url,$fila_tipo,$fila_dominio,$fila_usuario,$fila_fecha,$fila_orden,$fila_activar)=$this->fmt->query->obt_fila($rs);
				echo "<tr>";
		      echo '<td class="">';
					//echo $fila_url;
					//echo $fila_dominio;
					if (empty($fila_dominio)){ $aux=_RUTA_WEB_temp; } else { $aux = $this->fmt->categoria->traer_dominio_cat_id($fila_dominio); }
					$img=$this->fmt->archivos->convertir_url_thumb( $fila_url );
		      echo '<img src="'.$aux.$img.'" width="60px">';
		      echo '</td>';
					echo '<td class=""><strong>'.$fila_nombre.'</strong> ( '.$fila_tipo.' orden: '.$fila_orden.' )</td>';
					echo '<td class="">'.$this->fmt->usuario->nombre_usuario( $fila_usuario ).'</td>';
					echo '<td class="">';
						$this->fmt->categoria->traer_rel_cat_nombres($fila_id,'multimedia_rel','mul_rel_cat_id','mul_rel_mul_id'); //$fila_id,$from,$prefijo_cat,$prefijo_rel
					echo '</td>';
					echo '<td class="">'.$fila_fecha.'</td>';
					echo '<td class="">';
						$this->fmt->class_modulo->estado_publicacion($fila_activar,"modulos/multimedia/multimedia.adm.php", $this->id_mod,$aux,$fila_id );
					echo '</td>';
					?>
					<td class="td-user col-xl-offset-2 acciones">
						<a  id="btn-editar-modulo" class="btn btn-accion btn-editar <?php echo $aux; ?>" href="multimedia.adm.php?tarea=form_editar&id=<? echo $fila_id; ?>&id_mod=<? echo $this->id_mod; ?>" title="Editar <? echo $fila_id."-".$fila_url; ?>" ><i class="icn-pencil"></i></a>
						<a  title="eliminar <? echo $fila_id; ?>" type="button" idEliminar="<? echo $fila_id; ?>" nombreEliminar="<? echo $fila_nombre; ?>"   class="btn btn-eliminar btn-accion <?php echo $aux; ?>"><i class="icn-trash"></i></a>
					</td>
					<?php
		    echo "</tr>";
		  }
		}
    $this->fmt->form->tbody_table_close();
		$this->fmt->class_modulo->script_form("modulos/multimedia/multimedia.adm.php",$this->id_mod);
    $this->fmt->form->footer_table();
    $this->fmt->form->footer_page();
  }

  function form_nuevo(){
    $this->fmt->form->head_nuevo('Archivo','multimedia',$this->id_mod,'','form_nuevo'); //$nom,$archivo,$id_mod,$botones,$id_form
		?>
		<div class="form-group">
			<label>Archivo Multimedia:</label>
			<div class="panel panel-default" >
				<div class="panel-body">
		<?php
    $this->fmt->form->file_form_seleccion('Cargar Archivo (max 8MB)','','form_nuevo','form-file','','box-file-form','multimedia');  //$nom,$ruta,$id_form,$class,$class_div,$id_div
		?>
				</div>
			</div>
		</div>
		<?
    $this->fmt->form->categoria_form('Categoria','inputCat',"0","","",""); //$label,$id,$cat_raiz,$cat_valor,$class,$class_div
		$fecha=$this->fmt->class_modulo->fecha_hoy('America/La_Paz');
		$this->fmt->form->input_form_sololectura('Fecha:','inputFecha','',$fecha,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$usuario = $this->fmt->sesion->get_variable('usu_id');
		$usuario_n = $this->fmt->sesion->get_variable('usu_nombre');
		$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$this->fmt->form->input_form('Orden:','inputOrden','','0','','','');
    $this->fmt->form->botones_nuevo();
		?>
		<script>
      $(function(){
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
      });
    </script>
		<?php
    $this->fmt->form->footer_page();
  }

	function form_editar(){
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];
		$consulta= "SELECT * FROM multimedia WHERE mul_id='".$id."'";
		$rs =$this->fmt->query->consulta($consulta);
		$fila=$this->fmt->query->obt_fila($rs);

		$this->fmt->form->head_editar('Editar archivo','multimedia',$this->id_mod,'','form_editar');
		$this->fmt->form->input_hidden_form("inputId",$id);
		?>
		<div class="form-group">
			<label>Archivo Multimedia:</label>
			<div class="panel panel-default" >
				<div class="panel-body">
		<?php
		$this->fmt->form->file_form_seleccion('Cargar Archivo (max 8MB)','','form_editar','form-file','','box-file-form','multimedia');
		?>
				</div>
			</div>
		</div>
		<?php
		$cats_id = $this->fmt->categoria->traer_rel_cat_id($id,'multimedia_rel','mul_rel_cat_id','mul_rel_mul_id');
		$this->fmt->form->input_form("<span class='obligatorio'>*</span> Nombre archivo:","inputNombre","",$fila['mul_nombre'],"","","En minúsculas");
		$this->fmt->form->input_form('Url archivo:','inputUrl','',$fila['mul_url'],'');
		$this->fmt->form->input_form('Tipo archivo:','inputTipo','',$fila['mul_tipo_archivo'],'');
		$this->fmt->form->input_form('Leyenda:','inputLeyenda','',$fila['mul_leyenda'],'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('Texto Alternativo:','inputTextoalternativo','',$fila['mul_texto_alternativo'],'','','');
		$this->fmt->form->textarea_form('Descripción:','inputDescripcion','',$fila['mul_descripcion'],'','3',''); //$label,$id,$placeholder,$valor,$class,$class_div,$rows,$mensaje
		$this->fmt->form->input_form('Dimensión:','inputDimension','',$fila['mul_dimension'],'','','');
		$this->fmt->form->input_form('Tamaño:','inputTamano','',$fila['mul_tamano'],'','','');
		$this->fmt->form->input_form('Dominio:','inputDominio','',$this->fmt->categoria->traer_dominio_cat_id($fila['mul_id_dominio']),'','','');
		$this->fmt->form->categoria_form('Categoria','inputCat',"0",$cats_id,"","");
		//$label,$id,$cat_raiz,$cat_valor,$class,$class_div
		$fecha=$this->fmt->class_modulo->fecha_hoy('America/La_Paz');
		$this->fmt->form->input_form_sololectura('Fecha:','inputFecha','',$fecha,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$usuario = $this->fmt->sesion->get_variable('usu_id');
		$usuario_n = $this->fmt->sesion->get_variable('usu_nombre');
		$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$this->fmt->form->input_form('Orden:','inputOrden','',$fila['mul_orden'],'','','');
		$this->fmt->form->radio_activar_form($fila['mul_activar']);
		$this->fmt->form->botones_editar($fila['mul_id'],$fila['mul_nombre'],'Archivo');//$fila_id,$fila_nombre,$nombre
    $this->fmt->class_modulo->script_form("modulos/multimedia/multimedia.adm.php",$this->id_mod);

		?>
		<script>
      $(function(){
				$("#respuesta").html('<?php echo '<img src="'.$this->fmt->categoria->traer_dominio_cat_id($fila['mul_id_dominio']).$fila['mul_url'].'" class="img-responsive" />';?>');
        $(".form-file").on("change", function(){
        var formData = new FormData($("#form_editar")[0]);
        var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload-mul.php";
        $("#respuesta").toggleClass('respuesta-form');
        $("#respuesta").html('');
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
						  var myarr = datos.split(",");
							var num = myarr.length;
							if (myarr[0]=="editar"){
								//alert("termino");
								var i;
								var url = myarr[1];
								for (i = 2; i < num; i++) {
									var datx = myarr[i].split('^');
									var dx = datx[1];
									//datosx += dat[0]+'-'+dat[1]+"<br/>";
									$("#"+datx[0]).val(datx[1]); //cambia los valores por los nuevos
								}
								var datosx='<img src="'+ dx + url +'" class="img-responsive">';

								$("#respuesta").html(datosx);
							}else{
              	$("#respuesta").html(datos);
							}
            }
          });
        });
      });
    </script>
		<?php
  	$this->fmt->form->footer_page();
	}

  function ingresar(){
		if ($_POST["btn-accion"]=="activar"){
			$activar=1;
		}
		if ($_POST["btn-accion"]=="guardar"){
			$activar=0;
		}
		$ingresar ="mul_nombre,mul_url,mul_tipo_archivo,mul_leyenda,mul_texto_alternativo,mul_descripcion,mul_dimension,mul_tamano,mul_id_dominio,mul_fecha,mul_usuario,mul_orden,mul_activar";
		$valores  ="'".$_POST['inputNombre']."','".
									 $_POST['inputUrl']."','".
									 $_POST['inputTipo']."','".
									 $_POST['inputLeyenda']."','".
									 $_POST['inputTextoalternativo']."','".
									 $_POST['inputDescripcion']."','".
									 $_POST['inputDimension']."','".
									 $_POST['inputTamano']."','".
									 $_POST['inputDominio']."','".
									 $_POST['inputFecha']."','".
									 $_POST['inputUsuario']."','".
									 $_POST['inputOrden']."','".
									 $activar."'";

		$sql="insert into multimedia (".$ingresar.") values (".$valores.")";
		$this->fmt->query->consulta($sql);

		$sql="select max(mul_id) as id from multimedia";
		$rs= $this->fmt->query->consulta($sql);
		$fila = $this->fmt->query->obt_fila($rs);
	  $id = $fila ["id"];
		$ingresar1 ="mul_rel_mul_id, mul_rel_cat_id";
		$valor_cat= $_POST['inputCat'];
		$num=count( $valor_cat );
		for ($i=0; $i<$num;$i++){
			$valores1 = "'".$id."','".$valor_cat[$i]."'";
			$sql1="insert into multimedia_rel (".$ingresar1.") values (".$valores1.")";
			$this->fmt->query->consulta($sql1);
		}
		//echo "multimedia.adm.php?id_mod=".$this->id_mod;
		header("location: multimedia.adm.php?id_mod=".$this->id_mod);
	}

	function activar(){
    $this->fmt->get->validar_get ( $_GET['estado'] );
    $this->fmt->get->validar_get ( $_GET['id'] );
    $sql="update multimedia set
        mul_activar='".$_GET['estado']."' where mul_id='".$_GET['id']."'";
    $this->fmt->query->consulta($sql);
    header("location: multimedia.adm.php?id_mod=".$this->id_mod);
  }

	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){

			$sql="UPDATE multimedia SET
						mul_nombre='".$_POST['inputNombre']."',
						mul_url ='".$_POST['inputUrl']."',
						mul_tipo_archivo='".$_POST['inputTipo']."',
						mul_leyenda='".$_POST['inputLeyenda']."',
						mul_texto_alternativo='".$_POST['inputTextoalternativo']."',
						mul_descripcion='".$_POST['inputDescripcion']."',
						mul_dimension='".$_POST['inputDimension']."',
						mul_tamano='".$_POST['inputTamano']."',
						mul_id_dominio='".$this->fmt->categoria->traer_id_cat_dominio($_POST['inputDominio'])."',
						mul_fecha='".$_POST['inputFecha']."',
						mul_usuario='".$_POST['inputUsuario']."',
						mul_orden='".$_POST['inputOrden']."',
						mul_activar='".$_POST['inputActivar']."'
						WHERE mul_id='".$_POST['inputId']."'";

			$this->fmt->query->consulta($sql);
		}
			header("location: multimedia.adm.php?id_mod=".$this->id_mod);
	}


	function eliminar(){
		$this->fmt->get->validar_get( $_GET['id'] );
		$id= $_GET['id'];

		$sql="DELETE FROM multimedia WHERE mul_id='".$id."'";
		$this->fmt->query->consulta($sql);

		$sql="DELETE FROM multimedia_rel WHERE mul_rel_mul_id='".$id."'";
		$this->fmt->query->consulta($sql);

		$up_sqr6 = "ALTER TABLE multimedia AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);

		$up_sqr7 = "ALTER TABLE multimedia_rel AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr7);

		header("location: multimedia.adm.php?id_mod=".$this->id_mod);
	}


}
?>
