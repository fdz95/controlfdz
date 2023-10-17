<?php
	require_once ("conexion.php");
	require_once ("../funciones.php");
	// DEFINO EL FORMATO DE MONEDA
	setlocale(LC_MONETARY, 'es_ES');
	$tdProp = null;
	$getNombreCliente = "";
	$getCelularCliente = "";
	
	$texto_buscar = null;
	$count_trabajo = null;
	$query_select_trabajosF = null;
	if(isset($_GET['search'])){ // si es busqueda, primero busco el nombre del cliente o del equipo
		$texto_buscar = $_GET['search'];
		$query_buscar_cliente = "SELECT * FROM t_clientes WHERE nombre LIKE '%$texto_buscar%' OR apellido LIKE '%$texto_buscar%';";
		$result_buscar_cliente = mysqli_query($conexion,$query_buscar_cliente);
		if($result_buscar_cliente){
			if(mysqli_num_rows($result_buscar_cliente) > 0){ // si encuentro cliente, devuelvo el id para buscar en t_trabajos
				$rows_cliente = mysqli_fetch_assoc($result_buscar_cliente);
				$id_cliente = $rows_cliente['Id'];
				$query_select_trabajosF = "SELECT * FROM t_trabajos WHERE estado = 'A' AND cliente = '$id_cliente' ORDER BY fecha_trabajo DESC;";
			}else{ // si no encuentro clientes, busco equipos
				$query_select_trabajosF = "SELECT * FROM t_trabajos WHERE estado = 'A' AND equipo LIKE '%$texto_buscar%' ORDER BY fecha_trabajo DESC;";
			}
		}
		
	}else{ // si no es busqueda, devuelvo todos los trabajos (default)
		$query_select_trabajosF = "SELECT * FROM t_trabajos WHERE estado = 'A' ORDER BY fecha_trabajo DESC;";
	}
	
	$result_select_trabajosF = mysqli_query($conexion,$query_select_trabajosF);
	if($result_select_trabajosF){
		if ($count_trabajo = mysqli_num_rows($result_select_trabajosF) > 0){?>
		
	<div class="row">
		<div class="col">
			<div class="card card-default">
				<div class="card-header">
					<div class="row">
						<div class="col">
							<h2 class="card-title"><b>Trabajos finalizados</b></h2>
						</div>
						<div class="col">
							<div id="loader_trabajo_finalizados"></div>
							<input type="search" class="form-control" onsearch="loadTrabajosF(true)" name="input_search_trabajof" id="input_search_trabajof" placeholder="Buscar por cliente o equipo..." />
						</div>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
						</div>
					</div>
					<!-- /.card-tools -->
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class='text-center'>ID</th>
								<th class='text-center'>Cliente</th>
								<th class='text-center'>Fecha</th>
								<th class='text-center'>Trabajo</th>
								<th class='text-center'>Costo</th>
								<th class='text-center'>Importe</th>
								<th class='text-center'>Ganancia</th>
								<th class='text-center'>Opc</th>
							</tr>
						</thead>
						<tbody>
					<?php
					$count_trabajo = 0;
					while($row_trabajos = mysqli_fetch_assoc($result_select_trabajosF)){
						$getID = $row_trabajos['Id'];
						$getFecha = $row_trabajos['fecha_trabajo'];
						$fecha_format = date_format(date_create($getFecha), 'd/m/Y');
						
						$getIdCliente = $row_trabajos['cliente'];
						$query_select_nombre = "SELECT nombre, apellido, celular FROM t_clientes WHERE Id = '$getIdCliente';";
						$result_select_nombre = mysqli_query($conexion,$query_select_nombre);
						if($result_select_nombre){
							if(mysqli_num_rows($result_select_nombre) > 0){
								$row1 = mysqli_fetch_assoc($result_select_nombre);
								$getNombreCliente = $row1['nombre']." ".$row1['apellido'];
								$getCelularCliente = $row1['celular'];
							}else{
								$getNombreCliente = $getIdCliente;
							}
						}else{
							echo "<div class='card-body'>No se pudieron cargar los clientes. Error result_select_nombre: ". mysqli_error($conexion) ."</div>";
						}
						
						$getEquipo = $row_trabajos['equipo'];
						
						$getTrabajo = $row_trabajos['trabajo'];
						$query_select_tipo_trabajo = "SELECT * FROM t_tipos WHERE Id = '$getTrabajo';";
						$result_tipo_trabajo = mysqli_query($conexion,$query_select_tipo_trabajo);
						if($result_tipo_trabajo){
							$row2 = mysqli_fetch_assoc($result_tipo_trabajo);
							$getTipoTrabajo = $row2['tipo'];
						}else{
							echo "<div class='card-body'>No se pudieron cargar los trabajos. Error result_tipo_trabajo: ". mysqli_error($conexion) ."</div>";
						}
						
						$getObserv = $row_trabajos['observ'];
							
						$getCosto = $row_trabajos['costo'];
						$costo_format = moneyFormat($getCosto);
						
						$getImporte = $row_trabajos['importe'];
						$importe_format = moneyFormat($getImporte);
						
						$getGanancia = moneyFormat($getImporte - $getCosto);
						
						$saldo_format = "";
						$getFechaAgregado = $row_trabajos['fecha'];
						$fecha_agregado_format = date_format(date_create($getFechaAgregado), 'd/m/Y');
						$getHoraAgregado = $row_trabajos['hora'];
						$hora_agregado_format = date_format(date_create($getHoraAgregado), 'H:m');
						$tdProp = "style='background-color:#9EFF94' class='text-center'";
						echo "<tr>
							<td $tdProp>$getID</td>
							<td $tdProp>$getNombreCliente</a></td>
							<td $tdProp>$fecha_format</td>
							<td $tdProp>$getEquipo - $getTipoTrabajo</td>
							<td $tdProp>$ $costo_format</td>
							<td $tdProp>$ $importe_format</td>
							<td $tdProp><font color='green'><b>$ $getGanancia</b></font></td>
							<td $tdProp>
								<button type='button' class='btn btn-tool dropdown-toggle' data-toggle='dropdown'></button>
								<div class='dropdown-menu dropdown-menu-right' role='menu'>
									<a href='#' data-target='#pagosTrabajoModal2' class='dropdown-item' title='Pagos' data-toggle='modal' data-id='$getID' data-cliente='$getNombreCliente' data-equipo='$getEquipo' data-importe='$importe_format' data-saldof='$saldo_format'>Pagos</a>
									<a href='ajax/printTrabajo.php?id_trabajo=$getID' target='_blank' class='dropdown-item' title='Imprimir'>Re-imprimir</a>
									<a href='#' data-target='#infoTrabajoModal' class='dropdown-item' title='Informacion' data-toggle='modal' data-id='$getID' data-idcliente='$getIdCliente' data-cliente='$getNombreCliente' data-celular='$getCelularCliente' data-notas='$getObserv' data-fecha='$fecha_agregado_format' data-hora='$hora_agregado_format'>Info</a>
								</div></td></tr>";
								$count_trabajo++;
					}
					?>
						</tbody>
					</table>
					
					<?php if(isset($_GET['search'])){
						$resultado_search = "";
						if($count_trabajo === 1){
							$resultado_search = "<b>Se encontro $count_trabajo registro</b>";
						}else if($count_trabajo > 1){
							$resultado_search = "<b>Se encontraron $count_trabajo registros</b>";
						}
						
						?>
						<div class="row">
							<?php echo " ". $resultado_search; ?>
						</div>
					<?php } ?>
				<?php
				}else{
					echo "<div class='card'>
						<div class='card-header'>
							<div class='row'>
								<div class='col'>
									<h2 class='card-title'><b>Trabajos finalizados</b></h2>
								</div>
								<div class='col'>
									<input type='search' class='form-control' onsearch='loadTrabajosF(true)' name='input_search_trabajof' id='input_search_trabajof' placeholder='Buscar por cliente o equipo...' />
								</div>
								<div class='card-tools'>
									<button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i></button>
								</div>
							</div>
							<!-- /.card-tools -->
						</div>
							<div class='card-body'>No se encontraron trabajos finalizados con '$texto_buscar'. <a href='index.php'><b>Volver</b></a></div>
						</div>";
				}
			}else{
				echo "<div class='card'>
						<div class='card-header'>
							<h2 class='card-title'><b>Trabajos finalizados</b></h2>
						</div>
						<div class='card-body'>No se pudieron cargar los trabajos finalizados. Error result_select_trabajosF: ". mysqli_error($conexion) ."</div>
					</div>";
			} ?>
								
				</div>
			<!-- /.card-body -->
			</div>
		<!-- /.card -->
		</div>
	</div>