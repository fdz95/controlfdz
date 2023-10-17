<?php
	if (empty($_POST['id_edit_trabajo'])) {
		$error = "ERROR id_edit_trabajo";
	} else if (!empty($_POST['id_edit_trabajo'])) {
		$id_edit_trabajo = $_POST["id_edit_trabajo"];
		$edit_trabajo_equipo = strtoupper($_POST["edit_trabajo_equipo"]);
		$edit_trabajo_costo = $_POST["edit_trabajo_costo"];
		$edit_trabajo_importe = $_POST["edit_trabajo_importe"];
		$edit_trabajo_saldo = $_POST["edit_trabajo_importe"];
		$edit_trabajo_notas = strtoupper($_POST["edit_trabajo_notas"]);
		$edit_trabajo_fecha = $_POST["edit_trabajo_fecha"];
		$fecha_edit = date('Y-m-d');
		$hora_edit = date('H:i');

		if (empty($edit_trabajo_equipo)) {
			$error = "Debe ingresar el nombre del equipo";
		} else {
			try{
				require_once("conexion_2.php");
				$query_update_trabajo = "UPDATE t_trabajos SET equipo = :edit_trabajo_equipo, observ = :edit_trabajo_notas, fecha_trabajo = :edit_trabajo_fecha, costo = :edit_trabajo_costo, importe = :edit_trabajo_importe, saldo = :edit_trabajo_saldo, fecha = :fecha_edit, hora = :hora_edit WHERE Id = :id_edit_trabajo";
				$stmt_update_trabajo = $pdo->prepare($query_update_trabajo);
				$stmt_update_trabajo->bindParam(':edit_trabajo_equipo', $edit_trabajo_equipo);
				$stmt_update_trabajo->bindParam(':edit_trabajo_notas', $edit_trabajo_notas);
				$stmt_update_trabajo->bindParam(':edit_trabajo_fecha', $edit_trabajo_fecha);
				$stmt_update_trabajo->bindParam(':edit_trabajo_costo', $edit_trabajo_costo);
				$stmt_update_trabajo->bindParam(':edit_trabajo_importe', $edit_trabajo_importe);
				$stmt_update_trabajo->bindParam(':edit_trabajo_saldo', $edit_trabajo_saldo);
				$stmt_update_trabajo->bindParam(':fecha_edit', $fecha_edit);
				$stmt_update_trabajo->bindParam(':hora_edit', $hora_edit);
				$stmt_update_trabajo->bindParam(':id_edit_trabajo', $id_edit_trabajo);
				$result_update_trabajo = $stmt_update_trabajo->execute();
				
				if ($result_update_trabajo) {
					echo "Trabajo editado";
				} else {
					$error = "No se pudo editar. Por favor, vuelva a intentarlo. result_update_trabajo<br>" . $stmt_update_trabajo->errorInfo();
				}
			}catch(PDOException $e){
				$error = "No se pudo editar. ". $e->getMessage();
			}
		}
	} else {
		$error = "ERROR id_edit_trabajo";
	}

	if (isset($error)) {
		echo "<font color='red' class='error'>" . $error . "</font>";
	}
?>