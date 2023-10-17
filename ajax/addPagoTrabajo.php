<?php
	$saldo_nuevo = 0;
	$query_update_payment = null;

	if (empty($_POST['pago_trabajo'])) {
		$error = "Debe ingresar el importe";
	} else if (!empty($_POST['pago_trabajo'])) {
		require "conexion_2.php";
		$id_trabajo = $_POST["id_trabajo"];
		$pago_trabajo = $_POST["pago_trabajo"];
		$saldo_trabajo = $_POST["saldo_trabajo"];
		$cliente_trabajo = $_POST["cliente_trabajo"];
		$fecha_pago = $_POST["pago_trabajo_fecha"];
		$fecha_add = date('Y-m-d');
		$hora_add = date('H:i');
		
		if ($pago_trabajo <= 0) {
			$error = "Debe ingresar el importe";
		} else {
			try{
				$query_insert_payment = "INSERT INTO t_pagos(id_trabajo, cliente, pago_importe, fecha_pago, fecha_agregado, hora_agregado)
				VALUES(:id_trabajo, :cliente_trabajo, :pago_trabajo, :fecha_pago, :fecha_add, :hora_add)";
				$stmt_insert_payment = $pdo->prepare($query_insert_payment);
				$stmt_insert_payment->bindParam(':id_trabajo', $id_trabajo);
				$stmt_insert_payment->bindParam(':cliente_trabajo', $cliente_trabajo);
				$stmt_insert_payment->bindParam(':pago_trabajo', $pago_trabajo);
				$stmt_insert_payment->bindParam(':fecha_pago', $fecha_pago);
				$stmt_insert_payment->bindParam(':fecha_add', $fecha_add);
				$stmt_insert_payment->bindParam(':hora_add', $hora_add);
				$result_insert_payment = $stmt_insert_payment->execute();

				if ($result_insert_payment) {
					$saldo_nuevo = $saldo_trabajo - $pago_trabajo;

					if ($saldo_nuevo == 0) {
						$query_update_payment = "UPDATE t_trabajos SET estado = 'A', saldo = '0' WHERE Id = :id_trabajo";
						$stmt_update_payment = $pdo->prepare($query_update_payment);
					} else {
						$query_update_payment = "UPDATE t_trabajos SET saldo = :saldo_nuevo WHERE Id = :id_trabajo";
						$stmt_update_payment = $pdo->prepare($query_update_payment);
						$stmt_update_payment->bindParam(':saldo_nuevo', $saldo_nuevo);
					}

					//try{
						$stmt_update_payment->bindParam(':id_trabajo', $id_trabajo);
						$result_update_payment = $stmt_update_payment->execute();

						if ($result_update_payment) {
							echo "Pago agregado";
						} else {
							$error = "No se pudo agregar. Por favor, vuelva a intentarlo. result_update_payment<br>". $stmt_update_payment->errorInfo();
						}
					/*}catch(PDOException $e){
						$error = "No se pudo conectar a la base de datos. ". $e->getMessage();
					}*/
				} else {
					$error = "No se pudo agregar. Por favor, vuelva a intentarlo. result_insert_payment<br>". $stmt_insert_payment->errorInfo();
				}
			}catch(PDOException $e){
				$error = "No se pudo conectar a la base de datos. ". $e->getMessage();
			}
		}
	} else {
		$error = "Debe ingresar el importe";
	}
	
    if (isset($error)){
        echo "<font color='red' class='error'>" . $error ."</font>";
    }
?>