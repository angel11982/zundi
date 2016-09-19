<?php
require_once("../clases/class-constructor.php");
$fmt = new CONSTRUCTOR();
if(isset($_POST["action"])){
	$accion=$_POST["action"];
	if($accion=="contenedor"){
		$pla=$_POST["pla"];
		$cat=$_POST["cat"];
		if (!empty($pla)){
			$sql="SELECT contenedor_cont_id FROM contenedor_plantilla WHERE plantilla_pla_id=$pla order by contenedor_cont_id asc";
				$rs=$fmt->query->consulta($sql);
				while($filax=$fmt->query->obt_fila($rs)){
					$conte = $filax["contenedor_cont_id"];
					traercontenedor($cat,$pla,$conte, $fmt);
				}
			?>
			<script>
			$(function(){
				$('ul.pub-cont').sortable({
				    items : ':not(.ui-state-disabled)'
				});
			    $( "ul.pub-all, ul.pub-cont" ).sortable({
			      connectWith: ".connectedSortable"
			    }).disableSelection();

			    $(".fa-eye").click(function(){
				   var at = $(this).attr("act");
				   var pub = $(this).attr("pub");

				   var act;
				   if(at=="1"){
					   act = 0;
					   $(this).addClass("fa-inverse");
				   }
				   else{
					   act = 1;
					   $(this).removeClass("fa-inverse");
				   }
				   $("#pub-"+pub).attr("act", act);
				   $(this).attr("act", act);
			    });
			    $(".fa-trash").click(function(){
				    var r = confirm("Esta seguro quitar esta publicación.?");
					if (r == true) {
						var pub = $(this).attr("pub");
						$("#pub-"+pub).remove();
					}
			    });
			  });
			  </script>
			<?php
		}

	}

	if($accion=="actualizar"){
		$pla=$_POST["pla"];
		$cat=$_POST["cat"];
		$cont=$_POST["cont"];

		$sql="DELETE FROM publicacion_rel WHERE pubrel_cat_id='$cat' and pubrel_pla_id='$pla'";
	    $fmt->query->consulta($sql);
	    $up_sqr6 = "ALTER TABLE publicacion_rel AUTO_INCREMENT=1";
	    $fmt->query->consulta($up_sqr6);

		$num = count($cont);
		for($i=0;$i<$num;$i++){
			$con = $cont[$i];
			$pubs=$_POST["pub".$con];
			$acts=$_POST["act".$con];
			$num_p = count($pubs);
			for($j=0;$j<$num_p;$j++){
				$pub=$pubs[$j];
				$act=$acts[$j];
				$sql="insert into publicacion_rel (pubrel_cat_id, pubrel_pla_id, pubrel_cont_id, pubrel_pub_id, pubrel_activar, pubrel_orden) values ('$cat','$pla','$con','$pub','$act','$j')";
				$rs=$fmt->query->consulta($sql);
			}
		}
	}
}

function traercontenedor($cat,$pla,$cont,$fmt){
	$sql="SELECT cont_nombre FROM contenedor WHERE cont_id=$cont";
	$rs=$fmt->query->consulta($sql);
	while($filax=$fmt->query->obt_fila($rs)){
		$nombre = $filax["cont_nombre"];

		echo '<ul id="cont-'.$cont.'" cont="'.$cont.'" class="pub-cont connectedSortable" >';
		echo '<h3 class="ui-state-disabled">'.$nombre.'</h3>';
		traerpublicaciones($cat,$pla,$cont,$fmt);
		traerhijoscontenedor($cat,$pla,$cont,$fmt);
		echo "</ul>";
	}
}
function traerhijoscontenedor($cat,$pla,$cont,$fmt){
	$sql="SELECT cont_id FROM contenedor WHERE cont_id_padre=$cont order by cont_orden asc";
	$rs=$fmt->query->consulta($sql);
	while($filax=$fmt->query->obt_fila($rs)){
		$cont=$filax["cont_id"];
		traercontenedor($cat,$pla,$cont,$fmt);
	}
}
function traerpublicaciones($cat,$pla,$cont,$fmt){
	$sql="SELECT pubrel_pub_id, pubrel_activar, pub_nombre, pub_imagen FROM publicacion_rel, publicacion WHERE pubrel_pub_id=pub_id and pubrel_cat_id=$cat and pubrel_pla_id=$pla and pubrel_cont_id=$cont order by pubrel_orden asc";

	$rs=$fmt->query->consulta($sql);
	while($filax=$fmt->query->obt_fila($rs)){
		$nombre = $filax["pub_nombre"];
		$act = $filax["pubrel_activar"];
		$imagen = $filax["pub_imagen"];
		$pub = $filax["pubrel_pub_id"];
		$cls="";
		if($act=="0")
			$cls="fa-inverse";
		if(empty($imagen)){
			$im = _RUTA_WEB."images/pub.png";
		}
		else{
			$im = _RUTA_WEB.$imagen;
		}
		echo "<li id='pub-".$pub."' pub='".$pub."' act='".$act."' class='ui-state'><i class='ui-state-disabled icn-move'></i><img src='".$im."' class='ui-state-disabled' >".$nombre;
		echo '<a href="'. _RUTA_WEB.'modulos/config/publicaciones.adm.php?tarea=form_editar&id='.$pub.'&id_mod=" target="_blank" class="ui-state-disabled" ><i pub="'.$pub.'" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
		echo '<i pub="'.$pub.'" act="'.$act.'" class="ui-state-disabled fa fa-eye '.$cls.'" aria-hidden="true"></i>';
		echo '<i pub="'.$pub.'" class="ui-state-disabled fa fa-trash" aria-hidden="true"></i>';
		echo "</li>";
	}
}
?>

