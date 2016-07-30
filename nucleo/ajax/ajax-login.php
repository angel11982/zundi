<?php

require_once("../clases/class-constructor.php");
$fmt = new CONSTRUCTOR();

$cat = $fmt->get->get_categoria_index();
$pla = $fmt->get->get_plantilla_index($fmt->query,$cat);

$email= $_POST['inputEmail'];
$pw= base64_encode( $_POST['password'] );
//echo $email." : ".$pw;

$sql="SELECT usu_id, usu_nombre, usu_email, usu_estado FROM usuarios WHERE usu_email='".$email."' and usu_password='".$pw."' ";
$rs = $fmt->query->consulta($sql);
$num= $fmt->query->num_registros($rs);
//echo "num:".$num;

if($num > 0){
  list($usu_id, $usu_nombre, $usu_email, $usu_estado) = $fmt->query->obt_fila($rs);
  $fmt->sesion->set_variable("usu_id",$usu_id);
  $fmt->sesion->set_variable("usu_nombre",$usu_nombre);
  $fmt->sesion->set_variable("usu_mail",$usu_email);

  //$fmt->sesion->get_nombre();
  //$fmt->sesion->imprimir();
  //$redireccion = new REDIRECCION();
  $ruta = $fmt->redireccion->login($cat,$pla,$usu_id);
  if ($usu_estado=='0'){
    echo "rol-desactivado";
    $fmt->sesion->cerrar_sesion();
  } else {
    if ($fmt->usuario->id_rol_usuario($usu_id)) {
      $fmt->sesion->set_variable("usu_rol",$fmt->usuario->id_rol_usuario($usu_id));
      echo $ruta;
    } else{
      echo "sin-rol";
      $fmt->sesion->cerrar_sesion();
    }
  }
} else {
  echo "false";
} 


?>
