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

  function get_data_on($ruta){
    $rx = explode ("/",$ruta);
    $con = count($rx);
    $ruta_amig = $rx[$con-2];
    $sql="SELECT cat_id,cat_id_plantilla	from categoria WHERE cat_tipo=2 AND cat_ruta_amigable ='$ruta_amig'";
    $rs=$this->fmt->query->consulta($sql);
    $fila=$this->fmt->query->obt_fila($rs);
    $data = array($fila['cat_id'],$ruta_amig,$fila['cat_id_plantilla']);
    return $data;
  }

  function get_data_off($ruta){
    $rx = explode ("/",$ruta);
    $con = count($rx);
    $ruta_amig = $rx[$con-2];

    return $ruta_amig;
  }

  function get_sub_cat($archivo,$id_cat_recibido,$ruta){
    $sql="SELECT cat_id, cat_ruta_amigable, cat_id_plantilla FROM categoria WHERE cat_id_padre=".$id_cat_recibido;
    $rs=$this->fmt->query->consulta($sql);
    if($this->fmt->query->num_registros($rs)>0){
      while ($R = $rs->fetch_array()) {
             $id_cat=$R["cat_id"];
             $ruta1=$R["cat_ruta_amigable"];
             $pla=$R["cat_id_plantilla"];

             if(!empty($ruta1)){
               $ruta_com = $ruta."/".$ruta1;
              // echo '<script type="text/javascript">alert("id_cat' . $id_cat .' ruta='.$ruta_com.' ");</script>';
               fwrite($archivo, "Rewriterule ^".$ruta_com."$  index.php?cat=".$id_cat."&pla=".$pla.PHP_EOL) or die(print_r(error_get_last(),true));
               fwrite($archivo, "Rewriterule ^".$ruta_com."/([^/]*).html$  index.php?cat=".$id_cat."&pla=3&nota=$1".PHP_EOL);

               $sql2="SELECT mod_prod_id, mod_prod_ruta_amigable FROM mod_productos, mod_productos_rel WHERE mod_prod_id=mod_prod_rel_prod_id and mod_prod_rel_cat_id=".$id_cat;

			   $rs2=$this->fmt->query->consulta($sql2);

               if($this->fmt->query->num_registros($rs2)>0){
               	while ($s = $rs2->fetch_array()) {
                	$id_prod= $s['mod_prod_id'];
                    $ruta2 = $s['mod_prod_ruta_amigable'];
                    if (!empty($ruta2)) {
                    	fwrite($archivo, "Rewriterule ^".$ruta."/".$ruta1."/".$ruta2."$  index.php?cat=".$id_cat."&pla=2&prod=".$id_prod.PHP_EOL);
                        fwrite($archivo, "Rewriterule ^".$ruta."/".$ruta1."/".$ruta2."/pag=([0-9]+)$  index.php?cat=".$id_cat."&pla=1&prod=".$id_prod."&pag=$1".PHP_EOL);

                    }
                 }
                }

				$this->get_sub_cat($archivo,$id_cat,$ruta_com);
             }
      }
    }

  }

  function update_htaccess(){
      $nombre_archivo = _RUTA_HT.".htaccess";
      if(_MULTIPLE_SITE=="on")
      	$datos = $this->get_data_on($nombre_archivo);
      else
      	$datos = $this->get_data_off($nombre_archivo);
      //if($this->fmt->archivos->existe_archivo($nombre_archivo)){
      //  $this->fmt->archivos->permitir_escritura($nombre_archivo); }
      if($archivo = fopen($nombre_archivo, "w+") or die(print_r(error_get_last(),true)))
      {
            //categorias
            fwrite($archivo, "# htaccess ".$datos[1]. PHP_EOL);
            fwrite($archivo, "# Fecha de modificacion:". date("d m Y H:m:s").PHP_EOL);
            fwrite($archivo, "#".PHP_EOL);
            fwrite($archivo, "RewriteEngine on".PHP_EOL);
            fwrite($archivo, "RewriteCond %{SCRIPT_FILENAME} !-d".PHP_EOL);
            fwrite($archivo, "RewriteCond %{SCRIPT_FILENAME} !-f".PHP_EOL);
            fwrite($archivo, "#".PHP_EOL);
            fwrite($archivo, "Rewriterule ^dashboard$  nucleo/dashboard.php".PHP_EOL);

            if(_MULTIPLE_SITE=="on"){
            	fwrite($archivo, "Rewriterule ^".$datos[1]."$  index.php?cat=".$datos[0]."&pla=".$datos[2].PHP_EOL);
            	fwrite($archivo, "Rewriterule ^buscar/([^/]*)$  index.php?cat=".$datos[0]."&pla=2&q=$1".PHP_EOL);
				$padre_cat=$datos[0];
				$sql="SELECT cat_id, cat_ruta_amigable, cat_id_plantilla FROM categoria WHERE cat_id_padre=".$padre_cat;
            }
            else{
            	fwrite($archivo, "Rewriterule ^".$datos."$  index.php?cat=1&pla=1".PHP_EOL);
            	fwrite($archivo, "Rewriterule ^buscar/$  index.php?cat=1&pla=2".PHP_EOL);
            	$datos[0]=0;
				$sql="SELECT cat_id, cat_ruta_amigable, cat_id_plantilla FROM categoria WHERE cat_activar=1";
            }


            
            $rs=$this->fmt->query->consulta($sql);
            while ($R = $rs->fetch_array()) {
                   $id_cat=$R["cat_id"];
                   $ruta1=$R["cat_ruta_amigable"];
                   $pla=$R["cat_id_plantilla"];
                   if(!empty($ruta1)){

                     fwrite($archivo, "Rewriterule ^".$ruta1."$  index.php?cat=".$id_cat."&pla=".$pla.PHP_EOL);
                     // sitios con pla!=1
                     fwrite($archivo, "Rewriterule ^".$ruta1."/p=([0-9]+)$  index.php?cat=".$id_cat."&pla=$1".PHP_EOL);
                     // sitios con paginación
                     fwrite($archivo, "Rewriterule ^".$ruta1."/pag=([0-9]+)$  index.php?cat=".$id_cat."&pla=".$pla."&pag=$1".PHP_EOL);
                     fwrite($archivo, "Rewriterule ^".$ruta1."/([^/]*).html$  index.php?cat=".$id_cat."&pla=3&nota=$1".PHP_EOL);
                     fwrite($archivo, "Rewriterule ^".$ruta1."/prod=([0-9]+)$  index.php?cat=".$id_cat."&pla=1&prod=$1".PHP_EOL);

                     fwrite($archivo, "Rewriterule ^".$ruta1."/prod=([0-9]+)&ruta=([^/]*)$  index.php?cat=".$id_cat."&pla=1&prod=$1&ruta=$2".PHP_EOL);

                     //escribir en htaccess las categorias del producdo
                     $sql2="SELECT mod_prod_id, mod_prod_ruta_amigable FROM mod_productos, mod_productos_rel WHERE mod_prod_id=mod_prod_rel_prod_id and mod_prod_rel_cat_id=".$id_cat;


                     $rs2=$this->fmt->query->consulta($sql2);

                     if($this->fmt->query->num_registros($rs2)>0){
                     	while ($s = $rs2->fetch_array()) {
                         $id_prod= $s['mod_prod_id'];
                         $ruta2 = $s['mod_prod_ruta_amigable'];
                         if (!empty($ruta2)) {
                         	fwrite($archivo, "Rewriterule ^".$ruta1."/".$ruta2."$  index.php?cat=".$id_cat."&pla=2&prod=".$id_prod.PHP_EOL);
                            fwrite($archivo, "Rewriterule ^".$ruta1."/".$ruta2."/pag=([0-9]+)$  index.php?cat=".$id_cat."&pla=1&prod=".$id_prod."&pag=$1".PHP_EOL);


                         }
                        }
                      }

					  $this->get_sub_cat($archivo,$id_cat,$ruta1);


                  }


            }

            fclose($archivo);
        }
        //$this->fmt->archivos->quitar_escritura($nombre_archivo);
    }
}
?>
