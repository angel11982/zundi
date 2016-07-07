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
				$(".btn-eliminar").click(function() {
					tarea = $( this ).attr("tarea");
					if ( tarea != "eliminar" ){
						id = $( this ).attr("idEliminar");
						nombre = $( this ).attr("nombreEliminar");
					}else{
						id = $( this ).attr("ide");
						nombre = $( this ).attr("nombre");
					}
					
				  url = "<? echo _RUTA_WEB.$ruta; ?>?tarea=eliminar&id_mod=<? echo $id_mod; ?>&id="+id;
					if(confirm('¿Estas seguro de ELIMINAR: "'+ nombre +  '" ?')){
					  //alert(url);
					  document.location.href=url;
					}
				});

			$(document).ready( function () {
				$('#table_id').DataTable({
					"language": {
		            "url": "<?php echo _RUTA_WEB; ?>js/spanish_datatable.json"
		            },
		            "pageLength": 25,
		            "order": [[ 0, 'desc' ]]
				});
				
				var adicionarImagen = function (context) {
				  var ui = $.summernote.ui;
				  
				  // create button
				  var button = ui.button({
				    contents: '<i class="icon-picture"/>',
				    tooltip: 'imagen',
				    click: function () {
				      // invoke insertText method with 'hello' on editor module. 
				       $( ".note-editable" ).append( "<p>hola</p>" );
				    }
				  });
				
				  return button.render();   // return button as jquery object 
				}
				
				$('#summernote').summernote({
						height: 300,                 // set editor height
						minHeight: null,             // set minimum height of editor
						maxHeight: null,             // set maximum height of editor
						lang: 'es-ES',
						focus: true, 
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

}
?>
