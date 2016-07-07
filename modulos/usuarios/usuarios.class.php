<?php
header("Content-Type: text/html;charset=utf-8");

class USUARIOS{

	var $fmt;
	var $id_mod;

	function usuarios($fmt){
		$this->fmt = $fmt;
		$this->fmt->get->validar_get($_GET['id_mod']);
		$this->id_mod=$_GET['id_mod'];
	}

	function busqueda(){
		$botones = $this->fmt->class_pagina->crear_btn("roles.adm.php?id_mod=$this->id_mod","btn btn-link"," icn-credential","Roles");  // link, tarea, clase, icono, nombre
		$botones .= $this->fmt->class_pagina->crear_btn("grupo-usuarios.adm.php","btn btn-link","icn-list","Grupos de Usuarios");
    $botones .= $this->fmt->class_pagina->crear_btn("usuarios.adm.php?tarea=form_nuevo&id_mod=$this->id_mod","btn btn-primary","icn-plus","Nuevo Usuario");
    $this->fmt->class_pagina->crear_head( $this->id_mod, $botones); // id modulo, botones

		?>
    <div class="body-modulo">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nombre del Usuario</th>
            <th>E-mail</th>
            <th>Roles</th>
            <th>Grupos</th>
            <th>Estado</th>
            <th class="col-xl-offset-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql="select usu_id, usu_nombre,usu_apellidos, usu_imagen, usu_email, usu_estado  from usuarios	ORDER BY usu_id desc";
            $rs =$this->fmt->query-> consulta($sql);
            $num=$this->fmt->query->num_registros($rs);
            if($num>0){
              for($i=0;$i<$num;$i++){
                list($fila_id,$fila_nombre,$fila_apellido,$fila_imagen,$fila_email,$fila_estado)=$this->fmt->query->obt_fila($rs);
                ?>
                <tr>
                  <td  class="col-nombre"><?php if (!empty($fila_imagen)){
                      echo '<img class="img-user img-responsive" src="'._RUTA_WEB.$fila_imagen.'" />';
                    } else {
                      echo '<img class="img-user img-responsive" src="'._RUTA_WEB.'images/user/user-default.png" ?>';
                    }
                      echo '<span class="nombre-user">'.$fila_nombre."</span>";
                    ?>
                  </td>
                  <td class="td-user"><?php echo $fila_email; ?></td>
                  <td class="td-user"><?php //echo $this->fmt->usuario->roles_usuario($fila_id); ?></td>
                  <td class="td-user"> grupos</td>
                  <td class="td-user">
                  <?php
                    $this->fmt->class_modulo->estado_publicacion($fila_estado,"modulos/usuarios/usuarios.adm.php", $this->id_mod,$aux,$fila_id );
                  ?>
                  </td>
                  <td class="td-user col-xl-offset-2 acciones">
                    <a  id="btn-editar-modulo" class="btn btn-accion btn-editar <?php echo $aux; ?>" href="usuarios.adm.php?tarea=form_editar&id=<? echo $fila_id; ?>&id_mod=<? echo $this->id_mod; ?>" title="Editar <? echo $fila_id."-".$fila_url; ?>" ><i class="icn-pencil"></i></a>
                    <a  title="eliminar <? echo $fila_id; ?>" type="button" idEliminar="<? echo $fila_id; ?>" nombreEliminar="<? echo $fila_nombre; ?>"   class="btn btn-eliminar btn-accion <?php echo $aux; ?>"><i class="icn-trash"></i></a>
                  </td>
                </tr>
                <?
              }
            }
          ?>
        </tbody>
      </table>
    </div>
    </div>
    <?
		$this->fmt->class_modulo->script_form("modulos/usuarios/usuarios.adm.php",$this->id_mod);
  }

	function form_nuevo(){
		$botones = $this->fmt->class_pagina->crear_btn("usuarios.adm.php?tarea=busqueda&id_mod=$this->id_mod","btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_form("Nuevo Usuario", $botones,"");// nombre, botones-left, botones-right
		?>
		<div class="body-modulo col-xs-6 col-xs-offset-3">
			<form class="form form-modulo" action="usuarios.adm.php?tarea=ingresar&id_mod=<? echo $this->id_mod; ?>"  method="POST" id="form-nuevo">
				<div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->

				<div class="form-group control-group">
					<label>Nombre Usuario</label>
					<div class="input-group controls">
						<span class=" color-border-gris-a  color-text-gris input-group-addon form-input-icon"><i class="<? echo $this->fmt->class_modulo->icono_modulo($this->id_mod); ?>"></i></span>
						<input class="form-control input-lg color-border-gris-a color-text-gris form-nombre"  id="inputNombre" name="inputNombre" placeholder=" " type="text" autofocus />
					</div>
				</div>

				<div class="form-group">
					<label>Apellidos</label>
					<input class="form-control" id="inputApellidos" name="inputApellidos"  placeholder="" />
				</div>

				<div class="form-group">
					<label>Email</label>
					<input class="form-control" id="inputEmail" name="inputEmail"  placeholder="@" />
				</div>

				<div class="form-group">
					<label>Password</label>
					<input class="form-control" type="password" id="inputPassword" name="inputPassword"  placeholder="" />
				</div>
				<div class="form-group">
					<label>Confirmar password</label>
					<input class="form-control" type="password" id="inputPasswordConfirmar" name="inputPasswordConfirmar"  placeholder="" />
				</div>

				<div class="form-group">
					<label>Imagen</label>
					<input class="form-control" id="inputImagen" name="inputImagen"  placeholder="" />
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-xs-6" >
							<label>Rol:  </label>
							<?php echo $this->opciones_roles();  ?>
						</div>
						<div class="col-xs-6" >
							<label>Grupo de Roles:  </label>
							<?php //echo $this->opciones_grupos();  ?>
						</div>
					</div>
				</div>
				<div class="form-group form-botones">
					 <button type="submit" class="btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" value="guardar"><i class="icn-save" ></i> Guardar</button>
					 <button type="submit" class="btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" value="activar"><i class="icn-eye-open" ></i> Activar</button>
				</div>
			</form>
		</div>
		<?php
	}

	function opciones_roles(){
		$sql="select rol_id, rol_nombre from roles ORDER BY rol_id asc";
            $rs =$this->fmt->query-> consulta($sql);
            $num=$this->fmt->query->num_registros($rs);
            if($num>0){
              for($i=0;$i<$num;$i++){
                list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
		?>
		<div class="checkbox">
          <label>
            <input name="inputRol[]" id="inputRol[]" type="checkbox" value="<?php echo $fila_id; ?>"> <?php echo $fila_nombre; ?>
          </label>
        </div>
		<?php
				}
			}
	}

	function ingresar(){
		if ($_POST["btn-accion"]=="activar"){
			$estado=1;
		}
		if ($_POST["btn-accion"]=="guardar"){
			$estado=0;
		}
		$ingresar ="usu_nombre, usu_apellidos, usu_email, usu_password, usu_imagen, usu_estado, usu_padre";
		$valores  ="'".$_POST['inputNombre']."','".
									 $_POST['inputApellidos']."','".
									 $_POST['inputEmail']."','".
									 base64_decode($_POST['inputPassword'])."','".
									 $_POST['inputImagen']."','".
									 $estado."','1'";

		$sql="insert into usuarios (".$ingresar.") values (".$valores.")";
		$this->fmt->query->consulta($sql);

		$sql="select max(usu_id) as id_usu from usuarios";
		$rs= $this->fmt->query->consulta($sql);
		$fila = $this->fmt->query->obt_fila($rs);
		$id = $fila ["id_usu"];

		$rol = $_POST['inputRol'];
		$cont_rol= count($rol);
		$ingresar1 ="usuarios_usu_id, roles_rol_id";
		for($i=0; $i <= $cont_rol; $i++){
			$valores1 = "'".$id."','".$rol[$i]."'";
			$sql1="insert into usuarios_roles (".$ingresar1.") values (".$valores1.")";
			$this->fmt->query->consulta($sql1);
		}

		$grupo_rol = $_POST['inputRolGrupo'];
		$cont_grupo_rol=  $grupo_rol;
		header("location: usuarios.adm.php?id_mod=".$this->id_mod);

	}

  function activar(){
    $this->fmt->get->validar_get ( $_GET['estado'] );
    $this->fmt->get->validar_get ( $_GET['id'] );
    $sql="update usuarios set
        usu_estado='".$_GET['estado']."' where usu_id='".$_GET['id']."'";
    $this->fmt->query->consulta($sql);
    header("location: usuarios.adm.php?id_mod=".$this->id_mod);
  }



	function eliminar(){

		$this->fmt->get->validar_get( $_GET['id'] );
		$id= $_GET['id'];

		echo $sql="DELETE FROM  roles_rel WHERE rol_rel_usu_id='".$id."'";
		$this->fmt->query->consulta($sql);

		echo $sql="DELETE FROM usuarios WHERE usu_id='".$id."'";
		$this->fmt->query->consulta($sql);

		$up_sqr6 = "ALTER TABLE usuarios AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);
		header("location: usuarios.adm.php?id_mod=".$this->id_mod);
	}

}
