<?php
	require_once ("conexion.php");
	require_once ("../funciones.php");
	$getIdTipoTrabajo = null;
	$getClienteGasto = null;
	$getTipoTrabajo = "";
	$setVisibility = null;
	$importeTotal_format = 0;
	$setVisibility_fijo = null;
	$importeTotal_format_fijo = 0;
	$output_body = null;
	$output = null;
	$output_body_fijo = null;
	$output_fijo = null;
	$output_total = null;
	
	/////////////////
	///////////////// GASTOS FIJOS
	/////////////////
	
	echo "<div class='row'>";
	
	//main query to fetch the data
	$query_select_gastos_fijos = "SELECT * FROM t_gastos WHERE fijo = '1' ORDER BY fecha_gasto DESC;";
	$result_select_gastos_fijos = mysqli_query($conexion,$query_select_gastos_fijos);
	if($result_select_gastos_fijos){
		if ($numrows = mysqli_num_rows($result_select_gastos_fijos) > 0){
			while($rowGastosFijos = mysqli_fetch_array($result_select_gastos_fijos)){
				$getID_fijo = $rowGastosFijos['Id'];
				$getEstado_fijo = $rowGastosFijos['estado'];
				$getGasto_fijo = $rowGastosFijos['gasto'];
				$getImporte_fijo = $rowGastosFijos['importe'];
				$getNotas_fijo = $rowGastosFijos['notas'];
				$getFechaGasto_fijo = $rowGastosFijos['fecha_gasto'];
				$getFechaAgregado_fijo = $rowGastosFijos['fecha'];
				$getHoraAgregado_fijo = $rowGastosFijos['hora'];
				
				$importeTotal_format_fijo += $getImporte_fijo;
				$importe_format_fijo = moneyFormat($getImporte_fijo);
				$fecha_format_fijo = date_format(date_create($getFechaGasto_fijo), 'd/m/Y');
				$fecha_agregado_format_fijo = date_format(date_create($getFechaAgregado_fijo), 'd/m/Y');
				$hora_agregado_format_fijo = date_format(date_create($getHoraAgregado_fijo), 'H:m');
				
				if($getEstado_fijo === "A"){
					$setVisibility_fijo = "visible";
				}else{
					$setVisibility_fijo = "hidden";
				}
				
				$output_body_fijo .= "
				<tr>
					<td class='text-center'>$fecha_format_fijo</td>
					<td class='text-center'>$getGasto_fijo</td>
					<td class='text-center'>$ $importe_format_fijo</td>
					<td class='text-center' width='5%'>
						<button type='button' class='btn btn-tool dropdown-toggle' data-toggle='dropdown'></button>
						<div class='dropdown-menu dropdown-menu-right' role='menu'>
							<a href='#' style='display:$setVisibility_fijo' data-target='#pagosGastoModal' class='dropdown-item' title='Movimientos' data-toggle='modal' data-id='$getID_fijo' data-importe='$importe_format_fijo'>Pagos</a>
							<a href='#' data-target='#infoGastoModal' class='dropdown-item' title='Informacion' data-toggle='modal' data-id='$getID_fijo' data-notas='$getNotas_fijo' data-fecha='$fecha_agregado_format_fijo' data-hora='$hora_agregado_format_fijo'>Info</a>
							<a href='#' style='display:$setVisibility_fijo' data-target='#editGastoModal' class='dropdown-item' title='Editar' data-toggle='modal' data-id='$getID_fijo' data-gasto='$getGasto_fijo' data-importe='$getImporte_fijo' data-notas='$getNotas_fijo' data-fecha='$getFechaGasto_fijo'>Editar</a>
							<a href='#' style='display:$setVisibility_fijo' data-target='#deleteGastoModal' class='dropdown-item' title='Borrar' data-toggle='modal' data-id='$getID_fijo' data-gasto='$getGasto_fijo'>Borrar</a>
						</div>
					</td>
				</tr>";
			}
			
			$output_fijo = "
			<div class='col'>
				<div class='card'>
					<div class='card-header'>
						<div class='row'>
							<div class='col'>
								<h3><b>Gastos fijos</b></h3>
							</div>
							<div class='col' align='right'>
								<h3><b>$". moneyFormat($importeTotal_format_fijo) ."</b></h3>
							</div>
						</div>
					</div>
					<div class='card-body'>
						<table class='table table-bordered table-hover'>
							<thead>
								<tr>
									<th class='text-center'>Fecha</th>
									<th class='text-center'>Gasto</th>
									<th class='text-center'>Importe</th>
									<th class='text-center'>Opciones</th>
								</tr>
							</thead>
							<tbody>
							$output_body_fijo
							</tbody>
						</table>
					</div>
				</div>
			</div>";
		}else{	
		
			$output_fijo = "
			<div class='col'>
				<div class='card'>
					<div class='card-header'>
						<div class='row'>
							<div class='col'>
								<h3><b>Gastos fijos</b></h3>
							</div>
						</div>
					</div>
					<div class='card-body'>
						No hay gastos agregados
					</div>
				</div>
			</div>";
		}
	}else{
		echo "No se pudieron cargar los gastos fijos. Error result_select_gastos_fijos: ". mysqli_error($conexion);
	}
	
	/////////////////
	///////////////// GASTOS MENSUALES
	/////////////////
	
	//main query to fetch the data
	$query_select_gastos = "SELECT * FROM t_gastos WHERE fijo = '0' ORDER BY fecha_gasto DESC;";
	$result_select_gastos = mysqli_query($conexion,$query_select_gastos);
	if($result_select_gastos){
		if ($numrows = mysqli_num_rows($result_select_gastos) > 0){
			while($rowGastos = mysqli_fetch_array($result_select_gastos)){
				$getID = $rowGastos['Id'];
				$getEstado = $rowGastos['estado'];
				$getGasto = $rowGastos['gasto'];
				$getTrabajo = $rowGastos['trabajo'];
				$getImporte = $rowGastos['importe'];
				$getSaldo = $rowGastos['saldo'];
				$getNotas = $rowGastos['notas'];
				$getFechaGasto = $rowGastos['fecha_gasto'];
				$getFechaAgregado = $rowGastos['fecha'];
				$getHoraAgregado = $rowGastos['hora'];
				
				if($getEstado === "A"){
					$setVisibility = "visible";
				}else{
					$setVisibility = "hidden";
				}
				
				$importeTotal_format += $getImporte;
				$importe_format = moneyFormat($getImporte);
				$saldo_format = moneyFormat($getSaldo);
				$fecha_format = date_format(date_create($getFechaGasto), 'd/m/Y');
				$fecha_agregado_format = date_format(date_create($getFechaAgregado), 'd/m/Y');
				$hora_agregado_format = date_format(date_create($getHoraAgregado), 'H:m');
				
				if(!empty($getTrabajo) || $getTrabajo != null){
					$query_select_trabajo = "SELECT * FROM t_trabajos WHERE Id = '$getTrabajo';";
					$result_select_trabajo = mysqli_query($conexion,$query_select_trabajo);
					if($result_select_trabajo){
						$row1 = mysqli_fetch_assoc($result_select_trabajo);
						$getIdTipoTrabajo = $row1['trabajo'];
						$getIdClienteTrabajo = $row1['cliente'];
						$getImporteTrabajo = $row1['importe'];
						
						$query_select_tipo_trabajo = "SELECT * FROM t_tipos WHERE Id = '$getIdTipoTrabajo';";
						$result_tipo_trabajo = mysqli_query($conexion,$query_select_tipo_trabajo);
						if($result_tipo_trabajo){
							$row2 = mysqli_fetch_assoc($result_tipo_trabajo);
							$getTipoTrabajo = $row2['tipo'];
						}else{
							echo "No se pudieron cargar los trabajos. Error result_tipo_trabajo: ". mysqli_error($conexion);
						}
					}else{
						echo "No se pudieron cargar los trabajos. Error result_select_trabajo: ". mysqli_error($conexion);
					}
				}
				
				$output_body .= "<tr>
					<td class='text-center'>$fecha_format</td>
					<td class='text-center'>$getGasto $getTipoTrabajo</td>
					<td class='text-center'>$ $importe_format</td>
					<td class='text-center' width='5%'>
						<button type='button' class='btn btn-tool dropdown-toggle' data-toggle='dropdown'></button>
						<div class='dropdown-menu dropdown-menu-right' role='menu'>
							<a href='#' style='display:$setVisibility' data-target='#pagosGastoModal' class='dropdown-item' title='Movimientos' data-toggle='modal' data-id='$getID' data-importe='$importe_format' data-saldof='$saldo_format' data-saldo='$getSaldo'>Pagos</a>
							<a href='#' data-target='#infoGastoModal' class='dropdown-item' title='Informacion' data-toggle='modal' data-id='$getID' data-notas='$getNotas' data-fecha='$fecha_agregado_format' data-hora='$hora_agregado_format'>Info</a>
							<a href='#' style='display:$setVisibility' data-target='#editGastoModal' class='dropdown-item' title='Editar' data-toggle='modal' data-id='$getID' data-gasto='$getGasto' data-importe='$getImporte' data-notas='$getNotas' data-fecha='$getFechaGasto'>Editar</a>
							<a href='#' style='display:$setVisibility' data-target='#deleteGastoModal' class='dropdown-item' title='Borrar' data-toggle='modal' data-id='$getID' data-gasto='$getGasto'>Borrar</a>
						</div>
					</td>
				</tr>";
			}
			
			$output = "
			<div class='col'>
				<div class='card'>
					<div class='card-header'>
						<div class='row'>
							<div class='col'>
								<h3><b>Gastos mensuales</b></h3>
							</div>
							<div class='col' align='right'>
								<h3><b>$". moneyFormat($importeTotal_format) ."</b></h3>
							</div>
						</div>
					</div>
					<div class='card-body'>
						<table class='table table-bordered table-hover'>
							<thead>
								<tr>
									<th class='text-center'>Fecha</th>
									<th class='text-center'>Gasto</th>
									<th class='text-center'>Importe</th>
									<th class='text-center'>Opciones</th>
								</tr>
							</thead>
							<tbody>
							$output_body
							</tbody>
						</table>
					</div>
				</div>
			</div>";
			
		}else{
			$output = "
			<div class='col'>
				<div class='card'>
					<div class='card-header'>
						<div class='row'>
							<div class='col'>
								<h3><b>Gastos mensuales</b></h3>
							</div>
						</div>
					</div>
					<div class='card-body'>
						No hay gastos agregados
					</div>
				</div>
			</div>";
		}
	}else{
		echo "No se pudieron cargar los gastos. Error result_select_gastos: ". mysqli_error($conexion);
	}
	
	$output_total = "
		<div class='col-3'>
			<div class='card'>
				<div class='card-header' align='right'>
					<h3><b>Total: $". moneyFormat($importeTotal_format + $importeTotal_format_fijo) ."</b></h3>
				</div>
			</div>
		</div>";
	
	echo $output_fijo . $output . $output_total;
?>