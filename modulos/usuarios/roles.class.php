<?php
header("Content-Type: text/html;charset=utf-8");

class ROLES{

	var $fmt;
	var $id_mod;

	function ROLES($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

  function busqueda(){
    $botones .= $this->fmt->class_pagina->crear_btn("usuarios.adm.php?tarea=busqueda&id_mod=$this->id_mod","btn btn-link","icn-users","Usuarios");

    $botones .= $this->fmt->class_pagina->crear_btn("grupos.adm.php","btn btn-link","icn-list","Grupos de Usuarios");

    $botones .= $this->fmt->class_pagina->crear_btn("roles.adm.php?tarea=form_nuevo&id_mod=$this->id_mod","btn btn-primary","icn-plus","Nuevo Rol");

    $this->fmt->class_pagina->crear_head_mod( "icn-credential color-text-naranja-a","Roles", $botones); // bd, id modulo, botones

    ?>
    <div class="body-modulo">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nombre Rol</th>
              <th>Funciones</th>
              <th>Padre</th>
              <th>Estado</th>
              <th class="col-xl-offset-2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql="select * from roles	ORDER BY rol_id desc";
              $rs =$this->fmt->query->consulta($sql);
              $num=$this->fmt->query->num_registros($rs);
              if($num>0){
              for($i=0;$i<$num;$i++){
                list($fila_id,$fila_nombre,$fila_funciones,$fila_id_padre, $fila_grupo, $fila_permisos, $fila_activar)=$this->fmt->query->obt_fila($rs);
            ?>
              <tr>
                <td class=""><?php echo $fila_nombre; ?></td>
                <td class=""><?php echo $fila_funciones; ?></td>
                <td class=""><?php echo $this->nombre_rol($fila_id_padre); ?></td>
                <td class="">
                <?php
                      $this->fmt->class_modulo->estado_publicacion($fila_activar,"modulos/usuarios/roles.adm.php", $this->id_mod,$aux,$fila_id );
                ?>
                </td>
                <td class="col-xl-offset-2 accione">
                  <a  id="btn-editar-modulo" class="btn btn-accion btn-editar <?php echo $aux; ?>" href="roles.adm.php?tarea=form_editar&id=<? echo $fila_id; ?>&id_mod=<? echo $this->id_mod; ?>" title="Editar <? echo $fila_id."-".$fila_url; ?>" ><i class="icn-pencil"></i></a>
                  <a  title="eliminar <? echo $fila_id; ?>" type="button" idEliminar="<? echo $fila_id; ?>" nombreEliminar="<? echo $fila_nombre; ?>" class="btn btn-eliminar btn-accion <?php echo $aux; ?>"><i class="icn-trash"></i></a>
                </td>
              </tr>
            <?php
                }
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php
    $this->fmt->class_modulo->script_form("modulos/usuarios/roles.adm.php",$this->id_mod);
  }

  function form_nuevo(){

    $botones = $this->fmt->class_pagina->crear_btn("roles.adm.php?tarea=busqueda&id_mod=".$this->id_mod,"btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre

  	$this->fmt->class_pagina->crear_head_form("Nuevo Rol", $botones,"","",$this->id_mod);

    ?>
    <div class="body-modulo col-xs-6 col-xs-offset-3">
      <form class="form form-modulo" action="roles.adm.php?tarea=ingresar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-nuevo">
        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->
        <div class="form-group control-group">
          <label>Nombre Rol:</label>
          <input class="form-control input-lg"  id="inputNombre" name="inputNombre" placeholder=" " type="text" autofocus />
        </div>

        <div class="form-group form-descripcion">
          <label>Ref. Funciones:</label>
          <textarea class="form-control" rows="2" id="inputFunciones" name="inputFunciones" placeholder=""></textarea>
        </div>

        <div class="form-group">
					<label>Rol padre:</label>
					<select class="form-control" id="inputPadre" name="inputPadre">
						<?php $this->traer_opciones(''); ?>
					</select>
				</div>

        <div class="form-group form-descripcion">
          <label>Ref. Permisos:</label>
          <textarea class="form-control" rows="2" id="inputPermisos" name="inputPermisos" placeholder=""></textarea>
        </div>
		<?php
			$this->fmt->form->select_form("Redireccion","InputRedireccion","red_","redireccion");
			$this->fmt->form->categoria_form('Accesos a categoría:','inputCat',"0","","","box-md-7 rol-cat"); //$label,$id,$cat_raiz,$cat_valor,$class,$class_div
			$this->fmt->class_modulo->sistemas_modulos_select("Accesos a Sistemas y modulos","inputMod","box-md-10 rol-cat  box-sm"); //$label,$id,$class_div
				//$this->fmt->class_modulo->grupos_select("Definición de grupos","inputGrupos",""); //$label,$id,$class_div
				?>

        <div class="form-group form-botones clear-both">
					 <button type="submit" class="btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save" ></i> Guardar</button>
					 <button type="submit" class="btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open" ></i> Activar</button>
				</div>
      </form>
    </div>
    <?php
  }

  function form_editar(){
    $this->fmt->form->head_editar('Rol','roles',$this->id_mod,''); //$nom,$archivo,$id_mod,$botones
    $this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];
    $consulta ="SELECT * FROM roles WHERE rol_id='$id'";
    $rs = $this->fmt->query->consulta($consulta);
    $fila=  $this->fmt->query->obt_fila($rs);
    $this->fmt->form->input_form('Nombre','inputNombre','', $fila['rol_nombre'],'input-lg','',''); //$label,$id,$placeholder,$valor,$class,$class_div,$mensaje
    $this->fmt->form->input_hidden_form('inputId',$fila['rol_id']);
    $this->fmt->form->textarea_form('Ref. Funciones','inputFunciones','', $fila['rol_funciones'],'','','3',''); //$label,$id,$placeholder,$valor,$class,$rows,$mensaje
    $this->fmt->form->select_form('Id padre','inputPadre','rol_','roles',$fila['rol_id_padre']);
    $this->fmt->form->textarea_form('Ref. Permisos','inputPermisos','', $fila['rol_permisos'],'','','3',''); //$label,$id,$placeholder,$valor,$class,$rows,$mensaje
	$cats_id = $this->fmt->categoria->traer_rel_cat_id($id,'roles_rel','rol_rel_cat_id','rol_rel_rol_id'); //$fila_id,$from,$prefijo_cat,$prefijo_rel
	$this->fmt->form->select_form("Redireccion","InputRedireccion","red_","redireccion",$fila["rol_redireccion"]);
    $this->fmt->form->categoria_form('Accesos a categoría:','inputCat',"0", $cats_id,"","box-md-7 rol-cat"); //$label,$id,$cat_raiz,$cat_valor,$class,$class_div

		$ids_sis = $this->fmt->class_modulo->traer_roles_rel_sis_id($id);
		$ids_mod = $this->fmt->class_modulo->traer_roles_rel_mod_id($id);
		$ids_per = $this->fmt->class_modulo->traer_roles_rel_mod_id_permisos($id);


    $this->fmt->class_modulo->sistemas_modulos_select("Accesos a Sistemas y modulos","inputMod","box-md-10 rol-cat box-sm",$ids_sis,$ids_mod,$ids_per); //$label,$id,$class_div,$ids_sis,$isd_mod
    //$this->fmt->class_modulo->grupos_select("Definición de grupos","inputGrupos",""); //$label,$id,$class_div

    $this->fmt->form->radio_activar_form($fila['rol_activar']);
    $this->fmt->form->botones_editar($fila['rol_id'],$fila['rol_nombre'],'Rol');//$fila_id,$fila_nombre,$nombre

    $this->fmt->class_modulo->script_form("modulos/usuarios/roles.adm.php",$this->id_mod);
    $this->fmt->form->footer_page();
  }

  function nombre_rol($rol){
    $sql = "SELECT rol_nombre FROM roles WHERE rol_id=$rol";
    $rs =$this->fmt->query->consulta($sql);
    $fila =$this->fmt->query->obt_fila($rs);
    return $fila['rol_nombre'];
  }

  function traer_opciones($id){
    $consulta ="SELECT rol_id, rol_nombre FROM roles";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    echo "<option class='' value='0'>Raiz (0)</option>";
    if($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
        if ($fila_id==$id){  $aux="selected";  $aux1="disabled"; }else{ $aux1=""; $aux=""; }
        echo "<option class='' value='$fila_id' $aux $aux1 > ".$fila_nombre;
        echo "</option>";
      }
    }
  }

  function ingresar(){

		if ($_POST["btn-accion"]=="activar"){
			$activar=1;
		}
		if ($_POST["btn-accion"]=="guardar"){
			$activar=0;
		}

		$ingresar ="rol_nombre,rol_funciones, rol_id_padre, rol_permisos, rol_redireccion, rol_activar";
		$valores  ="'".$_POST['inputNombre']."','".
									 $_POST['inputFunciones']."','".
									 $_POST['inputPadre']."','".
									 $_POST['inputPermisos']."','".
									 $_POST['InputRedireccion']."','".
									 $activar."'";

		$sql="insert into roles (".$ingresar.") values (".$valores.")";

		$this->fmt->query->consulta($sql);

		$sql="select max(rol_id) as id from roles";
		$rs= $this->fmt->query->consulta($sql);
		$fila = $this->fmt->query->obt_fila($rs);
		$id = $fila ["id"];

		//var_dump( $_POST['inputCat']);
		$ingresar1 ="rol_rel_rol_id, rol_rel_cat_id";
		$valor_cat= $_POST['inputCat'];
		$num=count( $valor_cat );
		for ($i=0; $i<$num;$i++){
			$valores1 = "'".$id."','".$valor_cat[$i]."'";
			$sql1="insert into roles_rel (".$ingresar1.") values (".$valores1.")";
			$this->fmt->query->consulta($sql1);
		}

		$ingresar1 ="rol_rel_rol_id, rol_rel_sis_id";
		$valor_sis= $_POST['inputSis'];
		$num=count( $valor_sis );
		for ($i=0; $i<$num;$i++){
			$valores1 = "'".$id."','".$valor_sis[$i]."'";
			$sql1="insert into roles_rel (".$ingresar1.") values (".$valores1.")";
			$this->fmt->query->consulta($sql1);
		}

		$ingresar1 ="rol_rel_rol_id, rol_rel_mod_id, rol_rel_mod_p_ver, rol_rel_mod_p_activar,  rol_rel_mod_p_agregar, rol_rel_mod_p_editar, rol_rel_mod_p_eliminar";
		$valor_mod= $_POST['inputMod'];


		$num=count( $valor_mod );
		for ($i=0; $i<$num;$i++){
			$valor_v= $_POST['input_v'.$valor_mod[$i]];
			$valor_p= $_POST['input_p'.$valor_mod[$i]];
			$valor_a= $_POST['input_a'.$valor_mod[$i]];
			$valor_e= $_POST['input_e'.$valor_mod[$i]];
			$valor_t= $_POST['input_t'.$valor_mod[$i]];
			$valores1 = "'".$id."','".$valor_mod[$i]."','".$valor_v."','".$valor_p."','".$valor_a."','".$valor_e."','".$valor_t."'";
			$sql1="insert into roles_rel (".$ingresar1.") values (".$valores1.")";
			$this->fmt->query->consulta($sql1);
		}


		header("location: roles.adm.php?id_mod=".$this->id_mod);
	} // fin funcion ingresar

	function modificar(){
		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){
			$id=$_POST['inputId'];
			$sql="UPDATE roles SET
						rol_nombre='".$_POST['inputNombre']."',
						rol_funciones='".$_POST['inputFunciones']."',
						rol_id_padre ='".$_POST['inputPadre']."',
						rol_permisos='".$_POST['inputPermisos']."',
						rol_redireccion='".$_POST['InputRedireccion']."',
						rol_activar='".$_POST['inputActivar']."'
	          WHERE rol_id='".$id."'";

			$this->fmt->query->consulta($sql);

			$sql1="DELETE FROM roles_rel WHERE rol_rel_rol_id='".$id."'";
			$this->fmt->query->consulta($sql1);

			$up_sqr7 = "ALTER TABLE roles_rel AUTO_INCREMENT=1";
			$this->fmt->query->consulta($up_sqr7);

			$ingresar1 ="rol_rel_rol_id, rol_rel_cat_id";
			$valor_cat= $_POST['inputCat'];
			$num=count( $valor_cat );
			for ($i=0; $i<$num;$i++){
				$valores1 = "'".$id."','".$valor_cat[$i]."'";
				$sql1="insert into roles_rel (".$ingresar1.") values (".$valores1.")";
				$this->fmt->query->consulta($sql1);
			}

			$ingresar1 ="rol_rel_rol_id, rol_rel_sis_id";
			$valor_sis= $_POST['inputSis'];
			$num=count( $valor_sis );
			for ($i=0; $i<$num;$i++){
				$valores1 = "'".$id."','".$valor_sis[$i]."'";
				$sql1="insert into roles_rel (".$ingresar1.") values (".$valores1.")";
				$this->fmt->query->consulta($sql1);
			}

			$ingresar1 ="rol_rel_rol_id, rol_rel_mod_id, rol_rel_mod_p_ver, rol_rel_mod_p_activar,  rol_rel_mod_p_agregar, rol_rel_mod_p_editar, rol_rel_mod_p_eliminar";
			$valor_mod= $_POST['inputMod'];


			$num=count( $valor_mod );
			for ($i=0; $i<$num;$i++){
				$valor_v= $_POST['input_v'.$valor_mod[$i]];
				$valor_p= $_POST['input_p'.$valor_mod[$i]];
				$valor_a= $_POST['input_a'.$valor_mod[$i]];
				$valor_e= $_POST['input_e'.$valor_mod[$i]];
				$valor_t= $_POST['input_t'.$valor_mod[$i]];
				$valores1 = "'".$id."','".$valor_mod[$i]."','".$valor_v."','".$valor_p."','".$valor_a."','".$valor_e."','".$valor_t."'";
				$sql1="insert into roles_rel (".$ingresar1.") values (".$valores1.")";
				$this->fmt->query->consulta($sql1);
			}

		}
			header("location: roles.adm.php?id_mod=".$this->id_mod);
	}

	function eliminar(){
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id= $_GET['id'];
		$sql="DELETE FROM roles WHERE rol_id='".$id."'";
		$this->fmt->query->consulta($sql);
		$up_sqr6 = "ALTER TABLE roles AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);

		$sql1="DELETE FROM roles_rel WHERE rol_rel_rol_id='".$id."'";
		$this->fmt->query->consulta($sql1);
		$up_sqr7 = "ALTER TABLE roles_rel AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr7);

		header("location: roles.adm.php?id_mod=".$this->id_mod);
	}

	function activar(){
		$this->fmt->get->validar_get ( $_GET['estado'] );
		$this->fmt->get->validar_get ( $_GET['id'] );
		$sql="update roles set
				rol_activar='".$_GET['estado']."' where rol_id='".$_GET['id']."'";
		$this->fmt->query->consulta($sql);
		header("location: roles.adm.php?id_mod=".$this->id_mod);
	}

}
