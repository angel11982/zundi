<?php
require_once("../clases/class-constructor.php");
$fmt = new CONSTRUCTOR();

$cat = $fmt->get->get_categoria_index();
$pla = $fmt->get->get_plantilla_index($fmt->query,$cat);

$fmt->get->validar_get($_POST['inputId']);
$id_mod= $_POST['inputId'];

$sql ="SELECT mod_url FROM modulos WHERE mod_id=$id_mod";
$rs = $fmt->query -> consulta($sql);
$row = $fmt->query -> obt_fila($rs);
$url_mod =  _RUTA_WEB.$row["mod_url"]."?id_mod=".$id_mod;
$url = _RUTA_HOST.$row["mod_url"];
if (file_exists($url)) {
  echo "<div class='container-fluid bloque-modulo'>";
  echo "<a class='btn-cerrar-pag'><i class='icn-close'></i></a>";
  echo "<iframe class='frame-mod' src='".$url_mod."'  name='frame_content' scrolling=auto ></iframe>";
  echo "</div>";
}else{
  $fmt->error->error_pag_no_encontrada();
}

?>
<script>
$(".btn-cerrar-pag").click(function () {
    $(".popup-div").removeClass("on");
    $(".cont_1").removeClass("oncontentpage");
    window.location.reload();
});
</script>
