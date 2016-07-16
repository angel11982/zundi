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
  	$this->fmt->class_pagina->crear_head_form($nom, $botones,"");
    ?>
    <div class="body-modulo col-xs-6 col-xs-offset-3 <? echo $class; ?>">
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
  	
  	$this->fmt->class_pagina->crear_head_form($nom, $botones,"","head-modal");
  	//echo $url;
    ?>
    <div class="body-modulo col-xs-6 col-xs-offset-3 <? echo $class; ?> <? echo $mod; ?>">
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
				<a class="btn btn-actualizar"><i class='icn-sync'></i> Actualizar</a>
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
					echo "<option value='".$xst[0]."' >".$xst[1]."</option>";
				}
			?>
		</select>
		<?php
	}
  function file_form_seleccion($nom,$ruta,$id_form,$class,$class_div,$id_div,$directorio_p){
		if ($id_form == 'form_nuevo'){ $texto="para subir"; }else{ $texto="para reemplazar"; }
    ?>
    <div class="form-group <?php echo $class_div; ?>" id="<?php echo $id_div; ?>" >
      <label>Seleccionar ruta url <? echo $texto; ?> : </label>
      <?php $this->fmt->archivos->select_archivos($ruta,$directorio_p); ?>
			<br/><label>Seleccionar tamaño thumb (ancho x alto):</label>
			<?php $this->sizes_thumb(); ?>

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
	function file_form_doc($nom,$ruta,$id_form,$class,$class_div,$id_div,$directorio_p){
		?>
		<div class="form-group">
			<label><? echo $nom; ?></label>
			<div class="panel panel-default" >
				<div class="panel-body">
					<?php $this->fmt->archivos->select_archivos($ruta,$directorio_p,"inputRutaArchivosDocs"); ?>
					<input type="file" ruta="<?php echo _RUTA_WEB; ?>" class="form-control <?php echo $class; ?>" id="inputArchivosDocs" name="inputArchivosDocs"  />
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
  
  
  function agregar_documentos($label,$id,$valor,$class,$class_div,$mensaje,$from,$id_item){
	  ?>
	<div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
      <a class="btn btn-nuevo-docs pull-right"><i class="fa fa-plus"></i> Nuevo documento </a>
      <a class="btn btn-agregar-docs pull-right"><i class="fa fa-plus"></i> Agregar documento </a>
      <?php if (!empty($mensaje)){ ?>
	  <p class="help-block"><?php echo $mensaje; ?></p>
	  <? } ?>
	  <div class="box-modal" id="box-modal-docs" style="display:none;">
		  <div id="respuesta-modal">
		  <?  
			if (!empty($id_item)){ $xvalor="&id=".$id_item; }else{ $xvalor=""; }
			$url_mod =  _RUTA_WEB."modulos/documentos/documentos.adm.php?tarea=form_nuevo&modo=modal&from=".$from.$xvalor;
			echo "<iframe class='frame-modal' src='".$url_mod."'  name='frame_content_modal' scrolling=auto ></iframe>";
		  ?>
		  </div>
	  </div>
	  
	  <div class="box-modal" id="box-modal-adocs" style="display:none;">
		  <?php
			  require_once(_RUTA_HOST."modulos/documentos/documentos.class.php");
			  $form =new DOCUMENTOS($this->fmt);
			  $form->busqueda_seleccion('modal');
		   ?>
	  </div>
	  <script>
		  	$(function(){
			  	$(".btn-nuevo-docs").click( function(){
				  $("#box-modal-docs").toggle();
				  $(".btn-nuevo-docs").toggleClass("on");
			  	});
			  	$(".btn-agregar-docs").click( function(){
				  $("#box-modal-adocs").toggle();
				  $(".btn-agregar-docs").toggleClass("on");
				  	var ruta = "<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-doc-modal.php";
				  
				  	/*
$.ajax({
					          url: ruta,
					          type: "POST",
					          data: { inputFecha:inputUsuario },
							  success: function(datos){
								  $("#respuesta-modal").html(datos);
							  }
					}); 
*/ 
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

  function thead_table($cab){
    $valor = explode(":",$cab);
    $num = count($valor);
    ?><thead>
      <tr>
        <?
        for ($i=0; $i<$num;$i++){
          echo '<th>'.$valor[$i].'</th>';
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
      <input class="form-control <?php echo $class; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>" validar="<?php echo $validar; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $valor; ?>" <?php echo $disabled; ?>/>
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
  function categoria_form($label,$id,$cat_raiz,$cat_valor,$class,$class_div){
    ?>
    <div class="form-group <?php echo $class_div; ?>">
      <label><?php echo $label; ?></label>
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

  function select_form($label,$id,$prefijo,$from,$id_s,$id_disabled){
    ?>
    <div class="form-group">
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
        if ($fila_id==$id_s){  $aux="selected";  }else{  $aux=""; }
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

  function botones_editar($fila_id,$fila_nombre,$nombre){
    ?>
    <div class="form-group form-botones">
       <button  type="button" class="btn-accion-form btn btn-danger btn-eliminar color-bg-rojo-a"  idEliminar="<? echo $fila_id; ?>" title="<? echo $fila_id; ?> : <? echo $fila_nombre; ?>" nombreEliminar="<? echo $fila_nombre; ?>" name="btn-accion" id="btn-eliminar" value="eliminar"><i class="icn-trash" ></i> Eliminar <? echo $nombre; ?></button>

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

  function footer_page(){
    ?>
      </form>
    </div>
    <?php
  }
  
  function botones_acciones($id,$class,$href,$title,$icono,$tarea,$nom,$ide){
	  if (!empty($href)){ $auxr="href='".$href."'"; }else{$auxr="";}
	  ?>
		<a  id="<?php echo $id; ?>" type="button" class="<?php echo $class; ?>" <?php echo $auxr; ?> title="<?php echo $title; ?>" alt="<?php echo $title; ?>" tarea="<?php echo $tarea; ?>" nombre="<?php echo $nom; ?>" ide="<?php echo $ide; ?>" ><i class="<?php echo $icono; ?>" ></i></a>
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
