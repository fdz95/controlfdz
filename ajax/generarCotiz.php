<?php
	require_once ("conexion.php");
	$message = null;
	$error = null;
	$getTotalCosto = 0;
	$getTotalImporte = 0;
	$id_generar_cotiz = mysqli_real_escape_string($conexion,(strip_tags($_POST["id_generar_cotiz"],ENT_QUOTES)));
	$id_cliente = mysqli_real_escape_string($conexion,(strip_tags($_POST["id_generar_cotiz_cliente"],ENT_QUOTES)));
	$cotiz_fecha = date('Y-m-d');
	$cotiz_hora = date('H:i');
	
	$query_select_detalle_cotiz = "SELECT * FROM t_cotiz_detalle WHERE id_cotiz = '$id_generar_cotiz';";
	$result_detalle_cotiz = mysqli_query($conexion,$query_select_detalle_cotiz);
	if($result_detalle_cotiz){
		if(mysqli_num_rows($result_detalle_cotiz) > 0){
			while($row = mysqli_fetch_assoc($result_detalle_cotiz)){
				$getTotalCosto += $row['costo_total'];
				$getTotalImporte += $row['importe'];
			}
			
			$query_select_cotiz = "SELECT * FROM t_cotiz WHERE Id = '$id_generar_cotiz';";
			$result_select_cotiz = mysqli_query($conexion,$query_select_cotiz);
			if ($result_select_cotiz) {
				if(mysqli_num_rows($result_select_cotiz) <= 0){
					
					// insert
					$query_insert_cotiz = "INSERT INTO t_cotiz(estado, cliente, costo, importe_cliente, fecha, hora) VALUES('A', '$id_cliente', '$getTotalCosto', '$getTotalImporte', '$cotiz_fecha', '$cotiz_hora');";
					$result_insert_cotiz = mysqli_query($conexion,$query_insert_cotiz);
					if ($result_insert_cotiz) {
						$message = "Cotizaci&oacute;n generada";
					}else{
						$error = "No se pudo generar. Por favor, vuelva a intentarlo.</br>Error result_insert_cotiz: ". mysqli_error($conexion);
					}
				}else{
					
					// update
					$query_update_cotiz = "UPDATE t_cotiz SET costo = '$getTotalCosto', importe_cliente = '$getTotalImporte', fecha = '$cotiz_fecha', hora = '$cotiz_hora';";
					$result_update_cotiz = mysqli_query($conexion,$query_update_cotiz);
					if ($result_update_cotiz) {
						$message = "Cotizaci&oacute;n actualizada";
					}else{
						$error = "No se pudo actualizar. Por favor, vuelva a intentarlo.</br>Error result_update_cotiz: ". mysqli_error($conexion);
					}
				}
			}else{
				$error = "No se pudo generar. Por favor, vuelva a intentarlo.</br>Error result_select_cotiz: ". mysqli_error($conexion);
			}
		}else{
			$error = "No se pudo encontrar el detalle de la cotizaci&oacute;n";
		}
	}else{
		$error = "No se pudo generar. Por favor, vuelva a intentarlo.</br>Error result_detalle_cotiz: ". mysqli_error($conexion);
	}
	
	if(isset($message)){
		echo $message;
	}
	
	if(isset($error)){
		echo "<font color='red'><b>Error: ". $error ."</b></font>";
	}
?>