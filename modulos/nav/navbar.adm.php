<?
  header('Content-Type: text/html; charset=utf-8');
  define(_EDITANDO,"true");

  $id_usu = $this->fmt->sesion->get_variable("usu_id");
  $id_rol = $this->fmt->sesion->get_variable("usu_rol");


  $usu_nombre    = $this->fmt->usuario->nombre_usuario($id_usu);
  $usu_apellidos = $this->fmt->usuario->apellidos_usuario($id_usu);
  $usu_imagen    = _RUTA_WEB.$this->fmt->usuario->imagen_usuario($id_usu);
  $rol_nombre    = $this->fmt->usuario->nombre_rol($id_rol);

  $menu_config .= $this->fmt->nav->construir_sistemas_rol( $id_rol, $id_usu);

  if (($id_rol==1)||($id_rol==2)){

    $ref_inicio= _RUTA_WEB;

    $menu_config .= $this->fmt->nav->construir_title_menu("Administración");

    $menu_config .= $this->fmt->nav->construir_sistemas_esenciales("",$id_rol, $id_usu);

    // $menu_config .= $this->fmt->nav->construir_btn_sidebar("btn-menu-sidebar btn-usuarios btn-menu-ajax","5");
    // $menu_config .= $this->fmt->nav->construir_btn_sidebar("btn-menu-sidebar btn-config btn-menu-ajax","4"); // class a, id modulo
    // $menu_config .= $this->fmt->nav->construir_btn_sidebar("btn-menu-sidebar btn-atajos-config btn-menu-ajax","3");
    // $menu_config .= $this->fmt->nav->construir_btn_sidebar("btn-menu-sidebar btn-modulos btn-menu-ajax","2");
    // $menu_config .= $this->fmt->nav->construir_btn_sidebar("btn-menu-sidebar btn-sistemas btn-menu-ajax","1");


    // $menu_config .= cargar_sistemas( $id_rol, $id_mod);

  }

?>
<!-- inicio navbar  -->
  <style>
    #page-content-wrapper{ margin-top: 43px; position:relative; }
    .nav-bar-m, .side-bar-m, .boby-page-m{
      margin-top: 43px;
    }
  </style>
  <div  class="navbar navbar-default navbar-fixed-top color-bg-blanco menu-adm" role="navigation">
    <div class="navbar-inner"> <!-- incicio navbar-inner -->
      <div class="dropdown_container">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo $ref_inicio; ?>" >
  					<?php echo  $this->fmt->brand->brand_login($cat,"navbar-logo"); ?>
  				</a>
        </div><!-- fin header -->
        <div class="collapse navbar-collapse" id="bs-menu">
          <ul class="nav navbar-nav navbar-right">
            <li class="">
              <a class="btn-navbar btn-search" href="#" ><i class="icn-search"></i></a>
            </li>
            <li class="">
              <a class="btn-navbar btn-alarma" href="#" ><i class="icn-alarm"></i></a>
            </li>
            <li class="">
              <a class="btn-navbar btn-mensajes" href="#" ><i class="icn-bubble"></i></a>
            </li>

            <li class="dropdown" id="Atajos">
              <a href="#" class="dropdown-toggle btn-navbar btn-atajos" data-toggle="dropdown" data-hover="dropdown" data-delay="10" data-close-others="false">
                  <i class="icn-shortcut"></i>
                  <i class="icn-chevron-donw btn-donw"></i>
                </a>
                <ul class="dropdown-menu menu-user">
                  <?php echo $menu_atajos; ?>
                </ul>
            </li>

            <li class="dropdown" id="Perfil">
              <a href="#" class="dropdown-toggle btn-navbar btn-user" data-toggle="dropdown" data-hover="dropdown" data-delay="10" data-close-others="false">
                  <i class="icn-user"></i>
                  <i class="icn-chevron-donw btn-donw"></i>
                </a>
                <ul class="dropdown-menu menu-user">
                  <li class="dropdown" id="Perfil">
                    <img class="img-user"alt="" src="<? echo $usu_imagen; ?>">
                    <h6 class="name-user"><? echo $usu_nombre." ".$usu_apellidos; ?>
                    <a href="#" target="_blank" class="btn btn-xs btn-default btn-perfil">Editar perfil</a></h6>
                  </li>
                  <li class="dropdown">
                    <a  class="btn-submenu btn-rol" href="" >
                    <i class="icn-credential"></i> <?php echo $rol_nombre ;?>
                    </a>
                  </li>
                  <li>
                    <a  class="btn-submenu btn-salir" href="<? echo _RUTA_WEB; ?>nucleo/includes/login.php?tarea=salir&cat=<?php echo $cat;?>&pla=<?php echo $pla;?>" >
                    <i class="icn-off"></i> Cerrar Sesión
                    </a>
                  </li>
                </ul>
            </li>

        <li>
          <a id="btn-navicon" class="btn-navbar btn-menu" >
            <i class="icn-reorder"></i>
            <i class="icn-close"></i>
          </a>
        </li>
        </ul>
        </div><!--    navbar-collapse -->
      </div>
    </div> <!-- fin navbar-inner -->
  </div><!-- fin navba -->
  <?php
    echo "\n\n";
  ?>

  <!--     Publicacion  Sidebar      -->
  <div class="sidebar" style="right: -250px;" >
  	<ul class="sidebar-inner">
      <div class="title-menu title-menu-general"> Menu General</div>
      <li>
        <a class="btn-menu-sidebar btn-menu-sidebar-active" href="<? echo $ref_inicio; ?>"><i class="icn-home"></i> Inicio </a>
      </li>
      <?php echo $menu_config; ?>
  	</ul>
  </div>

  <!--     SCRIPT     -->
  <script>
  $( "#btn-navicon" ).click(function() {
  	sidebar_on_off();
  });
   function sidebar_on_off(){
  $(".sidebar").toggleClass("on");
   	$(".btn-menu .icon-close").toggleClass("on");
   	$(".btn-menu .icon-recorder").toggleClass("on");
   	$("#btn-navicon").toggleClass("on");
   	$(".sidebar").animate({
   					right: parseInt($(".sidebar").css("right"))== 0 ?"-="+$(".sidebar").outerWidth() : 0
   			},300);
   }
  $(document).ready(function()
  {
      $(".btn-menu-ajax").click(function () {
        $(".cont_1").addClass("oncontentpage");
        var id = this.id;
        var id_mod = $( this ).attr("id_mod");

        $(".popup-div").addClass("on");
        //alert("Bien!!!, la edad seleccionada es: "+ id_mod );
        //alert("Bien!!!, la edad seleccionada es: " + $(this).val());
        $.ajax({
    			url:"<?php echo _RUTA_WEB; ?>nucleo/ajax/ajax-adm.php",
    			type:"post",
    			data:{ inputId:id_mod },
    			success: function(msg){
            //alert(msg);
            $("#popup-div").html(msg);
    			}
    		});
        sidebar_on_off();
      });
  });

  </script>

<!-- fin navbar  -->
