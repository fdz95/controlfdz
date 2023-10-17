<?php
	$day_format = null;
	$month_format = null;
	$getDay = null;
	$day = date('l');
	$month = date('m');
	
	switch($month){
		case "01":
			$month_format = "Enero";
			break;
		case "02":
			$month_format = "Febrero";
			break;
		case "03":
		$month_format = "Marzo";
			break;
		case "04":
			$month_format = "Abril";
			break;
		case "05":
			$month_format = "Mayo";
			break;
		case "06":
			$month_format = "Junio";
			break;
		case "07":
			$month_format = "Julio";
			break;
		case "08":
			$month_format = "Agosto";
			break;
		case "09":
			$month_format = "Septiembre";
			break;
		case "10":
			$month_format = "Octubre";
			break;
		case "11":
			$month_format = "Noviembre";
			break;
		case "12":
			$month_format = "Diciembre";
			break;
	}
	
	switch($day){
		case "Sunday":
			$day_format = "Domingo";
			break;
		case "Monday":
			$day_format = "Lunes";
			break;
		case "Tuesday":
			$day_format = "Martes";
			break;
		case "Wednesday":
			$day_format = "Mi&eacute;rcoles";
			break;
		case "Thursday":
			$day_format = "Jueves";
			break;
		case "Friday":
			$day_format = "Viernes";
			break;
		case "Saturday":
			$day_format = "S&aacute;bado";
			break;
		}
		
		$getDay = "<h3><b>".$day_format .", ". date('d') ." de ". $month_format ." de ". date('Y') ."</b></h3>";
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="index.php" class="nav-link">Inicio</a>
		</li>
	</ul>	
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<?php echo $getDay; ?>
		</li>
	</ul>
</nav>