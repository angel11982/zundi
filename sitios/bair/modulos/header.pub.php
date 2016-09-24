<div class="header">
	<div class="signin_wrap">
		<div class="container">
		    	<div class="left">
		      	<span class="phno"><i class="fa fa-phone"></i>(+591 3) 3419916 / 3118768 / 773-77111</span> <span><i class="fa fa-envelope"></i><a href="mailto:info@b-air.com">
		info@b-air.com</a></span>			<a href="https://www.facebook.com/B-Air-969978906359923" target="_blank"><img src="http://b-air.com/wp-content/themes/skt-yogi-pro/images/facebook-logo.png" width="24" height="24" alt=""></a>
		</div>
		 <div class="right"> <span>DISEÑADO Y FABRICADO EN CALIFORNIA </span> <span>HORARIOS: L-V 8AM to 6PM</span>
			<form role="search" method="get" class="searchbox" action="http://b-air.com/">
				<input type="search" class="searchbox-input" placeholder="Search..." value="" name="s" onkeyup="buttonUp();">
				<input type="submit" class="" value="">
				<span class="searchbox-icon"></span>
			</form>
		 <div class="clear"></div></div>
		 <div class="clear"></div>
	  </div>
	</div><!--end signin_wrap-->
	<div class="header-inner">
		<div class="container">
			<div class="logo">
				<a href="http://b-air.com.bo/">
					<img class="img-responsive" src="http://b-air.com/wp-content/uploads/2016/03/Logo-bair3.png">
				</a>
			 </div><!-- logo -->
				<div class="menu-top collapse navbar-collapse" id="bs-navbar-collapse">
				 <ul class="nav navbar-nav">
						 <? echo $fmt->nav->traer_cat_hijos_menu("0","0","2"); ?>
				 </ul>
				</div>
		</div>
	</div>
</div>

<script>
	$(".searchbox-icon").click(function(){
		$(".searchbox").toggleClass('on');
	});
</script>
