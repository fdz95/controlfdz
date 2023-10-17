<?php
	if (empty($_POST['add_user'])) {
		$error = "Debe ingresar el usuario";
	} else {
		require_once("conexion_2.php"); // Contiene función que conecta a la base de datos

		$add_user = $_POST["add_user"];
		$add_user_password = $_POST["add_user_password"];
		$add_user_name = $_POST["add_user_name"];
		$add_user_lastname = $_POST["add_user_lastname"];
		$add_user_email = $_POST["add_user_email"];
		$fecha_add = date('Y-m-d');
		
		if (empty($add_user)) {
			$error = "Debe ingresar el usuario";
		} elseif (strlen($add_user) < 5) {
			$error = "El usuario debe tener al menos 5 caracteres";
		} elseif (empty($add_user_password)) {
			$error = "Debe ingresar la contraseña";
		} elseif (strlen($add_user_password) < 5) {
			$error = "La contraseña debe tener al menos 5 caracteres";
		} elseif (empty($add_user_name)) {
			$error = "Debe ingresar el nombre";
		} elseif (empty($add_user_lastname)) {
			$error = "Debe ingresar el apellido";
		} else {
			$query_search_user = "SELECT * FROM t_users WHERE estado = 'A' AND user = :add_user";
			$stmt_search_user = $conexion->prepare($query_search_user);
			$stmt_search_user->bindParam(':add_user', $add_user);
			$stmt_search_user->execute();
			$result_search_user = $stmt_search_user->fetchAll(PDO::FETCH_ASSOC);

			if (count($result_search_user) > 0) {
				$error = "El usuario <b>$add_user</b> ya está agregado";
			} else {
				$options = ['cost' => 11];
				$hashedPassword = password_hash($add_user_password, PASSWORD_BCRYPT, $options);

				$query_insert_user = "INSERT INTO t_users(estado, user, password, nombre, apellido, email, fecha_alta)
				VALUES('A', :add_user, :hashedPassword, :add_user_name, :add_user_lastname, :add_user_email, :fecha_add)";
				$stmt_insert_user = $conexion->prepare($query_insert_user);
				$stmt_insert_user->bindParam(':add_user', $add_user);
				$stmt_insert_user->bindParam(':hashedPassword', $hashedPassword);
				$stmt_insert_user->bindParam(':add_user_name', $add_user_name);
				$stmt_insert_user->bindParam(':add_user_lastname', $add_user_lastname);
				$stmt_insert_user->bindParam(':add_user_email', $add_user_email);
				$stmt_insert_user->bindParam(':fecha_add', $fecha_add);

				if ($stmt_insert_user->execute()) {
					echo "Usuario agregado";
				} else {
					$error = "No se pudo agregar. Por favor, vuelva a intentarlo. " . $stmt_insert_user->errorInfo()[2];
				}
			}
		}
	}

	if (isset($error)) {
		echo "<font color='red' class='error'>" . $error . "</font>";
	}
?>