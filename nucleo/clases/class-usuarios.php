<?php
header('Content-Type: text/html; charset=utf-8');

class USUARIO{

  var $constructor;

  function __construct($fmt){
    $this->fmt = $fmt;
  }
  function nombre_grupo_usuario($id_grupo){
    $sql ="SELECT grupo_nombre FROM grupos WHERE grupo_id='$id_grupo'";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query-> obt_fila($rs);
    return $fila["grupo_nombre"];
  }
  function nombre_rol($id_rol){
    $sql ="SELECT rol_nombre  FROM roles WHERE rol_id='$id_rol'";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query-> obt_fila($rs);
    return $fila["rol_nombre"];
  }

  function id_rol_usuario($id_usu){
    $sql ="SELECT roles_rol_id FROM usuarios_roles WHERE usuarios_usu_id='$id_usu'";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila["roles_rol_id"];
  }

  function traer_ruta_rol($id_rol){
    $sql ="SELECT red_url FROM redireccion, roles WHERE rol_id='$id_rol' and rol_redireccion=red_id";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila["red_url"];
  }

  function rol_usuario($id_usu){
    $sql ="SELECT roles_rol_id FROM usuarios_roles WHERE usuarios_usu_id='$id_usu'";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    $id = $fila["roles_rol_id"];
    if (isset($id)){
      $sql1 ="SELECT rol_nombre FROM roles WHERE rol_id='$id'";
      $rs1 = $this->fmt->query-> consulta($sql1);
      $fila1 = $this->fmt->query->obt_fila($rs1);
      return $fila1["rol_nombre"];
    }else {
      return "sin rol";
    }
  }

  function nombre_usuario($usuario){
    $sql="select usu_nombre, usu_apellidos from usuarios where usu_id=$usuario";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila["usu_nombre"]." ".$fila["usu_apellidos"];
  }

  function nombre_id_usuario($usuario_n,$usuario_a){
    $sql="select usu_id from usuarios where usu_nombre='$usuario_n' and usu_apellidos='$usuario_a'";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila["usu_id"];
  }

  function apellidos_usuario($usuario){
    $sql="select usu_apellidos from usuarios where usu_id=$usuario";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila["usu_apellidos"];
  }

  function imagen_usuario($usuario){
    $sql="select usu_imagen from usuarios where usu_id=$usuario";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    if (empty($fila["usu_imagen"])){
      $r = "images/user/user-default.png";
    }else{
      $r = $fila["usu_imagen"];
    }
    return $r;
  }

  function opciones_roles_list(){
		$sql ="SELECT rol_id, rol_nombre FROM roles";
		$rs = $this->fmt->query -> consulta($sql);
		$num = $this->fmt->query -> num_registros($rs);
		$aux="";
		if ($num > 0){
			for ( $i=1; $i <= $num; $i++){
				list($fila_id, $fila_nombre) = $this->fmt->query->obt_fila($rs);
				$aux .= '<div class="checkbox">';
				$aux .= '<label>';
				$aux .= '<input type="checkbox" name="inputRol[]" value="'.$fila_id.'">';
				$aux .= '<i class="'.$fila_icono.'"></i> '.$fila_nombre;
				$aux .= '</label>';
				$aux .= '</div>';
			}
		} else {
			$aux =" no existen roles registrados";
		}
		return $aux;
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

	function opciones_grupos(){
		$sql ="SELECT rol_grupo_id, rol_grupo_nombre FROM roles_grupo";
		$rs = $this->fmt->query -> consulta($sql);
		$num = $this->fmt->query -> num_registros($rs);
		$aux="";
		if ($num > 0){
			for ( $i=1; $i <= $num; $i++){
				list($fila_id, $fila_nombre) = $this->fmt->query->obt_fila($rs);
				$aux .= '<div class="checkbox">';
				$aux .= '<label>';
				$aux .= '<input type="checkbox" name="inputRolGrupo[]" value="'.$fila_id.'">';
				$aux .= '<i class="'.$fila_icono.'"></i> '.$fila_nombre;
				$aux .= '</label>';
				$aux .= '</div>';
			}
		} else {
			$aux =" no existen roles registrados";
		}
		return $aux;
	}  

  function nombre_cat($id_rol){
    $sql="select cts_nombre from cats where cts_id_roles=$id_rol";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila["cts_nombre"]." ".$fila["usu_apellidos"];
  }

  function id_cat_roles($id_rol){
    $sql="select cts_id from cats where cts_id_roles='$id_rol'";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila["cts_id"];
  }

  function nombre_cat_id($id_cat){
    $sql="select cts_nombre from cats where cts_id='$id_cat'";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila["cts_nombre"];
  }

  function permisos_roles_mod($id_rol,$id_mod){
    $sql="select rol_rel_mod_p_ver, rol_rel_mod_p_activar, rol_rel_mod_p_agregar, rol_rel_mod_p_editar, rol_rel_mod_p_eliminar from roles_rel where rol_rel_rol_id='$id_rol' and rol_rel_mod_id='$id_mod'";
    $rs = $this->fmt->query-> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    $perm["ver"]=$fila["rol_rel_mod_p_ver"];
    $perm["activar"]=$fila["rol_rel_mod_p_activar"];
    $perm["agregar"]=$fila["rol_rel_mod_p_agregar"];
    $perm["editar"]=$fila["rol_rel_mod_p_editar"];
    $perm["eliminar"]=$fila["rol_rel_mod_p_eliminar"];
    return $perm;
  }

}
