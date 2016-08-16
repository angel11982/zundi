<?php
header("Content-Type: text/html;charset=utf-8");

class CONTENEDORES{

	var $fmt;
	var $id_mod;

	function CONTENEDORES($fmt){
		$this->fmt = $fmt;
	}

  function editar_contenidos(){
    $this->fmt->get->validar_get ( $_GET['cat'] );
    $cat = $_GET['cat'];
    $pla = $this->fmt->categoria->id_plantilla_cat($cat);
    $nombre_cat=$this->fmt->categoria->nombre_categoria($cat);
    $botones .= $this->fmt->class_pagina->crear_btn("publicaciones.adm.php?tarea=form_nuevo","btn btn-primary","icn-plus","Nueva Publicación");  // link, tarea, clase, icono, nombre
		$this->fmt->class_pagina->crear_head_mod( "icn-block-page color-text-rojo","Contenidos: ".$nombre_cat, $botones); // bd, id modulo, botones
		
    ?>
    <link href="<?php echo _RUTA_WEB; ?>css/estilos.cont.css" rel="stylesheet" type="text/css" />
		<div class="body-modulo sorteable">
      <?php
        $rs = $this->fmt->plantilla->obtener_padre($cat,$pla);
        $num = $this->fmt->query->num_registros($rs);
        if ($num > 0){
					list($cont_id, $cont_nombre, $cont_css,$cont_clase, $con_id_contenedor, $cont_codigos) = $this->fmt->query->obt_fila($rs);
					//echo "id_cont:".$cont_id;
          echo "<div class='cnt-box-head unsorteable'><label>".$cont_nombre."</label>";
          echo "  <i class='pull-right icn-pencil btn-i btn-editar' id_cont='".$cont_id."' ></i><div class='cnt-box'>";
          $rs_pub = $this->fmt->plantilla->obtener_publicaciones($cont_id,$cat,$pla);
          $cant = $this->fmt->query->num_registros($rs_pub);
          if ($cant > 0){
            //echo "aqui pub";
            while ($fila_aux = $this->fmt->query->obt_fila($rs_pub)){
              $this->cargar_pub($fila_aux["pub_nombre"],$fila_aux["pub_id"],$fila_aux["pubrel_activar"]);
            }
          }
          echo "</div></div>";
				}
      ?>
    </div>
      <script>
        $(function() {
          $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable"
          }).disableSelection();
        });
        $(".btn-editar").click(function(e) {
          var id = $( this ).attr("id_cont");
          url="contenedores.adm.php?tarea=form_editar&modo=editar_contenidos&cat=<?php echo $cat; ?>&id="+id;
          //alert(url);
          window.location=(url);
        });
      </script>
      
    <?php
  }

  function cargar_pub($pub_nombre,$pub_id,$pub_activar){
    echo "<div class='cnt-publicacion' idpub='".$pub_id."' id='pub-".$pub_id."'>";
    echo "  <i class='btn-i icn-move btn-mover'></i> <label>".$pub_nombre."</label>";
    echo "  <i class='btn-i icn-trash btn-eliminar-i pull-right' idpub='".$pub_id."'  ></i>";
    echo "  <i class='btn-i icn-pencil btn-editar-i pull-right' idpub='".$pub_id."'  ></i>";
    if ($pub_activar==1){ $aux="icn-eye-open";}else{$aux="icn-eye-close";}
    echo "  <i class='btn-i $aux btn-activar-i pull-right' idpub='".$pub_id."'  ></i>";

    echo "</div>";
  }

  function form_editar(){
    $this->fmt->get->validar_get ( $_GET['cat'] );
    $this->fmt->get->validar_get ( $_GET['id'] );
    $modo = $_GET['modo'];
    $id = $_GET['id'];
    $cat = $_GET['cat'];

    if ($modo=="busqueda"){ $tarea="busqueda" ;}
    if ($modo=="editar_contenidos"){ $tarea="editar_contenidos" ;}
    $botones = $this->fmt->class_pagina->crear_btn("contenedores.adm.php?cat=".$cat."&tarea=".$tarea,"btn btn-link  btn-volver","icn-chevron-left","volver"); // link, clase, icono, nombre
    $this->fmt->class_pagina->crear_head_form("Editar Contenedor", $botones,"");


    $sql="select * from contenedor	where cont_id='".$id."'";
    $rs=$this->fmt->query->consulta($sql);
    $num=$this->fmt->query->num_registros($rs);
      if($num>0){
        for($i=0;$i<$num;$i++){
          list($fila_id,$fila_nombre,$fila_clase,$fila_css,$fila_codigos,$fila_activar,$fila_id_padre,$fila_orden)=$this->fmt->query->obt_fila($rs);
        }
      }

    ?>
    <div class="body-modulo col-xs-6 col-xs-offset-3">
      <form class="form form-modulo" action="contenedores.adm.php?modo=<?php echo $modo; ?>&tarea=modificar&cat=<? echo $cat; ?>"  method="POST" id="form-nuevo">
        <div class="form-group" id="mensaje-form"></div> <!--Mensaje form -->

        <div class="form-group control-group">
          <label>Nombre contenedor:</label>
          <input class="form-control input-lg color-border-gris-a color-text-gris"  id="inputNombre" name="inputNombre" placeholder=" " value="<?php echo $fila_nombre; ?>" type="text" autofocus />
          <input id="inputId" name="inputId" type="hidden" value="<?php echo $fila_id; ?>" />
        </div>
        <div class="form-group form-descripcion">
          <label>Clase:</label>
          <input class="form-control" id="inputClase" name="inputClase" placeholder="" value="<?php echo $fila_clase; ?>"/>
        </div>
        <div class="form-group">
          <label>Css:</label>
          <input class="form-control" id="inputCss" name="inputCss" placeholder="" value="<?php echo $fila_css; ?>"/>
        </div>
        <div class="form-group">
          <label>Codigos:</label>
          <textarea class="form-control" id="inputCodigos" name="inputCodigos"><?php echo $fila_codigos; ?></textarea>
        </div>
        <div class="form-group">
          <label>Id Padre:</label>
          <input class="form-control" id="inputPadre" name="inputPadre" placeholder="" value="<?php echo $fila_id_padre; ?>"/>
        </div>
        <div class="form-group">
          <label>Id Orden:</label>
          <input class="form-control" id="inputOrden" name="inputOrden" placeholder="" value="<?php echo $fila_orden; ?>"/>
        </div>
        <div class="form-group form-botones">
           <button  type="button" class="btn btn-danger btn-eliminar color-bg-rojo-a" id_eliminar="<? echo $fila_id; ?>" nombre_eliminar="<? echo $fila_nombre; ?>" name="btn-accion" id="btn-eliminar" value="eliminar"><i class="icn-trash" ></i> Eliminar Contenedores</button>

           <button type="submit" class="btn btn-info  btn-actualizar hvr-fade btn-lg color-bg-celecte-c btn-lg" name="btn-accion" id="btn-activar" value="actualizar"><i class="icn-sync" ></i> Actualizar</button>
        </div>
      </form>
    </div>
    <?php
      $this->fmt->class_modulo->script_form("modulos/categorias/contenedores.adm.php",$this->id_mod);
  }

  function modificar(){
    $this->fmt->get->validar_get ( $_GET['cat'] );
    $modo = $_GET['modo'];
    $cat = $_GET['cat'];
    if ($modo=="busqueda"){ $tarea="busqueda" ;}
    if ($modo=="editar_contenidos"){ $tarea="editar_contenidos" ;}

		if ($_POST["btn-accion"]=="eliminar"){}
		if ($_POST["btn-accion"]=="actualizar"){

			$sql="UPDATE contenedor SET
						cont_nombre='".$_POST['inputNombre']."',
						cont_clase='".$_POST['inputClase']."',
						cont_css ='".$_POST['inputCss']."',
						cont_codigos='".$_POST['inputCodigos']."',
						cont_activar='".$_POST['inputActivar']."',
						cont_id_padre='".$_POST['inputPadre']."',
						cont_orden='".$_POST['inputOrden']."'
	          WHERE cont_id='".$_POST['inputId']."'";

			$this->fmt->query->consulta($sql);
		}
			header("location: contenedores.adm.php?tarea=".$tarea."&cat=".$cat);
	}

}
?>
