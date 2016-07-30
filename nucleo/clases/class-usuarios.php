<?php
header('Content-Type: text/html; charset=utf-8');

class USUARIO{

  var $constructor;

  function __construct($fmt){
    $this->fmt = $fmt;
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
    return $fila["usu_imagen"];
  }

  function opciones_roles(){
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


}
