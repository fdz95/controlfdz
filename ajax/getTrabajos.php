<?php
	require_once("conexion_2.php");
	require_once("../funciones.php");
	// DEFINO EL FORMATO DE MONEDA
	setlocale(LC_MONETARY, 'es_ES');
	$tdProp = null;
	$getNombreCliente = "";
	$getCelularCliente = "";
	
	$orderBy = "";
	if(isset($_GET['ordenar'])) if($_GET['ordenar'] === "1") $orderBy = " ORDER BY estado DESC";
	
	//main query to fetch the data
	//$query_select_trabajos = "SELECT * FROM t_trabajos ORDER BY estado DESC;";
	$query_select_trabajos = "SELECT * FROM t_trabajos WHERE estado != 'A' $orderBy;";
	$result_select_trabajos = $pdo->query($query_select_trabajos);
	if ($result_select_trabajos) {
		if ($numrows = $result_select_trabajos->rowCount() > 0) { ?>
			<div class="row">
				<div class="col">
					<div class="card card-default">
						<div class="card-header">
							<h2 class="card-title"><b>Trabajos</b></h2>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
							</div>
							<!-- /.card-tools -->
						</div>
						<div class="card-body">
							<table class="table table-bordered table-hover">
								<thead>
								<tr>
									<th class='text-center'>ID</th>
									<th class='text-center'>Cliente</th>
									<th class='text-center' style="cursor: pointer;" onclick="ordenar()">Estado</th>
									<th class='text-center'>Fecha</th>
									<th class='text-center'>Trabajo</th>
									<th class='text-center'>Costo</th>
									<th class='text-center'>Importe</th>
									<th class='text-center'>Ganancia</th>
									<th class='text-center'>Saldo</th>
									<th class='text-center'>Opc</th>
								</tr>
								</thead>
								<tbody>
								<?php
								while ($row = $result_select_trabajos->fetch(PDO::FETCH_ASSOC)) {
									$getID = $row['Id'];
									$getFecha = $row['fecha_trabajo'];
									$fecha_format = date_format(date_create($getFecha), 'd/m/Y');

									$getIdCliente = $row['cliente'];
									$query_select_nombre = "SELECT nombre, apellido, celular FROM t_clientes WHERE Id = '$getIdCliente';";
									$result_select_nombre = $pdo->query($query_select_nombre);
									if ($result_select_nombre) {
										$stmt = $result_select_nombre->fetchAll(PDO::FETCH_ASSOC);
										if (count($stmt) > 0) {
											foreach ($stmt as $row1) {
												$getNombreCliente = $row1['nombre'] . " " . $row1['apellido'];
												$getCelularCliente = $row1['celular'];
											}
										}else{
											$getNombreCliente = $getIdCliente;
										}
									} else {
										echo "<div class='card-body'>No se pudieron cargar los clientes. Error result_select_nombre: " . $conexion->errorInfo() . "</div>";
									}

									$getEquipo = $row['equipo'];

									$getTrabajo = $row['trabajo'];
									$query_select_tipo_trabajo = "SELECT * FROM t_tipos WHERE Id = '$getTrabajo';";
									$result_tipo_trabajo = $pdo->query($query_select_tipo_trabajo);
									if ($result_tipo_trabajo) {
										$row2 = $result_tipo_trabajo->fetch(PDO::FETCH_ASSOC);
									$getTipoTrabajo = $row2['tipo'];
									} else {
										echo "<div class='card-body'>No se pudieron cargar los trabajos. Error result_tipo_trabajo: " . $conexion->errorInfo() . "</div>";
									}

									$getObserv = $row['observ'];

									$getCosto = $row['costo'];
									$costo_format = moneyFormat($getCosto);

									$getImporte = $row['importe'];
									$importe_format = moneyFormat($getImporte);

									$getGanancia = moneyFormat($getImporte - $getCosto);

									$getSaldo = $row['saldo'];
									$saldo_format = moneyFormat($getSaldo);

									$getEstado = $row['estado'];
									switch ($getEstado) {
										case 'A':
											$tdProp = "style='background-color:#9EFF94' class='text-center'";
											if ($getSaldo == 0) {
												// VERDE: reparado y pagado
												$estado_format = "Pagado";
											} else {
												// VERDE: en reparacion
												$estado_format = "Reparado (falta pagar)";
											}
											$setVisibility = "none";
											break;

										case 'B': // AMARILLO: esperando repuesto
											$estado_format = "Esp. repuesto";
											$tdProp = "style='background-color:#FFFF6D' class='text-center'";
											break;

										case 'C': // ROJO: No se puede reparar
											$estado_format = "No se puede rep.";
											$tdProp = "style='background-color:#FFD8D8' class='text-center'";
											break;

										case 'D': // AZUL: esperando pago
											$estado_format = "<font color='white'>Esp. pago</font>";
											$tdProp = "style='background-color:#8AA1FF' class='text-center'";
											break;

										default: // BLANCO: en reparacion
											$estado_format = "En reparac.";
											$tdProp = "style='background-color:#FFFFFF' class='text-center'";
											break;
									}

									if ($getEstado != "A") {
										//$estado_format = "<a href='#' data-target='#cambiarEstadoTrabajoModal' class='info' title='Cambiar estado' data-toggle='modal' data-id='$getID'>$estado_format</a>";
									}
									
									$getFechaAgregado = $row['fecha'];
									$fecha_agregado_format = date_format(date_create($getFechaAgregado), 'd/m/Y');
									$getHoraAgregado = $row['hora'];
									$hora_agregado_format = date_format(date_create($getHoraAgregado), 'H:m');
									
									echo "<tr>
									<td $tdProp>$getID</td>
									<td $tdProp>$getNombreCliente</a></td>
									<td $tdProp>
										<button type='button' class='btn btn-tool dropdown-toggle' data-toggle='dropdown'>$estado_format</button>
										<div class='dropdown-menu dropdown-menu-right' role='menu'>
											<a href='#' id='set_estado' class='dropdown-item' title='Estado' data-id='$getID' data-estado=''>En reparaci&oacute;n</a>
											<a href='#' id='set_estado' class='dropdown-item' title='Estado' data-id='$getID' data-estado='2'>Esperando repuesto</a>
											<a href='#' id='set_estado' class='dropdown-item' title='Estado' data-id='$getID' data-estado='3'>No se puede reparar</a>
											<a href='#' id='set_estado' class='dropdown-item' title='Estado' data-id='$getID' data-estado='4'>Esperando pago</a>
										</div>
									</td>
										
										
									<td $tdProp>$fecha_format</td>
									<td $tdProp>$getEquipo - $getTipoTrabajo</td>
									<td $tdProp>$ $costo_format</td>
									<td $tdProp>$ $importe_format</td>
									<td $tdProp><font color='green'><b>$ $getGanancia</b></font></td>
									<td $tdProp>$ $saldo_format</td>
									<td $tdProp>
										<button type='button' class='btn btn-tool dropdown-toggle' data-toggle='dropdown'></button>
										<div class='dropdown-menu dropdown-menu-right' role='menu'>";

									if ($getEstado != "A") {
										echo "
											<a href='#' data-target='#pagosTrabajoModal' class='dropdown-item' title='Pagos' data-toggle='modal' data-id='$getID' data-idcliente='$getIdCliente' data-cliente='$getNombreCliente' data-equipo='$getEquipo' data-importe='$importe_format' data-saldof='$saldo_format' data-saldo='$getSaldo'>Pagos</a>
											<a href='ajax/printTrabajo.php?id_trabajo=$getID' target='_blank' class='dropdown-item' title='Imprimir'>Imprimir</a>
											<a href='#' data-target='#infoTrabajoModal' class='dropdown-item' title='Informacion' data-toggle='modal' data-id='$getID' data-idcliente='$getIdCliente' data-cliente='$getNombreCliente' data-celular='$getCelularCliente' data-notas='$getObserv' data-fecha='$fecha_agregado_format' data-hora='$hora_agregado_format'>Info</a>
											<a href='#' data-target='#editTrabajoModal' class='dropdown-item' title='Editar' data-toggle='modal' data-id='$getID' data-fecha='$fecha_format' data-cliente='$getNombreCliente' data-equipo='$getEquipo' data-tipo='$getTipoTrabajo' data-observ='$getObserv' data-importe='$getImporte' data-costo='$getCosto'>Editar</a>
											<a href='#' data-target='#deleteTrabajoModal' class='dropdown-item' title='Borrar' data-toggle='modal' data-id='$getID' data-cliente='$getNombreCliente' data-equipo='$getEquipo'>Borrar</a>";
									} else {
										echo "
											<a href='#' data-target='#pagosTrabajoModal2' class='dropdown-item' title='Pagos' data-toggle='modal' data-id='$getID' data-cliente='$getNombreCliente' data-equipo='$getEquipo' data-importe='$importe_format' data-saldof='$saldo_format'>Pagos</a>
											<a href='#' data-target='#infoTrabajoModal' class='dropdown-item' title='Informacion' data-toggle='modal' data-id='$getID' data-idcliente='$getIdCliente' data-cliente='$getNombreCliente' data-celular='$getCelularCliente' data-notas='$getObserv' data-fecha='$fecha_agregado_format' data-hora='$hora_agregado_format'>Info</a>";
									}

									echo "</div></td></tr>";
								} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		<?php
		}else {
			echo "<div class='card'>
					<div class='card-header'>
						<h2 class='card-title'><b>Trabajos</b></h2>
					</div>
					<div class='card-body'>No hay trabajos agregados</div>
				</div>";
		}
	}else {
		echo "<div class='card'>
				<div class='card-header'>
					<h2 class='card-title'><b>Trabajos</b></h2>
				</div>
				<div class='card-body'>No hay trabajos agregados</div>
			</div>";
	}?>