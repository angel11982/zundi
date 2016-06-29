<?php
header('Content-Type: text/html; charset=utf-8');

class CLASSSISTEMAS{

  var $fmt;

  function __construct($fmt){
    $this->fmt = $fmt;
  }

  function id_sistemas(){

  }

  function nombre_sistema($id_sis){
    $sql="SELECT mod_nombre FROM modulos WHERE  mod_id='$id_sis'";
    $rs = $this->fmt->query -> consulta($sql);
    $fila = $this->fmt->query->obt_fila($rs);
    return $fila["mod_nombre"];
  }

  function modulos_sistema($id_sis){
    $sql="SELECT modulos_mod_id FROM sistemas_modulos WHERE sistemas_sis_id='$id_sis'";
    $rs = $this->fmt->query -> consulta($sql);
    $num = $this->fmt->query -> num_registros($rs);
    if ($num > 0){
      for ( $i=0; $i < $num; $i++){
				list($fila_id) = $this->fmt->query->obt_fila($rs);
        $aux .= "- ".$this->nombre_sistema($fila_id)."</br>";
      }
    }
    return $aux;
  }

  function opciones_modulos($id_sis){
		$sql ="SELECT mod_id, mod_nombre FROM modulos where mod_activar='1' and mod_tipo<>'2'";
		$rs = $this->fmt->query -> consulta($sql);
		$num = $this->fmt->query -> num_registros($rs);
		$ck="";
		if ($num > 0){
			for ( $i=0; $i < $num; $i++){
				list($fila_id, $fila_nombre) = $this->fmt->query->obt_fila($rs);
        if(!empty($id_sis)){
          $sql_mod ="SELECT modulos_mod_id FROM sistemas_modulos WHERE sistemas_sis_id='$id_sis' and modulos_mod_id='$fila_id'";
          $rs_mod = $this->fmt->query -> consulta($sql_mod);
          $fila_mod = $this->fmt->query -> obt_fila($rs_mod);
          if ($fila_mod['modulos_mod_id']==$fila_id) { $ck="checked"; }else{ $ck=""; }
          $this->fmt->query->liberar_consulta($rs_mod);
        }
				$aux .= '<div class="checkbox">';
				$aux .= '<label>';
				$aux .= '<input type="checkbox" name="inputModulo[]" value="'.$fila_id.'" '.$ck.'>';
				$aux .= '<i class="'.$fila_icono.'"></i> '.$fila_nombre;
				$aux .= '</label>';
				$aux .= '</div>';
			}
		} else {
			$aux =" no existen modulos registrados";
		}
		return $aux;
	}

  function get_data($ruta){
    $rx = explode ("/",$ruta);
    $con = count($rx);
    $ruta_amig = $rx[$con-2];
    $sql="SELECT cat_id,cat_id_plantilla	from categoria WHERE cat_tipo=2 AND cat_ruta_amigable ='$ruta_amig'";
    $rs=$this->fmt->query->consulta($sql);
    $fila=$this->fmt->query->obt_fila($rs);
    $data = array($fila['cat_id'],$ruta_amig,$fila['cat_id_plantilla']);
    return $data;
  }

  function update_htaccess(){
      $nombre_archivo = _RUTA_SERVER.".htaccess";
      $datos = $this->get_data($nombre_archivo);
      //if($this->fmt->archivos->existe_archivo($nombre_archivo)){
      //  $this->fmt->archivos->permitir_escritura($nombre_archivo); }
      if($archivo = fopen($nombre_archivo, "w+") or die(print_r(error_get_last(),true)))
      {
            //categorias
            fwrite($archivo, "# htaccess " . PHP_EOL);
            fwrite($archivo, "# Fecha de modificacion:". date("d m Y H:m:s").PHP_EOL);
            fwrite($archivo, "#".PHP_EOL);
            fwrite($archivo, "RewriteEngine on".PHP_EOL);
            fwrite($archivo, "RewriteCond %{SCRIPT_FILENAME} !-d".PHP_EOL);
            fwrite($archivo, "RewriteCond %{SCRIPT_FILENAME} !-f".PHP_EOL);
            fwrite($archivo, "#".PHP_EOL);
            fwrite($archivo, "Rewriterule ^dashboard$  nucleo/dashboard.php".PHP_EOL);
            fwrite($archivo, "Rewriterule ^".$datos[1]."$  index.php?cat=".$datos[0]."&pla=".$datos[2].PHP_EOL);
            $sql="SELECT cat_id, cat_ruta_amigable, cat_id_plantilla FROM categoria WHERE cat_id_padre=".$datos[0];
            $rs=$this->fmt->query->consulta($sql);
            while ($R = $rs->fetch_array()) {
                   $id_cat=$R["cat_id"];
                   $ruta1=$R["cat_ruta_amigable"];
                   $pla=$R["cat_id_plantilla"];
                   if(!empty($ruta1)){
                     fwrite($archivo, "Rewriterule ^".$ruta1."$  index.php?cat=".$id_cat."&pla=".$pla.PHP_EOL);
                     //verificar categoria producdo
                     $sql1="SELECT mod_prod_cat_id from mod_productos_cat WHERE mod_prod_cat_idcat=".$id_cat;
                     $rs1=$this->fmt->query->consulta($sql1);
                     if($this->fmt->query->num_registros($rs1)>0){
                       while ($c = $rs1->fetch_array()) {
                         $id_ini = $c['mod_prod_cat_id'];
                         //escribir en htaccess las categorias
                         $sql2="SELECT * FROM mod_productos_cat WHERE mod_prod_cat_id_padre=".$id_ini;
                         $rs2=$this->fmt->query->consulta($sql2);
                         if($this->fmt->query->num_registros($rs2)>0){
                           while ($s = $rs2->fetch_array()) {
                              $id_cat_prod= $s['mod_prod_cat_id'];
                              $ruta2 = $s['mod_prod_cat_ruta_amigable'];
                              fwrite($archivo, "Rewriterule ^".$ruta1."/".$ruta2."$  index.php?cat=".$id_cat."&pla=1&cp=".$id_cat_prod.PHP_EOL);
                              $sql3 = "SELECT mpr.mod_prod_rel_prod_id, mp.mod_prod_ruta_amigable FROM mod_productos mp, mod_productos_rel mpr WHERE mpr.mod_prod_rel_cat_id=".$id_cat_prod." AND mpr.mod_prod_rel_prod_id=mp.mod_prod_id";
                              $rs3 = $this->fmt->query->consulta($sql3);
                              $rs3=$this->fmt->query->consulta($sql3);
                              if($this->fmt->query->num_registros($rs3)>0){
                                while ($p = $rs3->fetch_array()) {
                                  $prod_id = $p['mod_prod_id'];
                                  $ruta_producto = $p['mod_prod_ruta_amigable'];
                                  fwrite($archivo, "Rewriterule ^".$ruta1."/".$ruta2."/".$ruta_producto."$  index.php?cat=".$id_cat."&pla=2&cp=".$id_cat_prod."&prod=".$prod_id.PHP_EOL);
                                }
                              }
                           }
                         }
                       }
                     }
                  }
            }
            fclose($archivo);
        }
        //$this->fmt->archivos->quitar_escritura($nombre_archivo);
    }
}
?>
