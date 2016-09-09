<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");


$fmt = new CONSTRUCTOR;
$fmt->class_modulo->fecha_zona('America/La_Paz');

if(isset($_GET["cat"]))
	$id_cat_hijo=$_GET["cat"];
else
	$id_cat_hijo=1;

if(isset($_GET["nota"])){
	$ruta_nota=$_GET["nota"];




$consulta ="SELECT not_id, not_titulo, not_resumen, not_cuerpo, not_imagen, not_fecha
            FROM noticia
            WHERE not_ruta_amigable='$ruta_nota'";

$rs =$this->fmt->query->consulta($consulta);
$num=$this->fmt->query->num_registros($rs);

if($num>0){
	for($i=0;$i<$num;$i++){
		$fila=$this->fmt->query->obt_fila($rs);

		$nombre_cat=$fmt->categoria->nombre_categoria($id_cat_hijo);
		$imagen_cat=$fmt->categoria->cat_imagen($id_cat_hijo);

			$ruta_cat = $fmt->categoria->traer_ruta_amigable_padre($id_cat_hijo);
			$ruta_noticia = _RUTA_WEB_temp.$ruta_cat."/".$fila["not_ruta_amigable"].".html";
			$fecha=$fila["not_fecha"];
			$hoy=date("Y-m-d H:i:s");
			$restante=$fmt->class_modulo->tiempo_restante($fecha,$hoy);

			$fecha_literal=$fmt->class_modulo->traer_fecha_literal($fecha);
			$imagen=_RUTA_WEB.$fila['not_imagen'];

			$nombre_archivo = $fmt->archivos->convertir_nombre_thumb($imagen);

			$file_headers = @get_headers($nombre_archivo);
			if($file_headers[0] != 'HTTP/1.1 404 Not Found')
				$imagen=$nombre_archivo;


?>
<div class="box-m-noticias">
  <div class="box-m-nota">
    <div class="header">
      <div class="box-cat">
        <img class="img-cat" alt="<?php echo $nombre_cat; ?>" src="<?php echo _RUTA_WEB.$imagen_cat; ?>">
      </div>
      <label><?php echo $nombre_cat; ?></label>
      <span>compartió esta noticia</span>
      <div class="box-m-fecha">
       <?php echo $restante; ?>
      </div>
    </div>
    <div class="box-m-cn">
			<img class="img-cat img-responsive" alt="" src="<?php echo $imagen; ?>">
      <div class="box-m-n">
        <label><h1><?php echo $fila["not_titulo"]; ?></h1></label>
        <div class="box-m-f"><?php echo $fecha_literal; ?></div>
        <div class="box-m-rs">
          <?php echo $fila["not_resumen"]; ?>
        </div>

        <div class="box-m-cp">
        <?php echo $fila["not_cuerpo"]; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

	}
}
}
?>
