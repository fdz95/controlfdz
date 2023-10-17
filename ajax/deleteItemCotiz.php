<?php
	if (!empty($_GET['delete_id_cotiz'])){
		require_once ("conexion.php");
		$delete_id_cotiz = mysqli_real_escape_string($conexion,(strip_tags($_GET["delete_id_cotiz"],ENT_QUOTES)));
		$delete_item_cotiz = mysqli_real_escape_string($conexion,(strip_tags($_GET["delete_item_cotiz"],ENT_QUOTES)));
		$query_delete_item_cotiz = "DELETE FROM t_cotiz_detalle WHERE id_cotiz = '$delete_id_cotiz' AND producto = '$delete_item_cotiz';";
		$result_delete_item_cotiz = mysqli_query($conexion,$query_delete_item_cotiz);
		if (!$result_delete_item_cotiz) {
			$errors[] = "No se pudo borrar. Por favor, vuelva a intentarlo. result_delete_item_cotiz: </br>";
			$errors[] = mysqli_error($conexion);
		}
	}else{
		$errors[] = "ERROR delete_id_cotiz";
	}
	
	if (isset($errors)){
		foreach ($errors as $error) {
			echo $error;
		}
	}
?>