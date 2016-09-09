<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
?>

<div class="nav-bar-m">
   <div class="brand">
     <a href="<?php echo _RUTA_WEB; ?>"><img src="<?php echo _RUTA_WEB; ?>sitios/beceratti/images/logo-beceratti.svg" ></a>
   </div>
   <div class="menu-toggle"><a ><i class="icn-reorder"></i></a></div>
   <div class="bg-bar"></div>
</div>

<script>
$(document).ready(function () {
  $('.box-m-menu a').click(function(e){
    e.preventDefault();
    $('html, body').stop().animate({scrollTop: $($(this).attr('href')).offset().top}, 1000);
  });
  var change= false;
  $(window).scroll(function(){
    window_y = $(window).scrollTop();
    scroll_critical = "20";
    scroll_menu ="340";
    s1 = parseInt($("#portada").height());
    if (window_y > scroll_critical){
      $(".nav-bar-m").addClass('on');
    }

    if (window_y < scroll_critical){
      $(".nav-bar-m").removeClass('on');
    }

    if (window_y > scroll_menu){
      $(".menu-toggle").addClass('on');
    }
    if (window_y < scroll_menu){
      $(".menu-toggle").removeClass('on');
    }

    if (window_y > 650){
      $(".lista-sillas").addClass('on');
    }

  });
  $('.menu-toggle').click(function(e){
    //alert('hola');
    $(".sidebar-m-d").toggleClass('on');
  });
});

</script>
