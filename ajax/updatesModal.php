<?php
	require_once ("conexion.php");
	$query_update_modal = "UPDATE t_config SET estado_update = '0' WHERE Id = 1;";
	$result_update_modal = mysqli_query($conexion,$query_update_modal);
	if(!$result_update_modal){
		$errors = "Por favor, vuelva a intentarlo. result_update_modal</br>". mysqli_error($conexion);
		echo $errors;
	}
?>	