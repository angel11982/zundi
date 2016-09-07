<?php
header('Content-Type: text/html; charset=utf-8');

class NAV{

  var $fmt;

  function __construct($fmt){
    $this->fmt = $fmt;
  }
  function activado_sistemas_rol($id_mod,$id_rol){
	$sql ="SELECT DISTINCT rol_rel_mod_id, rol_rel_mod_p_ver, rol_rel_mod_p_activar,  rol_rel_mod_p_agregar, rol_rel_mod_p_editar, rol_rel_mod_p_eliminar FROM roles_rel WHERE rol_rel_rol_id='$id_rol' and rol_rel_mod_id=$id_mod ";
    $rs = $this->fmt->query->consulta($sql);
    $num = $this->fmt->query->num_registros($rs);
    if($num>0)
    	return true;
    else
    	return false;
  }
  function activado_sistemas_rol_mod($id_sis,$id_rol){
	$sql ="SELECT modulos_mod_id FROM sistemas_modulos where sistemas_sis_id='$id_sis' ORDER BY modulos_mod_id ASC ";
    $rs = $this->fmt->query->consulta($sql);
    $num =$this->fmt->query->num_registros($rs);
    $sw=false;
    if ($num>0){
	    for ($i=0; $i<$num; $i++){
        	list($fila_id) = $this->fmt->query->obt_fila($rs);
        	if($this->activado_sistemas_rol($fila_id,$id_rol))
        		$sw=true;
        }
    }
    return $sw;

  }
  function construir_sistemas_rol($id_rol,$id_usu){  // revisar por roles
    $sql ="SELECT sis_id, sis_nombre, sis_icono FROM sistemas where sis_activar='1' ORDER BY sis_nombre ASC";
    $rs = $this->fmt->query->consulta($sql);
    $num = $this->fmt->query->num_registros($rs);
      if($num>0){
        for($i=0;$i < $num; $i++){
          list($fila_id,$fila_nombre,$fila_icono) = $this->fmt->query->obt_fila($rs);
          if($id_rol==1)
          	$aux .= $this->acordion($fila_id, "btn-menu-sidebar", $fila_nombre, $fila_icono,$id_rol); //$nombre, $menu, $id_sistema, $id_modulo
          else if($this->activado_sistemas_rol_mod($fila_id,$id_rol))
	       	$aux .= $this->acordion($fila_id, "btn-menu-sidebar", $fila_nombre, $fila_icono,$id_rol);
        }
      }
    return $aux;
  }

  function construir_sistemas_esenciales($id_rol, $id_usu){
    $sql ="SELECT mod_id  FROM modulos where mod_tipo='2' ORDER BY mod_id DESC";
    $rs = $this->fmt->query->consulta($sql);
    $num = $this->fmt->query->num_registros($rs);
      if($num>0){
        for($i=0;$i < $num; $i++){
          list($fila_id) = $this->fmt->query->obt_fila($rs);
          $aux .=  $this->construir_btn_sidebar("btn-menu-sidebar btn-menu-ajax", $fila_id);
        }
      }
    return $aux;
  }

  function construir_title_menu($nombre){
    $aux ="<div class='title-menu'>$nombre</div>";
    return $aux;
  }

  function construir_btn_sidebar($clase, $id_mod){

    $sql ="SELECT mod_nombre, mod_icono, mod_url FROM modulos where mod_id='".$id_mod."' and mod_activar='1'";
    $rs = $this->fmt->query->consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    $num =$this->fmt->query->num_registros($rs);
    $fila_nombre = $fila['mod_nombre'];
    $fila_icono  = $fila['mod_icono'];
    $fila_url    = $fila['mod_url'];
    if ($num > 0){
    $aux  ="<li>";
    $aux .='<a  class="'.$clase.'"  title="'.$fila_nombre.'"  icn="'.$fila_icono.'" id="btn-m'.$id_mod.'" id_mod="'.$id_mod.'">';
    $aux .= "<i class='".$fila_icono."'></i> <span>".$fila_nombre."</span> </a>";
    $aux .= "</li>";

    }

    return $aux;
  }

  function construir_btn_atajo ($clase, $id_atj){

    $sql ="SELECT atj_nombre, atj_icono, atj_url FROM atajos where atj_id='".$id_atj."' and atj_activar='1'";
    $rs = $this->fmt->query->consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    $num =$this->fmt->query->num_registros($rs);
    $fila_nombre = $fila['mod_nombre'];
    $fila_icono  = $fila['mod_icono'];
    $fila_url    = $fila['mod_url'];
    if ($num > 0){
    $aux ='<li class="dropdown">';
    $aux .='  <a  class="'.$clase.'"  title="'.$fila_nombre.'"  icn="'.$fila_icono.'" id="btn-a'.$id_atj.'" id_atj="'.$id_atj.'">';
    $aux .='  <i class="'.$fila_icono.'"></i>  <span>'.$fila_nombre.'</span> </a>';
    $aux .='</li>';
    }
    return $aux;
  }

  function acordion($id, $clase,$nombre, $icono,$id_rol,$id_usu){
    $aux ='<div class="panel-group acordion" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading-'.$id.'">
            <a role="button" data-toggle="collapse" class="'.$clase.'" data-parent="#accordion" href="#collapse-'.$id.'" aria-expanded="true" aria-controls="collapse-'.$id.'">
             <i class="'.$icono.'"></i> '.$nombre.' &nbsp; <i class="icn-chevron-donw btn-donw"></i>
            </a>
        </div>
        <div id="collapse-'.$id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'.$id.'">
          <div class="panel-body">
            '.$this->traer_modulos($id,$id_rol).'
          </div>
        </div>
      </div>
    </div>';
    return $aux;
  }

  function traer_modulos($id,$id_rol,$id_usu){
    $sql ="SELECT modulos_mod_id FROM sistemas_modulos where sistemas_sis_id='$id' ORDER BY modulos_mod_id ASC ";
    $rs = $this->fmt->query->consulta($sql);
    $num =$this->fmt->query->num_registros($rs);
    if ($num>0){
      for ($i=0; $i<$num; $i++){
        list($fila_id) = $this->fmt->query->obt_fila($rs);
        if($id_rol==1)
        	$aux .= $this->construir_btn_sidebar("btn btn-sm-sidebar btn-menu-ajax",$fila_id);
        else{
	        if($this->activado_sistemas_rol($fila_id,$id_rol))
	        	$aux .= $this->construir_btn_sidebar("btn btn-sm-sidebar btn-menu-ajax",$fila_id);
        }
      }
    }
    return $aux;
  }

  function traer_cat_hijos($cat){
    $sql="SELECT cat_id, cat_nombre, cat_id_padre, cat_icono, cat_url, cat_destino, cat_ruta_amigable FROM categoria WHERE cat_id_padre='$cat' and cat_activar='1' ORDER BY cat_orden ASC";
    $rs = $this->fmt->query->consulta($sql);
    $num = $this->fmt->query->num_registros($rs);
    if ($num>0){
      for ($i=0; $i<$num; $i++){

        list($fila_id, $fila_nombre, $fila_id_padre, $fila_icono, $fila_url, $fila_destino, $fila_ruta_amigable) =  $this->fmt->query->obt_fila($rs);

        if (!empty($fila_url)){
          $url= $fila_url; $destino=$fila_destino;
        }else{
          $url= $fila_ruta_amigable; $destino="";
        }
        $aux .= $this->fmt_li($fila_id,"","",$fila_nombre, $url, $destino );
      }
    }
    return $aux;
  }

  function traer_cat_hijos_menu($cat){
    $sql="SELECT cat_id, cat_nombre, cat_id_padre, cat_icono, cat_imagen, cat_url, cat_destino, cat_ruta_amigable FROM categoria WHERE cat_id_padre='$cat' and cat_activar='1' ORDER BY cat_orden ASC";
    $rs = $this->fmt->query->consulta($sql);
    $num = $this->fmt->query->num_registros($rs);
    if ($num>0){
      for ($i=0; $i<$num; $i++){

        list($fila_id, $fila_nombre, $fila_id_padre,$fila_icono, $fila_imagen, $fila_url, $fila_destino, $fila_ruta_amigable) =  $this->fmt->query->obt_fila($rs);

        if (!empty($fila_url)){
          $url= $fila_url; $destino=$fila_destino;
        }else{
          $url= $fila_ruta_amigable; $destino="";
        }
        if ( $this->tiene_cat_hijos($fila_id) ){
          $aux .= $this->fmt_li_hijos($fila_id, $fila_nombre);
        } else {
          $aux .= $this->fmt_li($fila_id,"","",$fila_nombre, $url, $destino, $fila_imagen,$cat);
        }
      }
      return $aux;
    }
  }

  function fmt_li($id, $clase, $icono, $nombre,$url, $destino, $imagen, $cat){

    $nombre_x = $this->convertir_url_amigable($nombre);
    $url=_RUTA_WEB_temp.$this->fmt->categoria->traer_ruta_amigable_padre($id, $cat);

    //$url=$this->fmt->categoria->traer_ruta_amigable_padre($id);
    //echo $url;
    if (empty($imagen)){ $aux_x=""; }else{ $aux_x="<img class='img-m' src='"._RUTA_WEB.$imagen."' border=0>"; }
    $aux  = '<li id="btn-m'.$id.'" class="btn-m'.$id.' '.$clase.' btn-m-'.$nombre_x.'">';
    $aux .= '<a href="'.$url.'" target="'.$destino.'">';
    $aux .= $aux_x;
    $aux .= '<i class="'.$icono.'"></i>';
    $aux .= '<span>'.$nombre.'</span></a>';
    $aux .= '</li>';
    return $aux;
  }

  function tiene_cat_hijos($id){
    $sql="SELECT cat_id FROM categoria WHERE cat_id_padre=$id";
    $rs=$this->fmt->query->consulta($sql);
    $num=$this->fmt->query->num_registros($rs);
    if($num>0){
      return true;
    }else{
      return false;
    }
  }

  function fmt_li_hijos($id, $nombre){
    $aux  = '<li class="dropdown">';
    $aux .= ' <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$nombre.'<span class="fa fa-angle-down"></span></a>';
    $aux .=   '<ul class="dropdown-menu animated fadeIn">';
    $aux .=     $this->traer_cat_hijos_menu($id);
    $aux .=   '</ul>';
    $aux .= '</li>';
    return $aux;
  }

  function convertir_url_amigable($cadena){
    $cadena= utf8_decode($cadena);
    $cadena = strtolower($cadena);
    $cadena = str_replace(' ', '-', $cadena);
    $cadena = str_replace('?', '', $cadena);
    $cadena = str_replace('+', '', $cadena);
    $cadena = str_replace(':', '', $cadena);
    $cadena = str_replace('??', '', $cadena);
    $cadena = str_replace('`', '', $cadena);
    $cadena = str_replace('!', '', $cadena);
    $cadena = str_replace('¿', '', $cadena);
    $cadena = str_replace(',', '-', $cadena);
    $cadena = str_replace('(', '', $cadena);
    $cadena = str_replace(')', '', $cadena);
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ??';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);

    return $cadena;
  }

}

?>
