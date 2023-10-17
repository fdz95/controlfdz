<?php
	if (!empty($_POST['id_delete_trabajo'])) {
		try{
			require_once("conexion_2.php");
			$id_delete_trabajo = $_POST["id_delete_trabajo"];
			$query_delete_trabajo = "DELETE FROM t_trabajos WHERE Id = :id_delete_trabajo";
			$stmt_delete_trabajo = $pdo->prepare($query_delete_trabajo);
			$stmt_delete_trabajo->bindParam(':id_delete_trabajo', $id_delete_trabajo);
			$stmt_delete_trabajo->execute();
			echo "Trabajo borrado";
		}catch(PDOException $e){
			$error = "No se pudo borrar. ". $e->getMessage();
		}
	} else {
		$errors[] = "ERROR id_delete_trabajo";
	}

	if (isset($errors)) {
		foreach ($errors as $error) {
			echo "<font color='red' class='error'>" . $error . "</font>";
		}
	}
?>