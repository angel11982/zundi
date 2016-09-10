<?
	$u = _RUTA_WEB_temp.substr($_SERVER["REDIRECT_URL"],1);
	$rut = urlencode($u);
?>
<div class="box-ci">
  <div class="box-compartir no-print">
    <label>Compartir</label>
    <i class="fa fa-share-alt"></i>
  </div>
  <div class="compartir no-print" style="display:none;">
    <i class="fa fa-caret-down indicador-abajo"></i>
    
    <a class="item" href="<?php echo _RUTA_WEB."enviar-mainter/prod=$id&ruta=".str_replace("/","+",substr($_SERVER["REDIRECT_URL"],1)); ?>" target="_blank"><i class="fa fa-envelope"></i></a>
    
    <a class="item" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<? echo $rut;?>&amp;src=sdkpreparse"><i class="fa fa-facebook"></i></a>
    
    <a class="item" target="_blank" href="http://www.linkedin.com/shareArticle?url=<?php echo $u; ?>"><i class="fa fa-linkedin"></i>  
    </a>
    
    <a class="item btn-whatsapp" target="_blank" href="whatsapp://send?text=<?php echo $u; ?>" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i></a>

  </div>

  <a  class="box-imprimir no-print" id="btn_print">
    <label>Imprimir</label>
    <i class="fa fa-print"></i>
  </a>
</div>

<script>
	
  $(function(){
    $('.box-compartir').click(function(){
      $('.compartir').toggle();
      $('.box-compartir').toggleClass('on');
    });

    $("#btn_print").click(function() {
      //Print ele2 with default options
      $.print("#body-page-m");
    });
    
  });
</script>
