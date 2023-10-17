<?php
	if (!empty($_POST['id_delete_user'])){
		require_once ("conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$id_delete_user = intval($_POST['id_delete_user']);
		$fecha_delete = date('Y-m-d');
		$hora_delete = date('H:i');
		
		// DELETE FROM database
		$query_delete_user = "UPDATE t_users SET estado = 'B' WHERE Id = '$id_delete_user';";
		$result_delete_user = mysqli_query($conexion,$query_delete_user);
		if ($result_delete_user) {
			$messages[] = "Borrado con &eacute;xito.";
		}else{
			$errors[] = "No se pudo borrar. Por favor, vuelva a intentarlo. result_delete_user</br>";
			$errors[] = mysqli_error($conexion);
		}
	}else{
		$errors[] = "ERROR id_delete_user";
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