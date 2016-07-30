<?php
header("Content-Type: text/html;charset=utf-8");

class KARDEX_CONF{

	var $fmt;
	var $id_mod;

	function KARDEX_CONF($fmt){
		$this->fmt = $fmt;
	}

	function busqueda(){
    $botones = $this->fmt->class_pagina->crear_btn("kardex.adm.php","btn btn-link","icn-kardex","Kardex");
    $this->fmt->class_pagina->crear_head_mod("icn-conf color-text-rojo","Configuraciones Kardex",$botones ); // $icon, $nom,$botones
    ?>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#empresas" aria-controls="empresas" role="tab" data-toggle="tab">Empresas</a></li>
					<li role="presentation"><a href="#cargos" aria-controls="cargos" role="tab" data-toggle="tab">Cargos</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="empresas">
						<label><h4>Nuestras Empresas</h4></label>
	          <a href="kardex-config.adm.php?tarea=form_nuevo_empresa" class='btn btn-primary pull-right'><i class="icn-plus"></i> Nueva Empresa</a>
						<div class="box-tabla">
	              <?php
	              $sql="SELECT mod_kdx_emp_id, mod_kdx_emp_nombre, mod_kdx_emp_activar  FROM mod_kardex_empresa ORDER BY mod_kdx_emp_id asc";
	              $rs =$this->fmt->query->consulta($sql);
	              $num=$this->fmt->query->num_registros($rs);
	              if($num>0){
	                for($i=0;$i<$num;$i++){
	                  list($fila_id,$fila_nombre,$fila_activar)=$this->fmt->query->obt_fila($rs);
	                  echo "<div class='box-tr'>";
	          				echo '<div class="box-td box-md-6">'.$fila_nombre.'</div>';
	          				echo '<div class="box-td box-md-3">';
	                  $this->fmt->class_modulo->estado_activar($fila_activar,"modulos/rrhh/kardex-config.adm.php?tarea=activar_empresa","","",$fila_id );
	                  echo '</div>';
	          				echo '<div class="box-td box-md-3">';
										$url_editar= "kardex-config.adm.php?tarea=form_editar_empresa&id=".$fila_id;
										$this->fmt->form->botones_acciones("btn-editar-modulo","btn btn-accion btn-editar",$url_editar,"Editar","icn-pencil","editar_empresa",'editar',$fila_id); //$id,$class,$href,$title,$icono,$tarea,$nom,$ide
										$this->fmt->form->botones_acciones("btn-eliminar","btn btn-eliminar btn-accion","","Eliminar -".$fila_id,"icn-trash","eliminar_empresa",$fila_nombre,$fila_id);
										//$id,$class,$href,$title,$icono,$tarea,$nom,$ide
										echo '</div>';
	                  echo "</div>";
	                }
	              }
	              ?>
	          </div>
					</div>
					<div role="tabpanel" class="tab-pane" id="cargos">
						<label><h4>Cargos</h4></label>

					</div>
				</div>
    <?php
		$this->fmt->class_modulo->script_form("modulos/rrhh/kardex-config.adm.php","");
    echo $this->fmt->form->footer_page();
  }

  function form_nuevo_empresa(){
    $botones .= $this->fmt->class_pagina->crear_btn("kardex-config.adm.php?tarea=busqueda","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
    $this->fmt->class_pagina->crear_head_mod( "", "Nueva Empresa",'',$botones,'col-xs-6 col-xs-offset-4');
    ?>
    <div class="body-modulo col-xs-6 col-xs-offset-3">
      <form class="form form-modulo" action="kardex-config.adm.php?tarea=ingresar_empresa"  enctype="multipart/form-data" method="POST" id="form_nuevo">
        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
        <?php
        $this->fmt->form->input_form('Nombre de la empresa:','inputNombre','','','requerido requerido-texto input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->textarea_form('Descripción:','inputDescripcion','','','','','3','','');
        $this->fmt->form->input_form('Logo:','inputLogo','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Razón social:','inputRazonSocial','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('NIT:','inputNit','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Dirección:','inputDireccion','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Coordenadas:','inputCoordenadas','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Rubro:','inputRubro','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('E-mail:','inputEmail','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Web:','inputWeb','','','','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->botones_nuevo();
        ?>
      </div>
    </div>
    <?php
    $this->fmt->class_modulo->script_form("modulos/kardex/kardex-config.adm.php","");
    $this->fmt->form->footer_page();
  }

  function form_editar_empresa(){
    $botones .= $this->fmt->class_pagina->crear_btn("kardex-config.adm.php?tarea=busqueda","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
    $this->fmt->class_pagina->crear_head_mod( "", "Editar Cargo",'',$botones,'col-xs-6 col-xs-offset-4');
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];
		$sql="SELECT mod_kdx_emp_id,mod_kdx_emp_nombre,mod_kdx_emp_descripcion,mod_kdx_emp_logo,mod_kdx_emp_razon_social,mod_kdx_emp_nit,mod_kdx_emp_direccion,mod_kdx_emp_coordenadas,mod_kdx_emp_rubro,mod_kdx_emp_email,mod_kdx_emp_web,mod_kdx_emp_activar from mod_kardex_empresa	where mod_kdx_emp_id='".$id."'";
		$rs=$this->fmt->query->consulta($sql);
		$num=$this->fmt->query->num_registros($rs);
			if($num>0){
				for($i=0;$i<$num;$i++){
					list($fila_id,$fila_nombre,$fila_descripcion,$fila_logo,$fila_razon_social,$fila_nit,$fila_direccion,$fila_coordenadas,$fila_rubro,$fila_email,$fila_web,$fila_activar)=$this->fmt->query->obt_fila($rs);
				}
			}
    ?>
    <div class="body-modulo col-xs-6 col-xs-offset-3">
      <form class="form form-modulo" action="kardex-config.adm.php?tarea=modificar_empresa"  enctype="multipart/form-data" method="POST" id="form_editar">
        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
        <?php
        $this->fmt->form->input_form('Nombre de la empresa:','inputNombre','',$fila_nombre,'requerido requerido-texto input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
				$this->fmt->form->input_hidden_form("inputId",$fila_id);
				$this->fmt->form->textarea_form('Descripción:','inputDescripcion','',$fila_descripcion,'','','3','','');
        $this->fmt->form->input_form('Logo:','inputLogo','',$fila_logo,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Razón social:','inputRazonSocial','',$fila_razon_social,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('NIT:','inputNit','',$fila_nit,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Dirección:','inputDireccion','',$fila_direccion,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Coordenadas:','inputCoordenadas','',$fila_coordenadas,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Rubro:','inputRubro','',$fila_rubro,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('E-mail:','inputEmail','',$fila_email,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_form('Web:','inputWeb','',$fila_web,'','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
				$this->fmt->form->radio_activar_form($fila_activar);
				$this->fmt->form->botones_editar($fila_id,$fila_nombre,'empresa');
        ?>
      </div>
    </div>
    <?php
    $this->fmt->class_modulo->script_form("modulos/kardex/kardex-config.adm.php","");
    $this->fmt->form->footer_page();
  }

  function ingresar_empresa(){
    if ($_POST["btn-accion"]=="activar"){
      $activar=1;
    }
    if ($_POST["btn-accion"]=="guardar"){
      $activar=0;
    }
    $ingresar ="mod_kdx_emp_nombre,
                mod_kdx_emp_descripcion,
                mod_kdx_emp_logo,
                mod_kdx_emp_razon_social,
                mod_kdx_emp_nit,
                mod_kdx_emp_direccion,
                mod_kdx_emp_coordenadas,
                mod_kdx_emp_rubro,
                mod_kdx_emp_email,
                mod_kdx_emp_web,
                mod_kdx_emp_activar";
    $valores  ="inputNombre,
									inputDescripcion,
									inputLogo,
									inputRazonSocial,
									inputNit,
									inputDireccion,
									inputCoordenadas,
									inputRubro,
									inputEmail,
									inputWeb,".$activar;

    $this->fmt->class_modulo->ingresar_tabla('mod_kardex_empresa',$filas,$valores_post);
		//$from,$filas,$valores_post
    header("location: kardex-config.adm.php");
  }

	function modificar_empresa(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){

			$filas='mod_kdx_emp_id,
							mod_kdx_emp_nombre,
              mod_kdx_emp_descripcion,
              mod_kdx_emp_logo,
              mod_kdx_emp_razon_social,
              mod_kdx_emp_nit,
              mod_kdx_emp_direccion,
              mod_kdx_emp_coordenadas,
              mod_kdx_emp_rubro,
              mod_kdx_emp_email,
              mod_kdx_emp_web,
              mod_kdx_emp_activar';
			$valores_post='inputId,
										inputNombre,
										inputDescripcion,
										inputLogo,
										inputRazonSocial,
										inputNit,
										inputDireccion,
										inputCoordenadas,
										inputRubro,
										inputEmail,
										inputWeb,
										inputActivar';
			$this->fmt->class_modulo->actualizar_tabla('mod_kardex_empresa',$filas,$valores_post); //$from,$filas,$valores_post
			//header("location: kardex-config.adm.php");
		}
	}

  function eliminar_empresa(){
      $this->fmt->class_modulo->eliminar_get_id("mod_kardex_empresa","mod_kdx_emp_");
      header("location: kardex-config.adm.php");
    }

  function activar_empresa(){
      $this->fmt->class_modulo->activar_get_id("mod_kardex_empresa","mod_kdx_emp_");
      header("location: kardex-config.adm.php");
  }

}
