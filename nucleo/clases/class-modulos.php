<?PHP
header('Content-Type: text/html; charset=utf-8');

class CLASSMODULOS{

  var $fmt;

  function __construct($fmt) {
    $this->fmt = $fmt;
  }

	function estado_publicacion( $estado,$link,$id_mod,$disabled,$id){
		$link = _RUTA_WEB.$link;
		if( $estado==1){
      		echo "<a title='activo' class='btn btn-fila-activar $disabled' href='$link?tarea=activar&estado=0&id=$id&id_mod=$id_mod' ><i class='icn-eye-open color-text-negro-b'></i></a>";
  		}else{
      		echo "<a title='desactivado' class='btn btn-fila-activar $disabled' href='$link?tarea=activar&estado=1&id=$id&id_mod=$id_mod' ><i class='icn-eye-close color-text-gris-a'></i></a>";
  		};
	}
	function estado_activar( $estado,$link,$id_mod,$disabled,$id){
		$link = _RUTA_WEB.$link;
    if (!empty($id_mod)){ $mod="&id_mod=".$id_mod; }else{ $mod=""; }
		if( $estado==1){
      		echo "<a title='activo' class='btn btn-fila-activar $disabled' href='$link&estado=0&id=$id$mod' ><i class='icn-eye-open color-text-negro-b'></i></a>";
  		}else{
      		echo "<a title='desactivado' class='btn btn-fila-activar $disabled' href='$link&estado=1&id=$id$mod' ><i class='icn-eye-close color-text-gris-a'></i></a>";
  		};
	}

	function script_busqueda($FileModulo){
  	?>
  		<script language="JavaScript">
  			function confirma_eliminacion(mod_id, mod_nombre, mod_tarea){
  			  url = "<?php echo $FileModulo; ?>&tarea="+ mod_tarea + "&id="+ mod_id;
  			  if (confirm('¿Está seguro que desea eliminar "'+ mod_nombre +'" \n el Registro de la Base de Datos?'))
  			  location=(url)
  			}

  		</script>
  	<?php
	}

	function script_page($FileModulo){
		?>
			<script language="JavaScript">
			$(document).ready(function()
			{

			});
			</script>
		<?php
	}  // fin script_busqueda()

	function script_form($ruta,$id_mod){
		?>
			<script language="JavaScript">
			$(document).ready(function() {
        $('.requerido').before('<span class="obligatorio">*</span>');
        $('.datetimepicker').datetimepicker({
          isRTL: false,
          format: 'dd/MM/yyyy',
          autoclose:true,
          language: 'es',
          keyboardNavigation : true
        }).on("changeDate", function(e){
          $(this).datetimepicker('hide');
        });

				$('#table_id').DataTable({
					"language": {
		            "url": "<?php echo _RUTA_WEB; ?>js/spanish_datatable.json"
		            },
		            "pageLength": 25,
		            "order": [[ 0, 'asc' ]]
				});
				$('#table_id_modal').DataTable({
					"language": {
		            "url": "<?php echo _RUTA_WEB; ?>js/spanish_datatable.json"
		            },
		            "pageLength": 25,
		            "order": [[ 0, 'asc' ]]
				});

				$(".btn-eliminar").click(function() {
					tarea = $( this ).attr("tarea");

          id = $( this ).attr("ide");
					nombre = $( this ).attr("nombre");
          idx = $( this ).attr("idEliminar");
					if (idx){
					  id = idx;
					  nombre = $( this ).attr("nombreEliminar");
          }

          <?php
            if (!empty($id_mod)){ $m ="&id_mod=".$id_mod; }else{ $m =""; }
          ?>
				  url = "<? echo _RUTA_WEB.$ruta; ?>?tarea="+ tarea +"<? echo $m; ?>&id="+id;
					if(confirm('¿Estas seguro de ELIMINAR: "'+ nombre +'" ?')){
					  //alert(url);
					  document.location.href=url;
					}
				});


				var adicionarImagen = function (context) {
				  var ui = $.summernote.ui;

				  // create button
				  var button = ui.button({
				    contents: '<i class="fa fa-picture-o"/>',
				    tooltip: 'imagen',
				    click: function () {
				      // invoke insertText method with 'hello' on editor module.
				       $( ".note-editable" ).append( "<p>hola</p>" );
				    }
				  });

				  return button.render();   // return button as jquery object
				}

				$('.summernote').summernote({
						height: 300,                 // set editor height
						minHeight: null,             // set minimum height of editor
						maxHeight: null,             // set maximum height of editor
						lang: 'es-ES',
						focus: false,
						toolbar: [
							['style', ['style','bold', 'italic', 'underline', 'clear','hr']],
						    ['font', ['strikethrough', 'superscript', 'subscript']],
						    ['fontsize', ['fontsize']],
						    ['color', ['color']],
						    ['para', ['ul', 'ol', 'paragraph']],
						    ['height', ['height']],
						    ['codeview',['codeview','fullscreen']],
						    ['mybutton', ['imagen','link']],

						  ],

						  buttons: {
						    imagen: adicionarImagen
						  }
				});
			} );
			</script>
		<?php
	}

  function fecha_hoy($zona){
    setlocale(LC_TIME,"es_ES");
    date_default_timezone_set($zona);
    return date("Y-m-d h:i");
  }

	function Estructurar_Fecha($Fecha){
	    $Fechas = explode("-", $Fecha);
	    $ano=$Fechas[0];
	    $mes=(string)(int)$Fechas[1];
	    $dia=(string)(int)$Fechas[2];


	    $day = array(' ','Lunes','Martes','Miercoles','Jueves','Viernes');
	    $month = array(' ','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');


	    $F .= "<span class='Dia'>".$dia." </span>";
	    $F .= "<span class='Mes'>".$month[$mes]." </span>";
	    $F .= "<span class='Ano'>".$ano." </span>";

		return $F;
	}

	function Estructurar_Fecha_input($Fecha){
	    $Fechas = explode("-", $Fecha);
	    $ano=$Fechas[0];
	    $mes=(string)(int)$Fechas[1];
	    $dia=(string)(int)$Fechas[2];
	    return $dia."/".$mes."/".$ano;
	}

	function Restructurar_Fecha($Fecha){
	    $Fechas = explode("/", $Fecha);
	    $ano=$Fechas[2];
	    $mes=(string)(int)$Fechas[1];
	    $dia=(string)(int)$Fechas[0];
	    return $ano."-".$mes."-".$dia;
	}

	function Fecha_Hora_Compacta($Fecha){
	    $FechaHora = explode(" ", $Fecha);
	    $Fechas = explode("-", $FechaHora[0]);
	    $Tiempo = explode (":", $FechaHora[1]);
	    $ano=$Fechas[0];
	    $mes=(string)(int)$Fechas[1];
	    $dia=$Fechas[2];
	    $hora = $Tiempo[0];
	    $min = $Tiempo[1];
	    $seg = substr($Tiempo[2], 0, 2);


	    $day = array(' ','Lun','Mar','Mie','Jue','Vie');
	    $month = array(' ','Ene','Feb','Mar','Abr','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');


	    $F .= " <span class='Dia'>".$dia." </span>";
	    $F .= " <span class='Mes'>".$month[$mes]." </span>";
	    $F .= " <span class='Ano'>".$ano." </span>";
	    $F .= "<span class='Hora'>".$hora."</span>";
	    $F .= "<span class='Min'>".$min."</span>";
	    $F .= "<span class='Seg'>".$seg."</span>";

		return $F;
	}

	function Fecha_Compacta($Fecha){
	    $Fechas = explode("-", $Fecha);
	    $ano=$Fechas[0];
	    $mes=(string)(int)$Fechas[1];
	    $dia=(string)(int)$Fechas[2];


	    $day = array(' ','Lun','Mar','Mie','Jue','Vie');
	    $month = array(' ','Ene','Feb','Mar','Abr','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');


	    $F .= "<span class='Dia'>".$dia." </span>";
	    $F .= "<span class='Mes'>".$month[$mes]." </span>";
	    $F .= "<span class='Ano'>".$ano." </span>";

		return $F;
	}

	function icono_modulo($id){
		$sql="select mod_icono from modulos where mod_id=$id";
		$rs=$this->fmt->query->consulta($sql);
		$fila=$this->fmt->query->obt_fila($rs);
		return $fila["mod_icono"];
	} //Fion nombre usuario

	function mombre_modulo($id){
		$sql="select mod_nombre from modulos where mod_id=$id";
    $rs=$this->fmt->query->consulta($sql);
		$fila=$this->fmt->query->obt_fila($rs);
		return $fila["mod_nombre"];
	} //Fion nombre usuario

  function fila_modulo($id,$fila,$from,$prefijo){
		$sql="select ".$prefijo.$fila." from ".$from." where ".$prefijo."id=$id";
    $rs=$this->fmt->query->consulta($sql);
		$filax=$this->fmt->query->obt_fila($rs);
		return $filax[$prefijo.$fila];
	} //Fion nombre usuario

  function cambiar_tumb($ruta){
    $arrayName = array(".jpg",".png");
    $arrayVar = array("_thumb.jpg","_thumb.png");
    $ruta = str_replace($arrayName, $arrayVar, $ruta);
    return $ruta;
  }
	function get_modulo_id (){

		if (isset($_GET['mod_id'])){
		return $_GET['mod_id'];
		}else {
		return 0;
		}

	}

	function eliminar_get_id($from,$prefijo){
		$this->fmt->get->validar_get( $_GET['id'] );
		$id= $_GET['id'];
		$sql="DELETE FROM ".$from." WHERE ".$prefijo."id='".$id."'";
		$this->fmt->query->consulta($sql);
		$up_sqr6 = "ALTER TABLE ".$from." AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);
		return;
	}

	function eliminar_fila($valor,$from,$fila){
		$sql="DELETE FROM ".$from." WHERE ".$fila."='".$valor."'";
		$this->fmt->query->consulta($sql);
		$up_sqr6 = "ALTER TABLE ".$from." AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);
		return;
	}

	function activar_get_id($from,$prefijo){
		$this->fmt->get->validar_get ( $_GET['estado'] );
	    $this->fmt->get->validar_get ( $_GET['id'] );
	    $sql="update ".$from." set
	        ".$prefijo."activar='".$_GET['estado']."' where ".$prefijo."id='".$_GET['id']."'";
	    $this->fmt->query->consulta($sql);
	}

	function sistemas_modulos_select($label,$id,$class_div,$ids_sis,$ids_mod,$ids_per){
	?>
		<div class="form-group <?php echo $class_div; ?>">
			<label><?php echo $label; ?></label>
			<div class='arbol-cat'>
		<?php

		$sql="SELECT sis_id, sis_nombre, sis_icono FROM sistemas WHERE sis_activar=1";
		$rs=$this->fmt->query->consulta($sql);
		$num = $this->fmt->query->num_registros($rs);

		if($num>0){
			for($i=0;$i<$num;$i++){
				list($fila_id, $fila_nombre, $fila_icono)=$this->fmt->query->obt_fila($rs);
				$aux_s="";
				if (in_array($fila_id, $ids_sis))
						$aux_s="checked";

				echo "<label><input name='inputSis[]' type='checkbox' id='sis-$fila_id' class='cbx-sis' value='$fila_id' $aux_s> <i class='$fila_icono'></i><span>".$fila_nombre."</span></label>";

				$sql1="SELECT DISTINCT mod_id, mod_nombre, mod_icono FROM modulos,sistemas,sistemas_modulos WHERE sistemas_sis_id='$fila_id' and mod_id=modulos_mod_id and mod_activar='1' ORDER BY mod_nombre asc" ;
				$rs1=$this->fmt->query->consulta($sql1);
				$num1 = $this->fmt->query->num_registros($rs1);

				if($num1>0){
					for($j=0;$j<$num1;$j++){
						list($fila1_id, $fila1_nombre, $fila1_icono)=$this->fmt->query->obt_fila($rs1);
						$aux_m="";

						$ver_m="";
						$act_m="";
						$agr_m="";
						$edt_m="";
						$elm_m="";

						$ver="1";
						$act="1";
						$agr="1";
						$edt="1";
						$elm="1";
						if (in_array($fila1_id, $ids_mod)){
							$aux_m="checked";
							$ver=$ids_per[$fila1_id]["ver"];
							if($ver==0)
								$ver_m=" on";
							$act=$ids_per[$fila1_id]["act"];
							if($act==0)
								$act_m=" on";
							$agr=$ids_per[$fila1_id]["agr"];
							if($agr==0)
								$agr_m=" on";
							$edt=$ids_per[$fila1_id]["edt"];
							if($edt==0)
								$edt_m=" on";
							$elm=$ids_per[$fila1_id]["eli"];
							if($elm==0)
								$elm_m=" on";
						}


						echo "<div class='box-ms clear-both'><label style='margin-left:20px'> <input name='inputMod[]' type='checkbox' id='mod-$fila1_id' ids='$fila_id' class='cbx-mod msis-$fila_id' value='$fila1_id' $aux_m > <i class='$fila1_icono'></i><span>".$fila1_nombre."</span></label>
            <i ids='".$fila1_id."' id='bv-".$fila1_id."' title='Ver' nom='v' class='btn-permiso btn-ver icn-search$ver_m'></i>
            <input type='hidden' name='input_v$fila1_id' id='v-".$fila1_id."'   value='$ver' >
            <i ids='".$fila1_id."' id='bp-".$fila1_id."' title='Activar' nom='p' class='btn-permiso btn-publicar icn-eye-open$act_m' ></i>
            <input type='hidden' name='input_p$fila1_id' id='p-".$fila1_id."'   value='$act' >
            <i ids='".$fila1_id."' id='ba-".$fila1_id."' title='Activar' nom='a' class='btn-permiso btn-a icn-plus$agr_m' ></i>
            <input type='hidden' name='input_a$fila1_id' id='a-".$fila1_id."'   value='$agr' >
            <i ids='".$fila1_id."' id='be-".$fila1_id."' title='Editar' nom='e' class='btn-permiso btn-editar icn-pencil$edt_m' ></i>
            <input type='hidden' name='input_e$fila1_id' id='e-".$fila1_id."'    value='$edt' >
            <i ids='".$fila1_id."' id='bt-".$fila1_id."' title='Eliminar' nom='t' class='btn-permiso btn-trash icn-trash$elm_m' ></i>
            <input type='hidden' name='input_t$fila1_id' id='t-".$fila1_id."'   value='$elm' >
            </div>";
					}
				}
			}
		}

		?>
			</div>
			<script language="JavaScript">
				$(document).ready(function() {


					$(":checkbox").change(function() {
						var id = $(this).val();
						if ($(this).is(':checked')) {
							$(".msis-"+id).prop('checked', true );
						}else{
							$(".msis-"+id).prop('checked', false );
						}
						if ($(".cbx-mod").is(':checked')) {
							var ids = $(this).attr('ids');
							//alert(ids);
							$("#sis-"+ids).prop('checked', true );
						}
					});

          $(".btn-permiso").click(function(event) {
            var id = $(this).attr('ids');
            var nom = $(this).attr('nom');
            var valor = $("#"+nom+"-"+id).val();
            //alert("#"+nom+"-"+id+":"+ valor);
            $(this).toggleClass('on');
            if (valor=="0"){
              $("#"+nom+"-"+id).val("1");
            }else{
              $("#"+nom+"-"+id).val("0");
            }
          });

				});
			</script>
		</div>
		<?php
	}

	function grupos_select($label,$id,$class_div,$group){
		?>
		<div class="form-group <?php echo $class_div; ?>">
			<label><?php echo $label; ?></label>
			<div class='arbol-cat'>
				<?php

		$sql="SELECT grupo_id, grupo_nombre, grupo_detalle FROM grupos WHERE grupo_activar=1";
		$rs=$this->fmt->query->consulta($sql);
		$num = $this->fmt->query->num_registros($rs);

		if($num>0){
			for($i=0;$i<$num;$i++){
				list($fila_id, $fila_nombre, $fila_detalle)=$this->fmt->query->obt_fila($rs);
				$ck="";
				if(in_array($fila_id, $group))
					$ck="checked";
				echo "<label><input name='".$id."[]' ".$ck." type='checkbox' id='sis-$fila_id' class='cbx-sis' value='$fila_id'> <i class='$fila_icono'></i><span>$fila_nombre : $fila_detalle</span></label>";
				}
			}
		?>
			</div>
		</div>
		<?php
	}

  function traer_roles_rel_sis_id($id){
    $sql="SELECT DISTINCT rol_rel_sis_id FROM roles_rel WHERE rol_rel_rol_id='$id' and rol_rel_sis_id not in (0) ";
    $rs=$this->fmt->query->consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila['rol_rel_sis_id'];
  }

  function traer_roles_rel_mod_id($id){
    $sql="SELECT DISTINCT rol_rel_mod_id FROM roles_rel WHERE rol_rel_rol_id='$id' and rol_rel_mod_id not in (0) ";
    $rs=$this->fmt->query->consulta($sql);
    $num = $this->fmt->query->num_registros($rs);
    if($num>0){
			for($i=0;$i<$num;$i++){
        list($fila_id)=$this->fmt->query->obt_fila($rs);
        $aux[$i] = $fila_id;
      }
    }
    return $aux;
  }

  function traer_roles_rel_mod_id_permisos($id){

	$sql="SELECT DISTINCT rol_rel_mod_id, rol_rel_mod_p_ver, rol_rel_mod_p_activar,  rol_rel_mod_p_agregar, rol_rel_mod_p_editar, rol_rel_mod_p_eliminar FROM roles_rel WHERE rol_rel_rol_id='$id' and rol_rel_mod_id not in (0) ";
    $rs=$this->fmt->query->consulta($sql);
    $num = $this->fmt->query->num_registros($rs);
    if($num>0){
			for($i=0;$i<$num;$i++){
        list($fila_id, $fila_ver, $fila_activar, $fila_agregar, $fila_editar, $fila_eliminar)=$this->fmt->query->obt_fila($rs);
        $aux[$fila_id]["ver"] = $fila_ver;
        $aux[$fila_id]["act"] = $fila_activar;
        $aux[$fila_id]["agr"] = $fila_agregar;
        $aux[$fila_id]["edt"] = $fila_editar;
        $aux[$fila_id]["eli"] = $fila_eliminar;
      }
    }


    return $aux;
  }

  function actualizar_tabla($from,$filas,$valores_post){
    $filas = str_replace("[\n|\r|\n\r|\t| ]","",$filas);
    $valores_post = eregi_replace("[\n|\r|\n\r|\t| ]","",$valores_post);
    $filas1= explode(',',$filas);
    $valores_post1= explode(',',$valores_post);
    //var_dump($valores_post1);
    $num_filas = count($filas1);
    $num_post = count($valores_post1);
    $valores ="";
        if ($num_filas==$num_post){
          for ($i=1; $i < $num_filas; $i++) {
            $x=$valores_post1[$i];
            $y= $_POST[$x];
            if ( $i==$num_filas-1){ $aux=""; }else{ $aux=","; };
            $valores .=$filas1[$i].'="'.$y.'"'.$aux;
          }
        }else{
          $this->fmt->error->error_parametrizacion();
        }

        $campo_id=$filas1[0];
        $f=$valores_post1[0];
        $id= $_POST[$f];
    		$sql="UPDATE $from SET ".$valores." WHERE ".$campo_id."='".$id."'";
  			$this->fmt->query->consulta($sql);
  }

  function ingresar_tabla($from,$filas,$valores_post){
    $filas = str_replace("[\n|\r|\n\r|\t| ]","",$filas);
    $valores_post = eregi_replace("[\n|\r|\n\r|\t| ]","",$valores_post);
    $valores_post1= explode(',',$valores_post);
    //var_dump($valores_post1);
    $num_filas = count($filas1);
    $num_post = count($valores_post1);
    $valores ="";
        if ($num_filas==$num_post){
          for ($i=0; $i < $num_filas; $i++) {
            $x=$valores_post1[$i];
            $y= $_POST[$x];
            if ( $i==$num_filas-1){ $aux=""; }else{ $aux=","; };
            $valores .=$filas1[$i].'="'.$y.'"'.$aux;
          }
        }else{
          $this->fmt->error->error_parametrizacion();
        }

        echo $sql="insert into $from (".$filas.") values (".$valores.")";
        //$this->fmt->query->consulta($sql);
  }

}
?>
