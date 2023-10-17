<?php
	require_once ("conexion.php");
	$ingreso_total = 0;
	$ganancia_total = 0;
	$anio_actual = date('Y');
	$mes_actual_nombre = "";

	for($i = 1; $i <= 12; $i++){
		if($i <= 9){
			$i = "0". $i;
		}
		$fecha_query = $anio_actual ."-". $i;
		switch($i){
			case "01":
				$mes_actual_nombre = "Enero";
				break;
			case "02":
				$mes_actual_nombre = "Febrero";
				break;
			case "03":
				$mes_actual_nombre = "Marzo";
				break;
			case "04":
				$mes_actual_nombre = "Abril";
				break;
			case "05":
				$mes_actual_nombre = "Mayo";
				break;
			case "06":
				$mes_actual_nombre = "Junio";
				break;
			case "07":
				$mes_actual_nombre = "Julio";
				break;
			case "08":
				$mes_actual_nombre = "Agosto";
				break;
			case "09":
				$mes_actual_nombre = "Septiembre";
				break;
			case "10":
				$mes_actual_nombre = "Octubre";
				break;
			case "11":
				$mes_actual_nombre = "Noviembre";
				break;
			case "12":
				$mes_actual_nombre = "Diciembre";
				break;
		}
				
		$query_select_importe_trabajo = "SELECT costo,importe FROM t_trabajos WHERE fecha_trabajo LIKE '$fecha_query%';";
		$result_importe_trabajo = mysqli_query($conexion,$query_select_importe_trabajo);
		if($result_importe_trabajo){
			while($row1 = mysqli_fetch_assoc($result_importe_trabajo)){
				$ingreso_total += $row1['importe'];
				$ganancia_total += $row1['importe'] - $row1['costo'];
			}
		}
		
		$etiquetas[] = $mes_actual_nombre;
		$datosVentas[] = $ganancia_total;
		$ganancia_total = 0;
	}
	
	$respuesta = [
		"etiquetas" => $etiquetas,
		"datos" => $datosVentas,
	];
	echo json_encode($respuesta);
?>