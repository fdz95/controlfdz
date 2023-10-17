<?php
	if(isset($_GET['id_trabajo'])){
		$id_trabajo = $_GET['id_trabajo'];
		require_once ("conexion.php");
		require_once ("../funciones.php");
		// DEFINO EL FORMATO DE MONEDA
		setlocale(LC_MONETARY, 'es_ES');
		$result = "<h4><b>Historial de pagos:</b></br></br>";
		$countPagos = 1;
		
		//main query to fetch the data
		$query_select_pagos = "SELECT * FROM t_pagos WHERE id_trabajo = $id_trabajo;";
		$result_select_pagos = mysqli_query($conexion,$query_select_pagos);
		if($result_select_pagos){
			if ($numrows = mysqli_num_rows($result_select_pagos) > 0){
				while($row = mysqli_fetch_array($result_select_pagos)){
					$getID = $row['Id'];
					
					$getFecha = $row['fecha_pago'];
					$fecha_format = date_format(date_create($getFecha), 'd/m/Y');
					
					$getPago = $row['pago_importe'];
					$pago_format = moneyFormat($getPago);
					
					$result .= "Pago ". $countPagos .": ". $fecha_format ." - $". $pago_format ."</br></br>";
					
					$countPagos++;
				}
			}else{
				$result .= "No hay pagos agregados";
			}
		}else{
			$result .= "No se pudieron cargar los pagos. Error result_select_pagos: ". mysqli_error($conexion);
		}
	}else{
		$result .= "No se pudieron cargar los pagos. Error_id_trabajo_NOT_FOUND ". mysqli_error($conexion);
	}
		
	echo $result ."</h4>";
?>