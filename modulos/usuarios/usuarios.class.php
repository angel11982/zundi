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
		$botones .= $this->fmt->class_pagina->crear_btn("grupos.adm.php?id_mod=$this->id_mod","btn btn-link","icn-list","Grupos de Usuarios");
    $botones .= $this->fmt->class_pagina->crear_btn("usuarios.adm.php?tarea=form_nuevo&id_mod=$this->id_mod","btn btn-primary","icn-plus","Nuevo Usuario");
    $this->fmt->class_pagina->crear_head( $this->id_mod, $botones); // id modulo, botones

		?>
    <div class="body-modulo">
    <div class="table-responsive">
      <table class="table table-hover" id="table_id">
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
											$img=$this->fmt->class_modulo->cambiar_tumb($fila_imagen);
                      echo '<img class="img-user img-responsive" src="'._RUTA_WEB.$img.'" />';
                    } else {
                      echo '<img class="img-user img-responsive" src="'._RUTA_WEB.'images/user/user-default.png" ?>';
                    }
                      echo '<span class="nombre-user">'.$fila_nombre." ".$fila_apellido."</span>";
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
                    <a  title="eliminar <? echo $fila_id; ?>" type="button" ide="<? echo $fila_id; ?>" nombre="<? echo $fila_nombre." ".$fila_apellido; ?>" tarea="eliminar"  class="btn btn-eliminar btn-accion <?php echo $aux; ?>"><i class="icn-trash"></i></a>
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
		$this->fmt->class_modulo->script_form("modulos/usuarios/usuarios.adm.php",$this->id_mod,"desc"); //$ruta,$id_mod,$tipo="asc",$orden=0,$cant=25
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
						<input  class="form-control input-lg color-border-gris-a color-text-gris form-nombre"  id="inputNombre" name="inputNombre" placeholder=" " type="text" required autofocus />
					</div>
				</div>

				<div class="form-group">
					<label>Apellidos</label>
					<input type="text" required class="form-control" id="inputApellidos" name="inputApellidos"  placeholder="" />
				</div>

				<div class="form-group">
					<label>Email</label>
					<input type="email" required class="form-control" id="inputEmail" name="inputEmail"  placeholder="@" />
				</div>

				<div class="form-group">
					<label>Password</label>
					<input class="form-control" type="password" id="inputPassword" name="inputPassword"  placeholder="" />
					<div id="msg_pass"></div>
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

							<?php  $this->fmt->class_modulo->grupos_select("Grupo Roles","inputRolGrupo","");  ?>
						</div>
					</div>
				</div>
				<div class="form-group form-botones">
					 <button type="submit" class="btn btn-info  btn-guardar color-bg-celecte-b btn-lg" name="btn-accion" id="btn-guardar" disabled="true" value="guardar"><i class="icn-save" ></i> Guardar</button>
					 <button type="submit" class="btn btn-success color-bg-verde btn-activar btn-lg" name="btn-accion" id="btn-activar" disabled="true" value="activar"><i class="icn-eye-open" ></i> Activar</button>
				</div>
			</form>
		</div>
		<script>
		$(document).ready(function(){
			$("#inputPassword").keyup(function(){
				validarpass();
			});
			$("#inputPasswordConfirmar").keyup(function(){
				validarpass();
			});
		});
		function validarpass(){
			var pass = $("#inputPassword").val();
			var re_pass = $("#inputPasswordConfirmar").val();
			if(pass.length>0 && re_pass.length>0){
				if(pass==re_pass){
					$("#btn-guardar").prop("disabled", false);
					$("#btn-activar").prop("disabled", false);
					$("#msg_pass").html("");
				}
				else{
					$("#msg_pass").html('<span class="text-danger"><font><font>Los password no coinciden.</font></font></span>');
					$("#btn-guardar").prop("disabled", true);
					$("#btn-activar").prop("disabled", true);
				}
			}
		}
		</script>
		<?php
	}

	function opciones_roles($rol){
		$sql="select rol_id, rol_nombre from roles ORDER BY rol_id asc";
            $rs =$this->fmt->query->consulta($sql);
            $num=$this->fmt->query->num_registros($rs);
            if($num>0){
              for($i=0;$i<$num;$i++){
                list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
                $ch="";
				if (in_array($fila_id, $rol))
					$ch="checked";
		?>
		<div class="checkbox">
          <label>
            <input name="inputRol" <?php echo $ch; ?> id="inputRol<?php echo $fila_id; ?>" type="radio" value="<?php echo $fila_id; ?>"> <?php echo $fila_nombre; ?>
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
		$ingresar = "usu_nombre, usu_apellidos, usu_email, usu_password, usu_imagen, usu_estado, usu_padre";
		$valores  = "'".$_POST['inputNombre']."','".
					$_POST['inputApellidos']."','".
					$_POST['inputEmail']."','".
					base64_encode($_POST['inputPassword'])."','".
					$_POST['inputImagen']."','".
					$estado."','1'";

		$sql="insert into usuarios (".$ingresar.") values (".$valores.")";
		$this->fmt->query->consulta($sql);

		$sql="select max(usu_id) as id_usu from usuarios";
		$rs= $this->fmt->query->consulta($sql);
		$fila = $this->fmt->query->obt_fila($rs);
		$id = $fila ["id_usu"];

		$rol = $_POST['inputRol'];

		$ingresar1 ="usuarios_usu_id, roles_rol_id";
		$valores1 = "'".$id."','".$rol."'";
		$sql1="insert into usuarios_roles (".$ingresar1.") values (".$valores1.")";
		$this->fmt->query->consulta($sql1);

		$ingresar1 ="usuarios_usu_id, grupos_grupo_id";

		$grupo_rol = $_POST['inputRolGrupo'];
		$cont_grupo_rol= count($grupo_rol);
		for($i=0;$i<$cont_grupo_rol;$i++){
			$valores1 = "'".$id."','".$grupo_rol[$i]."'";
			$sql2="insert into usuarios_grupos (".$ingresar1.") values (".$valores1.")";
			$this->fmt->query->consulta($sql2);
		}
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
		echo $id= $_GET['id'];
		$this->fmt->class_modulo->eliminar_fila($id,"usuarios_roles","usuarios_usu_id");
		$this->fmt->class_modulo->eliminar_fila($id,"usuarios_grupos","usuarios_usu_id");
		$sql="DELETE FROM usuarios WHERE usu_id='".$id."'";
		$this->fmt->query->consulta($sql);

		$up_sqr6 = "ALTER TABLE usuarios AUTO_INCREMENT=1";
		$this->fmt->query->consulta($up_sqr6);

		header("location: usuarios.adm.php?id_mod=".$this->id_mod);
	}
	function form_editar(){

		$this->fmt->form->head_editar('editar usuario','usuarios',$this->id_mod,''); //$nom,$archivo,$id_mod,$botones
		$this->fmt->get->validar_get ( $_GET['id'] );
		$id = $_GET['id'];
		$consulta ="SELECT * FROM usuarios WHERE usu_id='$id'";
		$rs = $this->fmt->query->consulta($consulta);
		$fila=  $this->fmt->query->obt_fila($rs);
		$this->fmt->form->input_hidden_form('inputId',$id);
		$rols_id = $this->fmt->categoria->traer_rel_cat_id($id,'usuarios_roles','roles_rol_id','usuarios_usu_id');

		$groups_id = $this->fmt->categoria->traer_rel_cat_id($id,'usuarios_grupos','grupos_grupo_id','usuarios_usu_id');

		?>
				<div class="form-group control-group">
					<label>Nombre Usuario</label>
					<div class="input-group controls">
						<span class=" color-border-gris-a  color-text-gris input-group-addon form-input-icon"><i class="<? echo $this->fmt->class_modulo->icono_modulo($this->id_mod); ?>"></i></span>
						<input  class="form-control input-lg color-border-gris-a color-text-gris form-nombre"  id="inputNombre" name="inputNombre" placeholder=" " type="text" value="<?php echo $fila["usu_nombre"]; ?>" required autofocus />
					</div>
				</div>

				<div class="form-group">
					<label>Apellidos</label>
					<input type="text" required class="form-control" id="inputApellidos" name="inputApellidos"  placeholder="" value="<?php echo $fila["usu_apellidos"]; ?>" />
				</div>

				<div class="form-group">
					<label>Email</label>
					<input type="email" required class="form-control" id="inputEmail" name="inputEmail"  placeholder="@" value="<?php echo $fila["usu_email"]; ?>" />
				</div>

				<div class="form-group">
					<label>Password</label>
					<input class="form-control" type="password" id="inputPassword" name="inputPassword"  placeholder="" value="<?php echo base64_decode($fila["usu_password"]); ?>" />
					<div id="msg_pass"></div>
				</div>
				<div class="form-group">
					<label>Confirmar password</label>
					<input class="form-control" type="password" id="inputPasswordConfirmar" name="inputPasswordConfirmar"  placeholder="" value="<?php echo base64_decode($fila["usu_password"]); ?>" />
				</div>

				<div class="form-group">
					<label>Imagen</label>
					<input class="form-control" id="inputImagen" name="inputImagen"  placeholder="" value="<?php echo $fila["usu_imagen"]; ?>" />
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-xs-6" >
							<label>Rol:  </label>
							<?php echo $this->opciones_roles($rols_id);  ?>
						</div>
						<div class="col-xs-6" >

							<?php  $this->fmt->class_modulo->grupos_select("Grupo Roles","inputRolGrupo","",$groups_id);  ?>
						</div>
					</div>
				</div>
				<div class="form-group form-botones">
					 <button type="submit" class="btn-accion-form btn btn-info  btn-actualizar hvr-fade btn-lg color-bg-celecte-c btn-lg " name="btn-accion" id="btn-activar" value="actualizar"><i class="icn-sync"></i> Actualizar</button>
				</div>
			</form>
		</div>
		<script>
		$(document).ready(function(){
			$("#inputPassword").keyup(function(){
				validarpass();
			});
			$("#inputPasswordConfirmar").keyup(function(){
				validarpass();
			});
		});
		function validarpass(){
			var pass = $("#inputPassword").val();
			var re_pass = $("#inputPasswordConfirmar").val();
			if(pass.length>0 && re_pass.length>0){
				if(pass==re_pass){
					$("#btn-activar").prop("disabled", false);
					$("#msg_pass").html("");
				}
				else{
					$("#msg_pass").html('<span class="text-danger"><font><font>Los password no coinciden.</font></font></span>');
					$("#btn-activar").prop("disabled", true);
				}
			}
		}
		</script>
		<?php
	}
	function modificar(){
		$id=$_POST['inputId'];

		$sql="UPDATE usuarios SET
				usu_nombre='".$_POST['inputNombre']."',
				usu_apellidos='".$_POST['inputApellidos']."',
				usu_email ='".$_POST['inputEmail']."',
				usu_password='".base64_encode($_POST['inputPassword'])."',
				usu_imagen='".$_POST['inputImagen']."'
	          WHERE usu_id='".$id."'";

		$this->fmt->query->consulta($sql);
		$this->fmt->class_modulo->eliminar_fila($id,"usuarios_roles","usuarios_usu_id");
		$this->fmt->class_modulo->eliminar_fila($id,"usuarios_grupos","usuarios_usu_id");
		$rol = $_POST['inputRol'];

		$ingresar1 ="usuarios_usu_id, roles_rol_id";
		$valores1 = "'".$id."','".$rol."'";
		$sql1="insert into usuarios_roles (".$ingresar1.") values (".$valores1.")";
		$this->fmt->query->consulta($sql1);

		$ingresar1 ="usuarios_usu_id, grupos_grupo_id";

		$grupo_rol = $_POST['inputRolGrupo'];
		$cont_grupo_rol= count($grupo_rol);
		for($i=0;$i<$cont_grupo_rol;$i++){
			$valores1 = "'".$id."','".$grupo_rol[$i]."'";
			$sql2="insert into usuarios_grupos (".$ingresar1.") values (".$valores1.")";
			$this->fmt->query->consulta($sql2);
		}
		header("location: usuarios.adm.php?id_mod=".$this->id_mod);
	}
}
