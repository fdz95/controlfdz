<?php
	$newEstado = null;
	if (empty($_POST['id_trabajo_estado'])) {
		$error = "ERROR id_trabajo_estado";
	} else if (!empty($_POST['id_trabajo_estado'])) {
		require_once("conexion_2.php");
		$id_trabajo_estado = $_POST["id_trabajo_estado"];
		$cambiar_estado = $_POST["cambiar_estado"];

		if (empty($cambiar_estado)) {
			$error = "Debe seleccionar un estado";
		} else {
			switch ($cambiar_estado) {
				case 'EN_REP':
					$newEstado = ""; // En reparacion
					break;
				case 'ESP_REP':
					$newEstado = "B"; // Esperando repuesto
					break;
				case 'NO_REP':
					$newEstado = "C"; // No se puede reparar
					break;
				case 'ESP_PAGO':
					$newEstado = "D"; // Esperando pago
					break;
				default:
					$newEstado = "";
					break;
			}

			$query_update_estado = "UPDATE t_trabajos SET estado = :newEstado WHERE Id = :id_trabajo_estado";
			$stmt_update_estado = $pdo->prepare($query_update_estado);
			$stmt_update_estado->bindParam(':newEstado', $newEstado);
			$stmt_update_estado->bindParam(':id_trabajo_estado', $id_trabajo_estado);
			$stmt_update_estado->execute();

			if ($stmt_update_estado) {
				echo "Estado cambiado";
			} else {
				$error = "No se pudo cambiar el estado. Por favor, vuelva a intentarlo. result_update_estado: " . mysqli_error($conexion);
			}
		}
	} else {
		$error = "ERROR id_trabajo_estado";
	}

	if (isset($error)) {
		echo "<font color='red' class='error'>". $error ."</font>";
	}
?>