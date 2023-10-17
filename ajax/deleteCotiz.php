<?php
	if (!empty($_POST['id_delete_cotiz'])){
		require_once ("conexion.php");
		$id_delete_cotiz = mysqli_real_escape_string($conexion,(strip_tags($_POST["id_delete_cotiz"],ENT_QUOTES)));
		
		$query_delete_cotiz = "DELETE FROM t_cotiz WHERE Id = '$id_delete_cotiz';";
		$result_delete_cotiz = mysqli_query($conexion,$query_delete_cotiz);
		if ($result_delete_cotiz) {
			$query_delete_item_cotiz = "DELETE FROM t_cotiz_detalle WHERE Id = '$id_delete_cotiz';";
			$result_delete_item_cotiz = mysqli_query($conexion,$query_delete_item_cotiz);
			if ($result_delete_item_cotiz) {
				$messages[] = "Cotizaci&oacute;n borrada";
			}else{
				$errors[] = "No se pudo borrar. Por favor, vuelva a intentarlo. result_delete_item_cotiz: </br>";
				$errors[] = mysqli_error($conexion);
			}
		}else{
			$errors[] = "No se pudo borrar. Por favor, vuelva a intentarlo. result_delete_cotiz: </br>";
			$errors[] = mysqli_error($conexion);
		}		
	}else{
		$errors[] = "ERROR id_delete_cotiz";
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