<?php
	require_once ("conexion.php");
	require_once ("../funciones.php");
	$ingreso_total = 0;
	$ganancia_total = 0;
	$getGananciaTrabajo = 0;
	$fecha_hoy = date('Y-m');
	$anio_actual = date('Y');
	
	
	echo "
		<div class='card-body'>
			<table  class='table table-bordered table-hover'>
				<thead>
					<tr>
						<th class='text-center'>Fecha</th>
						<th class='text-center'>Cantidad</th>
						<th class='text-center'>Total cobrado</th>
						<th class='text-center'>Total ganancia</th>
						<!--<th class='text-center'>Opciones</th>-->
				</tr>
				</thead>
				<tbody>";
						
	for($i = 1; $i <= 12; $i++){
		if($i <= 9){
			$i = "0". $i;
		}
				
		switch($i){
			case "01":
				$fecha_mes_nombre = "Enero";
				break;
			case "02":
				$fecha_mes_nombre = "Febrero";
				break;
			case "03":
				$fecha_mes_nombre = "Marzo";
				break;
			case "04":
				$fecha_mes_nombre = "Abril";
				break;
			case "05":
				$fecha_mes_nombre = "Mayo";
				break;
			case "06":
				$fecha_mes_nombre = "Junio";
				break;
			case "07":
				$fecha_mes_nombre = "Julio";
				break;
			case "08":
				$fecha_mes_nombre = "Agosto";
				break;
			case "09":
				$fecha_mes_nombre = "Septiembre";
				break;
			case "10":
				$fecha_mes_nombre = "Octubre";
				break;
			case "11":
				$fecha_mes_nombre = "Noviembre";
				break;
			case "12":
				$fecha_mes_nombre = "Diciembre";
				break;
		}
		
		$fecha_mes_numero = $anio_actual ."-". $i;
		
		$query_select_importe_trabajo = "SELECT costo,importe FROM t_trabajos WHERE fecha_trabajo LIKE '$fecha_mes_numero%';";
		$result_importe_trabajo = mysqli_query($conexion,$query_select_importe_trabajo);
		if($result_importe_trabajo){
			$numrows1 = mysqli_num_rows($result_importe_trabajo);
			if ($numrows1 > 0){
				while($row1 = mysqli_fetch_assoc($result_importe_trabajo)){
					$ingreso_total += $row1['importe'];
					$ganancia_total += $row1['importe'] - $row1['costo'];
				}
				
				echo "
				<tr>
					<td class='text-center'>";
					if($fecha_hoy == $fecha_mes_numero){
						echo $fecha_mes_nombre ." ". $anio_actual ." (actual)";
					}else{
						echo $fecha_mes_nombre ." ". $anio_actual;
					}
					echo "
					</td>
					<td class='text-center'>$numrows1</td>
					<td class='text-center'>$". moneyFormat($ingreso_total) ."</td>
					<td class='text-center'>$". moneyFormat($ganancia_total) ."</td>
					<td class='text-center'><a href='#' data-target='#detalleVentasMensualesModal' class='info' data-toggle='modal' data-fecha1='$fecha_mes_numero' data-fecha2='$fecha_mes_nombre'>Ver detalle</a></td>
				</tr>";
			}
		}else{
			echo "No se pudieron cargar las ventas mensuales. result_importe_trabajo: ". mysqli_error($conexion);
		}
		
		$ingreso_total = 0;
		$ganancia_total = 0;
	}
	
	echo "</tbody></table></div>";
	
	/*
	require_once ("conexion.php");
	require_once ("../funciones.php");
	$ingreso_total = 0;
	$ganancia_total = 0;
	$getGananciaTrabajo = 0;
	$fecha_hoy = date('Y-m');
	$anio_actual = date('Y');
	
	
	echo "
		<div class='card-body'>
			<table  class='table table-bordered table-hover'>
				<thead>
					<tr>
						<th class='text-center'>Fecha</th>
						<th class='text-center'>Cantidad</th>
						<th class='text-center'>Total cobrado</th>
						<th class='text-center'>Total ganancia</th>
						<!--<th class='text-center'>Opciones</th>-->
				</tr>
				</thead>
				<tbody>";
						
	for($i = 1; $i <= 12; $i++){
		if($i <= 9){
			$i = "0". $i;
		}
				
		switch($i){
			case "01":
				$fecha_mes_nombre = "Enero";
				break;
			case "02":
				$fecha_mes_nombre = "Febrero";
				break;
			case "03":
				$fecha_mes_nombre = "Marzo";
				break;
			case "04":
				$fecha_mes_nombre = "Abril";
				break;
			case "05":
				$fecha_mes_nombre = "Mayo";
				break;
			case "06":
				$fecha_mes_nombre = "Junio";
				break;
			case "07":
				$fecha_mes_nombre = "Julio";
				break;
			case "08":
				$fecha_mes_nombre = "Agosto";
				break;
			case "09":
				$fecha_mes_nombre = "Septiembre";
				break;
			case "10":
				$fecha_mes_nombre = "Octubre";
				break;
			case "11":
				$fecha_mes_nombre = "Noviembre";
				break;
			case "12":
				$fecha_mes_nombre = "Diciembre";
				break;
		}
		
		$fecha_mes_numero = $anio_actual ."-". $i;
			
		$query_select_ventas_fecha = "SELECT * FROM t_pagos WHERE fecha_pago LIKE '$fecha_mes_numero%';";
		$result_select_ventas_fecha = mysqli_query($conexion,$query_select_ventas_fecha);
		if($result_select_ventas_fecha){
			$numrows1 = mysqli_num_rows($result_select_ventas_fecha);
			if ($numrows1 > 0){
				
				while($row1 = mysqli_fetch_array($result_select_ventas_fecha)){
					$getID = $row1['Id'];
					$ingreso_total += $row1['pago_importe'];
					
					$getIdTrabajo = $row1['id_trabajo'];
					$query_select_importe_trabajo = "SELECT costo,importe FROM t_trabajos WHERE fecha_trabajo LIKE '$fecha_mes_numero%';";
					$result_importe_trabajo = mysqli_query($conexion,$query_select_importe_trabajo);
					if($result_importe_trabajo){
						$row2 = mysqli_fetch_assoc($result_importe_trabajo);
						$getGananciaTrabajo = $row2['importe'] - $row2['costo'];
					}else{
						echo "No se pudieron cargar las ventas mensuales. result_importe_trabajo: ". mysqli_error($conexion);
					}
					
					$ganancia_total += $getGananciaTrabajo;
					$getGananciaTrabajo = 0;
				}
				
				echo "
				<tr>
					<td class='text-center'>";
					if($fecha_hoy == $fecha_mes_numero){
						echo $fecha_mes_nombre ." ". $anio_actual ." (actual)";
					}else{
						echo $fecha_mes_nombre ." ". $anio_actual;
					}
					echo "
					</td>
					<td class='text-center'>$numrows1</td>
					<td class='text-center'>$". moneyFormat($ingreso_total) ."</td>
					<td class='text-center'>$". moneyFormat($ganancia_total) ."</td>
				</tr>";
			}
		}else{
			echo "No se pudieron cargar las ventas mensuales. result_select_ventas_fecha: ". mysqli_error($conexion);
		}
		
		$ingreso_total = 0;
		$ganancia_total = 0;
	}
	
	echo "</tbody></table></div>";*/
?>