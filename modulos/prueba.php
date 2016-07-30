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

		                <div id="datetimepicker2" class="col-sm-7 input-group input-append date" data-date="28/07/2016"  data-date-format="dd/mm/yyyy">
		                      <input type="text" class="form-control add-on" id="inputFechaFin" name="inputFechaFin" value="28/07/2016"/>
		                      <span class="input-group-addon add-on"><i class="fa fa-calendar"></i></span>
		                </div>
		              </div>
				<script>
						$(document).ready(function(){
              $('#datetimepicker2').datetimepicker({
                  isRTL: false,
                  language: 'es'
              }).on("changeDate", function(e){
                $(this).datetimepicker('hide');
              });
						});
				</script>

        <script src="http://52.36.176.142/mainter/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" language="javascript" src="http://52.36.176.142/mainter/js/moment.js"></script>
        <script type="text/javascript" language="javascript" src="http://52.36.176.142/mainter/js/bootstrap-datepicker.es.js"></script>
</body>
</html>
