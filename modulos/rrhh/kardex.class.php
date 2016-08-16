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
			<a class="btn btn-info btn-anterior   btn-lg " paso-anterior='1'>Anterior <i class="icn-chevron-left"></i></a>
			<a class="btn btn-info btn-siguiente pull-right btn-lg " paso-siguiente='3'>Siguiente <i class="icn-chevron-right"></i></a>
		</div>
		<div class="form-paso animated fadeIn" id='form-paso-3'>
			<? $this->paso_3_nuevo(); ?>
			<div class='clearfix'></div>
			<a class="btn btn-info btn-anterior   btn-lg " paso-anterior='2'>Anterior <i class="icn-chevron-left"></i></a>
			<a class="btn btn-info btn-siguiente pull-right btn-lg " paso-siguiente='4'>Siguiente <i class="icn-chevron-right"></i></a>
		</div>
		<div class="form-paso animated fadeIn" id='form-paso-4'>
			<? $this->paso_4_nuevo(); ?>
			<a class="btn btn-info btn-anterior   btn-lg " paso-anterior='3'>Anterior <i class="icn-chevron-left"></i></a>
			<a class="btn btn-info btn-siguiente pull-right btn-lg " paso-siguiente='5'>Siguiente <i class="icn-chevron-right"></i></a>
		</div>
		<div class="form-paso animated fadeIn" id='form-paso-5'>
			<? $this->paso_5_nuevo(); ?>
			<button type="submit" class="btn btn-info  pull-right btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" disabled="true" value="guardar"><i class="icn-save" ></i> Guardar</button>
			<button type="submit" class="btn btn-success  pull-right color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" disabled="true" value="activar"><i class="icn-eye-open" ></i> Activar</button>
			<a class="btn btn-info btn-anterior   btn-lg " paso-anterior='4'>Anterior <i class="icn-chevron-right"></i></a>
		</div>
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
		$this->fmt->form->input_file("Cargar Imagen:","inputImagen","","","","box-md-4","Archivo no mayo a 1M jpg,png","",""); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		echo "<div class='clearfix'></div>";
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


					$('.dp').datetimepicker({
						format: 'dddd, LL',
						locale: 'es'
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
		$this->fmt->form->select_form("Empresa actual:","inputEmpresaActual","mod_kdx_emp_","mod_kardex_empresa","","","box-md-3"); //$label,$id,$prefijo,$from,$id_select,$id_disabled
		$this->fmt->form->select_form("División/área:","inputDivision","mod_kdx_div_","mod_kardex_division","","","box-md-4"); //$label,$id,$prefijo,$from,$id_select,$id_disabled
		$this->fmt->form->select_form("Cargo Actual:","inputCargoActual","mod_kdx_car_","mod_kardex_cargo","","","box-md-4"); //$label,$id,$prefijo,$from,$id_select,$id_disabled

		$options=$this->departamentos();
		$valores=$this->departamentos();
		$this->fmt->form->select_form_simple('Departamentos:','inputDepartamento',$options,$valores,'','','box-md-4');
		$this->fmt->form->input_date('Fecha de ingreso:','inputIngresoEmpresaActual','','','','box-md-3',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_date('Fecha de retiro:','inputRetiroActual','','','','box-md-3','','retiro-actual'); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('Antiguedad (años):','inputAntiguedad','','','','box-md-2','');
		$this->fmt->form->input_form('CODIGO SAP:','inputCodigoSAP','','','','box-md-3','');
		$this->fmt->form->input_form('Cuenta abono de sueldo (Bmsc):','inputCuentaSueldo','','','','box-md-4','');
		echo "<div class='box-bancos'>";
		echo "<div class='box-banco clear-both' id='kcuenta_1'>";
		$this->fmt->form->input_form('Cuenta Banco:','inputCuentaBanco[]','','','','box-md-5 clear-left',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$options=$this->bancos();
		$valores= array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15");
		$this->fmt->form->select_form_simple('Banco:','inputBanco[]',$options,$valores,'','','box-md-4');
		echo "</div>";
		echo "</div>";
		echo "<a class='btn btn-success clear-both box-md-2 btn-acuenta'><i class='icn-plus'></i> Añadir otra cuenta</a>";
		echo "<div class='clearfix'></div>";

		$options=$this->contratos();
		$valores= array("0","1","2","3","4","5");
		$this->fmt->form->select_form_simple('Formato de Contrato:','inputFormatoContrato',$options,$valores,'','','box-md-3');

		?>
		<script>
			$(document).ready(function () {
				$(".btn-acuenta").click(function(event) {
					//var $button = $("#klon1").clone();
					var $div = $('div[id^="kcuenta"]:last');
					var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
					var $klon = $div.clone().prop('id', 'kcuenta'+num );
					$('.box-bancos').append($klon).append('<a class="btn-eliminar-box-cuenta pull-left color-text-rojo" v="kcuenta'+num+'"><i class="icn-close"></i></a>');


					$('.dp').datetimepicker({
						format: 'DD/MM/YYYY',
						locale: 'es'
					});

					$(".btn-eliminar-box-cuenta").click(function(event) {
						//alert("hola");
						var id = $(this).attr('v');
						$("#"+id).remove();
						$(this).remove();
					});
				});
				$(".dp").on("dp.change", function (e) {
					var fecha_in=$("#inputIngresoEmpresaActual").val();
					var fecha_hoy="<?php echo date("Y-m-d");?>";
					var dia = 86400000;
					var anho = dia * (365);
					fecha_in = CambiarFormatFecha(fecha_in);
					var diferencia =  Math.floor(( Date.parse(fecha_hoy) - Date.parse(fecha_in) ) / anho);
					// if(diferencia < 0){
					// diferencia = diferencia*(-1);
					// }
					$("#inputAntiguedad").val(diferencia);
				});
		});
		function CambiarFormatFecha(fecha){
			var dato = fecha.split("/");
			return dato[2]+"-"+dato[1]+"-"+dato[0];
		}
		</script>
		<?php

	}

	function paso_3_nuevo(){
		echo "<h3>Datos Formación</h3>";
		$this->fmt->form->input_file("Cargar CV:","inputCV","Cargar CV","","","box-md-4","Archivo no mayo a 8M pdf,doc","",""); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje,$disabled,$validar
		echo "<div class='clearfix'></div>";
		$options=$this->nivel_formacion();
		$valores= array("0","1","2","3","4","5","6","7");
		$this->fmt->form->select_form_simple('Nivel Educación:','inputNivelEducacion[]',$options,$valores,'','','box-md-4');
		echo "<div class='clearfix'></div>";
		echo "<h3>Formación profesional</h3>";
		echo "<div class='box-estudios'>";
		echo "<div class='box-titulo clear-both' id='kt_1'>";
		$this->fmt->form->input_form('Titulo:','inputTitulo[]','','','','box-md-4 ',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('Institución:','inputInstitucion[]','','','','box-md-3  ','');
		$this->fmt->form->input_date('Fecha de obtención:','inputFechaTitulo[]','','','','box-md-3','','');
		echo "</div>";
		echo "</div>";
		echo "<a class='btn btn-success clear-both box-md-2 btn-atitulo'><i class='icn-plus'></i> Añadir Titulo</a>";
		echo "<div class='clearfix'></div>";

		echo "<h3>Formación Complementaria</h3>";
		echo "<div class='box-estudiosc'>";
		echo "<div class='box-curso clear-both' id='kc_1'>";
		$this->fmt->form->input_form('Nombre del curso/capacitación:','inputCurso[]','','','','box-md-4 ',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_form('Institución:','inputInstitucionCurso[]','','','','box-md-3  ','');
		$this->fmt->form->input_date('Fecha de obtención:','inputFechaCurso[]','','','','box-md-3','','');
		echo "</div>";
		echo "</div>";
		echo "<a class='btn btn-success clear-both box-md-3 btn-acurso'><i class='icn-plus'></i> Añadir Curso/Capacitación</a>";
		echo "<div class='clearfix'></div>";
		?>
		<script>
			$(document).ready(function () {
				$(".btn-atitulo").click(function(event) {
					//var $button = $("#klon1").clone();
					var $div = $('div[id^="kt"]:last');
					var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
					var $klon = $div.clone().prop('id', 'kt'+num );
					$('.box-estudios').append($klon).append('<a class="btn-eliminar-box-titulo pull-left color-text-rojo" v="kt'+num+'"><i class="icn-close"></i></a>');


					$('.dp').datetimepicker({
						format: 'DD/MM/YYYY',
						locale: 'es'
					});

					$(".btn-eliminar-box-titulo").click(function(event) {
						//alert("hola");
						var id = $(this).attr('v');
						$("#"+id).remove();
						$(this).remove();
					});
				});

				$(".btn-acurso").click(function(event) {
					//var $button = $("#klon1").clone();
					var $div = $('div[id^="kc"]:last');
					var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
					var $klon = $div.clone().prop('id', 'kc'+num );
					$('.box-estudiosc').append($klon).append('<a class="btn-eliminar-box-curso pull-left color-text-rojo" v="kc'+num+'"><i class="icn-close"></i></a>');


					$('.dp').datetimepicker({
						format: 'DD/MM/YYYY',
						locale: 'es'
					});

					$(".btn-eliminar-box-curso").click(function(event) {
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

	function paso_4_nuevo(){
		echo "<h3>Datos Laborales Coorporativos</h3>";

		$this->fmt->form->input_form('Empresa Anterior:','inputEmpresaAnterior','','','','box-md-3','');
		$this->fmt->form->input_form('Cargo:','inputEmpresaAnterior','','','','box-md-3','');
		$this->fmt->form->input_date('Fecha de ingreso:','inputIngresoEmpresaAnterior','','','','box-md-3','');
		$this->fmt->form->input_date('Fecha de retiro:','inputRetiroAnterior','','','','box-md-3','','retiro-actual');
		$this->fmt->form->input_form('Antiguedad (años):','inputAntiguedadAnterior','','','','box-md-2','');
		echo "<div class='clearfix'></div>";
		echo "<h3>Historial oorporativo</h3>";
		echo "<div class='box-otros-cargos'>";
		echo "<div class='box-otros clear-both' id='kcorp_1'>";
			$this->fmt->form->select_form("Empresa:","inputEmpresaAnterior[]","mod_kdx_emp_","mod_kardex_empresa","","","box-md-3");
			$this->fmt->form->input_date('Fecha de ingreso:','inputIngresoEmpresa[]','','','','box-md-2',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
			$this->fmt->form->input_date('Fecha de retiro:','inputRetiro[]','','','','box-md-2','','retiro-actual');
			$this->fmt->form->select_form("Cargo:","inputCargo[]","mod_kdx_car_","mod_kardex_cargo","","","box-md-4");
		echo "</div>";

		echo "</div>";
		echo "<a class='btn btn-success clear-both box-md-2 btn-acargo'><i class='icn-plus'></i> Añadir otra cargo</a>";
		echo "<div class='clearfix'></div>";
		?>
		<script>
			$(document).ready(function () {
				$(".btn-acargo").click(function(event) {
					//var $button = $("#klon1").clone();
					var $div = $('div[id^="kcorp"]:last');
					var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
					var $klon = $div.clone().prop('id', 'kcorp'+num );
					$('.box-otros-cargos').append($klon).append('<a class="btn-eliminar-box-cargo pull-left color-text-rojo" v="corp'+num+'"><i class="icn-close"></i></a>');


					$('.dp').datetimepicker({
						format: 'DD/MM/YYYY',
						locale: 'es'
					});

					$(".btn-eliminar-box-cargo").click(function(event) {
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

	function paso_5_nuevo(){
		echo "<h3>Consolidado</h3>";
		$this->fmt->form->input_form('E-mail /Usuario:','inputEmailUsuario','','','','box-md-5','');
		$this->fmt->form->input_form('Password:','inputPasword','','','','box-md-3','');
		$this->fmt->form->input_form('confirmar Password:','inputPaswordConfirmar','','','','box-md-3','');
		echo "<div class='clearfix'></div>";
		?>
		<div class="form-group">
			<div class="row">
				<div class="col-xs-6" >
					<label>Rol:  </label>
					<?php echo $this->fmt->usuario->opciones_roles();  ?>
				</div>
				<div class="col-xs-6" >

					<?php  $this->fmt->class_modulo->grupos_select("Grupo Roles","inputRolGrupo","");  ?>
				</div>
			</div>
		</div>
		<?php

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

	function nivel_formacion(){
		$ext[0] = 'Seleccione una opción';
		$ext[1] = 'Básico incial';
		$ext[2] = 'Bachilerato';
		$ext[3] = 'Egresado';
		$ext[4] = 'Licencitura';
		$ext[5] = 'Diplomado';
		$ext[6] = 'Master';
		$ext[7] = 'PHD';

		return $ext;
	}

	function contratos(){
		$ext[0] = 'Seleccione una opción';
		$ext[1] = 'Contrato a plazo fijo';
		$ext[2] = 'Contrato indefinido';
		$ext[3] = 'Contrato de pasantias';
		$ext[4] = 'Contrato de reemplazo';
		$ext[5] = 'Contrato de capacitación pagada';

		return $ext;
	}

	function departamentos(){
		$ext[0] = 'Seleccione una opción';
		$ext[1] = 'Departamento Comercial Agro';
		$ext[2] = 'Departamento Comercial  Maquinaria';
		$ext[3] = 'Departamento Comercial Línea Eco';
		$ext[4] = 'Departamento Comercial Construcción';
		$ext[5] = 'Departamento Investigación & Desarrollo';
		$ext[6] = 'Departamento Marketing';
		$ext[7] = 'Departamento Registros';
		$ext[8] = 'Departamento Logística e Importaciones';
		$ext[9] = 'Departamento Activos Fijos y Servicios';
		$ext[10] = 'Departamento Tecnología de la Información';
		$ext[11] = 'Departamento Finanzas';
		$ext[12] = 'Departamento Contable';
		$ext[13] = 'Departamento Legal';
		$ext[14] = 'Departamento Crédito y Cobranzas';
		$ext[15] = 'Departamento Servicio Técnico';
		$ext[16] = 'Departamento Administración y Gestión de Calidad';
		$ext[17] = 'Departamento Desarrollo Organizacional';

		return $ext;
	}

	function bancos(){
		$ext[0] = 'Seleccione una opción';
		$ext[1] = 'Banco Mercantil Santa Cruz';
		$ext[2] = 'Banco Nacional de Bolivia';
		$ext[3] = 'Banco Central de Bolivia';
		$ext[4] = 'Banco de Crédito de Bolivia';
		$ext[5] = 'Banco Do Brasil';
		$ext[6] = 'Banco Bisa S.A.';
		$ext[7] = 'Banco Unión S.A.';
		$ext[8] = 'Banco Económico';
		$ext[9] = 'Banco Solidario S.A.';
		$ext[10] = 'Banco Ganadero';
		$ext[11] = 'Banco Los Andes Pro Credit S.A.';
		$ext[12] = 'Banco Fie';
		$ext[13] = 'BANCO FASSIL S.A.';
		$ext[14] = 'Banco Fortaleza';
		$ext[15] = 'Banco Pyme Ecofuturo S.A.';
		return $ext;
	}

}
