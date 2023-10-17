<?php
	if (empty($_POST['account_id'])) {
		$error = "Debe ingresar el usuario";
	} else if (!empty($_POST['account_id'])) {
		require_once("conexion_2.php");
		$account_id = $_POST["account_id"];
		$account = $_POST["account"];
		$password = $_POST["password"];
		$account_name = $_POST["account_name"];
		$account_lastname = $_POST["account_lastname"];
		$account_email = $_POST["account_email"];

		if (empty($password)) {
			$error = "Debe ingresar la contraseña";
		} else if (strlen($password) < 5) {
			$error = "La contraseña debe tener al menos 5 caracteres";
		} else if (empty($account_name)) {
			$error = "Debe ingresar el nombre";
		} else if (empty($account_lastname)) {
			$error = "Debe ingresar el apellido";
		} else {
			$options = ['cost' => 11];
			$hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
			
			$query_update_account = "UPDATE t_account SET password = :hashedPassword, nombre = :account_name, apellido = :account_lastname, email = :account_email WHERE Id = :account_id";
			$stmt_update_account = $pdo->prepare($query_update_account);
			$stmt_update_account->bindParam(':hashedPassword', $hashedPassword);
			$stmt_update_account->bindParam(':account_name', $account_name);
			$stmt_update_account->bindParam(':account_lastname', $account_lastname);
			$stmt_update_account->bindParam(':account_email', $account_email);
			$stmt_update_account->bindParam(':account_id', $account_id);

			if ($stmt_update_account->execute()) {
				echo "Datos guardados";
			} else {
				$error = "No se pudo editar. Por favor, vuelva a intentarlo. result_update_account</br>" . $stmt_update_account->errorInfo();
			}
		}
	} else {
		$error = "Debe ingresar el usuario";
	}
	
	if (isset($error)) {
		echo "<font color='red' class='error'>" . $error . "</font>";
	}
?>