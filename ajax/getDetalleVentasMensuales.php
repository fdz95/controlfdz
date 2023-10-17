<?php
	require_once ("conexion.php");
	require_once ("../funciones.php");
	$ganancia_total = 0;
	$fecha_hoy = date('Y-m');
	$anio_actual = date('Y');
	
	$fecha_mes_numero = $_GET['fecha1'];
	$fecha_mes_nombre = $_GET['fecha2'];
	
	$query_select_detalle_vmensual = "SELECT * FROM t_trabajos WHERE fecha_trabajo LIKE '$fecha_mes_numero%';";
	$result_detalle_vmensual = mysqli_query($conexion,$query_select_detalle_vmensual);
	if($result_detalle_vmensual){
		$numrows1 = mysqli_num_rows($result_detalle_vmensual);
		if ($numrows1 > 0){
			echo "
				<h3><b>$fecha_mes_nombre</b></h3></br>
				<table class='table table-bordered table-hover'>
					<thead>
						<tr>
							<th class='text-center'>Fecha</th>
							<th class='text-center'>Cliente</th>
							<th class='text-center'>Trabajo</th>
							<th class='text-center'>Costo</th>
							<th class='text-center'>Importe</th>
							<th class='text-center'>Ganancia</th>
					</tr>
					</thead>
					<tbody>";
					
					
			while($row1 = mysqli_fetch_assoc($result_detalle_vmensual)){
				$fecha_trabajo = $row1['fecha_trabajo'];
				$fecha_trabajo_format = date_format(date_create($fecha_trabajo),"d/m/Y");
				$id_cliente_trabajo = $row1['cliente'];
				$equipo_trabajo = $row1['equipo'];
				$id_tipo_trabajo = $row1['trabajo'];
				$costo_trabajo = $row1['costo'];
				$importe_trabajo = $row1['importe'];
				$ganancia_trabajo = $importe_trabajo - $costo_trabajo;
				$ganancia_total += $ganancia_trabajo;
				
				$query_select_nombre = "SELECT nombre, apellido, celular FROM t_clientes WHERE Id = '$id_cliente_trabajo';";
				$result_select_nombre = mysqli_query($conexion,$query_select_nombre);
				if($result_select_nombre){
					$row2 = mysqli_fetch_assoc($result_select_nombre);
					$getNombreCliente = $row2['nombre']." ".$row2['apellido'];
				}
				
				$query_select_tipo_trabajo = "SELECT * FROM t_tipos WHERE Id = '$id_tipo_trabajo';";
				$result_tipo_trabajo = mysqli_query($conexion,$query_select_tipo_trabajo);
				if($result_tipo_trabajo){
					$row3 = mysqli_fetch_assoc($result_tipo_trabajo);
					$getTipoTrabajo = $row3['tipo'];
				}
				
				echo "
				<tr>
					<td class='text-center'>$fecha_trabajo_format</td>
					<td class='text-center'>$id_cliente_trabajo-$getNombreCliente</td>
					<td class='text-center'>$equipo_trabajo - $getTipoTrabajo</td>
					<td class='text-center'>$". moneyFormat($costo_trabajo) ."</td>
					<td class='text-center'>$". moneyFormat($importe_trabajo) ."</td>
					<td class='text-center'>$". moneyFormat($ganancia_trabajo) ."</td>
				</tr>";
			}
				
			echo "</tbody></table></br></br><div align='right'><h3><b>Total: $". moneyFormat($ganancia_total) ."</b></h3></div>";
		}else{
			echo "No se encontraron registros";
		}
	}else{
		echo "No se pudo cargar el detalle de las ventas mensuales. result_detalle_vmensual: ". mysqli_error($conexion);
	}
?>