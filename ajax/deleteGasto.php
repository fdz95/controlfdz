<?php
	if (!empty($_POST['id_delete_gasto'])){
		require_once ("conexion.php");
		$id_delete_gasto = mysqli_real_escape_string($conexion,(strip_tags($_POST["id_delete_gasto"],ENT_QUOTES)));
		
		$query_delete_gasto = "DELETE FROM t_gastos WHERE Id = '$id_delete_gasto';";
		$result_delete_gasto = mysqli_query($conexion,$query_delete_gasto);
		if ($result_delete_gasto) {
			$messages[] = "Gasto borrado";
		}else{
			$errors[] = "No se pudo borrar. Por favor, vuelva a intentarlo. result_delete_gasto: </br>";
			$errors[] = mysqli_error($conexion);
		}		
	}else{
		$errors[] = "ERROR id_delete_gasto";
	}
	
	if (isset($errors)){
		foreach ($errors as $error) {
			echo "<font color='red'><b>Error: ". $error ."</b></font>";
		}
	}
	if (isset($messages)){
		foreach ($messages as $message) {
			echo $message;
		}
	}
?>