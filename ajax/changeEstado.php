<?php
	$newEstado = null;
	if (empty($_POST['id_trabajo_estado'])){
		$errors[] = "ERROR id_trabajo_estado";
	} else if (!empty($_POST['id_trabajo_estado'])){
		require_once ("conexion.php");
		$id_trabajo_estado = mysqli_real_escape_string($conexion,(strip_tags($_POST["id_trabajo_estado"],ENT_QUOTES)));
		$cambiar_estado = mysqli_real_escape_string($conexion,(strip_tags($_POST["cambiar_estado"],ENT_QUOTES)));
		
		if(empty($cambiar_estado)){
			$errors[] = "Debe seleccionar un estado";
		}else{
			switch($cambiar_estado){
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
			
			$query_update_estado = "UPDATE t_trabajos SET estado = '$newEstado' WHERE Id = '$id_trabajo_estado';";
			$result_update_estado = mysqli_query($conexion,$query_update_estado);
			if ($result_update_estado) {
				$messages[] = "Estado cambiado";
			}else{
				$errors[] = "No se pudo cambiar el estado. Por favor, vuelva a intentarlo. result_update_estado</br>". mysqli_error($conexion);
			}
		}
	}else{
		$errors[] = "ERROR id_trabajo_estado";
	}

	if (isset($errors)){
		?>
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Error!</strong> 
				<?php
					foreach ($errors as $error) {
							echo $error;
					}
				?>
		</div>
		<?php
	}
	if (isset($messages)){
		?>
		<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php
				foreach ($messages as $message) {
					echo $message;
				}
			?>
		</div>
	<?php
	}
?>	