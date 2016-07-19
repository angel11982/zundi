<?php
header('Content-Type: text/html; charset=utf-8');

class CATEGORIA{

  var $fmt;

  function __construct($fmt) {
    $this->fmt = $fmt;
  }

  function categoria_id_tipo($cat){
	$this->fmt->get->validar_get($cat);
	$consulta = "SELECT cat_tipo FROM categoria WHERE cat_id='$cat' ";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    $tipo=$fila["cat_tipo"];
    return $tipo;
  }

  function ruta_amigable($cat){
  $this->fmt->get->validar_get($cat);
  $consulta = "SELECT cat_ruta_amigable FROM categoria WHERE cat_id='$cat' ";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    $tipo=$fila["cat_ruta_amigable"];
    return $tipo;
  }

  function categoria_id_padre($cat){
	$this->fmt->get->validar_get($cat);
	$consulta = "SELECT cat_id_padre FROM categoria WHERE cat_id='$cat' ";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    $id=$fila["cat_id_padre"];
    return $id;
  }

  function id_padre($cat,$from,$prefijo){
  $this->fmt->get->validar_get($cat);
  $consulta = "SELECT ".$prefijo."id_padre FROM ".$from." WHERE ".$prefijo."id='$cat' ";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    $id=$fila[$prefijo."id_padre"];
    return $id;
  }

  function nombre_categoria($cat){
	$this->fmt->get->validar_get($cat);
  if ($cat==0){
    return 'raiz (0)';
  }
	$consulta = "SELECT cat_nombre FROM categoria WHERE cat_id='$cat' ";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    $nombre=$fila["cat_nombre"];
    return $nombre;
  }

  function descripcion($cat,$from,$prefijo){
	$this->fmt->get->validar_get($cat);
	if ($cat==0){
    	return 'sin descripción';
  	}
	$consulta = "SELECT ".$prefijo."descripcion FROM ".$from." WHERE ".$prefijo."id='$cat' ";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    $nombre=$fila[$prefijo."descripcion"];
    return $nombre;
  }

  function nombre($cat,$from,$prefijo){
  $this->fmt->get->validar_get($cat);
  if ($cat==0){
    return 'raiz (0)';
  }
  $consulta = "SELECT ".$prefijo."nombre FROM ".$from." WHERE ".$prefijo."id='$cat' ";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    $nombre=$fila[$prefijo."nombre"];
    return $nombre;
  }

  function categoria_padre_sitio($cat){
  	$this->fmt->get->validar_get($cat);
  	$cat_padre = $this->categoria_id_padre($cat);
  	$cat_tipo = $this->categoria_id_tipo($cat_padre);
  	if ($cat_tipo=='2'){
  		return $cat_padre;
  	}
  	//}else {
  	//	$this->categoria_padre_sitio($cat_padre);
  	//}
  	return $cat_padre;
  }

  function favicon_categoria($cat){
	$this->fmt->get->validar_get($cat);
	$consulta = "SELECT cat_favicon FROM categoria WHERE cat_id='$cat' ";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    $favicon=$fila["cat_favicon"];
    return $favicon;
  }

  function arbol_editable($from,$prefijo,$url_modulo){
    echo "<div class='arbol'>";

    $consulta = "SELECT ".$prefijo."id, ".$prefijo."nombre FROM ".$from." WHERE ".$prefijo."id_padre='0' ORDER BY ".$prefijo."orden";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    if($num>0){
      echo "<div class='arbol-nuevo'><a href='"._RUTA_WEB.$url_modulo."'><i class='icn-plus'></i> nuevo</a></div>";
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
        if ($i==$num-1) { $aux = 'icn-point-4'; } else { $aux = 'icn-point-1'; }
        echo "<div class='nodo'><i class='".$aux." i-nodo'></i> ".$fila_nombre;
        $this->accion($fila_id,$from,$prefijo);
        echo "</div>";
        if ($this->tiene_hijos($fila_id,$from,$prefijo)){
          $this->hijos($fila_id,'1',$from,$prefijo);
        }
      }
    }else{
      echo "<div class='arbol-nuevo'><a href='"._RUTA_WEB.$url_modulo."'><i class='icn-plus'></i> nuevo</a></div>";
    }
    echo "</div>";
    return;
  }

  function arbol($id,$cat,$cat_valor){
    //var_dump($cat_valor);
    echo "<div class='arbol-cat'>";
    $sql="SELECT cat_id, cat_nombre FROM categoria WHERE cat_id_padre='".$cat."'";
    $rs = $this->fmt->query->consulta($sql);
    $num=$this->fmt->query->num_registros($rs);
    $nivel=1;
    $espacio = 0;
    $num_v = count($cat_valor);
    if($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
        echo "<label style='margin-left:".$espacio."px'><input name='".$id."[]' type='checkbox' id='cat-$fila_id' value='$fila_id' $aux> <span>".$fila_nombre."</span></label>";
        if ($this->tiene_hijos_cat($fila_id)){
          $this->hijos_cat_check($id,$fila_id,$nivel);
        }
      }
    }
    echo "</div>";
    if (!empty($cat_valor)){
    ?>
    	<script language="JavaScript">
	    	$(document).ready( function () {
		    	<?php for ($j=0;$j<$num_v;$j++){ ?>
		    	var dato<?php echo $j; ?> = <?php echo $cat_valor[$j]; ?>;
		    	$("#cat-<?php echo $cat_valor[$j]; ?>").prop("checked", true);
		    	<?php } ?>
		    });
	    </script>
    <?php
	}
  }

  function tiene_hijos($cat,$from,$prefijo){
    $consulta = "SELECT ".$prefijo."id  FROM ".$from." WHERE ".$prefijo."id_padre='$cat'";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    if ($num>0){
      return true;
    }else{
      return false;
    }
  }


  function tiene_hijos_cat($cat){
    $consulta = "SELECT cat_id  FROM categoria WHERE cat_id_padre='$cat'";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    if ($num>0){
      return true;
    }else{
      return false;
    }
  }

  function hijos_cat($cat,$nivel){
    $consulta = "SELECT cat_id,cat_nombre  FROM categoria WHERE cat_id_padre='$cat' ORDER BY cat_orden";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    
    if ($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);

        $valor_n= 25 * ($nivel+1);

        $aux_nivel = $this->img_nodo("linea",$nivel);
        echo "<div class='nodo-hijo' style='padding-left:".$valor_n."px'> ".$aux_nivel."".$fila_nombre;
        //$this->accion($fila_id,$from,$prefijo_activar);
        echo "</div>";
        if ( $this->tiene_hijos_cat($fila_id) ){
          $nivel++;
          $this->hijos_cat($fila_id, $nivel);
        }
      }
    }
  }
  function hijos_cat_check($id,$cat,$nivel){
    $consulta = "SELECT cat_id,cat_nombre  FROM categoria WHERE cat_id_padre='$cat' ORDER BY cat_orden";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    if ($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
        	$espacio=  $nivel * 10;
			$aux_nivel = $this->img_nodo("linea",$nivel);
        echo $aux_nivel."<label style='margin-left:".$espacio."px'><input name='".$id."[]' id='cat-$fila_id' type='checkbox' value='$fila_id' $aux> <span>".$fila_nombre."</span></label>";
        if ( $this->tiene_hijos_cat($fila_id) ){
          $nivel++;
          $this->hijos_cat_check($id,$fila_id,$nivel);
        }
      }
    }
  }

  function hijos($cat,$nivel,$from,$prefijo){
    $consulta = "SELECT ".$prefijo."id, ".$prefijo."nombre  FROM ".$from." WHERE ".$prefijo."id_padre='$cat' ORDER BY ".$prefijo."orden";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    if ($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);

        $valor_n= 25 * ($nivel+1);

        $aux_nivel = $this->img_nodo("linea",$nivel);
        echo "<div class='nodo-hijo' style='padding-left:".$valor_n."px'> ".$aux_nivel."".$fila_nombre;
        $this->accion($fila_id,$from,$prefijo);
        echo "</div>";
        if ( $this->tiene_hijos($fila_id,$from,$prefijo) ){
          $nivel++;
          $this->hijos($fila_id, $nivel,$from,$prefijo);
        }
      }
    }
  }

  function img_nodo($modo,$nivel){
  }

  function accion($cat,$from,$prefijo){
    $var_activo=$this->estado_activo($cat,$from,$prefijo);
    if ($var_activo=="1"){ $i='icn-eye-open'; $a="1"; }else{ $i='icn-eye-close'; $a="0"; }
    echo " <i class='icn-plus btn-i btn-nuevo-i' cat='".$cat."' ></i>";
    echo " <i class='".$i." btn-i btn-activar-i' estado='".$a."'  cat='".$cat."'></i>";
    echo " <i class='icn-pencil btn-i btn-editar-i' title='editar $cat' cat='".$cat."'></i>";
    echo " <i class='icn-block-page btn-i btn-contenedores' cat='".$cat."' ></i>";
    echo " <i class='icn-trash btn-i btn-eliminar' idEliminar='".$cat."' nombreEliminar='".$this->nombre($cat,$from,$prefijo)."'  cat='".$cat."' ></i>";
    return;
  }

  function estado_activo($cat,$from,$prefijo){
    $consulta = "SELECT ".$prefijo."activar  FROM ".$from." WHERE ".$prefijo."id='$cat'";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila[$prefijo.'activar'];
  }

  function id_plantilla_cat($cat){
    $consulta = "SELECT cat_id_plantilla  FROM categoria WHERE cat_id='$cat'";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila['cat_id_plantilla'];
  }

  function traer_opciones_cat($cat){
    $id_padre=$this->categoria_id_padre($cat);
    $consulta = "SELECT cat_id, cat_nombre FROM categoria WHERE cat_id_padre='0'  ORDER BY cat_orden";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    echo "<option class='' value='0'>Raiz (0)</option>";
      if($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
        if ($fila_id==$id_padre){ $aux="selected"; }else{ $aux=""; }
        if ($fila_id==$cat){ $aux1="disabled"; }else{ $aux1=""; }
        echo "<option class='' value='$fila_id' $aux $aux1 > ".$fila_nombre;
        echo "</option>";
        if ($this->tiene_hijos_cat($fila_id)){
          $this->hijos_opciones_cat($fila_id,'1',$id_padre);
        }
      }
    }
  }

  function traer_opciones($cat,$from,$prefijo){
    $id_padre=$this->id_padre($cat,$from,$prefijo);
    $consulta ="SELECT ".$prefijo."id, ".$prefijo."nombre FROM ".$from." WHERE ".$prefijo."id_padre='0'";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    echo "<option class='' value='0'>Raiz (0)</option>";
      if($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
        if ($fila_id==$id_padre){ $aux="selected"; }else{ $aux=""; }
        if ($fila_id==$cat){ $aux1="disabled"; }else{ $aux1=""; }
        echo "<option class='' value='$fila_id' $aux $aux1 > ".$fila_nombre;
        echo "</option>";
        if ($this->tiene_hijos($fila_id,$from,$prefijo)){
          $this->hijos_opciones($fila_id,'1',$id_padre,$from,$prefijo);
        }
      }
    }
  }



  function hijos_opciones_cat($cat,$nivel,$id_padre){
    $consulta = "SELECT cat_id,cat_nombre  FROM categoria WHERE cat_id_padre='$cat' ORDER BY cat_orden";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    if ($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
        $valor_n="";
        for ($j=0;$j<$nivel;$j++){
          $valor_n .='--';
        }
        if ($fila_id==$id_padre){ $aux="selected"; }else{ $aux=""; }
        if ($fila_id==$cat){ $aux1="disabled"; }else{ $aux1=""; }
        echo "<option class='' value='$fila_id' $aux  $aux1 > ".$valor_n.$fila_nombre;
        echo "</option>";
        if ( $this->tiene_hijos_cat($fila_id) ){
          $nivel++;
          $this->hijos_opciones_cat($fila_id, $nivel);
        }
      }
    }
  }

  function hijos_opciones($cat,$nivel,$id_padre,$from,$prefijo){
    $consulta = "SELECT ".$prefijo."id, ".$prefijo."nombre  FROM ".$from." WHERE ".$prefijo."id_padre='$cat' ORDER BY ".$prefijo."orden";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    if ($num>0){
      for($i=0;$i<$num;$i++){
        list($fila_id,$fila_nombre)=$this->fmt->query->obt_fila($rs);
        $valor_n="";
        for ($j=0;$j<$nivel;$j++){
          $valor_n .='--';
        }
        if ($fila_id==$id_padre){ $aux="selected"; }else{ $aux=""; }
        if ($fila_id==$cat){ $aux1="disabled"; }else{ $aux1=""; }
        echo "<option class='' value='$fila_id' $aux  $aux1 > ".$valor_n.$fila_nombre;
        echo "</option>";
        if ( $this->tiene_hijos($fila_id,$from,$prefijo) ){
          $nivel++;
          $this->hijos_opciones($fila_id, $nivel,$from,$prefijo);
        }
      }
    }
  }

  function opciones_tipo_cat($cat){
    $consulta = "SELECT cat_tipo  FROM categoria WHERE cat_id='$cat'";
    $rs = $this->fmt->query->consulta($consulta);
    $fila = $this->fmt->query->obt_fila($rs);

    for($i=0;$i<3;$i++){
      if ($fila["cat_tipo"]==$i){ $aux="selected"; }else{ $aux=""; }
      echo "<option class='' value='".$i."' ".$aux." > ".$this->tipo_cat($i);
      echo "</option>";
    }
  }

  function tipo_cat($tipo){
    switch ($tipo) {
      case '0':
        return "Estandar";
        break;
      case '1':
        return "Logeada";
        break;
      case '2':
        return "Sitio";
        break;

      default:
        return "error";
        break;
    }
  }

  function opciones_destino($destino){
      $aux="";
      if ($destino=="_self"){ $aux ="selected"; }
      if ($destino=="_blank"){ $aux ="selected"; }
      echo "<option class='' value='_self' > La misma página (_self)</option>";
      echo "<option class='' value='_blank' > En otra pestaña (_blank)</option>";
  }

  function traer_rel_cat_nombres($fila_id,$from,$prefijo_cat,$prefijo_rel){
    $consulta = "SELECT ".$prefijo_cat." FROM ".$from." WHERE ".$prefijo_rel."='".$fila_id."'";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    if ($num>0){
      for ($i=0;$i<$num;$i++){
        list($fila_id1)=$this->fmt->query->obt_fila($rs);
        echo "- ".$this->nombre_categoria($fila_id1)."<br/>";
      }
    }
  }

  function traer_rel_cat_id($fila_id,$from,$prefijo_cat,$prefijo_rel){
    $consulta = "SELECT ".$prefijo_cat." FROM ".$from." WHERE ".$prefijo_rel."='".$fila_id."'";
    $rs = $this->fmt->query->consulta($consulta);
    $num=$this->fmt->query->num_registros($rs);
    if ($num>0){
      for ($i=0;$i<$num;$i++){
        list($fila_id1)=$this->fmt->query->obt_fila($rs);
        $aux[$i]=  $fila_id1;
      }
    }
    return $aux;
  }

  function traer_dominio_cat_ruta($dato){
    $consulta = "SELECT cat_dominio FROM categoria WHERE cat_ruta_sitio='".$dato."' and cat_tipo='2'";
    $rs = $this->fmt->query->consulta($consulta);
    $fila=$this->fmt->query->obt_fila($rs);
    return $fila["cat_dominio"];
  }

    function traer_dominio_cat_id($dato){
    $consulta = "SELECT cat_dominio FROM categoria WHERE cat_id='".$dato."' and cat_tipo='2'";
    $rs = $this->fmt->query->consulta($consulta);
    $fila=$this->fmt->query->obt_fila($rs);
    return $fila["cat_dominio"];
  }

  function traer_id_cat_dominio($dato){
    $consulta = "SELECT cat_id FROM categoria WHERE cat_dominio='".$dato."' and cat_tipo='2'";
    $rs = $this->fmt->query->consulta($consulta);
    $fila=$this->fmt->query->obt_fila($rs);
    return $fila["cat_id"];
  }
}
?>
