<?php
header("Content-Type: text/html;charset=utf-8");

class CONFIG_EC{

	var $fmt;
	var $id_mod;
	var $ruta_modulo;
	var $nombre_modulo;

	function CONFIG_EC($fmt){
		$this->fmt = $fmt;
		$this->ruta_modulo="modulos/config-ec/config-ec.adm.php";
		$this->nombre_modulo="config-ec.adm.php";
	}

	function busqueda(){
   // $botones = $this->fmt->class_pagina->crear_btn("config-ec.adm.php?id_mod=16","btn btn-link","icn-kardex","Kardex");
    $this->fmt->class_pagina->crear_head_mod("icn-conf color-text-rojo","Configuraciones EC",$botones ); // $icon, $nom,$botones
		if (isset($_GET["p"])){
			$clase_activa = $_GET["p"];
		}else{
			$clase_activa = "pestana";
		}
    ?>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="<?php if ($clase_activa=="pestana"){ echo "active"; }?>"><a href="#empresas" aria-controls="pestana" role="tab" data-toggle="tab"><i class="icn-category-o color-text-azul-b"></i> Pestaña</a></li>

				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane <?php if ($clase_activa=="pestana"){ echo "active"; }?>" id="empresas">
						<label><h4>Nuestras Pestañas</h4></label>
	          <a href="config-ec.adm.php?tarea=form_nuevo" class='btn btn-primary pull-right'><i class="icn-plus"></i> Nueva Pestaña</a>
						<div class="box-tabla">
	              <?php
	              $sql="SELECT 	pes_id, pes_nombre, pes_activar  FROM pestana ORDER BY pes_id asc";
	              $rs =$this->fmt->query->consulta($sql);
	              $num=$this->fmt->query->num_registros($rs);
	              if($num>0){
	                for($i=0;$i<$num;$i++){
	                  list($fila_id,$fila_nombre_e,$fila_activar)=$this->fmt->query->obt_fila($rs);
	                  echo "<div class='box-tr'>";
	          				echo '<div class="box-td box-md-6">'.$fila_nombre_e.'</div>';
	          				echo '<div class="box-td box-md-3">';
	                  $this->fmt->class_modulo->estado_activar($fila_activar,$this->ruta_modulo."?tarea=activar","","",$fila_id );
	                  echo '</div>';
	          				echo '<div class="box-td box-md-3">';
										$url_editar= "config-ec.adm.php?tarea=form_editar&id=".$fila_id;
										$this->fmt->form->botones_acciones("btn-editar-modulo","btn btn-accion btn-editar",$url_editar,"Editar","icn-pencil","editar",'editar',$fila_id); //$id,$class,$href,$title,$icono,$tarea,$nom,$ide
										$this->fmt->form->botones_acciones("btn-eliminar","btn btn-eliminar btn-accion","","Eliminar -".$fila_id,"icn-trash","eliminar",$fila_nombre_e,$fila_id);
										//$id,$class,$href,$title,$icono,$tarea,$nom,$ide
										echo '</div>';
	                  echo "</div>";
	                }
	              }
	              ?>
	          </div>
			</div>

			</div>
    <?php
		$this->fmt->class_modulo->script_form($this->ruta_modulo,"");
    echo $this->fmt->form->footer_page();
  }

	function form_nuevo(){

    $botones .= $this->fmt->class_pagina->crear_btn("config-ec.adm.php?tarea=busqueda&p=pestana","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
    $this->fmt->class_pagina->crear_head_mod( "", "Nueva Pestaña",'',$botones,'col-xs-6 col-xs-offset-4');
    ?>
    <div class="body-modulo col-xs-6 col-xs-offset-3">
      <form class="form form-modulo" action="config-ec.adm.php?tarea=ingresar"  enctype="multipart/form-data" method="POST" id="form_nuevo">
        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
        <?php
        $this->fmt->form->input_form('Nombre de la pestaña:','inputNombre','','','requerido requerido-texto input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->textarea_form('Descripción:','inputDescripcion','','','','','3','','');
		$usuario = $this->fmt->sesion->get_variable('usu_id');
		$usuario_n =  $this->fmt->usuario->nombre_usuario( $usuario );
		$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$fecha =  date("Y-m-d H:i:s");
		$this->fmt->form->input_hidden_form("inputFecha",$fecha);
        $this->fmt->form->botones_nuevo();
        ?>
      </form>
    </div>
    <?php
    $this->fmt->class_modulo->script_form($this->ruta_modulo,"");
    $this->fmt->form->footer_page();
  }

  function form_editar(){
		$botones .= $this->fmt->class_pagina->crear_btn("config-ec.adm.php?tarea=busqueda&p=pestana","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
    $this->fmt->class_pagina->crear_head_mod( "", "Editar Petaña",'',$botones,'col-xs-6 col-xs-offset-4');
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];
		$sql="SELECT * from pestana	where pes_id='".$id."'";
		$rs=$this->fmt->query->consulta($sql);
		$num=$this->fmt->query->num_registros($rs);
			if($num>0){
				for($i=0;$i<$num;$i++){
					list($fila_id,$fila_nombre,$fila_descripcion,$fila_fecha,$fila_usuario,$fila_activar)=$this->fmt->query->obt_fila($rs);
				}
			}
    ?>
    <div class="body-modulo col-xs-6 col-xs-offset-3">
      <form class="form form-modulo" action="config-ec.adm.php?tarea=modificar"  enctype="multipart/form-data" method="POST" id="form_editar">
        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
        <?php
        $this->fmt->form->input_form('Nombre de la pestaña:','inputNombre','',$fila_nombre,'requerido requerido-texto input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
        $this->fmt->form->input_hidden_form("inputId",$fila_id);
        $this->fmt->form->textarea_form('Descripción:','inputDescripcion','',$fila_descripcion,'','','3','','');
		$usuario = $this->fmt->sesion->get_variable('usu_id');
		$usuario_n =  $this->fmt->usuario->nombre_usuario( $usuario );
		$this->fmt->form->input_form_sololectura('Usuario:','','',$usuario_n,'','','');//$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
		$this->fmt->form->input_hidden_form("inputUsuario",$usuario);
		$fecha =  date("Y-m-d H:i:s");
		$this->fmt->form->input_hidden_form("inputFecha",$fecha);
        $this->fmt->form->radio_activar_form($fila_activar);
		$this->fmt->form->botones_editar($fila_id,$fila_nombre,'pestana','eliminar');
        ?>
      </form>
    </div>
    <?php
    $this->fmt->class_modulo->script_form($this->ruta_modulo,"");
    $this->fmt->form->footer_page();
  }


	function ingresar(){

    if ($_POST["btn-accion"]=="activar"){
      $activar=1;
    }
    if ($_POST["btn-accion"]=="guardar"){
      $activar=0;
    }

    $ingresar ="pes_nombre,
				pes_descripcion,
				pes_fecha,
				pes_usuario,
				pes_activar";
    $valores_post  ="inputNombre, inputDescripcion,inputFecha,inputUsuario,inputActivar=".$activar;

    $this->fmt->class_modulo->ingresar_tabla('pestana',$ingresar,$valores_post);
		//$from,$filas,$valores_post
    header("location: config-ec.adm.php?tarea=busqueda&p=pestana");

  }

	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){

			$filas='pes_id,pes_nombre, pes_descripcion, pes_fecha, pes_usuario, pes_activar';
			$valores_post='inputId,inputNombre, inputDescripcion,inputFecha,inputUsuario,inputActivar';

			$this->fmt->class_modulo->actualizar_tabla('pestana',$filas,$valores_post); //$from,$filas,$valores_post
			header("location: config-ec.adm.php?tarea=busqueda?p=pestana");
		}
	}




	function eliminar(){
      $this->fmt->class_modulo->eliminar_get_id("pestana","pes_");
      header("location: config-ec.adm.php?tarea=busqueda&p=pestana");
    }

  function activar(){
      $this->fmt->class_modulo->activar_get_id("pestana","pes_");
      header("location: config-ec.adm.php?tarea=busqueda&p=pestana");

  }

  function busqueda_seleccion($modo,$valor){
	  	//var_dump($valor);
  		$this->fmt->form->head_modal('Busqueda Pestaña',$modo);  //$nom,$archivo,$id_mod,$botones,$id_form,$class,$modo)
  		$this->fmt->form->head_table('table_id_modal_aux');
		$this->fmt->form->thead_table('Nombre:Acciones');
		$this->fmt->form->tbody_table_open();

		$sql="SELECT * FROM pestana ORDER BY pes_id asc";
		$rs =$this->fmt->query->consulta($sql);
		$num=$this->fmt->query->num_registros($rs);
		if($num>0){
		  for($i=0;$i<$num;$i++){

		    list($fila_id,$fila_nombre,$fila_descripcion,$fila_fecha,$fila_usuario,$fila_activar)=$this->fmt->query->obt_fila($rs);
			$class_a ='';
			$class_do ='';
		    if (!empty($valor)){
				$num_v = count($valor);




				for ($j=0; $j<$num_v;$j++){
					if ( $fila_id ==$valor[$j]){
						$class_a ="on";
						$class_do ="on";
					}
				}
			}



		    //var_dump($fila);
		    	echo "<tr>";
				echo '<td class="fila-url"><strong>'.$fila_nombre.'</strong></td>';
				echo "<td class='acciones' id='dp-".$fila_id."'><a class='btn btn-agregar-pes ".$class_a."' value='".$fila_id."' id='bp-".$fila_id."' nombre='".$fila_nombre."' ><i class='icn-plus'></i> Agregar</a> <span class='agregado btp-".$fila_id." ".$class_do."'>Agregado</span></td>";
				echo "</tr>";
		    }
		}

		$this->fmt->form->tbody_table_close();
		$this->fmt->form->footer_table();
		$this->fmt->form->footer_page($modo);
	}

}
