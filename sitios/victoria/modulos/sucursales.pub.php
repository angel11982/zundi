<?php
header("Content-Type: text/html;charset=utf-8");
require_once(_RUTA_HOST."nucleo/clases/class-constructor.php");
$fmt = new CONSTRUCTOR;
require_once("nav.pub.php");

function TraerLikes($id,$next,&$num_likes){
	$json1 = file_get_contents('https://graph.facebook.com/v1.0/'.$id.'/likes?pretty=1&limit=99&after='.$next);
	$likes=json_decode($json1,true);
	$num = count($likes["data"]);
	$num_likes=$num_likes+$num;
	if($num==99){
		TraerLikes($id,$likes["paging"]["cursors"]["after"],$num_likes);
	}
	else{
		return $num_likes;
	}
}
function NumRandom($num,$max){
	$valores = array();
	$x=0;
	while ($x<$num) {
	  $num_aleatorio = rand(1,$max);
	  if (!in_array($num_aleatorio,$valores)) {
	    array_push($valores,$num_aleatorio);
	    $x++;
	  }
	}
	return $valores;
}
function HaceTiempo($valor_fecha){
	$tiempo_actual     = time();
	$valor_hace_time = strtotime($valor_fecha);
	$tiempo_transcurrido     = $tiempo_actual - $valor_hace_time;
	$segundos     = $tiempo_transcurrido ;
	$minutos     = round($tiempo_transcurrido / 60 );
	$horas     = round($tiempo_transcurrido / 3600);
	$dias     = round($tiempo_transcurrido / 86400 );
	$semanas     = round($tiempo_transcurrido / 604800);
	$meses     = round($tiempo_transcurrido / 2600640 );
	$anios     = round($tiempo_transcurrido / 31207680 );

	// En Segundos (AHORA)
	if($segundos <= 60){
	    return "Ahora mismo";
	}
	//En Minutos
	else if($minutos <=60){
	    if($minutos==1){
	        return "Hace 1 Minuto";
	    }
	    else{
	        return "Hace $minutos minutos";
	    }
	}
	//En Horas
	else if($horas <=24){
	    if($horas==1){
	        return "Hace 1 hora";
	    }else{
	        return "Hace $horas horas";
	    }
	}
	//En Dias
	else if($dias <= 7){
	    if($dias==1){
	        return "Ayer";
	    }else{
	        return "Hace $dias d&iacute;as";
	    }
	}
	//En Semanas
	else if($semanas <= 4.3){
	    if($semanas==1){
	        return "Hace 1 Semana";
	    }else{
	        return "Hace $semanas semanas";
	    }
	}
	//En Meses
	else if($meses <=12){
	    if($meses==1){
	        return "Hace 1 Mes";
	    }else{
	        return "Hace $meses meses";
	    }
	}
	// En Años
	else{
	    if($anios==1){
	        return "Hace 1 a&ntilde;o";
	    }else{
	        return "Hace $anios a&ntilde;os";
	    }
	}
}


//$qr="victoria";

	//$json = file_get_contents('https://api.instagram.com/v1/users/244967564/media/recent/?access_token=244967564.66a583c.1632d35a8de6453fa64bc99fad241ad0');
	//$json = file_get_contents('https://api.instagram.com/v1/tags/'.$qr.'/media/recent?access_token=244967564.66a583c.1632d35a8de6453fa64bc99fad241ad0');
	$json = file_get_contents('https://api.instagram.com/v1/users/3064923528/media/recent/?access_token=1112840409.66a583c.396b33cd57974c3780383703f6d8910c');
	$instagram=json_decode($json,true);
$num = count($instagram["data"]);

for($i=0;$i<$num;$i++){
	$titulo=$instagram["data"][$i]["caption"]["text"];
	$feed[$i]["titulo"]=utf8_encode($titulo);
	$feed[$i]["link"]=$instagram["data"][$i]["link"];
	$feed[$i]["foto"]=$instagram["data"][$i]["images"]["standard_resolution"];
	$feed[$i]["fecha"]=date('Y-m-d', $instagram["data"][$i]["created_time"]);
	$feed[$i]["like"]=$instagram["data"][$i]["likes"]["count"];
	$feed[$i]["tipo"]="instagram";
}

$i=$num;
	//$json = file_get_contents('https://graph.facebook.com/443098365731875/photos');
	$json=file_get_contents('https://graph.facebook.com/501202473225871/photos?access_token=1438859033090174|d881f783811e02ce9521aea95e9a723f');
	$facebook=json_decode($json,true);
	$num_f = count($facebook["data"]);
//var_dump($facebook);
for($j=0;$j<$num_f;$j++){
	$dato=explode("T", $facebook["data"][$j]["created_time"]);
	$num_likes=count($facebook["data"][$j]["likes"]["data"]);
	/*if($num_likes=="25"){
		TraerLikes($facebook["data"][$j]["id"],$facebook["data"][$j]["likes"]["paging"]["cursors"]["after"],$num_likes);
	}*/
	$titulo=$facebook["data"][$j]["name"];
	$feed[$i]["titulo"]= utf8_encode($titulo);
	$feed[$i]["link"]=$facebook["data"][$j]["link"];
	$feed[$i]["foto"]=$facebook["data"][$j]["source"];
	$feed[$i]["fecha"]=$dato[0];
	$feed[$i]["like"]=$num_likes;
	$feed[$i]["tipo"]="facebook";
	$i++;
}
$n_f=count($feed);
$cant=floor($n_f/5);

$valor=NumRandom(($cant-1),($n_f-1));

foreach ($feed as $llave => $fila) {$fecha[$llave]  = $fila['fecha'];}array_multisort($fecha, SORT_DESC, $feed);

?>
<div class="box-body container-fluid box-catalogo">
	<div class="header-catalogo">
		<div class="box-title">
			<h1>Social</h1>
		</div>
		<i class="flecha-up fa fa-caret-up"></i>
		<div class="bg-shadow"></div>
	</div>

	<div class="container-fluid box-redes">

	<script type="text/javascript">
      $(document).ready(function($){
	$('#social-stream').isotope();
	$('#filters a').click(function(){
  var selector = $(this).attr('data-filter');
  $('#social-stream').isotope({ filter: selector });
  $('.filter').removeClass('active');
  switch (selector) {
                case ".facebook":
                $('.filterFacebook').addClass('active');
                break;
				case ".instagram":
                $('.filterInstagram').addClass('active');
                break;
                case ".twitter":
                $('.filterTwitter').addClass('active');
                break;
                case "*":
                $('.filterAll').addClass('active');
                break;
            }

  return false;
});

	var thePost = $('.postWrapper');
    var shareLinks = $('.shareIconsContainer');
	var hoverText = $('.viewPost');
    var clockText = $('.timestamp.clockText');
    var theClock = $('.clock');
        $('.itemImageContainer').hover(function () {
            $(this).parent().find(thePost).addClass('fadeOutDown');
            $(this).parent().find(thePost).removeClass('fadeInUp');
            $(this).parent().find(shareLinks).addClass('fadeInUp');
            $(this).parent().find(shareLinks).removeClass('fadeOutDown');
            $(this).parent().find(shareLinks).removeClass('visibilityNone');

        }, function () {
            $(this).parent().find(thePost).removeClass('fadeOutDown');
            $(this).parent().find(thePost).addClass('fadeInUp');
            $(this).parent().find(shareLinks).removeClass('fadeInUp');
            $(this).parent().find(shareLinks).addClass('fadeOutDown');
            $(this).parent().find(shareLinks).addClass('visibilityNone');
        });

});

    </script>

    <ul id="filters">
  <li><a href="#" class="filter" data-filter="*"><div class="filter filterAll active">
    </div></a></li>
  <li><a href="#" class="filter" data-filter=".facebook"><div class="filter filterFacebook">
    </div></a></li>
  <li><a href="#" class="filter" data-filter=".instagram"><div class="filter filterInstagram">
    </div></a></li>
<!--  <li><a href="#" class="filter" data-filter=".twitter"><div class="filter filterTwitter">
    </div></a></li>-->
</ul>
   <div id="social-stream">
   <?php
	   for($i=0;$i<$n_f;$i++){
	   if($feed[$i]["tipo"]=="instagram"){
		   $foto=$feed[$i]["foto"]["url"];
	   }
	   else{
		   $foto=$feed[$i]["foto"];
	   }
	  if (in_array($i,$valor)){
		   $cl="featured";
	   }
	   else{
		   $cl="regular";
	   }
	   $titulo=$feed[$i]["titulo"];
	   if($titulo==""){
		   $titulo="Cinnabon";
	   }
	    $urllink="https://instagram.com/cinnabonbolivia/";
	   if($feed[$i]["tipo"]=="facebook"){
		 $urllink="https://www.facebook.com/CinnabonBolivia?fref=ts";
	   }
   ?>
	  <div class="item <?php echo $feed[$i]["tipo"]." ".$cl; ?>">
		  <div class="preLoad"></div>
			<div class="itemImageContainer">

			    <!--social image-->

			    <div class="itemImage" style="background: url(<?php echo $foto; ?>) 50% 50%;"></div>

			    <!--post title, description & text-->

			    <div class="postWrapper animated fadeInUp">
			        <h1 class="postBiz">Cinnabon</h1>
			        <hr class="textBreak">
			        <h1 class="postTitle"><?php echo utf8_decode($titulo); ?></h1>
			        <p class="postDesc"></p>
			    </div>

			    <!--hover state, share icons, view post link, controlled in javascript-->

			    <div class="shareIconsContainer animated visibilityNone fadeOutDown" style="display: block;">
			        <div class="shareIcons animated text-centerNew">
			            <h1 class="viewPostText theShareText">Compartir</h1>
			            <a href="https://www.facebook.com/sharer/sharer.php?u=<? echo $feed[$i]["link"]; ?>" target="_blank"><div class="shareTransition share animated sFb" id="shareFb" data-related="360MOpro"  ></div></a>
			            <hr class="socialLine" width="1px">
			           <a target="_blank" href="https://twitter.com/intent/tweet?related=360MOpro&text=<?php echo utf8_decode($titulo); ?>%20<? echo $feed[$i]["link"]; ?>"> <div class="shareTransition share animated sTwitter" href="https://twitter.com/share" data-related="360MOpro" id="shareTwitter"></div></a>
			            <hr class="socialLine" width="1">
			           <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $feed[$i]["link"]; ?>&title=Quiero%20compartir%20con%20ustedes&summary=<?php echo utf8_decode($titulo); ?>&source="> <div class="shareTransition share animated sLinkedIn" id="shareLinkedIn"></div></a>
			            <div class="viewPost animated">
			                <a class="viewPostText" href="<?php echo $feed[$i]["link"]; ?>" target="_blank">Ver Mensaje</a>
			            </div>
			        </div>
			    </div>
			</div>


			<!--social bar at bottom, styling controlled by parent classes-->

			<div class="bar">

			    <!--timestamp, counts/icons for likes, pins, comments, etc-->

			    <div class="barTextContainer">
			        <div class="action">
			            <div class="actionIcon"></div>
			            <p class="actionCount"><?php echo $feed[$i]["like"]; ?></p>
			        </div>
			        <img class="timestamp clock" src="assets/img/clock.png">
			        <p class="timestamp clockText"><?php echo HaceTiempo($feed[$i]["fecha"]); ?></p>
			        <a class="viewPostMobile timestamp" href="<?php echo $feed[$i]["link"]; ?>" target="_blank">View Post</a>
			    </div>

			    <!--social network icon, controlled by parent classes-->

			    <a href="<?php echo $urllink; ?>" target="_blank"><div class="theNetwork"></div></a>
			</div>
	  </div>
	  <?php
		  }
	  ?>
   </div>
<style>
.item.regular {
  width: 220px;
  height: 355px;
  border: 1px solid #d3d3d3;
}
.item.featured {
  width: 440px;
  height: 710px;
  border: 2px solid #d3d3d3;
}
.item {
  float: left;
  position: relative;
  background: white;
  overflow: hidden;
  background-color: black;
}
.preLoad {
  background-image: url(images/linkedinShareHover.png),url(images/linkedinShareHoverSmall.png),url(images/facebookShareHover.png),url(images/facebookShareHoverSmall.png),url(images/twitterShareHover.png),url(images/twitterShareHoverSmall.png);
  width: 1px;
  height: 1px;
  display: none;
}
.itemImageContainer {
  z-index: 10;
  width: 100%;
  height: 100%;
  transition: 1s;
  -webkit-backface-visibility: hidden;
  -webkit-transform: translateZ(0) scale(1.0,1.0);
}
.bar {
  width: 100%;
  position: absolute;
  height: 40px;
  bottom: 0;
}
.item.facebook .bar {
  background: #3b5998;
}
.item.twitter .bar {
  background: #22AAE2;
}
.regular .itemImage {
  height: 220px;
}
.itemImageContainer:hover .itemImage {
  -webkit-filter: blur(10px);
  -moz-filter: blur(10px);
  -o-filter: blur(10px);
  -ms-filter: blur(10px);
  filter: blur(10px);
  transition: .5s;
  opacity: .6;
  filter: "alpha(opacity=60)";
  -ms-filter: "alpha(opacity=60)";
  -webkit-backface-visibility: hidden;
  -webkit-transform: translateZ(0) scale(1.0,1.0);
}

.itemImage {
 height: 100%;
  z-index: 11;
  transition: .3s;
  background-size: cover!important;
  filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale')";
  -webkit-backface-visibility: hidden;
  -webkit-transform: translateZ(0) scale(1.0,1.0);
}
.itemImage {
  height: 100%!important;
  background-repeat: no-repeat;
}
.regular .postWrapper {
  height: 80px;
}
.postWrapper {
  position: absolute;
  bottom: 40px;
  left: 0;
  right: 0;
  margin: auto;
  background: rgba(0,0,0,.6);
  padding: 15px;
}
.fadeInUp {
  -webkit-animation-duration: .5s;
  animation-duration: .5s;
}
.fadeInUp {
  -webkit-animation-name: fadeInUp;
  animation-name: fadeInUp;
  -webkit-animation-duration: .7s;
  animation-duration: .7s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
  visibility: visible !important;

}
.animated {
  -webkit-animation-duration: .7s;
  animation-duration: .7s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}
.fadeOutDown {
height: 0px !important;
  padding: 0px !important;
  -webkit-animation-name: fadeOutDown;
  animation-name: fadeOutDown;
}
.fadeOutDown {
  -webkit-animation-duration: .5s;
  animation-duration: .5s;
}
.shareIconsContainer {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  height: 100px;
  color: white;
  -webkit-backface-visibility: hidden;
  -webkit-transform: translateZ(0);
}

.visibilityNone {
  opacity: 0;
}

.item .postBiz {
  display: none;
}
.postWrapper .postBiz, .postWrapper .postTitle, .postWrapper .postDesc, .viewPostText, .timestamp {
  font-weight: 100!important;
  font-family: proxima-nova-1,Helvetica!important;
  color: white!important;
  padding: 0!important;
}
.gridWideContainer h1, .gridWideContainer h1 a[href^=tel] {
  font-family: museo-1;
  font-size: 43px;
  text-transform: lowercase;
  line-height: 31px;
  color: #ffffff;
  font-weight: 100;
}
.postBiz {
  margin: 0!important;
  text-align: left!important;
  text-transform: none!important;
  text-shadow: none!important;
}
.item .textBreak {
  display: none;
}
.regular .postTitle {
  transition: .3s!important;
  font-size: 12px!important;
  line-height: 16px!important;
  height: 80px!important;
  overflow: hidden!important;
  margin: -2px 0 0 0!important;
}
.regular .postTitle {
  font-size: 16px!important;
  line-height: 20px!important;
  letter-spacing: 1px!important;
  text-align: left!important;
  text-transform: none!important;
  text-shadow: none!important;
}
.regular .postDesc {
  font-size: 10px!important;
  display: none;
}
.item .postDesc {
  display: none;
}
.shareIcons {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}
.text-centerNew {
  text-align: center;
  width: 100%;
}
.regular .viewPostText {
  font-size: 11px!important;
  text-align: center!important;
}
.regular .theShareText {
  position: absolute;
  left: 0;
  right: 0;
  top: -10px;
}
.regular .sFb {
  background: url('images/facebookShareSmall.png');
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/facebookShareSmall.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/facebookShareSmall.png',sizingMethod='scale')";
}
.regular .sFb:hover {
  background: url('images/facebookShareHoverSmall.png');
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/facebookShareHoverSmall.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/facebookShareHoverSmall.png',sizingMethod='scale')";
}
.regular .share {
  width: 25px;
  height: 25px;
}
.featured .viewPostText {
  font-size: 14px!important;
  text-align: center!important;
}
.viewPostText {
  line-height: 20px!important;
  text-transform: uppercase!important;
  text-shadow: none!important;
  margin: 0!important;
  transition: .3s;
}
.featured .sFb {
  background: url('images/facebookShare.png');
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/facebookShare.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/facebookShare.png',sizingMethod='scale')";
}
.featured .sFb:hover {
  background: url(images/facebookShareHover.png);
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/facebookShareHover.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/facebookShareHover.png',sizingMethod='scale')";
}
.featured .share {
  width: 50px;
  height: 50px;
}
.featured .socialLine {
  color: white;
  display: inline-block;
  margin: 15px 0 0 -5px;
  height: 50px;
  width: 5px;
  background: white;
}
.featured .sTwitter {
  background: url('images/twitterShare.png');
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/twitterShare.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/twitterShare.png',sizingMethod='scale')";
}
.featured .sLinkedIn:hover {
  background: url(images/linkedinShareHover.png);
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/linkedinShareHover.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/linkedinShareHover.png',sizingMethod='scale')";
}
.featured .sLinkedIn {
  background: url(images/linkedinShare.png);
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/linkedinShare.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/linkedinShare.png',sizingMethod='scale')";
}
.featured .sTwitter:hover {
  background: url(images/twitterShareHover.png);
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/linkedinShareHover.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/linkedinShareHover.png',sizingMethod='scale')";
}
.featured .viewPost {
  bottom: 0;
  position: absolute;
  top: 300px;
  left: 0;
  right: 0;
}
hr {
  display: block;
  -webkit-margin-before: 0.5em;
  -webkit-margin-after: 0.5em;
  -webkit-margin-start: auto;
  -webkit-margin-end: auto;
  border-style: inset;
  border-width: 1px;
}
.shareIcons .share {
  text-align: center;
  display: inline-block;
  cursor: pointer;
  float: none!important;
  padding: 0!important;
}
.shareTransition {
  -webkit-transition: .3s;
  -moz-transition: .3s;
  transition: .3s;
}
.regular .socialLine {
  color: white;
  display: inline-block;
  margin: 15px 0 0 -5px;
  height: 25px;
 width: 3px;
  background: white;
}
.regular .sTwitter {
  background: url('images/twitterShareSmall.png');
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/twitterShareSmall.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/twitterShareSmall.png',sizingMethod='scale')";
}
.regular .sLinkedIn {
  background: url(images/linkedinShareSmall.png);
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/linkedinShareSmall.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/linkedinShareSmall.png',sizingMethod='scale')";
}
.regular .sTwitter:hover {
  background: url('images/twitterShareHoverSmall.png');
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/twitterShareHoverSmall.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/twitterShareHoverSmall.png',sizingMethod='scale')";
}
.regular .sLinkedIn:hover {
  background: url(images/linkedinShareHoverSmall.png);
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/linkedinShareHoverSmall.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/linkedinShareHoverSmall.png',sizingMethod='scale')";
}
.regular .viewPost {
  bottom: 0;
  position: absolute;
  top: 150px;
  left: 0;
  right: 0;
}
.viewPost {
  display: block;
  width: auto;
  cursor: pointer;
  text-align: center;
  line-height: 40px;
  font-size: 12px;
  color: white;
  height: 40px;
  -webkit-transition: 300ms linear 0s;
  -moz-transition: 300ms linear 0s;
  -o-transition: 300ms linear 0s;
  transition: 300ms linear 0s;
}
.barTextContainer {
  position: absolute;
  bottom: 0;
  right: 0;
  left: 0;
  text-align: center;
  width: 100%;
  height: 40px;
  padding: 5px auto auto auto;
}
.action {
  position: absolute;
  bottom: 0;
  right: 0;
  left: 0;
  text-align: center;
  width: 100%;
  height: 40px;
  padding: 5px auto auto auto;
}
.clock {
  height: 40px;
  margin-left: -15px;
  display: none;
}
.timestamp {
  position: relative;
  text-align: center;
  margin: 0;
  vertical-align: middle;
  transition: 1s;
}
.timestamp {
  text-align: center!important;
}
.clock {
  display: none!important;
}
.facebook .actionIcon, .youtube .actionIcon {
  background-image: url('images/like.png');
}
.actionIcon {
  width: 40px;
  height: 40px;
  background-size: cover;
  position: relative;
  text-align: center;
  display: inline-block;
  font-size: 10px;
  color: white;
  line-height: 40px;
  margin: 0;
  display: inline-block;
  vertical-align: middle;
  float: left;
}
.actionCount {
  position: relative;
  display: inline-block;
  font-size: 10px;
  color: white;
  line-height: 40px;
  margin: 0;
  display: inline-block;
  vertical-align: middle;
  float: left;
  text-align: left;
}
.actionCount {
  text-align: left!important;
  float: left!important;
}
.timestamp, .actionCount {
  display: inline-block;
  font-size: 10px!important;
  color: white!important;
  line-height: 40px!important;
  text-decoration: none!important;
  font-style: normal!important;
  font-weight: 100!important;
  text-transform: none!important;
  padding: inherit!important;
  margin: inherit!important;
  font-family: proxima-nova-1,Helvetica!important;
  text-shadow: none!important;
}
.clockText {
  margin-left: -5px;
}
.viewPostMobile {
  display: block;
  width: 100%;
  cursor: pointer;
  text-align: center;
  line-height: 40px;
  font-size: 10px;
  color: white;
  height: 40px;
  margin: 0;
}
.item.facebook .theNetwork {
  background: url(images/facebookLogoIcon1.png);
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/facebookLogoIcon1.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/facebookLogoIcon1.png',sizingMethod='scale')";
}
.item.twitter .theNetwork {
  background: url(images/twitterLogoIcon.png);
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/twitterLogoIcon.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/twitterLogoIcon.png',sizingMethod='scale')";
}
.theNetwork {
  position: absolute;
  bottom: 5px;
  right: 5px;
  width: 30px;
  height: 30px;
  cursor: pointer;
}
.item.instagram .bar {
  background: #517fa4;
}
.instagram .actionIcon {
  background-image: url('images/heart.png');
}
.item.instagram .theNetwork {
  background: url('images/instagramLogoIcon.png');
  background-size: cover;
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/instagramLogoIcon.png',sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/instagramLogoIcon.png',sizingMethod='scale')";
}
/****** filtros ******/

.filter {
  width: 41px;
  height: 41px;
  cursor: pointer;
  display: inline-block;
}
#filters {
  position: relative;
  display: block;
  height: 41px;
  width: 123px;
  text-align: center;
  margin: 0 auto;
  padding-bottom: 30px;
  list-style: none;
}
li {
  float: left;
  position: relative;
}
.filterAll, .filterAll:hover, .filterAll.active, .filterFacebook, .filterFacebook:hover, .filterFacebook.active, .filterTwitter, .filterTwitter:hover, .filterTwitter.active, .filterInstagram, .filterInstagram:hover, .filterInstagram.active {
  background: url(images/socialSprite.png) no-repeat;
  display: inline-block;
  cursor: pointer;
}
.filterAll {
  background-position: -5px -5px;
  width: 41px;
  height: 41px;
}
.filterAll:hover, .filterAll.active {
  background-position: -55px -5px;
  width: 41px;
  height: 41px;
}
.filterFacebook {
  background-position: -105px -5px;
  width: 41px;
  height: 41px;
}
.filterFacebook:hover, .filterFacebook.active {
  background-position: -5px -55px;
  width: 41px;
  height: 41px;
}
.filterTwitter {
  background-position: -155px -55px;
  width: 41px;
  height: 41px;
}
.filterTwitter:hover, .filterTwitter.active {
  background-position: -155px -105px;
  width: 41px;
  height: 41px;
}
.filterInstagram{
  background-position: -5px -105px;
  width: 41px;
  height: 41px;
}
.filterInstagram:hover, .filterInstagram.active {
  background-position: -55px -105px;
  width: 41px;
  height: 41px;
}
.isotope,
.isotope .isotope-item {
  /* change duration value to whatever you like */
  -webkit-transition-duration: 0.8s;
     -moz-transition-duration: 0.8s;
      -ms-transition-duration: 0.8s;
       -o-transition-duration: 0.8s;
          transition-duration: 0.8s;
}

.isotope {
  -webkit-transition-property: height, width;
     -moz-transition-property: height, width;
      -ms-transition-property: height, width;
       -o-transition-property: height, width;
          transition-property: height, width;
}

.isotope .isotope-item {
  -webkit-transition-property: -webkit-transform, opacity;
     -moz-transition-property:    -moz-transform, opacity;
      -ms-transition-property:     -ms-transform, opacity;
       -o-transition-property:      -o-transform, opacity;
          transition-property:         transform, opacity;
}

/**** disabling Isotope CSS3 transitions ****/

.isotope.no-transition,
.isotope.no-transition .isotope-item,
.isotope .isotope-item.no-transition {
  -webkit-transition-duration: 0s;
     -moz-transition-duration: 0s;
      -ms-transition-duration: 0s;
       -o-transition-duration: 0s;
          transition-duration: 0s;
}
</style>

	</div>
</div>