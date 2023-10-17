<?php
	require_once("conexion_2.php");

	// Preparar la consulta
	$query_select_clientes = "SELECT * FROM t_clientes WHERE estado = 'A';";
	$stmt = $pdo->prepare($query_select_clientes);

	// Ejecutar la consulta
	$stmt->execute();

	// Obtener los resultados
	$result_select_clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Verificar si hay resultados
	if (count($result_select_clientes) > 0) {
		?>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class='text-center'>ID</th>
					<th class='text-center'>Nombre</th>
					<th class='text-center'>Apellido</th>
					<th class='text-center'>Celular</th>
					<th class='text-center'>Email</th>
					<th class='text-center'>Opciones</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($result_select_clientes as $row) {
				$getID = $row['Id'];
				$getNombre = $row['nombre'];
				$getApellido = $row['apellido'];
				$getCelular = $row['celular'];
				$getEmail = $row['email'];
				?>
				<tr>
					<td class='text-center'><?php echo $getID; ?></td>
					<td class='text-center'><?php echo $getNombre; ?></td>
					<td class='text-center'><?php echo $getApellido; ?></td>
					<td class='text-center'><?php echo "<a href='https://api.whatsapp.com/send?phone=" . $getCelular . "' target='_blank'> +" . $getCelular; ?></a></td>
					<td class='text-center'><?php echo $getEmail; ?></td>
					<td align="center" width="15%"><?php
						echo "<a href='#' data-target='#editClienteModal' class='info' data-toggle='modal' data-id='$getID' data-nombre='$getNombre' data-apellido='$getApellido' data-celular='$getCelular' data-email='$getEmail'><font color='blue'><i class='fas fa-edit'></i></a>&nbsp;&nbsp;&nbsp;";
						echo "<a href='#' data-target='#deleteClienteModal' class='info' data-toggle='modal' data-id='$getID' data-nombre='$getNombre'><font color='red'><i class='fas fa-trash'></i></a>";
						?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	<?php
	} else {
		echo "No hay clientes agregados";
	}
?>