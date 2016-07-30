<?php
header("Content-Type: text/html;charset=utf-8");

class KARDEX{

	var $fmt;
	var $id_mod;

	function KARDEX($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

	function busqueda(){
		$botones .= $this->fmt->class_pagina->crear_btn("kardex-config.adm.php","btn btn-link","icn-conf","Configuraciones");

		$botones .= $this->fmt->class_pagina->crear_btn("kardex.adm.php?tarea=form_nuevo&id_mod=$this->id_mod","btn btn-primary","icn-plus","Nuevo Registro");

		$this->fmt->class_pagina->crear_head( $this->id_mod,$botones); // bd, id modulo, botones

  }

  function form_nuevo(){
    $this->fmt->form->head_nuevo('Nuevo registro','kardex',$this->id_mod,'','form_nuevo','form_kardex',''); //$nom,$archivo,$id_mod,$botones,$id_form,$class,$modo
		?>
		<div class="box-pasos">
			<a class="paso on" idf="form-paso-1" id='paso-1'><num>1</num><label>Datos personales</label><hr class="barra"></a>
			<a class="paso" idf="form-paso-2" id='paso-2'><num>2</num><label>Datos Laborales actuales</label><hr class="barra"></a>
			<a class="paso" idf="form-paso-3" id='paso-3' ><num>3</num><label>Formación</label><hr class="barra"></a>
			<a class="paso" idf="form-paso-4" id='paso-4'><num>4</num><label>Datos Laborales corpororación</label><hr class="barra"></a>
			<a class="paso" idf="form-paso-5" id='paso-5'><num>5</num><label>Consolidado</label></a>
		</div>

		<div class="form-paso on animated fadeIn " id='form-paso-1'>
			<? $this->paso_1_nuevo(); ?>
			<div class='clearfix'></div>
			<a class="btn btn-info btn-siguiente pull-right btn-lg clear-both" paso-siguiente='2'>Siguiente <i class="icn-chevron-right"></i></a>
		</div>

		<div class="form-paso animated fadeIn" id='form-paso-2'>
			<? $this->paso_2_nuevo(); ?>
			<div class='clearfix'></div>
			<a class="btn btn-info btn-anterior   btn-lg " paso-anterior='1'>Anterior <i class="icn-chevron-right"></i></a>
			<a class="btn btn-info btn-siguiente pull-right btn-lg " paso-siguiente='3'>Siguiente <i class="icn-chevron-right"></i></a>
		</div>
		<div class="form-paso animated fadeIn" id='form-paso-3'>paso 3</div>
		<div class="form-paso animated fadeIn" id='form-paso-4'>paso 4</div>
		<div class="form-paso animated fadeIn" id='form-paso-5'>paso 5</div>
		<script>
			$(document).ready(function () {
				$(".paso").click(function(event) {
					var id = $(this).attr('idf');
					$(".paso").removeClass('on');
					$(".form-paso").removeClass('on');
					$("#"+id).addClass('on');
					$(this).addClass('on');
					/* Act on the event */
				});

				$(".btn-siguiente").click(function(event) {
					var id = $(this).attr('paso-siguiente');
					$(".paso").removeClass('on');
					$(".form-paso").removeClass('on');
					$("#form-paso-"+id).addClass('on');
					$("#paso-"+id).addClass('on');
				});
				$(".btn-anterior").click(function(event) {
					var id = $(this).attr('paso-anterior');
					$(".paso").removeClass('on');
					$(".form-paso").removeClass('on');
					$("#form-paso-"+id).addClass('on');
					$("#paso-"+id).addClass('on');
				});
			});
		</script>
		<?php
    $this->fmt->form->footer_page();
  }

	function paso_1_nuevo(){
		echo "<h3>Datos personales</h3>";
		$this->fmt->form->input_form('Nombre Completo:','inputNombre','','','requerido requerido-texto','box-md-4',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('Apellido Paterno:','inputApellidoPaterno','','','requerido requerido-texto','box-md-4',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('Apellido Materno:','inputApellidoMaterno','','','requerido requerido-texto','box-md-4',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('CI/DNI:','inputIdentificacion','','','requerido requerido-texto','box-md-2','');
		$options = $this->extensiones();
		$valores = $this->extensiones();
		$this->fmt->form->select_form_simple('Extensión:','inputExtension',$options,$valores,'','','box-md-1'); //$label,$id,$options,$valores,$desabilitado,$defecto,$class_div
		$this->fmt->form->input_date('Fecha de vencimiento CI/DNI:','inputFechaVencimientoCiDni','','','','box-md-3',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_date('Fecha de vencimiento de licencia de conducir:','inputFechaVencimientoLicenciaConducir','','','','box-md-4',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_date('Fecha de nacimiento:','inputFechaNaciento','','','','box-md-2',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('Nacionalidad:','inputNacionalidad','','','requerido requerido-texto','box-md-3',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('Lugar de nacimiento','inputLugarNacimiento','','','requerido requerido-texto','box-md-3',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$options=array("M","F","otro");
		$valores=array("0","1","2");
		$this->fmt->form->select_form_simple('Sexo:','inputSexo',$options,$valores,'','','box-md-1'); //$label,$id,$options,$valores,$desabilitado,$defecto,$class_div
		$options=array("Soltero(a)","Casado(a)","Divorciado(a)","Viudo(a)","Concubino(a)");
		$valores=array("0","1","2","3","4");
		$this->fmt->form->select_form_simple('Estado Civil:','inputEstadoCivil',$options,$valores,'','','box-md-1'); //$label,$id,$options,$valores,$desabilitado,$defecto,$class_div
		$this->fmt->form->input_form('Tipo de sangre:','inputTipoSangre','','','requerido requerido-texto','box-md-2',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('Telf. Domicilio','inputTelefonoDomicilio','','','requerido requerido-telefono','box-md-3 clear-left','Ej: (591) 3 340-32323'); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('Telf. Corporativo','inputTelefonoCorporativo','','','requerido requerido-telefono','box-md-2','Ej: (591) 3 340-32323'); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('Interno:','inputInterno','','','requerido requerido-numero','box-md-1',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('Celular personal:','inputCelularPersonal','','','requerido requerido-celular','box-md-3','Ej: (591) 755-23452'); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('Celular Corporativo:','inputCelularCorporativo','','','requerido requerido-celular','box-md-3','Ej: (591) 755-23452'); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('E-mail personal:','inputEmailPersonal','@','','requerido requerido-email','box-md-4',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('E-mail Corporativo:','inputEmailCorporativo','@','','requerido requerido-email','box-md-4',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('Dirección Domicilio:','inputDireccionDomicilio','','','requerido requerido-email','box-md-7 clear-left',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('Mapa Domicilio:','inputMapaDomicilio','','','requerido requerido-email','box-md-2',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('Dirección Empresa:','inputDireccionDomicilio','','','mapa','box-md-7 clear-left',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('Mapa Empresa:','inputMapaEmpresa','','','mapa','box-md-2 ',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		$this->fmt->form->input_form('Nro. Afiliación CNS:','inputAfiliacionCNS','','','requerido requerido-texto','box-md-3 clear-left','');
		$this->fmt->form->input_form('Nro. Afiliación AFP:','inputAfiliacionAFP','','','requerido requerido-texto','box-md-3','');
		$options=array(" ","AFP Previsión","AFP Futuro");
		$valores=array("0","1","2");
		$this->fmt->form->select_form_simple('AFP:','inputAFP',$options,$valores,'','','box-md-2');
		$this->fmt->form->input_form('Talla de camisa:','inputTallaCamisa','','','','box-md-2 clear-left','');
		$this->fmt->form->input_form('Talla de pantalón:','inputTallaPantalon','','','','box-md-2','');
		$this->fmt->form->input_form('Talla de botines:','inputTallaBotines','','','','box-md-2','');
		echo "<h3 class='clear-both'>Datos Familia</h3>";
		$this->fmt->form->input_form('Nombre Completo Esposo(a):','inputEsposa','','','','box-md-7',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_date('Fecha cumpleaños esposo(a):','inputFechaCumpleEsposa','','','','box-md-3',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje

		echo "<div class='box-hijos'>";
		echo "<div class='box-hijo clear-both' id='klon1'>";
		$this->fmt->form->input_form('Nombre Completo hijo(a):','inputNombreHijo[]','','','','box-md-7 clear-left',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_date('Fecha cumpleaños hijo(a):','inputFechaCumpleHijo[]','','','','box-md-3',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		//echo '<a class="btn-eliminar-box-hijo color-text-rojo"><i class="icn-close"></i></a>';
		echo "</div>";
		echo "</div>";
		echo "<a class='btn btn-success clear-both box-md-2 btn-ahijo'><i class='icn-plus'></i> Añadir hijo(a)</a>";

		echo "<div class='clearfix'></div>";

		echo "<h3 class='clear-both'>Datos Referencias</h3>";
		$this->fmt->form->input_form('Nombre Completo Ref. Emergencia:','inputNombreEmergencia','','','','box-md-7 clear-both',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
 		$this->fmt->form->input_form('Telf. Emergencia','inputTelefonoEmergencia','','','','box-md-3','Ej: (591) 3 340-32323 o (591) 768-78789');

		echo "<div class='box-referencias'>";
		echo "<div class='box-referencia clear-both' id='kref_1'>";
		$this->fmt->form->input_form('Nombre Completo Referencia:','inputNombreReferencia[]','','','','box-md-7 clear-left',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
			$this->fmt->form->input_form('Telf. Referencia','inputTelefonoReferencia','','','','box-md-3','Ej: (591) 3 340-32323 o (591) 768-78789'); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		echo "</div>";
		echo "</div>";
		echo "<a class='btn btn-success clear-both box-md-2 btn-ref'><i class='icn-plus'></i> Añadir Referencia</a>";

		$this->fmt->class_modulo->script_form("modulos/rrhh/kardex.adm.php",$this->id_mod);
		?>
		<script>
			$(document).ready(function () {
				$(".btn-ahijo").click(function(event) {
					//var $button = $("#klon1").clone();
					var $div = $('div[id^="klon"]:last');
					var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
					var $klon = $div.clone().prop('id', 'klon'+num );
					$('.box-hijos').append($klon).append('<a class="btn-eliminar-box-hijo pull-left color-text-rojo" v="klon'+num+'"><i class="icn-close"></i></a>');

					$('.datetimepicker').datetimepicker({
						isRTL: false,
						format: 'dd/MM/yyyy',
						autoclose:true,
						language: 'es',
						keyboardNavigation : true
					}).on("changeDate", function(e){
						$(this).datetimepicker('hide');
					});
					$(".btn-eliminar-box-hijo").click(function(event) {
						//alert("hola");
						var id = $(this).attr('v');
						$("#"+id).remove();
						$(this).remove();
					});
				});

				$(".btn-ref").click(function(event) {
					//var $button = $("#klon1").clone();
					var $divz = $('div[id^="kref_"]:last');
					var numz = parseInt( $divz.prop("id").match(/\d+/g), 10 ) +1;
					var $klonz = $divz.clone().prop('id', 'kref_'+numz );
					$('.box-referencias').append($klonz).append('<a class="btn-eliminar-box-ref pull-left color-text-rojo" v="kref_'+numz+'"><i class="icn-close"></i></a>');

					$(".btn-eliminar-box-ref").click(function(event) {
						//alert("hola");
						var id = $(this).attr('v');
						$("#"+id).remove();
						$(this).remove();
					});
				});

			});
		</script>
		<?php
	}

	function paso_2_nuevo(){
		echo "<h3>Datos Laborales actuales</h3>";
	}

	function extensiones(){
		$ext[0] = '';
		$ext[1] = 'SC';
		$ext[2] = 'LP';
		$ext[3] = 'CB';
		$ext[4] = 'CH';
		$ext[5] = 'OR';
		$ext[6] = 'PD';
		$ext[7] = 'PT';
		$ext[8] = 'TR';
		$ext[9] = 'BN';

		return $ext;
	}

}
