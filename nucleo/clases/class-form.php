<?PHP
header("Content-Type: text/html;charset=utf-8");

class FORM{

	var $fmt;

  function __construct($fmt) {
    $this->fmt = $fmt;
  }

  function head_busqueda_simple($nom,$archivo,$id_mod,$botones){
    $botones .= $this->fmt->class_pagina->crear_btn($archivo.".adm.php?tarea=form_nuevo&id_mod=$id_mod","btn btn-primary","icn-plus",$nom);
    $this->fmt->class_pagina->crear_head( $id_mod, $botones); // bd, id modulo, botones
    ?>
    <div class="body-modulo">
    <?php
  }


  function head_editar($nom,$archivo,$id_mod,$botones,$id_form,$class){
    $botones .= $this->fmt->class_pagina->crear_btn($archivo.".adm.php?tarea=busqueda&id_mod=$id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
  	$this->fmt->class_pagina->crear_head_form($nom, $botones,"","",$id_mod);
		$nom_mod=  strtolower($this->fmt->class_modulo->mombre_modulo($id_mod));
    ?>
    <div class="body-modulo body-<? echo $nom_mod; ?> col-xs-6 col-xs-offset-3 <? echo $class; ?>">
      <form class="form form-modulo" action="<?php echo $archivo; ?>.adm.php?tarea=modificar&id_mod=<? echo $id_mod; ?>"  enctype="multipart/form-data" method="POST" id="<?php echo $id_form; ?>">
        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
    <?php
  }
  function head_nuevo($nom,$archivo,$id_mod,$botones,$id_form,$class,$modo){
	 //echo "m:".$modo;
	if (empty($modo)){
	    $botones .= $this->fmt->class_pagina->crear_btn($archivo.".adm.php?tarea=busqueda&id_mod=$id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
	  	$action = "action='".$archivo.".adm.php?tarea=ingresar&id_mod=".$id_mod."'";
  		$mod="";
  	}else{
  		$mod="body-modal";
  		if (isset($_GET['id'])){
	  		$this->fmt->get->validar_get($_GET['id']);
	  		$id = "&id=".$_GET['id'];
  		}

  		$from =$_GET['from'];

  		$action = "action='".$archivo.".adm.php?tarea=ingresar&id_mod=".$id_mod."&modo=modal&from=".$from.$id."'";
  	}

  	$this->fmt->class_pagina->crear_head_form($nom, $botones,"","head-modal",$id_mod);
  	//echo $url;
		$nom_mod=  strtolower($this->fmt->class_modulo->mombre_modulo($id_mod));
    ?>
    <div class="body-modulo body-<? echo $nom_mod; ?> col-xs-6 col-xs-offset-3 <? echo $class; ?> <? echo $mod; ?>">
      <form class="form form-modulo" <?php echo $action; ?>  enctype="multipart/form-data"  method="POST" id="<?php echo $id_form; ?>">
        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
    <?php
  }

  function head_modal($nom,$modo){
	 //echo "m:".$modo;
    ?>
    <div class="head-modulo head-m-<?php echo $modo; ?>">
		<h1 class="title-page pull-left"><i class=""></i> <? echo $nom; ?></h1>
			<div class="head-botones pull-right">
				<a class="btn btn-actualizar-modal"><i class='icn-sync'></i> Actualizar</a>
			</div>
    </div>
    <div class="body-modal">
        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->

    <?php
  }


	function sizes_thumb($sizes){
		if (!empty($sizes)){
			$st = explode(",",$sizes);
			$c_st = count($st);
		}
		?>
		<select id="inputThumb" name="inputThumb" class="form-control">
			<?php

				for($i=0; $i < $c_st;$i++){
					$xst = explode(":",$st[$i]);
					echo "<option value='".$xst[0]."' >".$xst[0]."</option>";
				}
			?>
		</select>
		<?php
	}
  function file_form_seleccion($nom,$ruta,$id_form,$class,$class_div,$id_div,$directorio_p,$sizethumb){
		if ($id_form == 'form_nuevo'){ $texto="para subir"; }else{ $texto="para reemplazar"; }
    ?>
    <div class="form-group <?php echo $class_div; ?>" id="<?php echo $id_div; ?>" >
      <label>Seleccionar ruta url <? echo $texto; ?> : </label>
      <?php $this->fmt->archivos->select_archivos($ruta,$directorio_p); ?>
			<input type="hidden" value="<? echo $sizethumb; ?>" id="inputThumb" name="inputThumb">

      <br/>
			<label><? echo $nom; ?> :</label>
      <input type="file" ruta="<?php echo _RUTA_WEB; ?>" class="form-control <?php echo $class; ?>" id="inputArchivos" name="inputArchivos"  />
			<div id='prog'></div>
      <div id="respuesta"></div>
    </div>
    <?php
  }
  function file_form_nuevo($nom,$ruta,$id_form,$class,$class_div,$id_div,$directorio_p,$sizethumb){
  	//echo $ruta;
    ?>
    <div class="form-group <?php echo $class_div; ?>" id="<?php echo $id_div; ?>" >
      <label>Seleccionar ruta url para subir : </label>
      <?php $this->fmt->archivos->select_archivos($ruta,$directorio_p); ?>
			<br/><label>Seleccionar tamaño thumb (ancho x alto):</label>
			<?php $this->sizes_thumb($sizethumb); ?>
      <br/>
			<label><? echo $nom; ?> :</label>
      <input type="file" ruta="<?php echo _RUTA_WEB; ?>" class="form-control <?php echo $class; ?>" id="inputArchivos" name="inputArchivos"  />
			<div id='prog'></div>
      <div id="respuesta"></div>
    </div>
		<script>
      $(function(){
        $(".<?php echo $class; ?>").on("change", function(){
        var formData = new FormData($("#<?php echo $id_form; ?>")[0]);
        var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload.php";
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
  }
  function file_form_nuevo_save_thumb($nom,$ruta,$id_form,$class,$class_div,$id_div,$directorio_p,$sizethumb,$imagen){
  	//echo $ruta;
    ?>
    <div class="form-group <?php echo $class_div; ?>" id="<?php echo $id_div; ?>" >
      <label>Seleccionar ruta url para subir : </label>
      <?php $this->fmt->archivos->select_archivos($ruta,$directorio_p); ?>
			<br/><label>Seleccionar tamaño thumb (ancho x alto):</label>
			<?php $this->sizes_thumb($sizethumb); ?>
      <br/>
			<label><? echo $nom; ?> :</label>
      <input type="file" ruta="<?php echo _RUTA_WEB; ?>" class="form-control <?php echo $class; ?>" id="inputArchivos" name="inputArchivos"  />
			<div id='prog'></div>
      <div id="respuesta"></div>
    </div>
		<script>
      $(function(){
        $(".<?php echo $class; ?>").on("change", function(){
        var formData = new FormData($("#<?php echo $id_form; ?>")[0]);
        var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload-mul-tumb.php";
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

	  function CargarCrop(){
		 var formData = new FormData($("#<?php echo $id_form; ?>")[0]);

        var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload-mul-tumb.php";
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
	  }


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
							$("#respuesta-thumb").html('<p class="text-success">El thumb se guardo correctamente.</p>');
						}
					});
				});
			}
			<?php
				if($imagen!="")
				echo "CargarCrop();";
			?>
    </script>
    <?php
  }

  function file_form_nuevo_croppie_thumb($nom,$ruta,$id_form,$class,$class_div,$id_div,$directorio_p,$sizethumb,$imagen){
  	//echo $ruta;
    ?>
    <div class="form-group <?php echo $class_div; ?>" id="<?php echo $id_div; ?>" >
      <label>Seleccionar ruta url para subir : </label>
      <?php $this->fmt->archivos->select_archivos($ruta,$directorio_p); ?>
			<br/><label>Seleccionar tamaño thumb (ancho x alto):</label>
			<?php $this->sizes_thumb($sizethumb); ?>
      <br/>
			<label><? echo $nom; ?> :</label>
      <input type="file" ruta="<?php echo _RUTA_WEB; ?>" class="form-control <?php echo $class; ?>" id="inputArchivos" name="inputArchivos"  accept="image/*" />
			<div id='prog'></div>
      <div id="respuesta"></div>
    </div>
    <div id="ImagenPreview" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Vista Previa</h4>
	      </div>
	      <div class="modal-body" style="text-align: center;">
	        <img id="ImagePrev" src="">
	        <div id="prog_modal"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="button" id="GuardarImg" class="btn btn-primary">Guardar</button>
	      </div>
	    </div>
	  </div>
	</div>
		<script>
      $(function(){
        $(".<?php echo $class; ?>").on("change", function(){
        var formData = new FormData($("#<?php echo $id_form; ?>")[0]);
        var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload-mul-tumb-cropp.php";
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

		$("#GuardarImg").on("click", function(){
			guardar_thumb();
		})
      });

	  function CargarCrop(){
		 var formData = new FormData($("#<?php echo $id_form; ?>")[0]);
		 formData.append("inputArchivosEdit", "<?php echo $imagen; ?>");
        var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload-mul-tumb-cropp.php";
        $("#respuesta").toggleClass('respuesta-form');
        $.ajax({
            url: ruta,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos){
              	$("#respuesta").html(datos);
            }
          });
	  }


			function guardar_thumb(){
				var ext = $("#inputTipo").val();
				var dim = $("#inputThumb").val();
				var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-save-thumb-mul-cropp.php";
				var ruta_url = $("#inputUrl").val();
				var nombre = $("#inputNombreArchivo").val();

				var thm = dim.split("x");
				var ext_crop=ext;
				if(ext=="jpg"){
					ext_crop="jpeg";
				}
				 $('#image-cropp').cropper("getCroppedCanvas"<?php if($sizethumb!=""){ ?>, { width: thm[0], height: thm[1] }<?php } ?>).toBlob(function (blob) {
	           		var formData = new FormData();

			   		formData.append('croppedImage', blob);
			   		formData.append('dir', ruta_url);
			   		formData.append('nombre', nombre);
			   		formData.append('ext', ext);

			   		 $.ajax(ruta, {
				        method: "POST",
				        data: formData,
				        processData: false,
				        contentType: false,
				        xhr: function() {
				        var xhr = $.ajaxSettings.xhr();
				        xhr.upload.onprogress = function(e) {
									var dat = Math.floor(e.loaded / e.total *100);
				          //console.log(Math.floor(e.loaded / e.total *100) + '%');
									$("#prog_modal").html('<div class="progress"><div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'+ dat +'" aria-valuemin="0" aria-valuemax="100" style="width: '+ dat +'%;">'+ dat +'%</div></div>');
				        };
				        return xhr;
					    },
				        success: function (data) {
				          $("#respuesta-thumb").html('<p class="text-success">El thumb se guardo correctamente.</p><img src="../../'+data+'" width="350">');
						  $("#ImagenPreview").modal("hide");
				        },
				        error: function (data) {
				            console.log(data);
				        }
				    });



				});


			}
			<?php
				if($imagen!="")
				echo "CargarCrop();";
			?>
    </script>
    <?php
  }
  function multimedia_form($label,$input,$ruta,$thumb,$table,$col_id_extra,$col_id,$col_ruta,$col_dom,$id_mul=0){

  		$dom=0;
  		$aux="";

  		$sql="SELECT $col_id_extra, $col_id, $col_ruta, $col_dom FROM $table WHERE $col_id=$id_mul ";
		$rs=$this->fmt->query->consulta($sql);
		$num =$this->fmt->query->num_registros($rs);
		$i=0;
		while($filax=$this->fmt->query->obt_fila($rs)){
			$prev[$i]=_RUTA_WEB.$filax[$col_ruta];
			$ids[$i]=$filax[$col_id_extra];
			$dom=$filax[$col_dom];
			$i++;
		}

		if($num>0){
			$aux.="initialPreview: [\n";
			$div="";
			foreach ($prev as $file) {
		        $aux.="$div '".$file."'";
		        $div=",";
		    }
			$aux.="],\n";
			$aux.="initialPreviewAsData: true,\n";
			$aux.="initialPreviewConfig: [\n";
			$div="";
			$data=explode("/", _RUTA_WEB);
			$dato=$data[3]."/sitios/".$data[3]."/".$ruta;

			for ($i=0; $i < count($ids); $i++) {
		        $aux.="$div {\n";
		        $nom_cap=explode($dato, $prev[$i]);
		        $ext = $this->fmt->archivos->saber_extension_archivo($prev[$i]);
				if($ext=="mp4"){
		        	$aux.="type: 'video', filetype: 'video/mp4',\n";
		        }
		        if($ext=="mp3"){
		        	$aux.="type: 'audio', filetype: 'audio/mp3',\n";
		        }
		        $aux.="caption: '".$nom_cap[1]."',\n";
		        $aux.="url: '"._RUTA_WEB."nucleo/ajax/ajax-mul-delete-db.php',\n";
		        $aux.="key: ".$ids[$i].",\n";
		        $aux.="extra: {table: '".$table."', col_id: '".$col_id_extra."', col_ruta: '".$col_ruta."'}\n";
		        $aux.="}\n";
		        $div=",";
		    }
		    $aux.="],\n";
		}
		/*
		initialPreviewConfig: [
    {
        caption: 'desert.jpg',
        width: '120px',
        url: '/localhost/avatar/delete',
        key: 100,
        extra: {id: 100}
    },
    */

	  ?>
	  	<div class="form-group">
			<label class="control-label"><?php echo $label; ?></label>
			<input id="<?php echo $input; ?>" name="<?php echo $input; ?>[]" type="file" multiple class="file-loading">
			<div id="errorBlock" class="help-block"></div>
		</div>
		<script>
			$(document).ready(function () {
				$("#<?php echo $input; ?>").fileinput({
			    	<?php echo $aux; ?>
			    	language: "es",
			        allowedFileExtensions: ["jpg", "png", "gif", "mp3", "mp4"],
			        maxFilePreviewSize: 20480,
			        uploadUrl: "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-mul-upload-db.php", // your upload server url
			        uploadExtraData: function() {
			            return {
			                input_img: "<?php echo $input; ?>",
			                ruta: "<?php echo $ruta; ?>",
			                thumb: "<?php echo $thumb; ?>",
			                dominio: "<?php echo _RUTA_WEB; ?>",
			                table: "<?php echo $table; ?>",
			                col_id: "<?php echo $col_id; ?>",
			                col_ruta: "<?php echo $col_ruta; ?>",
			                col_dom: "<?php echo $col_dom; ?>",
			                id_mul: "<?php echo $id_mul; ?>"
			            };
			        },
			        overwriteInitial: false
			    });
				$("#<?php echo $input; ?>").on("filepredelete", function(jqXHR) {
				    var abort = true;
				    if (confirm("¿ Esta seguro eliminar este archivo ?")) {
				        abort = false;
				    }
				    return abort; // you can also send any data/object that you can receive on `filecustomerror` event
				});
			});
		</script>
	  <?php
  }
	function file_form_doc($nom,$ruta,$id_form,$class,$class_div,$id_div,$directorio_p,$req){
		?>
		<div class="form-group">
			<label><? echo $nom; ?></label>
			<div class="panel panel-default" >
				<div class="panel-body">
					<?php $this->fmt->archivos->select_archivos($ruta,$directorio_p,"inputRutaArchivosDocs"); ?>
					<input type="file" <?php echo $req; ?> ruta="<?php echo _RUTA_WEB; ?>" class="form-control <?php echo $class; ?>" id="inputArchivosDocs" name="inputArchivosDocs"  />
					<div id='prog'></div>
		      <div id="respuesta-docs"></div>
					<script>
					  $(function(){
					    $(".<?php echo $class; ?>").on("change", function(){
								var formData = new FormData($("#<?php echo $id_form; ?>")[0]);
					      var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload-doc.php";
								$("#prog").html();
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
                        var i;
                        var url = myarr[1];
                        for (i = 2; i < num; i++) {
                          var datx = myarr[i].split('^');
                          var dx = datx[1];
                          $("#"+datx[0]).val(datx[1]);
                          $("#respuesta-docs").html('<div> <i class="icn-checkmark-circle color-text-verde" /> Archivo subido satisfactoriamente.</div>');
                        }
                      }else{
								$("#respuesta-docs").toggleClass('respuesta-form');
					            $("#respuesta-docs").html(datos);
                      }
					          }
					        });
							});
						});
					</script>
				</div>
			</div>
		</div>
		<?
	}
  function file_form_editar($nom,$ruta,$id_form,$class,$class_div,$id_div,$directorio_p,$sizethumb){
    ?>
    <div class="form-group <?php echo $class_div; ?>" id="<?php echo $id_div; ?>" >
      <label>Seleccionar ruta url para reemplazar archivo : </label>
      <?php $this->fmt->archivos->select_archivos($ruta,$directorio_p); ?>
			<br/><label>Seleccionar tamaño thumb (ancho x alto):</label>
			<?php $this->sizes_thumb($sizethumb); ?>
      <br/>
			<label><? echo $nom; ?> :</label>
      <input type="file" ruta="<?php echo _RUTA_WEB; ?>" class="form-control <?php echo $class; ?>" id="inputArchivos" name="inputArchivos"  />
			<div id='prog'></div>
      <div id="respuesta"></div>
    </div>
		<script>
			$(function(){
				$(".<?php echo $class; ?>").on("change", function(){
					var formData = new FormData($("#<?php echo $id_form; ?>")[0]);
	        var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-upload.php";

					$("#url-imagen").html('');
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

								$("#respuesta").toggleClass('respuesta-form');
								var myarr = datos.split(",");
								var num = myarr.length;
								if (myarr[0]=="editar"){

									var i;

									var url = myarr[1];
									for (i = 2; i < num; i++) {
										var datx = myarr[i].split('^');
										var dx = datx[1];

										$("#"+datx[0]).val(datx[1]); //cambia los valores por los nuevos
									}
								}
							  var datosx='<img src="'+ dx + url +'" class="img-responsive">';
								$("#respuesta").html(datosx);

							}
						});
				});
      });
		</script>
    <?php
  }
  function agregar_pestana($label,$id,$valor,$class,$class_div,$mensaje,$from,$id_item,$id_item_doc){
	$idx=$id;
	  ?>
	<div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <a class="btn btn-nuevo-pest pull-right"><i class="fa fa-plus"></i> Nueva Pestaña </a>
      <a class="btn btn-agregar-pest pull-right"><i class="fa fa-plus"></i> Agregar Pestaña </a>
      <?php if (!empty($mensaje)){ ?>
	  <p class="help-block"><?php echo $mensaje; ?></p>
	  <? } ?>
	  <div class="" id="box-adiciones_pest">
		  <?php
			  $orden_pest=0;
			if (!empty($valor)){
				$sql="SELECT DISTINCT pes_id, pes_nombre, mod_pro_pes_contenido, mod_pro_pes_orden FROM $from, pestana WHERE $id_item_doc=pes_id and $id_item=$valor order by mod_pro_pes_orden asc ";
				$rs=$this->fmt->query->consulta($sql);
				$num =$this->fmt->query->num_registros($rs);
				if ($num>0){

					for($i=0;$i<$num;$i++){
						$filax=$this->fmt->query->obt_fila($rs);
						echo '<div class="box-pest-agregado box-pest-'.$filax["pes_id"].'" "><input type="hidden" name="'.$id.'[]" id="'.$id.'[]" value="'.$filax["pes_id"].'" /> <label>'.$filax["pes_nombre"].'</label><a class="btn quitarpest" value="'.$filax["pes_id"].'" id="e-'.$filax["pes_id"].'" nombre="'.$filax["pes_nombre"].'"><i class="icn-close"></i></a><div class="form-group"><label for="textArea" class="col-lg-2 control-label">Contenido:<p></p>Orden:<input type="number" class="form-control" min="0" name="orden_pest'.$filax["pes_id"].'" id="orden_pest'.$filax["pes_id"].'" value="'.$filax["mod_pro_pes_orden"].'"></label><div class="col-lg-10"><textarea class="form-control text-note" rows="3" name="contenido'.$filax["pes_id"].'" id="contenido'.$filax["pes_id"].'">'.$filax["mod_pro_pes_contenido"].'</textarea></div></div></div>';

						$valor_ids[$i] = $filax["pes_id"];
						$orden_pest=$filax["mod_pro_pes_orden"];
					}

				}
			}
		  ?>
	  </div>
	  <div class="box-modal" id="box-modal-pest" style="display:none;">
		  <div id="respuesta-modal">
		  <?
			if (!empty($valor)){ $xvalor="&id=".$valor; }else{ $xvalor=""; }
			$url_mod =  _RUTA_WEB."modulos/productos/config-ec.adm.php?tarea=form_nuevo&modo=modal&from=".$from.$xvalor;
			echo "<iframe class='frame-modal' src='".$url_mod."'  name='frame_content_modal' scrolling=auto ></iframe>";
		  ?>
		  </div>
	  </div>

	  <div class="box-modal" id="box-modal-apest" style="display:none;">
		  <?php
			  require_once(_RUTA_HOST."modulos/productos/config-ec.class.php");
			  $form_e =new CONFIG_EC($this->fmt);
			  $form_e->busqueda_seleccion('modal',$valor_ids);
		   ?>
	  </div>
	  <script>
		  	$(document).ready( function (){
		  		var orden_pst = <?php echo $orden_pest; ?>;
			  	$(".btn-nuevo-pest").click( function(){
				  $("#box-modal-pest").toggle();
				  $(".btn-nuevo-pest").toggleClass("on");
			  	});

			  	$(".btn-agregar-pest").click( function(){
				  $("#box-modal-apest").toggle();
				  $(".btn-agregar-pest").toggleClass("on");
				});

				$( "#box-modal-apest" ).on( "click", ".btn-agregar-pes", function(){
					orden_pst++;
				  var idv = $( this ).attr("value");
				  var nom = $( this ).attr("nombre");
				  $('#bp-' + idv).toggleClass("on");
				  $('.btp-' + idv).toggleClass("on");
				  $('#box-adiciones_pest').append('<div class="box-pest-agregado box-pest-'+idv+'"><input type="hidden" name="<?php echo $idx; ?>[]" id="<?php echo $idx; ?>[]" value="'+idv+'" /> <label>'+nom+'</label><a class="btn quitarpest" value="'+idv+'" id="e-'+idv+'" nombre="'+nom+'"><i class="icn-close"></i></a><div class="form-group"><label for="textArea" class="col-lg-2 control-label">Contenido:<p></p>Orden:<input type="number" class="form-control" min="0" name="orden_pest'+idv+'" id="orden_pest'+idv+'" value="'+orden_pst+'"></label><div class="col-lg-10"><textarea class="form-control text-note" rows="3" name="contenido'+idv+'" id="contenido'+idv+'"></textarea></div></div></div>');

				  	$(".quitarpest").off('click');
    				$(".quitarpest").on('click', function() {
	    				var ide = $( this ).attr("value");
	    				var nom = $( this ).attr("nombre");
	    				$('#bp-' + ide).toggleClass("on");
	    				$('.btp-' + ide).toggleClass("on");
	    				$('.box-pest-' + ide ).remove();
					});

					$('.text-note').summernote({
						height: 150,                 // set editor height
						minHeight: null,             // set minimum height of editor
						maxHeight: null,             // set maximum height of editor
						lang: 'es-ES',
						focus: false,
						toolbar: [
							['style', ['style','bold', 'italic', 'underline', 'clear','hr']],
						    ['font', ['strikethrough', 'superscript', 'subscript']],
						    ['fontsize', ['fontsize']],
						    ['color', ['color']],
						    ['table', ['table']],
						    ['para', ['ul', 'ol', 'paragraph']],
						    ['height', ['height']],
						    ['codeview',['codeview','fullscreen']],
							['mybutton', ['imagen','link']],
						]
					});
				});
				$(".quitarpest").click(function() {
	    				var ide = $( this ).attr("value");
	    				$('#bp-' + ide).toggleClass("on");
	    				$('.btp-' + ide).toggleClass("on");
	    				$('.box-pest-' + ide ).remove();
				});
				$( "#box-modal-apest" ).on( "click", ".btn-actualizar-modal", function() {
					  $("#box-modal-apest").html("cargando..");
					 var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-act-seccion.php";
					 var dato = [{name:"action", value:"pestana"},{name:"valor", value:"<?php echo $valor; ?>"}];
					 $.ajax({
					          url: ruta,
					          type: "POST",
					          data: dato,
							  success: function(datos){
							  	$("#box-modal-apest").html(datos);
									$('#table_id_modal_aux').DataTable({
										"language": {
							            "url": "http://52.36.176.142/mainter/js/spanish_datatable.json"
							            },
							            "pageLength": 25,
							            "order": [[ 0, 'asc' ]]
									});
							  }
					});
				});
				$('.text-note').summernote({
						height: 150,                 // set editor height
						minHeight: null,             // set minimum height of editor
						maxHeight: null,             // set maximum height of editor
						lang: 'es-ES',
						focus: false,
						toolbar: [
							['style', ['style','bold', 'italic', 'underline', 'clear','hr']],
						    ['font', ['strikethrough', 'superscript', 'subscript']],
						    ['fontsize', ['fontsize']],
						    ['color', ['color']],
						    ['table', ['table']],
						    ['para', ['ul', 'ol', 'paragraph']],
						    ['height', ['height']],
						    ['codeview',['codeview','fullscreen']],
							['mybutton', ['imagen','link']],
						]
					});
			});

       </script>
    </div>
	<?php
  }

  function agregar_documentos($label,$id,$valor,$class,$class_div,$mensaje,$from,$id_item,$id_item_doc){
	  $idx=$id;
	  ?>
	<div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <a class="btn btn-nuevo-docs pull-right"><i class="fa fa-plus"></i> Nuevo documento </a>
      <a class="btn btn-agregar-docs pull-right"><i class="fa fa-plus"></i> Agregar documento </a>
      <?php if (!empty($mensaje)){ ?>
	  <p class="help-block"><?php echo $mensaje; ?></p>
	  <? } ?>
	  <div class="" id="box-adiciones">
		  <?php

			if (!empty($valor)){
				$sql="SELECT DISTINCT doc_id,doc_nombre,doc_tipo_archivo FROM $from, documento WHERE $id_item_doc=doc_id and $id_item=$valor ";
				$rs=$this->fmt->query->consulta($sql);
				$num =$this->fmt->query->num_registros($rs);
				if ($num>0){
					for($i=0;$i<$num;$i++){
						$filax=$this->fmt->query->obt_fila($rs);
						echo '<div class="box-doc-agregado box-doc-'.$filax["doc_id"].'">';
						echo '<input type="hidden" name="'.$id.'[]" id="'.$id.'[]" value="'.$filax["doc_id"].'" />';
						echo '<label>'.$filax["doc_nombre"].' ('.$filax["doc_tipo_archivo"].') </label>';
						echo '<a class="btn quitardoc" value="'.$filax["doc_id"].'" id="e-'.$filax["doc_id"].'" nombre="'.$filax["doc_nombre"].' ('.$filax["doc_tipo_archivo"].')"><i class="icn-close"></i></a>';
						echo '</div>';
						$valor_ids[$i] = $filax["doc_id"];
					}
				}
			}
		  ?>
	  </div>
	  <div class="box-modal" id="box-modal-docs" style="display:none;">
		  <div id="respuesta-modal">
		  <?
			if (!empty($valor)){ $xvalor="&id=".$valor; }else{ $xvalor=""; }
			$url_mod =  _RUTA_WEB."modulos/documentos/documentos.adm.php?tarea=form_nuevo&id_mod=15&modo=modal&from=".$from.$xvalor;
			echo "<iframe class='frame-modal' src='".$url_mod."'  name='frame_content_modal' scrolling=auto ></iframe>";
		  ?>
		  </div>
	  </div>

	  <div class="box-modal" id="box-modal-adocs" style="display:none;">
		  <?php
			  require_once(_RUTA_HOST."modulos/documentos/documentos.class.php");
			  $form =new DOCUMENTOS($this->fmt);
			  $form->busqueda_seleccion('modal',$valor_ids);
		   ?>
	  </div>
	  <script>
		  	$(document).ready( function (){
			  	$(".btn-nuevo-docs").click( function(){
				  $("#box-modal-docs").toggle();
				  $(".btn-nuevo-docs").toggleClass("on");
			  	});

			  	$(".btn-agregar-docs").click( function(){
				  $("#box-modal-adocs").toggle();
				  $(".btn-agregar-docs").toggleClass("on");
				});

				$("#box-modal-adocs").on('click', ".btn-agregar", function(){
				  var idv = $( this ).attr("value");
				  var nom = $( this ).attr("nombre");
				  $('#b-' + idv).toggleClass("on");
				  $('.bt-' + idv).toggleClass("on");
				  $('#box-adiciones').append('<div class="box-doc-agregado box-doc-'+idv+'" "><input type="hidden" name="<?php echo $idx; ?>[]" id="<?php echo $idx; ?>[]" value="'+idv+'" /> <label>'+nom+'</label><a class="btn quitardoc" value="'+idv+'" id="e-'+idv+'" nombre="'+nom+'"><i class="icn-close"></i></a></div>');
				  	/*
					  	<div id="'.$id.'[]" value=""></div>
					  	var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-doc-modal.php";

$.ajax({
					          url: ruta,
					          type: "POST",
					          data: { inputFecha:inputUsuario },
							  success: function(datos){
								  $("#respuesta-modal").html(datos);
							  }
					});

*/  				$(".quitardoc").off('click');
    				$(".quitardoc").on('click', function() {
	    				var ide = $( this ).attr("value");
	    				var nom = $( this ).attr("nombre");
	    				$('#b-' + ide).toggleClass("on");
	    				$('.bt-' + ide).toggleClass("on");
	    				$('.box-doc-' + ide ).remove();
					});
				});
				$(".quitardoc").click(function() {
	    				var ide = $( this ).attr("value");
	    				$('#b-' + ide).toggleClass("on");
	    				$('.bt-' + ide).toggleClass("on");
	    				$('.box-doc-' + ide ).remove();
				});
				$( "#box-modal-adocs" ).on( "click", ".btn-actualizar-modal", function() {
					  $("#box-modal-adocs").html("cargando..");
					 var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-act-seccion.php";
					 var dato = [{name:"action", value:"documento"},{name:"valor", value:"<?php echo $valor; ?>"}];
					 $.ajax({
					          url: ruta,
					          type: "POST",
					          data: dato,
							  success: function(datos){
								  $("#box-modal-adocs").html(datos);
									$('#table_id_modal').DataTable({
										"language": {
							            "url": "http://52.36.176.142/mainter/js/spanish_datatable.json"
							            },
							            "pageLength": 25,
							            "order": [[ 0, 'asc' ]]
									});
							  }
					});
				});
			});
       </script>
    </div>
	<?php
   }

	 function agregar_pedidos($label,$id,$valor,$class,$class_div,$mensaje){
 	$idx=$id;
 	  ?>
 	<div class="form-group <?php echo $class_div; ?>">
       <label><?php echo $label; ?></label>
       <?php if (!empty($mensaje)){ ?>
 	  <p class="help-block"><?php echo $mensaje; ?></p>
 	  <? } ?>
		<div class="box-pedt-head box-pedt-head">
			<div class="form-group box-md-4">
				<label>Articulo:</label>
			</div>
			<div class="form-group box-md-1">
				<label>Cant.:</label>
			</div>
			<div class="form-group box-md-2">
				<label>Unidad:</label>
			</div>
			<div class="form-group box-md-3">
				<label>Observaciones:</label>
			</div>
			<div class="form-group box-md-1">
				<label>Quitar</label>
			</div>
		</div>
 	  <div class="" id="box-adiciones_pedt">
 		  <?php
 			  $orden_pedt=0;
 			if (!empty($valor)){
 				$sql="SELECT DISTINCT alm_id, alm_nombre, ped_alm_cantidad, ped_alm_unidad, ped_alm_observaciones FROM almacen, pedido_almacen WHERE ped_alm_id_almacen=alm_id and ped_alm_id_pedido=$valor order by alm_id asc ";
 				$rs=$this->fmt->query->consulta($sql);
 				$num =$this->fmt->query->num_registros($rs);
 				if ($num>0){

 					for($i=0;$i<$num;$i++){
 						$filax=$this->fmt->query->obt_fila($rs);
 						echo '<div class="box-pedt-agregado box-pedt-'.$filax["alm_id"].'"><div class="form-group box-md-4"><input class="form-control " id="" name="" placeholder="" value="'.$filax["alm_nombre"].'" readonly=""><input type="hidden" name="'.$idx.'[]" id="'.$idx.'[]" value="'.$filax["alm_id"].'"/></div><div class="form-group box-md-1"><input class="form-control " id="cant'.$filax["alm_id"].'" name="cant'.$filax["alm_id"].'" value="'.$filax["ped_alm_cantidad"].'" ></div><div class="form-group box-md-2"><input class="form-control " id="unidad'.$filax["alm_id"].'" name="unidad'.$filax["alm_id"].'" placeholder="caja,bolsas,litros" value="'.$filax["ped_alm_unidad"].'" ></div><div class="form-group box-md-3"><input class="form-control " id="observacion'.$filax["alm_id"].'" name="observacion'.$filax["alm_id"].'" placeholder="" value="'.$filax["ped_alm_observaciones"].'" ></div><div class="form-group box-md-1"><a class="btn quitarpedt" value="'.$filax["alm_id"].'" id="e-'.$filax["alm_id"].'" nombre="'.$filax["alm_nombre"].'"><i class="icn-close"></i></a></div></div>';

 						$valor_ids[$i] = $filax["alm_id"];
 					}

 				}
 			}
 		  ?>
 	  </div>
 	  <div class="box-modal" id="box-modal-apedt">
 		  <?php
 			  require_once(_RUTA_HOST."modulos/rrhh/inventario.class.php");
 			  $form_e =new INVENTARIO($this->fmt);
 			  $form_e->busqueda_seleccion('modal',$valor_ids);
 		   ?>
 	  </div>
 	  <script>
 		  	$(document).ready( function (){
 		  		var orden_pst = <?php echo $orden_pedt; ?>;
 			  	$(".btn-nuevo-pedt").click( function(){
 				  $("#box-modal-pedt").toggle();
 				  $(".btn-nuevo-pedt").toggleClass("on");
 			  	});

 			  	$(".btn-agregar-pedt").click( function(){
 				  $("#box-modal-apedt").toggle();
 				  $(".btn-agregar-pedt").toggleClass("on");
 				});

 				$( "#box-modal-apedt" ).on( "click", ".btn-agregar-ped", function(){
 					orden_pst++;
 				  var idv = $( this ).attr("value");
 				  var nom = $( this ).attr("nombre");
 				  $('#bp-' + idv).toggleClass("on");
 				  $('.btp-' + idv).toggleClass("on");
 				  $('#box-adiciones_pedt').append('<div class="box-pedt-agregado box-pedt-'+idv+'"><div class="form-group box-md-4"><input class="form-control " id="" name="" placeholder="" value="'+nom+'" readonly=""><input type="hidden" name="<?php echo $idx; ?>[]" id="<?php echo $idx; ?>[]" value="'+idv+'"/></div><div class="form-group box-md-1"><input class="form-control " id="cant'+idv+'" name="cant'+idv+'" value="" ></div><div class="form-group box-md-2"><input class="form-control " id="unidad'+idv+'" name="unidad'+idv+'" placeholder="caja,bolsas,litros" value="" ></div><div class="form-group box-md-3"><input class="form-control " id="observacion'+idv+'" name="observacion'+idv+'" placeholder="" value="" ></div><div class="form-group box-md-1"><a class="btn quitarpedt" value="'+idv+'" id="e-'+idv+'" nombre="'+nom+'"><i class="icn-close"></i></a></div></div>');

 				  $(".quitarpedt").off('click');
     			$(".quitarpedt").on('click', function() {
 	    				var ide = $( this ).attr("value");
 	    				var nom = $( this ).attr("nombre");
 	    				$('#bp-' + ide).toggleClass("on");
 	    				$('.btp-' + ide).toggleClass("on");
 	    				$('.box-pedt-' + ide ).remove();
 					});
				});

 				$(".quitarpedt").click(function() {
 	    				var ide = $( this ).attr("value");
 	    				$('#bp-' + ide).toggleClass("on");
 	    				$('.btp-' + ide).toggleClass("on");
 	    				$('.box-pedt-' + ide ).remove();
 				});

 				$( "#box-modal-apedt" ).on( "click", ".btn-actualizar-modal", function() {
 					  $("#box-modal-apedt").html("cargando..");
 					 var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-act-seccion.php";
 					 var dato = [{name:"action", value:"pestana"},{name:"valor", value:"<?php echo $valor; ?>"}];
 					 $.ajax({
 					          url: ruta,
 					          type: "POST",
 					          data: dato,
 							  success: function(datos){
 							  	$("#box-modal-apedt").html(datos);
 							  }
 					});
 				});

 			});

        </script>
     </div>
 	<?php
   }

  function head_table($id_tabla){
    ?><div class="table-responsive">
        <table class="table table-hover display" id="<?php echo $id_tabla; ?>">
    <?php
  }

  function thead_table($cab,$class){
    $valor = explode(":",$cab);
		$valor_clase = explode(":",$class);
    $num = count($valor);
    ?><thead>
      <tr>
        <?
        for ($i=0; $i<$num;$i++){
          echo '<th class="'.$valor_clase[$i].'">'.$valor[$i].'</th>';
        }
        ?>
      </tr>
    </thead>
    <?php
  }

  function tbody_table_open(){
    ?>
    <tbody>
  	<?php
  }
  function tbody_table_close(){
    ?>
		</tbody>
  	<?php
  }


  function footer_table(){
    ?>
        </table> <!-- fin table-->
      </div>
    <?php
  }

  function input_hidden_form($id,$valor){
    ?>
    	<input type="hidden" id="<? echo $id; ?>" name="<? echo $id; ?>" value="<?php echo $valor; ?>" />
    <?php
  }
  function input_form($label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar){
    ?>
    <div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <input class="form-control <?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>" validar="<?php echo $validar; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $valor; ?>" <?php echo $disabled; ?> >
			<?php if (!empty($mensaje)){ ?>
			<p class="help-block"><?php echo $mensaje; ?></p>
			<? } ?>
    </div>
    <?php
  }
	function input_color($label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar){
    ?>
    <div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <input type="color" class="form-control <?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>" validar="<?php echo $validar; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $valor; ?>" <?php echo $disabled; ?> >
			<?php if (!empty($mensaje)){ ?>
			<p class="help-block"><?php echo $mensaje; ?></p>
			<? } ?>
    </div>
    <?php
  }
  function input_mail($label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar){
    ?>
    <div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <input type="email" class="form-control <?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>" validar="<?php echo $validar; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $valor; ?>" <?php echo $disabled; ?>  >
			<?php if (!empty($mensaje)){ ?>
			<p class="help-block"><?php echo $mensaje; ?></p>
			<? } ?>
    </div>
    <?php
  }
  function input_file($label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar){
    ?>
    <div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <input type="file" class="form-control <?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>" validar="<?php echo $validar; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $valor; ?>" <?php echo $disabled; ?> >
			<?php if (!empty($mensaje)){ ?>
			<p class="help-block"><?php echo $mensaje; ?></p>
			<? } ?>
    </div>
    <?php
  }

	function var_input_form($label,$id,$placeholder,$valor,$class,$class_div,$mensaje){
		$aux= '<div class="form-group '.$class_div.'">
			<label>'.$label.'</label>
			<input class="form-control '.$class.'" id="'.$id.'" name="'.$id.'"  placeholder="'.$placeholder.'" value="'.$valor.'" />';
			if (!empty($mensaje)){
				$aux .='<p class="help-block">'.$mensaje.'</p>';
			}
			$aux .= '</div>';
			return $aux;
	}

  function input_form_sololectura($label,$id,$placeholder,$valor,$class,$class_div,$mensaje){
    ?>
    <div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <input class="form-control <?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>"  placeholder="<?php echo $placeholder; ?>" value="<?php echo $valor; ?>" readonly/>
			<?php if (!empty($mensaje)){ ?>
			<p class="help-block"><?php echo $mensaje; ?></p>
			<? } ?>
    </div>
    <?php
  }

	function input_date($label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$id_input){
		date_default_timezone_set('America/La_Paz');
		switch ($valor) {
			case 'hoy':
				$va=date("d/m/Y");
			break;
			case 'mañana':
				$va= date('d',time()+84600)."/". date("m")."/".date("Y");
			break;
			default:
				$va=$valor;
			break;
		}
		?>
			<div class="<?php echo $class_div; ?> " >
				<label><?php echo $label; ?></label>
        <div class="form-group">
					<div class='input-group date <?php echo $class; ?>' id="<?php echo $id_input; ?>" >
						<input type="text" class="form-control add-on dp" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo  $va; ?>"/>
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
				</div>
			</div>
			<script type="text/javascript">
					$(function () {
							$('.dp').datetimepicker({agra
								format: 'DD/MM/YYYY',
								locale: 'es'
							});
					});
			</script>
		<?php
	}
  function categoria_form($label,$id,$cat_raiz,$cat_valor,$class,$class_div){
    ?>
    <div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label.":"; ?></label>
      <?php $this->fmt->categoria->arbol($id,$cat_raiz,$cat_valor);  ?>
    </div>
    <?php
  }
  function textarea_form($label,$id,$placeholder,$valor,$class,$class_div,$rows,$mensaje){
    ?>
    <div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <textarea  class="form-control <?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>" rows="<?php echo $rows; ?>"  placeholder="<?php echo $placeholder; ?>" ><?php echo $valor; ?></textarea>
			<?php if (!empty($mensaje)){ ?>
			<p class="help-block"><?php echo $mensaje; ?></p>
			<? } ?>
    </div>
    <?php
  }

  function select_form($label,$id,$prefijo,$from,$id_select,$id_disabled,$class_div){
    ?>
    <div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <select class="form-control" id="<?php echo $id; ?>" name="<?php echo $id; ?>">
    <?php
    $consulta ="SELECT ".$prefijo."id, ".$prefijo."nombre FROM ".$from;
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
		echo "<option class='' value='0'>Sin selección (0)</option>";
		if($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
        if ($fila_id==$id_select){  $aux="selected";  }else{  $aux=""; }
        if ($fila_id==$id_disabled){  $aux1="disabled";  }else{  $aux1=""; }
        echo "<option class='' value='$fila_id' $aux $aux1 > ".$fila_nombre;
        echo "</option>";
      }
    }
    ?>
      </select>
    </div>
    <?php
  }

	  function select_form_simple($label,$id,$options,$valores,$desabilitado,$defecto,$class_div){
			?>
			<div class="form-group <?php echo $class_div; ?>">
				<label><?php echo $label; ?></label>
				<select class="form-control" id="<?php echo $id; ?>" name="<?php echo $id; ?>">
				<?php
					$n = count($options);
					for($i=0;$i<$n;$i++){
						if ($valores[$i]==$defecto){  $aux="selected";  }else{  $aux=""; }
		        if ($valores[$i]==$desabilitado){  $aux1="disabled";  }else{  $aux1=""; }
		        echo "<option class='' value='".$valores[$i]."' $aux $aux1 > ".$options[$i];
		        echo "</option>";
					}
				?>
				</select>
		</div>
		<?php
		}
	function input_check_form($label,$nombreinput,$valor,$campo){

		$campo_in[0]="1";
		$num = count($nombreinput);
		for($i=0;$i<$num;$i++){
			$ck="";
			if(in_array($valor[$i], $campo))
				$ck="checked";
			?>
			<div class="checkbox">
				 <label>
					 <input type="checkbox" name="<?php echo $nombreinput[$i]; ?>" id="<?php echo $nombreinput[$i]; ?>" value="<?php echo $valor[$i]; ?>" <?php echo $ck; ?>> <?php echo $label[$i]; ?>
				 </label>
			</div>
			<?php
		}
	}
  function radio_activar_form($valor){
    ?>
    <div class="form-group">
      <label class="radio-inline">
        <input type="radio" name="inputActivar" id="inputActivar" value="0" <?php if ($valor==0){ echo "checked"; } ?> > Desactivar
      </label>
      <label class="radio-inline">
        <input type="radio" name="inputActivar" id="inputActivar" value="1" <?php if ($valor==1){ echo "checked"; $aux="Activo"; } else { $aux="Activar"; } ?> > <? echo $aux; ?>
      </label>
    </div>
    <?php
  }

  function botones_editar($fila_id,$fila_nombre,$nombre,$tarea_eliminar){
    ?>
    <div class="form-group form-botones clear-both">
       <button  type="button" class="btn-accion-form btn btn-danger btn-eliminar color-bg-rojo-a" 	tarea="<?php echo $tarea_eliminar; ?>" nombre="<?php echo $fila_nombre;  ?>" ide="<?php echo $fila_id; ?>" title="<? echo $fila_id; ?> : <? echo $fila_nombre; ?>"  name="btn-accion" id="btn-eliminar" value="eliminar"><i class="icn-trash" ></i> Eliminar <? echo $nombre; ?></button>

       <button type="submit" class="btn-accion-form btn btn-info  btn-actualizar hvr-fade btn-lg color-bg-celecte-c btn-lg " name="btn-accion" id="btn-activar" value="actualizar"><i class="icn-sync" ></i> Actualizar</button>
    </div>
    <?php
  }

  function botones_nuevo($modo){

	  $tipo='type="submit"';
    ?>
    <div class="form-group form-botones">
       <button <?php echo $tipo; ?> class="btn-accion-form btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save" ></i> Guardar</button>
       <button <?php echo $tipo; ?> class="btn-accion-form btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open" ></i> Activar</button>
    </div>
    <?php
  }

  function footer_page($modo){
    if ($modo!="modal"){ ?>
      </form>
    <?php } ?>
    </div>
    <?php
  }

  function botones_acciones($id,$class,$href,$title,$icono,$tarea,$nom,$ide){
	  if (!empty($href)){ $auxr="href='".$href."'"; }else{$auxr="";}
	  ?>
		<a  id="<?php echo $id; ?>" type="button" class="<?php echo $class; ?>" <?php echo $auxr; ?> title="<?php echo $title; ?>" alt="<?php echo $title; ?>"
			tarea="<?php echo $tarea; ?>" nombre="<?php echo $nom; ?>" ide="<?php echo $ide; ?>" ><i class="<?php echo $icono; ?>" ></i></a>
	<?php
  }

  function form_head_form_editar($nom,$from,$prefijo,$id_mod,$class,$archivo){
	$this->fmt->get->validar_get ( $_GET['id'] );
	$id = $_GET['id'];
	$consulta= "SELECT * FROM ".$from." WHERE ".$prefijo."id='".$id."'";
	$rs =$this->fmt->query->consulta($consulta);
	$fila=$this->fmt->query->obt_fila($rs);
	//var_dump($fila);
	$this->head_editar($nom,$archivo,$id_mod,'','form_editar',$class); //$nom,$archivo,$id_mod,$botones,$id_form,$class
	return $fila;
  }


}
?>
