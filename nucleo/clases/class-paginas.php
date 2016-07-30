<?PHP
header("Content-Type: text/html;charset=utf-8");

class CLASSPAGINAS{

	var $fmt;

  function __construct($fmt) {
    $this->fmt = $fmt;
  }

/* ---------------- Funcion Verificar ---------------------- */

	function verificar_session(){
		include_once("sesion.php");
		$sesion= new SESION();
		$sesion->iniciar_sesion();
		$mysite_username = $sesion->get_variable("mysite_username");
		if(!$sesion->existe_variable("mysite_username"))
		{
			echo "<script>";
			echo "window.location = '../registrarse.php'";
			echo "</script>";
		}
	}

/* ---------------- Funcion crear head ---------------------- */

	function crear_head( $id_mod,$botones){

		$sql ="SELECT mod_nombre,mod_icono FROM modulos WHERE mod_id=$id_mod";
		$rs = $this->fmt->query -> consulta($sql);
		$row = $this->fmt->query -> obt_fila ($rs);
		$nom = $row["mod_nombre"];
		$icon = $row["mod_icono"];
		?>
		<div class="head-modulo">
		<h1 class="title-page pull-left"><i class="<? echo $icon; ?>"></i> <? echo $nom; ?></h1>
			<a href='javascript:location.reload()'><i class='icn-sync'></i></a>
			<?php if (!empty($botones)){ ?>
			<div class="head-botones pull-right">
				<?php echo $botones; ?>
			</div>
			<?php } ?>
		</div>
		<?php
	}  // fin crear head
	function crear_head_mod( $icon, $nom,$botones,$botones_left,$class){
		?>
		<div class="head-modulo">

		<?php if (!empty($botones_left)){ ?>
		<div class="head-botones pull-left">
			<?php echo $botones_left; ?>
		</div>
		<?php } ?>

		<h1 class="title-page pull-left <? echo $class; ?>"><i class="<? echo $icon; ?>"></i> <? echo $nom; ?> <a class='small' href='javascript:location.reload()'><i class='icn-sync'></i></a></h1>


			<?php if (!empty($botones)){ ?>
			<div class="head-botones pull-right">
				<?php echo $botones; ?>
			</div>
			<?php } ?>
		</div>
		<?php
	}  // fin crear head

	/* ---------------- Funcion crear form ---------------------- */

		function crear_head_form( $nombre,$botones_left, $botones_right, $class_modo,$id_mod){
			$nom_mod="";
			if(!empty($id_mod))
			$nom_mod=  strtolower($this->fmt->class_modulo->mombre_modulo($id_mod));
			?>
			<div class="head-modulo row <?php echo $class_modo." head-".$nom_mod; ?> ">
			<div class="head-botones pull-left">
				 	<?php echo $botones_left; ?>
			</div>
			<h1 class="title-form col-xs-4 col-xs-offset-3"><? echo $nombre; ?> <a href='javascript:location.reload()'><i class='icn-sync'></i></a></h1>
			<? if ($botones_right!=""){ ?>
				<div class="head-botones pull-right">
						<?php echo $botones_right; ?>
				</div>
			<? } ?>
			</div>
			<?php
		}  // fin crear head

/* ---------------- Funcion btn nuevo ---------------------- */

	function crear_btn($Link,$Clase,$Icon,$Nom){
		$Botones ='<a href="'.$Link.'" class="'.$Clase.'">
			 <i class="'.$Icon.'"></i> '.$Nom.'
			 </a> ';
		return $Botones;
	} // fin btn nuevo

}
?>
