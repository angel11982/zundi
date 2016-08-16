<html id="pagina-modulo" lang="ES">
<head>
	<title> Landicorp</title>
    <link rel="stylesheet" href="http://52.36.176.142/mainter/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://52.36.176.142/mainter/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://52.36.176.142/mainter/css/bootstrap-datetimepicker.min.css">       <script type="text/javascript" language="javascript" src="http://52.36.176.142/mainter/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="http://52.36.176.142/mainter/js/bootstrap.js"></script>
</head>
<body>
<div class="form-group">
	<div class="input-group date " id="">
		<input type="text" class="form-control add-on dp" id="inputIngresoEmpresaActual" name="inputIngresoEmpresaActual" value="">
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	</div>
</div>
				<script>
				$(function () {
							$('.dp').datetimepicker({
								format: 'DD/MM/YYYY',
								locale: 'es'
							});
							$(".dp").on("dp.change", function (e) {
								var fecha_in=$("#inputIngresoEmpresaActual").val();
								var fecha_hoy="<?php echo date("Y-m-d");?>";
								var dia = 86400000;
								var anho = dia * (365);
								fecha_in = CambiarFormatFecha(fecha_in);
								var diferencia =  Math.floor(( Date.parse(fecha_hoy) - Date.parse(fecha_in) ) / anho);
								if(diferencia < 0){
								diferencia = diferencia*(-1);
								}
								alert(diferencia);
							});
				});
				function CambiarFormatFecha(fecha){
					var dato = fecha.split("/");
					return dato[2]+"-"+dato[1]+"-"+dato[0];
				}


				</script>


        <script type="text/javascript" language="javascript" src="http://52.36.176.142/mainter/js/moment.js"></script>
       <script src="http://52.36.176.142/mainter/js/bootstrap-datetimepicker.js"></script>
	   <script type="text/javascript" language="javascript" src="http://52.36.176.142/mainter/js/bootstrap-datepicker.es.js" charset="UTF-8"></script>
</body>
</html>
