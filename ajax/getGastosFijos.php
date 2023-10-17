<?php
	require_once ("conexion.php");
	require_once ("../funciones.php");
	// DEFINO EL FORMATO DE MONEDA
	setlocale(LC_MONETARY, 'es_ES');
	$estado_format = null;
	$tdProp = null;
	$getIdTipoTrabajo = null;
	$getClienteGasto = null;
	$getTipoTrabajo = null;
	$setVisibility = null;
	$importeTotal_format = 0;
	
	//main query to fetch the data
	$query_select_gastos = "SELECT * FROM t_gastos WHERE fijo = '1' ORDER BY fecha_gasto DESC;";
	$result_select_gastos = mysqli_query($conexion,$query_select_gastos);
	if($result_select_gastos){
		if ($numrows = mysqli_num_rows($result_select_gastos) > 0){?>
			<div class="card">
				<div class="card-header"><h3><b>Gastos fijos</b></h3></div>
				<div class="card-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class='text-center'>Fecha</th>
								<th class='text-center'>Gasto</th>
								<th class='text-center'>Importe</th>
								<th class='text-center'>Opciones</th>
							</tr>
						</thead>
						<tbody>
			<?php
			while($rowGastos = mysqli_fetch_array($result_select_gastos)){
				$getID = $rowGastos['Id'];
				$getEstado = $rowGastos['estado'];
				$getFijo = $rowGastos['fijo'];
				$getGasto = $rowGastos['gasto'];
				$getImporte = $rowGastos['importe'];
				$getNotas = $rowGastos['notas'];
				$getFechaGasto = $rowGastos['fecha_gasto'];
				$getFechaAgregado = $rowGastos['fecha'];
				$getHoraAgregado = $rowGastos['hora'];
				
				$importeTotal_format += $getImporte;
				$importe_format = moneyFormat($getImporte);
				$fecha_format = date_format(date_create($getFechaGasto), 'd/m/Y');
				$fecha_agregado_format = date_format(date_create($getFechaAgregado), 'd/m/Y');
				$hora_agregado_format = date_format(date_create($getHoraAgregado), 'H:m');
				
				if($getEstado === "A") $setVisibility = "visible";
				echo "
				<tr>
					<td class='text-center'>$fecha_format</td>
					<td class='text-center'>$getGasto</td>
					<td class='text-center'>$ $importe_format</td>
					<td class='text-center' width='5%'>
						<button type='button' class='btn btn-tool dropdown-toggle' data-toggle='dropdown'></button>
						<div class='dropdown-menu dropdown-menu-right' role='menu'>
							<a href='#' style='display:$setVisibility' data-target='#pagosGastoModal' class='dropdown-item' title='Movimientos' data-toggle='modal' data-id='$getID' data-importe='$importe_format'>Pagos</a>
							<a href='#' data-target='#infoGastoModal' class='dropdown-item' title='Informacion' data-toggle='modal' data-id='$getID' data-notas='$getNotas' data-fecha='$fecha_agregado_format' data-hora='$hora_agregado_format'>Info</a>
							<a href='#' style='display:$setVisibility' data-target='#editGastoModal' class='dropdown-item' title='Editar' data-toggle='modal' data-id='$getID' data-gasto='$getGasto' data-importe='$getImporte' data-notas='$getNotas' data-fecha='$getFechaGasto'>Editar</a>
							<a href='#' style='display:$setVisibility' data-target='#deleteGastoModal' class='dropdown-item' title='Borrar' data-toggle='modal' data-id='$getID' data-gasto='$getGasto'>Borrar</a>
						</div>
					</td>
				</tr>";
			}
			?>
						</tbody>
					</table></br>
					<div class="row">
						<div class="col" align="right">
							<?php
								echo "<h4><b>Total: $ ". moneyFormat($importeTotal_format) ."</b></h4>";
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}else{
			echo "No hay gastos fijos agregados";
		}
	}else{
		echo "No se pudieron cargar los gastos fijos. Error result_select_gastos: ". mysqli_error($conexion);
	}
?>