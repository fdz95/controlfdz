<?php
	try {
		// Include the database connection file
		require_once("conexion_2.php");
		
		// Main query to fetch the data
		$getID = 1; // The value for the Id
		$query_select_account = "SELECT * FROM t_account WHERE Id = ?";
		
		// Prepare and execute the query
		$stmt = $pdo->prepare($query_select_account);
		$stmt->execute([$id]);

		// Fetch the data
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row) {
			// Retrieve values from the associative array
			$getUser = $row['user'];
			$getPassword = $row['password'];
			$getNombre = $row['nombre'];
			$getApellido = $row['apellido'];
			$getEmail = $row['email'];
			
			$getFechaUlt = $row['fecha_ult_ingreso'];
			$fecha_format = date_format(date_create($getFechaUlt), 'd/m/Y');
			
			$getHoraUlt = $row['hora_ult_ingreso'];
			$hora_format = date_format(date_create($getHoraUlt), 'H:m');
			
			$getFechaAlta = $row['fecha_alta'];
			$fecha_alta_format = date_format(date_create($getFechaAlta), 'd/m/Y');
			?>
			
			</br>
			<div style="float:left;width:50%" class="container">
				<form name="form_edit_account" id="form_edit_account">
					<div class="row">
						<div class="col">
							<label>Usuario</label>
							<input type="text" name="user" id="user" value="<?php echo $getUser; ?>" placeholder="Ingrese su ususario..." disabled class="form-control" />
							<input type="hidden" name="account_id" id="account_id" value="<?php echo $getID; ?>" disabled />
						</div>
						<div class="col">
							<label>Contrase&ntilde;a</label>
							<input type="password" name="password" id="password" value="<?php echo $getPassword; ?>" placeholder="Ingrese su contrase&ntilde;a..." class="form-control" />
						</div>
					</div>
					</br>
					<div class="row">
						<div class="col">
							<label>Nombre</label>
							<input type="text" name="account_name" id="account_name" value="<?php echo $getNombre; ?>" placeholder="Ingrese su nombre..." class="form-control" />
						</div>
						<div class="col">
							<label>Apellido</label>
							<input type="text" name="account_lastname" id="account_lastname" value="<?php echo $getApellido; ?>" placeholder="Ingrese su apellido..." class="form-control" />
						</div>
					</div>
					</br>
					<div class="row">
						<div class="col-6">
							<label>Email</label>
							<input type="email" name="account_email" id="account_email" value="<?php echo $getEmail; ?>" placeholder="Ingrese su email..." class="form-control" />
						</div>
						<div class="col-6">
							</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="submit" class="btn btn-success" value="Guardar">
							<label id="response_form_account"></label>
						</div>
					</div>
				</form>
				</br>
				<div class="row">
					<div class="col">
						<label>Fecha ult. ingreso:</label> <?php echo $fecha_format ." ". $hora_format; ?></br>
						<label>Fecha alta:</label> <?php echo $fecha_alta_format; ?>
					</div>
				</div>
			</div>
<?php
		} else {
			echo "No se encontró ninguna cuenta. Contáctese con el administrador";
		}
	} catch (PDOException $e) {
		echo "Error query_select_account: " . $e->getMessage();
	}
?>