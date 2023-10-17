<?php
	if (empty($_POST['add_trabajo_id_cliente'])) {
		$error = "Debe ingresar el cliente";
	} else if (!empty($_POST['add_trabajo_id_cliente'])) {
		$add_trabajo_id_cliente = $_POST["add_trabajo_id_cliente"];
		$add_trabajo_equipo = strtoupper($_POST["add_trabajo_equipo"]);
		$add_trabajo_select = $_POST["add_trabajo_select"];
		$add_trabajo_importe = $_POST["add_trabajo_importe"];
		$add_trabajo_costo = $_POST["add_trabajo_costo"];
		$add_trabajo_notas = strtoupper($_POST["add_trabajo_notas"]);
		$add_trabajo_fecha = $_POST["add_trabajo_fecha"];
		$fecha_add = date('Y-m-d');
		$hora_add = date('H:i');
		
		if (empty($add_trabajo_select)) {
			$error = "Debe ingresar el trabajo";
		}else if (empty($add_trabajo_equipo)) {
			$error = "Debe ingresar el nombre del equipo";
		} else if ($add_trabajo_costo < 0) {
			$error = "Debe ingresar el costo";
		} else if ($add_trabajo_importe < 0) {
			$error = "Debe ingresar el importe";
		} else {
			try{
				require_once("conexion_2.php");
				$query_insert = "INSERT INTO t_trabajos(estado, cliente, equipo, trabajo, observ, costo, importe, saldo, fecha_trabajo, fecha, hora)
				VALUES('', :add_trabajo_id_cliente, :add_trabajo_equipo, :add_trabajo_select, :add_trabajo_notas, :add_trabajo_costo, :add_trabajo_importe, :add_trabajo_saldo, :add_trabajo_fecha, :fecha_add, :hora_add)";
				$stmt_insert = $pdo->prepare($query_insert);
				$stmt_insert->bindParam(':add_trabajo_id_cliente', $add_trabajo_id_cliente);
				$stmt_insert->bindParam(':add_trabajo_equipo', $add_trabajo_equipo);
				$stmt_insert->bindParam(':add_trabajo_select', $add_trabajo_select);
				$stmt_insert->bindParam(':add_trabajo_notas', $add_trabajo_notas);
				$stmt_insert->bindParam(':add_trabajo_costo', $add_trabajo_costo);
				$stmt_insert->bindParam(':add_trabajo_importe', $add_trabajo_importe);
				$stmt_insert->bindParam(':add_trabajo_saldo', $add_trabajo_importe);
				$stmt_insert->bindParam(':add_trabajo_fecha', $add_trabajo_fecha);
				$stmt_insert->bindParam(':fecha_add', $fecha_add);
				$stmt_insert->bindParam(':hora_add', $hora_add);
				$result_query_insert = $stmt_insert->execute();
				
				if ($result_query_insert) {
					echo "Trabajo agregado";
				} else {
					$error = "No se pudo agregar. Por favor, vuelva a intentarlo. result_query_insert</br>". $stmt_insert->errorInfo();
				}
			}catch(PDOException $e){
				$error = "No se pudo agregar. ". $e->getMessage();
			}
		}
	} else {
		$error = "Debe ingresar el cliente";
	}

	if (isset($error)) {
		echo "<font color='red' class='error'><b>" . $error . "</b></font>";
	}
?>